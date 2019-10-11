<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BrandController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Brand";

        return view('eksportir.brand.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $url = '/eksportir/brand_save';
        $pageTitle = 'Tambah Brand';
        return view('eksportir.brand.tambah', compact('pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_eks_product_brand')->insert([
            'id_itdp_profil_eks' => $id_user,
            'merek' => $request->brand,
            'arti_merek' => $request->arti_brand,
            'bulan_merek' => $request->bulan,
            'tahun_merek' => $request->year,
            'paten_merek' => $request->copyright_number,
        ]);
        return redirect('eksportir/brand');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_product_brand')
            ->where('id_itdp_profil_eks', '=', Auth::user()->id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('brand.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('brand.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('brand.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
                    <i class="fa fa-trash text-white"></i> Delete
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($id)
    {
        $pageTitle = 'Detail Sales';
        $url = '/eksportir/brand_update';
        $data = DB::table('itdp_eks_product_brand')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.brand.edit', compact('pageTitle', 'data', 'url'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Sales';
        $data = DB::table('itdp_eks_product_brand')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.brand.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_product_brand')->where('id', $id)
            ->delete();
        return redirect('eksportir/brand');
    }

    public function update(Request $request)
    {
//        dd($request);
        DB::table('itdp_eks_product_brand')->where('id', $request->id_sales)
            ->update([
                'merek' => $request->brand,
                'arti_merek' => $request->arti_brand,
                'bulan_merek' => $request->bulan,
                'tahun_merek' => $request->year,
                'paten_merek' => $request->copyright_number,
            ]);
        return redirect('eksportir/brand');
    }
}
