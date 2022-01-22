<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Session;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;


class AdminAuthController extends Controller
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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    

    public function showLogin()
    {
        return view('auth.login-admin');
    }

    public function login(Request $request)
    {

        // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required'
      ]);
      // Attempt to log the user in
      if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // dd((Auth::guard('admin')));
        // if successful, then redirect to their intended location
        $request->session()->regenerate();
        // \Session::put('success','You are Login successfully!!');
        // return redirect()->intended(route('admin.dashboard'));
        return redirect()->intended(route('admin.dashboard'));
      } 

        return redirect('/login')->withErrors([
            'email' => '',
            'password' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        \Session::flush();
        return redirect('/login');
    }
}
