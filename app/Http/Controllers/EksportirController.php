<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EksportirController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Annual Sales";

        return view('eksportir.annual_sales.index', compact('pageTitle'));
    }

    public function tambahannual()
    {

//        dd($id_user);
        $url = '/annual_save';
        $pageTitle = 'Tambah Annual Sales';
        return view('eksportir.annual_sales.tambah', compact('pageTitle', 'url'));
    }

    public function storeannual(Request $request)
    {
        $id_user = Auth::user()->id;
//        dd($request);
        $insert = DB::table('itdp_eks_sales')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'nilai' => $request->value,
            'nilai_persen' => $request->persen,
            'nilai_ekspor' => $request->nilai_ekspor,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('annual_sales');
    }

    public function datanya()
    {
//        $dokumen = DB::table('document_type')->get();
        $user = DB::table('itdp_eks_sales')
            ->get();

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
                <a href="' . route('sales.detail', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $url = '/sales_update';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.edit', compact('pageTitle', 'data', 'url'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Sales';
        $url = '/sales_update';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.view', compact('pageTitle', 'data', 'url'));
    }

    public function updateannual(Request $request)
    {
//        dd($request);
        $update = DB::table('itdp_eks_sales')->where('id', $request->id_sales)
            ->update([
                'tahun' => $request->year,
                'nilai' => $request->value,
                'nilai_persen' => $request->persen,
                'nilai_ekspor' => $request->nilai_ekspor,
            ]);
        return redirect('annual_sales');
    }
}
