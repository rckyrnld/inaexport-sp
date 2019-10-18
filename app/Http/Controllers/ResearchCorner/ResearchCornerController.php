<?php

namespace App\Http\Controllers\ResearchCorner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class ResearchCornerController extends Controller
{

	public function __construct(){
        $this->middleware('auth:eksmp');
    }

	  public function index(){
      $pageTitle = 'Research Corner';
      return view('research-corner.eksportir.index',compact('pageTitle'));
    }

    public function getData()
    {
      $array = array();
      $id_profil = Auth::guard('eksmp')->user()->id_profil;

      $kategori = DB::table('csc_product_single')->where('id_itdp_profil_eks', $id_profil)
        ->select('id_csc_product as kategori', 'id_csc_product_level1 as sub_kategori', 'id_csc_product_level2 as sub_sub_kategori')
        ->distinct('kategori', 'sub_kategori', 'sub_sub_kategori')->get();

      foreach ($kategori as $key) {
        if (!in_array($key->kategori, $array)){
            array_push($array, $key->kategori);
          }
        if($key->sub_kategori != null){
          if (!in_array($key->sub_kategori, $array)){
            array_push($array, $key->sub_kategori);
          }
        }
        if($key->sub_sub_kategori != null){
          if (!in_array($key->sub_sub_kategori, $array)){
            array_push($array, $key->sub_sub_kategori);
          }
        }
      }

      $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
      ->whereIn('a.id_categori_product', $array)
      ->orderby('b.publish_date', 'asc')
      ->select('b.*')
      ->get();

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
            $id_profil = Auth::guard('eksmp')->user()->id_profil;
            $download = DB::table('csc_download_research_corner')
            ->where('id_research_corner', $data->id)
            ->where('id_itdp_profil_eks', $id_profil)
            ->first();
                if($download){
                  return '<center>
                    <a href="'.route("research-corner.view", $data->id).'" style="width:100px;" class="btn btn-sm btn-info">View</a>
                    </center>';
                } else {
                  return '<center>
                    <a href="'.url('/').'/uploads/Research Corner/File/'.$data->exum.'" style="width:100px;" onclick="cek_download('.$data->id.', event, this)" class="btn btn-sm btn-warning text-white">Download</a>&nbsp;&nbsp;
                    <a href="'.route("research-corner.view", $data->id).'" style="width:100px;" class="btn btn-sm btn-info">View</a>
                    </center>';
                }
          })
          ->rawColumns(['action'])
          ->make(true);
    }

    public function download(Request $req)
    {
      $id_profil = Auth::guard('eksmp')->user()->id_profil;
      $id_user = Auth::guard('eksmp')->user()->id;
      $checking = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->where('id_research_corner', $req->id)->first();
      if($checking){
        $hasil = 'positif';
      } else {
        $id = DB::table('csc_download_research_corner')->orderby('id', 'desc')->first();
        if($id){ $id = $id->id+1; }else{ $id=1; }
        $before = DB::table('csc_research_corner')->where('id', $req->id)->first();

        DB::table('csc_download_research_corner')->insert([
          'id' => $id,
          'id_itdp_profil_eks' => $id_profil,
          'id_research_corner' => $req->id,
          'waktu' => date('Y-m-d H:i:s')
        ]);

        DB::table('notif')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->update([
          'status_baca' => 1
        ]);

        DB::table('csc_research_corner')->where('id', $req->id)->update([
          'download' => $before->download+1
        ]);

        $hasil = 'nihil';
      }
      echo json_encode($hasil);
    }

    public function read($id)
    {
      $pageTitle = "Research Corner";
      $data = DB::table('csc_research_corner')->where('id', $id)->first();
      return view('research-corner.eksportir.view',compact('data','pageTitle'));
    }
}
