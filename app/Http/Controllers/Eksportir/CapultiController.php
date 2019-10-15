<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CapultiController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Capacity Utilization";

        return view('eksportir.capacity_utilization.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $ldate = date('Y');
//        dd($ldate);
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
//        dd($years);
        $url = '/eksportir/capulti_save';
        $pageTitle = 'Add Capacity Utilization';
        return view('eksportir.capacity_utilization.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_production_capacity')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'kapasitas_terpakai_persen' => $request->used_capacity,
        ]);
        return redirect('eksportir/capulti');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_production_capacity')
            ->select('itdp_production_capacity.id', 'itdp_production_capacity.tahun', 'itdp_production_capacity.kapasitas_terpakai_persen')
            ->where('itdp_production_capacity.id_itdp_profil_eks', '=', Auth::user()->id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('capulti.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('capulti.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('capulti.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $pageTitle = 'Detail Export Destination';
        $url = '/eksportir/portland_update';
        $port = DB::table('mst_port')->get();
        $data = DB::table('itdp_eks_port')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.port_landing.edit', compact('pageTitle', 'data', 'url', 'port'));
    }

    public function view($id)
    {
//        dd($id);
        $pageTitle = 'Detail Export Destination';
        $data = DB::table('itdp_eks_port')
            ->where('id', '=', $id)
            ->get();
//        $brand = DB::table('itdp_eks_product_brand')->get();
        $port = DB::table('mst_port')->get();
//        dd($data);
        return view('eksportir.port_landing.view', compact('pageTitle', 'data', 'port'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_port')->where('id', $id)
            ->delete();
        return redirect('eksportir/portland');
    }

    public function update(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_eks_port')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'id_mst_port' => $request->port,
                'pelcompany' => $id_user . $request->tahun . $request->port,
            ]);
        return redirect('eksportir/portland');
    }
}
