<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MasterBannerController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function index(){
    $pageTitle = 'Master Banner';
    return view('master.banner.index',compact('pageTitle'));
  }
}
