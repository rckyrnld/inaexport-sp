<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class EventController extends Controller
{
	public function index(){
		$pageTitle = "Event";
		if (Auth::guard('eksmp')->user()) {
			$id_user = strval(Auth::guard('eksmp')->user()->id);
			// $e_detail = DB::select("SELECT DISTINCT b.id_terkait, a.* FROM event_detail as a LEFT JOIN notif as b on b.id_terkait=a.id::VARCHAR WHERE b.untuk_id='$id_user' and b.url_terkait='event/show/read' ORDER BY a.id desc ");
            $e_detail = DB::table('event_detail as a')->select('b.id_terkait', 'a.*')
            ->leftjoin('notif as b', function($join){
                $join->on(DB::raw('a.id::varchar'), '=', 'b.id_terkait');
            })->where('b.untuk_id', $id_user)->where(function($query){
                $query->where('b.url_terkait', 'event/show/read');
            })->orderby('a.id','desc')->get();
			// $e_detail = DB::table('event_detail')->orderby('id', 'desc')->paginate(6);
			return view('Event.index_eksportir', compact('pageTitle','e_detail', 'id_user'));
		}else{
			$e_detail = DB::table('event_detail')->orderby('id', 'desc')->paginate(6);
			return view('Event.index', compact('pageTitle','e_detail'));
		}
	}

	public function create(){
		$url_store = '/event/store';
		$pageTitle = 'Tambah Event';
		$page='add';
		$e_organizer = DB::table('event_organizer')->orderby('id', 'desc')->get();
		$e_palce = DB::table('event_place')->orderby('id', 'desc')->get();
		$e_comodity = DB::table('event_comodity')->orderby('id', 'desc')->get();
		// $prod_cat = DB::table('csc_product')->orderby('id', 'asc')->get();

		return view('Event.create', compact('pageTitle', 'url_store', 'page', 'e_organizer','e_palce','e_comodity'));
	}

	public function store(Request $req){
		//admin
		$datenow = date("Y-m-d H:i:s");
		$id_user = Auth::user()->id;
		$array = array();

		$nama_file1 = NULL;
        $nama_file2 = NULL;
        $nama_file3 = NULL;
        $nama_file4 = NULL;

        $id=DB::table('event_detail')->max('id');
    	if($id){ $id = $id+1; } else { $id = 1; }

        $destination= 'uploads\Event\Image\\'.$id;
        if($req->hasFile('image_1')){ 
            $file1 = $req->file('image_1');
            $nama_file1 = time().'_'.$req->eventname_en.'_'.$req->file('image_1')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        if($req->hasFile('image_2')){ 
            $file2 = $req->file('image_2');
            $nama_file2 = time().'_'.$req->eventname_en.'_'.$req->file('image_2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
        }

        if($req->hasFile('image_3')){ 
            $file3 = $req->file('image_3');
            $nama_file3 = time().'_'.$req->eventname_en.'_'.$req->file('image_3')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
        }

        if($req->hasFile('image_4')){ 
            $file4 = $req->file('image_4');
            $nama_file4 = time().'_'.$req->eventname_en.'_'.$req->file('image_4')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
        }

        $data = DB::table('event_detail')->insert([
        	'id' => $id,
        	'start_date'	=> $req->s_date,
			'end_date'	=> $req->e_date,
			'event_name_en'	=> $req->eventname_en,
			'event_name_in'	=> $req->eventname_in,
			'event_name_chn'	=> $req->eventname_chn,
			'event_type_en'	=> $req->eventype_en,
			'event_type_in'	=> $req->eventype_in,
			'event_type_chn'	=> $req->eventype_chn,
			'id_event_organizer'	=> $req->eventorgnzr_en,
			'event_organizer_text_en'	=> $req->eot_en,
			'even_organizer_text_in'	=> $req->eot_in,
			'even_organizer_text_chn'	=> $req->eot_chn,
			'id_event_place'	=> $req->eventplace_en,
			'event_place_text_en'	=> $req->ept_en,
			'event_place_text_in'	=> $req->ept_in,
			'event_place_text_chn'	=> $req->ept_chn,
			'image_1'	=> $nama_file1,
			'image_2'	=> $nama_file2,
			'image_3'	=> $nama_file3,
			'image_4'	=> $nama_file4,
			'website'	=> $req->website,
			'jenis_en'	=> $req->jenis_en,
			'jenis_in'	=> $req->jenis_in,
			'jenis_chn'	=> $req->jenis_chn,
			'event_comodity'	=> $req->eventcomodity,
			'event_scope_en'	=> $req->es_en,
			'event_scope_in'	=> $req->es_in,
			'event_scope_chn'	=> $req->es_chn,
			'id_prod_cat'	=> 0,
			// 'id_articles'	=> $req->,
			'id_prod_sub1_kat'	=> 0,
			'id_prod_sub2_kat'	=> 0,
			'status_en'	=> $req->status,
			// 'status_in'	=> $req->,
			// 'status_chn'	=> $req->,
        	'created_at' => $datenow
        ]);

        for ($i=0; $i < count($req->id_prod_cat) ; $i++) { 
        	$var=$req->id_prod_cat[$i];
        	$idn=DB::table('event_detail_kategori')->max('id');
        	if($idn){ $idn = $idn+1; } else { $idn = 1; }

	        DB::table('event_detail_kategori')->insert([
	        	'id' => $idn,
	        	'id_event_detail'	=> $id,
				'id_prod_cat'	=> $req->id_prod_cat[$i],
	        	'created_at' => $datenow
	        ]);

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


	        sort($array);
	        for ($user=0; $user < count($array) ; $user++) {
	        	$pengirim = DB::table('itdp_admin_users')->where('id',$id_user)->first();
	        	$account_penerima = DB::table('itdp_company_users')->where('id',$array[$user])->first();
	        	$profile_penerima = DB::table('itdp_profil_eks')->where('id',$account_penerima->id_profil)->first();

	        	$notif = DB::table('notif')->insert([
		            'dari_nama' => $pengirim->name,
		            'dari_id' => $pengirim->id,
		            'untuk_nama' => $profile_penerima->company,
		            'untuk_id' => $array[$user],
		            'keterangan' => 'New Event from '.$pengirim->name.' with Title  "'.$req->eventname_en.'"',
		            'url_terkait' => 'event/show/read',
		            'status_baca' => 0,
		            'waktu' => date('Y-m-d H:i:s'),
		            'id_terkait' => $id,
		            'to_role' => 2
		        ]);
	        }

        }

        return redirect('event');
	}

	public function edit($id){
		$url_update = '/event/update/'.$id;
		$pageTitle = 'Edit Event';
		$page='edit';
		$e_detail = DB::table('event_detail')->where('id', $id)->first();
		$ex = explode(' ', $e_detail->start_date);
		$sd = $ex[0];
		$ex2 = explode(' ', $e_detail->end_date);
		$se = $ex2[0];

		$e_organizer = DB::table('event_organizer')->orderby('id', 'asc')->get();
		$e_palce = DB::table('event_place')->orderby('id', 'asc')->get();
		$e_comodity = DB::table('event_comodity')->orderby('id', 'asc')->get();
		// $prod_cat = DB::table('csc_product')->orderby('id', 'asc')->get();

		return view('Event.create', compact('pageTitle', 'url_update', 'page', 'e_detail', 'e_organizer','e_palce','e_comodity','sd', 'se'));
	}

	public function update($id, Request $req)
    {
       //admin
    	$id_user = Auth::user()->id;
		$array = array();
        $datenow = date("Y-m-d H:i:s");

        $dtawal = DB::table('event_detail')->where('id', $id)->first();

        $destination= 'uploads\Event\Image\\'.$id;
        if($req->hasFile('image_1')){ 
            $file1 = $req->file('image_1');
            $nama_file1 = time().'_'.$req->eventname_en.'_'.$req->file('image_1')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }else{
            $nama_file1 = $dtawal->image_1;
        }

        if($req->hasFile('image_2')){ 
            $file2 = $req->file('image_2');
            $nama_file2 = time().'_'.$req->eventname_en.'_'.$req->file('image_2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
        }else{
            $nama_file2 = $dtawal->image_2;
        }

        if($req->hasFile('image_3')){ 
            $file3 = $req->file('image_3');
            $nama_file3 = time().'_'.$req->eventname_en.'_'.$req->file('image_3')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
        }else{
            $nama_file3 = $dtawal->image_3;
        }

        if($req->hasFile('image_4')){ 
            $file4 = $req->file('image_4');
            $nama_file4 = time().'_'.$req->eventname_en.'_'.$req->file('image_4')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
        }else{
            $nama_file4 = $dtawal->image_4;
        }


        DB::table('event_detail')->where('id', $id)->update([
            'start_date'	=> $req->s_date,
			'end_date'	=> $req->e_date,
			'event_name_en'	=> $req->eventname_en,
			'event_name_in'	=> $req->eventname_in,
			'event_name_chn'	=> $req->eventname_chn,
			'event_type_en'	=> $req->eventype_en,
			'event_type_in'	=> $req->eventype_in,
			'event_type_chn'	=> $req->eventype_chn,
			'id_event_organizer'	=> $req->eventorgnzr_en,
			'event_organizer_text_en'	=> $req->eot_en,
			'even_organizer_text_in'	=> $req->eot_in,
			'even_organizer_text_chn'	=> $req->eot_chn,
			'id_event_place'	=> $req->eventplace_en,
			'event_place_text_en'	=> $req->ept_en,
			'event_place_text_in'	=> $req->ept_in,
			'event_place_text_chn'	=> $req->ept_chn,
			'image_1'	=> $nama_file1,
			'image_2'	=> $nama_file2,
			'image_3'	=> $nama_file3,
			'image_4'	=> $nama_file4,
			'website'	=> $req->website,
			'jenis_en'	=> $req->jenis_en,
			'jenis_in'	=> $req->jenis_in,
			'jenis_chn'	=> $req->jenis_chn,
			'event_comodity'	=> $req->eventcomodity,
			'event_scope_en'	=> $req->es_en,
			'event_scope_in'	=> $req->es_in,
			'event_scope_chn'	=> $req->es_chn,
			'id_prod_cat'	=> 0,
			'status_en'	=> $req->status,
            'updated_at' => $datenow,
        ]);

        DB::table('event_detail_kategori')->where('id_event_detail', $id)->delete();
        for ($i=0; $i < count($req->id_prod_cat) ; $i++) {
        	$idn=DB::table('event_detail_kategori')->max('id');
        	if($idn){ $idn = $idn+1; } else { $idn = 1; }

	        DB::table('event_detail_kategori')->insert([
	        	'id' => $idn,
	        	'id_event_detail'	=> $id,
				'id_prod_cat'	=> $req->id_prod_cat[$i],
	        	'created_at' => $datenow
	        ]);
        }
        return redirect('event');
    }

	public function delete($id)
    {
        DB::table('event_detail')->where('id', $id)->delete();
        DB::table('event_detail_kategori')->where('id_event_detail', $id)->delete();
        return redirect('event');
    }

    public function show($id){
		$pageTitle = 'Show Event';
		$page='show';
		$e_detail = DB::table('event_detail')->where('id', $id)->first();
		$ex = explode(' ', $e_detail->start_date);
		$sd = $ex[0];
		$ex2 = explode(' ', $e_detail->end_date);
		$se = $ex2[0];

		$e_organizer = DB::table('event_organizer')->orderby('id', 'asc')->get();
		$e_palce = DB::table('event_place')->orderby('id', 'asc')->get();
		$e_comodity = DB::table('event_comodity')->orderby('id', 'asc')->get();
		$prod_cat = DB::table('csc_product')->orderby('id', 'asc')->get();

		return view('Event.create', compact('pageTitle', 'page', 'e_detail', 'e_organizer','e_palce','e_comodity', 'prod_cat','sd', 'se'));
    }

    public function show_company($id){
    	$pageTitle = 'Show Event';
    	$list = DB::table('notif')->where('url_terkait', 'event/show/read')->Where('id_terkait', $id)->where('status', '!=', null)->distinct()->get(['id_terkait','untuk_id', 'untuk_nama', 'waktu']);
    	$listnono = DB::table('event_company_add')->where('id_event_detail', $id)->get();
    	return view('Event.show_company', compact('pageTitle','list', 'listnono'));
    }

    public function show_detail($id){
    	$pageTitle = 'Show Event';
    	$detail = DB::table('event_detail')->where('id', $id)->first();
    	$id_user = strval(Auth::guard('eksmp')->user()->id);
    	return view('Event.show_detail', compact('pageTitle','detail', 'id_user'));
    }

    public function search(Request $req){
    	$pageTitle = "Event";
    	$q = $req->q;
    	if ($q!="") {
    		$e_detail = DB::table('event_detail')->where('event_name_en', 'LIKE', '%'.$q.'%')->orderby('id', 'asc')->paginate(6)->setPath( '' );
          	$pagination = $e_detail->appends(array('q' => $req->q));
	   		$e_detail->appends($req->only('q'));
          	if (count($e_detail) > 0) {
		   		return view('Event.index', compact('pageTitle','e_detail'));
          	}else{
          		return view('Event.index', compact('pageTitle','e_detail'))->withMessage('No Details found. Try to search again !');
          	}
    	}else{
    		return redirect('/event');
    	}
    }

   public function search_eksportir(Request $req){
   		$pageTitle = "Event";
    	$eq = $req->eq;
    	if ($eq!="") {
    		$e_detail = DB::table('event_detail')->where('event_name_en', 'LIKE', '%'.$eq.'%')->orderby('id', 'asc')->paginate(6)->setPath( '' );
          	$pagination = $e_detail->appends(array('eq' => $req->eq));
	   		$e_detail->appends($req->only('eq'));
          	if (count($e_detail) > 0) {
		   		return view('Event.index_eksportir', compact('pageTitle','e_detail'));
          	}else{
          		return view('Event.index_eksportir', compact('pageTitle','e_detail'))->withMessage('No Details found. Try to search again !');
          	}
    	}else{
    		return redirect('/event');
    	}
   }

    public function getEventOrg(Request $req){
  		$id = $req->id;
  		$data = DB::table('event_organizer')->where('id', $id)->first();
  		echo json_encode($data);
    }
    public function getEventPlace(Request $req){
    	$id=$req->id;
    	$data = DB::table('event_place')->where('id', $id)->first();
    	echo json_encode($data);
    }

    public function updatestatjoin(Request $req){
    	$id = $req->id;
    	$id_user = Auth::guard('eksmp')->user()->id;
    	DB::table('notif')->where('untuk_id', $id_user)->where('id_terkait', $id)->update([
    		'status' => 1
    	]);
    	return redirect('/event');
    }

    public function updatestatver(Request $req){
    	$id = $req->id;
    	$untuk_id = $req->untuk_id;
    	DB::table('notif')->where('untuk_id', $untuk_id)->where('id_terkait', $id)->update([
    		'status' => 2
    	]);
    	return redirect('/event/show_company/'.$id);
    }

    public function store_company(Request $req){
    	$datenow = date("Y-m-d H:i:s");
    	$id_user = Auth::guard('eksmp')->user()->id;
    	DB::table('event_company_add')->insert([
    		'id_itdp_profil_eks'	=> $id_user,
    		'id_event_detail'		=> $req->id_event,
    		'status'				=> 1,
    		'waktu'					=> $datenow
    	]);
    	return redirect('/front_end/event');
    }

    public function updatestatcompany(Request $req){
    	$id_user = $req->id_itdp_profil_eks;
    	$id = $req->id;

    	DB::table('event_company_add')->where('id_itdp_profil_eks', $id_user)->where('id_event_detail', $id)->update([
    		'status' => 2
    	]);
    	return redirect('/event/show_company/'.$id);
    }

}