<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Intervention\Image\ImageManagerStatic as Image;


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
        if (count($dataProfil) > 0) {

            foreach ($dataProfil as $rt) {
                $idFoto = $rt->foto_profil;
            }

            $path = ($idFoto) ? url('image/fotoprofil/' . $idFoto) : url('image/fotoprofil/aaaa.PNG');
            $path2 = (string)Image::make($path)->resize(96, 96)->encode('data-url');
//        $path3 = base64_encode(file_get_contents($path2));
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

    public function updateProfilExp(Request $request)
    {
        if ($request->id_profile == null) {
            $meta = [
                'code' => 400,
                'message' => 'All Data Must Be Filled In',
                'status' => 'Failed'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $id_user_b = $request->id_profile;

            if (empty($request->file('doc'))) {
                $file = "";
            } else {
                $file = $request->file('doc')->getClientOriginalName();
                $destinationPath = public_path() . "/eksportir";
                $request->file('doc')->move($destinationPath, $file);
                $updatetabd = DB::select("update itdp_profil_eks set doc='" . $file . "' where id='" . $id_user_b . "'");
            }
            //UPDATE TAB 1
            if ($request->password == null) {
                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "', status='" . $request->staim . "' where id='" . $request->id_user . "' ");
            } else {
                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->staim . "', email='" . $request->email . "' where id='" . $request->id_user . "' ");

            }
            //UPDATE TAB 2

            $updatetab2 = DB::select("update itdp_profil_eks set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' , id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' 
            where id='" . $id_user_b . "'");

            //UPDATE TAB 3
            if ($request->npwp == null) {

            } else {
                $updatetab2 = DB::select("update itdp_profil_eks set npwp='" . $request->npwp . "', tdp='" . $request->tanda_daftar . "', siup='" . $request->siup . "' 
				, upduserid='" . $request->situ . "' , id_eks_business_size='" . $request->scoope . "', id_business_role_id='" . $request->tob . "', employe='" . $request->employee . "', status='" . $request->staim . "' 
				where id='" . $id_user_b . "'");
            }
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

        if (count($dataProfil) > 0) {
            foreach ($dataProfil as $rat) {
                $idaFoto = $rat->foto_profil;
            }

//        $path = asset('image/fotoprofil/' . $idFoto);
//        $path2 = base64_encode(file_get_contents($path));
            $path = ($idaFoto) ? url('image/fotoprofil/' . $idaFoto) : url('image/fotoprofil/aaaa.PNG');
            $path2 = (string)Image::make($path)->resize(96, 96)->encode('data-url');

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
