<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AgreementScore
 * @package App\Models
 * @version March 9, 2018, 12:09 pm UTC
 *
 * @property string agreement_score
 * @property string norma
 */
class AgreementScore extends Model
{
    use SoftDeletes;

    public $table = 'agreement_scores';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'agreement_score',
        'norma'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'agreement_score' => 'string',
        'norma' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'agreement_score' => 'required',
        'norma' => 'required'
    ];

    
}
