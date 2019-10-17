<?php

namespace App\Http\Controllers\ResearchCorner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class PerwakilanResearchController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Research Corner';
      return view('research-corner.perwakilan.index',compact('pageTitle'));
    }

    public function getData()
    {
      $id_user = Auth::user()->id;
      $research = DB::table('csc_research_corner')->where('created_by', $id_user)->orderby('publish_date', 'asc')->get();

      return \Yajra\DataTables\DataTables::of($research)
          ->addIndexColumn()
          ->addColumn('country', function ($value) {
            $data =  DB::table('mst_country')->where('id', $value->id_mst_country)->first();
            return $data->country;
          })
          ->addColumn('type', function ($value) {
            $data =  DB::table('csc_research_type')->where('id', $value->id_csc_research_type)->first();
            return $data->nama_en;
          })
          ->addColumn('date', function ($data) {
            return getTanggalIndo(date('Y-m-d', strtotime($data->publish_date))).' ( '.date('H:i', strtotime($data->publish_date)).' )';
          })
          ->addColumn('action', function ($data) {
            $research = DB::table('csc_broadcast_research_corner')
              ->where('id_research_corner', $data->id)
              ->first();
              if($research){
                return '<center>
                  <a href="'.route("perwakilan.research-corner.view", $data->id).'" id="button" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                  <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Data Ini ?\')" href="'.route("perwakilan.research-corner.destroy", $data->id).'" id="button" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
                  </center>';
              } else {
                return '<center>
                  <button onclick="broadcast(\''.$data->title_en.'||'.$data->id.'\')" id="button" class="btn btn-sm btn-warning text-white">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Broadcast&nbsp;</button>&nbsp;&nbsp;
                  <a href="'.route("perwakilan.research-corner.edit", $data->id).'" id="button" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>
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
      $url = "/perwakilan/research-corner/store/Create";
      $type = DB::table('csc_research_type')->orderby('nama_en', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      $hscode = DB::table('mst_hscodes')->orderby('desc_eng', 'asc')->get();
      return view('research-corner.perwakilan.create',compact('url','pageTitle','page','country','hscode','type'));
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
         return redirect('perwakilan/research-corner/');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('perwakilan/research-corner/');
       }
    }

    public function broadcast(Request $req)
    {
      $id_user = Auth::user()->id;
      $array = array();

      for($i = 0; $i<count($req->categori); $i++){
        $var = $req->categori[$i];
        $id = DB::table('csc_broadcast_research_corner')->orderby('id','desc')->first();
        if($id){ $id = $id->id+1; } else { $id = 1; }

        $data = DB::table('csc_broadcast_research_corner')->insert([
          'id' => $id,
          'id_research_corner' => $req->research,
          'id_categori_product' => $req->categori[$i],
          'created_at' => date('Y-m-d H:i:s')
        ]);

        $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
              ->where(function ($query) use ($var) {
                      $query->where('id_csc_product', $var)
                            ->orWhere('id_csc_product_level1', $var)
                            ->orWhere('id_csc_product_level2', $var);
                  })
              ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
        foreach ($perusahaan as $key) {
          if (!in_array($key->id_itdp_company_user, $array)){
            array_push($array, $key->id_itdp_company_user);
          }
        }
      }
      sort($array);
      for ($user=0; $user < count($array) ; $user++) { 
        $pengirim = DB::table('itdp_admin_users')->where('id',$id_user)->first();
        $account_penerima = DB::table('itdp_company_users')->where('id',$array[$user])->first();
        $profile_penerima = DB::table('itdp_profil_eks')->where('id',$account_penerima->id_profil)->first();

        $notif = DB::table('notif')->insert([
            'dari_nama' => $pengirim->name,
            'dari_id' => $pengirim->id,
            'untuk_nama' => $profile_penerima->company,
            'untuk_id' => $array[$user],
            'keterangan' => 'New Broadcast from '.$pengirim->name.' with Title  "'.$req->title_en.'"',
            'url_terkait' => 'research-corner/read',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'id_terkait' => $req->research,
        ]);
      }

      if($data){
         Session::flash('success','Success Broadcast Data');
         return redirect('perwakilan/research-corner/');
       }else{
         Session::flash('failed','Failed Broadcast Data');
         return redirect('perwakilan/research-corner/');
       }
    }

    public function view($id)
    {
      $pageTitle = "Research Corner";
      $page = "view";
      $data = DB::table('csc_research_corner')->where('id', $id)->first();
      $type = DB::table('csc_research_type')->orderby('nama_en', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      $hscode = DB::table('mst_hscodes')->orderby('desc_eng', 'asc')->get();
      return view('research-corner.perwakilan.create',compact('page','data','pageTitle','country','hscode','type'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Research Corner";
      $url = "/perwakilan/research-corner/store/Update_".$id;
      $data = DB::table('csc_research_corner')->where('id', $id)->first();
      $type = DB::table('csc_research_type')->orderby('nama_en', 'asc')->get();
      $country = DB::table('mst_country')->orderby('country', 'asc')->get();
      $hscode = DB::table('mst_hscodes')->orderby('desc_eng', 'asc')->get();
      return view('research-corner.perwakilan.create',compact('url','data','pageTitle','page','country','type','hscode'));
    }

    public function destroy($id)
    {
      $data = DB::table('csc_research_corner')->where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('perwakilan/research-corner/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('perwakilan/research-corner/');
       }
    }
}
