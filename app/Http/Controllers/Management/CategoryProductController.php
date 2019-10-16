<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class CategoryProductController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Category Product';
      $product = DB::table('csc_product')->orderby('nama_kategori_en', 'asc')->get();
      return view('management.category-product.index',compact('pageTitle','product'));
    }

    public function getData()
    {
      $product = DB::table('csc_product')->orderby('nama_kategori_en', 'asc')->get();

      return \Yajra\DataTables\DataTables::of($product)
          ->addIndexColumn()
          ->addColumn('action', function ($data) {
              return '
              <center>
              <div class="btn-group">
                <a href="'.route('management.category-product.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                <a href="'.route('management.category-product.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Data Ini ?\')" href="'.route('management.category-product.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
              </div>
              </center>
              ';
          })
          ->rawColumns(['action'])
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'Category Product';
      $page = 'create';
      $url = "/management-category-product/store/Create";
      $level_1 = DB::table('csc_product')->where('level_2', 0)->orderby('nama_kategori_en', 'asc')->get();
      return view('management.category-product.create',compact('url','pageTitle','page','level_1'));
    }

    public function store(Request $req, $param)
    {
      $id = DB::table('csc_product')->orderby('id','desc')->first();
      if($id){ $id = $id->id+1; } else { $id = 1; }
      if($req->level_2 == 0){
        $level_1 = $req->level_1;
        $level_2 = 0;
      } else {
        $level_1 = $req->level_2;
        $level_2 = $req->level_1;
      }

      if($param == 'Create'){
        $data = DB::table('csc_product')->insert([
          'id' => $id,
          'level_1' => $level_1,
          'level_2' => $level_2,
          'nama_kategori_en' => $req->product_en,
          'nama_kategori_in' => $req->product_in,
          'nama_kategori_chn' => $req->product_chn,
          'type' => $req->type
        ]);
      } else {
        $pecah = explode('_', $param);
        $param = $pecah[0];

        $data = DB::table('csc_product')->where('id', $pecah[1])->update([
          'level_1' => $level_1,
          'level_2' => $level_2,
          'nama_kategori_en' => $req->product_en,
          'nama_kategori_in' => $req->product_in,
          'nama_kategori_chn' => $req->product_chn,
          'type' => $req->type
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.' Data');
         return redirect('management-category-product/');
       }else{
         Session::flash('failed','Failed '.$param.' Data');
         return redirect('management-category-product/');
       }
    }

    public function view($id)
    {
      $pageTitle = "Category Product";
      $page = "view";
      $data = DB::table('csc_product')->where('id', $id)->first();
      $level_1 = DB::table('csc_product')->where('level_2', 0)->orderby('nama_kategori_en', 'asc')->get();
      return view('management.category-product.create',compact('page','data','pageTitle','level_1'));
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Category Product";
      $url = "/management-category-product/store/Update_".$id;
      $data = DB::table('csc_product')->where('id', $id)->first();
      $level_1 = DB::table('csc_product')->where('level_2', 0)->orderby('nama_kategori_en', 'asc')->get();
      return view('management.category-product.create',compact('url','data','pageTitle','page','level_1'));
    }

    public function destroy($id)
    {
      $data = DB::table('csc_product')->where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('management-category-product/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('management-category-product/');
       }
    }

    public function level_2(Request $req){
      $checking = DB::table('csc_product')
                ->where('level_1', $req->id)
                ->whereNotIn('id', [$req->except])
                ->orderby('nama_kategori_en', 'asc')->get();
      
      $data = '<option value="0">Main Sub Hierarchy</option>';
      if($checking){
        foreach ($checking as $val) {
          $data .= '<option value="'.$val->id.'">'.$val->nama_kategori_en.'</option>';
        }
      }
      echo json_encode($data);
    }
}
