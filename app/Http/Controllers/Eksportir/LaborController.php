<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LaborController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Labor";

        return view('eksportir.labor.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $ldate = date('Y');
//        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
//        dd($years);
        $url = '/eksportir/labor_save';
        $pageTitle = 'Add Raw Material';
        return view('eksportir.labor.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id;
        DB::table('itdp_eks_labor')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'lokal_orang' => $request->local_employee,
            'asing_orang' => $request->foreign_worker,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/labor');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_labor')
            ->where('itdp_eks_labor.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('labor.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('labor.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('labor.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $url = '/eksportir/labor_update';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_labor')
            ->where('id', '=', $id)
            ->get();
//        dd($data);
        return view('eksportir.labor.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $ldate = date('Y');
        $pageTitle = 'View Detail Labor';
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $data = DB::table('itdp_eks_labor')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.labor.view', compact('pageTitle', 'data', 'years'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_labor')->where('id', $id)
            ->delete();
        return redirect('eksportir/labor');
    }

    public function update(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id;
        DB::table('itdp_eks_labor')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'tahun' => $request->year,
                'lokal_orang' => $request->local_employee,
                'asing_orang' => $request->foreign_worker,
                'idcompanytahun' => $id_user . $request->year,
            ]);
        return redirect('eksportir/labor');
    }
}