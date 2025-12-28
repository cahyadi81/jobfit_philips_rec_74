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
use App\Models\JobfitBasic;
use App\Models\Session;
use App\Models\Analysis;
use PDF;
use Carbon\Carbon;

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
        if (!session('PHPSESSID')) {
            return redirect(config('jobfit.base_url'));
        }

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
        $nik                    = strstr($id, '_', true);
        $date                   = substr($id, strpos($id, "_") + 1);
        $result                 = Result::getNikResult($nik, $date);
        $position               = $result->position_id;
        $user                   = Session::user();
        $flag_agreement_score   = $result->flag_agreement_score;

        if (empty($result)) {
            Flash::error('Result not found');

            return redirect(route('results.index'));
        }

        $categoryCompetency = CategoryCompetency::categoryByPosition($position);
        $assess_report      = Result::assessReport($result->result_disc);

        // DISC
        // $D_most             = Result::hitungDISC('D', 'M', $nik, $result->last_test)->total;
        // $D_least            = Result::hitungDISC('D', 'L', $nik, $result->last_test)->total;
        // $I_most             = Result::hitungDISC('I', 'M', $nik, $result->last_test)->total;
        // $I_least            = Result::hitungDISC('I', 'L', $nik, $result->last_test)->total;
        // $S_most             = Result::hitungDISC('S', 'M', $nik, $result->last_test)->total;
        // $S_least            = Result::hitungDISC('S', 'L', $nik, $result->last_test)->total;
        // $C_most             = Result::hitungDISC('C', 'M', $nik, $result->last_test)->total;
        // $C_least            = Result::hitungDISC('C', 'L', $nik, $result->last_test)->total;
        // $st_least           = Result::hitungDISC('star', 'L', $nik, $result->last_test)->total;
        // $st_most            = Result::hitungDISC('star', 'M', $nik, $result->last_test)->total;

        $D_most             = count(Result::hitungDISC('D', 'M', $nik, $result->last_test));
        $D_least            = count(Result::hitungDISC('D', 'L', $nik, $result->last_test));
        $I_most             = count(Result::hitungDISC('I', 'M', $nik, $result->last_test));
        $I_least            = count(Result::hitungDISC('I', 'L', $nik, $result->last_test));
        $S_most             = count(Result::hitungDISC('S', 'M', $nik, $result->last_test));
        $S_least            = count(Result::hitungDISC('S', 'L', $nik, $result->last_test));
        $C_most             = count(Result::hitungDISC('C', 'M', $nik, $result->last_test));
        $C_least            = count(Result::hitungDISC('C', 'L', $nik, $result->last_test));
        $st_least           = count(Result::hitungDISC('star', 'L', $nik, $result->last_test));
        $st_most            = count(Result::hitungDISC('star', 'M', $nik, $result->last_test));


        // INDIVIDUAL DISC PATTERN
        $disc_pattern_D     = Result::indvDiscPattern($D_most - $D_least)->quartil;
        $disc_pattern_I     = Result::indvDiscPattern($I_most - $I_least)->quartil;
        $disc_pattern_S     = Result::indvDiscPattern($S_most - $S_least)->quartil;
        $disc_pattern_C     = Result::indvDiscPattern($C_most - $C_least)->quartil;
        $total_score        = array();
        $data               = array();
        $result_fit         = 0;
        $jml_competency     = 0;

        //        return array($disc_pattern_D, $disc_pattern_I, $disc_pattern_S, $disc_pattern_C);
        //
        //        return array('original most' => array('D' => $D_most, 'I' => $I_most, 'S' => $S_most, 'C' => $C_most),
        //                     'original least' => array('D' => $D_least, 'I' => $I_least, 'S' => $S_least, 'C' => $C_least),
        //                     'change' => array('D' => $D_most-$D_least, 'I' => $I_most-$I_least, 'S' => $S_most-$S_least, 'C' => $C_most-$C_least));

        // VS
        foreach (CategoryJob::categoryCompetencyByPosition($position) as $catjob) {

            $total_score        = 0;
            $jml_jobfit_basic   = 0;
            $jml_competency++;

            foreach (JobfitBasic::jobfitBasicByPosCat($position, $catjob->category_competencies_id) as $poscat) {
                if ($poscat->jobfit_id == 'D') {
                    $vs_pattern = $disc_pattern_D . ',' . $poscat->pattern;
                } else if ($poscat->jobfit_id == 'I') {
                    $vs_pattern = $disc_pattern_I . ',' . $poscat->pattern;
                } else if ($poscat->jobfit_id == 'S') {
                    $vs_pattern = $disc_pattern_S . ',' . $poscat->pattern;
                } else if ($poscat->jobfit_id == 'C') {
                    $vs_pattern = $disc_pattern_C . ',' . $poscat->pattern;
                }

                $total_score  += Result::getQuadranScore($vs_pattern)->score; //ambil quartil

                $patt[] = array(
                    'category_competencies_id' => $poscat->category_competencies_id,
                    'poscat' => $poscat->pattern,
                    'vs_pattern' => $vs_pattern,
                    'quadran_score' => Result::getQuadranScore($vs_pattern)->score,
                    'skor' => array('D' => $D_least, 'I' => $I_least, 'S' => $S_least, 'C' => $C_least),
                    'pattern' => array($disc_pattern_D, $disc_pattern_I, $disc_pattern_S, $disc_pattern_C)
                );

                $jml_jobfit_basic++;
            }

            //dd($patt);


            $rata       = round($total_score / $jml_jobfit_basic);

            $norma      = $this->getNorma($flag_agreement_score, $rata);

            $data[]     = array('competency' => $catjob->category_name, 'fit' => $norma, 'rata' => $rata, 'norma' => $norma);
            $result_fit += $norma;
        }


        /*
         * Count Result
         *
         */
        if (count(CategoryJob::categoryCompetencyByPosition($position)) == 0) {
            $hasil = '0';
        } else {
            $hasil = round($result_fit / count(CategoryJob::categoryCompetencyByPosition($position)));
        }

        $assessmentresult = Result::countResult($hasil);
        $quadranResult = Result::quadranResult();

        $result->last_test = Carbon::parse($result->last_test)->format('d F y');

        return view('results.show')->with([
            'result'         => $result,
            'data'           => $data,
            'assess_report'  => $assess_report,
            'user'           => $user,
            'assessmentresult' => $assessmentresult,
            'quadran_result' => $quadranResult
        ]);
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
        $flag_agreement_score   = $result->flag_agreement_score; # FLAG AGREEMENT SCORE

        if (empty($result)) {
            Flash::error('Result not found');
            return redirect(route('results.index'));
        }

        $categoryCompetency = CategoryCompetency::categoryByPosition($position);
        $assess_report      = Result::assessReport($result->result_disc);

        // DISC
        // $D_most             = Result::hitungDISC('D', 'M', $nik, $result->last_test)->total;
        // $D_least            = Result::hitungDISC('D', 'L', $nik, $result->last_test)->total;
        // $I_most             = Result::hitungDISC('I', 'M', $nik, $result->last_test)->total;
        // $I_least            = Result::hitungDISC('I', 'L', $nik, $result->last_test)->total;
        // $S_most             = Result::hitungDISC('S', 'M', $nik, $result->last_test)->total;
        // $S_least            = Result::hitungDISC('S', 'L', $nik, $result->last_test)->total;
        // $C_most             = Result::hitungDISC('C', 'M', $nik, $result->last_test)->total;
        // $C_least            = Result::hitungDISC('C', 'L', $nik, $result->last_test)->total;
        // $st_least           = Result::hitungDISC('star', 'L', $nik, $result->last_test)->total;
        // $st_most            = Result::hitungDISC('star', 'M', $nik, $result->last_test)->total;

        $D_most             = count(Result::hitungDISC('D', 'M', $nik, $result->last_test));
        $D_least            = count(Result::hitungDISC('D', 'L', $nik, $result->last_test));
        $I_most             = count(Result::hitungDISC('I', 'M', $nik, $result->last_test));
        $I_least            = count(Result::hitungDISC('I', 'L', $nik, $result->last_test));
        $S_most             = count(Result::hitungDISC('S', 'M', $nik, $result->last_test));
        $S_least            = count(Result::hitungDISC('S', 'L', $nik, $result->last_test));
        $C_most             = count(Result::hitungDISC('C', 'M', $nik, $result->last_test));
        $C_least            = count(Result::hitungDISC('C', 'L', $nik, $result->last_test));
        $st_least           = count(Result::hitungDISC('star', 'L', $nik, $result->last_test));
        $st_most            = count(Result::hitungDISC('star', 'M', $nik, $result->last_test));

        // INDIVIDUAL DISC PATTERN
        $disc_pattern_D     = Result::indvDiscPattern($D_most - $D_least)->quartil;
        $disc_pattern_I     = Result::indvDiscPattern($I_most - $I_least)->quartil;
        $disc_pattern_S     = Result::indvDiscPattern($S_most - $S_least)->quartil;
        $disc_pattern_C     = Result::indvDiscPattern($C_most - $C_least)->quartil;
        $total_score        = array();
        $data               = array();
        $result_fit         = 0;
        $jml_competency     = 0;


        $totalrata = 0;
        // VS
        foreach (CategoryJob::categoryCompetencyByPosition($position) as $catjob) {
            $total_score        = 0;
            $jml_jobfit_basic   = 0;
            $jml_competency++;

            foreach (jobfitBasic::jobfitBasicByPosCat($position, $catjob->category_competencies_id) as $poscat) {
                if ($poscat->jobfit_id == 'D') {
                    $vs_pattern = $disc_pattern_D . ',' . $poscat->pattern;
                } else if ($poscat->jobfit_id == 'I') {
                    $vs_pattern = $disc_pattern_I . ',' . $poscat->pattern;
                } else if ($poscat->jobfit_id == 'S') {
                    $vs_pattern = $disc_pattern_S . ',' . $poscat->pattern;
                } else if ($poscat->jobfit_id == 'C') {
                    $vs_pattern = $disc_pattern_C . ',' . $poscat->pattern;
                }

                $total_score  += Result::getQuadranScore($vs_pattern)->score;

                $patt[] = array(
                    'category_competencies_id' => $poscat->category_competencies_id,
                    'poscat' => $poscat->pattern,
                    'vs_pattern' => $vs_pattern,
                    'quadran_score' => Result::getQuadranScore($vs_pattern)->score,
                    'skor' => array('D' => $D_least, 'I' => $I_least, 'S' => $S_least, 'C' => $C_least),
                    'pattern' => array($disc_pattern_D, $disc_pattern_I, $disc_pattern_S, $disc_pattern_C)
                );

                $jml_jobfit_basic++;
            }

            $rata       = round($total_score / $jml_jobfit_basic);

            $norma = $this->getNorma($flag_agreement_score, $rata);
            $data[]     = array('competency' => $catjob->category_name, 'fit' => $norma);
            $result_fit += $norma;
        }

        /*
         * Count Result
         * */
        if (count(CategoryJob::categoryCompetencyByPosition($position)) == 0) {
            $hasil = '0';
        } else {
            $hasil = round($result_fit / count(CategoryJob::categoryCompetencyByPosition($position)));
        }
        $assessmentresult = Result::countResult($hasil);
        $quadranResult = Result::quadranResult();

        $datas = [
            'data'              => $data,
            'result'            => $result,
            'assess_report'     => $assess_report,
            'assessmentresult'  => $assessmentresult,
            'quadran_result'    => $quadranResult,
        ];

        $pdf = PDF::loadView('results.extract-pdf', $datas);
        return $pdf->download('extract_' . strtotime(date('Y-m-d H:i:s')) . '.pdf');
    }

    public function exportExcel()
    {

        $user_assessment    = Result::getUserAssessment();

        foreach ($user_assessment as $user_assess) {
            $nik            = $user_assess->nik;
            $last_test      = $user_assess->last_test;
            $position       = $user_assess->position_id;

            $result          = Result::getNikResult($nik, $last_test);
            $position        = $result->position_id;
            $flag_agreement_score   = $result->flag_agreement_score; # FLAG AGREEMENT SCORE
            $user            = Session::user();

            if (empty($result)) {
                Flash::error('Result not found');

                return redirect(route('results.index'));
            }

            $categoryCompetency = CategoryCompetency::categoryByPosition($position);
            $assess_report      = Result::assessReport($result->result_disc);


            if (empty(Result::checkAssessResult($nik, $last_test))) {

                // DISC
                // $D_most             = Result::hitungDISC('D', 'M', $nik, $result->last_test)->total;
                // $D_least            = Result::hitungDISC('D', 'L', $nik, $result->last_test)->total;
                // $I_most             = Result::hitungDISC('I', 'M', $nik, $result->last_test)->total;
                // $I_least            = Result::hitungDISC('I', 'L', $nik, $result->last_test)->total;
                // $S_most             = Result::hitungDISC('S', 'M', $nik, $result->last_test)->total;
                // $S_least            = Result::hitungDISC('S', 'L', $nik, $result->last_test)->total;
                // $C_most             = Result::hitungDISC('C', 'M', $nik, $result->last_test)->total;
                // $C_least            = Result::hitungDISC('C', 'L', $nik, $result->last_test)->total;
                // $st_least           = Result::hitungDISC('star', 'L', $nik, $result->last_test)->total;
                // $st_most            = Result::hitungDISC('star', 'M', $nik, $result->last_test)->total;

                $D_most             = count(Result::hitungDISC('D', 'M', $nik, $result->last_test));
                $D_least            = count(Result::hitungDISC('D', 'L', $nik, $result->last_test));
                $I_most             = count(Result::hitungDISC('I', 'M', $nik, $result->last_test));
                $I_least            = count(Result::hitungDISC('I', 'L', $nik, $result->last_test));
                $S_most             = count(Result::hitungDISC('S', 'M', $nik, $result->last_test));
                $S_least            = count(Result::hitungDISC('S', 'L', $nik, $result->last_test));
                $C_most             = count(Result::hitungDISC('C', 'M', $nik, $result->last_test));
                $C_least            = count(Result::hitungDISC('C', 'L', $nik, $result->last_test));
                $st_least           = count(Result::hitungDISC('star', 'L', $nik, $result->last_test));
                $st_most            = count(Result::hitungDISC('star', 'M', $nik, $result->last_test));

                // INDIVIDUAL DISC PATTERN
                $disc_pattern_D     = Result::indvDiscPattern($D_most - $D_least)->quartil;
                $disc_pattern_I     = Result::indvDiscPattern($I_most - $I_least)->quartil;
                $disc_pattern_S     = Result::indvDiscPattern($S_most - $S_least)->quartil;
                $disc_pattern_C     = Result::indvDiscPattern($C_most - $C_least)->quartil;
                $total_score        = array();
                $data               = array();
                $result_fit         = 0;
                $jml_competency     = 0;
                $totalrata          = 0;

                // echo $D_least.' '.$nik.'<br>';
                // VS
                foreach (CategoryJob::categoryCompetencyByPosition($position) as $catjob) {
                    $total_score        = 0;
                    $jml_jobfit_basic   = 0;
                    $jml_competency++;

                    foreach (jobfitBasic::jobfitBasicByPosCat($position, $catjob->category_competencies_id) as $poscat) {
                        if ($poscat->jobfit_id == 'D') {
                            $vs_pattern = $disc_pattern_D . ',' . $poscat->pattern;
                        } else if ($poscat->jobfit_id == 'I') {
                            $vs_pattern = $disc_pattern_I . ',' . $poscat->pattern;
                        } else if ($poscat->jobfit_id == 'S') {
                            $vs_pattern = $disc_pattern_S . ',' . $poscat->pattern;
                        } else if ($poscat->jobfit_id == 'C') {
                            $vs_pattern = $disc_pattern_C . ',' . $poscat->pattern;
                        }

                        $total_score  += Result::getQuadranScore($vs_pattern)->score;

                        $patt[] = array(
                            'category_competencies_id' => $poscat->category_competencies_id,
                            'poscat' => $poscat->pattern,
                            'vs_pattern' => $vs_pattern,
                            'quadran_score' => Result::getQuadranScore($vs_pattern)->score,
                            'skor' => array('D' => $D_least, 'I' => $I_least, 'S' => $S_least, 'C' => $C_least),
                            'pattern' => array($disc_pattern_D, $disc_pattern_I, $disc_pattern_S, $disc_pattern_C)
                        );

                        $jml_jobfit_basic++;
                    }

                    $rata       = round($total_score / $jml_jobfit_basic);

                    $norma = $this->getNorma($flag_agreement_score, $rata);

                    $data[]     = array('competency' => $catjob->category_name, 'fit' => $norma);
                    $result_fit += $norma;
                }

                /*
                 * Count Result
                 * */
                if (count(CategoryJob::categoryCompetencyByPosition($position)) == 0) {
                    $hasil = '0';
                } else {
                    $hasil = round($result_fit / count(CategoryJob::categoryCompetencyByPosition($position)));
                }

                $data = array('nik' => $nik, 'result' => $hasil, 'last_test' => $last_test);

                Analysis::create($data);
            }
        }

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=export_result_" . strtotime(now()) . ".xls");
        echo '<html><title>Export All To Excel</title><body>';
        echo '<table border="1">';
        echo '<tr><th>NIK</th><th>NAMA</th><th>JABATAN</th><th>DEPARTEMENT</th><th>DIVISI</th><th>AREA</th><th>EMAIL</th><th>NOMOR TELPON</th><th>JOB FIT</th><th>KARAKTER KEPRIBADIAN</th>';

        $user_results       = Result::userAssessmentResult();
        foreach ($user_results as $user_result) {

            echo '<tr>
                    <td>' . $user_result->nik . '</td>
                    <td>' . $user_result->nama . '</td>
                    <td>' . $user_result->position_name . '</td>
                    <td>' . $user_result->departement . '</td>
                    <td>' . $user_result->divisi . '</td>
                    <td>' . $user_result->area . '</td>
                    <td>' . $user_result->email . '</td>
                    <td>' . $user_result->no_telp . '</td>
                    <td>' . $user_result->result . '%</td>
                    <td>' . $user_result->result_disc . '/' . $user_result->tipe_dev . '</td>
                  </tr>';
        }


        echo '</table>';

        echo '</body></html>';
    }

    public function tes()
    {
        return session()->get('PHPSESSID');
    }

    public function datatable()
    {
        $results    = Result::AllUserAssessment();
        return \DataTables::of($results)->make(true);
    }

    private function getNorma($flagagreementscore, $rata)
    {
        #FLAG AGREEMENT SCORE, JIKA 0 MAKA MENGGUNAKAN AGREEMENT SCORE LAMA, JIKA 1 MAKA MENGGUNAKAN AGREEMENT SCORE BARU
        if ($flagagreementscore == 0) {
            #AGREEMENT SCORE LAMA
            $norma      = empty(Result::getFitScore($rata)->norma) ? '0' : Result::getFitScore($rata)->norma;
        } else if ($flagagreementscore == 1) {
            #AGREEMENT SCORE BARU
            $norma      = empty(Result::getFitScoreNew($rata)->norma) ? '0' : Result::getFitScoreNew($rata)->norma;
        }

        return $norma;
    }
}
