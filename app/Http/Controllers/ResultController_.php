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
        $user               = Session::user();
        $assess_report      = Result::assessReport($result->result_disc);

        if (empty($result)) {
            Flash::error('Result not found');

            return redirect(route('results.index'));
        }

        $categoryCompetency = CategoryCompetency::categoryByPosition($result->position_id);
        //$personality        = Result::getPersonality('1');

        // DISC
        $D_most             = Result::hitungDISC('D', 'M', $nik, $result->last_test)->total;
        $D_least            = Result::hitungDISC('D', 'L', $nik, $result->last_test)->total;
        $I_most             = Result::hitungDISC('I', 'M', $nik, $result->last_test)->total;
        $I_least            = Result::hitungDISC('I', 'L', $nik, $result->last_test)->total;
        $S_most             = Result::hitungDISC('S', 'M', $nik, $result->last_test)->total;
        $S_least            = Result::hitungDISC('S', 'L', $nik, $result->last_test)->total;
        $C_most             = Result::hitungDISC('C', 'M', $nik, $result->last_test)->total;
        $C_least            = Result::hitungDISC('C', 'L', $nik, $result->last_test)->total;
        $total_most         = $D_most + $I_most + $S_most + $C_most;
        $total_least        = $D_least + $I_least + $S_least + $C_least;

        // TOTAL DISC
        $total_D            = $D_most - $D_least;
        $total_I            = $I_most - $I_least;
        $total_S            = $S_most - $S_least;
        $total_C            = $C_most - $C_least;

        //dd([$D_most, $I_most, $S_most, $C_most]);
        //dd(['total_most'=>$total_most, 'total_least'=>$total_least]);

        // INDIVIDUAL DISC PATTERN OR QUADRAN INDIVIDUAL
        $disc_pattern_D     = Result::indvDiscPattern($total_D)->quartil;
        $disc_pattern_I     = Result::indvDiscPattern($total_I)->quartil;
        $disc_pattern_S     = Result::indvDiscPattern($total_S)->quartil;
        $disc_pattern_C     = Result::indvDiscPattern($total_C)->quartil;

        //JOBFIT BASIC
        $jb_D               = Result::jobfitBasic($result->position_id, 'D');
        $jb_I               = Result::jobfitBasic($result->position_id, 'I');
        $jb_S               = Result::jobfitBasic($result->position_id, 'S');
        $jb_C               = Result::jobfitBasic($result->position_id, 'C');


        // VS
        $vs_D               = $jb_D->pattern . ',' . $disc_pattern_D;
        $vs_I               = $jb_I->pattern . ',' . $disc_pattern_I;
        $vs_S               = $jb_S->pattern . ',' . $disc_pattern_S;
        $vs_C               = $jb_C->pattern . ',' . $disc_pattern_C;

        //NORMA QUADRAN
        $q1             = Result::getQuadranScore($vs_D)->score;
        $q2             = Result::getQuadranScore($vs_I)->score;
        $q3             = Result::getQuadranScore($vs_S)->score;
        $q4             = Result::getQuadranScore($vs_C)->score;
        $total_score    = round(($q1 + $q2 + $q3 + $q4) / 4);
        $fit_score      = Result::getFitScore($total_score)->norma;

        $debug          = array(
            'quadran individual D' => $disc_pattern_D,
            'quadran individual I' => $disc_pattern_I,
            'quadran individual S' => $disc_pattern_S,
            'quadran individual C' => $disc_pattern_C,
            'jobfit basic D' => $jb_D->pattern,
            'jobfit basic I' => $jb_I->pattern,
            'jobfit basic S' => $jb_S->pattern,
            'jobfit basic C' => $jb_C->pattern,
            'vs' => array($vs_D, $vs_I, $vs_S, $vs_C),
            'vs1 score' => $q1,
            'vs2 score' => $q2,
            'vs3 score' => $q3,
            'vs4 score' => $q4,
            'total score' => $total_score,
            'fit score' => $fit_score . '%'
        );


        //return $debug;

        // NORMA QUADRAN

        // $total_norma_by_position    = count($categoryCompetency);
        // $data   = array();

        // foreach ($categoryCompetency as $cat) {
        //     $q1         = Result::getQuadranScore($vs_D)->score;
        //     $q2         = Result::getQuadranScore($vs_I)->score;
        //     $q3         = Result::getQuadranScore($vs_S)->score;
        //     $q4         = Result::getQuadranScore($vs_C)->score;
        //     $total      = $q1+$q2+$q3+$q4;
        //     $rata       = round($total/4);

        //     if(empty(Result::getFitScore($rata)->norma)){
        //         $fit    = 0;
        //     } else {
        //         $fit    = Result::getFitScore($rata)->norma;
        //     }

        //     $data[]     = array('category_name' => $cat->category_name,
        //                         'fit'         => $fit
        //                         );
        // }

        return view('results.show')->with([
            'result' => $result,
            'fit_score' => $fit_score,
            'user' => $user,
            'category_competency' => CategoryJob::categoryCompetencyByPosition($result->position_id),
            'assess_report' => $assess_report
        ]);
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

        // $categoryCompetency = CategoryCompetency::categoryByPosition($position);
        $assess_report      = Result::assessReport($result->result_disc);

        // // DISC
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

        // // INDIVIDUAL DISC PATTERN
        // $disc_pattern_D     = Result::indvDiscPattern($D_least)->quartil;
        // $disc_pattern_I     = Result::indvDiscPattern($I_least)->quartil;
        // $disc_pattern_S     = Result::indvDiscPattern($S_least)->quartil;
        // $disc_pattern_C     = Result::indvDiscPattern($C_least)->quartil;
        // $total_score        = array();
        // $data               = array();
        // $result_fit         = 0;
        // $jml_competency     = 0;


        // // VS
        // foreach(CategoryJob::categoryCompetencyByPosition($position) as $catjob) {
        //     $total_score        = 0;
        //     $jml_jobfit_basic   = 0;
        //     $jml_competency++;

        //     foreach(jobfitBasic::jobfitBasicByPosCat($position, $catjob->category_competencies_id) as $poscat){
        //         if($poscat->jobfit_id == 'D'){
        //             $vs_pattern = $disc_pattern_D.','.$poscat->pattern;
        //         }

        //         else if($poscat->jobfit_id == 'I') {
        //             $vs_pattern = $disc_pattern_I.','.$poscat->pattern;
        //         }

        //         else if($poscat->jobfit_id == 'S') {
        //             $vs_pattern = $disc_pattern_S.','.$poscat->pattern;
        //         }

        //         else if($poscat->jobfit_id == 'C') {
        //             $vs_pattern = $disc_pattern_C.','.$poscat->pattern;
        //         }

        //         $total_score  += Result::getQuadranScore($vs_pattern)->score;

        //         $patt[] = array('category_competencies_id' => $poscat->category_competencies_id,
        //                         'poscat' => $poscat->pattern,
        //                         'vs_pattern' => $vs_pattern,
        //                         'quadran_score' => Result::getQuadranScore($vs_pattern)->score,
        //                         'skor' => array('D'=>$D_least, 'I'=>$I_least, 'S'=>$S_least, 'C'=>$C_least),
        //                         'pattern' => array($disc_pattern_D, $disc_pattern_I, $disc_pattern_S, $disc_pattern_C));

        //         $jml_jobfit_basic++;
        //     }

        //     $rata       = round($total_score/$jml_jobfit_basic);
        //     $norma      = empty(Result::getFitScore($rata)->norma) ? '0' : Result::getFitScore($rata)->norma;
        //     $data[]     = array('competency' => $catjob->category_name,'fit' => $norma);
        //     $result_fit += $norma;

        // }

        // DISC
        $D_most         = Result::hitungDISC('D', 'M', $nik, $result->last_test)->total;
        $D_least        = Result::hitungDISC('D', 'L', $nik, $result->last_test)->total;
        $I_most         = Result::hitungDISC('I', 'M', $nik, $result->last_test)->total;
        $I_least        = Result::hitungDISC('I', 'L', $nik, $result->last_test)->total;
        $S_most         = Result::hitungDISC('S', 'M', $nik, $result->last_test)->total;
        $S_least        = Result::hitungDISC('S', 'L', $nik, $result->last_test)->total;
        $C_most         = Result::hitungDISC('C', 'M', $nik, $result->last_test)->total;
        $C_least        = Result::hitungDISC('C', 'L', $nik, $result->last_test)->total;

        // TOTAL DISC
        $total_D        = $D_most - $D_least;
        $total_I        = $I_most - $I_least;
        $total_S        = $S_most - $S_least;
        $total_C        = $C_most - $C_least;

        // INDIVIDUAL DISC PATTERN OR QUADRAN INDIVIDUAL
        $disc_pattern_D = Result::indvDiscPattern($total_D)->quartil;
        $disc_pattern_I = Result::indvDiscPattern($total_I)->quartil;
        $disc_pattern_S = Result::indvDiscPattern($total_S)->quartil;
        $disc_pattern_C = Result::indvDiscPattern($total_C)->quartil;

        //JOBFIT BASIC
        $jb_D           = Result::jobfitBasic($result->position_id, 'D');
        $jb_I           = Result::jobfitBasic($result->position_id, 'I');
        $jb_S           = Result::jobfitBasic($result->position_id, 'S');
        $jb_C           = Result::jobfitBasic($result->position_id, 'C');

        // VS
        $vs_D           = $jb_D->pattern . ',' . $disc_pattern_D;
        $vs_I           = $jb_I->pattern . ',' . $disc_pattern_I;
        $vs_S           = $jb_S->pattern . ',' . $disc_pattern_S;
        $vs_C           = $jb_C->pattern . ',' . $disc_pattern_C;

        //NORMA QUADRAN
        $q1             = Result::getQuadranScore($vs_D)->score;
        $q2             = Result::getQuadranScore($vs_I)->score;
        $q3             = Result::getQuadranScore($vs_S)->score;
        $q4             = Result::getQuadranScore($vs_C)->score;
        $total_score    = round(($q1 + $q2 + $q3 + $q4) / 4);
        $fit_score      = Result::getFitScore($total_score)->norma;


        $data = [
            'fit_score'             => $fit_score,
            'result'                => $result,
            'assess_report'         => $assess_report,
            'category_competency'   => CategoryJob::categoryCompetencyByPosition($result->position_id),
        ];

        //return view('results.extract-pdf')->with($data);


        $pdf = PDF::loadView('results.extract-pdf', $data);
        return $pdf->download('result_jobfit_' . $nik . '_' . strtotime(date('Y-m-d H:i:s')) . '.pdf');
    }

    public function exportExcel()
    {

        $user_assessment    = Result::getUserAssessment();

        foreach ($user_assessment as $user_assess) {
            $nik            = $user_assess->nik;
            $last_test      = $user_assess->last_test;
            $position       = $user_assess->position_id;


            if (empty(Result::checkAssessResult($nik, $last_test))) {

                $D_most         = Result::hitungDISC('D', 'M', $nik, $last_test)->total;
                $D_least        = Result::hitungDISC('D', 'L', $nik, $last_test)->total;
                $I_most         = Result::hitungDISC('I', 'M', $nik, $last_test)->total;
                $I_least        = Result::hitungDISC('I', 'L', $nik, $last_test)->total;
                $S_most         = Result::hitungDISC('S', 'M', $nik, $last_test)->total;
                $S_least        = Result::hitungDISC('S', 'L', $nik, $last_test)->total;
                $C_most         = Result::hitungDISC('C', 'M', $nik, $last_test)->total;
                $C_least        = Result::hitungDISC('C', 'L', $nik, $last_test)->total;
                $total_most     = $D_most + $I_most + $S_most + $C_most;
                $total_least    = $D_least + $I_least + $S_least + $C_least;

                // TOTAL DISC
                $total_D        = $D_most - $D_least;
                $total_I        = $I_most - $I_least;
                $total_S        = $S_most - $S_least;
                $total_C        = $C_most - $C_least;

                /* echo $nik.' '.$total_D.'<br>'; */

                // INDIVIDUAL DISC PATTERN OR QUADRAN INDIVIDUAL
                $disc_pattern_D     = Result::indvDiscPattern($total_D)->quartil;
                $disc_pattern_I     = Result::indvDiscPattern($total_I)->quartil;
                $disc_pattern_S     = Result::indvDiscPattern($total_S)->quartil;
                $disc_pattern_C     = Result::indvDiscPattern($total_C)->quartil;

                $nik . ' ' . $disc_pattern_D . ' ' . $disc_pattern_I . ' ' . $disc_pattern_S . ' ' . $disc_pattern_C . '<br>';

                //JOBFIT BASIC
                $jb_D           = Result::jobfitBasic($position, 'D');
                $jb_I           = Result::jobfitBasic($position, 'I');
                $jb_S           = Result::jobfitBasic($position, 'S');
                $jb_C           = Result::jobfitBasic($position, 'C');


                // VS
                $vs_D           = $jb_D->pattern . ',' . $disc_pattern_D;
                $vs_I           = $jb_I->pattern . ',' . $disc_pattern_I;
                $vs_S           = $jb_S->pattern . ',' . $disc_pattern_S;
                $vs_C           = $jb_C->pattern . ',' . $disc_pattern_C;

                // NORMA QUADRAN
                $q1             = Result::getQuadranScore($vs_D)->score;
                $q2             = Result::getQuadranScore($vs_I)->score;
                $q3             = Result::getQuadranScore($vs_S)->score;
                $q4             = Result::getQuadranScore($vs_C)->score;
                $total_score    = round(($q1 + $q2 + $q3 + $q4) / 4);
                $fit_score      = Result::getFitScore($total_score)->norma;

                Analysis::create(['nik' => $nik, 'result' => $fit_score, 'last_test' => $last_test]);
            }
        }

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=export_result_" . strtotime(now()) . ".xls");
        echo '<html><title>Export All To Excel</title><body>';
        echo '<table border="1">';
        //echo '<tr><th>NIK</th><th>NAMA</th><th>JABATAN</th><th>DEPARTEMENT</th><th>DIVISI</th><th>AREA</th><th>EMAIL</th><th>NOMOR TELPON</th><th>JOB FIT</th><th>KARAKTER KEPRIBADIAN</th>';
        echo '<tr><th>NIK</th><th>NAMA</th><th>JABATAN</th><th>DEPARTEMENT</th><th>DIVISI</th><th>AREA</th><th>EMAIL</th><th>NOMOR TELPON</th><th>JOB FIT</th>';

        $user_results       = Result::userAssessmentResult();
        foreach ($user_results as $user_result) {

            /* echo '<tr>
                    <td>'.$user_result->nik.'</td>
                    <td>'.$user_result->nama.'</td>
                    <td>'.$user_result->position_name.'</td>
                    <td>'.$user_result->departement.'</td>
                    <td>'.$user_result->divisi.'</td>
                    <td>'.$user_result->area.'</td>
                    <td>'.$user_result->email.'</td>
                    <td>'.$user_result->no_telp.'</td>
                    <td>'.$user_result->result.'%</td>
                    <td>'.$user_result->result_disc.'/'.$user_result->tipe_dev.'</td>
                  </tr>';*/

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
                  </tr>';
        }


        echo '</table>';

        echo '</body></html>';
    }

    public function datatable()
    {
        $results    = Result::AllUserAssessment();
        return \DataTables::of($results)->make(true);
    }
}
