<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use Lang;
use Mail;

class HistoryFrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
        changeStatusInquiry();
    }

    public function index()
    {
        if(Auth::guard('eksmp')->user()){
            return view('frontend.history');
        }else{
            return redirect('/front_end');
        }
    }

    public function data_inquiry()
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
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.prodname_en, csc_product_single.prodname_in, csc_product_single.prodname_chn, csc_product_single.id_itdp_company_user, csc_product_single.image_1')
            ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
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
            ->addColumn('prodname', function ($mjl) use($lct) {
                $img1 = "image/noimage.jpg";
                if($mjl->image_1 != NULL){
                    $imge1 = 'uploads/Eksportir_Product/Image/'.$mjl->id_product.'/'.$mjl->image_1;
                    if(file_exists($imge1)) {
                      $img1 = 'uploads/Eksportir_Product/Image/'.$mjl->id_product.'/'.$mjl->image_1;
                    }
                }
                $imgnya = '<img src="'.url('/').'/'.$img1.'" alt="" class="myImg" onclick="openImage(\''.$img1.'\')" />';
                $prodname = "-";
                $prodbhs = "prodname_".$lct;
                if($mjl->$prodbhs != NULL){
                    $prodname = $mjl->$prodbhs;
                }

                return $imgnya .'&nbsp;&nbsp;&nbsp;&nbsp;'. $prodname;
            })
            ->addColumn('exportir', function ($mjl) use($lct) {
                $exp = "-";
                if($mjl->id_itdp_company_user != NULL){
                    $exp = getCompanyName($mjl->id_itdp_company_user);
                }

                return $exp;
            })
            ->addColumn('notrack', function ($mjl) use($lct) {
                $notracking = "-";
                return $notracking;
            })
            ->addColumn('origin', function ($mjl) use($lct) {
                $org = "Inquiry";
                return $org;
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
            ->addColumn('subject', function ($mjl) use($lct) {
                $subject = "-";
                $subhs = "subyek_".$lct;
                if($mjl->$subhs != NULL){
                    $subject = $mjl->$subhs;
                }

                return $subject;
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
                    if($mjl->status == 0){
                        $stat = 1;
                    }else{
                        $stat = $mjl->status;
                    }
                    $statnya = Lang::get('inquiry.stat'.$stat);
                }

                return $statnya;
            })
            ->addColumn('action', function ($mjl) use($lct, $id_user) {
                if($mjl->status == 0){
                    return '
                        <center>
                        <a href="'.url('/front_end/ver_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-success" style="font-size: 12.5px;"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;&nbsp;'.Lang::get('button-name.verified').'</a>
                        </center>';
                }else if($mjl->status == 1){
                    return '
                        <center>
                        <button type="button" class="btn btn-sm btn-danger" style="font-size: 12.5px;">'.Lang::get('button-name.noact').'</button>
                        </center>';
                }else if($mjl->status == 2){
                    return '
                        <center>
                        <a href="'.url('/front_end/chat_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-warning" style="color: white; font-size: 12.5px;"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;&nbsp;'.Lang::get('button-name.chat').' <span class="badge badge-danger">'.$this->getCountChat($mjl->id, $id_user).'</span></a>
                        </center>';
                }else if($mjl->status == 3 || $mjl->status == 4 || $mjl->status == 5){
                    return '
                        <center>
                        <div class="btn-group">
                        <a href="'.url('/front_end/view_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-info" style="font-size: 12.5px;"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;'.Lang::get('button-name.view').'</a>
                        <a href="'.url('/front_end/chat_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-warning" style="color: white; font-size: 12.5px;"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;&nbsp;'.Lang::get('button-name.chat').'</a>
                        </div>
                        </center>';
                }else{
                    return '
                        <center>
                        <button type="button" class="btn btn-sm btn-danger" style="font-size: 12.5px;">'.Lang::get('button-name.noact').'</button>
                        </center>';
                }
            })
            ->rawColumns(['action', 'msg', 'prodname'])
            ->make(true);
    }

    function getCountChat($id, $receiver)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('type', 'importir')->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function data_ticketing()
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
        $id_user = Auth::guard('eksmp')->user()->id;
        $type = Auth::guard('eksmp')->user()->type;
        $tick = TicketingSupportModel::from('ticketing_support as ts')
            ->where('ts.id_pembuat', $id_user)
            ->get();

        return \Yajra\DataTables\DataTables::of($tick)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return 'No Response';
                } else if ($data->status == 2) {
                    return 'Response';
                } else if ($data->status == 3) {
                    return 'Closed';
                }
            })
            ->addColumn('action', function ($data) {
                if ($data->status == 1) {
                    return '
                            <center>
                            <div class="btn-group">
                                <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i> '.Lang::get('button-name.view').' </a>&nbsp;&nbsp;
                            </div>
                            </center>
                            ';
                } else if ($data->status == 2) {
                    return '
                          <center>
                          <div class="btn-group">
                                            <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i> '.Lang::get('button-name.view').' </a>
                            <a href="' . route('front.ticket.vchat', $data->id) . '" class="btn btn-sm btn-warning" style="color: white;"><i class="fa fa-comments-o" aria-hidden="true"></i> '.Lang::get('button-name.chat').'</a>
                          </div>
                          </center>
                          ';
                } else if ($data->status == 3) {
                    return '
                          <center>
                          <div class="btn-group">
                                            <a href="' . route('front.ticket.view', $data->id) . '" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i> '.Lang::get('button-name.view').' </a>
                            <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Chat Ini ?\')" href="' . route('front.ticket.delete', $data->id) . '" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i> '.Lang::get('button-name.delete').' </a>
                          </div>
                          </center>
                          ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
	
	public function data_br()
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
        $id_user = Auth::guard('eksmp')->user()->id;
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.* from csc_buying_request a, csc_buying_request_join b where b.id_br = a.id and a.id_pembuat='".$id_user."' order by a.id desc ");
      

        return DataTables::of($buy)
            ->addColumn('col1', function ($buy) {
				 return $buy->subyek;
            })
			->addColumn('col2', function ($buy) {
				$cr = explode(',',$buy->id_csc_prod);
				$hitung = count($cr);
				$semuacat = "";
				for($a = 0; $a < ($hitung - 1); $a++){
					$namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
					$semuacat = $semuacat."- ".$napro."<br>";
				}
				return $semuacat;
            })
			->addColumn('col3', function ($buy) {
				 return $buy->date;
            })
			->addColumn('col4', function ($buy) {
				 return 'Valid '.$buy->valid." days";
            })
			->addColumn('col5', function ($buy) {
				 if($buy->deal == null || $buy->deal == 0 || empty($buy->deal)){
					return "Negosiation";
				 }else{
					return "Deal";
				 }
            })
			
			
            ->addColumn('col7', function ($buy) {

								
							
				return '<center><a href="'.url('br_importir_lc/'.$buy->id).'" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-comments-o text-white"></i> List Chat</a></center>
				';
                /*if($pesan->status_a == 1 || $pesan->status_a == 2){ 
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-edit text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapusimportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('resetimportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
				';
				}else{
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-success"><i class="fa fa-check text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapusimportir/'.$pesan->ida).'" class="btn btn-sm btn-danger"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('resetimportir/'.$pesan->ida).'" class="btn btn-sm btn-warning"><i class="fa fa-key text-white"></i></a>
				';
				} */
            })
			->rawColumns(['col7','col4','col5','col2'])
            ->make(true);
    }

    public function create($id)
    {
        //
    }

    public function store($id, Request $request)
    {
        //
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
