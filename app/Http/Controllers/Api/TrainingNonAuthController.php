<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class TrainingNonAuthController extends Controller
{

    // use AuthenticatesUsers;  
    // public function __construct()
    // {
    //    auth()->shouldUse('api_user');
    // }


    public function browseTraining()
    {
        $dataTraining = DB::table('training_admin')
            ->get();
        if (count($dataTraining) > 0) {
            $res['message'] = "Success";
            $res['data'] = $dataTraining;
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }
}
