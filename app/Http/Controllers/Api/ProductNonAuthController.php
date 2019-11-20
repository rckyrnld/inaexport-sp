<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ProductNonAuthController extends Controller
{

    // use AuthenticatesUsers;  
    // public function __construct()
    // {
    //    auth()->shouldUse('api_user');
    // }


    public function browseProduct()
    {
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
//            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type', 'csc_product_single.price_usd', 'csc_product.nama_kategori_en')
            ->orderBy('csc_product_single.created_at', 'ASC')
            ->limit(10)
            ->get();
//        dd($dataProduk);
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $getJSON = array();
            foreach ($dataProduk as $item) {
                array_push($getJSON, array(
                    "id" => $item->id,
                    "prodname_en" => $item->prodname_en,
                    "id_csc_product" => $item->id_csc_product,
                    "type" => $item->type,
                    "image_1" => $path = ($item->image_1) ? url('uploads/Eksportir_Product/Image/' . $item->id . '/' . $item->image_1) : url('image/noimage.jpg'),
                    "nama_kategori_en" => $item->nama_kategori_en,
                    "price_usd" => $item->price_usd
                ));
            }
            $res['meta'] = $meta;
            $res['data'] = $getJSON;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function browseProductByKategori(Request $request)
    {
        // echo $request->id_kategori;die();
        // $id_kategori = $request->input('id_kategori');;
        // dd($request->id_kategori);
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.id_csc_product', $request->id_kategori)
            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type')
            ->orderBy('csc_product_single.prodname_en', 'asc')
            ->get();
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function findKategori()
    {
        $result = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();
        if (count($result) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $result;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = $result;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function detailProduk(Request $request)
    {
        //Product
        $data = DB::table('csc_product_single')
            ->where('id', '=', $request->id)
            ->first();
        // dd($data);
        if (count($data) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = $dataProduk;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
//            $data = data;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getImageProduk($id, $image)
    {
        $path = public_path() . '/uploads/Eksportir_Product/Image/' . $id . '/' . $image;
        if (is_file($path)) {
            return response()->download($path);
        } else {
            return response()->download(public_path() . '/image/noimage.jpg');
        }
    }

    public function responseView($pathToFile, $filename)
    {

        $headers = ['Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => 'Content-Type, Accept, Authorization, X-Requested-With, Application, Origin, Authorization, APIKey, Timestamp, AccessToken',
            'Content-Disposition' => 'filename=' . $filename,
            'Pragma' => 'public',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Type' => $this->getContentType($pathToFile),
            'Content-Length' => filesize($pathToFile)];

        $response = new BinaryFileResponse($pathToFile, 200, $headers);
        return $response;

    }

    public function getRandomProduct()
    {
//        $dataProduk = DB::table('itdp_company_users')
//            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
//            ->where('itdp_company_users.status', '=', 1)
//            ->where('csc_product_single.status', 2)
//            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
//                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type')
//            ->inRandomOrder()
//            ->limit(6)
//            ->get();
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
//            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type', 'csc_product_single.price_usd', 'csc_product.nama_kategori_en')
            ->inRandomOrder()
            ->limit(6)
            ->get();
//        dd($dataProduk);
        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $getJSON = array();
            foreach ($dataProduk as $item) {
                array_push($getJSON, array(
                    "id" => $item->id,
                    "prodname_en" => $item->prodname_en,
                    "id_csc_product" => $item->id_csc_product,
                    "type" => $item->type,
                    "image_1" => $path = ($item->image_1) ? url('uploads/Eksportir_Product/Image/' . $item->id . '/' . $item->image_1) : url('image/noimage.jpg'),
                    "nama_kategori_en" => $item->nama_kategori_en,
                    "price_usd" => $item->price_usd
                ));
            }
            $res['meta'] = $meta;
            $res['data'] = $getJSON;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
//            $data = data;
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

    public function getprodukBaru()
    {
        $dataProduk = DB::table('itdp_company_users')
            ->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->join('csc_product', 'csc_product.id', '=', 'csc_product_single.id_csc_product')
            ->where('itdp_company_users.status', '=', 1)
            ->where('csc_product_single.status', 2)
//            ->select('itdp_company_users.*','csc_product_single.*','csc_product.nama_kategori_en')
            ->select('csc_product_single.id', 'csc_product_single.prodname_en',
                'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type', 'csc_product_single.price_usd', 'csc_product.nama_kategori_en')
            ->orderBy('csc_product_single.created_at', 'ASC')
            ->limit(6)
            ->get();

        if (count($dataProduk) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $getJSON = array();
            foreach ($dataProduk as $item) {
                array_push($getJSON, array(
                    "id" => $item->id,
                    "prodname_en" => $item->prodname_en,
                    "id_csc_product" => $item->id_csc_product,
                    "type" => $item->type,
                    "image_1" => $path = ($item->image_1) ? url('uploads/Eksportir_Product/Image/' . $item->id . '/' . $item->image_1) : url('image/noimage.jpg'),
                    "nama_kategori_en" => $item->nama_kategori_en,
                    "price_usd" => $item->price_usd
                ));
            }
            $res['meta'] = $meta;
            $res['data'] = $getJSON;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
//            $data = data;
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }

}
