<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Model\EksmpApi;
use App\Http\Controllers\Api\Model\UserApi;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    public function login(Request $request){
        $idRole = $request->id_role;
        if($idRole != null){

            if($idRole == "1" || $idRole == "4"){
                $user = UserApi::where('email', $request->email)->orWhere('name', $request->email)->first();
            }else{
                $user = EksmpApi::where('email', $request->email)->orWhere('username', $request->email)->first();
            }

            if($user && Hash::check($request->password, $user->password)){
                $token = JWTAuth::fromUser($user);
                return $this->sendLoginResponse($request, $token, $user->id, $idRole, $idRole !='1'|| $idRole != '4' ? $user->id_profil: null);
            }else{
                return $this->sendFailedLoginResponse($request);
            }
        }else{
            // dd("masuk sini");
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function sendLoginResponse(Request $request, $token, $id, $idRole, $idProfil){
        $this->clearLoginAttempts($request);

        return $this->authenticated($token, $id, $idRole, $idProfil);
    }

    public function authenticated($token, $id, $idRole, $idProfil){
        return $this->response->array([
            'id_user' => $id,
            'id_role' => $idRole,
            'id_profil' => $idProfil,
            'token' => $token,
            'status_code' => 200,
            'message' => 'User Authenticated'
        ]);
    }

    public function sendFailedLoginResponse(){
        throw new UnauthorizedHttpException("Bad Credentials");
    }

    public function logout(){
        $this->guard('api')->logout();
    }
 }
