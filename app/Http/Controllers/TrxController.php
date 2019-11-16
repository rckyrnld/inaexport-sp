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
		$pageTitle = "Selling Transaction";
		$data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where  b.status_join='4' and  a.id = b.id_br and b.id_eks='".Auth::guard('eksmp')->user()->id."' order by b.id desc ");
        return view('trx.index_eks', compact('pageTitle','data'));
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
	
	


}
