<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Repositories\ResultRepository;
use App\Repositories\CategoryCompetencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Result;
use App\Models\CategoryCompetency;
use App\Models\CategoryJob;
use App\Models\jobfitBasic;
use App\Models\Session;
use PDF;
use DataTables;

class ResultController extends AppBaseController
{
    /** @var  ResultRepository */
    private $resultRepository;

    public function __construct(ResultRepository $resultRepo, CategoryCompetencyRepository $categoryCompetencyRepo)
    {
        $this->resultRepository       = $resultRepo;
        $this->categoryCompetencyRepo = $categoryCompetencyRepo;
    }

    /**
     * Display a listing of the Result.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->resultRepository->pushCriteria(new RequestCriteria($request));
        $results    = Result::userAssessment();
        $user       = Session::user();

        return view('results.index')->with(['user' => $user, 'results' => $results]);
    }

    /**
     * Show the form for creating a new Result.
     *
     * @return Response
     */
    public function create()
    {
        $position = $this->positionRepo->all();
        return view('results.create')->with('position', $position);
    }

    /**
     * Store a newly created Result in storage.
     *
     * @param CreateResultRequest $request
     *
     * @return Response
     */
    public function store(CreateResultRequest $request)
    {
        $input = $request->all();

        $result = $this->resultRepository->create($input);

        Flash::success('Result saved successfully.');

        return redirect(route('results.index'));
    }

    /**
     * Display the specified Result.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        // $result = $this->resultRepository->findWithoutFail($id);
        $nik                = strstr($id, '_', true);
        $date               = substr($id, strpos($id, "_") + 1);
        $result             = Result::getNikResult($nik, $date);
        $position           = $result->position_id;
        $user               = Session::user();

        if (empty($result)) {
            Flash::error('Result not found');

            return redirect(route('results.index'));
        }

        $categoryCompetency = CategoryCompetency::categoryByPosition($position);
        $assess_report      = Result::assessReport($result->result_disc);

        // DISC 
        $D_most             = Result::hitungDISC('D', 'M', $nik, $result->last_test)->total;
        $D_least            = Result::hitungDISC('D', 'L', $nik, $result->last_test)->total;
        $I_most             = Result::hitungDISC('I', 'M', $nik, $result->last_test)->total;
        $I_least            = Result::hitungDISC('I', 'L', $nik, $result->last_test)->total;
        $S_most             = Result::hitungDISC('S', 'M', $nik, $result->last_test)->total;
        $S_least            = Result::hitungDISC('S', 'L', $nik, $result->last_test)->total;
        $C_most             = Result::hitungDISC('C', 'M', $nik, $result->last_test)->total;
        $C_least            = Result::hitungDISC('C', 'L', $nik, $result->last_test)->total;
        $st_least           = Result::hitungDISC('star', 'L', $nik, $result->last_test)->total;
        $st_most            = Result::hitungDISC('star', 'M', $nik, $result->last_test)->total;

        // INDIVIDUAL DISC PATTERN
        $disc_pattern_D     = Result::indvDiscPattern($D_least)->quartil;
        $disc_pattern_I     = Result::indvDiscPattern($I_least)->quartil;
        $disc_pattern_S     = Result::indvDiscPattern($S_least)->quartil;
        $disc_pattern_C     = Result::indvDiscPattern($C_least)->quartil;
        $total_score        = array();
        $data               = array();
        $result_fit         = 0;
        $jml_competency     = 0;

        // echo 'D '.$D_least.' = '.$disc_pattern_D.'<br>';
        // echo 'I '.$I_least.' = '.$disc_pattern_I.'<br>';
        // echo 'S '.$S_least.' = '.$disc_pattern_S.'<br>';
        // echo 'C '.$C_least.' = '.$disc_pattern_C.'<br><br>';

        // VS 
        foreach(CategoryJob::categoryCompetencyByPosition($position) as $catjob) {
            //echo $pattern->category_competencies_id.'<br>';
            $total_score        = 0;
            $jml_jobfit_basic   = 0;
            $jml_competency++;

            //echo $catjob->category_name.'<br>';

            foreach(jobfitBasic::jobfitBasicByPosCat($position, $catjob->category_competencies_id) as $poscat){
                if($poscat->jobfit_id == 'D'){
                    $vs_pattern = $disc_pattern_D.','.$poscat->pattern;
                }

                else if($poscat->jobfit_id == 'I') {
                    $vs_pattern = $disc_pattern_I.','.$poscat->pattern;
                }

                else if($poscat->jobfit_id == 'S') {
                    $vs_pattern = $disc_pattern_S.','.$poscat->pattern;
                }

                else if($poscat->jobfit_id == 'C') {
                    $vs_pattern = $disc_pattern_C.','.$poscat->pattern;
                }

                $total_score  += Result::getQuadranScore($vs_pattern)->score;

                $patt[] = array('category_competencies_id' => $poscat->category_competencies_id,
                                'poscat' => $poscat->pattern,
                                'vs_pattern' => $vs_pattern,
                                'quadran_score' => Result::getQuadranScore($vs_pattern)->score,
                                'skor' => array('D'=>$D_least, 'I'=>$I_least, 'S'=>$S_least, 'C'=>$C_least),
                                'pattern' => array($disc_pattern_D, $disc_pattern_I, $disc_pattern_S, $disc_pattern_C));

                //echo $vs_pattern.' = '.Result::getQuadranScore($vs_pattern)->score.'<br>';
                $jml_jobfit_basic++;
            }

            $rata       = round($total_score/$jml_jobfit_basic);
            $norma      = empty(Result::getFitScore($rata)->norma) ? '0' : Result::getFitScore($rata)->norma;
            $data[]     = array('competency' => $catjob->category_name,'fit' => $norma);
            $result_fit += $norma;
            // echo 'Total Skor = '.$total_score.'<br>';
            // echo 'Rata-rata = '.round($rata).'<br>';
            // echo 'Fit = '.$norma.'%';
            // echo '<br><br>';

        }

        //echo 'Result = '.$result_fit/$jml_competency.'%';

        // return array('MOST' => $D_most+$I_most+$S_most+$C_most+$st_most, 'LEAST' => $D_least+$I_least+$S_least+$C_least+$st_least);

        // return json_encode($data);
        return view('results.show')->with(['result'         => $result,
                                           'data'           => $data,
                                           'assess_report'  => $assess_report,
                                           'user'           => $user]);

        // return array('D LEAST' => $D_least,
        //              'I LEAST' => $I_least,
        //              'S LEAST' => $S_least,
        //              'C LEAST' => $C_least);
        
    }

    /**
     * Show the form for editing the specified Result.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $result = $this->resultRepository->findWithoutFail($id);

        if (empty($result)) {
            Flash::error('Result not found');

            return redirect(route('results.index'));
        }

        return view('results.edit')->with('result', $result);
    }

    /**
     * Update the specified Result in storage.
     *
     * @param  int              $id
     * @param UpdateResultRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResultRequest $request)
    {
        $result = $this->resultRepository->findWithoutFail($id);

        if (empty($result)) {
            Flash::error('Result not found');

            return redirect(route('results.index'));
        }

        $result = $this->resultRepository->update($request->all(), $id);

        Flash::success('Result updated successfully.');

        return redirect(route('results.index'));
    }

    /**
     * Remove the specified Result from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $result = $this->resultRepository->findWithoutFail($id);

        if (empty($result)) {
            Flash::error('Result not found');

            return redirect(route('results.index'));
        }

        $this->resultRepository->delete($id);

        Flash::success('Result deleted successfully.');

        return redirect(route('results.index'));
    }

    public function extractPDF($id)
    {
        $nik                = strstr($id, '_', true);
        $date               = substr($id, strpos($id, "_") + 1);
        $result             = Result::getNikResult($nik, $date);
        $position           = $result->position_id;
        $user               = Session::user();

        if (empty($result)) {
            Flash::error('Result not found');

            return redirect(route('results.index'));
        }

        $categoryCompetency = CategoryCompetency::categoryByPosition($position);
        $assess_report      = Result::assessReport($result->result_disc);

        // DISC 
        $D_most             = Result::hitungDISC('D', 'M', $nik, $result->last_test)->total;
        $D_least            = Result::hitungDISC('D', 'L', $nik, $result->last_test)->total;
        $I_most             = Result::hitungDISC('I', 'M', $nik, $result->last_test)->total;
        $I_least            = Result::hitungDISC('I', 'L', $nik, $result->last_test)->total;
        $S_most             = Result::hitungDISC('S', 'M', $nik, $result->last_test)->total;
        $S_least            = Result::hitungDISC('S', 'L', $nik, $result->last_test)->total;
        $C_most             = Result::hitungDISC('C', 'M', $nik, $result->last_test)->total;
        $C_least            = Result::hitungDISC('C', 'L', $nik, $result->last_test)->total;
        $st_least           = Result::hitungDISC('star', 'L', $nik, $result->last_test)->total;
        $st_most            = Result::hitungDISC('star', 'M', $nik, $result->last_test)->total;

        // INDIVIDUAL DISC PATTERN
        $disc_pattern_D     = Result::indvDiscPattern($D_least)->quartil;
        $disc_pattern_I     = Result::indvDiscPattern($I_least)->quartil;
        $disc_pattern_S     = Result::indvDiscPattern($S_least)->quartil;
        $disc_pattern_C     = Result::indvDiscPattern($C_least)->quartil;
        $total_score        = array();
        $data               = array();
        $result_fit         = 0;
        $jml_competency     = 0;


        // VS 
        foreach(CategoryJob::categoryCompetencyByPosition($position) as $catjob) {
            $total_score        = 0;
            $jml_jobfit_basic   = 0;
            $jml_competency++;

            foreach(jobfitBasic::jobfitBasicByPosCat($position, $catjob->category_competencies_id) as $poscat){
                if($poscat->jobfit_id == 'D'){
                    $vs_pattern = $disc_pattern_D.','.$poscat->pattern;
                }

                else if($poscat->jobfit_id == 'I') {
                    $vs_pattern = $disc_pattern_I.','.$poscat->pattern;
                }

                else if($poscat->jobfit_id == 'S') {
                    $vs_pattern = $disc_pattern_S.','.$poscat->pattern;
                }

                else if($poscat->jobfit_id == 'C') {
                    $vs_pattern = $disc_pattern_C.','.$poscat->pattern;
                }

                $total_score  += Result::getQuadranScore($vs_pattern)->score;

                $patt[] = array('category_competencies_id' => $poscat->category_competencies_id,
                                'poscat' => $poscat->pattern,
                                'vs_pattern' => $vs_pattern,
                                'quadran_score' => Result::getQuadranScore($vs_pattern)->score,
                                'skor' => array('D'=>$D_least, 'I'=>$I_least, 'S'=>$S_least, 'C'=>$C_least),
                                'pattern' => array($disc_pattern_D, $disc_pattern_I, $disc_pattern_S, $disc_pattern_C));

                $jml_jobfit_basic++;
            }

            $rata       = round($total_score/$jml_jobfit_basic);
            $norma      = empty(Result::getFitScore($rata)->norma) ? '0' : Result::getFitScore($rata)->norma;
            $data[]     = array('competency' => $catjob->category_name,'fit' => $norma);
            $result_fit += $norma;

        }
        

        $datas = [
            'data'              => $data,
            'result'            => $result,
            'assess_report'     => $assess_report
        ];


        $pdf = PDF::loadView('results.extract-pdf', $datas);
        return $pdf->download('extract_'.strtotime(date('Y-m-d H:i:s')).'.pdf');
    }

    public function tes() {
        return session()->get('PHPSESSID');
    }

    public function datatable(){
        $results    = Result::AllUserAssessment();
        return \DataTables::of($results)->make(true);
    }
}
