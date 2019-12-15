<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use Lang;
use App\Customer;
use App\Spb;
use App\Manifest;

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
        // authenticate user
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'status' => 1])) {
            $priv = \App\Role_privilege::where('role_id',Auth::user()->role_id)->get();
            foreach($priv as $key=>$pri){
                $privilege[$pri->page_id] = ['browse'=>$pri->browse,'add'=>$pri->add,'edit'=>$pri->edit,'delete'=>$pri->delete];
            }
            session(['privilege'=>$privilege]);

            // if operasional, count undelivered spb
            if(Auth::user()->role_id == 6 || Auth::user()->role_id == 9){
                $manifest = Manifest::where('driver_id',Auth::user()->id)->first();
                $spb_undelivered = Spb::where('manifest_id',$manifest->id)->where('spb_status_id','!=',4)->count();
                session(['spb_undelivered'=>$spb_undelivered]);
                return redirect('/manifest/my');
            }

            return redirect()->intended('/');
        }else{
            // try to authenticate customer
            $customer = Customer::where('email',$request->username)->where('pic_phone',$request->password)->first();
            if($customer){
                session(['customer'=>$customer]);
                return redirect('/customerspb');
            }else{
                return redirect('login')->withErrors([
                $this->username() => Lang::get('auth.failed'),
                ]);;
            }
        }
    }
}
