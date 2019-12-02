<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Spb;
use App\Manifest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $spbmtd = Spb::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count();
        $spbytd = Spb::whereYear('created_at',date('Y'))->count();
        $manifestmtd = Manifest::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count();
        $manifestytd = Manifest::whereYear('created_at',date('Y'))->count();
        return view('home',compact('spbmtd','spbytd','manifestmtd','manifestytd'));
    }
}
