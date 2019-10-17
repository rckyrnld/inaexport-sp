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
    public function registrasi_pembeli()
    {
        $pageTitle = "Registrasi Pembeli";
        return view('auth.register_pembeli',compact('pageTitle'));
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
			insert into itdp_profil_imp (company,addres,postcode,phone,fax,email,website,created,status) values
			('".$request->company."','".$request->alamat."','".$request->postcode."','".$request->phone."','".$request->fax."'
			,'".$request->email."','".$request->website."','".Date('Y-m-d H:m:s')."','1')
		");
		$ambilmaxid = DB::select("select max(id) as maxid from itdp_profil_imp");
		foreach($ambilmaxid as $rt){
			$id1 = $rt->maxid;
		}
		$insert2 = DB::select("
			insert into itdp_company_users (id_profil,username,password,email,status,id_role,type) values
			('".$id1."','".$request->username."','".bcrypt($request->password)."','".$request->email."','0','3','Dalam Negeri')
		");
		$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
		foreach($ambilmaxid2 as $rt2){
			$id2 = $rt2->maxid2;
		}
		// notif 
		$id_terkait = "3/".$id2;
		$ket = "User baru Importir dengan nama ".$request->company;
		$insert3 = DB::select("insert into notif (dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('".$request->company."','".$id1."','Super Admin','1','".$ket."','profil2','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
		");
		
			
			$data = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => $request->email];

                Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
        return view('auth.waitmail',compact('pageTitle'));
    }
	
	public function simpan_rpenjual(Request $request)
    {
		$insert1 = DB::select("
			insert into itdp_profil_eks (company,addres,postcode,phone,fax,email,website,created,status) values
			('".$request->company."','".$request->alamat."','".$request->postcode."','".$request->phone."','".$request->fax."'
			,'".$request->email."','".$request->website."','".Date('Y-m-d H:m:s')."','1')
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
		$insert3 = DB::select("insert into notif (dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('".$request->company."','".$id1."','Super Admin','1','".$ket."','profil','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
		");
		
			
			$data = ['username' => $request->username, 'id2' => $id2, 'nama' => $request->company, 'password' => $request->password, 'email' => $request->email];

                Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
        return view('auth.waitmail',compact('pageTitle'));
    }
	
	public function verifypembeli($id)
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
