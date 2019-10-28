<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;

class TrainingControllerAdmin extends Controller
{

		public function __construct(){
      $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Training';
      return view('training.index', compact('pageTitle'));
    }

    public function create(){
      $pageTitle = 'Training';
      $page = 'create';
      return view('training.create', compact('page','pageTitle'));
    }

		public function store(Request $req){

			$store = DB::table('training_admin')->insert([
        'training_en'  => $req->training_en,
        'training_in'  => $req->training_in,
				'training_chn' => $req->training_chn,
        'start_date'   => $req->start_date,
        'end_date'     => $req->end_date,
        'duration'     => $req->duration,
        'topic_en'     => $req->topic_en,
        'topic_in'     => $req->topic_in,
        'topic_chn'    => $req->topic_chn,
        'location_en'  => $req->location_en,
        'location_in'  => $req->location_in,
        'location_chn' => $req->location_chn,
				'status' => 0
      ]);

			return redirect('/admin/training');
		}

    public function update(Request $req, $id){

			$store = DB::table('training_admin')->where('id', $id)->update([
        'training_en'  => $req->training_en,
        'training_in'  => $req->training_in,
				'training_chn' => $req->training_chn,
        'start_date'   => $req->start_date,
        'end_date'     => $req->end_date,
        'duration'     => $req->duration,
        'topic_en'     => $req->topic_en,
        'topic_in'     => $req->topic_in,
        'topic_chn'    => $req->topic_chn,
        'location_en'  => $req->location_en,
        'location_in'  => $req->location_in,
        'location_chn' => $req->location_chn,
      ]);

			return redirect('/admin/training');
		}

    public function getData(){

      $tick = DB::table('training_admin as ts')->get();

      return \Yajra\DataTables\DataTables::of($tick)
					->addColumn('status', function($data){
						if ($data->status == 0){
							return 'Not Published';
						}else if ($data->status == 1){
							return 'Published';
						}
					})
          ->addColumn('start_date', function($data){
					   $date = date("Y-m-d", strtotime($data->start_date));
             return $date;
					})
          ->addColumn('duration', function($data){
             return ''.$data->duration.' Days';
					})
          ->addColumn('action', function ($data) {
						if ($data->status == 0){
							return '
              <center>
              <div class="btn-group">
                <a onclick="return confirm(\'Are you sure to publish this training information ?\')" href="'.route('training.publish.admin', $data->id).'" class="btn btn-sm btn-primary">&nbsp;<i class="fa fa-file text-white"></i>&nbsp;Publish&nbsp;</a>&nbsp;&nbsp;
                <a href="'.route('training.edit.admin', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp;
              </div>
              </center>
              ';
						}else if ($data->status == 1){
							return '
              <center>
              <div class="btn-group">
								<a href="'.route('training.view.admin', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                <a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Data Ini ?\')" href="'.route('training.destroy.admin', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
              </div>
              </center>
              ';
						}
          })
          ->rawColumns(['action'])
          ->make(true);
    }

		public function view($id){
			$data = DB::table('training_admin')->where('id', $id)->first();

      $join = DB::table('training_join as tj')
        ->selectRaw('tj.*, ipe.company')
        ->leftJoin('itdp_profil_eks as ipe','tj.id_profil_eks','=','ipe.id')
        ->where('id_training_admin', $id)
        ->paginate(10);

      $pageTitle = 'Training';
			$page = 'view';

			return view('training.create',compact('page','pageTitle','data','join'));
    }

    public function edit($id){
			$data = DB::table('training_admin')->where('id', $id)->first();

			$pageTitle = 'Training';
			$page = 'edit';

			return view('training.create',compact('page','pageTitle','data'));
    }

		public function destroy($id){
      $data = DB::table('training_admin')->where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/admin/training');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/admin/training');
       }
    }

    public function publish($id){
      $data = DB::table('training_admin')->where('id', $id)->update([
        'status' => 1
      ]);
      if($data){
         Session::flash('success','Success Publish Data');
         return redirect('/admin/training');
       }else{
         Session::flash('failed','Failed Publish Data');
         return redirect('/admin/training');
       }
    }

    public function verifed($id, $id_tr, $id_profil){
      $id_penerima = DB::table('itdp_company_users')
      ->where('id_profil', $id_profil)
      ->first();

      $data = DB::table('training_join')->where('id', $id)->update([
        'status' => 1
      ]);

      $notif = DB::table('notif')
        ->where('untuk_id', Auth::user()->id)
        ->where('dari_id', $id_penerima->id)
        ->update([
        'keterangan' => 'Training Telah Di Verifikasi',
        'url_terkait' => 'training',
				'status_baca' => 0,
        'to_role' => 2
      ]);
      if($data){
         Session::flash('success','Success verifed Data');
         return redirect()->route('training.view.admin',['id'=>$id_tr]);
       }else{
         Session::flash('failed','Failed verifed Data');
         return redirect()->route('training.view.admin',['id'=>$id_tr]);
       }
    }

}
