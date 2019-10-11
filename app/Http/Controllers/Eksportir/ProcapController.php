<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProcapController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Product Capacity";

        return view('eksportir.procap.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $url = '/eksportir/procap_save';
        $pageTitle = 'Tambah Product Capacity';
        return view('eksportir.procap.tambah', compact('pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_eks_production')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->tahun,
            'sendiri_persen' => $request->persen_sendiri,
            'outsourcing_persen' => $request->out_persen,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/product_capacity');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', '=', Auth::user()->id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('procap.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('procap.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('procap.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $pageTitle = 'Detail Product Capacity';
        $url = '/eksportir/procap_update';

        $data = DB::table('itdp_eks_production')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.procap.edit', compact('pageTitle', 'data', 'url'));
    }

    public function view($id)
    {
//        dd($id);
        $pageTitle = 'Detail Country Patern Brand';
        $data = DB::table('itdp_eks_production')
            ->where('id', '=', $id)
            ->get();
        $brand = DB::table('itdp_eks_product_brand')->get();
        $country = DB::table('mst_country')->get();
//        dd($data);
        return view('eksportir.procap.view', compact('pageTitle', 'data', 'brand', 'country'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_production')->where('id', $id)
            ->delete();
        return redirect('eksportir/product_capacity');
    }

    public function update(Request $request)
    {
//        dd($request);
        DB::table('itdp_eks_production')->where('id', $request->id_sales)
            ->update([
                'tahun' => $request->tahun,
                'sendiri_persen' => $request->persen_sendiri,
                'outsourcing_persen' => $request->out_persen,
            ]);
        return redirect('eksportir/product_capacity');
    }
}
