<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuadranCompetency
 * @package App\Models
 * @version February 9, 2018, 9:04 am UTC
 *
 * @property string quatril
 * @property string min
 * @property string max
 */
class QuadranCompetency extends Model
{
    use SoftDeletes;

    public $table = 'quadran_competencies';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'quatril',
        'min',
        'max'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'quatril' => 'string',
        'min' => 'string',
        'max' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'quatril' => 'required',
        'min' => 'required',
        'max' => 'required'
    ];

    
}
