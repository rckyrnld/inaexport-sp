<?php

namespace App\Http\Controllers\Api\Auth\User;

use App\Http\Models\Api\UserApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function login(Request $request)
    {
        try {
            // dd( $request->only('email', 'password'));
            $credentials = $request->only('email', 'password');

            if (!$token = auth()->attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ])) {

                return $this->respondFailed();
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token!'], 401);
        }

        return $this->respondWithToken($token, $request->email);
    }

    protected function respondFailed()
    {
        $meta = [
            'code' => '401',
            'message' => 'Unauthorized',
            'status' => 'Failed'
        ];
        $data = [];
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;
    }

    protected function respondWithToken($token, $email)//: JsonResponse
    {
        $datas = '';

        $insertToken = DB::select("update itdp_company_users set remember_token='" . $token . "' where email='" . $email . "'");
        if ($insertToken) {
            $company = DB::Table('itdp_company_users')
                ->where('email', '=', $email)->get();
//        dd($company);
            if ($company[0]->id_role == 3) {
                $datas = DB::Table('itdp_profil_imp')
                    ->where('id', '=', $company[0]->id_profil)
                    ->get();
            } else {
                $datas = DB::Table('itdp_profil_eks')
                    ->where('id', '=', $company[0]->id_profil)
                    ->get();
            }
        }
        $meta = [
            'code' => '200',
            'message' => 'Success',
            'status' => 'Success'
        ];
        $datas[0]->type = $company[0]->type;
        $datas[0]->access_token = $token;
//    $data = [
//        'access_token' => $token,
//        'token_type' => 'Bearer',
//        'expires_in' => auth()->factory()->getTTL() * 60,
//        'user_id' => auth()->user()->id,
//        'role' => auth()->user()->id_role,
//        'id_profil' => auth()->user()->id_profil,
//        'name' => auth()->user()->username,
//        'email' => auth()->user()->email,
//        'type' => 'user' //api_user guard
//    ];
        $data = $datas;
        $res['meta'] = $meta;
        $res['data'] = $data;
        return $res;

//    return response()->json([
//        'access_token' => $token,
//        'token_type' => 'Bearer',
//        'expires_in' => auth()->factory()->getTTL() * 60,
//        'user_id' => auth()->user()->id,
//        'role' => auth()->user()->id_role,
//        'id_profil' => auth()->user()->id_profil,
//        'name' => auth()->user()->username,
//        'email' => auth()->user()->email,
//        'type' => 'user' //api_user guard
//    ]);
    }
}