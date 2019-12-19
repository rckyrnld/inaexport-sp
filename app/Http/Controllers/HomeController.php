<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;
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

	public function user_guide(){
		if(Auth::user()){
			if(Auth::user()->id_group == 1){
				$pageTitle = "User Guide";
		        return view('user-guide',compact('pageTitle'));
			} else {
				return redirect('/login');
			}
	    } else {
	    	return redirect('/login');
	    }
	}

	public function user_guide_update(Request $req){
		date_default_timezone_set("Asia/Bangkok");
		$cek = DB::table('user_guide')->where('group_user', $req->group)->first();
		if($cek){
			$file_path = public_path().'\uploads\User Guide\\'.$cek->name_version;
			if(file_exists($file_path)){
				unlink($file_path);
			}
			DB::table('user_guide')->where('id', $cek->id)->delete();
		}

		$destination= 'uploads\User Guide\\';
		if($req->hasFile('file')){ 
			$file = $req->file('file');
			$nama_file = time().'_'.$req->file('file')->getClientOriginalName();
			Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
		} else {
			return redirect('/login');
		}

		DB::table('user_guide')->insert([
			'name_version' => $nama_file,
			'group_user' => $req->group,
			'created_at' => date('Y-m-d H:i:s')
		]);

        return redirect('/user-guide/');
	}

	public function user_guide_data()
    {
      	$data = DB::table('user_guide')->orderBy('created_at','desc')->get();

      	return \Yajra\DataTables\DataTables::of($data)
      		->addIndexColumn()
          	->addColumn('action', function ($data) {
              	return '<center><a href="'.url('/').'/uploads/User Guide/'.$data->name_version.'" download class="btn btn-info donlod"><i class="fa fa-download"></i>&nbsp;&nbsp;Download</a></center>';
          	})
          	->addColumn('date', function($data){
          		return getTanggalIndo(date('Y-m-d', strtotime($data->created_at))).' ( '.date('H:i', strtotime($data->created_at)).' )';
          	})
          	->addColumn('group', function($data){
          		$groupnya = 1;
          		$group = [ 1 => 'Admin', 2 => 'Exporter', 3 => 'Buyer', 4 => 'Representative'];
          		if($data->group_user != null){ $groupnya = $data->group_user; }

          		return $group[$groupnya];
          	})
          	->rawColumns(['action'])
          	->make(true);
    }
}
