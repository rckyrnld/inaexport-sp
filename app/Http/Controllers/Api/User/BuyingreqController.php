<?php

namespace App\Http\Controllers\Api\User;

use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Yajra\DataTables\Facades\DataTables;
use Mail;


class BuyingreqController extends Controller
{

    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_user');
    }

    public function impmasukbr()
    {
        $kategoriprod = DB::table('csc_product')
            ->get();

        $quantity = array(
            "Each",
            "Foot",
            "Gallons",
            "Kilograms",
            "Liters",
            "Packs",
            "Pairs",
            "Pieces",
            "Reams",
            "Rods",
            "Rolls",
            "Sets",
            "Sheets",
            "Square Meters",
            "Tons",
            "Unit",
            "令",
            "件",
            "加仑",
            "包",
            "千克",
            "升",
            "单位",
            "卷",
            "吨",
            "套",
            "对",
            "平方米",
            "张",
            "根",
            "每个",
            "英尺",
            "集装箱",
        );
        $data = array();
        array_push($data, array(
            'kategori' => $kategoriprod,
            'quantity' => $quantity
        ));
//        dd($kategoriprod);
        if (count($data) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $data = $cars;
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

    public function br_importir_save(Request $request)
    {
//        dd($request);
        $kumpulcat = "";
        $g = count($request->category);
        for ($a = 0; $a < $g; $a++) {
            $kumpulcat = $kumpulcat . $request->category[$a] . ",";
        }
//        dd($kumpulcat);
//        $h = explode(",",$kumpulcat);

        if (empty($request->file('doc'))) {
            $file = "";
        } else {
            $file = $request->file('doc')->getClientOriginalName();
            $destinationPath = public_path() . "/uploads/buy_request";
            $request->file('doc')->move($destinationPath, $file);
        }
        $insert = DB::table('csc_buying_request')->insert([
            'subyek' => $request->subyek,
            'valid' => $request->valid,
            'id_mst_country' => $request->country,
            'city' => $request->city,
//            'id_csc_prod_cat' => $h[0],
            'id_csc_prod_cat_level1' => '0',
            'id_csc_prod_cat_level2' => '0',
            'shipping' => $request->ship,
            'spec' => $request->spec,
            'files' => $file,
            'eo' => $request->eo,
            'neo' => $request->neo,
            'tp' => $request->tp,
            'ntp' => $request->ntp,
            'by_role' => '3',
            'id_pembuat' => $request->id_user,
            'date' => Date('Y-m-d H:m:s'),
            'id_csc_prod' => $kumpulcat,
        ]);
        if ($insert) {

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

    public function impdata_br(Request $request)
    {
        $id_user = $request->id_user;
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request  where id_pembuat='" . $id_user . "' order by id desc ");
//        dd($buy);
        if ($buy) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $buy;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
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

    public function br_importir_bc(Request $request)
    {
        $id = $request->id_csc_buying_request;
        $cariprod = DB::select("select * from csc_buying_request where id='" . $id . "'");
        foreach ($cariprod as $prodcari) {
            $rrr = $prodcari->id_csc_prod;
            $zzz = $prodcari->id_pembuat;
        }
        $namacom = DB::select("select * from itdp_company_users where id='" . $zzz . "'");
        foreach ($namacom as $comnama) {
            $namapembuat = $comnama->username;
        }
        $cr = explode(',', $rrr);
        $hitung = count($cr);
        $semuacat = "";
        for ($a = 0; $a < ($hitung - 1); $a++) {
            //echo $rrr;die();
            // echo "select * from csc_product_single where id_csc_product='".$cr[0]."' or id_csc_product_level1='".$cr[0]."' or id_csc_product_level2='".$cr[0]."'";die();
            $namaprod = DB::select("select * from csc_product_single where id_csc_product='" . $cr[$a] . "' or id_csc_product_level1='" . $cr[$a] . "' or id_csc_product_level2='" . $cr[$a] . "' ");
            if (count($namaprod) == 0) {

            } else {
                foreach ($namaprod as $prod) {
                    $napro = $prod->id_itdp_company_user;
                    $cekada = DB::select("select * from csc_buying_request_join where id_br='" . $id . "' and id_eks='" . $napro . "'");
                    if (count($cekada) == 0) {

                        $insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('" . $id . "','" . $napro . "','" . Date('Y-m-d H:m:s') . "')");

                        //NOTIF
                        $id_terkait = "";
                        $ket = "Buying Request created by " . $namapembuat;
                        $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
					('2','" . $namapembuat . "','" . $zzz . "','Eksportir','" . $napro . "','" . $ket . "','br_list','" . $id_terkait . "','" . Date('Y-m-d H:m:s') . "','0')
				");
                        //END NOTIF
                        //EMAIL
                        $caridataeks = DB::select("select * from itdp_company_users where id='" . $napro . "'");
                        foreach ($caridataeks as $vm) {
                            $vc1 = $vm->email;
                        }
                        $data = ['username' => $namapembuat, 'id2' => '0', 'nama' => $namapembuat, 'password' => '', 'email' => $vc1];

                        Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                            $mail->to($data['email'], $data['username']);
                            $mail->subject('Buying Was Created');

                        });
                        //END EMAIL
                    } else {

                    }
                }
            }
        }
        $update = DB::select("update csc_buying_request set status='1' where id='" . $id . "'");
        if ($update) {

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

    public function ekslistbr(Request $request)
    {
        $iduser = $request->id_user;
        $data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request a, csc_buying_request_join b where a.id = b.id_br and b.id_eks='" . $iduser . "' order by b.id desc ");

        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
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

    public function eksjoinbr(Request $request)
    {
        $id = $request->id_br;
        $q1 = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        foreach ($q1 as $p) {
            $id_br = $p->id_br;
        }
        $q2 = DB::select("select * from csc_buying_request where id='" . $id_br . "'");
//        dd($q2);
        if ($q2) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $q2;
            return response($res);
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

    public function br_save_join(Request $request)
    {
        $id = $request->id_br;
        $update = DB::select("update csc_buying_request_join set status_join='1' where id='" . $id . "' ");
        if ($update) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
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

    public function br_importir_lc(Request $request)
    {
        $id_br = $request->id_br;
        $pesan = DB::select("select a.*,b.*,c.*,a.email as oemail,b.id as idb from itdp_company_users a, csc_buying_request_join b, itdp_profil_eks c where b.status_join >= '1' and a.id=b.id_eks and a.id_profil = c.id and id_br='" . $id_br . "'");
        if ($pesan) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $pesan;
            return response($res);
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

    public function br_konfirm(Request $request)
    {
        $id = $request->idb;
        $id2 = $request->id_br;

        $crv = DB::select("select * from csc_buying_request where id='" . $id2 . "'");
        foreach ($crv as $cr) {
            $vld = $cr->valid;
        }
        $dy = $vld . " day";
        $besok = date('Y-m-d', strtotime($dy, strtotime(date("Y-m-d"))));
        $update = DB::select("update csc_buying_request_join set status_join='2', expired_at='" . $besok . "' where id='" . $id . "' ");
        if ($update) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return response($res);
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

    public function br_chat(Request $request)
    {
        $id = $request->id_br;
        $q1 = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        foreach ($q1 as $p) {
            $id_br = $p->id_br;
        }
        $qwr = DB::select("select * from csc_buying_request_chat where id_br='".$id_br."' and id_join='".$id."'");
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
        if ($request->id_role == 3) {
            $id_user = $request->id_user;
            $id_product = $request->id_product;
            $type = 'importir';
            $datenow = date("Y-m-d H:i:s");

            $dtproduct = DB::table('csc_product_single')->where('id', $id_product)->first();
            $idn = DB::table('csc_inquiry_br')->max('id');
            $idnew = $idn + 1;

            $destination = 'uploads\Inquiry\\' . $idnew;
            if ($request->hasFile('filedo')) {
                $file1 = $request->file('filedo');
                $nama_file1 = time() . '_' . $request->subyek_en . '_' . $file1->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
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
                'id' => $idnew,
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

            if ($save) {
                $notif = DB::table('notif')->insert([
                    'dari_nama' => getCompanyNameImportir($id_user),
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyName($dtproduct->id_itdp_company_user),
                    'untuk_id' => $dtproduct->id_itdp_company_user,
                    'keterangan' => 'New Inquiry By ' . getCompanyNameImportir($id_user) . ' with Subyek  "' . $request->subject . '"',
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

//                Mail::send('inquiry.mail.sendToEksportir', $data, function ($mail) use ($data) {
//                    $mail->to($data['email'], $data['username']);
//                    $mail->subject('Inquiry Information');
//                });
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
        $importir = DB::table('csc_inquiry_br')
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product')
            ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
//            ->where('csc_inquiry_br.status', 1)
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();

        if (count($importir) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $importir;
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

        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $data = DB::table('csc_product_single')->where('id', $inquiry->to)->first();
        $idpenerima = $data->id_itdp_company_user;
        $messages = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', $id_inquiry)
            ->where('type', 'importir')
            ->orderBy('created_at', 'asc')
            ->get();
//        dd($data->id_itdp_company_user);
        //Read Chat
        $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id_inquiry)->where('type', 'importir')->where('receive', $id_user)->update([
            'status' => 1,
        ]);

        if (count($messages) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $data = array();
            array_push($data, array(
                'id_penerima' => $idpenerima,
                'items' => $messages
            ));
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

    public function sendChatimp(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id_inquiry = $request->id_inquiry;
        $sender = $request->id_user;
        $receiver = $request->id_penerima;
        $msg = $request->messages;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id' => $idmax,
            'id_inquiry' => $id_inquiry,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        if (count($save) > 0) {
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

    public function fileChat(Request $request)
    {
        $datenow = date('Y-m-d H:i:s');
        $id_inquiry = $request->id_inquiry;
        $sender = $request->id_user;
        $receiver = $request->id_penerima;

        $idm = DB::table('csc_chatting_inquiry')->max('id');
        $idmax = $idm + 1;

        $destination = 'uploads\ChatFileInquiry\\' . $idmax;
        if ($request->hasFile('upload_file')) {
            $file1 = $request->file('upload_file');
            $nama_file1 = time() . '_' . $request->file('upload_file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id' => $idmax,
            'id_inquiry' => $id_inquiry,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'importir',
            'file' => $nama_file1,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        if (count($save) > 0) {
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

    public function masukchattingEks(Request $request)
    {
        $id_user = $request->id_user;//sender
        $id_inquiry = $request->id_inquiry;
        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $product = DB::table('csc_product_single')->where('id', $inquiry->to)->where('id_itdp_company_user', $id_user)->first();

        $broadcast = NULL;
        $messages = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', $id_inquiry)
            ->where('type', $inquiry->type)
            ->orderBy('created_at', 'asc')
            ->get();

//        dd($inquiry->id_pembuat);
        $cekfile = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id_inquiry)->where('sender', $inquiry->id_pembuat)->where('receive', $id_user)->whereNull('messages')->count();

        //Read Chat
        $chat = DB::table('csc_chatting_inquiry')->where('id_inquiry', $id_inquiry)->where('type', $inquiry->type)->where('receive', $id_user)->update([
            'status' => 1,
        ]);

        if (count($messages) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = array();
            array_push($data, array(
                'id_penerima' => $inquiry->id_pembuat,
                'items' => $messages
            ));
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

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id' => $idmax,
            'id_inquiry' => $id_inquiry,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => $type,
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);
        if (count($save) > 0) {
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

    public function dealing(Request $request)
    {
        $id_inquiry = $request->id_inquiry;
        $status = $request->status;
        $id_user = $request->id_user;
        if ($status == 1) {
            $stat = 3;
        } else {
            $stat = 4;
        }
        $update = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
            'status' => $stat,
        ]);


        if (count($update) > 0) {
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
}
