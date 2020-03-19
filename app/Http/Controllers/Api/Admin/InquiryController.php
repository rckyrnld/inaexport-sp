<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Models\Api\AdminApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mail;


class InquiryController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api_admin');
    }
	
	public function list_inquiry_admin(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		/*
		$page = $request->page;
		$limit = $request->limit;
		$user = DB::table('csc_inquiry_br')
			->where('csc_inquiry_br.type', 'admin')
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
			->paginate($limit);
			//->limit(10)
            //->offset($offset)
            //->get();
		$user2 = DB::table('csc_inquiry_br')
			->where('csc_inquiry_br.type', 'admin')
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
			->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_pembuat"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            $jsonResult[$i]["to"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["duration"] = $user[$i]->duration;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;

			}
//        dd($jsonResult);
        if (count($user) > 0) {
			
			$countall = count($user2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
            ];

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
		
		*/
		
		$user = [];
		
		/*
                $importer = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->selectRaw('csc_inquiry_br.*,csc_inquiry_br.created_at as ca,csc_inquiry_br.id as idb ,csc_inquiry_br.status as stabr , csc_product_single.*, csc_product_single.id as id_product')
                   // ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                   // ->where('csc_inquiry_br.status', 1)
                    // ->orderBy('csc_inquiry_br.', 'DESC')
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->orderBy('ca', 'DESC')
					->paginate($limit);
					//->get();
			$user2 = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->selectRaw('csc_inquiry_br.*,csc_inquiry_br.status as stabr , csc_product_single.*, csc_product_single.id as id_product')
                   // ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                   // ->where('csc_inquiry_br.status', 1)
                    // ->orderBy('csc_inquiry_br.', 'DESC')
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->orderBy('csc_inquiry_br.created_at', 'DESC')
					->get();
					// dd($user);
					// echo count($importer);die();
                
                foreach ($importer as $key) {
                    array_push($user, $key);
                } 
		*/
//                dd($user);
				
                $perwakilan = DB::table('csc_inquiry_br')
                 //   ->leftjoin('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                 //   ->selectRaw('a.*,a.created_at as ca,a.id as idb,b.status as stabr, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.*, b.status')
                //    ->where('b.id_itdp_company_users', '=', $id_user)
                //   ->where('type', 'admin')
//                    ->orderBy('a.date', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($limit);
					//->get();
				$user3 = DB::table('csc_inquiry_br')
                //    ->leftjoin('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                //    ->selectRaw('a.*,a.id as idb,b.status as stabr, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.*, b.status')
                 //   ->where('b.id_itdp_company_users', '=', $id_user)
               //     ->where('b.status', 1)
			   // ->where('type', 'admin')
//                    ->orderBy('a.date', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                foreach ($perwakilan as $key2) {
                    array_push($user, $key2);
                }
        
				
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
			// $jsonResult[$i]["id_pembuat"] = $user[$i]->id_itdp_profil_eks;
            $jsonResult[$i]["type"] = $user[$i]->type;
			if($user[$i]->type == "admin"){
				$jsonResult[$i]["id_type"] = 1;
				/*$carid = DB::table('csc_inquiry_category')->where('id_inquiry', '=', $user[$i]->idb)->get();
				
				foreach($carid as $c1){ $id_cad_prod = $c1->id_cat_prod; }
				$ambilcat = DB::table('csc_product')->where('id', '=', $id_cad_prod)->get();
				foreach($ambilcat as $c2){
					$ip1 = $c2->level_2;
					$ip2 = $c2->level_1;
					$ip3 = $c2->id;
				}
				$jsonResult[$i]["id_csc_prod_cat"] = $ip1;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = $ip2;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = $ip3; */
				$jsonResult[$i]["id_csc_prod_cat"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = 0;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();
				
				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
				/*$jsonResult[$i]["csc_product_desc"] = "";
				$jsonResult[$i]["csc_product_level1_desc"] = "";
				$jsonResult[$i]["csc_product_level2_desc"] = "";
				*/
				/*
				$ifp1 = DB::table('csc_product')->where('id', '=', $ip1)->get();
				$ifp2 = DB::table('csc_product')->where('id', '=', $ip2)->get();
				$ifp3 = DB::table('csc_product')->where('id', '=', $ip3)->get();
				if(count($ifp1) == 0){
					$jsonResult[$i]["csc_product_desc"] = "";
				}else{
					foreach($ifp1 as $r1){ $icad1 = $r1->nama_kategori_en; }
					$jsonResult[$i]["csc_product_desc"] = $icad1;
				}
				if(count($ifp2) == 0){
					$jsonResult[$i]["csc_product_level1_desc"] = "";
				}else{
					foreach($ifp2 as $r2){ $icad2 = $r2->nama_kategori_en; }
					$jsonResult[$i]["csc_product_level1_desc"] = $icad2;
				}
				if(count($ifp3) == 0){
					$jsonResult[$i]["csc_product_level2_desc"] = "";
				}else{
					foreach($ifp3 as $r3){ $icad3 = $r3->nama_kategori_en; }
					$jsonResult[$i]["csc_product_level2_desc"] = $icad3;
				}
				*/
				
			}else if($user[$i]->type == "perwakilan"){
				$jsonResult[$i]["id_type"] = 4;
				$jsonResult[$i]["id_csc_prod_cat"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = 0;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = 0;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();

				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
				/* $jsonResult[$i]["csc_product_desc"] = "";
				$jsonResult[$i]["csc_product_level1_desc"] = "";
				$jsonResult[$i]["csc_product_level2_desc"] = "";
				*/
				/*
				$carid = DB::table('csc_inquiry_category')->where('id_inquiry', '=', $user[$i]->idb)->get();
				
				foreach($carid as $c1){ $id_cad_prod = $c1->id_cat_prod; }
				$ambilcat = DB::table('csc_product')->where('id', '=', $id_cad_prod)->get();
				foreach($ambilcat as $c2){
					$ip1 = $c2->level_2;
					$ip2 = $c2->level_1;
					$ip3 = $c2->id;
				}
				$jsonResult[$i]["id_csc_prod_cat"] = $ip1;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = $ip2;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = $ip3;
				$ifp1 = DB::table('csc_product')->where('id', '=', $ip1)->get();
				$ifp2 = DB::table('csc_product')->where('id', '=', $ip2)->get();
				$ifp3 = DB::table('csc_product')->where('id', '=', $ip3)->get();
				if(count($ifp1) == 0){
					$jsonResult[$i]["csc_product_desc"] = "";
				}else{
					foreach($ifp1 as $r1){ $icad1 = $r1->nama_kategori_en; }
					$jsonResult[$i]["csc_product_desc"] = $icad1;
				}
				if(count($ifp2) == 0){
					$jsonResult[$i]["csc_product_level1_desc"] = "";
				}else{
					foreach($ifp2 as $r2){ $icad2 = $r2->nama_kategori_en; }
					$jsonResult[$i]["csc_product_level1_desc"] = $icad2;
				}
				if(count($ifp3) == 0){
					$jsonResult[$i]["csc_product_level2_desc"] = "";
				}else{
					foreach($ifp3 as $r3){ $icad3 = $r3->nama_kategori_en; }
					$jsonResult[$i]["csc_product_level2_desc"] = $icad3;
				}
				*/
				
			}else{
				$jsonResult[$i]["id_type"] = 3;
				$jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
				$wkwk = $user[$i]->id_csc_prod_cat.",".$user[$i]->id_csc_prod_cat_level1.",".$user[$i]->id_csc_prod_cat_level2.",";
				$id_csc = explode(",", $wkwk);
				$list_k = array();

				for ($a = 0; $a < count($id_csc); $a++) {
					if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
						//$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
						$list_k[] = $id_csc[$a];
					}
				}

				$getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
				$jsonResult[$i]["csc_product_desc"] = $getName;
				/*
				$jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat)->first()->nama_kategori_en;
				$jsonResult[$i]["csc_product_level1_desc"] = ($user[$i]->id_csc_prod_cat_level1) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level1)->first()->nama_kategori_en : null;
				$jsonResult[$i]["csc_product_level2_desc"] = ($user[$i]->id_csc_prod_cat_level2) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level2)->first()->nama_kategori_en : null;
				*/
				/*
				$jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
				$jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
				$jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
				$jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat)->first()->nama_kategori_en;
				$jsonResult[$i]["csc_product_level1_desc"] = ($user[$i]->id_csc_prod_cat_level1) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level1)->first()->nama_kategori_en : null;
				$jsonResult[$i]["csc_product_level2_desc"] = ($user[$i]->id_csc_prod_cat_level2) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level2)->first()->nama_kategori_en : null;
				*/
			}
           
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
			if(empty($user[$i]->updated_at) || $user[$i]->updated_at == null){ 
			$jsonResult[$i]["updated_at"] =  ""; 
			}else{ 
			$jsonResult[$i]["updated_at"] =  $user[$i]->updated_at; 
			}
            
            $jsonResult[$i]["duration"] = $user[$i]->duration;
			if($user[$i]->type == "importir"){
				$jsonResult[$i]["to"] = $user[$i]->to;
				$jsonResult[$i]["prodname"] = $user[$i]->prodname;
				$id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
				$id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role;
				$jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
				
            }else{
				$jsonResult[$i]["to"] = $user[$i]->id_pembuat;
				$jsonResult[$i]["prodname"] = $user[$i]->prodname;
				/*$id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
				$id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role; */
				$jsonResult[$i]["company_name"] = "";
				/*$jsonResult[$i]["csc_product_desc"] = "";
				$jsonResult[$i]["csc_product_level1_desc"] = "";
				$jsonResult[$i]["csc_product_level2_desc"] = "";*/
			
			}
		}
		
		// echo count($user);die();
        if ($perwakilan) {
            /*$meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
			$countall = count($user3);
			// $bagi = $countall / ($request->limit * 2);
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => 0,
                'results' => $jsonResult
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

		
	}
	
	public function verif_inquiry_admin(Request $request)
    {
		$id = $request->id;
		$data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
                $datenow = date('Y-m-d H:i:s');
                $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();

                if($inquiry){
                    if($inquiry->duration != "None"){
                        $durasi = 0;
                        $jn = explode(' ', $inquiry->duration);
                        if($jn[1] == "week" || $jn[1] == "weeks"){
                            $durasi = (int)$jn[0] * 7;
                        }else if($jn[1] == "month" || $jn[1] == "months"){
                            $durasi = (int)$jn[0] * 30;
                        }

                        $date = strtotime("+".$durasi." days", strtotime($datenow));
                        $duedate = date('Y-m-d H:i:s', $date);

                        $inquirynya = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->update([
                            'status' => 2,
                        ]);

                        $inquirybroadcast = DB::table('csc_inquiry_broadcast')->where('id', $id)->update([
                            'status' => 2,
                            'date' => $datenow,
                            'due_date' => $duedate,
                        ]);
                    }else{
                        $inquirynya = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->update([
                            'status' => 2,
                        ]);

                        $inquirybroadcast = DB::table('csc_inquiry_broadcast')->where('id', $id)->update([
                            'status' => 2,
                            'date' => $datenow,
                        ]);
                    }
				if($inquirybroadcast){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
					
                }

                
	}
	
	public function list_inquiry_broadcast(Request $request)
    {
		$id_inquiry = $request->id_inquiry;
		$user = DB::table('csc_inquiry_broadcast')
			->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_inquiry_broadcast.id_itdp_company_users')
			->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
			->where('csc_inquiry_broadcast.id_inquiry', $id_inquiry)
            ->orderBy('csc_inquiry_broadcast.created_at', 'DESC')
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_itdp_company_users"] = $user[$i]->id_itdp_company_users;
			$jsonResult[$i]["company"] = $user[$i]->badanusaha." ".$user[$i]->company;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;
            
            

			}
//        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
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
	
	public function list_inquiry_hc(Request $request)
    {
		$id_inquiry = $request->id_inquiry;
		$id_broad = $request->id_broad;
		$user = DB::table('csc_chatting_inquiry')
			->where('csc_chatting_inquiry.id_inquiry', $id_inquiry)
			->where('csc_chatting_inquiry.id_broadcast_inquiry', $id_broad)
            ->orderBy('csc_chatting_inquiry.created_at', 'DESC')
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
			$jsonResult[$i]["sender"] = $user[$i]->sender;
            $jsonResult[$i]["receive"] = $user[$i]->receive;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["status"] = $user[$i]->status;
            
            

			}
//        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
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
	
	public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        $type = "admin";


                //Jenis Perihal
                $jpen = "";
                $jpin = "";
                $jpchn = "";
                if($request->kos == "offer to sell"){
                    $jpen = $request->kos;
                    $jpin = "menawarkan untuk menjual";
                    $jpchn = "出售要约";
                }else if($request->kos == "offer to buy"){
                    $jpen = $request->kos;
                    $jpin = "menawarkan untuk membeli";
                    $jpchn = "报价购买";
                }else if($request->kos == "consultation"){
                    $jpen = $request->kos;
                    $jpin = "konsultasi";
                    $jpchn = "咨询服务";
                }

                if($request->duration == NULL){
                    $duration = "None";
                }else{
                    $duration = $request->duration;
                }

                $save = DB::table('csc_inquiry_br')->insertGetId([
                    'id_pembuat' => '1',
                    'type' => $type,
                    'prodname' => $request->prodname,
                    'jenis_perihal_en' => $jpen,
                    'jenis_perihal_in' => $jpin,
                    'jenis_perihal_chn' => $jpchn,
                    'messages_en' => $request->messages,
                    'messages_in' => $request->messages,
                    'messages_chn' => $request->messages,
                    'subyek_en' => $request->subject,
                    'subyek_in' => $request->subject,
                    'subyek_chn' => $request->subject,
                    'status' => 1,
                    'date' => $request->dateinquiry,
                    'duration' => $duration,
                    'created_at' => $datenow,
                ]);

                $nama_file1 = NULL;
                $destination= 'uploads\Inquiry\\'.$save;
                if($request->hasFile('file')){
                    $file1 = $request->file('file');
                    $nama_file1 = time().'_'.$request->subject.'_'.$file1->getClientOriginalName();
                    Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
                }

                $savefile = DB::table('csc_inquiry_br')->where('id', $save)->update([
                    'file' => $nama_file1,
                ]);
                if($save){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
            

    }
	
	public function bc_inquiry_admin(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
            $id_user = 1;
                $id_inquiry = $request->id_inquiry;
                $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
                $datenow = date("Y-m-d H:i:s");

                //update status
                $upd = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
                    'status' => 0,
                ]);

                $array = [];
                for($i = 0; $i<count($request->categori); $i++){
                    $var = $request->categori[$i];
                    
                    $input_cat = DB::table('csc_inquiry_category')->insert([
                        'id_inquiry' => $id_inquiry,
                        'id_cat_prod' => $var,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
                          ->where(function ($query) use ($var) {
                                  $query->where('id_csc_product', $var)
                                        ->orWhere('id_csc_product_level1', $var)
                                        ->orWhere('id_csc_product_level2', $var);
                              })
                          ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
                    foreach ($perusahaan as $key) {
                      if (!in_array($key->id_itdp_company_user, $array)){
                        array_push($array, $key->id_itdp_company_user);
                      }
                    }
                }

                sort($array);
                $users = [];
                $usernames = [];
                $userbadanusaha = [];
                for ($k=0; $k <count($array) ; $k++) { 
                    $untuk = DB::table('itdp_company_users')->where('id', $array[$k])->first();
                    if($untuk != NULL){
                        $company = DB::table('itdp_profil_eks')->where('id', $untuk->id_profil)->first();
                        $save = DB::table('csc_inquiry_broadcast')->insert([
                            'id_inquiry' => $id_inquiry,
                            'id_itdp_company_users' => $array[$k],
                            'status' => 1,
                            'created_at' => $datenow,
                        ]);

                        $admin = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                        $notif = DB::table('notif')->insert([
                            'dari_nama' => $admin->name,
                            'dari_id' => $id_user,
                            'untuk_nama' => getCompanyName($array[$k]),
                            'untuk_id' => $array[$k],
                            'keterangan' => 'New Inquiry By '.$admin->name.' with Subyek  "'.$inquiry->subyek_en.'"',
                            'url_terkait' => 'inquiry',
                            'status_baca' => 0,
                            'waktu' => $datenow,
                            'to_role' => 2,
                        ]);

                        $data = [
                            'email' => $untuk->email,
                            'type' => "eksportir",
                            'company' => getCompanyName($array[$k]),
                            'dari' => auth::user()->name,
                            'bu' =>$company->badanusaha,
                        ];

                        Mail::send('inquiry.mail.sendToEksportir', $data, function ($mail) use ($data, $users) {
                            $mail->subject('Inquiry Information');
                            $mail->to($data['email']);
                        });


                $users_admin = [];
                $adminnya = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                array_push($users_admin, env('MAIL_USERNAME','no-reply@inaexport.id'));

                
            }else{
                   
            }
        }
			if($upd){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
		
	}
		
	

    

}
