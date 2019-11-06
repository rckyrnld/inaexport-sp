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
            ->where('status', '=', '1')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findTrainingById(Request $request)
    {
        $dataTraining = DB::table('training_admin')
            ->where('id', '=', $request->id_training)
            ->get();

        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);

        } else {
            $res['message'] = "Failed, No data.";
            return response($res);
        }
    }
}
