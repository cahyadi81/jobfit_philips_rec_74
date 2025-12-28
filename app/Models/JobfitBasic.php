<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class JobfitBasic
 * @package App\Models
 * @version March 9, 2018, 9:50 am UTC
 *
 * @property string category_competencies_id
 * @property string jobfit_id
 * @property string values
 * @property string percent
 */
class JobfitBasic extends Model
{
    use SoftDeletes;

    public $table = 'jobfit_basics';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'category_competencies_id',
        'position_id',
        'jobfit_id',
        'values',
        'percent',
        'pattern'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_competencies_id' => 'string',
        'position_id' => 'string',
        'jobfit_id' => 'string',
        'values' => 'string',
        'percent' => 'string',
        'pattern' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category_competencies_id' => 'required',
        'position_id' => 'required',
        'jobfit_id' => 'required',
        'values' => 'required',
        'percent' => 'required',
        'pattern' => 'required'
    ];
    
    public function categoryCompetency()
    {
        return $this->belongsTo(\App\Models\CategoryCompetency::class, 'category_competencies_id', 'id');
    }

    public function position($id) {
        return Position::where('id', $id)->first();
    }

    public static function jobfitBasicByPosCat($position_id, $category_competencies_id)
    {
        return DB::table('jobfit_basics')
                    ->select('category_competencies_id', 'pattern', 'jobfit_id')
                    ->where(['position_id' => $position_id, 'category_competencies_id' => $category_competencies_id])
                    ->get();
    }

    
}
