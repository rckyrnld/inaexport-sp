<?php

namespace App\Http\Controllers\Api\User;

use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Mail;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class InquiryController extends Controller
{

    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function getListinquiry(Request $request)
    {
//        dd($request);
        $id_user = $request->id_user;
        $user = DB::table('csc_inquiry_br')
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.id_itdp_profil_eks,csc_product_single.id_itdp_company_user, csc_product_single.prodname_en')
            ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_pembuat"] = $user[$i]->id_itdp_profil_eks;
//            $jsonResult[$i]["id_itdp_company_user"] = $user[$i]->id_itdp_company_user;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            $jsonResult[$i]["to"] = $user[$i]->to;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["duration"] = $user[$i]->duration;
            $jsonResult[$i]["prodname"] = $user[$i]->prodname_en;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;
            $jsonResult[$i]["id_product"] = $user[$i]->id_product;
            $id_profil = $user[$i]->id_itdp_profil_eks;
            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
            $jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat)->first()->nama_kategori_en;
            $jsonResult[$i]["csc_product_level1_desc"] = ($user[$i]->id_csc_prod_cat_level1) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level1)->first()->nama_kategori_en : null;
            $jsonResult[$i]["csc_product_level2_desc"] = ($user[$i]->id_csc_prod_cat_level2) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level2)->first()->nama_kategori_en : null;
        }
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function searchListinquiry(Request $request)
    {
        $id_user = $request->id_user;
        $queryaaa = $request->parameternya;

        $user = DB::table('csc_inquiry_br')
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product')
            ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
            ->where(function ($query) use ($queryaaa) {
                $query->where('csc_inquiry_br.subyek_in', 'like', '%' . $queryaaa . '%')
                    ->orwhere('csc_inquiry_br.subyek_chn', 'like', '%' . $queryaaa . '%')
                    ->orwhere('csc_inquiry_br.subyek_en', 'like', '%' . $queryaaa . '%')
                    ->orwhere('csc_inquiry_br.messages_en', 'like', '%' . $queryaaa . '%')
                    ->orwhere('csc_inquiry_br.messages_in', 'like', '%' . $queryaaa . '%')
                    ->orwhere('csc_inquiry_br.messages_chn', 'like', '%' . $queryaaa . '%');
            })
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();

        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $user;
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

    public function store(Request $request)
    {
//        dd("ilyas");
        if ($request->id_role == 3) {
            $id_user = $request->id_user;
            $id_product = $request->id_product;
            $type = 'importir';
            $datenow = date("Y-m-d H:i:s");

            $dtproduct = DB::table('csc_product_single')->where('id', $id_product)->first();
            if (empty($request->file('filedo'))) {
                $nama_file1 = null;
            } else {
                $idn = DB::table('csc_inquiry_br')->max('id');
                $idnew = $idn + 1;
                $destination = 'uploads\Inquiry\\' . $idnew;
//                if ($request->hasFile('filedo')) {
                $file1 = $request->file('filedo');
                $nama_file1 = time() . '_' . $request->subyek_en . '_' . $file1->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
//                }
            }

            //Jenis Perihal
            $jpen = "";
            $jpin = "";
            $jpchn = "";
            if ($request->kos == "offer to sell") {
                $jpen = $request->kos;
                $jpin = "menawarkan untuk menjual";
                $jpchn = "出售要约";
            } else if ($request->kos == "offer to buy") {
                $jpen = $request->kos;
                $jpin = "menawarkan untuk membeli";
                $jpchn = "报价购买";
            } else if ($request->kos == "consultation") {
                $jpen = $request->kos;
                $jpin = "konsultasi";
                $jpchn = "咨询服务";
            }

            $save = DB::table('csc_inquiry_br')->insert([
//                'id' => $idnew,
                'id_pembuat' => $id_user,
                'type' => $type,
                'id_csc_prod_cat' => $dtproduct->id_csc_product,
                'id_csc_prod_cat_level1' => $dtproduct->id_csc_product_level1,
                'id_csc_prod_cat_level2' => $dtproduct->id_csc_product_level2,
                'jenis_perihal_en' => $jpen,
                'jenis_perihal_in' => $jpin,
                'jenis_perihal_chn' => $jpchn,
                'messages_en' => $request->messages,
                'messages_in' => $request->messages,
                'messages_chn' => $request->messages,
                'subyek_en' => $request->subject,
                'subyek_in' => $request->subject,
                'subyek_chn' => $request->subject,
                'to' => $id_product,
                'file' => $nama_file1,
                'status' => 1,
                'date' => $datenow,
                'duration' => $request->duration,
                'created_at' => $datenow,
            ]);

            if (count($save > 0)) {
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyNameImportir($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyName($dtproduct->id_itdp_company_user),
                    'untuk_id' => $dtproduct->id_itdp_company_user,
                    'keterangan' => 'New Inquiry By ' . getCompanyNameImportir($id_user) . ' with Subyek  "' . $request->subyek_en . '"',
                    'url_terkait' => 'inquiry',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'to_role' => 2,
                ]);

                //Tinggal Ganti Email1 dengan email kemendag
                $untuk = DB::table('itdp_company_users')->where('id', $dtproduct->id_itdp_company_user)->first();
                $data = [
                    'email' => $untuk->email,
                    'username' => $untuk->username,
                    'type' => "eksportir",
                    'company' => getCompanyName($dtproduct->id_itdp_company_user),
                    'dari' => "Importer"
                ];

                Mail::send('inquiry.mail.sendToEksportir', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Inquiry Information');
                });
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
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }

    }

    public function getDataeks(Request $request)
    {
//        dd($request);
        $id_user = $request->id_user;
        $user = DB::table('csc_inquiry_br')
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.id_itdp_profil_eks, csc_product_single.prodname_en')
            ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
//            ->where('csc_inquiry_br.status', 1)
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_pembuat"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            $jsonResult[$i]["to"] = $user[$i]->to;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["duration"] = $user[$i]->duration;
            $jsonResult[$i]["prodname"] = $user[$i]->prodname_en;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;
            $jsonResult[$i]["id_product"] = $user[$i]->id_product;

            $id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
//            dd($id_profil);
            $id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role;
//            dd($id_role);
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;

            //            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
            $jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat)->first()->nama_kategori_en;
            $jsonResult[$i]["csc_product_level1_desc"] = ($user[$i]->id_csc_prod_cat_level1) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level1)->first()->nama_kategori_en : null;
            $jsonResult[$i]["csc_product_level2_desc"] = ($user[$i]->id_csc_prod_cat_level2) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level2)->first()->nama_kategori_en : null;
        }
//        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
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

    public function joined(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $id_user = $request->id_user;
        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();

        $path = ($inquiry->file) ? url('uploads/Inquiry/' . $id_inquiry . '/' . $inquiry->file) : url('image/noimage.jpg');
        $product->file = $path;

        if (count($product) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $product;
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

    public function accept_chat(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $data = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $users = DB::table('itdp_company_users')->where('id', $data->id_pembuat)->first();
        $email = $users->email;
        $username = $users->username;

        //Tinggal Ganti Email1 dengan email kemendag
        $data = [
            'email' => $email,
            'username' => $username,
            'type' => "importir",
            'company' => getCompanyNameImportir($data->id_pembuat),
            'dari' => "Eksportir"
        ];

        Mail::send('inquiry.mail.sendToPembuat', $data, function ($mail) use ($data) {
            $mail->to($data['email'], $data['username']);
            $mail->subject('Inquiry Information');
        });

        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
            'status' => 0,
        ]);

        if (count($inquiry) > 0) {
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

    public function verifikasi_inquiry(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $datenow = date('Y-m-d H:i:s');
        $data = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();

        $durasi = 0;
        if ($data) {
            if ($data->duration != NULL) {
                $jn = explode(' ', $data->duration);
                if ($jn[1] == "week" || $jn[1] == "weeks") {
                    $durasi = (int)$jn[0] * 7;
                } else if ($jn[1] == "month" || $jn[1] == "months") {
                    $durasi = (int)$jn[0] * 30;
                }
            }
        }

        $date = strtotime("+" . $durasi . " days", strtotime($datenow));
        $duedate = date('Y-m-d H:i:s', $date);

        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
            'status' => 2,
            'due_date' => $duedate,
        ]);

        if (count($inquiry) > 0) {
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

    public function masukchattingImp(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $id_user = $request->id_user;

//        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
//        $data = DB::table('csc_product_single')->where('id', $inquiry->to)->first();
//        $idpenerima = $data->id_itdp_company_user;
        $user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', $id_inquiry)
            ->where('type', 'importir')
            ->orderBy('created_at', 'desc')
            ->get();
        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }

            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["sender"] = $user[$i]->sender;
            $id_user = $user[$i]->sender;
            $id_profil = DB::table('itdp_company_users')->where('id', $id_user)->first()->id_profil;
            $id_role = DB::table('itdp_company_users')->where('id', $id_user)->first()->id_role;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            $jsonResult[$i]["id_profil"] = $id_profil;
            $jsonResult[$i]["receive"] = $user[$i]->receive;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["file"] = $path = ($user[$i]->file) ? url('/uploads/ChatFileInquiry/' . $user[$i]->id . '/' . $user[$i]->file) : "";
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["ext"] = $extension;

        }
//        dd($data->id_itdp_company_user);
        //Read Chat
        $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id_inquiry)->where('type', 'importir')->where('receive', $id_user)->update([
            'status' => 1,
        ]);

        if (count($user) > 0) {
//            $meta = [
//                'code' => 200,
//                'message' => 'Success',
//                'status' => 'OK'
//            ];
//
//            $data = array();
//            array_push($data, array(
//                'id_penerima' => $idpenerima,
//                'items' => $messages
//            ));
//            $res['meta'] = $meta;
//            $res['data'] = $data;
            return response($jsonResult);
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

    public function sendChatimp(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id_inquiry = $request->id_inquiry;
        $sender = $request->id_user;
        $receiver = $request->id_penerima;
        $msg = $request->messages;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $save = DB::table('csc_chatting_inquiry')->insertGetId([
//            'id' => $idmax,
            'id_inquiry' => $id_inquiry,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);
        $user = DB::table('csc_chatting_inquiry')
            ->where('id', '=', $save)
            ->get();
        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["sender"] = $user[$i]->sender;
            $id_profil = $user[$i]->sender;
            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
            $jsonResult[$i]["receive"] = $user[$i]->receive;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["file"] = $path = ($user[$i]->file) ? url('/uploads/ChatFileInquiry/' . $user[$i]->id . '/' . $user[$i]->file) : "";
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["ext"] = $extension;

        }
        $data = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        //Notif sistem
        $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyNameImportir($sender),
            'dari_id' => $sender,
            'untuk_nama' => getCompanyName($receiver),
            'untuk_id' => $receiver,
            'keterangan' => 'New Message from ' . getCompanyNameImportir($sender) . ' about Inquiry ' . $data->subyek_en,
            'url_terkait' => 'inquiry/chatting',
            'status_baca' => 0,
            'waktu' => $datenow,
            'to_role' => 2,
            'id_terkait' => $id_inquiry
        ]);

        $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
        $email = $users->email;
        $username = $users->username;
        //Tinggal Ganti Email1 dengan email kemendag
        $data2 = [
            'email' => $email,
            'username' => $username,
            'type' => 'importir',
            'sender' => getCompanyNameImportir($sender),
            'receiver' => getCompanyName($receiver),
            'subjek' => $data->subyek_en
        ];

        Mail::send('inquiry.mail.sendChat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email'], $data2['username']);
            $mail->subject('Inquiry Chatting Information');
        });

        if (count($save) > 0) {
//            $meta = [
//                'code' => 200,
//                'message' => 'Success',
//                'status' => 'OK'
//            ];
//            $data = '';
//            $res['meta'] = $meta;
//            $res['data'] = $data;
            return response($jsonResult);
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

    public function fileChat(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id_inquiry = $request->id_inquiry;
        $sender = $request->id_user;
        $receiver = $request->id_penerima;
        $msg = $request->messages;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $destination = 'uploads\ChatFileInquiry\\' . $idmax;
        if ($request->hasFile('upload_file')) {
            $file1 = $request->file('upload_file');
            $nama_file1 = time() . '_' . $request->file('upload_file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $save = DB::table('csc_chatting_inquiry')->insertGetId([
//            'id' => $idmax,
            'id_inquiry' => $id_inquiry,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'file' => $nama_file1,
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);
        $user = DB::table('csc_chatting_inquiry')
            ->where('id', '=', $save)
            ->get();
        for ($i = 0; $i < count($user); $i++) {

            $ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }

            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["sender"] = $user[$i]->sender;
            $id_profil = $user[$i]->sender;
            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
            $jsonResult[$i]["receive"] = $user[$i]->receive;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["file"] = $path = ($user[$i]->file) ? url('/uploads/ChatFileInquiry/' . $user[$i]->id . '/' . $user[$i]->file) : "";
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["ext"] = $extension;

        }
        $data = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyNameImportir($sender),
            'dari_id' => $sender,
            'untuk_nama' => getCompanyName($receiver),
            'untuk_id' => $receiver,
            'keterangan' => 'New Message from ' . getCompanyNameImportir($sender) . ' about Inquiry ' . $data->subyek_en,
            'url_terkait' => 'inquiry/chatting',
            'status_baca' => 0,
            'waktu' => $datenow,
            'to_role' => 2,
            'id_terkait' => $id_inquiry
        ]);

        $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
        $email = $users->email;
        $username = $users->username;
        //Tinggal Ganti Email1 dengan email kemendag
        $data2 = [
            'email' => $email,
            'username' => $username,
            'type' => 'importir',
            'sender' => getCompanyNameImportir($sender),
            'receiver' => getCompanyName($receiver),
            'subjek' => $data->subyek_en
        ];

        Mail::send('inquiry.mail.sendChat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email'], $data2['username']);
            $mail->subject('Inquiry Chatting Information');
        });

        if (count($save) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($jsonResult);
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

    public function masukchattingEks(Request $request)
    {
        $id_user = $request->id_user;//sender
        $id_inquiry = $request->id_inquiry;
        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();

        $broadcast = NULL;
        $user = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', $id_inquiry)
            ->where('type', $inquiry->type)
            ->orderBy('created_at', 'desc')
            ->get();
        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["sender"] = $user[$i]->sender;
            $id_user = $user[$i]->sender;
            $id_profil = DB::table('itdp_company_users')->where('id', $id_user)->first()->id_profil;
            $id_role = DB::table('itdp_company_users')->where('id', $id_user)->first()->id_role;
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
            $jsonResult[$i]["receive"] = $user[$i]->receive;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["file"] = $path = ($user[$i]->file) ? url('/uploads/ChatFileInquiry/' . $user[$i]->id . '/' . $user[$i]->file) : "";
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["ext"] = $extension;

        }

        $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id_inquiry)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNull('messages')->count();

        //Read Chat
        $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id_inquiry)->where('type', $inquiry->type)->where('receive', $id_user)->update([
            'status' => 1,
        ]);

        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = array();
//            array_push($data, array(
//                'id_penerima' => $inquiry->id_pembuat,
//                'items' => $messages
//            ));
//            $res['meta'] = $meta;
//            $res['data'] = $data;
            return response($jsonResult);
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

    public function sendChatEks(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id_inquiry = $request->id_inquiry;
        $sender = $request->id_user;
        $receiver = $request->id_penerima;
        $msg = $request->messages;
        $type = 'importir';

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $save = DB::table('csc_chatting_inquiry')->insertGetId([
//            'id' => $idmax,
            'id_inquiry' => $id_inquiry,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => $type,
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);
        $user = DB::table('csc_chatting_inquiry')
            ->where('id', '=', $save)
            ->get();
        for ($i = 0; $i < count($user); $i++) {
            $ext = pathinfo($user[$i]->file, PATHINFO_EXTENSION);
            $gbr = ['png', 'jpg', 'jpeg'];
            $file = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

            if (in_array($ext, $gbr)) {
                $extension = "gambar";
            } else if (in_array($ext, $file)) {
                $extension = "file";
            } else {
                $extension = "not identified";
            }
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["sender"] = $user[$i]->sender;
            $id_profil = $user[$i]->sender;
            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
            $jsonResult[$i]["receive"] = $user[$i]->receive;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["file"] = $path = ($user[$i]->file) ? url('/uploads/ChatFileInquiry/' . $user[$i]->id . '/' . $user[$i]->file) : "";
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
            $jsonResult[$i]["ext"] = $extension;

        }
        $data = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        //Notif sistem
        $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyName($sender),
            'dari_id' => $sender,
            'untuk_nama' => getCompanyNameImportir($receiver),
            'untuk_id' => $receiver,
            'keterangan' => 'New Message from ' . getCompanyName($sender) . ' about Inquiry ' . $data->subyek_en,
            'url_terkait' => 'front_end/chat_inquiry',
            'status_baca' => 0,
            'waktu' => $datenow,
            'to_role' => 3,
            'id_terkait' => $id_inquiry
        ]);

        $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
        $email = $users->email;
        $username = $users->username;
        //Tinggal Ganti Email1 dengan email kemendag
        $data = [
            'email' => $email,
            'username' => $username,
            'type' => $type,
            'sender' => getCompanyName($sender),
            'receiver' => getCompanyNameImportir($receiver),
            'subjek' => $data->subyek_en
        ];

        Mail::send('inquiry.mail.sendChat', $data, function ($mail) use ($data) {
            $mail->to($data['email'], $data['username']);
            $mail->subject('Inquiry Chatting Information');
        });

        if (count($save) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($jsonResult);
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

    public function dealing(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $status = $request->status;
        $id_user = $request->id_user;
        $datenow = date('Y-m-d H:i:s');
        if ($status == 1) {
            $stat = 3;
        } else {
            $stat = 4;
        }
        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $update = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
            'status' => $stat,
        ]);
        if ($stat == 3) {
            $idn = DB::table('csc_transaksi')->max('id_transaksi');
            $idnew = $idn + 1;

            if ($inquiry->type == "admin") {
                $role = 1;
            } else if ($inquiry->type == "perwakilan") {
                $role = 4;
            } else if ($inquiry->type == "importir") {
                $role = 3;
            }
            $insert = DB::table('csc_transaksi')->insert([
//                "id_transaksi" => $idnew,
                "id_pembuat" => $inquiry->id_pembuat,
                "by_role" => $role,
                "id_eksportir" => $id_user,
                "id_terkait" => $id_inquiry,
                "origin" => 1,
                "created_at" => $datenow,
                "status_transaksi" => 0,
            ]);
            $untuk_nama = "";
            if ($inquiry->type == "admin") {
                $untuk_nama = getAdminName($inquiry->id_pembuat);
                $to_role = 1;
                $url_terkait = 'inquiry_admin/view_detail';
            } else if ($inquiry->type == "perwakilan") {
                $untuk_nama = getPerwakilanName($inquiry->id_pembuat);
                $to_role = 4;
                $url_terkait = 'inquiry_perwakilan/view_detail';
            }
            $broad = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $id)->where('id_itdp_company_users', $id_user)->first();
            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getCompanyName($id_user),
                'dari_id' => $id_user,
                'untuk_nama' => $untuk_nama,
                'untuk_id' => $inquiry->id_pembuat,
                'keterangan' => 'Inquiry with subject ' . $inquiry->subyek_en . ' has been Deal by Exporter ' . getCompanyName($id_user),
                'url_terkait' => $url_terkait,
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => $to_role,
                'id_terkait' => $broad->id
            ]);

            $users = DB::table('itdp_admin_users')->where('id', $inquiry->id_pembuat)->first();
            $email = $users->email;
            $username = $users->name;
            //Tinggal Ganti Email1 dengan email kemendag
            $data2 = [
                'email' => $email,
                'username' => $username,
                'type' => $inquiry->type,
                'penerima' => $untuk_nama,
                'company' => getCompanyName($id_user),
                'subjek' => $inquiry->subyek_en
            ];

            Mail::send('inquiry.mail.sendDeal', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email'], $data2['username']);
                $mail->subject('Inquiry Deal Information');
            });
        }

        if (count($update) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $idnew;
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
}
