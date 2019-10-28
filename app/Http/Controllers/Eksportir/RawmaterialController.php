<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RawmaterialController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Raw Material";

        return view('eksportir.raw_material.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $ldate = date('Y');
//        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
//        dd($years);
        $url = '/eksportir/rawmaterial_save';
        $pageTitle = 'Add Raw Material';
        return view('eksportir.raw_material.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_raw_material')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'lokal_persen' => $request->domestic,
            'impor_persen' => $request->overseas,
            'nilai_impor' => $request->valuefromdomestic,
        ]);
        return redirect('eksportir/rawmaterial');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_raw_material')
            ->where('itdp_eks_raw_material.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('rawmaterial.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('rawmaterial.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('rawmaterial.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $pageTitle = 'Detail Capacity Utilization';
        $url = '/eksportir/rawmaterial_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_raw_material')
            ->where('id', '=', $id)
            ->get();
//        dd($data);
        return view('eksportir.raw_material.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $ldate = date('Y');
        $pageTitle = 'View Detail Raw Material';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_raw_material')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.raw_material.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_raw_material')->where('id', $id)
            ->delete();
        return redirect('eksportir/rawmaterial');
    }

    public function update(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_raw_material')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'lokal_persen' => $request->domestic,
                'impor_persen' => $request->overseas,
                'nilai_impor' => $request->valuefromdomestic,
            ]);
        return redirect('eksportir/rawmaterial');
    }

    public function indexadmin($id)
    {
//        dd($id);
        $pageTitle = "Raw Material";

        return view('eksportir.raw_material.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_raw_material')
            ->where('itdp_eks_raw_material.id_itdp_profil_eks', '=', $id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('rawmaterial.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
