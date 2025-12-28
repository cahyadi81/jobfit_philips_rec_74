<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        session()->put('PHPSESSID', $id);
        return redirect('/');
    }

    public function logout(){
        session()->flush();
        unset($_COOKIE['PHPSESSID']);
        setcookie('PHPSESSID', null, -1, '/');
        unset($_COOKIE['jobfit_session']);
        setcookie('jobfit_session', null, -1, '/');
        return redirect(config('jobfit.base_url'));
    }
}
