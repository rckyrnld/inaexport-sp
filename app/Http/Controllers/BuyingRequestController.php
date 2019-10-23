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
        $pageTitle = "Buying Request Perwakilan";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
        return view('buying-request.index', compact('pageTitle','data'));
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
			$destinationPath = public_path() . "/upload/buy_request";
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
