<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryCompetency
 * @package App\Models
 * @version March 5, 2018, 8:52 am UTC
 *
 * @property string alias
 * @property string category_name
 * @property string description
 */
class CategoryCompetency extends Model
{
    use SoftDeletes;

    public $table = 'category_competencies';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'alias',
        'category_name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'alias' => 'string',
        'category_name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'alias' => 'required',
        'category_name' => 'required',
        'description' => 'required'
    ];

    public static function categoryByPosition($id) {

        return DB::table('category_jobs as a')
                    ->select('b.position_name', 'c.category_name')
                    ->leftJoin('positions as b', 'a.position_id', '=', 'b.id')
                    ->leftJoin('category_competencies as c', 'a.category_competencies_id', '=', 'c.id')
                    ->where('b.id', $id)
                    ->get();

    }
    
}
