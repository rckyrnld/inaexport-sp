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
	
	


}
