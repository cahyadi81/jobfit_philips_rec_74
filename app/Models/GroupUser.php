<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GroupUser
 * @package App\Models
 * @version February 13, 2018, 3:26 am UTC
 *
 * @property string group_id
 * @property string group_name
 * @property integer status
 */
class GroupUser extends Model
{
    use SoftDeletes;

    public $table = 'group_users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'group_id',
        'group_name',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'group_id' => 'string',
        'group_name' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'group_id' => 'required',
        'group_name' => 'required',
        'status' => 'required'
    ];

    
}
