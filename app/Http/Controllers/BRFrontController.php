<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class BRFrontController extends Controller
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
    public function br_importir()
    {
        $pageTitle = "Buying Request Importer";
        return view('buying-request.br_importir',compact('pageTitle'));
    } 
	
	
}
