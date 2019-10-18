<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnnualController extends Controller
{
    public function index()
    {
//        $id_user = Auth::guard('eksmp')->user()->id;
//        dd($id_user);
//        dd("mantap");die();
        $pageTitle = "Annual Sales";

        return view('eksportir.annual_sales.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $url = '/eksportir/annual_save';
        $pageTitle = 'Tambah Annual Sales';
        return view('eksportir.annual_sales.tambah', compact('pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id;
        DB::table('itdp_eks_sales')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'nilai' => $request->value,
            'nilai_persen' => $request->persen,
            'nilai_ekspor' => $request->nilai_ekspor,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/annual_sales');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id)
        ->
        get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('sales.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('sales.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $url = '/eksportir/sales_update';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.edit', compact('pageTitle', 'data', 'url'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Sales';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_sales')->where('id', $id)
            ->delete();
        return redirect('eksportir/annual_sales');
    }

    public function update(Request $request)
    {
//        dd($request);
        DB::table('itdp_eks_sales')->where('id', $request->id_sales)
            ->update([
                'tahun' => $request->year,
                'nilai' => $request->value,
                'nilai_persen' => $request->persen,
                'nilai_ekspor' => $request->nilai_ekspor,
            ]);
        return redirect('eksportir/annual_sales');
    }
}
