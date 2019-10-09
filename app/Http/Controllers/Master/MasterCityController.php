<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterCityController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'City';
      $city = MasterCity::leftjoin('mst_country as a', 'a.id','=','mst_city.id_mst_country')
      ->orderby('a.country', 'asc')
      ->orderby('mst_city.city', 'asc')
      ->select('mst_city.*', 'a.country')
      ->get();
      return view('master.city.index',compact('pageTitle','city'));
    }

    public function create()
    {
      $pageTitle = 'City';
      $page = 'create';
      $url = "/master-city/store/Create";
      $country = MasterCountry::orderby('country')->get();
      return view('master.city.create',compact('url','pageTitle','page','country'));
    }

    public function store(Request $req, $param)
    {
      if($param == 'Create'){
        $data = MasterCity::insert([
          'id_mst_country' => $req->country,
          'city' => $req->city
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = MasterCity::where('id', $pecah[1])->update([
          'id_mst_country' => $req->country,
          'city' => $req->city
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('/master-city/');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('/master-city/');
       }
    }

    public function view($id)
    {
      $pageTitle = "City";
      $page = "view";
      $data = MasterCity::where('id', $id)->first();
      $country = MasterCountry::orderby('id')->get();
      return view('master.city.create',compact('page','data','pageTitle','country'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "City";
      $url = "/master-city/store/Update_".$id;
      $data = MasterCity::where('id', $id)->first();
      $country = MasterCountry::orderby('id')->get();
      return view('master.city.create',compact('url','data','pageTitle','page','country'));
    }

    public function destroy($id)
    {
      $data = MasterCity::where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/master-city/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/master-city/');
       }
    }

    public function export()
    {
      return Excel::download(new CityExport, 'City_Data.xlsx');
    }
}
