<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ProvinceExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterProvinceController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Province';
      $province = MasterProvince::orderby('province_en', 'asc')->get();
      return view('master.province.index',compact('pageTitle','province'));
    }

    public function create()
    {
      $pageTitle = 'Province';
      $page = 'create';
      $url = "/master-province/store/Create";
      return view('master.province.create',compact('url','pageTitle','page'));
    }

    public function store(Request $req, $param)
    { 
      if($param == 'Create'){
        $data = MasterProvince::insert([
          'id' => $req->kode_province,
          'province_en' => $req->province_en,
          'province_in' => $req->province_in,
          'province_chn' => $req->province_chn
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterProvince::where('id', $pecah[1])->update([
          'id' => $req->kode_province,
          'province_en' => $req->province_en,
          'province_in' => $req->province_in,
          'province_chn' => $req->province_chn
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('/master-province/');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('/master-province/');
       }
    }

    public function view($id)
    {
      $pageTitle = "Province";
      $page = "view";
      $data = MasterProvince::where('id', $id)->first();
      return view('master.province.create',compact('page','data','pageTitle'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Province";
      $url = "/master-province/store/Update_".$id;
      $data = MasterProvince::where('id', $id)->first();
      return view('master.province.create',compact('url','data','pageTitle','page'));
    }

    public function destroy($id)
    {
      $data = MasterProvince::where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/master-province/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/master-province/');
       }
    }

    public function check(Request $req){
      $checking = MasterProvince::where('id', $req->kode)->first();
      echo json_encode($checking);
    }

    public function export()
    {
      return Excel::download(new ProvinceExport, 'Province_Data.xlsx');
    }
}
