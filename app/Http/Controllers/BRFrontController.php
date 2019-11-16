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
        return view('frontend.indexbr', compact('product', 'categoryutama','r'));
		}else{
		$r = "2";
		$categoryutama = "";
        return view('frontend.indexbr', compact('product', 'categoryutama','r'));
		}
		}else{
		$r = "2";
		$categoryutama = "";
		return view('frontend.indexbr', compact('product', 'categoryutama','r'));
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
	
	public function br_konfirm($id,$id2)
    {
		$crv = DB::select("select * from csc_buying_request where id='".$id2."'");
		foreach($crv as $cr){ $vld = $cr->valid; }
		$dy = $vld." day";
		$besok = date('Y-m-d', strtotime($dy, strtotime(date("Y-m-d"))));
		$update = DB::select("update csc_buying_request_join set status_join='2', expired_at='".$besok."' where id='".$id."' ");
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
				foreach($caridataeks as $vm){ $vc1 = $vm->email; }
				$data = ['username' => $namapembuat, 'id2' => '0', 'nama' => $namapembuat, 'password' => '', 'email' => $vc1];

                Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Buying Was Created');

                });
				//END EMAIL
			}else{
				
			}
		}
		}
		}
		$update = DB::select("update csc_buying_request set status='1' where id='".$id."'");
        return redirect('br_importir');
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
				foreach($caridataeks as $vm){ $vc1 = $vm->email; }
				$data = ['username' => $namapembuat, 'id2' => '0', 'nama' => $namapembuat, 'password' => '', 'email' => $vc1];

                Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Buying Was Created');

                });
				//END EMAIL
			}else{
				
			}
		}
		}
		}
		$update = DB::select("update csc_buying_request set status='1' where id='".$id."'");
        return redirect('br_list');
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
			$idq = $request->idq;
			$idb = $request->idb;
			$idc = $request->idc;
			$file = $request->file('filez')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/pop";
			$request->file('filez')->move($destinationPath, $file);
			$insert = DB::select("
			insert into csc_buying_request_chat (id_br,pesan,tanggal,id_pengirim,id_role,username_pengirim,id_join,files) values
			('".$idq."','".$request->catatan."','".Date('Y-m-d H:m:s')."','".$request->idc."','".$request->ide."','".$request->idd."','".$idb."','".$file."')");
			
			return redirect('br_importir_chat/'.$idq.'/'.$idb);
	}	
	
	public function br_importir_save(Request $request)
    {
		$kumpulcat = "";
		$g = count($request->category);
		for($a = 0; $a < $g; $a++){
			$kumpulcat= $kumpulcat.$request->category[$a].",";
		}
		$h = explode(",",$kumpulcat);
		
		if(empty($request->file('doc'))){
			$file = "";
		}else{
			$file = $request->file('doc')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/buy_request";
			$request->file('doc')->move($destinationPath, $file);
		}
		$insert = DB::select("
			insert into csc_buying_request (subyek,valid,id_mst_country,city,id_csc_prod_cat,id_csc_prod_cat_level1,id_csc_prod_cat_level2,shipping,spec,files
			,eo,neo,tp,ntp,by_role,id_pembuat,date,id_csc_prod) values
			('".$request->subyek."','".$request->valid."','".$request->country."','".$request->city."','".$h[0]."'
			,'0','0','".$request->ship."','".$request->spec."','".$file."','".$request->eo."','".$request->neo."'
			,'".$request->tp."','".$request->ntp."','3','".Auth::guard('eksmp')->user()->id."','".Date('Y-m-d H:m:s')."','".$kumpulcat."')");
		
		return redirect('br_importir');
	}
	
	
}
