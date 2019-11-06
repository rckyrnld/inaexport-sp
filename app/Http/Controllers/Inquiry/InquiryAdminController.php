<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use Lang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class InquiryAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = "Inquiry";
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                return view('inquiry.admin.index', compact('pageTitle'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function getDataAdmin()
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;

            $user = DB::table('csc_inquiry_br')
                ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
                ->where('type', 'admin')
                ->orderBy('csc_inquiry_br.date', 'DESC')
                ->get();

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
                        if($mjl->status == 0){
                            $stat = 1;
                        }else{
                            $stat = $mjl->status;
                        }
                        $statnya = Lang::get('inquiry.stat'.$stat);
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
                    if($mjl->status == 0){
                        return '
                            <center>
                            <a href="'.url('/inquiry_admin/view').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                            <a href="'.url('/inquiry_admin/delete').'/'.$mjl->id.'" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </center>';
                    }else if($mjl->status == 1){
                        return '
                            <center>
                            <button type="button" class="btn btn-warning" style="color: white;" onclick="broadcastInquiry(\''.$mjl->subyek_en.'|'.$mjl->id.'\')"><i class="fa fa-bullhorn" aria-hidden="true"></i> Broadcast</button>
                            <a href="'.url('/inquiry_admin/edit').'/'.$mjl->id.'" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                            </center>';
                    }else if($mjl->status == 2 || $mjl->status == 5){
                        return '
                            <center>
                            <a href="'.url('/inquiry_admin/view').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                            </center>';
                    }else if($mjl->status == 3 || $mjl->status == 4){
                        return '
                            <center>
                            <a href="'.url('/inquiry_admin/view').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                            <a href="'.url('/inquiry_admin/delete').'/'.$mjl->id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure?\')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
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

    public function getPerwakilan()
    {
        if(Auth::user()){
            $user = DB::table('itdp_admin_users')
                ->where('id_group', 4)
                ->orderBy('name', 'ASC')
                ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('name', function ($mjl) {
                    $name = "-";
                    if($mjl->id != NULL){
                        $name = getPerwakilanName($mjl->id);
                    }
                    return $name;
                })
                ->addColumn('action', function ($mjl) {
                    return '
                        <center>
                        <a href="'.url('/inquiry_admin/detail_perwakilan').'/'.$mjl->id.'" class="btn btn-sm btn-success"><i class="fa fa-list" aria-hidden="true"></i> Detail</a>
                        </center>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function detail_perwakilan($id)
    {
        $pageTitle = "Inquiry";
        if(Auth::user()->id_group == 1){
            return view('inquiry.admin.perwakilan', compact('pageTitle', 'id'));
        }else{
            return redirect('/home');
        }
    }

    public function getDataPerwakilan($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;

            $user = DB::table('csc_inquiry_br')
                ->where('id_pembuat', $id)
                ->where('type', 'perwakilan')
                ->orderBy('date', 'DESC')
                ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('status', function ($mjl) {
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
                ->addColumn('action', function ($mjl) {
                    return '
                        <center>
                        <a href="'.url('/inquiry_admin/perwakilan_view').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                        </center>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function perwakilan_view($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $pageTitle = "Inquiry";
                $mode = "view";
                $url = "/inquiry_admin/update/".$id;
                $data = DB::table('csc_inquiry_br')->where('id', $id)->first();
                $id_pembuat = $data->id_pembuat;
                $id_country = $data->id_mst_country;
                
                return view('inquiry.admin.view_perwakilan', compact('pageTitle', 'mode', 'url', 'id_country', 'data', 'id_pembuat'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function getDataCompanyWakil($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;

            $user = DB::table('csc_inquiry_broadcast')
                ->where('id_inquiry', '=', $id)
                ->where('status', '!=', 1)
                ->orderBy('id_itdp_company_users', 'ASC')
                ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('company', function ($mjl) {
                    $company = "-";
                    if($mjl->id_itdp_company_users != NULL){
                        $company = getCompanyName($mjl->id_itdp_company_users);
                    }
                    return $company;
                })
                ->addColumn('status', function ($mjl) {
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
                ->addColumn('date', function ($mjl) {
                    $datenya = "-";
                    if($mjl->created_at != NULL){
                        $datenya = date('d/m/Y', strtotime($mjl->created_at));
                    }

                    return $datenya;
                })
                ->addColumn('action', function ($mjl) use($id_user) {
                    return '
                        <center>
                        <a href="'.url('/inquiry_admin/view_inquiry').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                        </center>';
                })
                ->rawColumns(['action', 'msg'])
                ->make(true);
        }
    }

    public function view_inquiry($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $mode = "perwakilan";
            $id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();
            $prodname = $inquiry->prodname;
            $urlnya = "/inquiry_admin/perwakilan_view/".$data->id_inquiry;

            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            $comsg = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->count(); 
            
            return view('inquiry.admin.view_inquiry', compact('pageTitle','inquiry', 'messages', 'id_user','data', 'urlnya', 'comsg', 'mode', 'prodname'));
        }else{
            return redirect('/home');
        }
    }

    public function getDataImportir()
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;

            $user = DB::table('csc_inquiry_br')
                ->where('type', 'importir')
                ->orderBy('csc_inquiry_br.date', 'DESC')
                ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('company', function ($mjl) {
                    $company = "-";
                    if($mjl->id_pembuat != NULL){
                        $company = getCompanyNameImportir($mjl->id_pembuat);
                    }
                    return $company;
                })
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
                        if($mjl->status == 0){
                            $stat = 1;
                        }else{
                            $stat = $mjl->status;
                        }
                        $statnya = Lang::get('inquiry.stat'.$stat);
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
                    return '
                        <center>
                        <a href="'.url('/inquiry_admin/view_importir').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                        </center>';
                })
                ->rawColumns(['action', 'msg'])
                ->make(true);
        }
    }

    public function view_importir($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $mode = "importir";
            $id_user = Auth::user()->id;
            $data = NULL;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();

            $product = DB::table('csc_product_single')->where('id', $inquiry->to)->first();
            $prodname = $product->prodname_en;
            $urlnya = "/inquiry_admin";
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            $comsg = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->count(); 
            
            return view('inquiry.admin.view_inquiry', compact('pageTitle','inquiry', 'messages', 'id_user','data', 'urlnya', 'comsg', 'mode', 'prodname'));
        }else{
            return redirect('/home');
        }
    }

    public function create()
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $pageTitle = "Inquiry";
                $mode = "add";
                $url = "/inquiry_admin/store";
                $data = NULL;
                
                return view('inquiry.admin.form', compact('pageTitle', 'mode', 'url', 'data'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function store(Request $request)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $type = "admin";
                $datenow = date("Y-m-d H:i:s");

                $idn = DB::table('csc_inquiry_br')->max('id');
                $idnew = $idn + 1;

                $destination= 'uploads\Inquiry\\'.$idnew;
                if($request->hasFile('file')){ 
                    $file1 = $request->file('file');
                    $nama_file1 = time().'_'.$request->subject.'_'.$file1->getClientOriginalName();
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
                    'prodname' => $request->prodname,
                    'jenis_perihal_en' => $jpen,
                    'jenis_perihal_in' => $jpin,
                    'jenis_perihal_chn' => $jpchn,
                    'messages_en' => $request->messages,
                    'messages_in' => $request->messages,
                    'messages_chn' => $request->messages,
                    'subyek_en' => $request->subject,
                    'subyek_in' => $request->subject,
                    'subyek_chn' => $request->subject,
                    'file' => $nama_file1,
                    'status' => 1,
                    'date' => $request->dateinquiry,
                    'duration' => $request->duration,
                    'created_at' => $datenow,
                ]);

                return redirect('/inquiry_admin');
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function edit($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $pageTitle = "Inquiry";
                $mode = "edit";
                $url = "/inquiry_admin/update/".$id;
                $data = DB::table('csc_inquiry_br')->where('id', $id)->first();
                $id_country = $data->id_mst_country;
                
                return view('inquiry.admin.form', compact('pageTitle', 'mode', 'url', 'id_country', 'data'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function update($id, Request $request)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $type = "admin";
                $datenow = date("Y-m-d H:i:s");

                $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

                $destination= 'uploads\Inquiry\\'.$data->id;
                if($request->hasFile('file')){ 
                    $file1 = $request->file('file');
                    $nama_file1 = time().'_'.$request->subject.'_'.$file1->getClientOriginalName();
                    Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
                }else{
                    $nama_file1 = $data->file;
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

                $save = DB::table('csc_inquiry_br')->where('id', $id)->update([
                    'id_pembuat' => $id_user,
                    'type' => $type,
                    'id_mst_country' => $request->id_country,
                    'prodname' => $request->prodname,
                    'jenis_perihal_en' => $jpen,
                    'jenis_perihal_in' => $jpin,
                    'jenis_perihal_chn' => $jpchn,
                    'messages_en' => $request->messages,
                    'messages_in' => $request->messages,
                    'messages_chn' => $request->messages,
                    'subyek_en' => $request->subject,
                    'subyek_in' => $request->subject,
                    'subyek_chn' => $request->subject,
                    'file' => $nama_file1,
                    'status' => 1,
                    'date' => $request->dateinquiry,
                    'duration' => $request->duration,
                    'updated_at' => $datenow,
                ]);

                return redirect('/inquiry_admin');
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function broadcasting(Request $request)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $id_inquiry = $request->idnya;
                $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
                $datenow = date("Y-m-d H:i:s");

                //update status
                $upd = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
                    'status' => 0,
                ]);

                $array = [];
                for($i = 0; $i<count($request->categori); $i++){
                    $var = $request->categori[$i];

                    $perusahaan = DB::table('csc_product_single')->where('id_itdp_company_user', '!=', null)
                          ->where(function ($query) use ($var) {
                                  $query->where('id_csc_product', $var)
                                        ->orWhere('id_csc_product_level1', $var)
                                        ->orWhere('id_csc_product_level2', $var);
                              })
                          ->select('id_itdp_company_user')->distinct('id_itdp_company_user')->get();
                    foreach ($perusahaan as $key) {
                      if (!in_array($key->id_itdp_company_user, $array)){
                        array_push($array, $key->id_itdp_company_user);
                      }
                    }
                }
                
                sort($array);
                $users = [];
                for ($k=0; $k <count($array) ; $k++) { 
                    $idn = DB::table('csc_inquiry_broadcast')->max('id');
                    $idnew = $idn + 1;
                    
                    $save = DB::table('csc_inquiry_broadcast')->insert([
                        'id' => $idnew,
                        'id_inquiry' => $id_inquiry,
                        'id_itdp_company_users' => $array[$k],
                        'status' => 1,
                        'created_at' => $datenow,
                    ]);

                    $admin = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                    $notif = DB::table('notif')->insert([
                        'dari_nama' => $admin->name,
                        'dari_id' => $id_user,
                        'untuk_nama' => getCompanyName($array[$k]),
                        'untuk_id' => $array[$k],
                        'keterangan' => 'New Inquiry By '.$admin->name.' with Subyek  "'.$inquiry->subyek_en.'"',
                        'url_terkait' => 'inquiry',
                        'status_baca' => 0,
                        'waktu' => $datenow,
                        'to_role' => 2,
                    ]);

                    $untuk = DB::table('itdp_company_users')->where('id', $array[$k])->first();
                    array_push($users, $untuk->email);
                }

                //Tinggal Ganti Email1 dengan email kemendag
                $data = [
                    'type' => "eksportir",
                    'company' => "Eksporter",
                    'dari' => "Admin"
                ];

                Mail::send('inquiry.mail.sendToEksportir', $data, function ($mail) use ($data, $users) {
                    $mail->subject('Inquiry Information');
                    $mail->to($users);
                });

                return redirect('/inquiry_admin');
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function view($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $pageTitle = "Inquiry";
                $mode = "view";
                $url = "/inquiry_admin/update/".$id;
                $data = DB::table('csc_inquiry_br')->where('id', $id)->first();
                $id_country = $data->id_mst_country;
                
                return view('inquiry.admin.view', compact('pageTitle', 'mode', 'url', 'id_country', 'data'));
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function delete($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $inquiry = DB::table('csc_inquiry_br')->where('id', $id)->first();

            //delete chatting
            $del1 = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $id)
                ->where('type', 'admin')
                ->delete();

            //delete broadcasting
            $del2 = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->delete();

            //delete broadcasting
            $del3 = DB::table('csc_inquiry_br')->where('id', $id)->delete();
            
            return redirect('/inquiry_admin/');
        }else{
            return redirect('/home');
        }
    }

    public function getDataCompany($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;

            $user = DB::table('csc_inquiry_broadcast')
                ->where('id_inquiry', '=', $id)
                ->where('status', '!=', 1)
                ->orderBy('id_itdp_company_users', 'ASC')
                ->get();

            return \Yajra\DataTables\DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('company', function ($mjl) {
                    $company = "-";
                    if($mjl->id_itdp_company_users != NULL){
                        $company = getCompanyName($mjl->id_itdp_company_users);
                    }
                    return $company;
                })
                ->addColumn('status', function ($mjl) {
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
                ->addColumn('date', function ($mjl) {
                    $datenya = "-";
                    if($mjl->created_at != NULL){
                        $datenya = date('d/m/Y', strtotime($mjl->created_at));
                    }

                    return $datenya;
                })
                ->addColumn('action', function ($mjl) use($id_user) {
                    if($mjl->status == 0){
                        return '
                            <center>
                            <a href="'.url('/inquiry_admin/verifikasi').'/'.$mjl->id.'" class="btn btn-sm btn-success">'.Lang::get('button-name.verified').'</a>
                            </center>';
                    }else if($mjl->status == 1){
                        return '
                            <center>
                            <button type="button" class="btn btn-warning" style="color: white;" onclick="broadcastInquiry(\''.$mjl->subyek_en.'|'.$mjl->id.'\')"><i class="fa fa-bullhorn" aria-hidden="true"></i> Broadcast</button>
                            <a href="'.url('/inquiry_admin/edit').'/'.$mjl->id.'" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                            </center>';
                    }else if($mjl->status == 2){
                        return '
                            <center>
                            <a href="'.url('/inquiry_admin/chatting').'/'.$mjl->id.'" class="btn btn-sm btn-warning" style="color: white;"><i class="fa fa-comments-o" aria-hidden="true"></i> '.Lang::get('button-name.chat').' <span class="badge badge-danger">'.$this->getCountChat($mjl->id_inquiry, $id_user, $mjl->id).'</span></a>
                            </center>';
                    }else if($mjl->status == 3 || $mjl->status == 4){
                        return '
                            <center>
                            <a href="'.url('/inquiry_admin/view_detail').'/'.$mjl->id.'" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> View</a>
                            <a href="'.url('/inquiry_admin/delete_detail').'/'.$mjl->id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure?\')"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
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

    function getCountChat($id, $receiver, $id_broadcast)
    {
        $count = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id)->where('id_broadcast_inquiry', $id_broadcast)->where('type', 'admin')->where('receive', $receiver)->where('status', 0)->count();
        return $count;
    }

    public function verifikasi($id)
    {
        if(Auth::user()){
            $id_user = Auth::user()->id;
            if(Auth::user()->id_group == 1){
                $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();

                $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->update([
                    'status' => 2,
                ]);

                $inquirybroadcast = DB::table('csc_inquiry_broadcast')->where('id', $id)->update([
                    'status' => 2,
                ]);

                return redirect('/inquiry_admin/view/'.$data->id_inquiry);
            }else{
                return redirect('/home');    
            }
        }else{
            return redirect('/home');
        }
    }

    public function chatting($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'admin')
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            // $cekfile = DB::table('csc_chatting_inquiry')
            //     ->where('id_inquiry', $data->id_inquiry)
            //     ->where('type', 'perwakilan')
            //     ->where('sender', $data->id_itdp_company_users)
            //     ->where('receive', $inquiry->id_pembuat)
            //     ->whereNull('messages')
            //     ->count();

            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'admin')
                ->where('sender', $data->id_itdp_company_users)
                ->where('receive', $inquiry->id_pembuat)
                ->where('id_broadcast_inquiry', $id)
                ->update([
                    'status' => 1,
                ]);
            
            return view('inquiry.admin.chatting', compact('pageTitle','inquiry', 'messages', 'id_user','data'));
        }else{
            return redirect('/home');
        }
    }

    public function sendChat(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id = $request->idinquiry;
        $id_broadcast = $request->idbroadcast;
        $sender = $request->from;
        $receiver = $request->to;
        $msg = $request->messages;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id' => $idmax,
            'id_inquiry' => $id,
            'id_broadcast_inquiry' => $id_broadcast,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'admin',
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
        $id_broadcast = $request->id_broadcast;
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
            'id_broadcast_inquiry' => $id_broadcast,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'admin',
            'file' => $nama_file1,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        return redirect('/inquiry_admin/chatting/'.$id_broadcast); 
        
    }

    public function view_detail($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();
            $messages = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'admin')
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->get();

            $comsg = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'admin')
                ->where('id_broadcast_inquiry', $id)
                ->orderBy('created_at', 'asc')
                ->count();

            //Read Chat
            $chat = DB::table('csc_chatting_inquiry')
                ->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'admin')
                ->where('sender', $data->id_itdp_company_users)
                ->where('receive', $inquiry->id_pembuat)
                ->where('id_broadcast_inquiry', $id)
                ->update([
                    'status' => 1,
                ]);
            
            return view('inquiry.admin.viewdetail', compact('pageTitle','inquiry', 'messages', 'id_user','data', 'comsg'));
        }else{
            return redirect('/home');
        }
    }

    public function delete_detail($id)
    {
        if(Auth::user()){
            $pageTitle = "Inquiry";
            $id_user = Auth::user()->id;
            $data = DB::table('csc_inquiry_broadcast')->where('id', $id)->first();
            $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();

            //delete chatting
            $del1 = DB::table('csc_chatting_inquiry')->where('id_inquiry', $data->id_inquiry)
                ->where('type', 'admin')
                ->where('id_broadcast_inquiry', $id)
                ->delete();

            $del2 = DB::table('csc_inquiry_broadcast')->where('id', $id)->delete();
            
            return redirect('/inquiry_admin/view/'.$inquiry->id);
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
