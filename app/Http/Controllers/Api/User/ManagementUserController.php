<?php

namespace App\Http\Controllers\Api\User;

use App\Models\ChatingTicketingSupportModel;
use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mail;


class ManagementUserController extends Controller
{

    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function downloadResearch(Request $request)
    {

        $id_profil = $request->id_profil;
        $id_reseach = $request->id_research;
        $date = date('Y-m-d H:i:s');
        $checking = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->where('id_research_corner', $id_reseach)->first();
//        dd($checking);
        if ($checking) {
            $meta = [
                'code' => 204,
                'message' => 'The document has been downloaded',
                'status' => 'Failed '
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
                ->orderby('a.created_at', 'desc')
                ->distinct('a.id_research_corner', 'a.created_at')
                ->select('b.*', 'a.id_research_corner', 'a.created_at')
                ->where('a.id_research_corner', '=', $id_reseach)
//            ->limit(10)
                ->get();
            foreach ($research as $img) {
                $coba = $img->exum;
            }
            $path = ($coba) ? url('uploads/Research Corner/File/' . $coba) : url('image/noimage.jpg');
//            dd($path);
            $id = DB::table('csc_download_research_corner')->orderby('id', 'desc')->first();
            if ($id) {
                $id = $id->id + 1;
            } else {
                $id = 1;
            }
            DB::table('csc_download_research_corner')->insert([
                'id' => $id,
                'id_itdp_profil_eks' => $id_profil,
                'id_research_corner' => $id_reseach,
                'id_mst_country' => '64',
                'waktu' => $date
            ]);

//                $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->first();
//                if ($notif) {
//                    DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->update([
//                        'status_baca' => 1
//                    ]);
//                }

            $before = DB::table('csc_research_corner')->where('id', $id_reseach)->first();
            DB::table('csc_research_corner')->where('id', $id_reseach)->update([
                'download' => $before->download + 1
            ]);
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $path;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function joinTraining(Request $request)
    {
        $store = DB::table('training_join')->insert([
            'id_training_admin' => $request->id_training,
            'id_profil_eks' => $request->id_user,
            'date_join' => date('Y-m-d H:i:s'),
            'status' => 0
        ]);

        $notif = DB::table('notif')->insert([
            'dari_id' => $request->id_user,
            'untuk_id' => 1,
            'keterangan' => '<b>Request To Join Training',
            'waktu' => date('Y-m-d H:i:s'),
            'url_terkait' => 'admin/training/view',
            'status_baca' => 0,
            'id_terkait' => $request->id_training,
            'to_role' => 1
        ]);
        if (count($store) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function joinEvent(Request $request)
    {
        $datenow = date("Y-m-d H:i:s");
        $id_user = $request->id_user;
        $event = DB::table('event_company_add')->insert([
            'id_itdp_profil_eks' => $id_user,
            'id_event_detail' => $request->id_event,
            'status' => 1,
            'waktu' => $datenow
        ]);
        if (count($event) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function createTicketing(Request $request)
    {
        $store = TicketingSupportModel::create([
            'id_pembuat' => $request->id_user,
            'name' => $request->name,
            'type' => $request->type,
            'email' => $request->email,
            'subyek' => $request->subject,
            'main_messages' => $request->messages,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $id_ticketing = $store->id;

        //Tinggal Ganti Email1 dengan email kemendag
        $data = [
            'email' => $request->email,
            'email1' => 'yossandiimran02@gmail.com',
            'username' => $request->name,
            'main_messages' => $request->messages,
            'id' => $id_ticketing
        ];

        Mail::send('UM.user.sendticket', $data, function ($mail) use ($data) {
            $mail->to($data['email1'], $data['username']);
            $mail->subject('Requesting Ticketing Support');
        });
        if (count($store) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function data_ticketing(Request $request)
    {
        $id_user = $request->id_user;
        $tick = TicketingSupportModel::from('ticketing_support as ts')
            ->where('ts.id_pembuat', $id_user)
            ->get();

        if (count($tick) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $tick;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $tick;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function vchat(Request $request)
    {
        $id = $request->id_tiketing;
        $messages = ChatingTicketingSupportModel::from('chating_ticketing_support as cts')
            ->leftJoin('ticketing_support as ts', 'cts.id_ticketing_support', '=', 'ts.id')
            ->where('ts.id', $id)
            ->orderby('cts.messages_send', 'asc')
            ->get();

        $users = TicketingSupportModel::where('id', $id)->first();

        if (count($messages) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = '';
            $data = array();
            array_push($data, array(
                'id_pembuat' => $users->id_pembuat,
                'items' => $messages
            ));
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $messages;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function sendchat(Request $req)
    {
        $chat = ChatingTicketingSupportModel::insert([
            'id_ticketing_support' => $req->id_tiketing,
            'sender' => $req->id_pembuat,
            'reciver' => '0',
            'messages' => $req->messages,
            'messages_send' => date('Y-m-d H:i:s')
        ]);
        if ($chat) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function destroytiketing(Request $request)
    {
        $id = $request->id_tiketing;
        $data2 = ChatingTicketingSupportModel::where('id_ticketing_support', $id)->delete();
        $data = TicketingSupportModel::where('id', $id)->delete();
        if ($data) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getTransaksi(Request $request)
    {
        if ($request->id_role == 2) {
            $data = DB::table('csc_transaksi')
                ->where('id_eksportir', $request->id_user)
                ->orderBy('id_transaksi', 'desc')
                ->get();
        } else if ($request->id_role == 3) {
            $data = DB::table('csc_transaksi')
                ->where('id_pembuat', $request->id_user)
                ->orderBy('id_transaksi', 'desc')
                ->get();
        }
        if ($data) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
//            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }
    public function detailTransaksi(Request $request)
    {
        $data = DB::table('csc_transaksi')
            ->where('id_transaksi', $request->id_transaksi)
            ->get();

        if ($data) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
//            $data = '';
            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
        }
    }
}
