<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MasterCountryController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Country';
      $country = MasterCountry::orderby('mst_country_group_id', 'asc')
      ->orderby('mst_country_region_id', 'asc')->get();
      return view('master.country.index',compact('pageTitle','country'));
    }

    public function create()
    {
      $pageTitle = 'Country';
      $page = 'create';
      $url = "/master-country/store/Create";
      return view('master.country.create',compact('url','pageTitle','page'));
    }

    public function store(Request $req, $param)
    {
      if($param == 'Create'){
        $data = MasterCountry::insert([
          'mst_country_group_id' => $req->group,
          'mst_country_region_id' => $req->group,
          'country' => $req->country,
          'kode_bps' => $req->kode_bps,
          'created_at' => date('Y-m-d H:i:s')
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterCountry::where('id', $pecah[1])->update([
          'mst_country_group_id' => $req->group,
          'mst_country_region_id' => $req->group,
          'country' => $req->country,
          'kode_bps' => $req->kode_bps,
          'updated_at' => date('Y-m-d H:i:s')
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
      return view('master.country.create',compact('page','data','pageTitle'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Country";
      $url = "/master-country/store/Update_".$id;
      $data = MasterCountry::where('id', $id)->first();
      return view('master.country.create',compact('url','data','pageTitle','page'));
    }

    public function destroy($id)
    {
        //
    }
}
