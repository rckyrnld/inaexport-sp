<?php

namespace App\Http\Controllers\ResearchCorner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class AdminResearchController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Research Corner';
      $research = DB::table('csc_research_corner')->orderby('title_en', 'asc')->get();
      return view('research-corner.admin.index',compact('pageTitle','research'));
    }

    public function getData()
    {
      $research = DB::table('csc_research_corner')->orderby('title_en', 'asc')->get();

      return \Yajra\DataTables\DataTables::of($research)
          ->addIndexColumn()
          ->addColumn('date', function ($data) {
            return getTanggalIndo(date('Y-m-d', strtotime($data->publish_date))).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          })
          ->addColumn('action', function ($data) {
            $research = DB::table('csc_broadcast_research_corner')
              ->where('id_research_corner', $data->id)
              ->first();
              if($research){
                return '<center>
                  <a href="'.route("admin.research-corner.view", $data->id).'" id="button" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                  <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Data Ini ?\')" href="'.route("admin.research-corner.destroy", $data->id).'" id="button" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
                  </center>';
              } else {
                return '<center>
                  <button onclick="broadcast(\''.$data->title_en.'||'.$data->id.'\')" id="button" class="btn btn-sm btn-warning text-white">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Broadcast&nbsp;</button>&nbsp;&nbsp;
                  <a href="'.route("admin.research-corner.edit", $data->id).'" id="button" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>
                  </center>';
              }
          })
          ->rawColumns(['action'])
          ->make(true);
    }

    public function getDataDownload($id)
    {
      $download = DB::table('csc_download_research_corner')
      ->orderby('waktu', 'asc')->where('id_research_corner', $id)->get();

      return \Yajra\DataTables\DataTables::of($download)
          ->addIndexColumn()
          ->addColumn('company', function ($var) {
            $data = DB::table('itdp_profil_eks')->where('id', $var->id_itdp_profil_eks)->first();
            return $data->company;
          })
          ->addColumn('download_date', function ($data) {
            return getTanggalIndo(date('Y-m-d', strtotime($data->waktu))).' ( '.date('H:i', strtotime($data->waktu)).' )';
          })
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'Research Corner';
      $page = 'create';
      $url = "/admin/research-corner/store/Create";
      // $type = DB::table('mst_country')->orderby('country', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      // $hscode = DB::table('mst_country')->orderby('country', 'asc')->get();
      return view('research-corner.admin.create',compact('url','pageTitle','page','country'));
    }

    public function store(Request $req, $param)
    {
      $id_user = Auth::user()->id;
      $id = DB::table('csc_research_corner')->orderby('id','desc')->first();
      if($id){ $id = $id->id+1; } else { $id = 1; }
            
      $destination=public_path().'\uploads\Research Corner\File';
      if($req->hasFile('file')){ 
        $nama_file = time().'_Research '.$req->title_en.'_'.$req->file('file')->getClientOriginalName();
        $req->file('file')->move($destination, $nama_file);
      } else { $nama_file = $req->lastest_file; }

      if($param == 'Create'){
        $data = DB::table('csc_research_corner')->insert([
          'id' => $id,
          'title_en' => $req->title_en,
          'title_in' => $req->title_in,
          'id_csc_research_type' => $req->type,
          'id_mst_country' => $req->country,
          'id_mst_hscodes' => $req->code,
          'publish_date' => $req->date,
          'exum' => $nama_file,
          'created_by' => $id_user
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = DB::table('csc_research_corner')->where('id', $pecah[1])->update([
          'title_en' => $req->title_en,
          'title_in' => $req->title_in,
          'id_csc_research_type' => $req->type,
          'id_mst_country' => $req->country,
          'id_mst_hscodes' => $req->code,
          'publish_date' => $req->date,
          'exum' => $nama_file,
          'created_by' => $id_user
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('admin/research-corner/');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('admin/research-corner/');
       }
    }

    public function broadcast(Request $req)
    {

      for($i = 0; $i<count($req->categori); $i++){
        $id = DB::table('csc_broadcast_research_corner')->orderby('id','desc')->first();
        if($id){ $id = $id->id+1; } else { $id = 1; }

        $data = DB::table('csc_broadcast_research_corner')->insert([
          'id' => $id,
          'id_research_corner' => $req->research,
          'id_categori_product' => $req->categori[$i],
          'created_at' => date('Y-m-d H:i:s')
        ]);
      }

      if($data){
         Session::flash('success','Success Broadcast Data');
         return redirect('admin/research-corner/');
       }else{
         Session::flash('failed','Failed Broadcast Data');
         return redirect('admin/research-corner/');
       }
    }

    public function view($id)
    {
      $pageTitle = "Research Corner";
      $page = "view";
      $data = DB::table('csc_research_corner')->where('id', $id)->first();
      // $type = DB::table('mst_country')->orderby('country', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      // $hscode = DB::table('mst_country')->orderby('country', 'asc')->get();
      return view('research-corner.admin.create',compact('page','data','pageTitle','country'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Research Corner";
      $url = "/admin/research-corner/store/Update_".$id;
      $data = DB::table('csc_research_corner')->where('id', $id)->first();
      // $type = DB::table('mst_country')->orderby('country', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      // $hscode = DB::table('mst_country')->orderby('country', 'asc')->get();
      return view('research-corner.admin.create',compact('url','data','pageTitle','page','country'));
    }

    public function destroy($id)
    {
      $data = DB::table('csc_research_corner')->where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('admin/research-corner/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('admin/research-corner/');
       }
    }
}
