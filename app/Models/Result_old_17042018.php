<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class Result
 * @package App\Models
 * @version March 1, 2018, 2:07 am UTC
 *
 * @property string nik
 * @property string position_id
 */
class Result extends Model
{

    public $table = 'assess_result';

    public $fillable = [
        'nik',
        'position_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nik' => 'string',
        'position_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nik' => 'required',
        'position_id' => 'required'
    ];

    public function position() {
        return $this->belongsTo(\App\Models\Position::class);
    }

    public static function userAssessment(){
        return $users = DB::table('assess_result as a')
                            ->select('a.nik','b.nama', 'b.jabatan', 'c.position_name', 'a.last_test')
                            ->groupBy('a.nik', 'a.last_test')
                            ->leftJoin('user_assesment as b', 'a.nik', '=', 'b.nik')
                            ->leftJoin('positions as c', 'b.jabatan', '=', 'c.id')
                            ->orderBy('a.last_test', 'desc')
                            ->paginate(10);
    }

    public static function AllUserAssessment(){
        return $users = DB::table('assess_result as a')
                            ->select('a.nik','b.nama', 'c.position_name', 'a.last_test')
                            ->groupBy('a.nik', 'a.last_test')
                            ->leftJoin('user_assesment as b', 'a.nik', '=', 'b.nik')
                            ->leftJoin('positions as c', 'b.jabatan', '=', 'c.id')
                            ->orderBy('a.last_test', 'desc')
                            ->get();
    }

    public static function getNikResult($nik, $last_test){
        return DB::table('assess_result as a')
                    ->select('a.nik','b.nama', 'b.jabatan as position_id', 'c.position_name as jabatan', 'a.last_test', 'b.departement', 'b.divisi', 'b.area', 'b.result_disc')
                    ->groupBy('a.nik', 'a.last_test')
                    ->leftJoin('user_assesment as b', 'a.nik', '=', 'b.nik')
                    ->leftJoin('positions as c', 'b.jabatan', '=', 'c.id')
                    ->where(["a.nik" => $nik, 'a.last_test' => $last_test])
                    ->first();
    }

    public static function assessReport($kode_dev) {
        return DB::table('assess_report_header')
                    ->where("kode_dev", $kode_dev)
                    ->first();
    }

    public static function hitungDISC($initial, $value, $nik, $date) {
        return DB::table('assess_result')
                    ->select(DB::raw('count(*) total'))
                    ->where([$initial => $value, 'nik' => $nik, 'last_test' => $date])
                    ->first();
    }

    public static function indvDiscPattern($value){
        return DB::table('quadran_individuals')
                    ->select('quatril as quartil')
                    ->where('min', '<=', $value)
                    ->where('max', '>=', $value)
                    ->first();
    }

    public static function getQuadranScore($quartil) {
        return DB::table('quadran_scores')
                    ->select('score')
                    ->where('quatril', $quartil)
                    ->first();
    }

    public static function getFitScore($rata){
        return DB::table('agreement_scores')
                    ->select('norma')
                    ->where('agreement_score', $rata)
                    ->first();
    }

    public static function patternCompetencyByPosition($position){
        return DB::table('jobfit_basics')
                    ->select('position_id', 'category_competencies_id')
                    ->where('position_id', $position)
                    ->get();
    }

    public static function countResult($value){
        return DB::table('quadran_result')
            ->where('min', '<=', $value)
            ->where('max', '>=', $value)
            ->first();
    }

    public static function quadranResult(){
        return DB::table('quadran_result')
            ->select('min','max','result','description')
            ->get();
    }
}
