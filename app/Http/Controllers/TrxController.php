<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrxController extends Controller
{
    public function index()
    {
		if(!empty(Auth::guard('eksmp')->user()->id)){
		if(Auth::guard('eksmp')->user()->id_role == 2){
		$pageTitle = "Selling Transaction Eksportir";
		$data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where  b.status_join='4' and  a.id = b.id_br and b.id_eks='".Auth::guard('eksmp')->user()->id."' order by b.id desc ");
        return view('trx.index_eks', compact('pageTitle','data'));
		}else if(Auth::guard('eksmp')->user()->id_role == 3){
		$pageTitle = "Selling Transaction Admin";
		$data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where   b.status_join='4' and  a.id = b.id_br order by b.id desc ");
        return view('trx.index_imp', compact('pageTitle','data'));	
		}
		}else{
		if(Auth::user()->id_group == 4){
        $pageTitle = "Selling Transaction Perwakilan";
		$data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where   b.status_join='4' and  a.id = b.id_br order by b.id desc ");
        return view('trx.index_adm', compact('pageTitle','data'));
		}else{
		$pageTitle = "Selling Transaction Admin";
		$data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where   b.status_join='4' and  a.id = b.id_br order by b.id desc ");
        return view('trx.index_adm', compact('pageTitle','data'));
		}
		}
    }
	
	public function detailtrx($ida,$idb)
    {
		return view('trx.detailtrx', compact('pageTitle','data'));
	}
	
	public function data_br3()
    {
        
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row,a.*,a.id as ida,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where a.id_pembuat='".Auth::guard('eksmp')->user()->id."' and  b.status_join='4' and  a.id = b.id_br ");
      

        return DataTables::of($buy)
            ->addColumn('col1', function ($buy) {
				 return $buy->subyek;
            })
			->addColumn('col2', function ($buy) {
				/*
				$cr = explode(',',$buy->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				return $semuacat;
				*/
				$carieks = DB::select("select * from itdp_company_users where id='".$buy->id_eks."'"); 
									foreach($carieks as $eks){ $rty=  $eks->username; }
				return $rty;
            })
			->addColumn('col3', function ($buy) {
				 return $buy->date;
            })
			->addColumn('col4', function ($buy) {
				 if($buy->status_trx == 1){
					return "<font color='green'>Already Sent</font>";
				 }else{
					return "<font color='orange'>On Process</font>";
				 }
            })
			->addColumn('col5', function ($buy) {
				 return $buy->no_track;
				 
            })
			->addColumn('col6', function ($buy) {
				 return '<center><a href="'.url('detailtrx/'.$buy->ida.'/'.$buy->idb).'" class="btn btn-sm btn-success">View</a></center>';
            })
			
			
			->rawColumns(['col4','col5','col2','col6'])
            ->make(true);
    }
	
	


}
