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

class FrontController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
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
            ->limit(9)
            ->get();

        $categoryutama2 = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('id', 'ASC')
            ->limit(8)
            ->get();
        return view('frontend.index', compact('categoryutama', 'categoryutama2'));
        // return view('frontend.index');
    }

    public function list_product(Request $request)
    {
        //Current Page
        if($request->page){
            $pagenow = $request->page;
        }else{
            $pagenow = 1;
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
        if($request->sort_prod != NULL || $request->sort_prod != ""){
            if($request->sort_prod == "new"){
                $col = "csc_product_single.created_at";
                $asdes = "DESC";
            }else if($request->sort_prod == "lowhigh"){
                $col = "csc_product_single.price_usd";
                $asdes = "ASC";
            }else if($request->sort_prod == "highlow"){
                $col = "csc_product_single.price_usd";
                $asdes = "DESC";
            }else if($request->sort_prod == "asc"){
                $col = "csc_product_single.prodname_en";
                $asdes = "ASC";
            }
            $sortbyproduct = $request->sort_prod;
        }else{
            $col = "updated_at";
            $asdes = "DESC";
            $sortbyproduct = "";
        }


        //Data Product
        if($request->cari_catnya == NULL){
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

            $search = "";
            if($request->cari_product){
                $search = $request->cari_product;
                $nprod = "prodname_".$request->locnya;
                $query->where('csc_product_single.'.$nprod, 'ILIKE', '%'.$search.'%');
                $coquery->where('csc_product_single.'.$nprod, 'ILIKE', '%'.$search.'%');
            }

            $getEks = "";
            if($request->eks_prod){
                if (strstr($request->eks_prod, '|')){
                    $eks = explode('|', $request->eks_prod);
                }else{
                    $eks = [$request->eks_prod];
                }
                $query->whereIn('csc_product_single.id_itdp_company_user', $eks);
                $coquery->whereIn('csc_product_single.id_itdp_company_user', $eks);
                $getEks = $request->eks_prod;
            }

            $coproduct = $coquery->orderBy($col, $asdes)->count();
            $product = $query->orderBy($col, $asdes)->paginate(12);

            $catActive = NULL;
            $get_id_cat = NULL;
        }else{
            $catActive = '';
            if (strstr($request->cari_catnya, '|')) {
                $pisah = explode('|', $request->cari_catnya);
                $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah[0]).'">'.getCategoryName($pisah[0], $request->locnya).'</a></li>';
                $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah[1]).'">'.getCategoryName($pisah[1], $request->locnya).'</a></li>';
                $get_id_cat = $pisah[0].'|'.$pisah[1];
            } else {
                $pisah = $request->cari_catnya;
                $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$pisah).'">'.getCategoryName($pisah, $request->locnya).'</a></li>';
                $get_id_cat = $pisah;
            }

            if($request->cari_product){
                $search = $request->cari_product;
            }else{
                $search = "";
            }

            $query = $this->getQueryCategory($pisah, $request->locnya, $request->cari_product);
            $coquery = $this->getQueryCategory($pisah, $request->locnya, $request->cari_product);
            $getEks = "";
            if($request->eks_prod){
                if (strstr($request->eks_prod, '|')){
                    $eks = explode('|', $request->eks_prod);
                }else{
                    $eks = [$request->eks_prod];
                }
                $query->whereIn('csc_product_single.id_itdp_company_user', $eks);
                $coquery->whereIn('csc_product_single.id_itdp_company_user', $eks);
                $getEks = $request->eks_prod;
            }
            $coproduct = $coquery->orderBy($col, $asdes)->count();
            $product = $query->orderBy($col, $asdes)->paginate(12);
        }

        //Data Eksportir/Manufacturer
        $manufacturer = DB::select(
            "SELECT 
                a.id, b.company, b.id as id_profil, (SELECT COUNT(*) FROM csc_product_single WHERE status = 2 AND id_itdp_company_user = a.id) as jml_produk
            FROM itdp_company_users as a
            JOIN itdp_profil_eks as b ON a.id_profil = b.id
            WHERE a.status = '1'
            ORDER BY jml_produk DESC
            LIMIT 10"
        );

        // return view('frontend.product.all_product', compact('product', 'catprod'));
        return view('frontend.product.list_product', compact('categoryutama', 'product', 'manufacturer', 'catActive', 'coproduct', 'search', 'get_id_cat', 'sortbyproduct', 'getEks', 'pagenow'));

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
                    ->where('csc_product_single.id_csc_product', $dt)
                    ->orderBy($col, $ord)
                    ->paginate(12);
            }
        }
        
        return $product;
    }

    public function getCategory(Request $request)
    {
        $name = $request->name;
        $loc = $request->loc;
        $srch = "nama_kategori_".$loc;
        $categoryutama = DB::table('csc_product')
            ->where($srch, 'ILIKE', '%'.$name.'%')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->limit(10)
            ->get();

        $result = "";
        foreach($categoryutama as $cu){
            $catprod1 = getCategoryLevel(1, $cu->id, "");
            $nk = "nama_kategori_".$loc; 
            if($cu->$nk == NULL){
                $nk = "nama_kategori_en";
            }

            if(count($catprod1) == 0){
                $result .= '<a href="'.url('/front_end/list_product/category/'.$cu->id).'" class="list-group-item">'.$cu->$nk.'</a>';
            }else{
                $result .= '<a onclick="openCollapse(\''.$cu->id.'\')" href="#menus'.$cu->id.'" class="list-group-item" data-toggle="collapse" data-parent="#MainMenu"> '.$cu->$nk.' <i class="fa fa-chevron-down" aria-hidden="true" style="float: right; margin-right: -10px;" id="fontdrop'.$cu->id.'"></i></a>
                        <div class="collapse" id="menus'.$cu->id.'">';
                foreach($catprod1 as $cat1){
                    $result .= '<a href="'.url('/front_end/list_product/category/'.$cat1->id).'" class="list-group-item">'.$cat1->$nk.'</a>';
                }
                $result .= '</div>';
            }
        }

        echo $result;
    }

    public function getManufactur(Request $request)
    {
        $name = $request->name;
        $manufacturer = DB::table('itdp_company_users as a')
            ->join('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
            ->selectRaw('a.*, b.id as idprofil, b.company')
            ->where('a.id_role', 2)
            ->where('b.company', 'ILIKE', '%'.$name.'%')
            ->limit(10)
            ->get();

        $numb = 1;
        $result = "";
        foreach($manufacturer as $man){
            $result .= '<li>
                            <input type="checkbox">
                            <a href="#">'.$man->company.'('.getCountProduct('company', $man->id).')</a>
                            <span class="checkmark"></span>
                        </li>';
            $numb++;
        }
        $result .= '<li>
                        <a href="#">View All</a>
                    </li>';

        return $result;
    }

    public function product_category($id)
    {
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
        $manufacturer = DB::select(
            "SELECT 
                a.id, b.company, b.id as id_profil, (SELECT COUNT(*) FROM csc_product_single WHERE status = 2 AND id_itdp_company_user = a.id) as jml_produk
            FROM itdp_company_users as a
            JOIN itdp_profil_eks as b ON a.id_profil = b.id
            WHERE a.status = '1'
            ORDER BY jml_produk DESC
            LIMIT 10"
        );

        $catActive = '';
        if($catdata->level_1 == 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $colnya = "id_csc_product";
            $get_id_cat = $catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 == 0){
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->level_1).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $colnya = "id_csc_product_level1";
            $get_id_cat = $catdata->level_1.'|'.$catdata->id;
        }else if($catdata->level_1 != 0 && $catdata->level_2 != 0){
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->level_2).'">'.getCategoryName($catdata->level_2, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->level_1).'">'.getCategoryName($catdata->level_1, $lct).'</a></li>';
            $catActive .= '<li><a href="'.url('/front_end/list_product/category/'.$catdata->id).'">'.getCategoryName($catdata->id, $lct).'</a></li>';
            $colnya = "id_csc_product_level2";
            $get_id_cat = $catdata->level_2.'|'.$catdata->level_1.'|'.$catdata->id;
        }

        //Data Product
        $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.'.$colnya, $id)
            ->orderBy('csc_product_single.prodname_en', 'ASC')
            ->paginate(12);
        $coproduct = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.'.$colnya, $id)
            ->orderBy('csc_product_single.prodname_en', 'ASC')
            ->count();

        return view('frontend.product.list_product', compact('categoryutama', 'product', 'manufacturer', 'catActive', 'coproduct', 'get_id_cat'));
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

    public function research_corner(){
        // Data Broadcast FrontEnd
        $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
            ->orderby('a.created_at', 'desc')
            ->distinct('a.id_research_corner', 'a.created_at')
            ->select('b.*', 'a.id_research_corner', 'a.created_at', 'b.cover')
            ->paginate(9, ['b.*']);
            // ->get();

        $json = json_decode($research->toJson(), true);
        $page = $json["current_page"];
        if($page > 1){
         $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
            ->distinct('a.id_research_corner', 'a.created_at')
            ->select('b.*', 'a.id_research_corner', 'a.created_at', 'b.cover')
            ->orderby('a.created_at', 'desc')
            ->paginate(8, ['b.*']);
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

    public function Event(){
        $e_detail = DB::table('event_detail as a')
            ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
            ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn')
            ->where('a.status_en', 'Verified')->orderby('a.id', 'desc')
            ->paginate(9);

        $json = json_decode($e_detail->toJson(), true);
        $page = $json["current_page"];
        if($page > 1){
         $e_detail = DB::table('event_detail as a')
            ->join('event_place as b', 'a.id_event_place', '=', 'b.id')
            ->select('a.*', 'b.name_en', 'b.name_in', 'b.name_chn')
            ->where('a.status_en', 'Verified')->orderby('a.id', 'desc')
            ->paginate(8);
        }
        // dd($e_detail);
            // ->get();
        return view('frontend.event.index', compact('e_detail', 'page'));
    }

    public function join_event($id){
        $detail = DB::table('event_detail')->where('status_en', 'Verified')->where('id', $id)->first();
        return view('frontend.event.detail_event', compact('detail'));
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
		$data = DB::table('training_admin')->where('status', 1)->orderby('created_at', 'desc')->paginate(3);
      return view('frontend.training',compact('data','pageTitle'));
    }

    public function indexTrainingSearch(Request $request){
			$cari = $request->cari;

			$data = DB::table('training_admin')
			->where('training_in','like',"%".$cari."%")
			->paginate(10);

			$pageTitle = 'Training';

			return view('training.frontend.index',compact('data','pageTitle'));
		}
    //End Training Front End
    public function about()
    {
        return view('frontend.about');
    }
}
