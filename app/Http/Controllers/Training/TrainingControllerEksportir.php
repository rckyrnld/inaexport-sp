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
			$data = DB::table('training_admin')->where('status', 1)->paginate(10);
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
			$id = DB::table('itdp_company_users as icu')
			->selectRaw('ipe.id')
			->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
			->where('icu.id', Auth::guard('eksmp')->user()->id)
			->first();

      $tick = DB::table('training_join as tj')
			->selectRaw('tj.*,ta.start_date,ta.duration,ta.topic_in,ta.location_in,ta.training_in')
			->leftJoin('training_admin as ta','ta.id','=','tj.id_training_admin')
			->where('tj.id_profil_eks',$id->id)
			->get();
      return \Yajra\DataTables\DataTables::of($tick)
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
                <button class="btn btn-danger"><span class="fa fa-close"></span> Not Verified</button>
              </div>
              </center>
              ';
						}else if ($data->status == 1){
							return '
              <center>
              <div class="btn-group">
								<button class="btn btn-success"><span class="fa fa-check"></span> Already verified</button>
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

		public function search(Request $request){
			$cari = $request->cari;

			$data = DB::table('training_admin')
			->where('training_in','like',"%".$cari."%")
			->paginate(10);

			$pageTitle = 'Training';

			$id_user = Auth::guard('eksmp')->user()->id;
			$id = DB::table('itdp_company_users as icu')
			->selectRaw('ipe.id')
			->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
			->where('icu.id', $id_user)
			->first();

			return view('training.eksportir.index', compact('pageTitle','data','id'));
		}

}
