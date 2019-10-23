<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        //Data Product
        $product = DB::table('csc_product_single')
            ->inRandomOrder()
            ->limit(10)
            ->get();
        return view('frontend.index', compact('product'));
    }

    public function all_product()
    {
        //List Category Product
        $catprod = DB::table('csc_product')
            ->where('level_1', 0)
            ->where('level_2', 0)
            ->orderBy('nama_kategori_en', 'ASC')
            ->get();
        //Data Product
        $product = DB::table('csc_product_single')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('frontend.product.all_product', compact('product', 'catprod'));
    }

    public function product_category($id)
    {
        //Category Product
        $catdata = DB::table('csc_product')->where('id', $id)->first();
        //Product dengan Category yang dipilih
        $prodcategory = DB::table('csc_product_single')->where('id_csc_product', $id)->orderby('prodname_en', 'asc')->paginate(20);
        return view('frontend.product.product_category', compact('catdata', 'prodcategory'));
    }

    public function view_product($id)
    {
        //Product
        $data = DB::table('csc_product_single')
            ->where('id', '=', $id)
            ->first();
        //Category Per Level
        $catprod = DB::table('csc_product')->where('level_1', 0)->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod2 = DB::table('csc_product')->whereNotNull('level_1')->where('level_2', 0)->orderBy('nama_kategori_en', 'ASC')->get();
        $catprod3 = DB::table('csc_product')->whereNotNull('level_1')->whereNotNull('level_2')->orderBy('nama_kategori_en', 'ASC')->get();
        return view('frontend.product.view_product', compact('data', 'catprod', 'catprod2', 'catprod3'));
    }

    public function research_corner(){
        // Data Broadcast FrontEnd
        $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
            ->orderby('a.created_at', 'desc')
            ->distinct('a.id_research_corner', 'a.created_at')
            ->select('b.*', 'a.id_research_corner', 'a.created_at')
            ->limit(10)
            ->get();

        return view('frontend.research-corner', compact('product', 'research'));
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
        $e_detail = DB::table('event_detail')->orderby('id', 'asc')->paginate(8);
        return view('frontend.event.index', compact('e_detail'));
    }

    public function search_event(Request $req){
        $eq = $req->eq;
        if ($eq!="") {
            $e_detail = DB::table('event_detail')->where('event_name_en', 'LIKE', '%'.$eq.'%')->orderby('id', 'asc')->paginate(8)->setPath( '' );
            $pagination = $e_detail->appends(array('eq' => $req->eq));
            $e_detail->appends($req->only('eq'));
            if (count($e_detail) > 0) {
                return view('frontend.event.index', compact('e_detail'));
            }else{
                return view('frontend.event.index', compact('e_detail'))->withMessage('No Details found. Try to search again !');
            }
        }else{
            return redirect('/event');
        }
    }

    public function join_event($id){
        $detail = DB::table('event_detail')->where('id', $id)->first();
        return view('frontend.event.join_event', compact('detail'));
    }
}
