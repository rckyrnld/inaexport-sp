<?php

namespace App\Http\Controllers\TicketingSupport;

use App\Http\Controllers\Controller;
use App\Models\MasterCity;
use App\Models\MasterCountry;
use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CityExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Auth;
use Mail;

class TicketingSupportControllerAdmin extends Controller
{

		public function __construct(){
      // $this->middleware('auth');
    }

	  public function index(){
      $pageTitle = 'Ticketing Support';
      return view('ticketingsupport.indexAdmin', compact('pageTitle'));
    }

    public function getData(){

      $tick = TicketingSupportModel::from('ticketing_support as ts')->orderby('id', 'DESC')
				->get();

      return \Yajra\DataTables\DataTables::of($tick)
					->addColumn('status', function($data){
						if ($data->status == 1){
							return 'No Respone';
						}else if ($data->status == 2){
							return 'Respone';
						}else if ($data->status == 3){
							return 'Closed';
						}
					})
          ->addColumn('action', function ($data) {
						if ($data->status == 1 || $data->status == 2){
							return '
              <center>
              <div class="btn-group">
                <a href="'.route('ticket_support.vchat.admin', $data->id).'" class="btn btn-sm btn-warning">&nbsp;<i class="fa fa-envelope text-white"></i>&nbsp;Chat&nbsp;</a>&nbsp;&nbsp;
								<a href="'.route('ticket_support.view.admin', $data->id).'" class="btn btn-sm btn-primary">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
                <!-- <a href="'.route('master.city.edit', $data->id).'" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; !>
              </div>
              </center>
              ';
						}else if ($data->status == 3){
							return '
              <center>
              <div class="btn-group">
								<a href="'.route('ticket_support.view.admin', $data->id).'" class="btn btn-sm btn-info">&nbsp;<i class="fa fa-search text-white"></i>&nbsp;View&nbsp;</a>&nbsp;&nbsp;
								<a onclick="return confirm(\'Apa Anda Yakin untuk Menghapus Chat Ini ?\')" href="'.route('ticket_support.delete.admin', $data->id).'" class="btn btn-sm btn-danger">&nbsp;<i class="fa fa-trash text-white"></i>&nbsp;Delete&nbsp;</a>
								<!-- <a href="" class="btn btn-sm btn-success">&nbsp;<i class="fa fa-edit text-white"></i>&nbsp;Edit&nbsp;</a>&nbsp;&nbsp; !>
              </div>
              </center>
              ';
						}
          })
          ->rawColumns(['action'])
          ->make(true);
    }

		public function vchat($id){
			$messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
				->leftJoin('ticketing_support as ts','cts.id_ticketing_support','=','ts.id')
				->where('ts.id', $id)
				->orderby('cts.messages_send','asc')
				->get();

			$users = TicketingSupportModel::where('id', $id)->first();

			$pageTitle = "Chat Ticketing Support";
			$jenis = 'chat';
			return view('ticketingsupport.vchatAdmin',compact('jenis','pageTitle', 'users', 'messages'));
    }

		public function sendchat(Request $req){
			// echo $req->id;die();
			$cari1 = DB::select("select * from ticketing_support where id='".$req->id."'");
			foreach($cari1 as $v1){ $id_company = $v1->id_pembuat; }
			$cari2 = DB::select("select * from itdp_company_users where id='".$id_company."'");
			foreach($cari2 as $v2){ 
			$data1 = $v2->username; 
			$data2 = $v2->email; 
			$data3 = $v2->id_role; 
			$data4 = $v2->id; 
			}
			$data = [
            'email' => "",
            'email1' => $data2,
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id
			];
			
			/*
			$data2 = [
            'email' => "",
            'email1' => "kementerianperdagangan.max@gmail.com",
            'username' => "",
            'main_messages' => $req->messages,
            'id' => $req->id
			];
			*/
			
			Mail::send('UM.user.sendticketchat2', $data, function ($mail) use ($data) {
            $mail->to($data['email1'], $data['username']);
            $mail->subject('Chat Ticketing Support');
			});
			
			/*
			Mail::send('UM.user.sendticketchat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email1'], $data2['username']);
            $mail->subject('Chat Ticketing Support');
			});
			*/
			
			
			$ket = "Super Admin Respond Your Ticketing Request !";
				$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
				('".$data3."','Super Admin','1','".$data1."','".$data4."','".$ket."','front_end/ticketing_support/chatview','".$req->id."','".Date('Y-m-d H:m:s')."','0')
				");
			
			$chat = ChatingTicketingSupportModel::insert([
				'id_ticketing_support' => $req->id,
				'sender' => $req->sender,
				'reciver' => $req->reciver,
				'messages' => $req->messages,
				'messages_send' => date('Y-m-d H:i:s')
			]);
			$update = TicketingSupportModel::where('id', $req->id)->update([
				'status' => 2
			]);
			return redirect('admin/ticketing/chatview/'.$req->id);
		}

    public function view($id){
			$messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
				->leftJoin('ticketing_support as ts','cts.id_ticketing_support','=','ts.id')
				->where('ts.id', $id)
				->orderby('cts.messages_send','asc')
				->get();

			$users = TicketingSupportModel::where('id', $id)->first();

			$pageTitle = "Chat Ticketing Support";
			$jenis = 'view';
			return view('ticketingsupport.vchatAdmin',compact('jenis','pageTitle', 'users', 'messages'));
    }

    public function destroy($id){
			$data2 = ChatingTicketingSupportModel::where('id_ticketing_support', $id)->delete();
      $data = TicketingSupportModel::where('id', $id)->delete();
      if($data){
         Session::flash('success','Success Delete Data');
         return redirect('/admin/ticketing');
       }else{
         Session::flash('failed','Failed Delete Data');
         return redirect('/admin/ticketing');
       }
    }

		public function change(Request $req){
			$cari1 = DB::select("select * from ticketing_support where id='".$req->id."'");
			foreach($cari1 as $v1){ $id_company = $v1->id_pembuat; }
			$cari2 = DB::select("select * from itdp_company_users where id='".$id_company."'");
			foreach($cari2 as $v2){ 
			$data1 = $v2->username; 
			$data2 = $v2->email; 
			$data3 = $v2->id_role; 
			$data4 = $v2->id; 
			}
			$data = [
            'email' => "",
            'email1' => $data2,
            'username' => "",
            'main_messages' => "",
            'id' => $req->id
			];
			
			/*
			$data2 = [
            'email' => "",
            'email1' => "kementerianperdagangan.max@gmail.com",
            'username' => "",
            'main_messages' => "",
            'id' => $req->id
			];
			*/
			
			Mail::send('UM.user.sendticketclosed2', $data, function ($mail) use ($data) {
            $mail->to($data['email1'], $data['username']);
            $mail->subject('Ticketing Support Closed');
			});
			
			/*
			Mail::send('UM.user.sendticketclosed', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email1'], $data2['username']);
            $mail->subject('Ticketing Support Closed');
			});
			*/
			
			$ket = "Super Admin Closed Your Ticketing Request !";
				$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
				('".$data3."','Super Admin','1','".$data1."','".$data4."','".$ket."','front_end/ticketing_support/chatview','".$req->id."','".Date('Y-m-d H:m:s')."','0')
				");
				
			$update = TicketingSupportModel::where('id', $req->id)->update([
				'status' => 3
			]);
			return redirect('admin/ticketing');
		}
}
