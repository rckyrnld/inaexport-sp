<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VerifyuserController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Verifikasi User";
		$data = DB::select("select a.* from itdp_company_users a order by a.id desc ");
        return view('verifyuser.index', compact('pageTitle','data'));
    }

   

    public function detailverify($id)
    {
        $pageTitle = 'Detail User';
        $data = DB::table('itdp_company_users')
            ->where('id', '=', $id)
            ->get();
        return view('verifyuser.edit', compact('pageTitle', 'data'));
    }
	
	public function saveverify($id)
    {
		$update = DB::select("update itdp_company_users set status='1' where id='".$id."'");
		return redirect('verifyuser');
	}

    
}
