<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class EksProductController extends Controller
{
    public function __construct()
    {
//         $this->middleware('auth');
//         $this->middleware('auth:eksmp', ['except' => array('view')]);
    }

    public function index()
    {
        $pageTitle = "Product";
        if(Auth::guard('eksmp')->user()){
            return view('eksportir.eksproduct.index', compact('pageTitle'));
        }else{
            return redirect('/home');
        }
    }

    public function index_admin($id)
    {
        $pageTitle = "Product";
        if(Auth::user()){
            $id_profil = $id;
            return view('eksportir.eksproduct.index_admin', compact('pageTitle', 'id_profil'));
        }else{
            return redirect('/home');
        }
    }
	
	public function product_unverif()
    {
        $pageTitle = "Product Unverification";
        if(Auth::user()){
            $id_profil = 0;
            return view('eksportir.eksproduct.index_admin_un', compact('pageTitle', 'id_profil'));
        }else{
            return redirect('/home');
        }
    }

    public function datanya()
    {
        if(Auth::guard('eksmp')->user()){
            $id_user = Auth::guard('eksmp')->user()->id;
            $user = DB::table('csc_product_single')
            ->where('id_itdp_company_user', '=', $id_user)
            ->where('status', '!=', 9)
//            ->orderBy('product_description_en', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('information', function ($mjl) {
                    $ket = "-";
                    if($mjl->status == 2 || $mjl->status == 3){
                        if($mjl->keterangan != NULL){
                            $ket = $mjl->keterangan;
                        }
                    }

                    return $ket;
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
                        return "Publish - Not Verified";
                    }else if($mjl->status == 2){
                        return "Publish - Verified";
                    }else if($mjl->status == 3){
                        return "Publish - Verification Rejected";
                    }else{
                        return "Hide";
                    }
                })
                ->addColumn('action', function ($mjl) {
                    $edit = '<a href="' . route('eksproduct.edit', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>';
//                    if($mjl->status == 2){
//                        $edit = '<button class="btn btn-sm btn-success" title="Edit" disabled><i class="fa fa-edit text-white"></i></button>';
//                    }
                    return '
                    <center>
                    <a href="' . route('eksproduct.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                        <i class="fa fa-eye text-white"></i>
                    </a>
                    '.$edit.'
                    <a href="' . route('eksproduct.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                        <i class="fa fa-trash text-white"></i>
                    </a>
                    </center>
                    ';
                })
                ->rawColumns(['action', 'product_description'])
                ->make(true);
        }
    }

    public function datanya_admin($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            $user = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('itdp_company_users.id_profil', $id)
            ->orderBy('csc_product_single.created_at', 'DESC')
//            ->orderBy('csc_product_single.id_itdp_company_user', 'ASC')
            ->get();

            return \Yajra\DataTables\DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('prodname_en', function ($mjl) {
                
                return '<div align="left">'.$mjl->prodname_en.'</div>';
            })
			->addColumn('information', function ($mjl) {
                $ket = "-";
                if($mjl->status == 2 || $mjl->status == 3){
                    if($mjl->keterangan != NULL){
                        $ket = $mjl->keterangan;
                    }
                }

                return $ket;
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
            ->addColumn('company_name', function ($mjl) {
                $name = "";
                if($mjl->id_itdp_company_user != NULL){
                    $companynya = DB::table('itdp_company_users')
                        ->where('id', $mjl->id_itdp_company_user)
                        ->first();
                    if($companynya){
                        $profiles = DB::table('itdp_profil_eks')->where('id', $companynya->id_profil)->first();
                        if($profiles){
                            $name = $profiles->company;
                        }
                    }
                }
                return $name;
            })
            ->addColumn('status', function ($mjl) {
                if($mjl->status == 1){
                    return "Publish - Not Verified";
                }else if($mjl->status == 2){
                    return "Publish - Verified";
                }else if($mjl->status == 3){
                    return "Publish - Verification Rejected";
                }else if($mjl->status == 9){
                        return "Unpublish - Verified";
                }else{
                    return "Hide";
                }
            })
            ->addColumn('action', function ($mjl) {
                if($mjl->status == 1){
                    return '
                    <center>
                    <a href="' . route('eksproduct.verifikasi', $mjl->id) . '" class="btn btn-sm btn-success" title="Verification">
                        <i class="fa fa-check text-white"></i>
                    </a>
                    <a href="' . route('eksproduct.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                        <i class="fa fa-eye text-white"></i>
                    </a>
                    </center>
                    ';
                }else{
                    return '
                    <center>
                    <a href="' . route('eksproduct.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                        <i class="fa fa-eye text-white"></i>
                    </a>
                    </center>
                    ';
                }

            })
            ->rawColumns(['action', 'product_description','prodname_en'])
            ->make(true);
        }
    }

	public function datanya_admin_un($id)
    {
        if(Auth::user()){
           //  $id_user = Auth::user()->id;
            $user = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->leftjoin('itdp_profil_eks','itdp_profil_eks.id','itdp_company_users.id_profil')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company','itdp_profil_eks.company')
            ->where('csc_product_single.status', 1)
            // ->where('itdp_company_users.id_profil', $id)
            ->orderBy('csc_product_single.created_at', 'DESC')
//            ->orderBy('csc_product_single.id_itdp_company_user', 'ASC')
            ->get();

            return \Yajra\DataTables\DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('prodname_en', function ($mjl) {
                
                return '<div align="left">'.$mjl->prodname_en.'</div>';
            })
			->addColumn('information', function ($mjl) {
                $ket = "-";
                if($mjl->status == 2 || $mjl->status == 3){
                    if($mjl->keterangan != NULL){
                        $ket = $mjl->keterangan;
                    }
                }

                return $ket;
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
            ->addColumn('company_name', function ($mjl) {
                $name = "";
                if($mjl->company != NULL){
                    $name = $mjl->company;
                }else{
                    $name = "";
                }
                // if($mjl->id_itdp_company_user != NULL){
                //     $companynya = DB::table('itdp_company_users')
                //         ->where('id', $mjl->id_itdp_company_user)
                //         ->first();
                //     if($companynya){
                //         $profiles = DB::table('itdp_profil_eks')->where('id', $companynya->id_profil)->first();
                //         if($profiles){
                //             $name = $profiles->company;
                //         }
                //     }
                // }
                return $name;
            })
            ->addColumn('status', function ($mjl) {
                if($mjl->status == 1){
                    return "Publish - Not Verified";
                }else if($mjl->status == 2){
                    return "Publish - Verified";
                }else if($mjl->status == 3){
                    return "Publish - Verification Rejected";
                }else if($mjl->status == 9){
                        return "Unpublish - Verified";
                }else{
                    return "Hide";
                }
            })
            ->addColumn('action', function ($mjl) {
                if($mjl->status == 1){
                    return '
                    <center>
                    <a href="' . route('eksproduct.verifikasi', $mjl->id) . '" class="btn btn-sm btn-success" title="Verification">
                        <i class="fa fa-check text-white"></i>
                    </a>
                    <a href="' . route('eksproduct.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                        <i class="fa fa-eye text-white"></i>
                    </a>
                    </center>
                    ';
                }else{
                    return '
                    <center>
                    <a href="' . route('eksproduct.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                        <i class="fa fa-eye text-white"></i>
                    </a>
                    </center>
                    ';
                }

            })
            ->rawColumns(['action', 'product_description','prodname_en'])
            ->make(true);
        }
    }

    public function tambah()
    {
        if(Auth::guard('eksmp')->user()){
            $url = '/eksportir/product_save';
            $pageTitle = 'Add Product';
            $hsco = DB::table('mst_hscodes')->orderBy('desc_eng', 'ASC')->limit(10)->get();
            $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
            return view('eksportir.eksproduct.tambah', compact('pageTitle', 'url', 'catprod', 'hsco'));
        }else{
            return redirect('eksportir/product');
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        if(Auth::guard('eksmp')->user()){
            $id_user = Auth::guard('eksmp')->user()->id;
            $id_profil = Auth::guard('eksmp')->user()->id_profil;

            $save = DB::table('csc_product_single')->insertGetId([
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
                'price_usd' => $request->price_usd,
                'id_mst_hscodes' => $request->hscode,
                'id_itdp_profil_eks' => $id_profil,
                'id_itdp_company_user' => $id_user,
                'minimum_order' => $request->minimum_order,
                'product_description_en' => $request->product_description_en,
                'product_description_in' => $request->product_description_in,
                'product_description_chn' => $request->product_description_chn,
                'status' => $request->status,
                'created_at' => $datenow,
            ]);

            $nama_file1 = NULL;
            $nama_file2 = NULL;
            $nama_file3 = NULL;
            $nama_file4 = NULL;

            $destination= 'uploads\Eksportir_Product\Image\\'.$save;
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

            $savefile = DB::table('csc_product_single')->where('id', $save)->update([
                'image_1' => $nama_file1,
                'image_2' => $nama_file2,
                'image_3' => $nama_file3,
                'image_4' => $nama_file4,
            ]);

            if($save && $request->status == "1"){
                $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
                $users_email = [];
                foreach ($admin as $adm) {
                    $admname = $adm->name;

                    array_push($users_email, $adm->email);
                }
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyName($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => "Admin",
                    'untuk_id' => 1,
                    'keterangan' => 'New Product Published By '.getCompanyName($id_user).' with Title  "'.$request->prodname_en.'"',
                    'url_terkait' => 'eksportir/verifikasi_product',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'id_terkait' => $save,
                    'to_role' => 1,
                ]);

                //Tinggal Ganti Email1 dengan email kemendag
//                $data = [
//                    'company' => getCompanyName($id_user),
//                    'dari' => "Eksportir"
//                ];
//
//                Mail::send('eksportir.eksproduct.sendToAdmin', $data, function ($mail) use ($data, $users_email) {
//                    $mail->subject('Product Information');
//                    $mail->to($users_email);
//                });
            }

        }

        return redirect('eksportir/product')->with('success','Success Add Data');
    }


    public function edit($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = 'Edit Product';
            $url = '/eksportir/product_update/'.$id;

            $data = DB::table('csc_product_single')->where('id', '=', $id)->first();
            if($data->status == 9){ return redirect('/eksportir/product'); }
            $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
            $catprod2 = DB::table('csc_product')->whereNotNull('level_1')->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
            $catprod3 = DB::table('csc_product')->whereNotNull('level_1')->whereNotNull('level_2')->orderBy('nama_kategori_en', 'ASC')->get();
            $hsco = DB::table('mst_hscodes')->orderBy('desc_eng', 'ASC')->get();
            return view('eksportir.eksproduct.edit', compact('pageTitle', 'data', 'url', 'catprod', 'catprod2', 'catprod3', 'hsco'));
        }else{
            return redirect('eksportir/product');
        }
    }

    public function view($id)
    {
//        dd($id);
//        if(empty(Auth::guard('eksmp')->user()) or empty(Auth::user()->id)){
//            return redirect('/login');
//        }else{
        if (Auth::guard('eksmp')->user() || Auth::user()) {
            if (Auth::guard('eksmp')->user()) {
//                dd('tes');
                $jenis = "eksportir";
                $id_user = Auth::guard('eksmp')->user()->id;
            } else {
                $jenis = "admin";
                $id_user = Auth::user()->id;
            }
        } else {
            return redirect('/login');
        }
//        }


        $pageTitle = 'Detail Product';
        $data = DB::table('csc_product_single')
            ->where('id', '=', $id)
            ->first();

        if($data->status == 9 && $jenis == "eksportir"){ return redirect('/eksportir/product'); }


        //Read Notification
        $admin = DB::table('itdp_admin_users')->where('id_group', 1)->get();
        foreach ($admin as $adm) {
            DB::table('notif')->where('dari_id', $adm->id)->where('url_terkait', 'eksportir/product_view')->where('id_terkait', $id)->where('untuk_id', $id_user)->update([
                'status_baca' => 1,
            ]);
        }

        $id_profil = $data->id_itdp_profil_eks;
        $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod2 = DB::table('csc_product')->whereNotNull('level_1')->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod3 = DB::table('csc_product')->whereNotNull('level_1')->whereNotNull('level_2')->orderBy('nama_kategori_en', 'ASC')->get();
        $hsco = DB::table('mst_hscodes')->where('id', $data->id_mst_hscodes)->first();
        return view('eksportir.eksproduct.view', compact('pageTitle', 'data', 'catprod', 'catprod2', 'catprod3', 'jenis', 'id_profil', 'hsco'));
    }

    public function delete($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 2){
            $cek = DB::table('csc_product_single')->where('id', $id)->first();
            if($cek->status == 2 || $cek->status == 9){
                $delete = DB::table('csc_product_single')->where('id', $id)->update(['status' => 9]);
            } else {
                $delete = DB::table('csc_product_single')->where('id', $id)->delete();
            }
            if($delete)
                return redirect('eksportir/product')->with('error','Success Delete Data');
            else
                return redirect('eksportir/product')->with('error','Failed Delete Data');
        }else{
            return redirect('eksportir/product')->with('error','Success Delete Data');
        }
    }

    public function update($id, Request $request)
    {
        if(Auth::guard('eksmp')->user()){
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
                'price_usd' => $request->price_usd,
                'id_mst_hscodes' => $request->hscode,
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
        }
        return redirect('eksportir/product')->with('success','Success Update Data');
    }

    public function verifikasi($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            $pageTitle = 'Verification Product';
            $url = '/eksportir/actver_product/'.$id;
            $jenis = "admin";

            $data = DB::table('csc_product_single')->where('id', '=', $id)->first();
            if($data->status == 2){
                return redirect('eksportir/product_admin/'.$data->id_itdp_profil_eks);
            }

            //Read Notification
            DB::table('notif')->where('dari_id', $data->id_itdp_company_user)->where('url_terkait', 'eksportir/verifikasi_product')->where('id_terkait', $id)->where('untuk_id', $id_user)->update([
                'status_baca' => 1,
            ]);

            $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
            $catprod2 = DB::table('csc_product')->whereNotNull('level_1')->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
            $catprod3 = DB::table('csc_product')->whereNotNull('level_1')->whereNotNull('level_2')->orderBy('nama_kategori_en', 'ASC')->get();
            $hsco = DB::table('mst_hscodes')->where('id', $data->id_mst_hscodes)->first();
            return view('eksportir.eksproduct.verifikasi', compact('pageTitle', 'data', 'url', 'catprod', 'catprod2', 'catprod3', 'jenis', 'hsco'));
        }else{
//            return redirect('eksportir/product');
            return redirect('login');
        }
    }

    public function verifikasi_act($id, Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        if(Auth::user()){
            $id_user = Auth::user()->id;
            $datenow = date("Y-m-d H:i:s");

            $data = DB::table('csc_product_single')->where('id', $id)->first();
			$carieks = DB::select("select email from itdp_company_users where id='".$data->id_itdp_company_user."'");
			foreach($carieks as $teks){
				$maileks = $teks->email;
			}
            $verifikasi = $request->verifikasi;
            // var_dump($verifikasi);
            if($verifikasi == '1'){
                $status = 2;
                $ket = "This product has been added on the front page";
                $notifnya = "has been accepted";
				$ket = "Your product ".$data->prodname_en." got verified";
				$ket2 = $data->prodname_en." has been accepted by Super Admin";
//				$insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//				('2','Super Admin','1','Eksportir','".$data->id_itdp_company_user."','".$ket."','eksportir/product_view','".$id."','".Date('Y-m-d H:m:s')."','0')
//				");
                $insertnotif = DB::table('notif')->insert([
                            'dari_nama' => 'Super Admin',
                            'dari_id' => 1,
                            'untuk_nama' => 'Eksportir',
                            'untuk_id' => $data->id_itdp_company_user,
                            'keterangan' => $ket2,
                            'url_terkait' => 'eksportir/product_view',
                            'id_terkait' => $id,
                            'status_baca' => 0,
                            'waktu' => $datenow,
                            'to_role' => 2,
                        ]);
    //             $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
				// ('2','Super Admin','1','Eksportir','".$data->id_itdp_company_user."','".$ket2."','eksportir/product_view','".$id."','".Date('Y-m-d H:m:s')."','0')
				// ");
			$data33 = [
            'email' => "",
            'email1' => $maileks,
            'username' => $data->prodname_en,
            'main_messages' => "",
            'id' => $id
			];
//			Mail::send('UM.user.sendproduct', $data33, function ($mail) use ($data33) {
//			$mail->to($data33['email1'], $data33['username']);
//			$mail->subject("Your product got verified");
//			});
			Mail::send('UM.user.sendproduct2', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject("Your product got verified");
            });
			// echo $data->prodname_en;die();
            // harus dipisah jangan disatu dengan yang bawah, product yang di decline bisa error kalo digabung dengan atas
            $update = DB::table('csc_product_single')->where('id', $id)->update([
                'id_csc_product' => $request->id_csc_product,
                'id_csc_product_level1' => $request->id_csc_product_level1,
                'id_csc_product_level2' => $request->id_csc_product_level2,
                'status' => $status,
                'keterangan' => $ket,
                'updated_at' => $datenow,
            ]);

            }else{
                $keterangan = $request->keterangan;
                // var_dump($keterangan);
                $status = 3;
                $ket = "The product that you added cannot be displayed on the front page because ".$keterangan;
                $notifnya = "has been declined";
                // harus dipisah jangan disatu dengan yang atas, product yang di decline bisa error kalo digabung dengan atas
                $update = DB::table('csc_product_single')->where('id', $id)->update([
                    'status' => $status,
                    'keterangan' => $ket,
                    'updated_at' => $datenow,
                ]);
    
            }

            // var_dump($status);
            // var_dump($ket);
            // die();
            
            if($update){
                $pengirim = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                $notif = DB::table('notif')->insert([
                    'dari_nama' => $pengirim->name,
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyName($data->id_itdp_company_user),
                    'untuk_id' => $data->id_itdp_company_user,
                    'keterangan' => 'Product '.$data->prodname_en.' '.$notifnya.' by Admin',
                    'url_terkait' => 'eksportir/product_view',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'id_terkait' => $id,
                    'to_role' => 2,
                ]);
            }
        }

        return redirect('eksportir/product_admin/'.$data->id_itdp_profil_eks);
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
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag2" onclick="getSub(2,'.$value->level_1.', '.$value->id.','.$nama.', event)" id="kat2_'.$value->id.'" data-value="'.$value->id.'">'.$value->nama_kategori_en.'</a>';
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
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag3" onclick="getSub(3,'.$value->level_1.', '.$value->id.','.$nama.', event)" id="kat3_'.$value->id.'" data-value="'.$value->id.'">'.$value->nama_kategori_en.'</a>';
                }
            }else{
                $result .= 'Category Not Found';
            }
        }
        return $result;
    }

    public function searchsub(Request $request){
        $level = $request->level;
        if($level == 1){
            $result = '';
            $catprod = DB::table('csc_product')->where('level_1',0)->where('level_2',0)->where('nama_kategori_en',  'ilike', '%' . $request->text . '%')->orderBy('nama_kategori_en', 'ASC')->get();
            if(count($catprod) > 0){
                foreach ($catprod as $key => $value) {
                    $nama = "'".$value->nama_kategori_en."'";
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag1" onclick="getSub(1,'.$value->id.','.$value->id.','.$nama.', event)" id="kat1_'.$value->id.'" data-value="'.$value->id.'">'.$value->nama_kategori_en.'</a>';
                }
            }else{
                $result .= 'Category Not Found';
            }
        }
        elseif($level == 2){
            $result = '';
            $catprod = DB::table('csc_product')->where('level_1', $request->parent)->where('level_2',0)->where('nama_kategori_en',  'ilike', '%' . $request->text . '%')->orderBy('nama_kategori_en', 'ASC')->get();
            if(count($catprod) > 0){
                foreach ($catprod as $key => $value) {
                    $nama = "'".$value->nama_kategori_en."'";
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag2" onclick="getSub(2,'.$value->level_1.','.$value->id.','.$nama.', event)" id="kat2_'.$value->id.'" data-value="'.$value->id.'">'.$value->nama_kategori_en.'</a>';
                }
            }else{
                $result .= 'Category Not Found';
            }
        }else{
            $result = '';
            $catprod = DB::table('csc_product')->where('level_1', $request->parent2)->where('level_2', $request->parent)->where('nama_kategori_en',  'ilike', '%' . $request->text . '%')->orderBy('nama_kategori_en', 'ASC')->get();
            if(count($catprod) > 0){
                foreach ($catprod as $key => $value) {
                    $nama = "'".$value->nama_kategori_en."'";
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag3" onclick="getSub(3,'.$value->level_1.','.$value->id.','.$nama.', event)" id="kat3_'.$value->id.'" data-value="'.$value->id.'">'.$value->nama_kategori_en.'</a>';
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

    public function getHsCode(Request $request)
    {
        $hscode = DB::table('mst_hscodes')
                ->select('id', 'desc_eng','fullhs')
                ->orderby('desc_eng', 'asc');
        if (isset($request->q)) {
            $search = $request->q;
            $hscode->where(function ($query) use ($search) {
                $query->where('fullhs', 'like', '%' . $search . '%')
                    ->orwhere('desc_eng','ilike','%'.$search.'%');
            });
            //          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
//            $hscode->where('desc_eng', 'ILIKE', '%'.$request->q.'%');
        } else if (isset($request->code)) {
            $hscode->where('id', $request->code);
        } else {
            $hscode->limit(10);
        }
        return response()->json($hscode->get());
    }
}
