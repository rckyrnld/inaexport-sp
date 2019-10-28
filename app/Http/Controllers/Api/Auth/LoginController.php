<?php

namespace App\Http\Api\Auth;

use App\Http\Api\Models\UserApi;
use App\Http\Api\Models\AdminApi;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
// use Tymon\JWTAuth\Facades\JWTAuth;
// use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;   

    use Helpers;
    //  public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('guest:userApi')->except('logout');        
    //     $this->middleware('guest:adminApi')->except('logout');

    // }

    public function login(Request $request){
        $idRole = $request->id_role;
        $token = null;
        $isTrue = false;
        if($idRole != null){

            if($idRole == "1" || $idRole == "4"){
                if(Auth::guard('adminApi')->attempt(['email' => $request->email, 'password' => $request->password])){
                    $user = Auth::guard('adminApi')->user();
                    $token = JWTAuth::fromUser($user);
                    $insertToken = DB::select("update itdp_admin_users set remember_token='".$token."' where id=".$user->id);
                    $isTrue = $insertToken;
                }
            }else{
                if(Auth::guard('userApi')->attempt(['email' => $request->email, 'password' => $request->password])){
                    $user = Auth::guard('userApi')->user();
                    $token = JWTAuth::fromUser($user);
                    $insertToken = DB::select("update itdp_company_users set remember_token='".$token."' where id=".$user->id);
                    $isTrue = $insertToken;
                }
            }
// dd($user);
            if($isTrue){
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
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:userApi')->except('logout');        
        $this->middleware('guest:adminApi')->except('logout');

    
    }
 }
