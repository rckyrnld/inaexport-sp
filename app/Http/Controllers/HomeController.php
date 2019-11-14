<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(empty(Auth::user()->name)){ 
		}else{ 
			if(Auth::user()->id_group == 4){
				if(Auth::user()->type == "DINAS PERDAGANGAN"){
					$qr = DB::select("select b.* from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and a.id='".Auth::user()->id."'");
					foreach($qr as $rq){ $sts = $rq->status; }
					if($sts==0){
					Auth::logout();
					return redirect('admin');	
					}
				}else{
					$qr = DB::select("select b.* from itdp_admin_users a, itdp_admin_ln b  where a.id_admin_ln = b.id and a.id='".Auth::user()->id."'");
					foreach($qr as $rq){ $sts = $rq->status; }
					if($sts==0){
					Auth::logout();
					return redirect('admin');	
					}
					
				}
			}
		}
        $pageTitle = "Beranda";
		
        return view('home',compact('pageTitle'));
    }
	
	
	
	public function gantipass()
    {
		$idx = Auth::user()->id;
		$queryxp = DB::select("select * from users where id='".$idx."'");
		$pageTitle = "Ganti Password";
        return view('gantipass',compact('pageTitle','queryxp'));
	}
	
	public function updatepass(Request $request)
    {
		// echo bcrypt($request->password);die();
		$queryxp = DB::select("
		update users set password='".bcrypt($request->password)."' , password_real='".$request->password."' 
		where id='".Auth::user()->id."'
		");
		return redirect('');
		
	}
}
