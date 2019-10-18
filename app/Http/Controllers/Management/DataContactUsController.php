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

    public function getData()
    {
      $contactus = DB::table('csc_contact_us')->orderby('id','asc')->get();

      return \Yajra\DataTables\DataTables::of($contactus)
          ->addIndexColumn()
          ->addColumn('action', function ($data) {
              return '
              <center>
              <div class="btn-group">
                <a href="'.route('management.contactus.view', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Data Ini ?\')" href="'.route('management.contactus.destroy', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
              </div>
              </center>
              ';
          })
          ->rawColumns(['action'])
          ->make(true);
    }

    public function store(Request $req)
    {
      $id = DB::table('csc_contact_us')->orderby('id','desc')->first();
      if($id){
        $id = $id->id+1;
      } else {
        $id = 1;
      }

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
            'url_terkait' => 'management-contact-us/view',
            'status_baca' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'id_terkait' => $id,
        ]);

      if($data){
         Session::flash('success','Success');
         return redirect('/management-contact-us/');
       }else{
         Session::flash('failed','Failed');
         return redirect('/management-contact-us/');
       }
    }

    public function create()
    {
      $pageTitle = 'Data Contact Us';
      $page = 'create';
      $url = "/contact-us/send/";
      return view('management.contact-us.create',compact('url','pageTitle','page'));
    }

    public function view($id)
    {
      $pageTitle = "Data Contact Us";
      $page = "view";
      $data = DB::table('csc_contact_us')->where('id',$id)->first();
      $read_notif = DB::table('notif')->where('id_terkait',$id)->update(['status_baca' => 1]);
      return view('management.contact-us.create',compact('page','data','pageTitle'));
    }

    public function destroy($id)
    {
      $data = DB::table('csc_contact_us')->where('id',$id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/management-contact-us/');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/management-contact-us/');
       }
    }
}
