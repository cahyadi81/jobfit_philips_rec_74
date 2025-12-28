<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class QuadranScore
 * @package App\Models
 * @version February 9, 2018, 12:24 pm UTC
 *
 * @property string quatril
 * @property string score
 */
class QuadranScore extends Model
{
    use SoftDeletes;

    public $table = 'quadran_scores';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'quatril',
        'score'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'quatril' => 'string',
        'score' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'quatril' => 'required',
        'score' => 'required'
    ];

    
}
