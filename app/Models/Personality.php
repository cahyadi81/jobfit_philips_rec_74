<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Personality
 * @package App\Models
 * @version March 9, 2018, 2:49 am UTC
 *
 * @property string alias
 * @property string personality_name
 * @property string description
 */
class Personality extends Model
{
    use SoftDeletes;

    public $table = 'personalities';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'alias',
        'personality_name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'alias' => 'string',
        'personality_name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'alias' => 'required',
        'personality_name' => 'required',
        'description' => 'required'
    ];

    
}
