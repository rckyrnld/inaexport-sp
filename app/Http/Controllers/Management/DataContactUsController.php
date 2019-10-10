<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DataContactUsController extends Controller
{

	public function __construct(){
        $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Data Contact Us';
      $contactus = DB::table('csc_contact_us')->orderby('id','asc')->get();
      return view('management.contact-us.index',compact('pageTitle','contactus'));
    }

    public function store(Request $req, $param)
    {
      $id = DB::table('csc_contact_us')->orderby('id','desc')->first();
      if($id){
        $id = $id->id+1;
      } else {
        $id = 1;
      }

      $data = MasterCity::insert([
        'id' => $id,
        'fullname' => $req->name,
        'email' => $req->email,
        'subyek' => $req->subyek,
        'message' => $req->message,
        'date_created' => date('Y-m-d H:i:s')
      ]);

      if($data){
         Session::flash('success','Success');
         return redirect('/management-contactus/');
       }else{
         Session::flash('failed','Failed');
         return redirect('/management-contactus/');
       }
    }

    public function view($id)
    {
      $pageTitle = "City";
      $page = "view";
      $data = MasterCity::where('id', $id)->first();
      $country = MasterCountry::orderby('id')->get();
      return view('management.contactus.create',compact('page','data','pageTitle','country'));
    }

    public function destroy($id)
    {
      $data = MasterCity::where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/management-contactus/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/management-contactus/');
       }
    }
}
