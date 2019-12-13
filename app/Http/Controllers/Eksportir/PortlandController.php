<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PortlandController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Port Of Landing";

        return view('eksportir.port_landing.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
//        $brand = DB::table('itdp_eks_product_brand')->get();
        $port = DB::table('mst_port')->get();
        $url = '/eksportir/portland_save';
        $pageTitle = 'Add Export Destination';
        return view('eksportir.port_landing.tambah', compact('port', 'pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_port')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_mst_port' => $request->port,
            'pelcompany' => $id_user . $request->tahun . $request->port,
        ]);
        return redirect('eksportir/portland');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->join('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('portland.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('portland.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('portland.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_port')->where('id', $request->id_sales)
            ->update([
                'id_itdp_profil_eks' => $id_user,
                'id_mst_port' => $request->port,
                'pelcompany' => $id_user . $request->tahun . $request->port,
            ]);
        return redirect('eksportir/portland');
    }

    public function indexadmin($id)
    {
//        dd($id);
        $pageTitle = "Port Of Landing";

        return view('eksportir.port_landing.indexadmin', compact('pageTitle', 'id'));
    }

    public function datanyaadmin($id)
    {
//        dd("masuk gan");
        $user = DB::table('itdp_eks_port')
            ->select('itdp_eks_port.id', 'mst_port.name_port')
            ->leftjoin('mst_port', 'mst_port.id', '=', 'itdp_eks_port.id_mst_port')
            ->where('itdp_eks_port.id_itdp_profil_eks', '=', $id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('name_port', function ($mjl) {
                return '<div align="left">'.$mjl->name_port.'</div>';
            })
			->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('portland.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action','name_port'])
            ->make(true);
    }
}
