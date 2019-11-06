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
    }

    public function index()
    {
        $pageTitle = "TEST";
        if(Auth::guard('eksmp')->user()->id_role == 3){
            return view('frontend.inquiry.index', compact('pageTitle'));
        }else{
            return redirect('/front_end');
        }
    }

    public function datanya()
    {
        $loc = app()->getLocale();
        $lct = "";
        if($loc == "ch"){
            $lct = "chn";
        }elseif($loc == "in"){
            $lct = "in";
        }else{
            $lct = "en";
        }
        // dd($lct);
        $id_user = Auth::guard('eksmp')->user()->id;
        $user = DB::table('csc_inquiry_br')
        ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
        ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product')
        ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
        ->orderBy('csc_inquiry_br.date', 'DESC')
        ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('category', function ($mjl) use($lct) {
                $category = "-";
                $catbhs = "nama_kategori_".$lct;
                if($mjl->id_csc_prod_cat != NULL){
                    if($mjl->id_csc_prod_cat_level1 != NULL){
                        if($mjl->id_csc_prod_cat_level2 != NULL){
                            $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level2)->first();
                            $category = $catprod->$catbhs;
                        }else{
                            $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat_level1)->first();
                            $category = $catprod->$catbhs;
                        }
                    }else{
                        $catprod = DB::table('csc_product')->where('id', $mjl->id_csc_prod_cat)->first();
                        $category = $catprod->$catbhs;
                    }
                    
                }
                return $category;
            })
            ->addColumn('subject', function ($mjl) use($lct) {
                $subyek = "-";
                $subbhs = "subyek_".$lct;
                if($mjl->$subbhs != NULL){
                    $subyek = $mjl->$subbhs;
                }

                return $subyek;
            })
            ->addColumn('date', function ($mjl) use($lct) {
                $datenya = "-";
                if($mjl->date != NULL){
                    $datenya = date('d/m/Y', strtotime($mjl->date));
                }

                return $datenya;
            })
            ->addColumn('kos', function ($mjl) use($lct) {
                $kosnya = "-";
                $kosbhs = "jenis_perihal_".$lct;
                if($mjl->$kosbhs != NULL){
                    $kosnya = $mjl->$kosbhs;
                }

                return $kosnya;
            })
            ->addColumn('msg', function ($mjl) use($lct) {
                $msgnya = "-";
                $msgbhs = "messages_".$lct;
                if($mjl->$msgbhs != NULL){
                    $num_char = 70;
                    $text = $mjl->$msgbhs;
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
            ->addColumn('status', function ($mjl) use($lct) {
                $statnya = "-";
                if($mjl->status != NULL){
                    $statnya = Lang::get('inquiry.stat'.$mjl->status);
                }

                return $statnya;
            })
            ->addColumn('action', function ($mjl) use($lct, $id_user) {
                if($mjl->status == 0){
                    return '
                        <center>
                        <a href="'.url('/front_end/ver_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-success">'.Lang::get('button-name.verified').'</a>
                        </center>';
                }else if($mjl->status == 1){
                    return '
                        <center>
                        <button type="button" class="btn btn-sm btn-danger">'.Lang::get('button-name.noact').'</button>
                        </center>';
                }else if($mjl->status == 2){
                    return '
                        <center>
                        <a href="'.url('/front_end/chat_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-warning" style="color: white;"><i class="fa fa-comments-o" aria-hidden="true"></i> '.Lang::get('button-name.chat').' <span class="badge badge-danger">'.$this->getCountChat($mjl->id, $id_user).'</span></a>
                        </center>';
                }else if($mjl->status == 3 || $mjl->status == 4 || $mjl->status == 5){
                    return '
                        <center>
                        <a href="'.url('/front_end/view_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> '.Lang::get('button-name.view').'</a>
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
            return view('frontend.inquiry.create', compact('data', 'url', 'id_user'));
        }else{
            return redirect('/front_end');
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

            return redirect('/front_end/inquiry_list');
        }else{
            return redirect('/front_end');
        }

    }

    public function verifikasi_inquiry($id)
    {
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $id_user = Auth::guard('eksmp')->user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->update([
                'status' => 2,
            ]);

            return redirect('/front_end/inquiry_list');
        }else{
            return redirect('/front_end');
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
        }else{
            return redirect('/front_end');
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
        }else{
            return redirect('/front_end');
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
