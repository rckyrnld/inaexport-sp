<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RekapAnggotaController extends Controller
{
    public function index(){
		$eksportirs = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
        $importirs = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
        
        return response()->json(['data'=>["importirs" => $importirs, "eksportirs" => $eksportirs]]);
    }
}
