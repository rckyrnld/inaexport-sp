<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MasterBannerController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){
    $pageTitle = 'Master Banner';
    return view('master.banner.index',compact('pageTitle'));
  }

  public function create()
  {
    $pageTitle = 'Create Banner';
    $page = 'create';
    $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
    return view('master.banner.create',compact('pageTitle', 'page', 'catprod'));
  }

  public function store($param, Request $request)
  {
    date_default_timezone_set('Asia/Jakarta');
    $datenow = date("Y-m-d H:i:s");
    if ($param == 'create') {
      if(empty($request->file('file_img'))){
        $file = "";
      }else{
        $file = $request->file('file_img')->getClientOriginalName();
        $destinationPath = public_path() . "/uploads/banner";
        $request->file('file_img')->move($destinationPath, $file);
      }

      $store = Banner::insert([
              'file' => $file,
              'id_csc_product' => $request->id_csc_product,
              'id_csc_product_level1' => $request->id_csc_product_level1,
              'id_csc_product_level2' => $request->id_csc_product_level2,
              'status' => 0,
              'created_at' => $datenow
              ]);

      return redirect('master-banner')->with('success','Success Add Data');
    } else if ($param == 'update') {
      
    }
  }

  public function getData(Request $request)
  {
    $columns = array(
      0 => 'id',
      1 => 'status',
    );

    $totalData = DB::table('banner')->count();
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $posts = DB::table('banner')
              ->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();

      $totalFiltered = count($posts);
    }

    $data = array();

    if ($posts) {
      $count = $start+1;
      foreach ($posts as $d) {
        $token = csrf_token();
        $nestedData['no'] = $count;
        $nestedData['file'] = '<div class="thumbnail"><img src="'.asset('/uploads/banner/'.$d->file).'" alt="Lights" style="width:100%"></div>';
        $nestedData['until'] = isset($d->end_at) ? date('d-m-Y',$d->end_at) : '-';
        if ($d->status == 0) {
          $nestedData['status'] = 'Tidak Aktif';
        } else {
          $nestedData['status'] = 'Aktif';
        }
        $nestedData['aksi'] = '<div class="btn-group"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEdit" data-edit-id="'.$d->id.'"><i class="fa fa-pencil"></i></button><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></div>';
        $data[] = $nestedData;
        $count++;
      }
    }

      $json_data = array(
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'data' => $data
      );

      echo json_encode($json_data);
  }

  public function getCompany(Request $request)
  {
    $banner = Banner::find($request->id);
    if (isset($banner->id_csc_product_level2)) {
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks', '=', 'itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product_level2', $banner->id_csc_product_level2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }

    $no = 0;
    foreach ($company as $val) {
      $company[$no]->no = ($no+1);
      $no++;
    }
    return response()->json($company);
  }
}
