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

class MasterPortController extends Controller
{

  public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
      $pageTitle = 'Port';
      $port = MasterPort::leftjoin('mst_province as a', 'mst_port.id_mst_province','=','a.id')
      ->orderby('mst_port.name_port', 'asc')
      ->select('mst_port.*', 'a.province_en')
      ->get();
      return view('master.port.index',compact('pageTitle','port'));
    }

    public function create()
    {
      $pageTitle = 'Port';
      $page = 'create';
      $url = "/master-port/store/Create";
      $province = MasterProvince::orderby('id')->get();
      return view('master.port.create',compact('url','pageTitle','page','province'));
    }

    public function store(Request $req, $param)
    {
      $id = MasterPort::orderby('id','desc')->first();
      if($id){
        $id = $id->id+1;
      } else {
        $id = 1;
      }
      
      if($param == 'Create'){
        $data = MasterPort::insert([
          'id' => $id,
          'id_mst_province' => $req->province,
          'name_port' => $req->port
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterPort::where('id', $pecah[1])->update([
          'id_mst_province' => $req->province,
          'name_port' => $req->port
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('/master-port/');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('/master-port/');
       }
    }

    public function view($id)
    {
      $pageTitle = "Port";
      $page = "view";
      $data = MasterPort::where('id', $id)->first();
      $province = MasterProvince::orderby('id')->get();
      return view('master.port.create',compact('page','data','pageTitle','province'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Port";
      $url = "/master-port/store/Update_".$id;
      $data = MasterPort::where('id', $id)->first();
      $province = MasterProvince::orderby('id')->get();
      return view('master.port.create',compact('url','data','pageTitle','page','province'));
    }

    public function destroy($id)
    {
      $data = MasterPort::where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/master-port/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/master-port/');
       }
    }

    public function export()
    {
      return Excel::download(new PortExport, 'Port_Data.xlsx');
    }
}
