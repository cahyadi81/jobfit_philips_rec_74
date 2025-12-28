<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Session extends Model
{
	public static function checkSession($session_id) {
	    return DB::table('users')
	    				->select('username', 'level')
	              		->where('id_session', $session_id)
	                    ->first();
	}

	public static function user() {
		$session_id = session()->get('PHPSESSID');
	    return DB::table('users')
	              		->where('id_session', $session_id)
	                    ->first();
	}
}
