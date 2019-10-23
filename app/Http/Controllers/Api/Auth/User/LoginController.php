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

class LoginController extends Controller{

public function __construct()
{
    auth()->shouldUse('user_api');
} 

public function login(Request $request)
{
    try {
        // dd( $request->only('email', 'password'));
        $credentials = $request->only('email', 'password');

        if(!$token = auth()->attempt([
            'email' => $request->input('email'), 
            'password' => $request->input('password'),
        ])) {

            return response()->json([
                'errors' => [
                    'email' => ['Your email and/or password may be incorrect.']
                 ]
            ], 422);
        }
    } catch (JWTException $e) {
        return response()->json(['message' => 'Could not create token!'], 401);
    }

    return $this->respondWithToken($token);
 }
 
protected function respondWithToken($token)//: JsonResponse
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'user_id' => auth()->user()->id,
        'role' => auth()->user()->id_role,
        'id_profil' => auth()->user()->id_profil,
        'name' => auth()->user()->username,
        'email' => auth()->user()->email,
        'type' => 'User Company' //api_user guard 
    ]);
} 
}