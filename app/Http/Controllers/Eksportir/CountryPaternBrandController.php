<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CountryPaternBrandController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Country Patern Brand";

        return view('eksportir.country_patern_brand.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $brand = DB::table('itdp_eks_product_brand')->get();
        $country = DB::table('mst_country')->get();
        $url = '/eksportir/country_patern_brand_save';
        $pageTitle = 'Tambah country patern brand';
        return view('eksportir.country_patern_brand.tambah', compact('country','pageTitle', 'url', 'brand'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_eks_country_patents')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_itdp_eks_product_brand' => $request->brand,
            'id_mst_country' => $request->country,
            'bulan' => $request->bulan,
            'tahun' => $request->year,
        ]);
        return redirect('eksportir/country_patern_brand');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_country_patents')
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('country_patern_brand.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('country_patern_brand.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('country_patern_brand.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $url = '/eksportir/country_patern_brand_update';
        $data = DB::table('itdp_eks_product_brand')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.country_patern_brand.edit', compact('pageTitle', 'data', 'url'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Sales';
        $data = DB::table('itdp_eks_product_brand')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.country_patern_brand.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_product_brand')->where('id', $id)
            ->delete();
        return redirect('eksportir/country_patern_brand');
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
        return redirect('eksportir/country_patern_brand');
    }
}
