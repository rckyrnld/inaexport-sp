<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class NewsController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function news()
    {
        $pageTitle = "Inaexport News";
        $topMenu = "news";
        $news = DB::table('itdp_news')->orderby('publish_date','desc')->get();
        return view('news.newslist', compact('news', 'pageTitle', 'topMenu'));
    }

    public function getnews($id) {
        $detail = DB::table('itdp_news')->where('id', $id)->first();
        $pageTitle = $detail->title." | Inaexport";
        $topMenu = "news";
        
        return view('news.getnews', compact('detail', 'pageTitle', 'topMenu'));
    }

    public function firstsentence($content) {

    $content = html_entity_decode(strip_tags($content));
    $pos = strpos($content, '.');
       
    if($pos === false) {
        return $content;
    }
    else {
        return substr($content, 0, $pos+1);
    }
   
}
	


}