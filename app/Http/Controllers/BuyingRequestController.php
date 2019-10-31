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
		$data = DB::select("select a.*,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where a.id = b.id_br and b.id_eks='".Auth::guard('eksmp')->user()->id."' order by b.id desc ");
        return view('buying-request.index_eks', compact('pageTitle','data'));
		}
		}else{
        $pageTitle = "Buying Request Perwakilan";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
        return view('buying-request.index', compact('pageTitle','data'));
		}
    }
	
	public function getcsc()
    {
        $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_inquiry_global order by id desc ");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return $pesan->company_name;
            })
			->addColumn('f2', function ($pesan) {
				 return $pesan->valid;
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->date;
            })
			->addColumn('f4', function ($pesan) {
				 $kat = $pesan->id_prod_kat;
				 $cardata = DB::select("select nama_kategori_en from csc_product where id='".$kat."'");
				 foreach($cardata as $ct){
					 $naka = $ct->nama_kategori_en;
				 }
				return $naka;
            })
			->addColumn('f6', function ($pesan) {
				return $pesan->spec;
            })
			->addColumn('f7', function ($pesan) {
				if($pesan->st_approve == 1){
					return "Valid";
				}else if($pesan->st_approve == 2){
					return "Not Valid";
				}else{
					return "Wait Verify";
				}
				 
            })
            ->addColumn('action', function ($pesan) {
           
                 
				return '<a href="'.url('/').'" class="btn btn-sm btn-success"><i class="fa fa-edit text-white"></i> Verify</a>';
				
           
                
            })
			->rawColumns(['action','f6','f7','f3','f4'])
            ->make(true);
    }
	
	public function add()
    {
        $pageTitle = "Add Buying Request Perwakilan";
		return view('buying-request.add', compact('pageTitle'));
    }
	
	public function br_join($id)
    {
		$pageTitle = "Join Buying Request Eksportir";
		return view('buying-request.join', compact('id','pageTitle'));
	}
	
	public function simpanchatbr($id,$id2,$id3,$id4,$id5)
    {
	date_default_timezone_set('Asia/Jakarta');
		$insert = DB::select("
			insert into csc_buying_request_chat (id_br,pesan,tanggal,id_pengirim,id_role,username_pengirim) values
			('".$id2."','".$id."','".Date('Y-m-d H:m:s')."','".$id4."','".$id3."','".$id5."')");
	}	
	public function br_deal($id,$id2,$id3)
    {
		$update = DB::select("update csc_buying_request_join set status_join='4' where id='".$id."' ");
		$update2 = DB::select("update csc_buying_request set status='4', deal='".$id3."' where id='".$id2."' ");
		return redirect('br_list');
	}	
	public function br_chat($id)
    {
		$pageTitle = "Chat Buying Request Eksportir";
		return view('buying-request.chat', compact('id','pageTitle'));
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
		if(empty($request->file('doc'))){
			$file = "";
		}else{
			$file = $request->file('doc')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/buy_request";
			$request->file('doc')->move($destinationPath, $file);
		}
		$insert = DB::select("
			insert into csc_inquiry_global (company_name,valid,id_mst_country,city,id_prod_kat,id_prod_sub1_kat,id_prod_sub2_kat,shipping,spec,files
			,eo,neo,tp,ntp,by_role,by_user,date) values
			('".$request->cmp."','".$request->valid."','".$request->country."','".$request->city."','".$request->category."'
			,'".$request->t2s."','".$request->t3s."','".$request->ship."','".$request->spec."','".$file."','".$request->eo."','".$request->neo."'
			,'".$request->tp."','".$request->ntp."','4','".Auth::user()->id."','".Date('Y-m-d H:m:s')."')");
		
		return redirect('br_list');
	}


}
