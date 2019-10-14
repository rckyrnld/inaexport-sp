<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExsdesController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Export Destination";

        return view('eksportir.export_destination.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
//        $brand = DB::table('itdp_eks_product_brand')->get();
        $country = DB::table('mst_country')->get();
        $url = '/eksportir/exdes_save';
        $pageTitle = 'Add Export Destination';
        return view('eksportir.export_destination.tambah', compact('country', 'pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_eks_destination')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_mst_country' => $request->country,
            'rasio_persen' => $request->ratio_export,
            'tahun' => $request->year,
            'comtahuncountry' => $id_user.$request->tahun.$request->country,
        ]);
        return redirect('eksportir/export_destination');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_destination')
            ->select('itdp_eks_destination.id', 'itdp_eks_destination.rasio_persen', 'itdp_eks_destination.tahun', 'mst_country.country')
            ->join('mst_country', 'mst_country.id', '=', 'itdp_eks_destination.id_mst_country')
            ->where('itdp_eks_destination.id_itdp_profil_eks', '=', Auth::user()->id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('exdes.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('exdes.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('exdes.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $url = '/eksportir/exdes_update';
        $country = DB::table('mst_country')->get();
        $data = DB::table('itdp_eks_destination')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.export_destination.edit', compact('pageTitle', 'data', 'url', 'brand', 'country'));
    }

    public function view($id)
    {
//        dd($id);
        $pageTitle = 'Detail Export Destination';
        $data = DB::table('itdp_eks_destination')
            ->where('id', '=', $id)
            ->get();
//        $brand = DB::table('itdp_eks_product_brand')->get();
        $country = DB::table('mst_country')->get();
//        dd($data);
        return view('eksportir.export_destination.view', compact('pageTitle', 'data', 'country'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_eks_destination')->where('id', $id)
            ->delete();
        return redirect('eksportir/export_destination');
    }

    public function update(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_eks_destination')->where('id', $request->id_sales)
            ->update([
                'id_mst_country' => $request->country,
                'rasio_persen' => $request->ratio_export,
                'tahun' => $request->year,
                'comtahuncountry' => $id_user.$request->tahun.$request->country,
            ]);
        return redirect('eksportir/export_destination');
    }
}
