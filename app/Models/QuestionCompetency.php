<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuestionCompetency
 * @package App\Models
 * @version February 9, 2018, 12:36 pm UTC
 *
 * @property string question_id
 * @property string categori_id
 * @property string description
 * @property string answer
 */
class QuestionCompetency extends Model
{
    use SoftDeletes;

    public $table = 'question_competencies';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'question_id',
        'category_competencies_id',
        'description',
        'coding',
        'jobfit_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'question_id' => 'string',
        'category_competencies_id' => 'string',
        'description' => 'string',
        'coding' => 'string',
        'jobfit_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question_id' => 'required',
        'category_competencies_id' => 'required',
        'description' => 'required',
        'coding' => 'required',
        'jobfit_id' => 'required'
    ];
    
    public function categoryCompetency()
    {
        return $this->belongsTo(\App\Models\CategoryCompetency::class, 'category_competencies_id', 'id');
    }

}
