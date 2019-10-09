<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterPort;
use App\Models\MasterProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MasterPortController extends Controller
{

  public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
      $pageTitle = 'Port';
      $port = MasterPort::leftjoin('mst_province as a', 'a.id','=','mst_port.id_mst_province')
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
      if($param == 'Create'){
        $data = MasterPort::insert([
          'id_mst_province' => $req->province,
          'name_port' => $req->port,
          'created_at' => date('Y-m-d H:i:s')
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterPort::where('id', $pecah[1])->update([
          'id_mst_province' => $req->province,
          'name_port' => $req->port,
          'updated_at' => date('Y-m-d H:i:s')
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
        //
    }
}
