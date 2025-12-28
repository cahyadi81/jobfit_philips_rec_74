<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryJob
 * @package App\Models
 * @version March 9, 2018, 12:06 pm UTC
 *
 * @property string position_id
 * @property string category_id
 */
class CategoryJob extends Model
{
    use SoftDeletes;

    public $table = 'category_jobs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'position_id',
        'category_competencies_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'position_id'               => 'string',
        'category_competencies_id'  => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'position_id'               => 'required',
        'category_competencies_id'  => 'required'
    ];

    public function categoryCompetency()
    {
        return $this->belongsTo(\App\Models\CategoryCompetency::class, 'category_competencies_id', 'id');
    }

    public function position($id)
    {
        return Position::where('id', $id)->first();
    }

    public static function categoryCompetencyByPosition($position_id)
    {
        return DB::table('category_jobs as a')
                    ->select('a.position_id', 'a.category_competencies_id', 'b.category_name')
                    ->leftJoin('category_competencies as b', 'a.category_competencies_id', '=', 'b.id')
                    ->where('a.position_id', $position_id)
                    ->get();
    }
    
}
