<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class ProfileController extends Controller
{

    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function findProfileExp(Request $request)
    {
        $dataProfil = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('itdp_profil_eks.id', '=', $request->id_profil)
            ->limit(1)
            ->get();

        if (count($dataProfil) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'Success'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findImageExp(Request $request)
    {
        $dataProfil = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('itdp_profil_eks.id', '=', $request->id_profil)
            ->limit(1)
            ->get();

        foreach ($dataProfil as $rt) {
            $idFoto = $rt->foto_profil;
        }
        $path = asset('image/fotoprofil/' . $idFoto);
        $path2 = base64_encode(file_get_contents($path));

        if (count($dataProfil) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path2;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);

        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findProfileImp(Request $request)
    {
        $dataProfil = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('itdp_profil_imp.id', '=', $request->id_profil)
            ->limit(1)
            ->get();

        if (count($dataProfil) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findImageimp(Request $request)
    {
        $dataProfil = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('itdp_profil_imp.id', '=', $request->id_profil)
            ->limit(1)
            ->get();
        foreach ($dataProfil as $rt) {
            $idFoto = $rt->foto_profil;
        }

        $path = asset('image/fotoprofil/' . $idFoto);
        $path2 = base64_encode(file_get_contents($path));

        if (count($dataProfil) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path2;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);

        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataProfil;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }
}
