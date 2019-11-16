<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Lang;
use Mail;

class InquiryFrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
        changeStatusInquiry();
    }

    public function index()
    {
        //
    }

    function getCountChat($id, $receiver)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function create($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $url = "/front_end/inquiry_act/".$id;
            $data = DB::table('csc_product_single')->where('id', $id)->first();
            $coinquiry = DB::table('csc_inquiry_br')
                ->where('type', 'importir')
                ->where('to', $id)
                ->where('status', 3)
                ->count();
            return view('frontend.inquiry.create_new', compact('data', 'url', 'id_user', 'coinquiry'));
        }else{
            return redirect('/');
        }
    }

    public function store($id, Request $request)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $id_product = $request->id_product;
            $type = $request->type;
            $datenow = date("Y-m-d H:i:s");

            $dtproduct = DB::table('csc_product_single')->where('id', $id_product)->first();
            $idn = DB::table('csc_inquiry_br')->max('id');
            $idnew = $idn + 1;

            $destination= 'uploads\Inquiry\\'.$idnew;
            if($request->hasFile('filedo')){ 
                $file1 = $request->file('filedo');
                $nama_file1 = time().'_'.$request->subyek_en.'_'.$file1->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
            }

            //Jenis Perihal
            $jpen = "";
            $jpin = "";
            $jpchn = "";
            if($request->kos == "offer to sell"){
                $jpen = $request->kos;
                $jpin = "menawarkan untuk menjual";
                $jpchn = "出售要约";
            }else if($request->kos == "offer to buy"){
                $jpen = $request->kos;
                $jpin = "menawarkan untuk membeli";
                $jpchn = "报价购买";
            }else if($request->kos == "consultation"){
                $jpen = $request->kos;
                $jpin = "konsultasi";
                $jpchn = "咨询服务";
            }

            $save = DB::table('csc_inquiry_br')->insert([
                'id' => $idnew,
                'id_pembuat' => $id_user,
                'type' => $type,
                'id_csc_prod_cat' => $dtproduct->id_csc_product,
                'id_csc_prod_cat_level1' => $dtproduct->id_csc_product_level1,
                'id_csc_prod_cat_level2' => $dtproduct->id_csc_product_level2,
                'jenis_perihal_en' => $jpen,
                'jenis_perihal_in' => $jpin,
                'jenis_perihal_chn' => $jpchn,
                'messages_en' => $request->messages,
                'messages_in' => $request->messages,
                'messages_chn' => $request->messages,
                'subyek_en' => $request->subject,
                'subyek_in' => $request->subject,
                'subyek_chn' => $request->subject,
                'to' => $id_product,
                'file' => $nama_file1,
                'status' => 1,
                'date' => $datenow,
                'duration' => $request->duration,
                'created_at' => $datenow,
            ]);

            if($save){
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyNameImportir($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyName($dtproduct->id_itdp_company_user),
                    'untuk_id' => $dtproduct->id_itdp_company_user,
                    'keterangan' => 'New Inquiry By '.getCompanyNameImportir($id_user).' with Subyek  "'.$request->subject.'"',
                    'url_terkait' => 'inquiry',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'to_role' => 2,
                ]);

                //Tinggal Ganti Email1 dengan email kemendag
                $untuk = DB::table('itdp_company_users')->where('id', $dtproduct->id_itdp_company_user)->first();
                $data = [
                    'email' => $untuk->email,
                    'username' => $untuk->username,
                    'type' => "eksportir",
                    'company' => getCompanyName($dtproduct->id_itdp_company_user),
                    'dari' => "Importer"
                ];

                Mail::send('inquiry.mail.sendToEksportir', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Inquiry Information');
                });
            }

            return redirect('/front_end/history');
        }else{
            return redirect('/');
        }

    }

    public function verifikasi_inquiry($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $datenow = date('Y-m-d H:i:s');
            $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

            $durasi = 0;
            if($data){
                if($data->duration != NULL){
                    $jn = explode(' ', $data->duration);
                    if($jn[1] == "week" || $jn[1] == "weeks"){
                        $durasi = (int)$jn[0] * 7;
                    }else if($jn[1] == "month" || $jn[1] == "months"){
                        $durasi = (int)$jn[0] * 30;
                    }
                }
            }

            $date = strtotime("+".$durasi." days", strtotime($datenow));
            $duedate = date('Y-m-d H:i:s', $date);

            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->update([
                'status' => 2,
                'due_date' => $duedate,
            ]);

            return redirect('/front_end/history');
        }else{
            return redirect('/');
        }
    }

    public function chatting($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $data = DB::table('csc_product_single')->where('id', $inquiry->to)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->where('type', 'importir')
                ->orderBy('created_at', 'asc')
                ->get();
            
            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $id_user)->update([
                'status' => 1,
            ]);
            
            return view('frontend.inquiry.chatting', compact('inquiry', 'data', 'messages', 'id_user'));
            // return view('frontend.inquiry.chatting');
        }else{
            return redirect('/');
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
        $id = $request->id_inquiry2;
        $sender = $request->sender2;
        $receiver = $request->receiver2;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $destination= 'uploads\ChatFileInquiry\\'.$idmax;
        if($request->hasFile('upload_file2')){ 
            $file1 = $request->file('upload_file2');
            $nama_file1 = time().'_'.$request->file('upload_file2')->getClientOriginalName();
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

        return redirect('/front_end/chat_inquiry/'.$id); 
        
    }

    public function view($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();
            $data = DB::table('csc_product_single')->where('id', $inquiry->to)->first();

            return view('frontend.inquiry.view', compact('inquiry', 'data', 'id_user'));
        }else{
            return redirect('/');
        }
    }

    public function edit()
    {
        # code...
    }

    public function update()
    {
        # code...
    }
}
