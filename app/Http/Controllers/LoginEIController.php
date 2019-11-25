<?php

namespace App\Http\Controllers;

use App\Eksmp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\DB;

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
			$caridata = DB::select("select * from itdp_company_users where email='".$request->email2."'");
			foreach($caridata as $dc){
				$data1 = $dc->id_role;
				$data2 = $dc->id;
			}
			date_default_timezone_set('Asia/Jakarta');
			 $ipaddress = '';
			 if (getenv('HTTP_CLIENT_IP')){
				 $ipaddress = getenv('HTTP_CLIENT_IP');
			 }else if(getenv('HTTP_X_FORWARDED_FOR')){
				 $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			 }else if(getenv('HTTP_X_FORWARDED')){
				 $ipaddress = getenv('HTTP_X_FORWARDED');
			 }else if(getenv('HTTP_FORWARDED_FOR')){
				 $ipaddress = getenv('HTTP_FORWARDED_FOR');
			 }else if(getenv('HTTP_FORWARDED')){
				$ipaddress = getenv('HTTP_FORWARDED');
			 }else if(getenv('REMOTE_ADDR')){
				 $ipaddress = getenv('REMOTE_ADDR');
			 }else{
				 $ipaddress = 'UNKNOWN';
			 }
 
			$insertlogin = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user) values 
			('".$request->email2."','".Date('H:m:s')."','".Date('Y-m-d')."','".$ipaddress."','".$data1."','".$data2."')
			");
            return redirect()->intended('/');
        }
		
        return back()->withErrors(['email' => 'Email or password are wrong.']);
    }
	
	
}
