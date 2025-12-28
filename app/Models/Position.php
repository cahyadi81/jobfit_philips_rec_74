<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Position
 * @package App\Models
 * @version March 5, 2018, 8:40 am UTC
 *
 * @property string position_name
 * @property integer status
 */
class Position extends Model
{
    use SoftDeletes;

    public $table = 'positions';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'position_name',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'position_name' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'position_name' => 'required',
        'status' => 'required'
    ];

    
}
