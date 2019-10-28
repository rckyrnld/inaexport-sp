<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaxesController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Taxes";

        return view('eksportir.taxes.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $ldate = date('Y');
//        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
//        dd($years);
        $url = '/eksportir/taxes_save';
        $pageTitle = 'Add Taxes';
        return view('eksportir.taxes.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_taxes')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'laporan_pph' => $request->laporan_pph,
            'laporan_ppn' => $request->laporan_ppn,
            'laporan_psl21' => $request->laporan_pasal_21,
            'setor_pph' => $request->total_pph,
            'setor_ppn' => $request->total_ppn,
            'setor_psl21' => $request->total_pasal_21,
            'tunggakan_pph' => $request->tunggakan_pph,
            'tunggakan_ppn' => $request->tunggakan_ppn,
            'tunggakan_psl21' => $request->tunggakan_pasal_21,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/taxes');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_taxes')
            ->where('itdp_eks_taxes.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('taxes.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('taxes.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('taxes.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $ldate = date('Y');
        $pageTitle = 'Detail Labor';
        $url = '/eksportir/taxes_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_taxes')
            ->where('id', '=', $id)
            ->get();
//        dd($data);
        return view('eksportir.taxes.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $ldate = date('Y');
        $pageTitle = 'View Detail Taxes';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_taxes')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.taxes.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_taxes')->where('id', $id)
            ->delete();
        return redirect('eksportir/taxes');
    }

    public function update(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_taxes')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'laporan_pph' => $request->laporan_pph,
                'laporan_ppn' => $request->laporan_ppn,
                'laporan_psl21' => $request->laporan_pasal_21,
                'setor_pph' => $request->total_pph,
                'setor_ppn' => $request->total_ppn,
                'setor_psl21' => $request->total_pasal_21,
                'tunggakan_pph' => $request->tunggakan_pph,
                'tunggakan_ppn' => $request->tunggakan_ppn,
                'tunggakan_psl21' => $request->tunggakan_pasal_21,
                'idcompanytahun' => $id_user . $request->year,
            ]);
        return redirect('eksportir/taxes');
    }
}
