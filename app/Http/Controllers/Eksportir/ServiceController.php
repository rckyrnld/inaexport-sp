<?php

namespace App\Http\Controllers\Eksportir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class ServiceController extends Controller
{
	  public function __construct()
    {
      // if(Auth::check()){
      //   $this->middleware('auth');
      // } else {
      //   $this->middleware('auth:eksmp');
      // }
    }

    public function index()
    {
        $pageTitle = "Service";
        if(Auth::guard('eksmp')->user()->id_role == 2){
            return view('eksportir.service.index', compact('pageTitle'));
        }else {
            return redirect('/login');
        }
    }

    public function index_admin()
    {
        $pageTitle = "Service";
        if(Auth::user()){
            return view('eksportir.service.index_admin', compact('pageTitle'));
        } else {
            return redirect('/login');
        }
    }

    public function getData()
    {
      if(Auth::guard('eksmp')->user()->id_role == 2){
        $id_profil = Auth::guard('eksmp')->user()->id_profil;

        $service = DB::table('itdp_service_eks as a')->where('id_itdp_profil_eks', $id_profil)->orderBy('created_at', 'desc')->get();

        return \Yajra\DataTables\DataTables::of($service)
            ->addIndexColumn()
            ->addColumn('status', function ($value) {
              switch ($value->status) {
                case 0:
                    return 'Hide';
                  break;
                case 1:
                    return 'Publish';
                  break;
                case 2:
                    return 'Publish - Accepted';
                  break;
                case 3:
                    return 'Publish - Rejected';
                  break;
                }
            })
            ->addColumn('action', function ($data) {
                return '
                  <center>
                    <div class="btn-group">
                      <a href="'.route('service.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                      <a href="'.route('service.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
                      <a onclick="return confirm(\'Are You Sure ?\')" href="'.route('service.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
                    </div>
                  </center>';
            })
            ->rawColumns(['action', 'skill_en', 'pengalaman_en', 'link'])
            ->make(true);
      } else {
        return redirect('/login');
      }
    }

    public function create()
    {
        if(Auth::guard('eksmp')->user()->id_role == 2){
            $url = '/eksportir/service/store';
            $pageTitle = 'Service';
            return view('eksportir.service.create', compact('pageTitle', 'url'));
        }else{
            return redirect('/login');
        }
    }

    public function view($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 2){
            $data = DB::table('itdp_service_eks')->where('id', $id)->first();
            $pageTitle = 'Service';
            return view('eksportir.service.view', compact('pageTitle', 'data'));
        }else{
            return redirect('/login');
        }
    }

    public function edit($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 2){
            $data = DB::table('itdp_service_eks')->where('id', $id)->first();
            $url = '/eksportir/service/update/'.$id;
            $pageTitle = 'Service';
            return view('eksportir.service.edit', compact('pageTitle', 'url', 'data'));
        }else{
            return redirect('/login');
        }
    }

    public function store(Request $req)
    {
      $id_profil = Auth::guard('eksmp')->user()->id_profil;
      $id_user = Auth::guard('eksmp')->user()->id;
      $id = DB::table('itdp_service_eks')->orderBy('id','desc')->first();
      $date =  date('Y-m-d H:i:s');

      if($id){ $id = $id->id+1; }else{ $id = 1; }
      $bidang_en = '';
      $bidang_ind = '';
      $bidang_chn = '';

      $jumlah_bidang = count($req->bidang_en);
      for($i = 0; $i < $jumlah_bidang; $i++){
        if($i === $jumlah_bidang-1){
          $bidang_en .= $req->bidang_en[$i];
          $bidang_ind .= $req->bidang_ind[$i];
          $bidang_chn .= $req->bidang_chn[$i];
        } else {
          $bidang_en .= $req->bidang_en[$i];
          $bidang_en .= ', ';
          $bidang_ind .= $req->bidang_ind[$i];
          $bidang_ind .= ', ';
          $bidang_chn .= $req->bidang_chn[$i];
          $bidang_chn .= ', ';
        }
      }

      $data = DB::table('itdp_service_eks')->insert([
        'id' => $id,
        'id_itdp_profil_eks' => $id_profil,
        'nama_en' => $req->name_en,
        'nama_ind' => $req->name_ind,
        'nama_chn' => $req->name_chn,
        'bidang_en' => $bidang_en,
        'bidang_ind' => $bidang_ind,
        'bidang_chn' => $bidang_chn,
        'skill_en' => $req->skill_en,
        'skill_ind' => $req->skill_ind,
        'skill_chn' => $req->skill_chn,
        'pengalaman_en' => $req->experience_en,
        'pengalaman_ind' => $req->experience_ind,
        'pengalaman_chn' => $req->experience_chn,
        'link' => $req->link,
        'status' => $req->status,
        'created_at' => $date
      ]);

      if($req->status == 1){
        $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
          foreach ($admin as $adm) {
              $notif = DB::table('notif')->insert([
                  'dari_nama' => getCompanyName($id_user),
                  'dari_id' => $id_user,
                  'untuk_nama' => $adm->name,
                  'untuk_id' => $adm->id,
                  'keterangan' => 'New Service Published By '.getCompanyName($id_user).' with Title  "'.$req->name_en.'"',
                  'url_terkait' => 'eksportir/service/verifikasi',
                  'status_baca' => 0,
                  'waktu' => $date,
                  'id_terkait' => $id,
                  'to_role' => 1
              ]);
          }
      }

      if($data){
         Session::flash('success','Success Store Data');
         return redirect('/eksportir/service/');
       }else{
         Session::flash('failed','Failed Store Data');
         return redirect('/eksportir/service/');
       }
    }

    public function update(Request $req, $id)
    {
      $id_user = Auth::guard('eksmp')->user()->id;
      $date = date('Y-m-d H:i:s');
      $bidang_en = '';
      $bidang_ind = '';
      $bidang_chn = '';

      $jumlah_bidang = count($req->bidang_en);
      for($i = 0; $i < $jumlah_bidang; $i++){
        if($i === $jumlah_bidang-1){
          $bidang_en .= $req->bidang_en[$i];
          $bidang_ind .= $req->bidang_ind[$i];
          $bidang_chn .= $req->bidang_chn[$i];
        } else {
          $bidang_en .= $req->bidang_en[$i];
          $bidang_en .= ', ';
          $bidang_ind .= $req->bidang_ind[$i];
          $bidang_ind .= ', ';
          $bidang_chn .= $req->bidang_chn[$i];
          $bidang_chn .= ', ';
        }
      }

      $data = DB::table('itdp_service_eks')->where('id', $id)->update([
        'nama_en' => $req->name_en,
        'nama_ind' => $req->name_ind,
        'nama_chn' => $req->name_chn,
        'bidang_en' => $bidang_en,
        'bidang_ind' => $bidang_ind,
        'bidang_chn' => $bidang_chn,
        'skill_en' => $req->skill_en,
        'skill_ind' => $req->skill_ind,
        'skill_chn' => $req->skill_chn,
        'pengalaman_en' => $req->experience_en,
        'pengalaman_ind' => $req->experience_ind,
        'pengalaman_chn' => $req->experience_chn,
        'link' => $req->link,
        'status' => $req->status,
        'updated_at' => $date
      ]);

      if($req->status == 1){
        $cek_notif = DB::table('notif')->where('url_terkait', 'eksportir/service/verifikasi')
        ->where('id_terkait', $id)
        ->where('dari_id', $id_user)
        ->first();
        if(!$cek_notif){
          $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
          foreach ($admin as $adm) {
              $notif = DB::table('notif')->insert([
                  'dari_nama' => getCompanyName($id_user),
                  'dari_id' => $id_user,
                  'untuk_nama' => $adm->name,
                  'untuk_id' => $adm->id,
                  'keterangan' => 'New Service Published By '.getCompanyName($id_user).' with Title  "'.$req->name_en.'"',
                  'url_terkait' => 'eksportir/service/verifikasi',
                  'status_baca' => 0,
                  'waktu' => $date,
                  'id_terkait' => $id,
                  'to_role' => 1
              ]);
          }
        }
      }

      if($data){
         Session::flash('success','Success Store Data');
         return redirect('/eksportir/service/');
       }else{
         Session::flash('failed','Failed Store Data');
         return redirect('/eksportir/service/');
       }
    }

    public function destroy($id)
    {
      $data = DB::table('itdp_service_eks')->where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/eksportir/service/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/eksportir/service/');
       }
    }
}
