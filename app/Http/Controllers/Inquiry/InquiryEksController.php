<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use Lang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InquiryEksController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('auth:eksmp');
    }

    public function index()
    {
        $pageTitle = "Inquiry";
        if(Auth::guard('eksmp')->user()){
            //Read Notification
            $id_user = Auth::guard('eksmp')->user()->id;
            DB::table('notif')->where('url_terkait', 'inquiry')->where('untuk_id', $id_user)->where('to_role', 2)->update([
                'status_baca' => 1,
            ]);
            return view('inquiry.eksportir.index', compact('pageTitle'));
        }else{
            return redirect('/home');
        }
    }

    public function getData($jenis)
    {
        if(Auth::guard('eksmp')->user()){
            $id_user = Auth::guard('eksmp')->user()->id;

            if($jenis == 1){
                $user = [];
                $importir = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product')
                    ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                    ->where('csc_inquiry_br.status', 1)
                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->get();
                foreach ($importir as $key) {
                    array_push($user, $key);
                }
                $perwakilan = DB::table('csc_inquiry_br as a')
                    ->join('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                    ->selectRaw('a.id, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.status')
                    ->where('b.id_itdp_company_users', '=', $id_user)
                    ->where('b.status', 1)
                    ->orderBy('b.created_at', 'DESC')
                    ->get();
                foreach ($perwakilan as $key2) {
                    array_push($user, $key2);
                }
            }else{
                $user = [];
                $importir = DB::table('csc_inquiry_br')
                    ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product')
                    ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                    ->where('csc_inquiry_br.status', '!=', 1)
                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->get();
                foreach ($importir as $key) {
                    array_push($user, $key);
                }
                $perwakilan = DB::table('csc_inquiry_br as a')
                    ->join('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
                    ->selectRaw('a.id, a.id_pembuat, a.type,a.id_csc_prod_cat, a.id_csc_prod_cat_level1, a.id_csc_prod_cat_level2, a.jenis_perihal_en, a.messages_en, a.subyek_en, a.duration, a.date, b.status')
                    ->where('b.id_itdp_company_users', '=', $id_user)
                    ->where('b.status', '!=', 1)
                    ->orderBy('b.created_at', 'DESC')
                    ->get();
                foreach ($perwakilan as $key2) {
                    array_push($user, $key2);
                }
            }

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('category', function ($mjl) {
                    $category = "-";
                    if($mjl->id_csc_prod_cat != NULL){
                        if($mjl->id_csc_prod_cat_level1 != NULL){
                            if($mjl->id_csc_prod_cat_level2 != NULL){
                                $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level2)->first();
                                $category = $catprod->nama_kategori_en;
                            }else{
                                $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level1)->first();
                                $category = $catprod->nama_kategori_en;
                            }
                        }else{
                            $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat)->first();
                            $category = $catprod->nama_kategori_en;
                        }
                        
                    }
                    return $category;
                })
                ->addColumn('status', function ($mjl) {
                    $statnya = "-";
                    if($mjl->status != NULL){
                        $statnya = Lang::get('inquiry.stat'.$mjl->status);
                    }

                    return $statnya;
                })
                ->addColumn('duration', function ($mjl) {
                    $durationnya = "-";
                    if($mjl->duration != NULL){
                        $durationnya = "Valid for ".$mjl->duration;
                    }

                    return $durationnya;
                })
                ->addColumn('subject', function ($mjl) {
                    $subyek = "-";
                    if($mjl->subyek_en != NULL){
                        $subyek = $mjl->subyek_en;
                    }

                    return $subyek;
                })
                ->addColumn('date', function ($mjl) {
                    $datenya = "-";
                    if($mjl->date != NULL){
                        $datenya = date('d/m/Y', strtotime($mjl->date));
                    }

                    return $datenya;
                })
                ->addColumn('kos', function ($mjl) {
                    $kosnya = "-";
                    if($mjl->jenis_perihal_en != NULL){
                        $kosnya = $mjl->jenis_perihal_en;
                    }

                    return $kosnya;
                })
                ->addColumn('msg', function ($mjl) {
                    $msgnya = "-";
                    if($mjl->messages_en != NULL){
                        $num_char = 70;
                        $text = $mjl->messages_en;
                        if(strlen($text) > 70){
                            $cut_text = substr($text, 0, $num_char);
                            if ($text{$num_char - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                $cut_text = substr($text, 0, $new_pos);
                            }
                            $msgnya = $cut_text . '...';
                        }else{
                            $msgnya = $text;
                        }
                    }

                    return $msgnya;
                })
                ->addColumn('origin', function ($mjl) {
                    $orginnya = "-";
                    if($mjl->type != NULL){
                        $orginnya = $mjl->type;
                    }

                    return $orginnya;
                })
                ->addColumn('action', function ($mjl) use($id_user) {
                    if($mjl->status == 0 || $mjl->status == 2){
                        return '
                            <center>
                            <a href="'.url('/inquiry/chatting').'/'.$mjl->id.'" class="btn btn-sm btn-warning" style="color: white;"><i class="fa fa-comments-o" aria-hidden="true"></i> '.Lang::get('button-name.chat').' <span class="badge badge-danger">'.$this->getCountChat($mjl->id, $id_user).'</span></a>
                            </center>';
                    }else if($mjl->status == 1){
                        return '
                            <center>
                            <a href="'.url('/inquiry/joined').'/'.$mjl->id.'" class="btn btn-sm btn-success" style="width: 100%;">'.Lang::get('button-name.join').'</a>
                            </center>';
                    }else if($mjl->status == 3 || $mjl->status == 4 || $mjl->status == 5){
                        return '
                            <center>
                            <a href="'.url('/inquiry/view').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> '.Lang::get('button-name.view').'</a>
                            </center>';
                    }else{
                        return '
                            <center>
                            <button type="button" class="btn btn-sm btn-danger">'.Lang::get('button-name.noact').'</button>
                            </center>';
                    }
                })
                ->rawColumns(['action', 'msg'])
                ->make(true);
        }
    }

    function getCountChat($id, $receiver)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function joined($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();
            
            return view('inquiry.eksportir.joined', compact('pageTitle','inquiry', 'product'));
        }else{
            return redirect('/home');
        }
    }

    public function accept_chat($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $data = DB::table('csc_inquiry_br')->where('id', $id)->first();
            if($data->type == "importir"){
                $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->update([
                    'status' => 0,
                ]);
            }else if($data->type == "perwakilan"){
                $inquiry = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $id_user)->update([
                    'status' => 0,
                ]);
            }
            
            return redirect('/inquiry');
        }else{
            return redirect('/home');
        }
    }

    public function chatting($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->where('type', 'importir')
                ->orderBy('created_at', 'asc')
                ->get();

            $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNull('messages')->count();

            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $id_user)->update([
                'status' => 1,
            ]);
            
            return view('inquiry.eksportir.chatting', compact('pageTitle','inquiry', 'product', 'messages', 'id_user', 'cekfile'));
        }else{
            return redirect('/home');
        }
    }

    public function sendChat(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id = $request->idinquiry;
        $sender = $request->from;
        $receiver = $request->to;
        $msg = $request->messages;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id' => $idmax,
            'id_inquiry' => $id,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        if($save){
            return 1;
        }else{
            return 0;
        }
    }

    public function fileChat(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id = $request->id_inquiry;
        $sender = $request->sender;
        $receiver = $request->receiver;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $destination= 'uploads\ChatFileInquiry\\'.$idmax;
        if($request->hasFile('upload_file')){ 
            $file1 = $request->file('upload_file');
            $nama_file1 = time().'_'.$request->file('upload_file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id' => $idmax,
            'id_inquiry' => $id,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'file' => $nama_file1,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        return redirect('/inquiry/chatting/'.$id); 
        
    }

    public function dealing($id, $status)
    {
        if($status == 1){
            $stat = 3;
        }else{
            $stat = 4;
        }

        $update = DB::table('csc_inquiry_br')->where('id', $id)->update([
            'status' => $stat,
        ]);

        return redirect('/inquiry');
    }

    public function view($id)
    {
        if(Auth::guard('eksmp')->user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->where('type', 'importir')
                ->orderBy('created_at', 'asc')
                ->get();

            $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNull('messages')->count();

            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $id_user)->update([
                'status' => 1,
            ]);
            
            return view('inquiry.eksportir.chatting', compact('pageTitle','inquiry', 'product', 'messages', 'id_user', 'cekfile'));
        }else{
            return redirect('/home');
        }
    }

    
    function setValue($value)
    {
        $value = str_replace('.', '', $value);

        return (int)$value;
    }
}
