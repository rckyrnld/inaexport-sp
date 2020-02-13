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
	
	public function getinquirynew(Request $request)
    {
//        dd($request);
        $id_user = $request->id_user;
        $user = DB::table('csc_inquiry_br')
			// ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            // ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
            ->where('csc_inquiry_br.status', '!=', 1)
			// ->orderBy('csc_inquiry_br.date', 'DESC')
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            // $jsonResult[$i]["id_pembuat"] = $user[$i]->id_itdp_profil_eks;
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
            $jsonResult[$i]["to"] = $user[$i]->id_itdp_company_user;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["duration"] = $user[$i]->duration;
            $jsonResult[$i]["prodname"] = $user[$i]->prodname_en;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;
            // $jsonResult[$i]["id_product"] = $user[$i]->id_product;
			
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

    public function getListinquiry(Request $request)
    {
//        dd($request);
        $id_user = $request->id_user;
        $user = DB::table('csc_inquiry_br')
		->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
                    ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.id_itdp_profil_eks,csc_product_single.id_itdp_company_user, csc_product_single.prodname_en')
                    ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
                    ->where('csc_inquiry_br.status', '!=', 1)
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
                    ->orderBy('csc_inquiry_br.created_at', 'DESC')
                    ->get();
		/*
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.id_itdp_profil_eks,csc_product_single.id_itdp_company_user, csc_product_single.prodname_en')
            ->where('csc_inquiry_br.id_pembuat', '=', $id_user)
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();
		*/
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
            $jsonResult[$i]["to"] = $user[$i]->id_itdp_company_user;
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
        date_default_timezone_set('Asia/Jakarta');
//        dd("ilyas");
        if ($request->id_role != null) {
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
                    'dari' => "Importer",
                    'bu' => getExBadan($dtproduct->id_itdp_company_user),
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

        $perwakilan = DB::table('csc_inquiry_br as a')
            ->join('csc_inquiry_broadcast as b', 'b.id_inquiry', '=', 'a.id')
            ->selectRaw('a.*, b.status,b.id as id_product')
            ->where('b.id_itdp_company_users', '=', $id_user)
//            ->where('b.status', 1)
//                    ->orderBy('a.date', 'DESC')
            ->orderBy('a.created_at', 'DESC')
            ->get();

        $jsonResult = array();
        for ($i = 0; $i < count($perwakilan); $i++) {
            $jsonResult[$i]["id"] = $perwakilan[$i]->id;
            $jsonResult[$i]["id_pembuat"] = $perwakilan[$i]->id_pembuat;
            $jsonResult[$i]["type"] = $perwakilan[$i]->type;
            $jsonResult[$i]["id_csc_prod_cat"] = $perwakilan[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $perwakilan[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $perwakilan[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $perwakilan[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $perwakilan[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $perwakilan[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $perwakilan[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $perwakilan[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $perwakilan[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $perwakilan[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $perwakilan[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $perwakilan[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $perwakilan[$i]->subyek_chn;
            $jsonResult[$i]["to"] = $perwakilan[$i]->id_pembuat;
            $jsonResult[$i]["status"] = $perwakilan[$i]->status;
            $jsonResult[$i]["date"] = $perwakilan[$i]->date;
            $jsonResult[$i]["created_at"] = $perwakilan[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $perwakilan[$i]->updated_at;
            $jsonResult[$i]["duration"] = $perwakilan[$i]->duration;
            $jsonResult[$i]["prodname"] = $perwakilan[$i]->prodname;
            $jsonResult[$i]["due_date"] = $perwakilan[$i]->due_date;
            $jsonResult[$i]["id_product"] = $perwakilan[$i]->id_product;

            //echo $user[$i]->id_pembuat;die();
//            $id_profil = DB::table('itdp_admin_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
            $id_profil = $perwakilan[$i]->id_pembuat;

            //
//            $id_role = DB::table('itdp_admin_users')->where('id', $perwakilan[$i]->id_pembuat)->first()->id_role;
            //	dd($id_role);
            $jsonResult[$i]["company_name"] = DB::table('itdp_admin_users')->where('id', $id_profil)->first()->name ;

            //            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
//            $jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $perwakilan[$i]->id_csc_prod_cat)->first()->nama_kategori_en;
//            $jsonResult[$i]["csc_product_level1_desc"] = ($perwakilan[$i]->id_csc_prod_cat_level1) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level1)->first()->nama_kategori_en : null;
//            $jsonResult[$i]["csc_product_level2_desc"] = ($perwakilan[$i]->id_csc_prod_cat_level2) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level2)->first()->nama_kategori_en : null;
        }

//
//        $user = DB::table('csc_inquiry_br')
//            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_inquiry_br.id_pembuat')
//            ->join('itdp_profil_imp', 'itdp_profil_imp.id', '=', 'itdp_company_users.id_profil')
//            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
//            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.id_itdp_profil_eks, csc_product_single.prodname_en')
//            ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
////            ->where('csc_inquiry_br.status', 1)
//            ->orderBy('csc_inquiry_br.created_at', 'DESC')
//            ->get();

        $user = DB::table('csc_inquiry_br')
            ->join('csc_product_single', 'csc_product_single.id', '=', 'csc_inquiry_br.to')
            ->selectRaw('csc_inquiry_br.*, csc_product_single.id as id_product, csc_product_single.id_itdp_profil_eks, csc_product_single.prodname_en')
            ->where('csc_product_single.id_itdp_company_user', '=', $id_user)
            ->where('csc_inquiry_br.status', 1)
            // ->orderBy('csc_inquiry_br.', 'DESC')
//                    ->orderBy('csc_inquiry_br.date', 'DESC')
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
            ->get();

//        $jsonResult = array();
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
            $jsonResult[$i]["to"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["duration"] = $user[$i]->duration;
            $jsonResult[$i]["prodname"] = $user[$i]->prodname_en;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;
            $jsonResult[$i]["id_product"] = $user[$i]->id_product;

            //echo $user[$i]->id_pembuat;die();
            $id_profil = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_profil;
            //
            $id_role = DB::table('itdp_company_users')->where('id', $user[$i]->id_pembuat)->first()->id_role;
            //	dd($id_role);
            $jsonResult[$i]["company_name"] = ($id_role == 3) ? DB::table('itdp_profil_imp')->where('id', $id_profil)->first()->company : DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;

            //            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
            $jsonResult[$i]["csc_product_desc"] = DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat)->first()->nama_kategori_en;
            $jsonResult[$i]["csc_product_level1_desc"] = ($user[$i]->id_csc_prod_cat_level1) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level1)->first()->nama_kategori_en : null;
            $jsonResult[$i]["csc_product_level2_desc"] = ($user[$i]->id_csc_prod_cat_level2) ? DB::table('csc_product')->where('id', $user[$i]->id_csc_prod_cat_level2)->first()->nama_kategori_en : null;
        }


//        return response($jsonResult);



//        dd($user);

//        dd($jsonResult);
        if (count($user) > 0 || count($perwakilan) > 0) {
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

        $path = ($inquiry->file) ? url('uploads/Inquiry/' . $id_inquiry . '/' . $inquiry->file) : url('image/nia3.png');
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
        date_default_timezone_set('Asia/Jakarta');
        $id_inquiry = $request->id_inquiry;
        $data = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $users = DB::table('itdp_company_users')->where('id', $data->id_pembuat)->first();
        $email = $users->email;
        $username = $users->username;
        $id_user = $users->id;
        $datenow = date('Y-m-d H:i:s');

        if ($data->type == "admin") {
            $rolenya = 1;
        } else if ($data->type == "perwakilan") {
            $rolenya = 4;
        } else if ($data->type == "importir") {
            $rolenya = 3;
        }

        $notif = DB::table('notif')->insert([
            'dari_nama' => getCompanyName($id_user),
            'dari_id' => $id_user,
            'untuk_nama' => getCompanyNameImportir($data->id_pembuat),
            'untuk_id' => $data->id_pembuat,
            'keterangan' => 'Exporter ' . getCompanyName($id_user) . ' has joined Inquiry ' . $data->subyek_en,
            'url_terkait' => 'front_end/history',
            'status_baca' => 0,
            'waktu' => $datenow,
            'to_role' => $rolenya,
        ]);
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
        date_default_timezone_set('Asia/Jakarta');
        $id_inquiry = $request->id_inquiry;
        $datenow = date('Y-m-d H:i:s');
        $data = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();

        $durasi = 0;
        if ($data) {
            if ($data->duration != "None") {
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
        date_default_timezone_set('Asia/Jakarta');
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
//            $id_profil = $user[$i]->sender;
//            $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
            $jsonResult[$i]["company_name"] = getCompanyNameImportir($user[$i]->sender);
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
        date_default_timezone_set('Asia/Jakarta');
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
//            $id_profil = $data = DB::table('itdp_company_users')->where('id', $user[$i]->sender)->first()->id_profil;;
//            $id_profil = $user[$i]->sender;
            $jsonResult[$i]["company_name"] = (getCompanyNameImportir($user[$i]->sender) == "-") ? getCompanyName($user[$i]->sender) : getCompanyNameImportir($user[$i]->sender);
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
            'dari_nama' => (getCompanyNameImportir($sender) == "-") ? getCompanyName($sender) : getCompanyNameImportir($sender),
            'dari_id' => $sender,
            'untuk_nama' => (getCompanyNameImportir($receiver) == "-") ? getCompanyName($receiver) : getCompanyNameImportir($receiver),
            'untuk_id' => $receiver,
            'keterangan' => 'New Payment Information from ' . getCompanyNameImportir($sender) . ' about Inquiry ' . $data->subyek_en,
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
            'bu' => '',
            'id' => $idm,
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
        date_default_timezone_set('Asia/Jakarta');
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
			$y = DB::table('itdp_profil_eks')->where('id', $id_profil)->get();
			if(count($y) == 0){
				$jsonResult[$i]["company_name"] = "";
			}else{
				$jsonResult[$i]["company_name"] = DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company;
			}
            // $jsonResult[$i]["company_name"] = (DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company) ? DB::table('itdp_profil_eks')->where('id', $id_profil)->first()->company : "";
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
            'bu' => "",
            'id' => $idm,
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
        date_default_timezone_set('Asia/Jakarta');
        $id_inquiry = $request->id_inquiry;
        $status = $request->status;
        $datenow = date('Y-m-d H:i:s');
        if ($status == 1) {
            $stat = 3;
        } else {
            $stat = 4;
        }
        $inquiry = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->first();
        $id_prods = $inquiry->to;
        $users = DB::table('csc_product_single')->where('id', $id_prods)->first();
        $id_user = $users->id_itdp_company_user;
//        $username = $users->username;

        $update = DB::table('csc_inquiry_br')->where('id', $id_inquiry)->update([
            'status' => $stat,
        ]);
        if ($stat == 3) {
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

            $notif = DB::table('notif')->insert([
                'dari_nama' => getCompanyName($id_user),
                'dari_id' => $id_user,
                'untuk_nama' => getCompanyNameImportir($inquiry->id_pembuat),
                'untuk_id' => $inquiry->id_pembuat,
                'keterangan' => 'Inquiry with subject ' . $inquiry->subyek_en . ' has been Deal by Exporter ' . getCompanyName($id_user),
                'url_terkait' => 'front_end/view_inquiry',
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => 3,
                'id_terkait' => $id_inquiry
            ]);

            $querymax = DB::select("select max(id_transaksi) as maxid from csc_transaksi");
            foreach ($querymax as $maxquery) {
                $maxid = $maxquery->maxid;
            }

            $usersemail = DB::table('itdp_company_users')->where('id', $inquiry->id_pembuat)->first();
//            dd($users);
            $email = $usersemail->email;
            $username = $usersemail->username;

            $data2 = [
                'email' => $email,
                'username' => $username,
                'type' => $inquiry->type,
                'penerima' => getCompanyNameImportir($inquiry->id_pembuat),
                'company' => getCompanyName($id_user),
                'bu' => "",
                'subjek' => $inquiry->subyek_en
            ];
//            dd($data2);
            Mail::send('inquiry.mail.sendDeal', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email'], $data2['username']);
                $mail->subject('Inquiry Deal Information');
            });
        }

        if (count($data2) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $list_k = array();
            $list_k["id_transaksi"] = $maxid;
            $res['meta'] = $meta;
            $res['data'] = $list_k;
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


    //admin punya

    public function adminperwachatting(Request $request)
    {
        $id_user = $request->id_user;
        $data = DB::table('csc_inquiry_broadcast')->where('id', $request->id_inquiry_broadcast)->first();
        $inquiry = DB::table('csc_inquiry_br')->where('id', $data->id_inquiry)->first();
        $messages = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', $data->id_inquiry)
            ->where('type', 'admin')
            ->where('id_broadcast_inquiry', $request->id_inquiry_broadcast)
            ->orderBy('created_at', 'asc')
            ->get();

        $chat = DB::table('csc_chatting_inquiry')
            ->where('id_inquiry', $data->id_inquiry)
            ->where('type', 'admin')
            ->where('sender', $data->id_itdp_company_users)
            ->where('receive', $inquiry->id_pembuat)
            ->where('id_broadcast_inquiry', $request->id_inquiry_broadcast)
            ->update([
                'status' => 1,
            ]);

        if ($chat) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $list_k = array();
//            $list_k["id_transaksi"] = $maxid;
            $res['meta'] = $meta;
            $res['data'] = $chat;
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

    public function adminperwasendChat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id = $request->idinquiry;
        $id_broadcast = $request->idbroadcast;
        $sender = $request->from;
        $receiver = $request->to;
        $msg = $request->messages;

        $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

        $save = DB::table('csc_chatting_inquiry')->insert([
            'id_inquiry' => $id,
            'id_broadcast_inquiry' => $id_broadcast,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'admin',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        if ($save) {
            //Notif sistem
            $notif = DB::table('notif')->insert([
                'dari_nama' => getAdminName($sender),
                'dari_id' => $sender,
                'untuk_nama' => getCompanyName($receiver),
                'untuk_id' => $receiver,
                'keterangan' => 'New Message from ' . getAdminName($sender) . ' about Inquiry ' . $data->subyek_en,
                'url_terkait' => 'inquiry/chatting',
                'status_baca' => 0,
                'waktu' => $datenow,
                'to_role' => 2,
                'id_terkait' => $id
            ]);

            $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
            $email = $users->email;
            $username = $users->username;
            //Tinggal Ganti Email1 dengan email kemendag
            $data2 = [
                'email' => $email,
                'username' => $username,
                'type' => "admin",
                'sender' => getAdminName($sender),
                'receiver' => getCompanyName($receiver),
                'subjek' => $data->subyek_en
            ];

            Mail::send('inquiry.mail.sendChat', $data2, function ($mail) use ($data2) {
                $mail->to($data2['email'], $data2['username']);
                $mail->subject('Inquiry Chatting Information');
            });

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $list_k = array();
//            $list_k["id_transaksi"] = $maxid;
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

    public function adminperwafileChat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date('Y-m-d H:i:s');
        $id = $request->id_inquiry;
        $id_broadcast = $request->id_broadcast;
        $sender = $request->sender;
        $receiver = $request->receiver;
        $msg = $request->msgfile;

        $data = DB::table('csc_inquiry_br')->where('id', $id)->first();

        $save = DB::table('csc_chatting_inquiry')->insertGetId([
            'id_inquiry' => $id,
            'id_broadcast_inquiry' => $id_broadcast,
            'sender' => $sender,
            'receive' => $receiver,
            'type' => 'admin',
            'messages' => $msg,
            'status' => 0,
            'created_at' => $datenow,
        ]);

        //upload file
        $nama_file1 = NULL;
        $destination = 'uploads\ChatFileInquiry\\' . $save;
        if ($request->hasFile('upload_file')) {
            $file1 = $request->file('upload_file');
            $nama_file1 = time() . '_' . $request->file('upload_file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
        }

        $savefile = DB::table('csc_chatting_inquiry')->where('id', $save)->update([
            'file' => $nama_file1,
        ]);

        //Notif sistem
        $notif = DB::table('notif')->insert([
            'dari_nama' => getAdminName($sender),
            'dari_id' => $sender,
            'untuk_nama' => getCompanyName($receiver),
            'untuk_id' => $receiver,
            'keterangan' => 'New Message from ' . getAdminName($sender) . ' about Inquiry ' . $data->subyek_en,
            'url_terkait' => 'inquiry/chatting',
            'status_baca' => 0,
            'waktu' => $datenow,
            'to_role' => 2,
            'id_terkait' => $id
        ]);

        $users = DB::table('itdp_company_users')->where('id', $receiver)->first();
        $email = $users->email;
        $username = $users->username;
        //Tinggal Ganti Email1 dengan email kemendag
        $data2 = [
            'email' => $email,
            'username' => $username,
            'type' => "admin",
            'sender' => getAdminName($sender),
            'receiver' => getCompanyName($receiver),
            'subjek' => $data->subyek_en
        ];

        Mail::send('inquiry.mail.sendChat', $data2, function ($mail) use ($data2) {
            $mail->to($data2['email'], $data2['username']);
            $mail->subject('Inquiry Chatting Information');
        });
        if ($data2) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
//            $list_k = array();
//            $list_k["id_transaksi"] = $maxid;
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
}
