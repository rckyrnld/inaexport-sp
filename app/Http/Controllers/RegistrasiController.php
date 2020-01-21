<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Yajra\DataTables\Facades\DataTables;

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
	
	public function cekmail($id)
    {
		$cek = DB::select("select * from itdp_company_users where email='".$id."'");
		if(count($cek) == 0){
			return "0";
		}else{
			return "1";
		}
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
			('".$id1."','".$request->username."','".bcrypt($request->password)."','".$request->email."','0','3','Dalam Negeri')
		");
		$ambilmaxid2 = DB::select("select max(id) as maxid2 from itdp_company_users");
		foreach($ambilmaxid2 as $rt2){
			$id2 = $rt2->maxid2;
		}
		// notif 
		$id_terkait = "3/".$id2;
		$ket = "New user Indonesian Exporter with name ".$request->company;
		$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('1','".$request->company."','".$id1."','Super Admin','1','".$ket."','profil2','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
		");
		
		//notif untuk perwakilan
		$carigc = DB::select("select * from mst_country where id='".$request->country."'");
		foreach($carigc as $gccari){  $groupcountry = $gccari->mst_country_group_id; }
		$qr = DB::select("select a.* from itdp_admin_users a, itdp_admin_ln b  where a.id_admin_ln = b.id and b.id_country='".$groupcountry."'");
		foreach($qr as $rq){
			$insertpw = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('4','".$request->company."','".$id1."','Perwakilan','".$rq->id."','".$ket."','profil2','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
			");
			$data3 = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => $rq->email, 'type' => 'Exporter'];

                Mail::send('UM.user.emailsadmin', $data3, function ($mail) use ($data3) {
                    $mail->to($data3['email'], $data3['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
		    }
		
			
			$data = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => $request->email];

                Mail::send('UM.user.emailsuser2', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
			
			$data2 = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => env('MAIL_USERNAME','admin@inaexport.id'),'type' => 'Exporter'];

                Mail::send('UM.user.emailsadmin', $data2, function ($mail) use ($data2) {
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
		
//		//notif untuk perwakilan
//		$qr = DB::select("select a.* from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and b.id_country='".$request->prov."'");
//		// echo "select a.* from itdp_admin_users a, itdp_admin_dn b where a.id_admin_dn = b.id and b.id_country='".$request->prov."'";die();
//		foreach($qr as $rq){
//			$insertpw = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//			('4','".$request->company."','".$id1."','Perwakilan','".$rq->id."','".$ket."','profil','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
//			");
//			$data3 = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => $rq->email];
//
//                Mail::send('UM.user.emailsperwakilan', $data3, function ($mail) use ($data3) {
//                    $mail->to($data3['email'], $data3['username']);
//                    $mail->subject('Notifikasi Aktifasi Akun');
//
//                });
//		}
		
			
			$data = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => $request->email, 'user' => 'exporter', 'type'=> 'Indonesian Exporter'];

                Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });

//			$data2 = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => 'kementerianperdagangan.max@gmail.com'];
			$data2 = ['username' => $request->username, 'id2' => $id2, 'company' => $request->company, 'password' => $request->password, 'email' => env('MAIL_USERNAME','admin@inaexport.id'),'type'=> 'Indonesian Exporter'];

                Mail::send('UM.user.emailsadmin', $data2, function ($mail) use ($data2) {
                    $mail->to($data2['email'], $data2['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
        return view('auth.waitmail',compact('pageTitle'));
    }
	
	public function data_br2()
    {
        
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row,* from csc_buying_request");
      

        return DataTables::of($buy)
			->addColumn('row', function ($buy) {
				 return "<center>".$buy->row."</center>";
            })
            ->addColumn('col1', function ($buy) {
				 return $buy->subyek;
            })
			->addColumn('col2', function ($buy) {
				$cr = explode(',',$buy->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					if(count($namaprod) != 0){
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
					}
				}
				return $semuacat;
            })
			->addColumn('col3', function ($buy) {
				 return $buy->date;
            })
			->addColumn('col4', function ($buy) {
				 return 'Valid '.$buy->valid." days";
            })
			->addColumn('col5', function ($buy) {
				 if($buy->deal == null || $buy->deal == 0 || empty($buy->deal)){
					return "Negosiation";
				 }else{
					return "Deal";
				 }
            })
			->addColumn('col6', function ($buy) {
				 if($buy->by_role == 3){
					return "Importir";
				 }else if($buy->by_role == 4){
					return "Perwakilan";
				 }else if($buy->by_role == 1){
					return "Admin";
				 }else{
					 return "";
				 }
            })
			
			
			->rawColumns(['col4','col5','col2','col6','row'])
            ->make(true);
    }
	
	public function transaksibr()
    {
		
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
