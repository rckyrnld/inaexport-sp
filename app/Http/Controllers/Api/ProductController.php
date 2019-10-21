<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Routing\Helpers;

class ProductController extends Controller
{
	use Helpers;

    public function __construct()
    {
        $this->middleware('api.auth');
	}

    public function findProductById(Request $request)
    {
        	$dataProduk = DB::table('csc_product_single')
            ->where('id_itdp_company_user', '=', $request->id_user)
            ->orderBy('product_description_en', 'ASC')
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
    
}
