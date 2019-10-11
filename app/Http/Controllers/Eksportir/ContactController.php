<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContactController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Contact";

        return view('eksportir.contact.index', compact('pageTitle'));
    }

    public function tambah()
    {
//        dd($id_user);
        $url = '/eksportir/contact_save';
        $pageTitle = 'Tambah Contact';
        return view('eksportir.contact.tambah', compact('pageTitle', 'url'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $id_user = Auth::user()->id;
        DB::table('itdp_contact_eks')->insert([
            'id_itdp_profil_eks' => $id_user,
            'name' => $request->name,
            'job_title' => $request->position,
            'phone' => $request->phone,
        ]);
        return redirect('eksportir/contact');
    }

    public function datanya()
    {
//        dd("masuk gan");
        $user = DB::table('itdp_contact_eks')
            ->where('id_itdp_profil_eks', '=', Auth::user()->id)
            ->get();
//        dd($user);
        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('contact.view', $mjl->id) . '" class="btn btn-sm btn-info">
                    <i class="fa fa-search text-white"></i> View
                </a>
                <a href="' . route('contact.detail', $mjl->id) . '" class="btn btn-sm btn-success">
                    <i class="fa fa-edit text-white"></i> Edit
                </a>
                <a href="' . route('contact.delete', $mjl->id) . '" class="btn btn-sm btn-danger">
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
        $pageTitle = 'Detail Contact';
        $url = '/eksportir/contact_update';

        $data = DB::table('itdp_contact_eks')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.contact.edit', compact('pageTitle', 'data', 'url'));
    }

    public function view($id)
    {
//        dd($id);
        $pageTitle = 'Detail Country Patern Brand';
        $data = DB::table('itdp_contact_eks')
            ->where('id', '=', $id)
            ->get();
//        dd($data);
        return view('eksportir.contact.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
//        dd($id);
        DB::table('itdp_contact_eks')->where('id', $id)
            ->delete();
        return redirect('eksportir/contact');
    }

    public function update(Request $request)
    {
//        dd($request);
        DB::table('itdp_contact_eks')->where('id', $request->id_sales)
            ->update([
                'name' => $request->name,
                'job_title' => $request->position,
                'phone' => $request->phone,
            ]);
        return redirect('eksportir/contact');
    }
}