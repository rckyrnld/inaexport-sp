<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CountryExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterCountryController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Country';
      return view('master.country.index',compact('pageTitle'));
    }

    public function getData()
    {
      $country = MasterCountry::leftjoin('mst_group_country as a','mst_country.mst_country_group_id','=','a.id')
              ->orderby('mst_country.country', 'asc')
              ->select('a.group_country','mst_country.*')
              ->get();

      return \Yajra\DataTables\DataTables::of($country)
          ->addColumn('action', function ($data) {
              return '
              <center>
              <div class="btn-group">
                <a href="'.route('master.country.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                <a href="'.route('master.country.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Data Ini ?\')" href="'.route('master.country.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
              </div>
              </center>
              ';
          })
          ->rawColumns(['action'])
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'Country';
      $page = 'create';
      $url = "/master-country/store/Create";
      $country_region = DB::table('mst_country_region')->get();
      $country_group = DB::table('mst_group_country')->get();
      return view('master.country.create',compact('url','pageTitle','page','country_region','country_group'));
    }

    public function store(Request $req, $param)
    {
      $id = MasterCountry::orderby('id','desc')->first();
      if($id){
        $id = $id->id+1;
      } else {
        $id = 1;
      }
      
      if($param == 'Create'){
        $data = MasterCountry::insert([
          'id' => $id,
          'mst_country_group_id' => $req->group,
          'mst_country_region_id' => $req->region,
          'country' => $req->country,
          'kode_bps' => $req->kode_bps
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterCountry::where('id', $pecah[1])->update([
          'mst_country_group_id' => $req->group,
          'mst_country_region_id' => $req->region,
          'country' => $req->country,
          'kode_bps' => $req->kode_bps
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('/master-country/');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('/master-country/');
       }
    }

    public function view($id)
    {
      $pageTitle = "Country";
      $page = "view";
      $data = MasterCountry::where('id', $id)->first();
      $country_region = DB::table('mst_country_region')->get();
      $country_group = DB::table('mst_group_country')->get();
      return view('master.country.create',compact('page','data','pageTitle','country_region','country_group'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Country";
      $url = "/master-country/store/Update_".$id;
      $data = MasterCountry::where('id', $id)->first();
      $country_region = DB::table('mst_country_region')->get();
      $country_group = DB::table('mst_group_country')->get();
      return view('master.country.create',compact('url','data','pageTitle','page','country_region','country_group'));
    }

    public function destroy($id)
    {
      $data = MasterCountry::where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/master-country/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/master-country/');
       }
    }

    public function check(Request $req){
      $checking = MasterCountry::where('kode_bps', $req->kode)->first();
      echo json_encode($checking);
    }

    public function export()
    {
      return Excel::download(new CountryExport, 'Country_Data.xlsx');
    }
}
