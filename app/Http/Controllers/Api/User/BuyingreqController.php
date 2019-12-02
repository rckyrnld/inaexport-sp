<?php

namespace App\Http\Controllers\Api\User;

use App\Models\TicketingSupportModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;
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
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request  
                           where id_pembuat='" . $id_user . "' order by id desc ");

//        for($i = 0; $i < count($buy);  $i++){
//
//        }
//
//        foreach ($buy as $datanya) {
//            $coba = explode(",", $datanya->id_csc_prod);
//        }
//        dd($jsonResult);
        $jsonResult = array();
        for ($i = 0; $i < count($buy); $i++) {
            $jsonResult[$i]["row"] = $buy[$i]->row;
            $jsonResult[$i]["id"] = $buy[$i]->id;
            $jsonResult[$i]["id_mst_country"] = $buy[$i]->id_mst_country;
            $jsonResult[$i]["id_csc_prod_cat"] = $buy[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $buy[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $buy[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $buy[$i]->jenis_perihal_en;
            $jsonResult[$i]["subyek"] = $buy[$i]->subyek;
            $jsonResult[$i]["message"] = $buy[$i]->message;
            $jsonResult[$i]["files"] = $buy[$i]->files;
            $jsonResult[$i]["message_answer"] = $buy[$i]->message_answer;
            $jsonResult[$i]["file_answer"] = $buy[$i]->file_answer;
            $jsonResult[$i]["date"] = $buy[$i]->date;
            $jsonResult[$i]["st_approve"] = $buy[$i]->st_approve;
            $jsonResult[$i]["date_approve"] = $buy[$i]->date_approve;
            $jsonResult[$i]["date_answer"] = $buy[$i]->date_answer;
            $jsonResult[$i]["by_role"] = $buy[$i]->by_role;
            $jsonResult[$i]["id_pembuat"] = $buy[$i]->id_pembuat;
            $jsonResult[$i]["city"] = $buy[$i]->city;
            $jsonResult[$i]["shipping"] = $buy[$i]->shipping;
            $jsonResult[$i]["spec"] = $buy[$i]->spec;
            $jsonResult[$i]["eo"] = $buy[$i]->eo;
            $jsonResult[$i]["neo"] = $buy[$i]->neo;
            $jsonResult[$i]["tp"] = $buy[$i]->tp;
            $jsonResult[$i]["ntp"] = $buy[$i]->ntp;
            $jsonResult[$i]["valid"] = $buy[$i]->valid;
            if ($buy[$i]->valid == 0) {
                $jsonResult[$i]["valid_desc"] = 'No Limit';
            } else {
                $jsonResult[$i]["valid_desc"] = 'Valid ' . $buy[$i]->valid . " days";
            }
            $jsonResult[$i]["status"] = $buy[$i]->status;
            if ($buy[$i]->status == null || $buy[$i]->status == 0 || empty($buy[$i]->status) || $buy[$i]->status == 1) {
                $jsonResult[$i]["status_desc"] = "Negosiation";
            } else if ($buy[$i]->status == 4) {
                $jsonResult[$i]["status_desc"] = "Deal";
            }
            $jsonResult[$i]["jenis_perihal_in"] = $buy[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $buy[$i]->jenis_perihal_chn;
            $jsonResult[$i]["message_perihal_en"] = $buy[$i]->message_perihal_en;
            $jsonResult[$i]["message_perihal_in"] = $buy[$i]->message_perihal_in;
            $jsonResult[$i]["message_perihal_chn"] = $buy[$i]->message_perihal_chn;
            $jsonResult[$i]["subyek_en"] = $buy[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $buy[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $buy[$i]->subyek_chn;
            $jsonResult[$i]["deal"] = $buy[$i]->deal;
            $jsonResult[$i]["id_csc_prod"] = $buy[$i]->id_csc_prod;
            $jsonResult[$i]["type_tracking"] = $buy[$i]->type_tracking;
            $jsonResult[$i]["no_track"] = $buy[$i]->no_track;
            $jsonResult[$i]["status_trx"] = $buy[$i]->status_trx;
            $id_csc = explode(",", $buy[$i]->id_csc_prod);
            $list_k = array();

            for ($a = 0; $a < count($id_csc); $a++) {
                if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
                    //$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
                    $list_k[] = $id_csc[$a];
                }
            }

            $getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
            $jsonResult[$i]["kategori_desc"] = $getName;

//
//            $jsonResult[$i]["tes"] = $namas;
//            for($x=0;$x<count($namas);$x++){
//
//            }
//            $nama = $namas;

//            $jsonResult[$i]["csc_product_name"] = (!empty($id_csc[$i])) ? DB::table('csc_product')->where('id', $id_csc[$i])->first()->nama_kategori_en : "";

//            print_r($id_csc);


//            $jsonResult[$i]["image_1"] = $path = ($dataProduk[$i]->image_1) ? url('uploads/Eksportir_Product/Image/' . $dataProduk[$i]->id . '/' . $dataProduk[$i]->image_1) : url('image/noimage.jpg');
//
//            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
        }
//        dd($buy);
        if ($buy) {

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

    public function get_csc($id)
    {

        return DB::table('csc_product')->where('id', $id)->first()->nama_kategori_en;
    }

    public function br_importir_bc(Request $request)
    {
        $coba = str_replace('"', '', $request->id_csc_buying_request);
        $id = (int)$coba;
//        dd($id);
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
        $jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_mst_country"] = $data[$i]->id_mst_country;
            $jsonResult[$i]["id_csc_prod_cat"] = $data[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $data[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $data[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $data[$i]->jenis_perihal_en;
            $jsonResult[$i]["subyek"] = $data[$i]->subyek;
            $jsonResult[$i]["message"] = $data[$i]->message;
            $jsonResult[$i]["files"] = $data[$i]->files;
            $jsonResult[$i]["message_answer"] = $data[$i]->message_answer;
            $jsonResult[$i]["file_answer"] = $data[$i]->file_answer;
            $jsonResult[$i]["date"] = $data[$i]->date;
            $jsonResult[$i]["st_approve"] = $data[$i]->st_approve;
            $jsonResult[$i]["date_approve"] = $data[$i]->date_approve;
            $jsonResult[$i]["date_answer"] = $data[$i]->date_answer;
            $jsonResult[$i]["by_role"] = $data[$i]->by_role;
            $jsonResult[$i]["id_pembuat"] = $data[$i]->id_pembuat;
            $id_role = $data[$i]->by_role;
            if ($id_role == 3) {
                $id_profile = DB::table('itdp_company_users')->where('id', $data[$i]->id_pembuat)->first()->id_profil;
                $jsonResult[$i]["company_name"] = DB::table('itdp_profil_imp')->where('id', $id_profile)->first()->company;
            } else if ($id_role == 1) {
                $jsonResult[$i]["company_name"] = DB::table('itdp_admin_users')->where('id', $data[$i]->id_pembuat)->first()->name;
            } else {
                $jsonResult[$i]["company_name"] = DB::table('itdp_admin_users')->where('id', $data[$i]->id_pembuat)->first()->name;
            }
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["shipping"] = $data[$i]->shipping;
            $jsonResult[$i]["spec"] = $data[$i]->spec;
            $jsonResult[$i]["eo"] = $data[$i]->eo;
            $jsonResult[$i]["neo"] = $data[$i]->neo;
            $jsonResult[$i]["tp"] = $data[$i]->tp;
            $jsonResult[$i]["ntp"] = $data[$i]->ntp;
            $jsonResult[$i]["valid"] = $data[$i]->valid;
            if ($data[$i]->valid == 0) {
                $jsonResult[$i]["valid_desc"] = 'No Limit';
            } else {
                $jsonResult[$i]["valid_desc"] = 'Valid ' . $data[$i]->valid . " days";
            }
            $jsonResult[$i]["status"] = $data[$i]->status;
            if ($data[$i]->status == null || $data[$i]->status == 0 || empty($data[$i]->status)) {
                $jsonResult[$i]["status_desc"] = "Negosiation";
            } else {
                $jsonResult[$i]["status_desc"] = "Deal";
            }
            $jsonResult[$i]["jenis_perihal_in"] = $data[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $data[$i]->jenis_perihal_chn;
            $jsonResult[$i]["message_perihal_en"] = $data[$i]->message_perihal_en;
            $jsonResult[$i]["message_perihal_in"] = $data[$i]->message_perihal_in;
            $jsonResult[$i]["message_perihal_chn"] = $data[$i]->message_perihal_chn;
            $jsonResult[$i]["subyek_en"] = $data[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $data[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $data[$i]->subyek_chn;
            $jsonResult[$i]["deal"] = $data[$i]->deal;
            $jsonResult[$i]["id_csc_prod"] = $data[$i]->id_csc_prod;
            $id_csc = explode(",", $data[$i]->id_csc_prod);
            $list_k = array();
            for ($a = 0; $a < count($id_csc); $a++) {
                if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
                    //$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
                    $list_k[] = $id_csc[$a];
                }
            }
            $getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
            $jsonResult[$i]["kategori_desc"] = $getName;
            $jsonResult[$i]["type_tracking"] = $data[$i]->type_tracking;
            $jsonResult[$i]["no_track"] = $data[$i]->no_track;
            $jsonResult[$i]["status_trx"] = $data[$i]->status_trx;
            $jsonResult[$i]["ida"] = $data[$i]->ida;
            $jsonResult[$i]["statusa"] = $data[$i]->statusa;
            $jsonResult[$i]["id_br"] = $data[$i]->id_br;
            $jsonResult[$i]["id_eks"] = $data[$i]->id_eks;
            $jsonResult[$i]["status_join"] = $data[$i]->status_join;
            if ($data[$i]->status_join == null) {
                $jsonResult[$i]["status_join_desc"] = "-";
            } else if ($data[$i]->status_join == 1) {
                $jsonResult[$i]["status_join_desc"] = "Wait Importir Verification";
            } else if ($data[$i]->status_join == 4) {
                $jsonResult[$i]["status_join_desc"] = "Deal";
            } else {
                $jsonResult[$i]["status_join_desc"] = "Negosiation";
            }
            $jsonResult[$i]["expired_at"] = $data[$i]->expired_at;
            $jsonResult[$i]["idb"] = $data[$i]->idb;
        }
//        dd($jsonResult);
        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
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
        $id = $request->id;
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
        $id = $request->id;
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

    public function eks_br_chat(Request $request)
    {
        $id = $request->id;
        $q1 = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        foreach ($q1 as $p) {
            $id_br = $p->id_br;
        }
//        $qwr = DB::select("select * from csc_buying_request_chat where id_br='" . $id_br . "' and id_join='" . $id . "'");
        $users = DB::table('csc_buying_request_chat')
            ->where('id_br', '=', $id_br)
            ->where('id_join', '=', $id)
            ->orderBy('id', 'desc')
            ->get();
        if ($users) {
            return response($users);
        } else {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;

        }
    }

    public function uploadpop(Request $request)
    {
        $a = $request->pesan;
        $id2 = $request->id_br;
        $id3 = $request->id_role;
        $id4 = $request->id_user;
        $id5 = $request->username;
        $id6 = $request->idb;
        $file = $request->file('filez')->getClientOriginalName();
        $destinationPath = public_path() . "/uploads/pop";
        $request->file('filez')->move($destinationPath, $file);
        date_default_timezone_set('Asia/Jakarta');

        $insert = DB::table('csc_buying_request_chat')->insertGetId([
                'id_br' => $id2,
                'pesan' => $a,
                'tanggal' => Date('Y-m-d H:m:s'),
                'id_pengirim' => $id4,
                'id_role' => $id3,
                'username_pengirim' => $id5,
                'id_join' => $id6,
                'files' => $file,
            ]
        );
        $users = DB::table('csc_buying_request_chat')
            ->where('id_br', '=', $id2)
            ->where('id_join', '=', $id6)
            ->where('id', '=', $insert)
            ->get();
//        dd($users->files);
//        $users->file_desc = $path = ($users->files) ? url('/uploads/pop' . $users->files) : url('image/noimage.jpg');
        if ($users) {

            return $users;
        } else {
            $meta = [
                'code' => 404,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;

        }
    }

    public function br_deal(Request $request)
    {
        $id = $request->idb;
        $id2 = $request->id_br;
        $id3 = $request->id_user;
        $maxid = 0;
        $update = DB::select("update csc_buying_request_join set status_join='4' where id='" . $id . "' ");
        $update2 = DB::select("update csc_buying_request set status='4', deal='" . $id3 . "' where id='" . $id2 . "' ");
        $ambildata = DB::select("select * from csc_buying_request where id='" . $id2 . "'");
        foreach ($ambildata as $ad) {
            $isi1 = $ad->id_pembuat;
            $isi2 = $ad->by_role;
        }

//        $insert = DB::select("
//			insert into csc_transaksi (id_pembuat,by_role,id_eksportir,id_terkait,origin,created_at,status_transaksi) values
//			('" . $isi1 . "','" . $isi2 . "','" . $id3 . "','" . $id2 . "','2','" . Date('Y-m-d H:m:s') . "','0')");
//        $querymax = DB::select("select max(id_transaksi) as maxid from csc_transaksi");

        $insert = DB::table('csc_transaksi')->insert([
                'id_pembuat' => $isi1,
                'by_role' => $isi2,
                'id_eksportir' => $id3,
                'id_terkait' => $id2,
                'origin' => '2',
                'created_at' => Date('Y-m-d H:m:s'),
                'status_transaksi' => '0'
            ]
        );
        $querymax = DB::select("select max(id_transaksi) as maxid from csc_transaksi");
        foreach ($querymax as $maxquery) {
            $maxid = $maxquery->maxid;
        }

        if ($insert) {
            $list_k = array();
            $list_k["id_transaksi"] = $maxid;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $list_k;
            return response($res);
        } else {
            $meta = [
                'code' => 404,
                'message' => 'Erorr',
                'status' => 'Failed'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;

        }
    }

    public function simpanchatbr(Request $request)
    {
        $a = $request->pesan;
        $id2 = $request->id_br;
        $id3 = $request->id_role;
        $id4 = $request->id_user;
        $id5 = $request->username;
        $id6 = $request->idb;
        date_default_timezone_set('Asia/Jakarta');

        $insert = DB::table('csc_buying_request_chat')->insertGetId([
                'id_br' => $id2,
                'pesan' => $a,
                'tanggal' => Date('Y-m-d H:m:s'),
                'id_pengirim' => $id4,
                'id_role' => $id3,
                'username_pengirim' => $id5,
                'id_join' => $id6,
            ]
        );
        $users = DB::table('csc_buying_request_chat')
            ->where('id_br', '=', $id2)
            ->where('id_join', '=', $id6)
            ->where('id', '=', $insert)
            ->get();
        if ($users) {

            return $users;
        } else {
            $meta = [
                'code' => 404,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];

            $res['meta'] = $meta;
            $res['data'] = '';
            return $res;
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
