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
        $pageTitle = 'Add Product Capacity';
        return view('eksportir.procap.tambah', compact('pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_production')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->tahun,
            'sendiri_persen' => $request->persen_sendiri,
            'outsourcing_persen' => $request->out_persen,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/product_capacity')->with('success','Success Add Data');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('procap.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                <a href="' . route('procap.detail', $mjl->id) . '" class="btn btn-sm btn-success" title="Edit">
                    <i class="fa fa-edit text-white"></i> 
                </a>
                <a href="' . route('procap.delete', $mjl->id) . '" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-sm btn-danger" title="Delete">
                    <i class="fa fa-trash text-white"></i> 
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
        return redirect('eksportir/product_capacity')->with('error','Success Add Data');
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
        return redirect('eksportir/product_capacity')->with('success','Success Update Data');
    }

    public function indexadmin($id)
    {
//        dd($id);
        $pageTitle = "Product Capacity";

        return view('eksportir.procap.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_production')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('procap.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
