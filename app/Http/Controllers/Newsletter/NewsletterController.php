<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;

class NewsletterController extends Controller
{

	public function __construct(){

  }

	  public function index(){
      $pageTitle = 'Newsletter';
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('newsletter.index',compact('pageTitle'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function getData()
    {
      $news = DB::table('itdp_newsletter')->orderBy('created_at','desc')->get();

      return \Yajra\DataTables\DataTables::of($news)
          ->addIndexColumn()
          ->addColumn('messages', function($data){
            $pecah = explode('<p>', $data->messages);
            $text = str_replace('</p>', '', $pecah[1]);
            if(count($pecah) > 2){ $text = $text.'&hellip;'; }
            return strip_tags($text, "");
          })
          ->addColumn('action', function ($data) {
            $p = '<center><div class="btn-group">';
            if($data->status == 1){
              $p .= '<a href="'.route('newsletter.view', $data->id).'" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;<a onclick="return confirm(\'Are You Sure ?\')" href="'.route('newsletter.destroy', $data->id).'" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash text-white"></i></a> ';
            } else {
              $p .= '<button type="button" class="btn btn-sm btn-warning" title="Broadcast" onclick="broadcast('.$data->id.')"><i class="fa fa-bullhorn text-white"></i></button>&nbsp;<a href="'.route('newsletter.edit', $data->id).'" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>';
            }
            return $p.'</div></center>';
          })
          ->addColumn('status', function ($data) {
            $p = '';
            if($data->status == 1){$p = '<center><span class="btn btn-sm btn-success" style="cursor:default;"><i class="fa fa-check"></i></span></center> ';}
            return $p;
          })
          ->rawColumns(['action','status'])
          ->make(true);
    }

    public function create()
    {
      $pageTitle = 'Newsletter';
      $page = 'create';
      $url = "/newsletter/store/Create";
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('newsletter.create',compact('url','pageTitle','page'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function store(Request $req, $param)
    { 
      date_default_timezone_set('Asia/Jakarta');

      $destination= 'uploads\Newsletter\File\\';
      if($req->hasFile('file')){ 
        $file = $req->file('file');
        $nama_file = time().'_'.date('Y_m_d').'_'.$req->file('file')->getClientOriginalName();
        Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
      } else { $nama_file = $req->lastest_file; }

      if($param == 'Create'){
        $data =  DB::table('itdp_newsletter')->insert([
          'about' => $req->about,
          'messages' => $req->messages,
          'file' => $nama_file,
          'status' => 0,
          'created_at' => date('Y-m-d H:i:s')
        ]);
      } else {
        $pecah = explode('|', $param);
        $param = $pecah[0];

        $data =  DB::table('itdp_newsletter')->where('id', $pecah[1])->update([
          'about' => $req->about,
          'messages' => $req->messages,
          'file' => $nama_file,
          'updated_at' => date('Y-m-d H:i:s')
        ]);
      }

      if($data){
         Session::flash('success','Success '.$param.'d Data');
         return redirect('/newsletter/')->with('success', 'Success '.$param.'d Data!');
       }else{
         Session::flash('failed','Failed '.$param.'d Data');
         return redirect('/newsletter/')->with('error', 'Failed '.$param .'d Data!');
       }
    }

    public function view($id)
    {
      $pageTitle = "Newsletter";
      $page = "view";
      $data =  DB::table('itdp_newsletter')->where('id', $id)->first();
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('newsletter.create',compact('page','data','pageTitle'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function edit($id)
    {
      $page = "edit";
      $pageTitle = "Newsletter";
      $url = "/newsletter/store/Update|".$id;
      $data =  DB::table('itdp_newsletter')->where('id', $id)->first();
      if(isset(Auth::user()->id)){
        if(Auth::user()->id_group == 1)
          return view('newsletter.create',compact('url','data','pageTitle','page'));
        else
          return redirect('/home');
      } else {
        return redirect('/');
      }
    }

    public function destroy($id)
    {
      $data =  DB::table('itdp_newsletter')->where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Deleted Data');
         return redirect('/newsletter/')->with('success', 'Success Deleted Data');
       }else{
         Session::flash('failed','Failed Deleted Data');
         return redirect('/newsletter/')->with('error', 'Failed Deleted Data');
       }
    }

    public function broadcast(Request $req)
    {
      $data =  DB::table('itdp_newsletter')->where('id', $req->newsletter)->first();
      $data = [
          'subject' => $data->about,
          'messages' => $data->messages,
          'file' => $data->file
      ];
      $user = DB::table('itdp_company_users')->where('newsletter', 1)->get();
      foreach ($user as $key => $value) {
        $data['email'] = $value->email;
        $data['email_unsub'] = Crypt::encryptString($value->id);
        Mail::send('newsletter.mail', $data, function ($mail) use ($data) {
            $mail->subject($data['subject']);
            $mail->to($data['email']);
        });
      }

      $simpan =   DB::table('itdp_newsletter')->where('id', $req->newsletter)->update(['status' => 1]);

      if($simpan){
        Session::flash('success','Success Broadcast Data');
        return redirect('/newsletter/')->with('success', 'Success Broadcast Data');
      }else{
        Session::flash('failed','Failed Broadcast Data');
        return redirect('/newsletter/')->with('error', 'Failed Broadcast Data');
      }
    }

    public function unsubscribe($lock_id)
    {
      $id = Crypt::decryptString($lock_id);
      $data = DB::table('itdp_company_users')->where('id', $id)->update(['newsletter' => 0]);
      if($data){
         $message = ['title' => 'You\'ve been unsubscribed.', 'body' => 'You will not get another newsletter. if you have any feedback or questions please contact us.'];
         return view('newsletter.unsubscribe', $message);
       }else{
         $message = ['title' => 'Unsubscribed Failed.', 'body' => 'Unsubscribe failed due to a data error. if you have any feedback or questions please contact us.'];
         return view('newsletter.unsubscribe', $message);
       }
    }
}