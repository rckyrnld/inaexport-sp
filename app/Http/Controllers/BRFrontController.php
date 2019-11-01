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
    public function br_importir()
    {
        $pageTitle = "Buying Request Importer";
        return view('buying-request.br_importir',compact('pageTitle'));
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
		$update = DB::select("update csc_buying_request_join set status_join='2' where id='".$id."' ");
        return redirect('br_importir_lc/'.$id2);
    }
	
	public function br_importir_bc($id)
    {
		$insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('".$id."','40001','".Date('Y-m-d H:m:s')."')");
		$update = DB::select("update csc_buying_request set status='1' where id='".$id."'");
        return redirect('br_importir');
    }
	
	public function br_pw_bc($id)
    {
		$insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('".$id."','40001','".Date('Y-m-d H:m:s')."')");
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
		if(empty($request->file('doc'))){
			$file = "";
		}else{
			$file = $request->file('doc')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/buy_request";
			$request->file('doc')->move($destinationPath, $file);
		}
		$insert = DB::select("
			insert into csc_buying_request (subyek,valid,id_mst_country,city,id_csc_prod_cat,id_csc_prod_cat_level1,id_csc_prod_cat_level2,shipping,spec,files
			,eo,neo,tp,ntp,by_role,id_pembuat,date) values
			('".$request->subyek."','".$request->valid."','".$request->country."','".$request->city."','".$request->category."'
			,'".$request->t2s."','".$request->t3s."','".$request->ship."','".$request->spec."','".$file."','".$request->eo."','".$request->neo."'
			,'".$request->tp."','".$request->ntp."','3','".Auth::guard('eksmp')->user()->id."','".Date('Y-m-d H:m:s')."')");
		
		return redirect('br_importir');
	}
	
	
}
