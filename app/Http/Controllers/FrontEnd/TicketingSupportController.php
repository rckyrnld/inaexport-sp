<?php

namespace App\Http\Controllers\FrontEnd;

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

class TicketingSupportController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = 'Ticketing Support';
//        dd(Auth::guard('eksmp')->user());
        return view('ticketingsupport.index', compact('pageTitle'));
    }

    public function create()
    {
        if(Auth::guard('eksmp')->user()){
            return view('frontend.ticketing.create');
        }else{
            return redirect('/front_end');
        }
    }

    public function store(Request $req)
    {
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

        //Tinggal Ganti Email1 dengan email kemendag
        $data = [
            'email' => $req->email,
            'email1' => 'yossandiimran02@gmail.com',
            'username' => $req->name,
            'main_messages' => $req->messages,
            'id' => $id_ticketing
        ];

        Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
            $mail->to($data['email1'], $data['username']);
            $mail->subject('Requesting Ticketing Support');
        });

        return redirect('/front_end/history');
    }

    public function getData()
    {

        //
    }

    public function vchat($id)
    {
        $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
            ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
            ->where('ts.id', $id)
            ->orderby('cts.messages_send', 'asc')
            ->get();

        $users = TicketingSupportModel::where('id', $id)->first();

        $pageTitle = "Chat Ticketing Support";
        $jenis = 'chat';

        return view('ticketingsupport.vchat', compact('jenis', 'pageTitle', 'users', 'messages'));

    }

    public function sendchat(Request $req)
    {
        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id,
            'sender' => $req->sender,
            'reciver' => $req->reciver,
            'messages' => $req->messages,
            'messages_send' => date('Y-m-d H:i:s')
        ]);
        return redirect('ticketing/chatview/' . $req->id);
    }

    public function view($id)
    {
        // $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
        //     ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
        //     ->where('ts.id', $id)
        //     ->orderby('cts.messages_send', 'asc')
        //     ->get();
        $ticket = TicketingSupportModel::where('id', $id)->first();
        return view('frontend.ticketing.view', compact('ticket'));
    }

    public function destroy($id)
    {
        $data2 = ChatingTicketingSupportModel::where('id_ticketing_support', $id)->delete();
        $data = TicketingSupportModel::where('id', $id)->delete();
        if ($data) {
            Session::flash('success', 'Success Delete Data');
            return redirect('/ticketing');
        } else {
            Session::flash('failed', 'Failed Delete Data');
            return redirect('/ticketing');
        }
    }

}
