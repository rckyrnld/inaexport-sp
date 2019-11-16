<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BuyingRequestController extends Controller
{
    public function index()
    {
		if(!empty(Auth::guard('eksmp')->user()->id)){
		if(Auth::guard('eksmp')->user()->id_role == 2){
		$pageTitle = "Buying Request Eksportir";
		$data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where a.id = b.id_br and b.id_eks='".Auth::guard('eksmp')->user()->id."' order by b.id desc ");
        return view('buying-request.index_eks', compact('pageTitle','data'));
		}
		}else{
		if(Auth::user()->id_group == 4){
        $pageTitle = "Buying Request Perwakilan";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.*,b.id as idb from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
        return view('buying-request.index', compact('pageTitle','data'));
		}else{
		$pageTitle = "Buying Request Admin";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
        return view('buying-request.indexadmin', compact('pageTitle','data'));
		}
		}
    }
	
	public function getcsc()
    {
        $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request where by_role='4' order by id desc ");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return $pesan->subyek;
            })
			->addColumn('f2', function ($pesan) {
				 return "Valid until ".$pesan->valid." days";
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->date;
            })
			->addColumn('f4', function ($pesan) {
				$cr = explode(',',$pesan->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				return $semuacat;
            })
			->addColumn('f6', function ($pesan) {
				if($pesan->by_role == 4){
					return "Perwakilan";
				}else if($pesan->by_role == 3){
					return "Importir";
				}
            })
			->addColumn('f7', function ($pesan) {
				if($pesan->status == 1){
					return "Negosiation";
				}else if($pesan->status == 4){
					return "Deal";
				}else{
					return "-";
				}
				 
            })
            ->addColumn('action', function ($pesan) {
				if($pesan->status == 1){
					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-primary"><i class="fa fa-comment"></i> List Chat</a>';
				}else if($pesan->status == 4){
					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-success"><i class="fa fa-list"></i> List Chat</a>';
				}else{
					return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy('.$pesan->id.')" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i> Broadcast</i></a>
					<a href="'.url('br_pw_dt/'.$pesan->id).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Detail</a>';
				}
                
				
				
           
                
            })
			->rawColumns(['action','f6','f7','f3','f4'])
            ->make(true);
    }
	
	public function getcsc0()
    {
        $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request where by_role='1' order by id desc ");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return $pesan->subyek;
            })
			->addColumn('f2', function ($pesan) {
				 return "Valid until ".$pesan->valid." days";
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->date;
            })
			->addColumn('f4', function ($pesan) {
				 $cr = explode(',',$pesan->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				return $semuacat;
            })
			->addColumn('f6', function ($pesan) {
				if($pesan->by_role == 4){
					return "Perwakilan";
				}else if($pesan->by_role == 3){
					return "Importir";
				}
            })
			->addColumn('f7', function ($pesan) {
				if($pesan->status == 1){
					return "Negosiation";
				}else if($pesan->status == 4){
					return "Deal";
				}else{
					return "-";
				}
				 
            })
            ->addColumn('action', function ($pesan) {
				if($pesan->status == 1){
					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-primary"><i class="fa fa-comment"></i> List Chat</a>';
				}else if($pesan->status == 4){
					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-success"><i class="fa fa-list"></i> List Chat</a>';
				}else{
					return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy('.$pesan->id.')" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i> Broadcast</i></a>
					<a href="'.url('br_pw_dt/'.$pesan->id).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Detail</a>';
				}
                
				
				
           
                
            })
			->rawColumns(['action','f6','f7','f3','f4'])
            ->make(true);
    }
	public function getcsc3()
    {
        $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request where by_role='3' order by id desc ");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return $pesan->subyek;
            })
			->addColumn('f2', function ($pesan) {
				 return "Valid until ".$pesan->valid." days";
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->date;
            })
			->addColumn('f4', function ($pesan) {
				$cr = explode(',',$pesan->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				return $semuacat;
            })
			->addColumn('f6', function ($pesan) {
				if($pesan->by_role == 4){
					return "Perwakilan";
				}else if($pesan->by_role == 3){
					return "Importir";
				}
            })
			->addColumn('f7', function ($pesan) {
				if($pesan->status == 1){
					return "Negosiation";
				}else if($pesan->status == 4){
					return "Deal";
				}else{
					return "-";
				}
				 
            })
            ->addColumn('action', function ($pesan) {
				if($pesan->status == 1){
					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-primary"><i class="fa fa-comment"></i> List Chat</a>';
				}else if($pesan->status == 4){
					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-success"><i class="fa fa-list"></i> List Chat</a>';
				}else{
					return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy('.$pesan->id.')" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i> Broadcast</i></a>
					<a href="'.url('br_pw_dt/'.$pesan->id).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Detail</a>';
				}
                
				
				
           
                
            })
			->rawColumns(['action','f6','f7','f3','f4'])
            ->make(true);
    }
	
	public function add()
    {
        $pageTitle = "Add Buying Request Perwakilan";
		return view('buying-request.add', compact('pageTitle'));
    }
	
	public function br_pw_lc($id)
    {
		$pageTitle = "List Chat Request Perwakilan";
		return view('buying-request.lc', compact('id','pageTitle'));
	}
	
	public function br_pw_dt($id)
    {
		$pageTitle = "List Chat Request Perwakilan";
		return view('buying-request.dt', compact('id','pageTitle'));
	}
	
	public function br_join($id)
    {
		$pageTitle = "Join Buying Request Eksportir";
		return view('buying-request.join', compact('id','pageTitle'));
	}
	
	public function simpanchatbr($id,$id2,$id3,$id4,$id5,$id6)
    {
	date_default_timezone_set('Asia/Jakarta');
		$a = $_GET['a'];
		$insert = DB::select("
			insert into csc_buying_request_chat (id_br,pesan,tanggal,id_pengirim,id_role,username_pengirim,id_join) values
			('".$id2."','".$a."','".Date('Y-m-d H:m:s')."','".$id4."','".$id3."','".$id5."','".$id6."')");
	}	
	public function br_trx($id,$id2)
    {
		$pageTitle = "Transaksi Buying Request";
		return view('buying-request.trx', compact('id','pageTitle','id2'));
	}	
	public function br_deal($id,$id2,$id3)
    {
		$update = DB::select("update csc_buying_request_join set status_join='4' where id='".$id."' ");
		$update2 = DB::select("update csc_buying_request set status='4', deal='".$id3."' where id='".$id2."' ");
		return redirect('br_trx/'.$id2.'/'.$id);
	}	
	public function br_chat($id)
    {
		$pageTitle = "Chat Buying Request Eksportir";
		return view('buying-request.chat', compact('id','pageTitle'));
	}
	
	public function br_pw_chat($id)
    {
		$pageTitle = "Chat Buying Request Perwakilan";
		return view('buying-request.chat2', compact('id','pageTitle'));
	}
	
	public function br_save_join($id)
    {
		$update = DB::select("update csc_buying_request_join set status_join='1' where id='".$id."' ");
		return redirect('br_list');
	}
	
	public function ambilt2($id)
    {
		return view('buying-request.t2', compact('id'));
	}
	
	public function ambilt3($id)
    {
		return view('buying-request.t3', compact('id'));
	}
	
	public function br_save(Request $request)
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
			('".$request->cmp."','".$request->valid."','".$request->country."','".$request->city."','".$h[0]."'
			,'0','0','".$request->ship."','".$request->spec."','".$file."','".$request->eo."','".$request->neo."'
			,'".$request->tp."','".$request->ntp."','".Auth::user()->id_group."','".Auth::user()->id."','".Date('Y-m-d H:m:s')."','".$kumpulcat."')");
		
		return redirect('br_list');
	}
	
	public function br_save_trx(Request $request)
    {
		$update = DB::select("update csc_buying_request set status_trx='".$request->tipekirim."', type_tracking='".$request->type_tracking."',no_track='".$request->no_track."' where id='".$request->id1."' ");
		return redirect('br_list');
	}


}
