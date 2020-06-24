<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;

class FrontController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $hot_product = hotProduct();
        //Data Product yang paling banyak di br dan inquiry (query masih menggunakan query sementara)
        // $product = DB::table('csc_product_single')
        //     ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
        //     ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
        //     ->where('itdp_company_users.status', 1)
            // ->where('csc_product_single.status', 2)
        //     ->orderby('csc_product_single.id', 'DESC')
        //     // ->inRandomOrder()
        //     // ->limit(10)
        //     ->get();

        // $service = DB::table('itdp_service_eks as a')->where('status', 2)->orderBy('created_at', 'desc')->get();
        //Category Utama
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(6)
            ->get();

        $categoryutama2 = DB::table('csc_product_home as a')
            ->join('csc_product as b', 'a.id_product', '=', 'b.id')
            ->select('b.*')
            ->orderBy('a.number', 'ASC')
            ->limit(6)
            ->get();
        return view('frontend.index', compact('categoryutama', 'categoryutama2','hot_product'));
        // return view('frontend.index');
    }

    public function list_product(Request $request)
    {
        $hot_product = hotProduct();
        //Current Page
        if($request->page){
            $pagenow = $request->page;
        }else{
            $pagenow = 1;
        }
        $lct = $request->locnya;
        
        if($request->cari_product){
            $hl_sort = $request->hl_prod;
            $getEks = $request->eks_prod;
            $get_id_cat = $request->cari_catnya;
            if(strpos($get_id_cat, '|searchByName') !== false){
                $categorynya = str_replace('|searchByName', '', $get_id_cat);
                $get_id_cat = getCategorySearch($categorynya, $lct);
            }
            $search = $searchnya = trim($request->cari_product);
            // if (strpos($request->cari_product, '-') !== false) {
            //     $pecah = explode('-', $request->cari_product);
            //     $search = $request->cari_product;
            //     $searchnya = trim($pecah[0]);
            //     if(strpos($pecah[1], ',') !== false){
            //         $pecah2 = explode(',', $pecah[1]);
            //         $nama_eksportir = trim($pecah2[0]);
            //         $pecah2 = array_map(function($query){
            //             $trim = trim($query);
            //             return strtolower($trim);
            //         }, $pecah2);

            //         $getEks = getAdvListEksportir($pecah2[0]);
            //         if(in_array('hot', $pecah2) && in_array('new', $pecah2)){
            //             $hl_sort = 'hot|new';
            //         } else if(in_array('hot', $pecah2) && !in_array('new', $pecah2)){
            //             $hl_sort = 'hot';
            //         } else if (!in_array('hot', $pecah2) && in_array('new', $pecah2)){
            //             $hl_sort = 'new';
            //         }
            //             //Delete Array
            //             if (($key = array_search('hot', $pecah2)) !== false) {
            //                 unset($pecah2[$key]);
            //             }
            //             if (($key = array_search('new', $pecah2)) !== false) {
            //                 unset($pecah2[$key]);
            //             }
            //             if (($key = array_search($nama_eksportir, $pecah2)) !== false) {
            //                 unset($pecah2[$key]);
            //             }

            //         if($pecah2){
            //             sort($pecah2);
            //             $get_id_cat = getCategorySearch($pecah2[0], $lct);
            //         }
            //     } else {
            //         $getEks = getAdvListEksportir($pecah[1]);
            //     } 
            // } else {
            //     if(strpos($request->cari_product, ',') !== false){
            //         $pecah = explode(',', $request->cari_product);
            //         $search = $request->cari_product;
            //         $searchnya = trim($pecah[0]);
            //         $pecah = array_map(function($query){
            //             $trim = trim($query);
            //             return strtolower($trim);
            //         }, $pecah);

            //         if(in_array('hot', $pecah) && in_array('new', $pecah)){
            //             $hl_sort = 'hot|new';
            //         } else if(in_array('hot', $pecah) && !in_array('new', $pecah)){
            //             $hl_sort = 'hot';
            //         } else if (!in_array('hot', $pecah) && in_array('new', $pecah)){
            //             $hl_sort = 'new';
            //         }
            //             //Delete Array
            //             if (($key = array_search('hot', $pecah)) !== false) {
            //                 unset($pecah[$key]);
            //             }
            //             if (($key = array_search('new', $pecah)) !== false) {
            //                 unset($pecah[$key]);
            //             }
            //             if (($key = array_search($searchnya, $pecah)) !== false) {
            //                 unset($pecah[$key]);
            //             }
            //         if($pecah){
            //             sort($pecah);
            //             $get_id_cat = getCategorySearch($pecah[0], $lct);
            //         }
            //     } else {
            //         $search = $searchnya = trim($request->cari_product);
            //     }
            // }
        } else {
            $search = $searchnya = '';
            $getEks = $request->eks_prod;
            $hl_sort = $request->hl_prod;
            $get_id_cat = $request->cari_catnya;
            if(strpos($get_id_cat, '|searchByName') !== false){
                $categorynya = str_replace('|searchByName', '', $get_id_cat);
                $get_id_cat = getCategorySearch($categorynya, $lct);
            }
        }

        //List Category Product
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(10)
            ->get();

        //Sort By
        $sortbyproduct = NULL;
        if($request->sort_prod != NULL){
            if($request->sort_prod == "new"){
                $col = "csc_product_single.created_at DESC NULLS LAST";
            }else if($request->sort_prod == "lowhigh"){
                $col = "csc_product_single.price_usd ASC NULLS LAST";
            }else if($request->sort_prod == "highlow"){
                $col = "csc_product_single.price_usd DESC NULLS LAST";
            }else if($request->sort_prod == "asc"){
                $col = "csc_product_single.prodname_en ASC NULLS LAST";
            } else {
                $col = "updated_at DESC NULLS LAST";
            }
            $sortbyproduct = $request->sort_prod;
        }else{
            $col = "updated_at DESC NULLS LAST";
            $sortbyproduct = "default";
        }


        //Data Product
        if($get_id_cat == ''){
            $query = DB::table('csc_product_single')
                    ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                    ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                    ->where('itdp_company_users.status', 1)
                    ->where('csc_product_single.status', 2);
            $coquery = DB::table('csc_product_single')
                    ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                    ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                    ->where('itdp_company_users.status', 1)
                    ->where('csc_product_single.status', 2);

            if($search != ''){
                $nprod = "prodname_".$request->locnya;
                $query->where('csc_product_single.'.$nprod, 'ILIKE', '%'.$searchnya.'%');
                $coquery->where('csc_product_single.'.$nprod, 'ILIKE', '%'.$searchnya.'%');
            }

            if($getEks != ''){
                if (strstr($getEks, '|')){
                    $eks = explode('|', $getEks);
                }else{
                    $eks = [$getEks];
                }
                $query->whereIn('csc_product_single.id_itdp_company_user', $eks);
                $coquery->whereIn('csc_product_single.id_itdp_company_user', $eks);
            }

            //count Hot dan New Product
            $productcheck = $query->orderByRaw($col)->get();
            $countNew = 0;
            $countHot = 0;
            foreach ($productcheck as $prod) {
                if(date('Y', strtotime($prod->created_at)) == date('Y')){
                    if(date('m', strtotime($prod->created_at)) == date('m')){
                        $countNew = $countNew + 1;
                    }
                }
                if(in_array($prod->id, $hot_product)){
                    $countHot = $countHot + 1;
                }
            }

            //highlight
            if($hl_sort != ''){
                if (strstr($hl_sort, '|')) {
                    $query->where(function ($query){
                        return $query->where(function ($query){
                            return $query->whereYear('csc_product_single.created_at', date('Y'))
                              ->whereMonth('csc_product_single.created_at', date('m'));
                        })->orWhereNotNull('csc_product_single.hot');
                    });
                    $coquery->where(function ($coquery){
                        return $coquery->where(function ($coquery){
                            return $coquery->whereYear('csc_product_single.created_at', date('Y'))
                              ->whereMonth('csc_product_single.created_at', date('m'));
                        })->orWhereNotNull('csc_product_single.hot');
                    });                  
                }else{
                    if($hl_sort == "new"){
                        $query->whereYear('csc_product_single.created_at', date('Y'))->whereMonth('csc_product_single.created_at', date('m'));
                        $coquery->whereYear('csc_product_single.created_at', date('Y'))->whereMonth('csc_product_single.created_at', date('m'));
                    }else if($hl_sort == "hot"){
                            $query->whereNotNull('csc_product_single.hot');
                            $coquery->whereNotNull('csc_product_single.hot')->orderByRaw('hot desc');
                    }
                }
            }

            $coproduct = $coquery->orderByRaw($col)->count();
            $product = $query->orderByRaw($col)->paginate(12);

            $catActive = NULL;
        }else{
            $catActive = '';
            if (strstr($get_id_cat, '|')) {
                $pisah = explode('|', $get_id_cat);
                $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah[0]).'">'.getCategoryName($pisah[0], $request->locnya).'</a></li>';
                if(count($pisah) > 2){
                    $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah[1]).'">&nbsp;'.getCategoryName($pisah[1], $request->locnya).'</a></li>';
                    $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah[2]).'">&nbsp;'.getCategoryName($pisah[2], $request->locnya).'</a><i class="fa fa-window-close" id="delete_cat"></i></li>';
                } else {
                    $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah[1]).'">&nbsp;'.getCategoryName($pisah[1], $request->locnya).'</a><i class="fa fa-window-close" id="delete_cat"></i></li>';

                }
            } else {
                $pisah = $get_id_cat;
                $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah).'">&nbsp;'.getCategoryName($pisah, $request->locnya).'</a><i class="fa fa-window-close" id="delete_cat"></i></li>';
            }

            $query = $this->getQueryCategory($pisah, $request->locnya, $searchnya);
            $coquery = $this->getQueryCategory($pisah, $request->locnya, $searchnya);

            if($getEks != ''){
                if (strstr($getEks, '|')){
                    $eks = explode('|', $getEks);
                }else{
                    $eks = [$getEks];
                }
                $query->whereIn('csc_product_single.id_itdp_company_user', $eks);
                $coquery->whereIn('csc_product_single.id_itdp_company_user', $eks);
            }

            //count Hot dan New Product
            $productcheck = $query->orderByRaw($col)->get();
            $countNew = 0;
            $countHot = 0;
            foreach ($productcheck as $prod) {
                if(date('Y', strtotime($prod->created_at)) == date('Y')){
                    if(date('m', strtotime($prod->created_at)) == date('m')){
                        $countNew = $countNew + 1;
                    }
                }
                if(in_array($prod->id, $hot_product)){
                    $countHot = $countHot + 1;
                }
            }

            //highlight
            if($hl_sort != ""){
                if (strstr($hl_sort, '|')) {
                    $query->where(function ($query){
                        return $query->where(function ($query){
                            return $query->whereYear('csc_product_single.created_at', date('Y'))
                              ->whereMonth('csc_product_single.created_at', date('m'));
                        })->orWhereNotNull('csc_product_single.hot');
                    });
                    $coquery->where(function ($coquery){
                        return $coquery->where(function ($coquery){
                            return $coquery->whereYear('csc_product_single.created_at', date('Y'))
                              ->whereMonth('csc_product_single.created_at', date('m'));
                        })->orWhereNotNull('csc_product_single.hot');
                    });
                }else{
                    if($hl_sort == "new"){
                        $query->whereYear('csc_product_single.created_at', date('Y'))->whereMonth('csc_product_single.created_at', date('m'));
                        $coquery->whereYear('csc_product_single.created_at', date('Y'))->whereMonth('csc_product_single.created_at', date('m'));
                    }else if($hl_sort == "hot"){
                            $query->whereNotNull('csc_product_single.hot')->orderByRaw('hot desc');
                            $coquery->whereNotNull('csc_product_single.hot')->orderByRaw('hot desc');
                    }
                }
            }


            $coproduct = $coquery->orderByRaw($col)->count();
            $product = $query->orderByRaw($col)->paginate(12);
        }

        //Data Eksportir/Manufacturer
        // $manufacturer = DB::select(
        //     "SELECT 
        //         a.id, b.company, b.id as id_profil, (SELECT COUNT(*) FROM csc_product_single WHERE status = 2 AND id_itdp_company_user = a.id) as jml_produk
        //     FROM itdp_company_users as a
        //     JOIN itdp_profil_eks as b ON a.id_profil = b.id
        //     WHERE a.status = '1'
        //     ORDER BY jml_produk DESC
        //     LIMIT 10"
        // );
        $query_manufacture = DB::table('itdp_company_users as a')->selectRaw('a.id, b.company, count(c.*) as jml_produk')
            ->join('itdp_profil_eks as b', 'a.id_profil', 'b.id')
            ->join('csc_product_single as c', 'a.id', 'c.id_itdp_company_user')
            ->where('a.status', 1)
            ->where('c.status', 2)
            ->orderby('jml_produk', 'desc')
            ->groupby('a.id')->groupby('b.company')
            ->limit(10);
        if($searchnya != ''){
            $query_manufacture->where(function($query) use ($searchnya,$lct){
                $query->where('c.prodname_en', 'ILIKE', '%'.$searchnya.'%');
                $query->orwhere('c.prodname_'.$lct, 'ILIKE', '%'.$searchnya.'%');
            });
        }
        if($get_id_cat != ''){
            if(strstr($get_id_cat, '|')){
                $pecah = explode('|', $get_id_cat);
                $end = end($pecah);
                $catnya = [$end];
            } else {
                $catnya = [$get_id_cat];
            }
            $query_manufacture->where(function($query) use ($catnya){
                $query->whereIn('c.id_csc_product', $catnya);
                $query->orWhereIn('c.id_csc_product_level1', $catnya);
                $query->orWhereIn('c.id_csc_product_level2', $catnya);
            });
        }
        $manufacturer = $query_manufacture->get();

        if($getEks != ''){
            if (strstr($getEks, '|')){
                $eks = explode('|', $getEks);
            }else{
                $eks = [$getEks];
            }
            foreach ($eks as $key => $value) {
                if(!$manufacturer->contains('id', $value)) {
                    $collection = getCollectionManufacture($value, $searchnya, $lct);
                    $manufacturer->push($collection, true);
                }
            }
        }


        // return view('frontend.product.all_product', compact('product', 'catprod'));
        return view('frontend.product.list_product', ['product' => $product->appends(Input::except('page'))], compact('categoryutama', 'manufacturer', 'catActive', 'coproduct', 'search', 'get_id_cat', 'sortbyproduct', 'getEks', 'pagenow','hot_product', 'hl_sort', 'countNew', 'countHot'));

    }

    function getQueryCategory($dt, $lct, $search)
    {
        if(is_array($dt)){
            if($search){
                $nprod = "prodname_".$lct;
                $product = DB::table('csc_product_single')
                    ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                    ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                    ->where('itdp_company_users.status', 1)
                    ->where('csc_product_single.status', 2)
                    ->where('csc_product_single.id_csc_product', $dt[0])
                    ->where('csc_product_single.id_csc_product_level1', $dt[1])
                    ->where('csc_product_single.'.$nprod, 'ILIKE', '%'.$search.'%');
            }else{
                $product = DB::table('csc_product_single')
                    ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                    ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                    ->where('itdp_company_users.status', 1)
                    ->where('csc_product_single.status', 2)
                    ->where('csc_product_single.id_csc_product', $dt[0])
                    ->where('csc_product_single.id_csc_product_level1', $dt[1]);
            }
        }else{
            if($search){
                $nprod = "prodname_".$lct;
                $product = DB::table('csc_product_single')
                    ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                    ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                    ->where('itdp_company_users.status', 1)
                    ->where('csc_product_single.status', 2)
                    ->where('csc_product_single.id_csc_product', $dt)
                    ->where('csc_product_single.'.$nprod, 'ILIKE', '%'.$search.'%');
            }else{
                $product = DB::table('csc_product_single')
                    ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                    ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
                    ->where('itdp_company_users.status', 1)
                    ->where('csc_product_single.status', 2)
                    ->where('csc_product_single.id_csc_product', $dt);
            }
        }
        
        return $product;
    }

    public function getCategoryAll(Request $request)
    {
        $categoryall = DB::table('csc_product')->orderby('nama_kategori_en','asc');
        if (isset($request->q)) {
          $categoryall->where('nama_kategori_en', 'ILIKE', '%'.$request->q.'%')->limit(10);
        } else {
          $categoryall->limit(10);
        }
        return response()->json($categoryall->get());
    }

    public function getCategory(Request $request)
    {
        $name = $request->name;
        $loc = $request->loc;
        $srch = "nama_kategori_".$loc;
        $tampung_cat_utama = [];
        $tampung_cat_level_1 = [];
        $tampung_return = [];
        $query = DB::table('csc_product')->where($srch, 'ILIKE', '%'.$name.'%')
            ->orderByRaw('level_2 = 0, level_2')
            ->orderByRaw('level_1 = 0, level_1')
            ->orderby('nama_kategori_en','asc');
        if(strlen($name) < 4){
            $query->limit(1000);
        }
        $categoryutama = $query->get();
        $batas = count($categoryutama)-1;
        
        $result = "";
        $array_cat = $categoryutama->toArray();
        foreach ($categoryutama as $key => $value) { 
            ${"result_".$value->id} = '';
            ${"result_".$value->level_1} = '';
            ${"result_".$value->level_2} = '';
        }
        foreach($categoryutama as $key => $cu){
            if($cu->level_2 != 0){
                if(!in_array($cu->level_2, $tampung_cat_utama)){
                    array_push($tampung_cat_utama, $cu->level_2);
                    ${"result_".$cu->level_2} .= '<div class="list-group-item">
                                    <a href="'.url('/front_end/list_product/category/'.$cu->level_2).'"> '.getCategoryName($cu->level_2, $loc).' </a><a onclick="openCollapse(\''.$cu->level_2.'\')" href="#menus'.$cu->level_2.'" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop'.$cu->level_2.'"></i></a>
                                </div>
                                <div class="collapse" id="menus'.$cu->level_2.'">';
                }
                if(!in_array($cu->level_1, $tampung_cat_level_1)){
                    array_push($tampung_cat_level_1, $cu->level_1);
                    ${"result_".$cu->level_2} .= '<div class="list-group-item" style="margin-left: 10px;">
                                    <a href="'.url('/front_end/list_product/category/'.$cu->level_1).'"> '.getCategoryName($cu->level_1, $loc).' </a>
                                    <a onclick="openCollapse(\''.$cu->level_1.'\')" href="#menus'.$cu->level_1.'" data-toggle="collapse" data-parent="#SubMenu"><i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop'.$cu->level_1.'"></i></a>
                                </div>
                                <div class="collapse" id="menus'.$cu->level_1.'">';
                }

                ${"result_".$cu->level_2} .= '<a href="'.url('/front_end/list_product/category/'.$cu->id).'" class="list-group-item" style="margin-left: 20px;">'.getCategoryName($cu->id, $loc).'</a>';
                if($key != $batas)
                if($array_cat[$key+1]->level_1 != $cu->level_1){
                    ${"result_".$cu->level_2} .= '</div>';
                }
            } else if($cu->level_1 != 0 && $cu->level_2 == 0){
                if(!in_array($cu->level_1, $tampung_cat_utama)){
                    array_push($tampung_cat_utama, $cu->level_1);
                    ${"result_".$cu->level_1} .= '<div class="list-group-item">
                                    <a href="'.url('/front_end/list_product/category/'.$cu->level_1).'"> '.getCategoryName($cu->level_1, $loc).' </a><a onclick="openCollapse(\''.$cu->level_1.'\')" href="#menus'.$cu->level_1.'" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop'.$cu->level_1.'"></i></a>
                                </div><div class="collapse" id="menus'.$cu->level_1.'">';
                }

                if(!in_array($cu->id, $tampung_cat_level_1)){
                    array_push($tampung_cat_level_1, $cu->id);
                    ${"result_".$cu->level_1} .= '<a href="'.url('/front_end/list_product/category/'.$cu->id).'" class="list-group-item" style="margin-left: 10px;">'.getCategoryName($cu->id, $loc).'</a>';
                }
            } else {
                if(!in_array($cu->id, $tampung_cat_utama)){
                    array_push($tampung_cat_utama, $cu->id);
                    ${"result_".$cu->id} .= '<a href="'.url('/front_end/list_product/category/'.$cu->id).'" class="list-group-item">'.getCategoryName($cu->id, $loc).'</a>';
                }
            }
        }
        foreach ($categoryutama as $key => $val) {
            if(!in_array($val->level_2, $tampung_return) && $val->level_2 != ''){
                array_push($tampung_return, $val->level_2);
                $result .= ${"result_".$val->level_2}.'</div>';
            }
            if(!in_array($val->level_1, $tampung_return) && $val->level_1 != ''){
                array_push($tampung_return, $val->level_1);
                $result .= ${"result_".$val->level_1}.'</div>';
            }
            if(!in_array($val->id, $tampung_return) && $val->id != ''){
                array_push($tampung_return, $val->id);
                $result .= ${"result_".$val->id}.'</div>';
            }
        }

        echo $result;
    }

    public function getManufactur(Request $request)
    {
        // $manufacturer = DB::table('itdp_company_users as a')
        //     ->join('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
        //     ->selectRaw('a.*, b.id as idprofil, b.company')
        //     ->where('a.id_role', 2)
        //     ->where('b.company', 'ILIKE', '%'.$name.'%')
        //     ->limit(10)
        //     ->get();
        $name = $request->name;
        $searchProd = $request->searchnya;
        $catnya = $request->catProd;
        $lct = $request->lang;
        $cek = $request->ceked;

        if(strpos($catnya, '|searchByName') !== false){
            $categorynya = str_replace('|searchByName', '', $catnya);
            $catnya = getCategorySearch($categorynya, $lct);
        }

        if (strstr($cek, '|')){
            $cek = explode('|', $cek);
        }else{
            $cek = [$cek];
        }

        $query_manufacture = DB::table('itdp_company_users as a')->selectRaw('a.id, b.company, count(c.*) as jml_produk')
            ->join('itdp_profil_eks as b', 'a.id_profil', 'b.id')
            ->join('csc_product_single as c', 'a.id', 'c.id_itdp_company_user')
            ->where('a.status', 1)
            ->where('c.status', 2)
            ->groupby('a.id')->groupby('b.company')
            ->limit(10);

        if($name == ''){
            if($searchProd != ''){
                $query_manufacture->where(function($query) use ($searchProd,$lct){
                    $query->where('c.prodname_en', 'ILIKE', '%'.$searchProd.'%');
                    $query->orwhere('c.prodname_'.$lct, 'ILIKE', '%'.$searchProd.'%');
                });
            }
            if($catnya != ''){
                if(strstr($catnya, '|')){
                    $pecah = explode('|', $catnya);
                    $end = end($pecah);
                    $catnya = [$end];
                } else {
                    $catnya = [$catnya];
                }
                $query_manufacture->where(function($query) use ($catnya){
                    $query->whereIn('c.id_csc_product', $catnya);
                    $query->orWhereIn('c.id_csc_product_level1', $catnya);
                    $query->orWhereIn('c.id_csc_product_level2', $catnya);
                });
            }
            $query_manufacture->orderby('jml_produk', 'desc');
        } else {
            $query_manufacture->where('b.company', 'ILIKE', '%'.$name.'%')->orderby('b.company','asc');
        }
        $manufacturer = $query_manufacture->get();

        $numb = 1;
        $result = "";
        foreach($manufacturer as $man){
            $jumlahnya = '';
            $ceked = '';
            if($name == ''){
                $jumlahnya = '('.$man->jml_produk.')';
            }
            if(in_array($man->id, $cek)){
                $ceked = 'checked="true"';
            }
            $result .= '<li>
                            <input type="checkbox" value="'.$man->id.'" onclick="getProductbyEksportir(this.value, this.checked)" '.$ceked.'>
                            <a href="#" onclick="stopProcess(event)" class="hover-none">'.$man->company.$jumlahnya.'</a>
                            <span class="checkmark"></span>
                        </li>';
            $numb++;
        }
        if($result == ''){
            $result = '<center><span style="font-size:12px;color:red;">Not Found</span></center>';
        } else {
            $result .= '<li>
                            <a href="#">View All</a>
                        </li>';
        }

        return $result;
    }

    public function product_category($id)
    {
        $hot_product = hotProduct();
        $loc = app()->getLocale();
        if($loc == "ch"){
            $lct = "chn";
        }else if($loc == "in"){
            $lct = "in";
        }else{
            $lct = "en";
        }
        
        //Category Product
        $catdata = DB::table('csc_product')->where('id', $id)->first();

        //List Category Product
        $categoryutama = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->limit(10)
            ->get();

        //Data Eksportir/Manufacturer
        // $manufacturer = DB::select(
        //     "SELECT 
        //         a.id, b.company, b.id as id_profil, (SELECT COUNT(*) FROM csc_product_single WHERE status = 2 AND id_itdp_company_user = a.id) as jml_produk
        //     FROM itdp_company_users as a
        //     JOIN itdp_profil_eks as b ON a.id_profil = b.id
        //     WHERE a.status = '1'
        //     ORDER BY jml_produk DESC
        //     LIMIT 10"
        // );
        $cek_cat = DB::table('csc_product')->where('id', $id)->first();
        $tampung_cat = [$cek_cat->id];
        $query_manufacture = DB::table('itdp_company_users as a')->selectRaw('a.id, b.company, count(c.*) as jml_produk')
            ->join('itdp_profil_eks as b', 'a.id_profil', 'b.id')
            ->join('csc_product_single as c', 'a.id', 'c.id_itdp_company_user')
            ->where('a.status', 1)
            ->where('c.status', 2)
            ->orderby('jml_produk', 'desc')
            ->groupby('a.id')->groupby('b.company')
            ->limit(10);
        if(count($tampung_cat) > 0){
            $query_manufacture->where(function($query) use ($tampung_cat){
                $query->whereIn('c.id_csc_product', $tampung_cat);
                $query->orWhereIn('c.id_csc_product_level1', $tampung_cat);
                $query->orWhereIn('c.id_csc_product_level2', $tampung_cat);
            });
        }
        $manufacturer = $query_manufacture->get();

        $catActive = '';
        if($catdata->level_1 == 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a><i class="fa fa-window-close" id="delete_cat"></i></li>';
            $colnya = "id_csc_product";
            $get_id_cat = $catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->level_1).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a><i class="fa fa-window-close" id="delete_cat"></i></li>';
            $colnya = "id_csc_product_level1";
            $get_id_cat = $catdata->level_1.'|'.$catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 != 0){
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->level_2).'">'.getCategoryName($catdata->level_2, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->level_1).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a><i class="fa fa-window-close" id="delete_cat"></i></li>';
            $colnya = "id_csc_product_level2";
            $get_id_cat = $catdata->level_2.'|'.$catdata->level_1.'|'.$catdata->id;
        }

        $productnya = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.'.$colnya, $id)
            ->orderBy('csc_product_single.prodname_en', 'ASC');

        //count Hot dan New Product
        $productcheck = $productnya->get();
        $countNew = 0;
        $countHot = 0;
        foreach ($productcheck as $prod) {
            if(date('Y', strtotime($prod->created_at)) == date('Y')){
                if(date('m', strtotime($prod->created_at)) == date('m')){
                    $countNew = $countNew + 1;
                }
            }
            if(in_array($prod->id, $hot_product)){
                $countHot = $countHot + 1;
            }
        }
        
        //Data Product
        $product = $productnya->paginate(12);
        $coproduct = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.'.$colnya, $id)
            ->orderBy('csc_product_single.prodname_en', 'ASC')
            ->count();

        return view('frontend.product.list_product', compact('categoryutama', 'product', 'manufacturer', 'catActive', 'coproduct', 'get_id_cat', 'hot_product', 'countNew', 'countHot'));
    }

    public function view_product($id)
    {
        //Product Pilih
        $data = DB::table('csc_product_single')
            ->where('id', '=', $id)
            ->first();

        //Product Lain
        $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('csc_product_single.status', 2)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        //get API Kurs
        $datenow = date('Y-m-d');
        $client = new Client();
        // $res = $client->request('GET', 'https://api.ratesapi.io/api/'.$datenow, [
        //     'verify' => false,
        //     'headers' => [
        //         'Content-Type'          => 'application/json',
        //         'Accept'                => 'application/json'
        //     ],
        //     'query' => ['base' =>  'USD']
        // ]);
        $res = $client->request('GET', 'https://api.ratesapi.io/api/'.$datenow, [
            'headers' => [
                'Content-Type'          => 'application/json',
                'Accept'                => 'application/json'
            ],
            'query' => ['base' =>  'USD']
        ]);

        $bdy = $res->getBody();
        $content = json_decode($bdy->getContents());
        $rates = $content->rates;

        $imgarr = ['en.png', 'us.png', 'ch.png', 'in.png', 'jp.png', 'ks.png', 'sg.png', 'aus.png', 'mly.jpg', 'ue.png', 'thai.png', 'hk.png'];
        $smtarr = ['GBP', 'USD', 'CNY', 'IDR', 'JPY', 'KRW', 'SGD', 'AUD', 'MYR', 'EUR', 'THB', 'HKD'];
        $nmtarr = ['British Pound', 'US Dollar', 'Chinese Yuan', 'Indonesian Rupiah', 'Japanese Yen', 'South Korean Won', 'Singapore Dollar', 'Australian Dollar', 'Malaysian Ringgit', 'Euro', 'Thai Baht', 'Hong Kong Dollar'];
        return view('frontend.product.detail_products', compact('data', 'product', 'imgarr', 'smtarr', 'nmtarr', 'rates'));
    }

//    public function research_corner(){
//        // Data Broadcast FrontEnd
//        $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
//            ->orderby('a.created_at', 'desc')
//            ->distinct('a.id_research_corner', 'a.created_at')
//            ->select('b.*', 'a.id_research_corner', 'a.created_at', 'b.cover')
//            ->paginate(9, ['b.*']);
//            // ->get();
//
//        $json = json_decode($research->toJson(), true);
//        $page = $json["current_page"];
//        if($page > 1){
//         $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
//            ->distinct('a.id_research_corner', 'a.created_at')
//            ->select('b.*', 'a.id_research_corner', 'a.created_at', 'b.cover')
//            ->orderby('a.created_at', 'desc')
//            ->paginate(8, ['b.*']);
//        }
//        // $item_page = $json["data"];
//
//        return view('frontend.research-corner', compact('research', 'page'));
//    }

    public function research_corner(){
        // Data Broadcast FrontEnd
        $research = DB::table('csc_research_corner')
//            ->orderby('id', 'desc')
            ->orderby('publish_date', 'desc')
            ->select('*','cover')
            ->paginate(9, ['*']);

        $json = json_decode($research->toJson(), true);
        $page = $json["current_page"];
        if($page > 1){
         $research = DB::table('csc_research_corner')
            ->select('*','cover')
//             ->orderby('id', 'desc')
             ->orderby('publish_date', 'desc')
            ->paginate(8, ['*']);
        }
        // $item_page = $json["data"];

        return view('frontend.research-corner', compact('research', 'page'));
    }

    public function tracking(){
        $kurir = DB::table('api_tracking')->orderby('name', 'asc')->get();
        return view('frontend.tracking', compact('kurir'));
    }

    public function contact_us(){
        $page = 'create';
        $url = "/contact-us/send/";
        return view('frontend.contact-us', compact('page', 'url'));
    }

    public function service($id){
        $data = DB::table('itdp_service_eks')->where('id', $id)->first();
        return view('frontend.service', compact('data'));
    }

    public function contact_us_send(Request $req){
        $id = DB::table('csc_contact_us')->max('id') + 1;

        $data = DB::table('csc_contact_us')->insert([
            'id' => $id,
            'fullname' => $req->name,
            'email' => $req->email,
            'subyek' => $req->subyek,
            'message' => $req->message,
            'date_created' => date('Y-m-d H:i:s')
        ]);

        $notif = DB::table('notif')->insert([
            'dari_nama' => $req->name,
            'untuk_nama' => 'Super Admin',
            'untuk_id' => '1',
            'keterangan' => 'New Message from Visitor with Title  "'.$req->subyek.'"',
            'url_terkait' => 'management/contact-us/view',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'id_terkait' => $id,
            'to_role' => '1',

        ]);

        $users = [];
        $cek_user = DB::table('itdp_admin_users')->where('id_group', 1)->get();
        foreach ($cek_user as $key => $value) {
            array_push($users, $value->email);
        }

        $datanya = [
            'subyek' => $req->subyek
        ];

        Mail::send('management.contact-us.mail', $datanya, function ($mail) use ($users) {
            $mail->subject('Contact us Information');
            $mail->to($users);
        });

        if($req->urlnya){
            return redirect($req->urlnya);
        }else{
            return redirect('/');
        }
    }

    public function getSub(Request $request)
    {
        $level = $request->level;
        if($level == 1){
            $result = '';
            $catprod = DB::table('csc_product')->where('level_1', $request->idparent)->orderBy('nama_kategori_en', 'ASC')->get();
            if(count($catprod) > 0){
                foreach ($catprod as $key => $value) {
                    $nama = "'".$value->nama_kategori_en."'";
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag2" onclick="getSub(2,'.$value->level_1.', '.$value->id.','.$nama.')" id="kat2_'.$value->id.'">'.$value->nama_kategori_en.'</a>';
                }
            }else{
                $result .= 'Category Not Found';
            }
        }else{
            $result = '';
            $catprod = DB::table('csc_product')->where('level_2', $request->idparent)->where('level_1', $request->idsub)->orderBy('nama_kategori_en', 'ASC')->get();
            if(count($catprod) > 0){
                foreach ($catprod as $key => $value) {
                    $nama = "'".$value->nama_kategori_en."'";
                    $result .= '<a href="#" class="list-group-item list-group-item-action listbag3" onclick="getSub(3,'.$value->level_1.', '.$value->id.','.$nama.')" id="kat3_'.$value->id.'">'.$value->nama_kategori_en.'</a>';
                }
            }else{
                $result .= 'Category Not Found';
            }
        }
        return $result;
    }

    public function Event(Request $req){
        $country = DB::table('mst_country')
            ->join('event_detail','event_detail.country','mst_country.id')
            ->orderby('event_detail.country', 'asc')
            ->get();

        $today = date('Y-m-d');

        if($req->search && $req->search2 == null && $req->search3 == null ){
            if($req->search ){
                $searchEvent = $req->search;
                $lang = app()->getLocale();
                if($lang == 'ch'){ $lang = 'chn';}
                $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.end_date', '>=', "'".$today."'")
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                if($searchEvent == 1){
                    $param = $req->nama;
                    $query->where(function($query) use ($param,$lang){
                        $query->where('a.event_name_en', 'ILIKE', "%".$param."%")
                            ->orWhere('a.event_name_'.$lang, 'ILIKE', "%".$param."%");
                    });
                } else if($searchEvent == 2){
                    $param = $req->tanggal; 
                    // dd($seplit[1].'-'.$seplit[0]);
                    if($param != null){
                        $query->where(function ($query) use ($param) {
                            $query->where(DB::raw("date_part('YEAR', Cast(a.start_date as TIMESTAMP))"),  date('Y', strtotime($param)))
                                ->where(DB::raw("date_part('MONTH', Cast(a.start_date as TIMESTAMP))"), date('m', strtotime($param)));
                        });
                        $query->orWhere(function ($query) use ($param){
                            $query->where(DB::raw("date_part('YEAR', Cast(a.end_date as TIMESTAMP))"), date('Y', strtotime($param)))
                                ->where(DB::raw("date_part('MONTH', Cast(a.end_date as TIMESTAMP))"), date('m', strtotime($param)));
                        });
                        // $query->where(function ($query) use ($param) {
                        //     $query->where(DB::raw('YEAR(a.start_date)'), '=', date('Y', strtotime($param)))
                        //         ->where(DB::raw('MONTH(a.start_date)'), '=', date('m', strtotime($param)));
                        // });
                        // $query->orWhere(function ($query) use ($param){
                        //     $query->where(DB::raw('YEAR(a.end_date)'), '=', date('Y', strtotime($param)))
                        //         ->where(DB::raw('MONTH(a.end_date)'), '=', date('m', strtotime($param)));
                        // });
                        // $query->where(function ($query) use ($param) {
                        //     $query->where(DB::raw('YEAR(a.start_date)'), '=', date('Y', strtotime($param)))
                        //         ->where(DB::raw('MONTH(a.start_date)'), '=', date('m', strtotime($param)));
                        // });
                        // $query->orWhere(function ($query) use ($param){
                        //     $query->where(DB::raw('YEAR(a.end_date)'), '=', date('Y', strtotime($param)))
                        //         ->where(DB::raw('MONTH(a.end_date)'), '=', date('m', strtotime($param)));
                        // });
                        
                        // $query->where(function ($query) use ($param) {
                        //     $query->where('TO_TIMESTAMP(a.start_date, "MM/DD/YYYY HH24:MI:SS")', '==', "'".date('Y', strtotime($param))."'" )
                        //             ->where('TO_TIMESTAMP(a.start_date, "MM/DD/YYYY HH24:MI:SS")', '==',  "'".date('m', strtotime($param))."'" );
                        // });
                        // $query->orWhere(function ($query) use ($param){
                        //     $query->whereyear('TO_TIMESTAMP(a.end_date, "MM/DD/YYYY HH24:MI:SS")', '==', "'".date('Y', strtotime($param))."'" )
                        //     ->wheremonth('TO_TIMESTAMP(a.end_date, "MM/DD/YYYY HH24:MI:SS")', '==',  "'".date('m', strtotime($param))."'" );
                        // });
                        // $query->where(function ($query) use ($param) {
                        //     $query->where('a.start_date', '<=', $param);
                        //     $query->where('a.end_date', '>=', $param);
                        // });
                        // $query->orWhere(function ($query) use ($param){
                        //     $query->where('a.start_date', $param)
                        //         ->orWhere('a.end_date', $param);
                        // });
                    }
                } else if($searchEvent == 3) {
                    $param = $req->country;
                    $query->where('country', $param);
                }else if($searchEvent == 4) {
                    $param = $req->product;
                    $query->where('c.id_prod_cat', $param);
                }

                if($param == null){
                    return redirect('/front_end/event');
                }
                $e_detail =  DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1', DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                            ->mergeBindings($query) // you need to get underlying Query Builder
                            ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                            ->orderby('abs_beda_tanggal')
                            ->paginate(12,['*'],'page_a');
                // $e_detail = $query->paginate(12,['*'],'page_a');
                

                $page = 99999999;
            } else {
                $searchEvent = null;
                $param = null;
                $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_a');

                $json = json_decode($e_detail->toJson(), true);
                $page = $json["current_page"];
                if($page > 1){
                    
                $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_a');
                }
            }
            $halaman = 'all';
            //untuk event Indonesia
            $searchEvent2 = null;
            $param2 = null;
            $query2 = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Indonesia')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query2) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_b');

            $json = json_decode($e_detail2->toJson(), true);
            $page2 = $json["current_page"];
            if($page2 > 1){
                $query2 = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.event_scope_en','Indonesia')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query2) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_b');
            }

            //untuk event foreign
            $searchEvent3 = null;
//            $param = null;
            $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Foreign')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

            $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                ->mergeBindings($query) // you need to get underlying Query Builder
                ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                ->orderby('abs_beda_tanggal')
                ->paginate(12,['*'],'page_c');

            $json = json_decode($e_detail3->toJson(), true);
            $page3 = $json["current_page"];
            if($page3 > 1){
                $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Foreign')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_c');
            }


        }
        else if($req->search2 && $req->search == null && $req->search3 == null ){
            $halaman = 'indonesia';
            if($req->search2){
                $searchEvent2 = $req->search2;
                $lang = app()->getLocale();
                if($lang == 'ch'){ $lang = 'chn';}
                $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal')
                    ->where('a.event_scope_en','Indonesia');

                if($searchEvent2 == 1){
                    $param2 = $req->nama;
                    $query->where(function($query) use ($param2,$lang){
                        $query->where('a.event_scope_en','Indonesia');
                        $query->where('a.event_name_en', 'ILIKE', "%".$param2."%")
                            ->orWhere('a.event_name_'.$lang, 'ILIKE', "%".$param2."%");
                    });
                } else if($searchEvent2 == 2){
                    $param2 = $req->tanggal;
                    if($param2 != null){
                        $query->where(function ($query) use ($param2) {
                            $query->where(DB::raw("date_part('YEAR', Cast(a.start_date as TIMESTAMP))"),  date('Y', strtotime($param2)))
                                ->where(DB::raw("date_part('MONTH', Cast(a.start_date as TIMESTAMP))"), date('m', strtotime($param2)))
                                ->where('a.event_scope_en','Indonesia');
                        });
                        $query->orWhere(function ($query) use ($param2){
                            $query->where(DB::raw("date_part('YEAR', Cast(a.end_date as TIMESTAMP))"), date('Y', strtotime($param2)))
                                ->where(DB::raw("date_part('MONTH', Cast(a.end_date as TIMESTAMP))"), date('m', strtotime($param2)))
                                ->where('a.event_scope_en','Indonesia');
                        });
                        // $query->where(function ($query) use ($param2) {
                        //     $query->where('a.start_date', '<=', $param2);
                        //     $query->where('a.end_date', '>=', $param2);
                        // });
                        // $query->orWhere(function ($query) use ($param2){
                        //     $query->where('a.start_date', $param2)
                        //         ->orWhere('a.end_date', $param2);
                        // });
                    }
                } else if($searchEvent2 == 3) {
                    $param2 = $req->country;
                    $query->where('country', $param2)
                        ->where('a.event_scope_en','Indonesia');
                }else if($searchEvent2 == 4) {
                    $param2 = $req->product;
                    $query->where('c.id_prod_cat', $param2);
                }

                if($param2 == null){
                    return redirect('/front_end/event');
                }
                $e_detail2 =  DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                            ->mergeBindings($query) // you need to get underlying Query Builder
                            ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                            ->orderby('abs_beda_tanggal')
                            ->paginate(12,['*'],'page_b');

                $page2 = 99999999;
            } else {
                $searchEvent2 = null;
                $param = null;
                $query2 = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Indonesia')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query2) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_b');

                $json = json_decode($e_detail2->toJson(), true);
                $page2 = $json["current_page"];
                if($page2 > 1){
                    $query2 = DB::table('event_detail as a')
                        ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                        ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                        ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                        // ->where('a.status_en', 'Verified')
                        ->where('a.event_scope_en','Indonesia')
                        ->where('a.end_date', '>=', $today)
                        //->orderby('a.created_at', 'desc')
                        ->orderby('abs_beda_tanggal');

                    $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                        ->mergeBindings($query2) // you need to get underlying Query Builder
                        ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                        ->orderby('abs_beda_tanggal')
                        ->paginate(12,['*'],'page_b');
                    }
            }

            //untuk event all
            $searchEvent = null;
//            $param = null;
            
            $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

            $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                ->mergeBindings($query) // you need to get underlying Query Builder
                ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                ->orderby('abs_beda_tanggal')
                ->paginate(12,['*'],'page_a');

            $json = json_decode($e_detail->toJson(), true);
            $page = $json["current_page"];
            if($page > 1){
                
                $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_a');
            }

                //untuk event foreign
                $searchEvent3 = null;
//            $param = null;
                $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Foreign')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_c');

            $json = json_decode($e_detail3->toJson(), true);
            $page3 = $json["current_page"];
            if($page3 > 1){
                $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Foreign')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_c');
            }
        }
        else if($req->search3 && $req->search == null && $req->search2 == null ){
            $halaman = 'foreign';
            if($req->search3){
                $searchEvent3 = $req->search3;
                $lang = app()->getLocale();
                if($lang == 'ch'){ $lang = 'chn';}
                $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->where('a.event_scope_en','Foreign')
                    // ->where('a.status_en', 'Verified')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc');
                    ->orderby('abs_beda_tanggal');

                if($searchEvent3 == 1){
                    $param3 = $req->nama;
                    $query->where(function($query) use ($param3,$lang){
                        $query->where('a.event_scope_en','Foreign');
                        $query->where('a.event_name_en', 'ILIKE', "%".$param3."%")
                            ->orWhere('a.event_name_'.$lang, 'ILIKE', "%".$param3."%");
                    });
                } else if($searchEvent3 == 2){
                    $param3 = $req->tanggal;
                    if($param3 != null){
                        
                        $query->where(function ($query) use ($param3) {
                            $query->where(DB::raw("date_part('YEAR', Cast(a.start_date as TIMESTAMP))"),  date('Y', strtotime($param3)))
                                ->where(DB::raw("date_part('MONTH', Cast(a.start_date as TIMESTAMP))"), date('m', strtotime($param3)))
                                ->where('a.event_scope_en','Foreign');
                        });
                        $query->orWhere(function ($query) use ($param3){
                            $query->where(DB::raw("date_part('YEAR', Cast(a.end_date as TIMESTAMP))"), date('Y', strtotime($param3)))
                                ->where(DB::raw("date_part('MONTH', Cast(a.end_date as TIMESTAMP))"), date('m', strtotime($param3)))
                                ->where('a.event_scope_en','Foreign');
                        });
                        // $query->where(function ($query) use ($param3) {
                        //     $query->where('a.start_date', '<=', $param3);
                        //     $query->where('a.end_date', '>=', $param3);
                        // });
                        // $query->orWhere(function ($query) use ($param3){
                        //     $query->where('a.start_date', $param3)
                        //         ->orWhere('a.end_date', $param3);
                        // });
                    }
                } else if($searchEvent3 == 3) {
                    $param3 = $req->country;
                    $query->where('country', $param3)
                        ->where('a.event_scope_en','Foreign');
                }else if($searchEvent3 == 4) {
                    $param3 = $req->product;
                    $query->where('c.id_prod_cat', $param3)
                    ->where('a.event_scope_en','Foreign');
                }
               
                if($param3 == null){
                    return redirect('/front_end/event');
                }
                
                // $e_detail3 = $query->paginate(12,['*'],'page_c');
                
                // echo $query->toSql(); die();
                $e_detail3 =  DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                            ->mergeBindings($query) // you need to get underlying Query Builder
                            ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                            ->orderby('abs_beda_tanggal')
                            ->paginate(12,['*'],'page_c');
                // echo $e_detail3->toSql();die();
                $page3 = 99999999;
            } else {
                $searchEvent3 = null;
                $param3 = null;
                $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.event_scope_en','Foreign')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_c');


                $json = json_decode($e_detail3->toJson(), true);
                $page3 = $json["current_page"];
                if($page3 > 1){
                    $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.event_scope_en','Foreign')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                    $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                        ->mergeBindings($query) // you need to get underlying Query Builder
                        ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                        ->orderby('abs_beda_tanggal')
                        ->paginate(12,['*'],'page_c');
                }
            }

            //untuk event all
            $searchEvent = null;
//            $param = null;
            $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

            $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                ->mergeBindings($query) // you need to get underlying Query Builder
                ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                ->orderby('abs_beda_tanggal')
                ->paginate(12,['*'],'page_a');

            $json = json_decode($e_detail->toJson(), true);
            $page = $json["current_page"];
            if($page > 1){
                $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_a');

            }

            //untuk event Indonesia
            $searchEvent2 = null;
            $param2 = null;
            $query2 = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Indonesia')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query2) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_b');

            $json = json_decode($e_detail2->toJson(), true);
            $page2 = $json["current_page"];
            if($page2 > 1){
                $query2 = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Indonesia')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query2) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_b');
            }
        }
        else{
            $halaman = 'all';
            //event all
            $searchEvent = null;
//            $param = null;
            $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

            $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                ->mergeBindings($query) // you need to get underlying Query Builder
                ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                ->orderby('abs_beda_tanggal')
                ->paginate(12,['*'],'page_a');


            $json = json_decode($e_detail->toJson(), true);
            $page = $json["current_page"];
            if($page > 1){
                $query = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                $e_detail = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_a');

            }

            //event indonesia
            $searchEvent2 = null;
//            $param = null;
            $query2 = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Indonesia')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

            $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1')
                ->mergeBindings($query2) // you need to get underlying Query Builder
                ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                ->orderby('abs_beda_tanggal')
                ->paginate(12,['*'],'page_b');

            $json = json_decode($e_detail2->toJson(), true);
            $page2 = $json["current_page"];
            if($page2 > 1){
                $query2 = DB::table('event_detail as a')
                    ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                    ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                    ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    // ->where('a.status_en', 'Verified')
                    ->where('a.event_scope_en','Indonesia')
                    ->where('a.end_date', '>=', $today)
                    //->orderby('a.created_at', 'desc')
                    ->orderby('abs_beda_tanggal');

                $e_detail2 = DB::table( DB::raw("({$query2->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query2) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_b');
            }

            //event foreign
            $searchEvent3 = null;
//            $param = null;
            $query = DB::table('event_detail as a')
            ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
            ->join('event_detail_kategori as c','c.id_event_detail','a.id')
            ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
            // ->where('a.status_en', 'Verified')
            ->where('a.event_scope_en','Foreign')
            ->where('a.end_date', '>=', $today)
            //->orderby('a.created_at', 'desc')
            ->orderby('abs_beda_tanggal');

            $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                ->mergeBindings($query) // you need to get underlying Query Builder
                ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                ->orderby('abs_beda_tanggal')
                ->paginate(12,['*'],'page_c');

            $json = json_decode($e_detail3->toJson(), true);
            $page3 = $json["current_page"];
            if($page3 > 1){
                $query = DB::table('event_detail as a')
                ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
                ->join('event_detail_kategori as c','c.id_event_detail','a.id')
                ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                // ->where('a.status_en', 'Verified')
                ->where('a.event_scope_en','Foreign')
                ->where('a.end_date', '>=', $today)
                //->orderby('a.created_at', 'desc')
                ->orderby('abs_beda_tanggal');

                $e_detail3 = DB::table( DB::raw("({$query->toSql()}) as sub") )->select('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
                    ->mergeBindings($query) // you need to get underlying Query Builder
                    ->groupby('event_name_chn','event_name_en','event_name_in','start_date','end_date','id_event_place','id','image_1','abs_beda_tanggal')
                    ->orderby('abs_beda_tanggal')
                    ->paginate(12,['*'],'page_c');
            }

        }


        //return view('frontend.event.index', ['e_detail' => $e_detail->appends(Input::except('page')),'e_detail2' => $e_detail2->appends(Input::except('page')),'e_detail3' => $e_detail3->appends(Input::except('page'))], compact('page','page2', 'page3', 'searchEvent','searchEvent2' ,'searchEvent3' ,'country', 'param', 'param2','param3','halaman'));
        return view('frontend.event.index', ['e_detail' => $e_detail->appends(Input::except('page')),'e_detail2' => $e_detail2->appends(Input::except('page')),'e_detail3' => $e_detail3->appends(Input::except('page'))], compact('page','page2', 'page3', 'searchEvent','searchEvent2' ,'searchEvent3' ,'country', 'param', 'param2','param3','halaman'));
    }

    public function join_event($id){
        $detail = DB::table('event_detail')->where('status_en', 'Verified')->where('id', $id)->first();
        return view('frontend.event.detail_event', compact('detail'));
    }

    public function event_interest(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        $cek = DB::table('event_interest')->where('id_profile', $id_profil)->where('id_event', $req->id)->first();
        $return = 'failed';
        if(!$cek){
            DB::table('event_interest')->insert([
                'id_profile' => $id_profil,
                'id_event' => $req->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $return = 'success';
        } 
        
        return json_encode($return);
    }

    public function training_interest(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        $cek = DB::table('training_interest')->where('id_profile', $id_profil)->where('id_training', $req->id)->first();
        $return = 'failed';
        if(!$cek){
            DB::table('training_interest')->insert([
                'id_profile' => $id_profil,
                'id_training' => $req->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $return = 'success';
        } 
        
        return json_encode($return);
    }

    public function gabung_event($id)
    {   
        $id_user = Auth::guard('eksmp')->user()->id;
        $cek = DB::table('notif')->where('url_terkait', 'event/show/read')->where(function($param) use ($id_user,$id){
            $param->where('untuk_id', $id_user)
                  ->where('id_terkait', $id);
        })->first();
        if($cek){
            DB::table('notif')->where('url_terkait', 'event/show/read')
            ->where(function($param) use ($id_user,$id){
                $param->where('untuk_id', $id_user)
                      ->where('id_terkait', $id);
            })->update([
                'status' => 1,
                'status_baca' => 1
            ]);
        } else {
            $cek = DB::table('event_company_add')->where('id_event_detail', $id)->where('id_itdp_profil_eks', $id_user)->first();
            if (!$cek) {
                $data = DB::table('event_company_add')->insert([
                    'id_itdp_profil_eks' => $id_user,
                    'id_event_detail' => $id,
                    'waktu' => date('Y-m-d H:i:s'),
                    'status' => 1
                ]);
            } else {
                $data = $cek;
            }
        }

        $detail = DB::table('event_detail')->where('status_en', 'Verified')->where('id', $id)->first();
        return view('frontend.event.detail_event', compact('detail', 'data'));
    }

    //Front End Training
    public function indexTraining(){
        $pageTitle = 'Training';
        $today = date('Y-m-d');
//        $todaydate = date('Y-m-d');
//        dd(Current_Time());
//		$data = DB::table('training_admin')->where('status', 1)->whereDate('end_date', '>=', $today)->orderby(DB::raw('ABS(DATEDIFF(created_at,'.$todaydate.'))'))->paginate(3);
//		$data = DB::table('training_admin')->where('status', 1)->whereDate('end_date', '>=', $today)->orderby('start_date ','asc')->paginate(3);
//		$data = DB::table('training_admin')->select(DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))->where('status', 1)->whereDate('end_date', '>=', $today)->orderby(DB::raw('start_date - now()'))->paginate(3);
		$data = DB::table('training_admin')
            ->select('*',DB::raw("case when start_date - now() < INTERVAL '0' then -(start_date - now())else start_date - now() end as abs_beda_tanggal"))
            ->where('status', 1)
            ->whereDate('end_date', '>=', $today)
            ->orderby('abs_beda_tanggal')
            ->paginate(3);

		return view('frontend.training',compact('data','pageTitle'));
    }

    public function indexTrainingSearch(Request $request){
			$cari = $request->cari;
            $today = date('Y-m-d');
			$data = DB::table('training_admin')
			->where('training_in','like',"%".$cari."%")
            ->whereDate('end_date', '>=', $today)
			->paginate(10);

			$pageTitle = 'Training';

			return view('training.frontend.index',compact('data','pageTitle'));
		}
    //End Training Front End
    public function about()
    {
        return view('frontend.about');
    }

    public function hot(Request $req){
        $data = DB::table('csc_product_single')->where('id', $req->id)->first();
        $data = DB::table('csc_product_single')->where('id', $req->id)->update([
            'hot' => $data->hot+1
        ]);

        $return = 'no';
        if($data){
            $return = 'ok';
        }
        return json_encode($return);
    }

    public function getcountryall(Request $request){
        $countryall = DB::table('mst_country')
            ->join('event_detail','event_detail.country','mst_country.id')
            ->select('mst_country.country','event_detail.country as id')
            ->groupby('mst_country.country', 'event_detail.country');

        if (isset($request->q)) {
            $search = $request->q;
            $countryall->where(function ($query) use ($search) {
                $query->where('mst_country.country', 'ilike', '%' . $search . '%')
                    ->orderby('event_detail.country', 'asc');
            });
            //          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
//            $hscode->where('desc_eng', 'ILIKE', '%'.$request->q.'%');
        } else if (isset($request->code)) {
            $countryall->where('mst_country.id', $request->code)
                        ->orderby('event_detail.country', 'asc');
        } else {
            $countryall->limit(10);
        }

        return response()->json($countryall->get());
    
    }

    public function getcountryindonesia(Request $request){
        $countryall = DB::table('mst_country')
            ->join('event_detail','event_detail.country','mst_country.id')
            ->select('mst_country.country','event_detail.country as id')
            ->groupby('mst_country.country', 'event_detail.country')
            ->where('event_scope_en','Indonesia');

        if (isset($request->q)) {
            $search = $request->q;
            $countryall->where(function ($query) use ($search) {
                $query->where('mst_country.country', 'ilike', '%' . $search . '%')
                    ->orderby('event_detail.country', 'asc');
            });
            //          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
//            $hscode->where('desc_eng', 'ILIKE', '%'.$request->q.'%');
        } else if (isset($request->code)) {
            $countryall->where('mst_country.id', $request->code)
                    ->orderby('event_detail.country', 'asc');
        } else {
            $countryall->limit(10);
        }

        return response()->json($countryall->get());
    
    }

    public function getcountryforeign(Request $request){
        $countryall = DB::table('mst_country')
            ->join('event_detail','event_detail.country','mst_country.id')
            ->select('mst_country.country','event_detail.country as id')
            ->groupby('mst_country.country', 'event_detail.country')
            ->where('event_scope_en','Foreign');

        if (isset($request->q)) {
            $search = $request->q;
            $countryall->where(function ($query) use ($search) {
                $query->where('mst_country.country', 'ilike', '%' . $search . '%')
                        ->orderby('event_detail.country', 'asc');
            });
            //          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
//            $hscode->where('desc_eng', 'ILIKE', '%'.$request->q.'%');
        } else if (isset($request->code)) {
            $countryall->where('mst_country.id', $request->code)
                        ->orderby('event_detail.country', 'asc');
        } else {
            $countryall->limit(10);
        }

        return response()->json($countryall->get());
    
    }

    public function getcategoryallevent(Request $request){
        $categoryall = DB::table('csc_product')
            ->join('event_detail_kategori','event_detail_kategori.id_prod_cat','csc_product.id')
            ->join('event_detail','event_detail_kategori.id_event_detail','event_detail.id')
            ->select('csc_product.nama_kategori_en','event_detail_kategori.id_event_detail','event_detail_kategori.id_prod_cat as id','event_detail.event_scope_en')
            ->groupby('csc_product.nama_kategori_en','event_detail_kategori.id_event_detail','event_detail_kategori.id_prod_cat','event_detail.event_scope_en');

        if (isset($request->q)) {
            $search = $request->q;
            $categoryall->where(function ($query) use ($search) {
                $query->where('csc_product.nama_kategori_en', 'ilike', '%' . $search . '%');
            });
            //          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
//            $hscode->where('desc_eng', 'ILIKE', '%'.$request->q.'%');
        } else if (isset($request->code)) {
            $categoryall->where('csc_product.id', $request->code);
        } else {
            $categoryall->groupby('csc_product.nama_kategori_en')
                        ->orderby('csc_product.nama_kategori_en', 'asc')
                        ->limit(10);
        }

        $final_query = DB::table( DB::raw("({$categoryall->toSql()}) as sub") )->select('nama_kategori_en','id')
        ->mergeBindings($categoryall) // you need to get underlying Query Builder
        ->groupby('nama_kategori_en','id');

        return response()->json($final_query->get());
    
    }

    public function getcategoryindonesiaevent(Request $request){
        $categoryall = DB::table('csc_product')
            ->join('event_detail_kategori','event_detail_kategori.id_prod_cat','csc_product.id')
            ->join('event_detail','event_detail_kategori.id_event_detail','event_detail.id')
            ->select('csc_product.nama_kategori_en','event_detail_kategori.id_event_detail','event_detail_kategori.id_prod_cat as id','event_detail.event_scope_en')
            ->groupby('csc_product.nama_kategori_en','event_detail_kategori.id_event_detail','event_detail_kategori.id_prod_cat','event_detail.event_scope_en');

        if (isset($request->q)) {
            $search = $request->q;
            $categoryall->where(function ($query) use ($search) {
                $query->where('csc_product.nama_kategori_en', 'ilike', '%' . $search . '%');
            });
            //          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
//            $hscode->where('desc_eng', 'ILIKE', '%'.$request->q.'%');
        } else if (isset($request->code)) {
            $categoryall->where('csc_product.id', $request->code);
        } else {
            $categoryall->where('event_detail.event_scope_en',"Indonesia")
                        ->groupby('csc_product.nama_kategori_en')
                        ->orderby('csc_product.nama_kategori_en', 'asc')
                        ->limit(10);
        }

        $final_query = DB::table( DB::raw("({$categoryall->toSql()}) as sub") )->select('nama_kategori_en','id')
        ->mergeBindings($categoryall) // you need to get underlying Query Builder
        ->groupby('nama_kategori_en','id');
        
        return response()->json($final_query->get());
    
    }

    public function getcategoryforeignevent(Request $request){
        $categoryall = DB::table('csc_product')
            ->join('event_detail_kategori','event_detail_kategori.id_prod_cat','csc_product.id')
            ->join('event_detail','event_detail_kategori.id_event_detail','event_detail.id')
            ->select('csc_product.nama_kategori_en','event_detail_kategori.id_event_detail','event_detail_kategori.id_prod_cat as id','event_detail.event_scope_en')
            ->groupby('csc_product.nama_kategori_en','event_detail_kategori.id_event_detail','event_detail_kategori.id_prod_cat','event_detail.event_scope_en');

        if (isset($request->q)) {
            $search = $request->q;
            $categoryall->where(function ($query) use ($search) {
                $query->where('csc_product.nama_kategori_en', 'ilike', '%' . $search . '%');
            });
            //          $hscode->where('fullhs', 'ILIKE', '%'.$request->q.'%');//ini untuk carinya pake full hs
//            $hscode->where('desc_eng', 'ILIKE', '%'.$request->q.'%');
        } else if (isset($request->code)) {
            $categoryall->where('csc_product.id', $request->code);
        } else {
            $categoryall->where('event_detail.event_scope_en',"Foreign")
                        ->groupby('csc_product.nama_kategori_en')
                        ->orderby('csc_product.nama_kategori_en', 'asc')
                        ->limit(10);
        }

        $final_query = DB::table( DB::raw("({$categoryall->toSql()}) as sub") )->select('nama_kategori_en','id')
        ->mergeBindings($categoryall) // you need to get underlying Query Builder
        ->groupby('nama_kategori_en','id');
        // echo $final_query->toSql();die();
        return response()->json($final_query->get());
    
    }
    
}
