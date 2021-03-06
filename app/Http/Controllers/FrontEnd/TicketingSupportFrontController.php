<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;
use Mail;

class TicketingSupportFrontController extends Controller
{

    public function __construct()
    {
//         $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = 'Ticketing Support';
//        dd(Auth::guard('eksmp')->user());

        return view('ticketingsupport.index', compact('pageTitle'));
    }

    public function create()
    {
//        dd(Auth::guard('eksmp')->user());
        if(Auth::guard('eksmp')->user()) {
            if(Auth::guard('eksmp')->user()->id_role == 3){
//                dd('a');
                $company = db::table('itdp_profil_imp')->where('id', Auth::guard('eksmp')->user()->id_profil)->first();
                $name = $company->company;
                $email = $company->email;
            }else if(Auth::guard('eksmp')->user()->id_role == 2){
//                dd('b');
                $company = db::table('itdp_profil_eks')->where('id', Auth::guard('eksmp')->user()->id_profil)->first();
                $name = $company->company;
                $email = $company->email;
            }
        }else{
            $name = "";
            $email = "";
        }
        // if(Auth::guard('eksmp')->user()){
            return view('frontend.ticketing.create', compact('name','email'));
        // }else{
        //     return redirect('/front_end');
        // }
    }

    public function store(Request $req)
    {

		date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $id_user = Auth::guard('eksmp')->user()->id;
        $type = Auth::guard('eksmp')->user()->type;

        $store = TicketingSupportModel::create([
            'id_pembuat' => $id_user,
            'name' => $req->name,
            'type' => $type,
            'email' => $req->email,
            'subyek' => $req->subject,
            'main_messages' => $req->messages,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $id_ticketing = $store->id;
//        dd($id_ticketing);
        //Tinggal Ganti Email1 dengan email kemendag
		//kementerianperdagangan.max@gmail.com
//        dd(Auth::guard('eksmp')->user()->id_role = 3);

        if(Auth::guard('eksmp')->user()->id_role == 2){
            $data = [
                'email' => $req->email,
                'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                'username' => $req->name,
                'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                'ticketing' => $id_ticketing,
                'main_messages' => $req->messages,
                'id' => $id_ticketing,
                'bu' => getExBadan(auth::guard('eksmp')->user()->id),
            ];

            $data2 = [
                'email' => $req->email,
                'email1' => Auth::guard('eksmp')->user()->email,
                'username' => $req->name,
                'ticketing' => $id_ticketing,
                'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                'main_messages' => $req->messages,
                'id' => $id_ticketing,
                'bu' => getExBadan(auth::guard('eksmp')->user()->id),
            ];



            $ket = "Ticketing was created by ".getExBadan(auth::guard('eksmp')->user()->id).getCompanyName(auth::guard('eksmp')->user()->id);
//		$ket2 = "You was create ticketing";
            $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('1','".getcompanyname(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$id_ticketing."','".$date."','0')
            ");

//		$insert4 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//			('".Auth::guard('eksmp')->user()->id_role."','Super Admin','1','".Auth::guard('eksmp')->user()->username."','".Auth::guard('eksmp')->user()->id."','".$ket2."','front_end/ticketing_support/view','".$id_ticketing."','".Date('Y-m-d H:m:s')."','0')
//		");


            //notif email for env email
            Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Requesting Ticketing Support');
            });

            //notif email for user
            Mail::send('UM.user.sendticket2', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email1'], $data2['username']);
                $mail->subject('You Requesting Ticketing Support');
            });

            //notif email for all admin
            $admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
            foreach($admin_all as $aa){
                $data = [
                    'email' => $aa->email,
                    'email1' => $aa->email,
                    'username' => $aa->name,
                    'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                    'ticketing' => $id_ticketing,
                    'main_messages' => $req->messages,
                    'id' => $id_ticketing,
                    'bu' => getExBadan(auth::guard('eksmp')->user()->id),
                ];
                Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['username']);
                    $mail->subject('Requesting Ticketing Support');
                });
            }
        }
        else if(Auth::guard('eksmp')->user()->id_role == 3){
            $data = [
                'email' => $req->email,
                'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                'username' => $req->name,
                'company' =>getCompanyNameImportir(Auth::guard('eksmp')->user()->id),
                'ticketing' => $id_ticketing,
                'main_messages' => $req->messages,
                'id' => $id_ticketing,
                'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
            ];

            $data2 = [
                'email' => $req->email,
                'email1' => Auth::guard('eksmp')->user()->email,
                'username' => $req->name,
                'ticketing' => $id_ticketing,
                'company' =>getCompanyNameImportir(Auth::guard('eksmp')->user()->id),
                'main_messages' => $req->messages,
                'id' => $id_ticketing,
                'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
            ];

            $ket = "Ticketing was created by ".getExBadanImportir(Auth::guard('eksmp')->user()->id)." ".getCompanyNameImportir(Auth::guard('eksmp')->user()->id);
//		$ket2 = "You was create ticketing";
            $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
			('1','".getCompanyNameImportir(Auth::guard('eksmp')->user()->id)."','".Auth::guard('eksmp')->user()->id."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$id_ticketing."','".$date."','0')
            ");

//		$insert4 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
//			('".Auth::guard('eksmp')->user()->id_role."','Super Admin','1','".Auth::guard('eksmp')->user()->username."','".Auth::guard('eksmp')->user()->id."','".$ket2."','front_end/ticketing_support/view','".$id_ticketing."','".Date('Y-m-d H:m:s')."','0')
//		");


            //notif email for admin
            Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Requesting Ticketing Support');
            });

            //notif email for user
            Mail::send('UM.user.sendticket2', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email1'], $data2['username']);
                $mail->subject('You Requesting Ticketing Support');
            });

            $admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
            foreach($admin_all as $aa){
                $data = [
                    'email' => $aa->email,
                    'email1' => $aa->email,
                    'username' => $aa->name,
                    'company' =>getCompanyNameImportir(auth::guard('eksmp')->user()->id),
                    'ticketing' => $id_ticketing,
                    'main_messages' => $req->messages,
                    'id' => $id_ticketing,
                    'bu' => getExBadanImportir(auth::guard('eksmp')->user()->id),
                ];
                Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['username']);
                    $mail->subject('Requesting Ticketing Support');
                });
            }

        }


        //dd();
//        return redirect('/front_end/history');
		//log
		$insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('".Auth::guard('eksmp')->user()->email."','".date('H:i:s')."','".date('Y-m-d')."','','".Auth::guard('eksmp')->user()->id_role."'
			,'".Auth::guard('eksmp')->user()->id."','8','create ticketing')");
		
		//end log
        return redirect()->route('front.histori.index');
    }

    public function getData()
    {

        //
    }

    public function vchat($id)
    {
        if(Auth::guard('eksmp')->user()){
            $id_user = Auth::guard('eksmp')->user()->id;
            $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
                ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
                ->where('ts.id', $id)
                ->orderby('cts.messages_send', 'asc')
                ->get();

            $ticket = TicketingSupportModel::where('id', $id)->first();

            return view('frontend.ticketing.chatting', compact('ticket', 'messages', 'id_user'));
        }else{
            return redirect('login');
        }

    }

    public function sendchat(Request $req)
    {
		date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
		$cari1 = DB::select("select * from ticketing_support where id='".$req->id."'");
			foreach($cari1 as $v1){ $id_company = $v1->id_pembuat; }
			$cari2 = DB::select("select * from itdp_company_users where id='".$id_company."'");
			foreach($cari2 as $v2){ 
			$data1 = $v2->username; 
			$data2 = $v2->email; 
			$data3 = $v2->id_role; 
			$data4 = $v2->id; 
			}
		/* $data = [
            'email' => "",
            'email1' => $data2,
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id
			];
		*/	
			$data2 = [
            'email' => "",
            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id,
            'user' => 'Admin',
			];
		     /*
			 Mail::send('UM.user.sendticketchat2', $data, function ($mail) use ($data) {
            
			$mail->to($data['email1'], $data['username']);
            $mail->subject('You Reply Chat on Ticketing Support');
			});

			*/
		    //Notif Untuk Admin
			Mail::send('UM.user.sendticketchat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email1'], $data2['username']);
            $mail->subject('User Reply Your Chat On Ticketing Support');
			});
			if(Auth::guard('eksmp')->user()->id_role == 3){
			    $ket = getExBadanImportir($data4).getCompanyNameImportir($data4)." Reply Chat on Ticketing Request";
            }
			elseif (Auth::guard('eksmp')->user()->id_role == 2){
                $ket = getExBadan($data4).getCompanyName($data4)." Reply Chat on Ticketing Request";
            }

				$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
				('1','".$data1."','".$data4."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$req->id."','".$date."','0')
				");
		
        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id,
            'sender' => $req->sender,
            'reciver' => $req->reciver,
            'messages' => $req->messages,
            'messages_send' => date('Y-m-d H:i:s')
        ]);
        return redirect('/front_end/ticketing_support/chatview/' . $req->id);
    }

    public function sendFilechat(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $nama_file1 = NULL;
        $destination= 'uploads\ticketing\\';
        if($req->hasFile('upload_file2')){ 
            $file1 = $req->file('upload_file2');
            $nama_file1 = time().'_'.$req->file('upload_file2')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $cari1 = DB::select("select * from ticketing_support where id='".$req->id."'");
            foreach($cari1 as $v1){ $id_company = $v1->id_pembuat; }
            $cari2 = DB::select("select * from itdp_company_users where id='".$id_company."'");
            foreach($cari2 as $v2){ 
            $data1 = $v2->username; 
            $data2 = $v2->email; 
            $data3 = $v2->id_role; 
            $data4 = $v2->id; 
            }


        /* $data = [
            'email' => "",
            'email1' => $data2,
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id
            ];
        */  
            $data2 = [
            'email' => "",
            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id,
            'user' => 'User',
            ];
             /*
             Mail::send('UM.user.sendticketchat2', $data, function ($mail) use ($data) {
            
            $mail->to($data['email1'], $data['username']);
            $mail->subject('You Reply Chat on Ticketing Support');
            });
            */
            //Notif untuk admin
            Mail::send('UM.user.sendticketchat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email1'], $data2['username']);
            $mail->subject('User Reply Your Chat On Ticketing Support');
            });
            if(Auth::guard('eksmp')->user()->id_role == 3){
                $ket = getExBadanImportir($data4).getCompanyNameImportir($data4)." Reply Chat on Ticketing Request";
            }
            elseif (Auth::guard('eksmp')->user()->id_role == 2){
                $ket = getExBadan($data4).getCompanyName($data4)." Reply Chat on Ticketing Request";
            }
                $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                ('1','".$data1."','".$data4."','Super Admin','1','".$ket."','admin/ticketing/chatview','".$req->id."','".Date('Y-m-d H:m:s')."','0')
                ");
        
        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id,
            'sender' => $req->sender,
            'reciver' => $req->reciver,
            'messages' => $req->messages,
            'file' => $nama_file1,
            'messages_send' => date('Y-m-d H:i:s')
        ]);
        return redirect('/front_end/ticketing_support/chatview/' . $req->id);
    }

    public function view($id)
    {
        $ticket = TicketingSupportModel::where('id', $id)->first();
        return view('frontend.ticketing.view', compact('ticket'));
    }

    public function destroy($id)
    {
        $data2 = ChatingTicketingSupportModel::where('id_ticketing_support', $id)->delete();
        $data = TicketingSupportModel::where('id', $id)->delete();
        if ($data) {
            Session::flash('error', 'Success Delete Data');
            return redirect('/front_end/history');
        } else {
            Session::flash('error', 'Failed Delete Data');
            return redirect('/front_end/history');
        }
    }

}
