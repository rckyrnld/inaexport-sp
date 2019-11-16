<?php

namespace App\Http\Controllers;

use App\Eksmp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginEIController extends Controller
{
    
	use AuthenticatesUsers;
    protected $guard = 'eksmp';
    protected $redirectTo = '/';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function guard()
    {
        return auth()->guard('eksmp');
    }
   
    public function loginei(Request $request)
    {
        if (Auth::guard('eksmp')->attempt(['email' => $request->email2, 'password' => $request->password2])) {

            return redirect()->intended('/');
        }
		
        return back()->withErrors(['email' => 'Email or password are wrong.']);
    }
	
	
}
