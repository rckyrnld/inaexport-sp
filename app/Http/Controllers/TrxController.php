<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class TrxController extends Controller
{
    /*
    public function __construct()
        {
            $this->middleware('auth:web');
            $this->middleware('auth:eksmp');
        }
    */


    public function index()
    {
        if(!empty(Auth::guard('eksmp')->user()->id)){
            if(Auth::guard('eksmp')->user()->id_role == 2){
                $pageTitle = "Selling Transaction";
                $data = DB::select("select * from csc_transaksi where  id_eksportir='".Auth::guard('eksmp')->user()->id."' order by id_transaksi desc ");
                return view('trx.index_eks', compact('pageTitle','data'));
            }else if(Auth::guard('eksmp')->user()->id_role == 3){
                $pageTitle = "Selling Transaction Admin";
                $data = DB::select("select * from csc_transaksi where  id_pembuat='".Auth::guard('eksmp')->user()->id."' order by id_transaksi desc");
                return view('trx.index_imp', compact('pageTitle','data'));
            }
        }else{
            if(Auth::user()->id_group == 4){
                $pageTitle = "Selling Transaction Representative";
                $data = DB::select("select * from csc_transaksi  order by id_transaksi desc ");
                return view('trx.index_adm', compact('pageTitle','data'));
            }else{
                $pageTitle = "Selling Transaction Admin";
                $data = DB::select("select * from csc_transaksi  order by id_transaksi desc ");
                return view('trx.index_adm', compact('pageTitle','data'));
            }
        }
    }

    public function caritab($id,$id2)
    {
        $pageTitle = "";
        if($id == 0 && $id2 == 0){
            $data = DB::select("select * from csc_transaksi order by id_transaksi desc");
        }else if ($id == 0 && $id2 != 0){
            $data = DB::select("select * from csc_transaksi where origin='".$id2."' order by id_transaksi desc");
        }else if ($id != 0 && $id2 == 0){
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' order by id_transaksi desc");
        }else if($id != 0 && $id2 != 0){
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' and origin='".$id2."' order by id_transaksi desc");
        }
        return view('trx.caritab', compact('id','id2','data','pageTitle'));
    }

    public function cetaktrx($id,$id2)
    {
        $pageTitle = "";
        if($id == 0 && $id2 == 0){
            $data = DB::select("select * from csc_transaksi order by id_transaksi desc");
        }else if ($id == 0 && $id2 != 0){
            $data = DB::select("select * from csc_transaksi where origin='".$id2."' order by id_transaksi desc");
        }else if ($id != 0 && $id2 == 0){
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' order by id_transaksi desc");
        }else if($id != 0 && $id2 != 0){
            $data = DB::select("select * from csc_transaksi where by_role='".$id."' and origin='".$id2."' order by id_transaksi desc");
        }
        return view('trx.cetaktrx2', compact('id','id2','data','pageTitle'));
    }

    public function input_transaksi($id)
    {
        $pageTitle = "Selling Transaction";
        return view('trx.trx2', compact('id','pageTitle'));
    }

    public function save_trx(Request $request)
    {
//        dd($request);
//        dd(Auth::guard('eksmp')->user()->id);

		$ch1 = str_replace(".","",$request->tp);
		$ch2 = str_replace(",",".",$ch1);
		if($request->origin == 2){
		    //buying request
			$update = DB::select("update csc_buying_request set eo='".$request->eo."', neo='".$request->neo."',tp='".$ch2."',ntp='".$request->ntp."' where id='".$request->id_br."' ");
			$update = DB::select("update csc_transaksi set id_product='".$request->id_product."' where id_transaksi='".$request->id_transaksi."' ");
		}
		if($request->tipekirim == 1){
//		    dd(Auth::guard('eksmp')->user()->id_profil);
            if(Auth::guard('eksmp')->user()->id_profil){
                $company = Db::table('itdp_profil_eks')->where('id',Auth::guard('eksmp')->user()->id_profil)->first();
                if($company){
                    if($request->by_role == 3){
                        $caripembuat = DB::select("select * from itdp_company_users where id='".$request->id_pembuat."'");
                        foreach($caripembuat as $cp){ $mailimp = $cp->email; }
                        $ket = "Transaction Created by ".$company->badanusaha." ".$company->company;
                        $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                ('3','".$company->company."','".Auth::guard('eksmp')->user()->id."','Importir','".$request->id_pembuat."','".$ket."','detailtrx','".$request->id_transaksi."','".Date('Y-m-d H:m:s')."','0')
                ");

                        $ket2 = "Transaction Created by ".$company->badanusaha." ".$company->company;
                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                ('1','".$company->company."','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket2."','br_trx2','".$request->id_transaksi."','".Date('Y-m-d H:m:s')."','0')
                ");

                        $data = [
                            'email' => "",
                            'email1' => $mailimp,
                            'username' => $company->company,
                            'main_messages' => "",
                            'id' => $request->id_transaksi,
                            'bu' => $company->badanusaha,
                        ];
                        Mail::send('UM.user.sendtrx', $data, function ($mail) use ($data) {
                            $mail->to($data['email1'], $data['username']);
                            $mail->subject('Transaction Created By '.$data['username']);
                        });

                        $data22 = [
                            'email' => "",
                            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                            'username' => $company->company,
                            'main_messages' => "",
                            'id' => $request->id_transaksi,
                            'bu' => $company->badanusaha,
                            'url' => "inquiry_admin/view",
                        ];
                        Mail::send('UM.user.sendtrx2', $data22, function ($mail) use ($data22) {
                            $mail->to($data22['email1'], $data22['username']);
                            $mail->subject('Transaction Created By '.$data22['username']);
                        });


                    }else{
//			    dd($request);
                        $caripenerima = DB::select("select * from itdp_admin_users where id = '".$request->id_pembuat."'");
                        $caripembuat = DB::select ("select * from itdp_profil_eks where id = '".Auth::guard('eksmp')->user()->id_profil."'");
                        $namapembuat = $caripembuat[0]->company;
                        $namapenerima = $caripenerima[0]->name;
                        $bupembuat = $caripembuat[0]->badanusaha;
                        if($bupembuat == "-"){
                            $bupembuat2 = "";
                        }
                        else{
                            $bupembuat2 = $bupembuat;
                        }
//			    dd($bupembuat);
//                $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//                ('4',$namapembuat,'".Auth::guard('eksmp')->user()->id_profil."',$namapenerima,$request->id_pembuat,'".$ket."','br_trx2','".$request->id_transaksi."','".Date('Y-m-d H:m:s')."','0')
//                ");
                        if($request->origin == 2){
//                    dd('a');
                            //transaksi buying request
                            $url = "br_trx2";
                            $idnya = $request->id_transaksi;
                        }else{
//                    dd('b');
                            //transaksi inqury
                            $url = "inquiry_perwakilan/view";
                            $idnya = $request->id_in;
                        }
//                dd(auth::guard('eksmp')->user()->id_profil);


                        $ket = "Transaction Created by ".$bupembuat2." ".$namapembuat;
                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                    ('4','$namapembuat','".Auth::guard('eksmp')->user()->id."','".$namapembuat."',$request->id_pembuat,'".$ket."','".$url."','".$idnya."','".Date('Y-m-d H:m:s')."','0')
                    ");
                        $data22 = [
                            'email' => "",
                            'email1' => $caripenerima[0]->email,
                            'username' => $namapembuat,
                            'main_messages' => "",
                            'id' => $idnya,
                            'sender' => $caripembuat[0]->company,
                            'receiver' => $namapenerima,
                            'url' => $url,
                            'bu' => $bupembuat,
                        ];
                        Mail::send('UM.user.sendtrx3', $data22, function ($mail) use ($data22) {
                            $mail->to($data22['email1'], $data22['username']);
//                    $mail->subject('Transaction Created By '.Auth::guard('eksmp')->user()->username);
                            $mail->subject('Transaction Created By '.$data22['sender']);
                        });


                        $ket2 = "Transaction Created by ".$bupembuat2." ".$namapembuat;
                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                    ('1','$namapembuat','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket2."','".$url."','".$idnya."','".Date('Y-m-d H:m:s')."','0')
                    ");

                        $data22 = [
                            'email' => "",
                            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                            'username' => $namapembuat,
                            'main_messages' => "",
                            'id' => $idnya,
                            'url' => $url,
                            'bu' => $bupembuat,
                        ];
                        Mail::send('UM.user.sendtrx2', $data22, function ($mail) use ($data22) {
                            $mail->to($data22['email1'], $data22['username']);
                            $mail->subject('Transaction Created By '.$data22['username']);
                        });
                    }
                }
            }

//            $ket3 = "Transaction Created By You";
//            $insertnotif3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//			('2','Eksportir','".Auth::guard('eksmp')->user()->id."','Eksportir','".Auth::guard('eksmp')->user()->id."','".$ket3."','input_transaksi','".$request->id_transaksi."','".Date('Y-m-d H:m:s')."','0')
//			");
//
//
//			$data33 = [
//            'email' => "",
//            'email1' => Auth::guard('eksmp')->user()->email,
//            'username' => Auth::guard('eksmp')->user()->username,
//            'main_messages' => "",
//            'id' => $request->id_transaksi
//			];
//			Mail::send('UM.user.sendtrx3', $data33, function ($mail) use ($data33) {
//			$mail->to($data33['email1'], $data33['username']);
//			$mail->subject('Transaction Created By '.Auth::guard('eksmp')->user()->username);
//			});
		}
		$update = DB::select("update csc_transaksi set total='".($request->eo * $ch2)."' , eo='".$request->eo."', neo='".$request->neo."',tp='".$ch2."',ntp='".$request->ntp."', status_transaksi='".$request->tipekirim."', type_tracking='".$request->type_tracking."',no_tracking='".$request->no_track."' where id_transaksi='".$request->id_transaksi."' ");
		return redirect('trx_list');
		
	}
	
	public function detailtrx($id)

    {
        $pageTitle = "";
        return view('trx.detailtrx', compact('pageTitle','id'));
    }

    public function allgr($id)
    {
        $pageTitle = "";
        if($id == 0){
            $pembuat = "All";
        }else if($id == 1){
            $pembuat = "Admin";
        }else if($id == 4){
            $pembuat = "Perwakilan";
        }else if($id == 3){
            $pembuat = "Importir";
        }
        if($id == 0){
            $data = DB::select("select * from csc_buying_request  order by id desc ");
        }else{
            $data = DB::select("select * from csc_buying_request where by_role='".$id."' order by id desc ");

        }
        return view('trx.cetaktrx', compact('pageTitle','id','pembuat','data'));
    }

    public function joineks($id,$id2)
    {
        $insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,status_join,date) values 
		('".$id."','".$id2."','1','".Date('Y-m-d')."')
		");
        return redirect('br_importir_all');
    }

    public function data_br3()
    {

        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row,a.*,a.id as ida,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where a.id_pembuat='".Auth::guard('eksmp')->user()->id."' and  b.status_join='4' and  a.id = b.id_br ");


        return DataTables::of($buy)
            ->addColumn('col1', function ($buy) {
                return $buy->subyek;
            })
            ->addColumn('col2', function ($buy) {
                $carieks = DB::select("select * from itdp_company_users where id='".$buy->id_eks."'");
                foreach($carieks as $eks){ $rty=  $eks->username; }
                return $rty;
            })
            ->addColumn('col3', function ($buy) {
                return $buy->date;
            })
            ->addColumn('col4', function ($buy) {
                if($buy->status_trx == 1){
                    return "<font color='green'>Already Sent</font>";
                }else{
                    return "<font color='orange'>On Process</font>";
                }
            })
            ->addColumn('col5', function ($buy) {
                return $buy->no_track;

            })
            ->addColumn('col6', function ($buy) {
                return '<center><a href="'.url('detailtrx/'.$buy->ida.'/'.$buy->idb).'" class="btn btn-sm btn-success">View</a></center>';
            })


            ->rawColumns(['col4','col5','col2','col6'])
            ->make(true);
    }


    public function data_br4()
    {
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row,* from csc_buying_request ");


        return DataTables::of($buy)
			->addColumn('row', function ($buy) {
				 return "<center>".$buy->row."</center>";
            })
            ->addColumn('col1', function ($buy) {
                return $buy->subyek;
            })
            ->addColumn('col2', function ($buy) {
                $cr = explode(',',$buy->id_csc_prod);
                $hitung = count($cr);
                $semuacat = "";
                for($a = 0; $a < ($hitung - 1); $a++){
                    $namaprod = DB::select("select * from csc_product where id='".$cr[$a]."' ");
					if(count($namaprod) != 0){
                    foreach($namaprod as $prod){ $napro = $prod->nama_kategori_en; }
                    $semuacat = $semuacat."- ".$napro."<br>";
					}
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
            ->addColumn('col6', function ($buy) {
                if($buy->by_role == 3){
                    return "Importir";
                }else if($buy->by_role == 4){
                    return "Perwakilan";
                }else if($buy->by_role == 1){
                    return "Admin";
                }else{
                    return "";
                }
            })

            ->addColumn('aks', function ($buy) {
                $adaga = DB::select("select * from csc_buying_request_join where id_br='".$buy->id."' and id_eks='".Auth::guard('eksmp')->user()->id."'");
                if(count($adaga) == 0){
                    return '<center><a href="'.url('joineks/'.$buy->id.'/'.Auth::guard('eksmp')->user()->id).'" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Join</a></center	>';
                }else{
                    return '<center><font color="green">On List</font></center>';
                }

            })


            ->rawColumns(['col4','col5','col2','col6','aks','row'])
            ->make(true);
    }




}
