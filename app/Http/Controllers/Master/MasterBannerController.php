<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Banner_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MasterBannerController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function message(){ 
    return redirect('master-banner')->with('success','Success Update Data');
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
      if($request->semua == 1){ 
        $banner = Banner::where('id', $request->id)->get();
        if (isset($banner[0]->id_csc_product_level2)) {
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level2', $banner[0]->id_csc_product_level2)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else if(isset($banner[0]->id_csc_product_level1)){
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level1', $banner[0]->id_csc_product_level1)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else{
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product', $banner[0]->id_csc_product)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }
        $explodeksportir = $company;
        foreach($explodeksportir as $eksportir){
          $cekada=DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".$eksportir->id."'");
          if(count($cekada) == 0){
            $storedetail = Banner_Detail::insert([
                    'id_banner' => $request->id,
                    'id_eks' => $eksportir->id,
                    'created_at' => $datenow
                    ]);
           }
        }
      }else{
        $dataeksportir = $request->dataeksportir;
        $explodeksportir = explode(',',$dataeksportir);
        foreach($explodeksportir as $eksportir){
          $cekada=DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".(int)$eksportir."'");
          if(count($cekada) == 0){
              $storedetail = Banner_Detail::insert([
                      'id_banner' => $request->id,
                      'id_eks' => $eksportir,
                      'created_at' => $datenow
                      ]);
          }
        }
      }
      $update = Banner::where('id', $request->id)
              ->update(['end_at' => $request->s_date,'updated_at' => $datenow, 'status' => $request->status]);

      
      $baliknya = 'sukses';
      return json_encode($baliknya);
    }else if($param == 'update2'){
      if($request->semua == 1){ 
        $banner = Banner::where('id', $request->id)->get();
        if (isset($banner[0]->id_csc_product_level2)) {
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level2', $banner[0]->id_csc_product_level2)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else if(isset($banner[0]->id_csc_product_level1)){
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product_level1', $banner[0]->id_csc_product_level1)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }else{
          $company = DB::table('csc_product_single')
                      ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                      ->where('csc_product_single.id_csc_product', $banner[0]->id_csc_product)
                      ->select('itdp_profil_eks.id')
                      ->groupBy('itdp_profil_eks.id')
                      ->orderBy('itdp_profil_eks.id', 'ASC')
                      ->get();
        }
        $explodeksportir = $company;
        foreach($explodeksportir as $eksportir){
          $cekada=DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".$eksportir->id."'");
          if(count($cekada) == 0){
            $storedetail = Banner_Detail::insert([
                    'id_banner' => $request->id,
                    'id_eks' => $eksportir->id,
                    'created_at' => $datenow
                    ]);
           }
        }
      }else if($request->dataeksportir != null){
        $dataeksportir = $request->dataeksportir;
        $explodeksportir = explode(',',$dataeksportir);
        foreach($explodeksportir as $eksportir){
          $cekada=DB::select("select * from banner_detail where id_banner='".$request->id."' and id_eks='".(int)$eksportir."'");
          if(count($cekada) == 0){
              $storedetail = Banner_Detail::insert([
                      'id_banner' => $request->id,
                      'id_eks' => $eksportir,
                      'created_at' => $datenow
                      ]);
          }
        }
      }
      $data1 = [
                'end_at' => $request->s_date,
                'updated_at' => $datenow, 
                'status' => $request->status
              ];
      
      $cek1 = $request->file('file');
      if (isset($cek1)) {
          $filenya = $request->file('file');
          $extension1 = $filenya->getClientOriginalExtension();
          $filename1 = 'File'.uniqid().'.'.$extension1;
          $destinationPath1 =public_path() . "/uploads/banner";
          $filenya->move($destinationPath1, $filename1); // move file to our uploads path
          $data1['file'] = $filename1;
      }

      $update = Banner::where('id', $request->id)
              ->update($data1);

      
      $baliknya = 'sukses';
      return json_encode($baliknya);
    }
  }

  public function getData(Request $request)
  {
    $today = date("Y-m-d h:i:s");
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
              ->where('deleted_at', null)
              ->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();

      $totalFiltered = count($posts);
    }

    $data = array();
// dd($posts);
    if ($posts) {
      $count = $start+1;
      foreach ($posts as $d) {
        $token = csrf_token();
        $nestedData['no'] = $count;
        $nestedData['file'] = '<div class="thumbnail"><img src="'.asset('/uploads/banner/'.$d->file).'" alt="Lights" style="width:100%"></div>';
        // if($d->end_at != null){
        //   $nestedData['until'] = date('d-m-Y',strtotime($d->end_at));
        // }else{
        //   $nestedData['until'] = '-';
        // }
        $nestedData['until'] = isset($d->end_at) ? date('d-m-Y',strtotime($d->end_at)) : '-';
        if($d->status == 1 && $d->end_at >= $today ){
          $nestedData['status'] = 'Aktif';
          $nestedData['aksi'] = '<div class="btn-group">
                               <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEdit2" data-image-id = "'.$d->file.'" data-endat-id="'.date('d-m-Y',strtotime($d->end_at)).'" data-check-id="'.$d->status.'" data-edit-id="'.$d->id.'"><i class="fa fa-pencil"></i></button>
                               <a onclick="return confirm(\'Are You Sure ?\')"  href="'.url("/").'/master-banner/destroy/'.$d->id.'" class="btn btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a></div>';

        } else if($d->status == 2){
          $nestedData['status'] = 'Tidak Aktif';
          $nestedData['aksi'] = '<div class="btn-group">
                               <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEdit2" data-image-id = "'.$d->file.'" data-endat-id="'.date('d-m-Y',strtotime($d->end_at)).'" data-check-id="'.$d->status.'" data-edit-id="'.$d->id.'"><i class="fa fa-pencil"></i></button>
                               <a onclick="return confirm(\'Are You Sure ?\')"  href="'.url("/").'/master-banner/destroy/'.$d->id.'" class="btn btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a></div>';

        }
        else if($d->status == 0 ) {
          $nestedData['status'] = 'Tidak Aktif';
          $nestedData['aksi'] = '<div class="btn-group">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEdit" data-edit-id="'.$d->id.'"><i class="fa fa-pencil"></i></button>
                                <a onclick="return confirm(\'Are You Sure ?\')"  href="'.url("/").'/master-banner/destroy/'.$d->id.'" class="btn btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a></div>';
        }
        
                              // <button type="button" onclick="destroy('.$d->id.')" class="btn btn-sm btn-danger" title="Cetak"><i class="fa fa-trash"></i></button> </div>';
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
    // dd($banner->id_csc_product_level2);
    if (isset($banner->id_csc_product_level2)) {
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product_level2', $banner->id_csc_product_level2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else if(isset($banner->id_csc_product_level1)){
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product_level1', $banner->id_csc_product_level1)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else{
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product', $banner->id_csc_product)
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

  public function getCompany2(Request $request)
  {
    $banner = Banner::find($request->id);
    $banner_detail = Banner_Detail::where('id_banner',$request->id)->get();
    if (isset($banner->id_csc_product_level2)) {
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product_level2', $banner->id_csc_product_level2)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else if(isset($banner->id_csc_product_level1)){
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product_level1', $banner->id_csc_product_level1)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }else{
      $company = DB::table('csc_product_single')
                  ->join('itdp_profil_eks', 'csc_product_single.id_itdp_profil_eks','itdp_profil_eks.id')
                  ->where('csc_product_single.id_csc_product', $banner->id_csc_product)
                  ->select('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->groupBy('itdp_profil_eks.id', 'itdp_profil_eks.company')
                  ->orderBy('itdp_profil_eks.id', 'ASC')
                  ->get();
    }
    
    $no = 0;
    foreach ($company as $val) {
      if(Banner_Detail::where([['id_banner', '=',$request->id],['id_eks', '=',$val->id]])->exists()){
        $company[$no]->status = 1;
      }else{
        $company[$no]->status = 0;
      }
      $company[$no]->no = ($no+1);
      $no++;
    }
    
    return response()->json($company);
  }

  public function destroy(Request $request){
    date_default_timezone_set('Asia/Jakarta');
    $today = date("Y-m-d h:i:s");
    DB::table('banner')->where('id', $request->id)->update(['deleted_at'=>$today]);
    // $msg = ["status"=>"success"];
    // echo json_encode($msg);
    
    return redirect('master-banner')->with('error','Success Delete Data');
    
  }
}
