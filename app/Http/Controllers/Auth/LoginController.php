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

    public function authenticate(Request $request)
    {
        $priv = \App\Role_privilege::where('role_id',1)->get();
        foreach($priv as $key=>$pri){
            $privilege[$pri->page_id] = ['browse'=>$pri->browse,'add'=>$pri->add,'edit'=>$pri->edit,'delete'=>$pri->delete];
        }
        session(['privilege'=>$privilege]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
        return redirect()->intended('/');
        }else{
            return redirect('login')->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);;
        }
    }
}
