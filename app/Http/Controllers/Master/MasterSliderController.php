<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterPort;
use App\Models\MasterProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PortExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterSliderController extends Controller
{

  public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
      $pageTitle = 'List Slider';
      return view('master.slider.index',compact('pageTitle'));
    }

    
    public function create()
    {
      $pageTitle = 'Add Slider';
      $page = 'create';
      $url = "/master-port/store/Create";
      $province = MasterProvince::orderby('province_en','asc')->get();
      return view('master.slider.create',compact('url','pageTitle','page','province'));
    }

    public function store(Request $request)
    { 
		if(empty($request->file('file_img'))){
			$file = "";
		}else{
			$file = $request->file('file_img')->getClientOriginalName();
			$destinationPath = public_path() . "/uploads/slider";
			$request->file('file_img')->move($destinationPath, $file);
		}
		$insert = DB::select("
			insert into mst_slide (file_img,keterangan,publish,created_at) values
			('".$file."','".$request->keterangan."','".$request->publish."','".Date('Y-m-d H:i:s')."')");
		
		return redirect('master-slide')->with('success','Success Add Data');
    }

    public function view($id)
    {
      $pageTitle = "List Port";
      $page = "view";
      $data = MasterPort::where('id', $id)->first();
      $province = MasterProvince::orderby('province_en','asc')->get();
      return view('master.port.create',compact('page','data','pageTitle','province'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "List Port";
      $url = "/master-port/store/Update_".$id;
      $data = MasterPort::where('id', $id)->first();
      $province = MasterProvince::orderby('province_en','asc')->get();
      return view('master.port.create',compact('url','data','pageTitle','page','province'));
    }

    public function destroy($id)
    {
      $data = MasterPort::where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/master-port/')->with('success', 'Success Delete Data');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/master-port/')->with('error', 'Failed Delete Data');
       }
    }

    public function check(Request $req){
      $checking = MasterPort::where('id', $req->kode)->first();
      echo json_encode($checking);
    }

    public function export()
    {
      return Excel::download(new PortExport, 'Port_Data.xlsx');
    }
}
