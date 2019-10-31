<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class ProductNonAuthController extends Controller
{

    // use AuthenticatesUsers;  
    // public function __construct()
    // {
    //    auth()->shouldUse('api_user');
	// }


	public function browseProduct(){
		$dataProduk = DB::table('itdp_company_users')
							->join('csc_product_single', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
							->where('itdp_company_users.status', '=', 1)
							->where('csc_product_single.status', 2)
							->select('csc_product_single.id', 'csc_product_single.prodname_en',
							'csc_product_single.image_1', 'csc_product_single.id_csc_product', 'itdp_company_users.type')
							->inRandomOrder()
            				->limit(10)
							->get();
		if(count($dataProduk) > 0){
			$res['message'] = "Success";
			$res['data'] = $dataProduk;
        	return response($res);
		}else{
			$res['message'] = "Failed";
			return response($res);
		}
	}

	public function browseProductByKategori(Request $request){
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
							->orderBy('csc_product_single.prodname_en','asc')
							->get();
		if(count($dataProduk) > 0){
			$res['message'] = "Success";
			$res['data'] = $dataProduk;
        	return response($res);
		}else{
			$res['message'] = "Failed";
			return response($res);
		}
	}

	public function findKategori(){
		$result = DB::table('csc_product')
						->where('level_1', 0)
						->where('level_2', 0)
						->orderBy('nama_kategori_en', 'ASC')
						->get();
		if(count($result) > 0){
			$res['message'] = "Success";
			$res['data'] = $result;
        	return response($res);
		}else{
			$res['message'] = "Failed";
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
		if(count($data) > 0){
			$res['message'] = "Success";
			$res['data'] = $data;
			return response($res);
		}else{
			$res['message'] = "Failed";
			return response($res);
		}
	}

	 public function getImageProduk(Request $request){
        $path = public_path().'uploads/Eksportir_Product/Image/'.$request->id.'/'.$request->image;
        return Response::download($path);        
    }
}
