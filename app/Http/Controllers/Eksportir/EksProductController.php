<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EksProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
    }

    public function index()
    {
        $pageTitle = "Product";
        return view('eksportir.eksproduct.index', compact('pageTitle'));
    }

    public function datanya()
    {
        $id_user = Auth::guard('eksmp')->user()->id;
        $user = DB::table('csc_product_single')
            ->where('id_itdp_company_user', '=', $id_user)//komen dulu blm kebaca loginnya
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('information', function ($mjl) {
                return "";
            })
            ->addColumn('product_description', function ($mjl) {
                if($mjl->product_description_en != NULL){
                    $num_char = 70;
                    $text = $mjl->product_description_en;
                    if(strlen($text) > 70){
                        $cut_text = substr($text, 0, $num_char);
                        if ($text{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                            $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                            $cut_text = substr($text, 0, $new_pos);
                        }
                        return $cut_text . '...';
                    }else{
                        return $text;
                    }
                }else{
                    return "";
                }
            })
            ->addColumn('status', function ($mjl) {
                if($mjl->status == 1){
                    return "Publish";
                }else{
                    return "Hide";
                }
            })
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('eksproduct.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('eksproduct.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('eksproduct.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
                    <i class="fa fa-trash text-white"></i> Delete
                </a>
                </center>
                ';
            })
            ->rawColumns(['action', 'product_description'])
            ->make(true);
    }

    public function tambah()
    {
//        dd($id_user);
        $url = '/eksportir/product_save';
        $pageTitle = 'Tambah Product';
        $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        return view('eksportir.eksproduct.tambah', compact('pageTitle', 'url', 'catprod'));
    }

    public function store(Request $request)
    {
        $id_user = Auth::guard('eksmp')->user()->id;
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        $datenow = date("Y-m-d H:i:s");

        $idn = DB::table('csc_product_single')->max('id');
        $idnew = $idn + 1;

        $nama_file1 = NULL;
        $nama_file2 = NULL;
        $nama_file3 = NULL;
        $nama_file4 = NULL;

        $destination= 'uploads\Eksportir_Product\Image\\'.$idnew;
        if($request->hasFile('image_1')){ 
            $file1 = $request->file('image_1');
            $nama_file1 = time().'_'.$request->prodname_en.'_'.$request->file('image_1')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        if($request->hasFile('image_2')){ 
            $file2 = $request->file('image_2');
            $nama_file2 = time().'_'.$request->prodname_en.'_'.$request->file('image_2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
        }

        if($request->hasFile('image_3')){ 
            $file3 = $request->file('image_3');
            $nama_file3 = time().'_'.$request->prodname_en.'_'.$request->file('image_3')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
        }

        if($request->hasFile('image_4')){ 
            $file4 = $request->file('image_4');
            $nama_file4 = time().'_'.$request->prodname_en.'_'.$request->file('image_4')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
        }


        DB::table('csc_product_single')->insert([
            'id' => $idnew,
            'id_csc_product' => $request->id_csc_product,
            'id_csc_product_level1' => $request->id_csc_product_level1,
            'id_csc_product_level2' => $request->id_csc_product_level2,
            'prodname_en' => $request->prodname_en,
            'prodname_in' => $request->prodname_in,
            'prodname_chn' => $request->prodname_chn,
            'code_en' => $request->code,
            'code_in' => $request->code,
            'code_chn' => $request->code_,
            'color_en' => $request->color_en,
            'color_in' => $request->color_in,
            'color_chn' => $request->color_chn,
            'size_en' => $request->size_en,
            'size_in' => $request->size_in,
            'size_chn' => $request->size_chn,
            'raw_material_en' => $request->raw_material_en,
            'raw_material_in' => $request->raw_material_in,
            'raw_material_chn' => $request->raw_material_chn,
            'capacity' => $request->capacity,
            'price_usd' => $this->setValue($request->price_usd),
            'image_1' => $nama_file1,
            'image_2' => $nama_file2,
            'image_3' => $nama_file3,
            'image_4' => $nama_file4,
            'id_itdp_profil_eks' => $id_profil,
            'id_itdp_company_user' => $id_user,
            'minimum_order' => $request->minimum_order,
            'product_description_en' => $request->product_description_en,
            'product_description_in' => $request->product_description_in,
            'product_description_chn' => $request->product_description_chn,
            'status' => $request->status,
            'created_at' => $datenow,
        ]);
        return redirect('eksportir/product');
    }


    public function edit($id)
    {
        $pageTitle = 'Edit Product';
        $url = '/eksportir/product_update/'.$id;

        $data = DB::table('csc_product_single')->where('id', '=', $id)->first();
        $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod2 = DB::table('csc_product')->whereNotNull('level_1')->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod3 = DB::table('csc_product')->whereNotNull('level_1')->whereNotNull('level_2')->orderBy('nama_kategori_en', 'ASC')->get();
        return view('eksportir.eksproduct.edit', compact('pageTitle', 'data', 'url', 'catprod', 'catprod2', 'catprod3'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Product';
        $data = DB::table('csc_product_single')
            ->where('id', '=', $id)
            ->first();
        $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod2 = DB::table('csc_product')->whereNotNull('level_1')->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod3 = DB::table('csc_product')->whereNotNull('level_1')->whereNotNull('level_2')->orderBy('nama_kategori_en', 'ASC')->get();
        return view('eksportir.eksproduct.view', compact('pageTitle', 'data', 'catprod', 'catprod2', 'catprod3'));
    }

    public function delete($id)
    {
        DB::table('csc_product_single')->where('id', $id)
            ->delete();
        return redirect('eksportir/product');
    }

    public function update($id, Request $request)
    {
        $id_user = Auth::guard('eksmp')->user()->id;
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        $datenow = date("Y-m-d H:i:s");

        $dtawal = DB::table('csc_product_single')->where('id', $id)->first();

        $destination= 'uploads\Eksportir_Product\Image\\'.$id;
        if($request->hasFile('image_1')){ 
            $file1 = $request->file('image_1');
            $nama_file1 = time().'_'.$request->prodname_en.'_'.$request->file('image_1')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }else{
            $nama_file1 = $dtawal->image_1;
        }

        if($request->hasFile('image_2')){ 
            $file2 = $request->file('image_2');
            $nama_file2 = time().'_'.$request->prodname_en.'_'.$request->file('image_2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
        }else{
            $nama_file2 = $dtawal->image_2;
        }

        if($request->hasFile('image_3')){ 
            $file3 = $request->file('image_3');
            $nama_file3 = time().'_'.$request->prodname_en.'_'.$request->file('image_3')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
        }else{
            $nama_file3 = $dtawal->image_3;
        }

        if($request->hasFile('image_4')){ 
            $file4 = $request->file('image_4');
            $nama_file4 = time().'_'.$request->prodname_en.'_'.$request->file('image_4')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
        }else{
            $nama_file4 = $dtawal->image_4;
        }


        DB::table('csc_product_single')->where('id', $id)->update([
            'id_csc_product' => $request->id_csc_product,
            'id_csc_product_level1' => $request->id_csc_product_level1,
            'id_csc_product_level2' => $request->id_csc_product_level2,
            'prodname_en' => $request->prodname_en,
            'prodname_in' => $request->prodname_in,
            'prodname_chn' => $request->prodname_chn,
            'code_en' => $request->code,
            'code_in' => $request->code,
            'code_chn' => $request->code_,
            'color_en' => $request->color_en,
            'color_in' => $request->color_in,
            'color_chn' => $request->color_chn,
            'size_en' => $request->size_en,
            'size_in' => $request->size_in,
            'size_chn' => $request->size_chn,
            'raw_material_en' => $request->raw_material_en,
            'raw_material_in' => $request->raw_material_in,
            'raw_material_chn' => $request->raw_material_chn,
            'capacity' => $request->capacity,
            'price_usd' => $this->setValue($request->price_usd),
            'image_1' => $nama_file1,
            'image_2' => $nama_file2,
            'image_3' => $nama_file3,
            'image_4' => $nama_file4,
            'minimum_order' => $request->minimum_order,
            'product_description_en' => $request->product_description_en,
            'product_description_in' => $request->product_description_in,
            'product_description_chn' => $request->product_description_chn,
            'status' => $request->status,
            'updated_at' => $datenow,
        ]);

        return redirect('eksportir/product');
    }

    public function getSub(Request $request)
    {
        $level = $request->level;
        if($level == 1){
            $result = '';
            $catprod = DB::table('csc_product')->where('level_1', $request->idparent)->orderBy('nama_kategori_en', 'ASC')->get();
            if(count($catprod) > 0){
                foreach ($catprod as $key => $value) {
                    $nama = "'".$value->nama_kategori_en."'";
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag2" onclick="getSub(2,'.$value->level_1.', '.$value->id.','.$nama.')" id="kat2_'.$value->id.'">'.$value->nama_kategori_en.'</a>';
                }
            }else{
                $result .= 'Category Not Found';
            }
        }else{
            $result = '';
            $catprod = DB::table('csc_product')->where('level_2', $request->idparent)->where('level_1', $request->idsub)->orderBy('nama_kategori_en', 'ASC')->get();
            if(count($catprod) > 0){
                foreach ($catprod as $key => $value) {
                    $nama = "'".$value->nama_kategori_en."'";
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag3" onclick="getSub(3,'.$value->level_1.', '.$value->id.','.$nama.')" id="kat3_'.$value->id.'">'.$value->nama_kategori_en.'</a>';
                }
            }else{
                $result .= 'Category Not Found';
            }
        }
        return $result;
    }

    function setValue($value)
    {
        $value = str_replace('.', '', $value);

        return (int)$value;
    }
}
