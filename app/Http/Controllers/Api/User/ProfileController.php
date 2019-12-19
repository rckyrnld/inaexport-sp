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
        $dataProfil = DB::table('itdp_profil_eks')
            ->leftJoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('itdp_profil_eks.id', '=', $request->id_profil)
//            ->limit(1)
            ->get();
//        dd($dataProfil);
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
//        dd($dataProfil);
        $id_user = DB::table('itdp_company_users')->where('id_profil', $request->id_profil)->first()->id;
//        dd($id_user);
        if (count($dataProfil) > 0) {

            foreach ($dataProfil as $rt) {
                $idFoto = $rt->foto_profil;
            }
//            $id_profil = DB::table('itdp_company_users')->where('id', $id_user)->first()->id_profil;
            $path = ($idFoto) ? url('uploads/Profile/Eksportir/' . $id_user . '/' . $idFoto) : url('image/noimage.jpg');
//            $destination= 'uploads\Profile\Importir\\'.$id_user;
//            $path2 = (string)Image::make($path)->resize(96, 96)->encode('data-url');
//        $path3 = base64_encode(file_get_contents($path2));
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);

        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function updateProfilExp(Request $request)
    {
//        dd($request);
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
            $id_profile = $request->id_profile;
            $id_user = $request->id_user;

            if (empty($request->file('foto_profil'))) {
//                $file = "";
                $cobaajadulu ="haha";
            } else {
                $file = $request->file('foto_profil')->getClientOriginalName();
                $destinationPath = public_path() . "/uploads/Profile/Eksportir/" . $id_user;
//                $destination = 'uploads\Profile\Importir\\' . $id_user;
                $request->file('foto_profil')->move($destinationPath, $file);
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'foto_profil' => $file
                    ]);
//                $updatetab12 = DB::select("update itdp_company_users set foto_profil='" . $file . "'  where id='" . $id_user . "' ");
                DB::table('itdp_profil_eks')
                    ->where('id', $id_user)
                    ->update([
                        'logo' => $file

                    ]);
//                $updatetab22 = DB::select("update itdp_profil_eks set logo='" . $file . "' where id='" . $id_profile . "'");
            }
            //UPDATE TAB 1
            if ($request->password == null) {
//                dd($request->username);
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'username' => $request->username,
                        'email' => $request->email,
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username= $request->username , email= $request->email , where id = $id_user  ");
//                dd('mantap');
            } else {
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => bcrypt($request->password)
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', email='" . $request->email . "' where id='" . $id_user . "' ");

            }
            //UPDATE TAB 2
            DB::table('itdp_profil_eks')
                ->where('id', $id_profile)
                ->update([
                    'company' => $request->company,
                    'addres' => $request->addres,
                    'city' => $request->city,
                    'id_mst_province' => $request->province,
                    'postcode' => $request->postcode,
                    'fax' => $request->fax,
                    'website' => $request->website,
                    'phone' => $request->phone
                ]);
//            $updatetab2 = DB::select("update itdp_profil_eks set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' , id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "'
//            where id='" . $id_profile . "'");

            //UPDATE TAB 3
            if ($request->npwp == null) {

            } else {
                DB::table('itdp_profil_eks')
                    ->where('id', $id_profile)
                    ->update([
                        'npwp' => $request->npwp,
                        'tdp' => $request->tdp,
                        'siup' => $request->siup,
                        'upduserid' => $request->situ,
                        'id_eks_business_size' => $request->id_eks_business_size,
                        'id_business_role_id' => $request->id_business_role_id,
                        'employe' => $request->employe,
                    ]);
//                $updatetab2 = DB::select("update itdp_profil_eks set npwp='" . $request->npwp . "', tdp='" . $request->tdp . "', siup='" . $request->siup . "'
//				, upduserid='" . $request->situ . "' , id_eks_business_size='" . $request->id_eks_business_size . "', id_business_role_id='" . $request->id_business_role_id . "', employe='" . $request->employe . "', status='" . $request->staim . "'
//				where id='" . $id_profile . "'");
            }
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function updateProfilImp(Request $request)
    {
        if ($request->id_profile == null) {
            $meta = [
                'code' => 400,
                'message' => 'All Data Must Be Filled In',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $id_profile = $request->id_profile;
            $id_user = $request->id_user;
            if (empty($request->file('foto_profil'))) {
//                $file = "";
                $cobaajadulu ="haha";
            } else {
                $file = $request->file('foto_profil')->getClientOriginalName();
                $destinationPath = public_path() . "/uploads/Profile/Importir/" . $id_user;
                $request->file('foto_profil')->move($destinationPath, $file);
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'foto_profil' => $file
                    ]);
//                $updatetab12 = DB::select("update itdp_company_users set foto_profil='" . $file . "'  where id='" . $id_user . "' ");
                DB::table('itdp_profil_imp')
                    ->where('id', $id_profile)
                    ->update([
                        'logo' => $file
                    ]);
//                $updatetab22 = DB::select("update itdp_profil_imp set logo='" . $file . "' where id='" . $id_profile . "'");
            }

            //UPDATE TAB 1
            if ($request->password == null) {
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'username' => $request->username,
                        'email' => $request->email,
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "',  where id='" . $id_user . "' ");
            } else {
                DB::table('itdp_company_users')
                    ->where('id', $id_user)
                    ->update([
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => bcrypt($request->password)
                    ]);
//                $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->staim . "' ,  email='" . $request->email . "' where id='" . $id_user . "' ");

            }
            //UPDATE TAB 2
            DB::table('itdp_profil_imp')
                ->where('id', $id_profile)
                ->update([
                    'company' => $request->company,
                    'addres' => $request->addres,
                    'city' => $request->city,
                    'id_mst_country' => $request->country,
                    'postcode' => $request->postcode,
                    'fax' => $request->fax,
                    'website' => $request->website,
                    'phone' => $request->phone,
                ]);
//            $updatetab2 = DB::select("update itdp_profil_imp set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "'
//		, id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' , status='" . $request->staim . "'
//		where id='" . $id_profile . "'");

//            if ($request->status == 2) {
//                if ($request->id_template_reject == 1) {
//                    DB::table('itdp_company_users')
//                        ->where('id', $id_user)
//                        ->update([
//                            'id_template_reject' => $request->id_template_reject,
//                            'keterangan_reject' => $request->keterangan_reject
//                        ]);
////                    $updatetabz = DB::select("update itdp_company_users set id_template_reject='" . $request->template_reject . "', keterangan_reject='" . $request->txtreject . "'  where id='" . $id_user . "' ");
//
//                } else {
//                    DB::table('itdp_company_users')
//                        ->where('id', $id_user)
//                        ->update([
//                            'id_template_reject' => $request->id_template_reject,
//                        ]);
////                    $updatetabz = DB::select("update itdp_company_users set id_template_reject='" . $request->template_reject . "'  where id='" . $id_user . "' ");
//
//                }
//            }
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findProfileImp(Request $request)
    {
        $dataProfil = DB::table('itdp_profil_imp')
            ->leftJoin('itdp_company_users', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('itdp_profil_imp.id', '=', $request->id_profil)
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
        $id_user = DB::table('itdp_company_users')->where('id_profil', $request->id_profil)->first()->id;
        if (count($dataProfil) > 0) {
            foreach ($dataProfil as $rat) {
                $idaFoto = $rat->foto_profil;
            }

//        $path = asset('image/fotoprofil/' . $idFoto);
//        $path2 = base64_encode(file_get_contents($path));
//            $path = ($idaFoto) ? url('image/fotoprofil/' . $idaFoto) : url('image/noimage.jpg');
            $path = ($idaFoto) ? url('uploads/Profile/Importir/' . $id_user . '/' . $idaFoto) : url('image/noimage.jpg');
//            $destination= 'uploads\Profile\Importir\\'.$id_user;
//            $path2 = (string)Image::make($path)->resize(96, 96)->encode('data-url');

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path;
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
