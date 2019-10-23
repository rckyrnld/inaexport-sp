<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;

class TrainingControllerEksportir extends Controller
{

		public function __construct(){
      // $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Training';
			$data = DB::table('training_admin')->where('status', 1)->get();
			$id_user = Auth::guard('eksmp')->user()->id;
			$id = DB::table('itdp_company_users as icu')
			->selectRaw('ipe.id')
			->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
			->where('icu.id', $id_user)
			->first();
      return view('training.eksportir.index', compact('pageTitle','data','id'));
    }

    public function create(){
      $pageTitle = 'Training';
      $page = 'create';
      return view('training.create', compact('page','pageTitle'));
    }

		public function join(Request $req){
			$id_user = Auth::guard('eksmp')->user()->id;
			$data = DB::table('itdp_company_users as icu')
			->selectRaw('ipe.id')
			->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
			->where('icu.id', $id_user)
			->first();

			$store = DB::table('training_join')->insert([
        'id_training_admin' => $req->id_training_admin,
				'id_profil_eks' => $data->id,
				'date_join' => date('Y-m-d H:i:s'),
				'status' => 0
      ]);

			return redirect('/training');
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

		public function view(){
			$pageTitle = 'Training';
			return view('training.eksportir.view', compact('pageTitle'));
		}

}
