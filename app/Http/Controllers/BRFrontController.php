<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class BRFrontController extends Controller
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
    public function br_importir_all()
    {
        /*$pageTitle = "Buying Request Importer";
        return view('buying-request.br_importir',compact('pageTitle')); */
		 $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            // ->where('csc_product_single.status', 2)
            ->orderby('csc_product_single.id', 'DESC')
            // ->inRandomOrder()
            ->limit(10)
            ->get();

        // $service = DB::table('itdp_service_eks as a')->where('status', 2)->orderBy('created_at', 'desc')->get();
        //Category Utama
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(9)
            ->get();
        return view('frontend.indexbr_all', compact('product', 'categoryutama'));
    }
	
	public function br_importir()
    {
		$subyek = "";
		$valid = "";
		$spec = "";
		$eo = "";
		$neo = "";
		$tp = "";
		$ntp = "";
		if(empty(Auth::guard('eksmp')->user()->id) && empty(Auth::user()->name)){
		// echo "a";die();
		$r = "2";
		$categoryutama = "";
        return view('frontend.indexbr', compact('product', 'categoryutama','r','subyek','valid','spec','eo','neo','tp','ntp'));
		
		}else{
		if(!empty(Auth::guard('eksmp')->user()->id)){
		if(Auth::guard('eksmp')->user()->id_role == 3){
        /*$pageTitle = "Buying Request Importer";
        return view('buying-request.br_importir',compact('pageTitle')); */
		 $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            // ->where('csc_product_single.status', 2)
            ->orderby('csc_product_single.id', 'DESC')
            // ->inRandomOrder()
            ->limit(10)
            ->get();

        // $service = DB::table('itdp_service_eks as a')->where('status', 2)->orderBy('created_at', 'desc')->get();
        //Category Utama
		$r = "1";
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(9)
            ->get();
        return view('frontend.indexbr', compact('product', 'categoryutama','r','subyek','valid','spec','eo','neo','tp','ntp'));
		}else{
		$r = "2";
		$categoryutama = "";
        return view('frontend.indexbr', compact('product', 'categoryutama','r','subyek','valid','spec','eo','neo','tp','ntp'));
		}
		}else{
		$r = "2";
		$categoryutama = "";
		return view('frontend.indexbr', compact('product', 'categoryutama','r','subyek','valid','spec','eo','neo','tp','ntp'));
		}
		}
		
    }

	public function br_importir_add()
    {
        $pageTitle = "Buying Request Importer";
        return view('buying-request.br_importir_add',compact('pageTitle'));
    }
	
	public function br_importir_detail($id)
    {
        $pageTitle = "Detail Buying Request Importer";
        return view('buying-request.br_importir_detail',compact('pageTitle','id'));
    }
	
	public function br_importir_chat($id,$idb)
    {
        $pageTitle = "Chat Buying Request Importer";
        return view('buying-request.br_importir_chat',compact('pageTitle','id','idb'));
    }
	
	public function br_importir_lc($id)
    {
        $pageTitle = "List Chat Buying Request Importer";
        return view('buying-request.br_importir_lc',compact('pageTitle','id'));
    }
	
	public function refreshchat($id,$id2)
    {
		return view('buying-request.refresh',compact('id','id2'));
	}
	
	public function refreshchat2($id,$id2)
    {
		return view('buying-request.refresh2',compact('id','id2'));
	}
	
	public function refreshchat3($id,$id2)
    {
		return view('buying-request.refresh3',compact('id','id2'));
	}
	
	public function br_konfirm($id,$id2)
    {
		date_default_timezone_set('Asia/Jakarta');
		$crv = DB::select("select * from csc_buying_request where id='".$id2."'");
		foreach($crv as $cr){ $vld = $cr->valid; }
		$dy = $vld." day";
		$besok = date('Y-m-d', strtotime($dy, strtotime(date("Y-m-d"))));
		
		
		$caribrsl = DB::select("select * from csc_buying_request_join where id='".$id."'");
		foreach($caribrsl as $val1){
			$data1 = $val1->id_eks;
			$data2 = $val1->id_br;
		}
		$caribrs2 = DB::select("select * from csc_buying_request where id='".$data2."'");
		foreach($caribrs2 as $val2){
			$data3 = $val2->id_pembuat;
		}
		$caribrs3 = DB::select("select * from itdp_company_users where id='".$data1."'");
		foreach($caribrs3 as $val3){
			$data4 = $val3->email;
		}
		
		$ket = Auth::guard('eksmp')->user()->username." Verified Buying Request!";
		$insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
		('2','Importir','".Auth::guard('eksmp')->user()->id."','Eksportir','".$data1."','".$ket."','br_chat','".$id."','".Date('Y-m-d H:m:s')."','0')
		");
		
		$ket2 = Auth::guard('eksmp')->user()->username." Verified Buying Request!";
		$insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
		('1','Importir','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket2."','br_pw_lc','".$id2."','".Date('Y-m-d H:m:s')."','0')
		");
		
		$data = [
            'email' => "",
            'email1' => $data4,
            'username' => Auth::guard('eksmp')->user()->username,
            'main_messages' => "",
            'id' => $id
			];
		Mail::send('UM.user.sendbrchat', $data, function ($mail) use ($data) {
        $mail->to($data['email1'], $data['username']);
        $mail->subject('Impotir Verified Buying Request');
		});
		
		$data22 = [
            'email' => "",
            'email1' => Auth::guard('eksmp')->user()->email,
            'username' => Auth::guard('eksmp')->user()->username,
            'main_messages' => Auth::guard('eksmp')->user()->username,
            'id' => $id,
            'id2' => $id2
		];
			
		Mail::send('UM.user.sendbrchat2', $data22, function ($mail) use ($data22) {
            $mail->to($data22['email1'], $data22['username']);
            $mail->subject('You Verified Buying Request');
		});
		
		$data33 = [
            'email' => "",
            'email1' => "kementerianperdagangan.max@gmail.com",
            'username' => Auth::guard('eksmp')->user()->username,
            'main_messages' => Auth::guard('eksmp')->user()->username,
            'id' => $id,
            'id2' => $id2
		];
			
		Mail::send('UM.user.sendbrchat3', $data33, function ($mail) use ($data33) {
            $mail->to($data33['email1'], $data33['username']);
            $mail->subject('Importir Verified Join Buying Request');
		});
		
		$update = DB::select("update csc_buying_request_join set status_join='2', expired_at='".$besok."' where id='".$id."' ");
		
		//log
		$insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('".Auth::guard('eksmp')->user()->email."','".date('H:i:s')."','".date('Y-m-d')."','','".Auth::guard('eksmp')->user()->id_role."'
			,'".Auth::guard('eksmp')->user()->id."','4','verification join buying request')");
		
		//end log
        return redirect('br_importir_lc/'.$id2);
    }
	
	public function br_konfirm2($id,$id2)
    {
		$crv = DB::select("select * from csc_buying_request where id='".$id2."'");
		foreach($crv as $cr){ $vld = $cr->valid; }
		$dy = $vld." day";
		$besok = date('Y-m-d', strtotime($dy, strtotime(date("Y-m-d"))));
		$update = DB::select("update csc_buying_request_join set status_join='2', expired_at='".$besok."' where id='".$id."' ");
        return redirect('br_pw_lc/'.$id2);
    }
	
	public function br_importir_bc($id)
    {
		
		date_default_timezone_set('Asia/Jakarta');
		$cariprod = DB::select("select * from csc_buying_request where id='".$id."'");
		foreach($cariprod as $prodcari) { $rrr = $prodcari->id_csc_prod; $zzz = $prodcari->id_pembuat; }
		$namacom = DB::select("select * from itdp_company_users where id='".$zzz."'");
		foreach($namacom as $comnama){ $namapembuat = $comnama->username; }
		$cr = explode(',',$rrr);
		$hitung = count($cr);
		$semuacat = "";
		for($a = 0; $a < ($hitung - 1); $a++){
		//echo $rrr;die();
		// echo "select * from csc_product_single where id_csc_product='".$cr[0]."' or id_csc_product_level1='".$cr[0]."' or id_csc_product_level2='".$cr[0]."'";die();
		$namaprod = DB::select("select * from csc_product_single where id_csc_product='".$cr[$a]."' or id_csc_product_level1='".$cr[$a]."' or id_csc_product_level2='".$cr[$a]."' ");
		if(count($namaprod) == 0){
		
		}else{
		foreach($namaprod as $prod){ $napro = $prod->id_itdp_company_user; 
			$cekada=DB::select("select * from csc_buying_request_join where id_br='".$id."' and id_eks='".$napro."'");
			if(count($cekada) == 0){
				
				$insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('".$id."','".$napro."','".Date('Y-m-d H:m:s')."')");
				
				//NOTIF
				$id_terkait = "";
				$ket = "Buying Request created by ".$namapembuat;
				$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
					('2','".$namapembuat."','".$zzz."','Eksportir','".$napro."','".$ket."','br_list','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
				");
				//END NOTIF
				//EMAIL
				$caridataeks = DB::select("select * from itdp_company_users where id='".$napro."'");
				if(count($caridataeks) != 0){
				foreach($caridataeks as $vm){ $vc1 = $vm->email; }
				$data = ['username' => $namapembuat, 'id2' => '0', 'nama' => $namapembuat, 'company' => $namapembuat, 'password' => '', 'email' => $vc1];

                Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Buying Was Created');

                });
				}
				//END EMAIL
			}else{
				
			}
		}
		}
		}
		$update = DB::select("update csc_buying_request set status='1' where id='".$id."'");
		
		//log
		$insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('".Auth::guard('eksmp')->user()->email."','".date('H:i:s')."','".date('Y-m-d')."','','".Auth::guard('eksmp')->user()->id_role."'
			,'".Auth::guard('eksmp')->user()->id."','4','broadcast buying request')");
		
		//end log
		
        return redirect('front_end/history')->with('prioritasnya','yayayayaya');
    }
	
	public function br_pw_bc($id)
    {
		/*
		$insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('".$id."','40001','".Date('Y-m-d H:m:s')."')");
		$update = DB::select("update csc_buying_request set status='1' where id='".$id."'");
        return redirect('br_list');
		*/
		$cariprod = DB::select("select * from csc_buying_request where id='".$id."'");
		foreach($cariprod as $prodcari) { $rrr = $prodcari->id_csc_prod; $zzz = $prodcari->id_pembuat; }
		$namacom = DB::select("select * from itdp_admin_users where id='".$zzz."'");
		foreach($namacom as $comnama){ $namapembuat = $comnama->name; }
		$cr = explode(',',$rrr);
		$hitung = count($cr);
		$semuacat = "";
		for($a = 0; $a < ($hitung - 1); $a++){
		//echo $rrr;die();
		// echo "select * from csc_product_single where id_csc_product='".$cr[0]."' or id_csc_product_level1='".$cr[0]."' or id_csc_product_level2='".$cr[0]."'";die();
		$namaprod = DB::select("select * from csc_product_single where id_csc_product='".$cr[$a]."' or id_csc_product_level1='".$cr[$a]."' or id_csc_product_level2='".$cr[$a]."' ");
		if(count($namaprod) == 0){
		
		}else{

		foreach($namaprod as $prod){
		    $napro = $prod->id_itdp_company_user;
//            dd($napro);
            $cekada=DB::select("select * from csc_buying_request_join where id_br='".$id."' and id_eks='".(int)$napro."'");
//			$cekada=DB::select("select * from csc_buying_request_join where id_br='".$id."' and id_eks='".$napro."'");
			if(count($cekada) == 0){

				$insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('".$id."','".(int)$napro."','".Date('Y-m-d H:m:s')."')");

				//NOTIF
				$id_terkait = "";
				$ket = "Buying Request created by ".$namapembuat;
				$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
					('2','".$namapembuat."','".$zzz."','Eksportir','".$napro."','".$ket."','br_list','".$id_terkait."','".Date('Y-m-d H:m:s')."','0')
				");
				//END NOTIF
				//EMAIL
				$caridataeks = DB::select("select * from itdp_company_users where id='".$napro."'");
				if(count($caridataeks) != 0){
				foreach($caridataeks as $vm){ $vc1 = $vm->email; }
                $datacomeks = DB::select("select * from itdp_profil_eks where id = '".$vm->id_profil."'");
//				dd($datacomeks[0]->company);
				$data = [
				    'username' => $namapembuat,
                    'id2' => '0', 'nama' => $namapembuat,
                    'password' => '',
                    'email' => $vc1,
                    'company' => $datacomeks[0]->company
                ];
                Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['company']);
                    $mail->subject('Buying Was Created');
                });
				}
				//END EMAIL
			}else{
				
			}
		}
		}
		}
		$update = DB::select("update csc_buying_request set status='1' where id='".$id."'");
        return redirect('br_list')->with('success','Success Broadcast Data');
    }
	
	public function ambilbroad($id)
    {
        return view('buying-request.broad', compact('id'));
    }
	
	public function ambilbroad2($id)
    {
        return view('buying-request.broad2', compact('id'));
    }
	
	public function uploadpop(Request $request)
    {		
			date_default_timezone_set('Asia/Jakarta');
			$cari = DB::select("select * from csc_buying_request_join where id='".$request->idb."'");
			foreach($cari as $cr1){
				$data1 = $cr1->id_eks;
			}
			$cari2 = DB::select("select * from itdp_company_users where id='".$data1."'");
			foreach($cari2 as $cr2){
				$data2 = $cr2->email;
			}
			
			$ket = "Importir ".Auth::guard('eksmp')->user()->username." Upload Invoice On Buying Request !";
			$it = $request->idb;
			$it2 = $request->idq."/".$request->idb;
			$insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('2','Importir','".Auth::guard('eksmp')->user()->id."','Eksportir','".$data1."','".$ket."','br_chat','".$it."','".Date('Y-m-d H:i:s')."','0')
			");
		
			$ket2 = "Impotir ".Auth::guard('eksmp')->user()->username." Upload Invoice On Buying Request !";
			$insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('1','Importir','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket2."','br_pw_chat','".$it."','".Date('Y-m-d H:i:s')."','0')
			");
			
			$ket3 = "You Had Uploaded Invoice On Buying Request !";
			$insertnotif3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('3','Importir','".Auth::guard('eksmp')->user()->id."','Importir','".Auth::guard('eksmp')->user()->id."','".$ket3."','br_importir_chat','".$it2."','".Date('Y-m-d H:i:s')."','0')
			");
			
			
			
			// echo "die";die();
			
			$idq = $request->idq;
			$idb = $request->idb;
			$idc = $request->idc;
			$file = $request->file('filez')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/pop";
			$request->file('filez')->move($destinationPath, $file);
			$insert = DB::select("
			insert into csc_buying_request_chat (id_br,pesan,tanggal,id_pengirim,id_role,username_pengirim,id_join,files) values
			('".$idq."','".$request->catatan."','".Date('Y-m-d H:i:s')."','".$request->idc."','".$request->ide."','".$request->idd."','".$idb."','".$file."')");
			
			return redirect('br_importir_chat/'.$idq.'/'.$idb);
	}
	
	public function uploadpop2(Request $request)
    {		
			date_default_timezone_set('Asia/Jakarta');
			$cari = DB::select("select * from csc_buying_request_join where id='".$request->idq."'");
			foreach($cari as $cr1){
				$data1 = $cr1->id_eks;
			}
			//echo $data1;die();
			$cari2 = DB::select("select * from itdp_company_users where id='".$data1."'");
			foreach($cari2 as $cr2){
				$data2 = $cr2->email;
			}
			$idq = $request->idq;
			$idb = $request->idb;
			$idc = $request->idc;
			$file = $request->file('filez')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/pop";
			$request->file('filez')->move($destinationPath, $file);
			$insert = DB::select("
			insert into csc_buying_request_chat (id_br,pesan,tanggal,id_pengirim,id_role,username_pengirim,id_join,files) values
			('".$idb."','".$request->catatan."','".Date('Y-m-d H:i:s')."','".$request->idc."','".$request->ide."','".$request->idd."','".$idq."','".$file."')");
			
			if($request->ide == 1){
			$ket = "Super Admin Upload Invoice On Buying Request";
			$it = $request->idq;
			$it2 = $request->idq."/".$request->idb;
			$insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('2','Admin','1','Eksportir','".$data1."','".$ket."','br_chat','".$it."','".Date('Y-m-d H:i:s')."','0')
			");

			}else{
			$ket = "Perwakilan Upload Invoice On Buying Request";
			$it = $request->idq;
			$it2 = $request->idq."/".$request->idb;
			$insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
			('2','Admin','1','Eksportir','".$data1."','".$ket."','br_chat','".$it."','".Date('Y-m-d H:i:s')."','0')
			");
			}
			
			
			
			return redirect('br_pw_chat/'.$idq);
	}	
	
	public function br_importir_next(Request $request)
    {
		$subyek = $request->subyek;
		$valid = $request->valid;
		$spec = $request->spec;
		$eo = $request->eo;
		$neo = $request->neo;
		$ch1 = str_replace(".","",$request->tp);
		$tp = str_replace(",",".",$ch1);
		$ntp = $request->ntp;
		$product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            // ->where('csc_product_single.status', 2)
            ->orderby('csc_product_single.id', 'DESC')
            // ->inRandomOrder()
            ->limit(10)
            ->get();

        // $service = DB::table('itdp_service_eks as a')->where('status', 2)->orderBy('created_at', 'desc')->get();
        //Category Utama
		$r = "1";
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(9)
            ->get();
        return view('frontend.indexbr', compact('product', 'categoryutama','r','subyek','valid','spec','eo','neo','tp','ntp'));
		
	}
	
	public function br_importir_update(Request $request)
    {
		$id_br = $request->id_br;
		$ch1 = str_replace(".","",$request->tp);
		$ch2 = str_replace(",",".",$ch1);
		
		$kumpulcat = $request->category;
		$kumpulcat2 = $request->category.",";
		$h = explode(",",$request->category);
		// echo $kumpulcat2;die();
		if(empty($request->file('image'))){
			$file = "";
		}else{
			$file = $request->file('image')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/buy_request";
			$request->file('image')->move($destinationPath, $file);
		}
		$insert = DB::select("update csc_buying_request set subyek='".$request->subyek."',valid='".$request->valid."',id_mst_country='".$request->country."'
								,shipping='".$request->ship."', spec='".$request->spec."', files='".$file."', eo ='".$request->eo."', neo='".$request->neo."'
								,tp='".$ch2."',ntp='".$request->ntp."',id_csc_prod='".$kumpulcat2."' where id='".$request->id_br."'");
		
		
		
		echo "<a href='".url('br_importir_bc/'.$id_br)."' class='btn btn-warning'><font color='white'>Broadcast</font></a>";
	
	}	
	public function br_importir_save(Request $request)
    {	
		date_default_timezone_set('Asia/Jakarta');
		$ch1 = str_replace(".","",$request->tp);
		$ch2 = str_replace(",",".",$ch1);
		
		$kumpulcat = $request->category;
		$kumpulcat2 = $request->category.",";
		$h = explode(",",$request->category);
		// echo $kumpulcat2;die();
		if(empty($request->file('image'))){
			$file = "";
		}else{
			$file = $request->file('image')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/buy_request";
			$request->file('image')->move($destinationPath, $file);
		}
		$insert = DB::select("
			insert into csc_buying_request (subyek,valid,id_mst_country,city,id_csc_prod_cat,id_csc_prod_cat_level1,id_csc_prod_cat_level2,shipping,spec,files
			,eo,neo,tp,ntp,by_role,id_pembuat,date,id_csc_prod) values
			('".$request->subyek."','".$request->valid."','".$request->country."','".$request->city."','".$h[0]."'
			,'0','0','".$request->ship."','".$request->spec."','".$file."','".$request->eo."','".$request->neo."'
			,'".$ch2."','".$request->ntp."','3','".Auth::guard('eksmp')->user()->id."','".Date('Y-m-d H:m:s')."','".$kumpulcat2."')");
		
		$carimax = DB::select("select max(id) as maxid from csc_buying_request ");
		foreach($carimax as $cm){
			$maxid = $cm->maxid;
		}
		
		//log
		$insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('".Auth::guard('eksmp')->user()->email."','".date('H:i:s')."','".date('Y-m-d')."','','".Auth::guard('eksmp')->user()->id_role."'
			,'".Auth::guard('eksmp')->user()->id."','4','created buying request')");
		
		//end log
		
		echo "<a href='".url('br_importir_bc/'.$maxid)."' class='btn btn-warning'><font color='white'>Broadcast</font></a>";
		//return redirect('br_importir');
	}
	
	
}
