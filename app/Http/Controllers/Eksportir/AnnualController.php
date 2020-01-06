<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AnnualController extends Controller
{
    public function index()
    {
//        $id_user = Auth::guard('eksmp')->user()->id_profil;
//        dd($id_user);die();
        $pageTitle = "Annual Sales";
        return view('eksportir.annual_sales.index', compact('pageTitle'));
    }

    public function tambah()
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $url = '/eksportir/annual_save';
        $pageTitle = 'Add Annual Sales';
        return view('eksportir.annual_sales.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_sales')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'nilai' => $request->value,
            'nilai_persen' => $request->persen,
            'nilai_ekspor' => $request->nilai_ekspor,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/annual_sales')->with('success','Success Add Data');
    }

    public function datanya()
    {
        $user = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">'.$mjl->tahun. '</div>';
            })
			->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                <a href="' . route('sales.detail', $mjl->id) . '" class="btn btn-sm btn-success"title="Edit">
                    <i class="fa fa-edit text-white"></i> 
                </a>
                <a href="' . route('sales.delete', $mjl->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure ?\')" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action','tahun'])
            ->make(true);
    }


    public function edit($id)
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $pageTitle = 'Detail Sales';
        $url = '/eksportir/sales_update';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.edit', compact('pageTitle', 'data', 'url', 'years'));
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
        DB::table('itdp_eks_sales')->where('id', $id)
            ->delete();
        return redirect('eksportir/annual_sales')->with('success','Success Delete Data');
    }

    public function update(Request $request)
    {
        DB::table('itdp_eks_sales')->where('id', $request->id_sales)
            ->update([
                'tahun' => $request->year,
                'nilai' => $request->value,
                'nilai_persen' => $request->persen,
                'nilai_ekspor' => $request->nilai_ekspor,
            ]);
        return redirect('eksportir/annual_sales')->with('success','Succes Update Data');
    }

    public function indexadminannualsales($id)
    {
//        dd($id);
        $pageTitle = "List Exporter";
        return view('eksportir.annual_sales.indexadminannualsales', compact('pageTitle', 'id'));
    }

    public function indexadmin()
    {
        $pageTitle = "List Exporter";
        return view('eksportir.annual_sales.indexadmin', compact('pageTitle'));
    }

    public function datanyaadmin($id)
    {
//        dd('hahahaha');
        $user = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getreporteksportir()
    {
        $pesan = DB::select("SELECT ID, company,addres,postcode,phone,fax FROM itdp_profil_eks ORDER BY ID DESC ");
//        dd($pesan);
        return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
                return '<div align="left">'.$pesan->company.'</div>';
            })
            ->addColumn('f2', function ($pesan) {
                return $pesan->addres;
            })
            ->addColumn('f3', function ($pesan) {
                return $pesan->postcode;
            })
            ->addColumn('f4', function ($pesan) {
                return $pesan->phone;
            })
            ->addColumn('f5', function ($pesan) {
                return $pesan->fax;
            })
            ->addColumn('action', function ($pesan) {
                return '<a href="' . url('eksportir/listeksportir/' . $pesan->id) . '" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-list text-white"></i></a>';
            })
            ->addIndexColumn()
            ->rawColumns(['action','f1'])
            ->make(true);
    }

    public function listeksportir($id)
    {
//        dd('hahahaha');
        $data = DB::table('itdp_profil_eks')
            ->where('id', '=', $id)
            ->get();
        foreach ($data as $datanya) {
            $company = $datanya->company;
        }
//        dd($data);
        $pageTitle = "List Exporter";
        return view('eksportir.annual_sales.listeksportir', compact('id', 'pageTitle', 'company'));
    }
}
