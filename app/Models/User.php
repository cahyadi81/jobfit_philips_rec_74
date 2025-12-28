<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version February 21, 2018, 1:37 am UTC
 *
 * @property string user_id
 * @property string name
 * @property string address
 * @property string email
 * @property string group_id
 * @property string password
 * @property integer status
 */
class User extends Model
{
    use SoftDeletes;

    public $table = 'users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'name',
        'address',
        'email',
        'group_user_id',
        'password',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'string',
        'name' => 'string',
        'address' => 'string',
        'email' => 'string',
        'group_user_id' => 'string',
        'password' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'name' => 'required',
        'address' => 'required',
        'email' => 'required',
        'group_user_id' => 'required',
        'password' => 'required',
        'status' => 'required'
    ];
    
    public function group_user()
    {
        return $this->belongsTo(\App\Models\GroupUser::class, 'group_id', 'group_id');
    }

    public function hasRole($roleName)
    {
        foreach ($this->groupUser as $role)
        {
            if ($role->group_name === $roleName) return true;
        }
        return false;
    }

}
