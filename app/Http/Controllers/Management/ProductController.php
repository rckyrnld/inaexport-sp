<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class ProductController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Category Product';
      $product = DB::table('csc_product')->get();
      return view('management.product.index',compact('pageTitle','product'));
    }

    public function create()
    {

    }

    public function store(Request $req, $param)
    {
      
    }

    public function view($id)
    {
      
    }

    public function edit($id)
    {
      
    }

    public function destroy($id)
    {
      
    }

    public function export()
    {
      
    }
}
