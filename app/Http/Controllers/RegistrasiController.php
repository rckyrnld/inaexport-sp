<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class RegistrasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginadmin()
    {
        $pageTitle = "Log In Administrator";
        return view('auth.loginadmin',compact('pageTitle'));
    }
	
	public function pilihregister()
    {
        $pageTitle = "Choose Register";
        return view('auth.cr',compact('pageTitle'));
    }
	
	public function registrasi_pembeli()
    {
        $pageTitle = "Registrasi Pembeli";
        return view('auth.register_pembeli',compact('pageTitle'));
    } 
	
	public function forget_a()
    {
        $pageTitle = "Forget Password";
        return view('auth.forget',compact('pageTitle'));
    } 
	
	public function gantipass1($id)
    {
        $pageTitle = "Forget Password";
        return view('auth.forget_form',compact('pageTitle','id'));
    } 
	
	public function gantipass2($id)
    {
        $pageTitle = "Forget Password";
        return view('auth.forget_form2',compact('pageTitle','id'));
    } 
	
	public function set($lang) {
    session(['applocale' => $lang]);

        return back();
    }
	
	public function registrasi_penjual()
    {
        $pageTitle = "Registrasi Penjual";
        return view('auth.register_penjual',compact('pageTitle'));
    } 
	
	public function simpan_rpembeli(Request $request)
    {
		$insert1 = DB::select("
			insert into itdp_profil_imp (company,addres,postcode,phone,fax,email,website,created,status,city,id_mst_country) values
			('".$request->company."','".$request->alamat."','".$request->postcode."','".$request->phone."','".$request->fax."'
			,'".$request->email."','".$request->website."','".Date('Y-m-d H:m:s')."','1','".$request->city."','".$request->country."')
		");
		$ambilmaxid = DB::select("select max(id) as maxid from itdp_profil_imp");
		foreach($ambilmaxid as $rt){
			$id1 = $rt->maxid;
		}
		$insert2 = DB::select("
			insert into itdp_company_users (id_profil,username,password,email,status,id_role,type) values
			('".$id1."','".$request->username."','".bcrypt($request->password)."','".$request->email."','0','3','Luar Negeri')
		");
		$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
		foreach($ambilmaxid2 as $rt2){
			$id2 = $rt2->maxid2;
		}
		// notif 
		$id_terkait = "3/".$id2;
		$ket = "User baru Importir dengan nama ".$request->company;
		$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('1','".$request->company."','".$id1."','Super Admin','1','".$ket."','profil2','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
		");
		
		//notif untuk perwakilan
		$carigc = DB::select("select * from mst_country where id='".$request->country."'");
		foreach($carigc as $gccari){  $groupcountry = $gccari->mst_country_group_id; }
		$qr = DB::select("select a.* from itdp_admin_users a, itdp_admin_ln b  where a.id_admin_ln = b.id and b.id_country='".$groupcountry."'");
		foreach($qr as $rq){
			$insertpw = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('4','".$request->company."','".$id1."','Perwakilan','".$rq->id."','".$ket."','profil','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
			");
			$data3 = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => $rq->email];

                Mail::send('UM.user.emailsuser', $data3, function ($mail) use ($data3) {
                    $mail->to($data3['email'], $data3['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
		}
		
			
			$data = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => $request->email];

                Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
			
			$data2 = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => 'kementerianperdagangan.max@gmail.com'];

                Mail::send('UM.user.emailsuser', $data2, function ($mail) use ($data2) {
                    $mail->to($data2['email'], $data2['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
        return view('auth.waitmail',compact('pageTitle'));
    }
	
	public function simpan_rpenjual(Request $request)
    {
		$insert1 = DB::select("
			insert into itdp_profil_eks (company,addres,postcode,phone,fax,email,website,created,status,city,id_mst_province) values
			('".$request->company."','".$request->alamat."','".$request->postcode."','".$request->phone."','".$request->fax."'
			,'".$request->email."','".$request->website."','".Date('Y-m-d H:m:s')."','1','".$request->city."','".$request->prov."')
		");
		$ambilmaxid = DB::select("select max(id) as maxid from itdp_profil_eks");
		foreach($ambilmaxid as $rt){
			$id1 = $rt->maxid;
		}
		$insert2 = DB::select("
			insert into itdp_company_users (id_profil,type,username,password,email,status,id_role) values
			('".$id1."','Luar Negeri','".$request->username."','".bcrypt($request->password)."','".$request->email."','0','2')
		");
		$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
		foreach($ambilmaxid2 as $rt2){
			$id2 = $rt2->maxid2;
		}
		
		// notif 
		$id_terkait = "2/".$id2;
		$ket = "User baru Eksportir dengan nama ".$request->company;
		$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('1','".$request->company."','".$id1."','Super Admin','1','".$ket."','profil','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
		");
		//notif untuk perwakilan
		$qr = DB::select("select a.* from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and b.id_country='".$request->prov."'");
		foreach($qr as $rq){
			$insertpw = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('4','".$request->company."','".$id1."','Perwakilan','".$rq->id."','".$ket."','profil','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
			");
			$data3 = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => $rq->email];

                Mail::send('UM.user.emailsuser', $data3, function ($mail) use ($data3) {
                    $mail->to($data3['email'], $data3['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
		}
		
			
			$data = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => $request->email];

                Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
			$data2 = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => 'kementerianperdagangan.max@gmail.com'];

                Mail::send('UM.user.emailsuser', $data2, function ($mail) use ($data2) {
                    $mail->to($data2['email'], $data2['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
        return view('auth.waitmail',compact('pageTitle'));
    }
	
	public function transaksibr()
    {
		get
	}	public function verifypembeli($id)
    {
		$update = DB::select("update itdp_company_users set agree='1' where id='".$id."'");
		return redirect('');
	}
	
	public function gantipass()
    {
		$idx = Auth::user()->id;
		$queryxp = DB::select("select * from users where id='".$idx."'");
		$pageTitle = "Ganti Password";
        return view('gantipass',compact('pageTitle','queryxp'));
	}
	
	public function resetpass(Request $request)
    {
		$id_role = $request->id_role;
		$email = $request->email;
		if($id_role == 1){
			$ei = DB::select("select * from itdp_company_users where email='".$email."'");
			if(count($ei) != 0){
			foreach($ei as $ie){
				$d1 = $ie->id;
				$d2 = $ie->username;
				$d3 = $ie->email;
			}
			$data = ['username' => $d2, 'id2' => $d1, 'nama' => $d2, 'email' => $d3];

                Mail::send('UM.user.emailforget', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Forget Password');

                });
			}
		}else if($id_role == 1){
			$ei = DB::select("select * from itdp_admin_users where email='".$email."'");
			if(count($ei) != 0){
			foreach($ei as $ie){
				$d1 = $ie->id;
				$d2 = $ie->name;
				$d3 = $ie->email;
			}
			$data = ['username' => $d2, 'id2' => $d1, 'nama' => $d2, 'email' => $d3];

                Mail::send('UM.user.emailforget2', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Forget Password');

                });
			}
		}
		return redirect('');
	}
	
	public function updatepass1(Request $request,$id)
    {
		$update = DB::select("update itdp_company_users set password='".bcrypt($request->password)."' where id='".$request->ida."'");
		return redirect('login');
	}
	
	public function updatepass2(Request $request,$id)
    {
		$update = DB::select("update itdp_admin_users set password='".bcrypt($request->password)."' where id='".$request->ida."'");
		return redirect('login');
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
