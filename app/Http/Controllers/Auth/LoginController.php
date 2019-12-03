<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1])) {
            $priv = \App\Role_privilege::where('role_id',Auth::user()->role_id)->get();
            foreach($priv as $key=>$pri){
                $privilege[$pri->page_id] = ['browse'=>$pri->browse,'add'=>$pri->add,'edit'=>$pri->edit,'delete'=>$pri->delete];
            }
            session(['privilege'=>$privilege]);
            return redirect()->intended('/');
        }else{
            return redirect('login')->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);;
        }
    }
}
