<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Analysis extends Model
{

	protected $fillable = [
        'nik',
        'result',
        'last_test',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'user_assesment_result';

    public static function checkUserAssessment($nik){
    	return DB::table('user_assesment')
    			   ->select('nik')
    			   ->where(['nik' => $nik])
    			   ->first();
    }

    public static function checkUserAssessmentResult($nik, $category_competencies_id, $last_test){
    	return DB::table('user_assesment_result')
    			   ->select('nik')
    			   ->where(['nik' => $nik, 'category_competencies_id' => $category_competencies_id, 'last_test' => $last_test])
    			   ->first();
    }

    public static function getUserAssessment() {
        return DB::table('assess_result as a')
                    ->select('a.nik','b.nama', 'b.jabatan as position_id', 'c.position_name as jabatan', 'a.last_test', 'b.departement', 'b.divisi', 'b.area', 'b.result_disc')
                    ->groupBy('a.nik', 'a.last_test')
                    ->leftJoin('user_assesment as b', 'a.nik', '=', 'b.nik')
                    ->leftJoin('positions as c', 'b.jabatan', '=', 'c.id')
                    ->groupBy('a.nik', 'a.last_test')
                    ->get();
    }
    public static function checkAssessResult($nik, $last_test)
    {
        return DB::table('user_assesment_result')
                    ->select('nik', 'last_test')
                    ->where(['nik'=>$nik,'last_test'=>$last_test])
                    ->first();
    }
}
