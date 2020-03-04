<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Models\Api\AdminApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Mail;


class ManagementController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api_admin');
    }

    public function getRekapAnggota(Request $request)
    {
//        dd($request);
        $offset = $request->offset;
        // dd(auth()->authenticate());
//        $data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc LIMIT 10 OFFSET " . $offsite .");
        $importirs = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('itdp_company_users.id_role', '3')
            ->selectRaw('itdp_company_users.id as id_user, itdp_company_users.id_profil as id_profil, 
            itdp_company_users.*, itdp_company_users.status as status_verif, itdp_profil_imp.*')
//            ->select('itdp_company_users.*', 'itdp_profil_imp.*')
            ->orderBy('itdp_company_users.id', 'desc')
            ->offset($offset)
            ->limit(10)
            ->get();
//        $data = ['importirs' => $importirs, 'eksportirs' => $eksportirs];
//        $dataResult = $this->customPaginate($data, $pageNya);
        if (count($importirs) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $importirs;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getRekapAnggotaEks(Request $request)
    {
//        dd($request);
        $offset = $request->offset;
        // dd(auth()->authenticate());
//        $data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc LIMIT 10 OFFSET " . $offsite .");
        $importirs = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('itdp_company_users.id_role', '2')
            ->selectRaw('itdp_company_users.id as id_user, itdp_company_users.id_profil as id_profil, 
            itdp_company_users.*, itdp_company_users.status as status_verif, itdp_profil_eks.*')
//            ->select('itdp_company_users.*', 'itdp_profil_imp.*')
            ->orderBy('itdp_company_users.id', 'desc')
            ->offset($offset)
            ->limit(10)
            ->get();
//        $data = ['importirs' => $importirs, 'eksportirs' => $eksportirs];
//        $dataResult = $this->customPaginate($data, $pageNya);
        if (count($importirs) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $importirs;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function detailVerifikasiImportir(Request $request)
    {
        $companyUsers = DB::select("select * from itdp_company_users where id='$request->id' limit 1");

        $detailCompanyUsers = DB::select("select b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$request->id' limit 1");

        if ((count($companyUsers) > 0) && (count($detailCompanyUsers) > 0)) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = ['companyUser' => $companyUsers, 'profilUser' => $detailCompanyUsers];
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function detailVerifikasiEksportir(Request $request)
    {
        $companyUsers = DB::select("select * from itdp_company_users where id='$request->id' limit 1");

        $detailCompanyUsers = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$request->id' limit 1");

        if ((count($companyUsers) > 0) && (count($detailCompanyUsers) > 0)) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = ['companyUser' => $companyUsers, 'profilUser' => $detailCompanyUsers];
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function submitVerifikasiImportir(Request $request)
    {
        $id_role = $request->id_role;
        $id_user = $request->id_user;
        $id_user_b = $request->idu;

        $isTrue1 = false;
        $isTrue2 = false;
        $isTrue3 = false;
        //UPDATE TAB 1
        if ($request->password == null) {
            $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "', status='" . $request->staim . "' where id='" . $request->id_user . "' ");
            $isTrue1 = true;
        } else {
            $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->staim . "', email='" . $request->email . "' where id='" . $request->id_user . "' ");
            $isTrue1 = true;
        }
        //UPDATE TAB 2
        if ($id_role == 2) {
            $updatetab2 = DB::select("update itdp_profil_eks set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' 
			, id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' 
			where id='" . $id_user_b . "'");
            $isTrue2 = true;
        } else {
            $updatetab2 = DB::select("update itdp_profil_imp set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' 
			, province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' 
			where id='" . $id_user_b . "'");
            $isTrue2 = true;
        }

        //UPDATE TAB 3
        if ($id_role == 2) {
            if ($request->npwp == null) {

                $isTrue3 = false;
            } else {
                $updatetab2 = DB::select("update itdp_profil_eks set npwp='" . $request->npwp . "', tdp='" . $request->tanda_daftar . "', siup='" . $request->siup . "' , doc='1.jpg' 
				, upduserid='" . $request->situ . "' , id_eks_business_size='" . $request->scoope . "', id_business_role_id='" . $request->tob . "', employe='" . $request->employee . "', status='" . $request->staim . "' 
				where id='" . $id_user_b . "'");

                $isTrue3 = true;
            }
        }
        if ($isTrue1 && $isTrue2 && $isTrue3) {
            $res['message'] = "Success";
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }

    public function submitVerifikasiEksportir(Request $request)
    {
        $id_role = $request->id_role;
        $id_user = $request->id_user;
        $id_user_b = $request->idu;
        $isTrue1 = false;
        $isTrue2 = false;
        $isTrue3 = false;
        if (empty($request->file('foto_profil'))) {
            $file = "";
            $isTrue1 = true;
        } else {
            $file = $request->file('foto_profil')->getClientOriginalName();
            $destinationPath = public_path() . "/image/fotoprofil";
            $request->file('foto_profil')->move($destinationPath, $file);
            $updatetab12 = DB::select("update itdp_company_users set foto_profil='" . $file . "'  where id='" . $request->id_user . "' ");
            $updatetab22 = DB::select("update itdp_profil_imp set logo='" . $file . "' where id='" . $id_user_b . "'");
            $isTrue1 = true;
        }

        //UPDATE TAB 1
        if ($request->password == null) {
            $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', email='" . $request->email . "', status='" . $request->staim . "'  where id='" . $request->id_user . "' ");
            $isTrue2 = true;
        } else {
            $updatetab1 = DB::select("update itdp_company_users set username='" . $request->username . "', password='" . bcrypt($request->password) . "', status='" . $request->staim . "' ,  email='" . $request->email . "' where id='" . $request->id_user . "' ");
            $isTrue2 = true;
        }
        //UPDATE TAB 2 belum kelar
        if ($request->npwp == null) {

            $isTrue3 = false;
        } else {
            $updatetab2 = DB::select("update itdp_profil_imp set company='" . $request->company . "', addres='" . $request->addres . "', city='" . $request->city . "' 
			, id_mst_province='" . $request->province . "' , postcode='" . $request->postcode . "', fax='" . $request->fax . "', website='" . $request->website . "', phone='" . $request->phone . "' , status='" . $request->staim . "'
			where id='" . $id_user_b . "'");
            $isTrue3 = true;
        }
        if ($isTrue1 && $isTrue2 && $isTrue3) {
            $res['message'] = "Success";
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }

    public static function customPaginate($items, $perPage)
    {
        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($items);

        //Define how many items we want to be visible in each page
        $perPage = $perPage;

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

        return $paginatedSearchResults;
    }

    public function verifikasi_act(Request $request)//belum ada api nya
    {

        $id_user = $request->id_user;
        $datenow = date("Y-m-d H:i:s");

        $data = DB::table('csc_product_single')->where('id', $request->id_product)->first();
        $carieks = DB::select("select email from itdp_company_users where id='" . $data->id_itdp_company_user . "'");
        foreach ($carieks as $teks) {
            $maileks = $teks->email;
        }
        $verifikasi = $request->verifikasi;
        // var_dump($verifikasi);
        if ($verifikasi == '1') {
            $status = 2;
            $ket = "This product has been added on the front page";
            $notifnya = "has been accepted";
            $ket = "Your product " . $data->prodname_en . " got verified !";
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
				('2','Super Admin','1','Eksportir','" . $data->id_itdp_company_user . "','" . $ket . "','eksportir/product_view','" . $request->id_product . "','" . Date('Y-m-d H:m:s') . "','0')
				");
            $data33 = [
                'email' => "",
                'email1' => $maileks,
                'username' => $data->prodname_en,
                'main_messages' => "",
                'id' => $request->id_product
            ];
            Mail::send('UM.user.sendproduct', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject("Your product got verified !");
            });
            // echo $data->prodname_en;die();
        } else {
            $keterangan = $request->keterangan;
            // var_dump($keterangan);
            $status = 3;
            $ket = "The product that you added cannot be displayed on the front page because " . $keterangan;
            $notifnya = "has been declined";
        }

        // var_dump($status);
        // var_dump($ket);
        // die();
        $update = DB::table('csc_product_single')->where('id', $request->id_product)->update([
            'status' => $status,
            'keterangan' => $ket,
            'updated_at' => $datenow,
        ]);

        if ($update) {
            $pengirim = DB::table('itdp_admin_users')->where('id', $id_user)->first();
            $notif = DB::table('notif')->insert([
                'dari_nama' => $pengirim->name,
                'dari_id' => $id_user,
                'untuk_nama' => getCompanyName($data->id_itdp_company_user),
                'untuk_id' => $data->id_itdp_company_user,
                'keterangan' => 'Product ' . $data->prodname_en . ' ' . $notifnya . ' by Admin',
                'url_terkait' => 'eksportir/product_view',
                'status_baca' => 0,
                'waktu' => $datenow,
                'id_terkait' => $request->id_product,
                'to_role' => 2,
            ]);
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'Failed'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }


    public function approval(Request $req)
    {

        $id_user = $req->id_user;
        $data_sebelumnya = DB::table('itdp_service_eks')->where('id', $req->id_service)->first();
        $pageTitle = 'Service';
        if ($req->verifikasi == 1) {
            $status = 2;
            $ket = "This product has been added on the front page";
            $notifnya = "has been accepted";

            $update = DB::table('itdp_service_eks')->where('id', $req->id_service)->update([
                'status' => 2,
                'keterangan' => $ket
            ]);
        } else {
            $status = 3;
            $ket = "The product that you added cannot be displayed on the front page because " . $req->keterangan;
            $notifnya = "has been declined";

            $update = DB::table('itdp_service_eks')->where('id', $req->id_service)->update([
                'status' => 3,
                'keterangan' => $ket
            ]);
        }

        $cek_notif = DB::table('notif')->where('url_terkait', 'eksportir/service/view')
            ->where('id_terkait', $req->id_service)
            ->where('untuk_id', getIdUserEks($data_sebelumnya->id_itdp_profil_eks))
            ->first();

        if ($update) {
            if (!$cek_notif) {
                $pengirim = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                $penerima = DB::table('itdp_profil_eks')->where('id', $data_sebelumnya->id_itdp_profil_eks)->first();
                $notif = DB::table('notif')->insert([
                    'dari_nama' => $pengirim->name,
                    'dari_id' => $id_user,
                    'untuk_nama' => $penerima->company,
                    'untuk_id' => getIdUserEks($data_sebelumnya->id_itdp_profil_eks),
                    'keterangan' => 'Product ' . $data_sebelumnya->nama_en . ' ' . $notifnya . ' by Admin',
                    'url_terkait' => 'eksportir/service/view',
                    'status_baca' => 0,
                    'waktu' => date('Y-m-d H:i:s'),
                    'id_terkait' => $req->id_service,
                    'to_role' => 2
                ]);
            } else {
                $notif = DB::table('notif')->where('id_notif', $cek_notif->id_notif)->update([
                    'keterangan' => 'Product ' . $data_sebelumnya->nama_en . ' ' . $notifnya . ' by Admin',
                    'status_baca' => 0,
                    'waktu' => date('Y-m-d H:i:s')
                ]);
            }

        }
        $meta = [
            'code' => 200,
            'message' => 'Success',
            'status' => 'OK'
        ];
        $data = "";
        $res['meta'] = $meta;
        $res['data'] = $data;
        return response($res);
    }
	
	public function list_br_admin(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
		$page = $request->page;
		$limit = $request->limit;
        $buy = DB::table('csc_buying_request')
                    ->orderBy('csc_buying_request.id', 'DESC')
					->paginate($limit);
		$buy2 = DB::table('csc_buying_request')
                    ->orderBy('csc_buying_request.id', 'DESC')
					->get();
		

        $jsonResult = array();
        for ($i = 0; $i < count($buy); $i++) {
            if(!empty($buy[$i]->id_mst_country)){ $daz1 = $buy[$i]->id_mst_country; }else{ $daz1 = "0"; }
            if(!empty($buy[$i]->id_csc_prod_cat)){ $daz2 = $buy[$i]->id_csc_prod_cat; }else{ $daz2 = "0"; }
            if(!empty($buy[$i]->id_csc_prod_cat_level1)){ $daz3 = $buy[$i]->id_csc_prod_cat_level1; }else{ $daz3 = "0"; }
            if(!empty($buy[$i]->id_csc_prod_cat_level2)){ $daz4 = $buy[$i]->id_csc_prod_cat_level2; }else{ $daz4 = "0"; }
            if(!empty($buy[$i]->jenis_perihal_en)){ $daz5 = $buy[$i]->jenis_perihal_en; }else{ $daz5 = ""; }
            if(!empty($buy[$i]->subyek)){ $daz6 = $buy[$i]->subyek; }else{ $daz6 = ""; }
            if(!empty($buy[$i]->message)){ $daz7 = $buy[$i]->message; }else{ $daz7 = ""; }
            if(!empty($buy[$i]->files)){ $daz8 = $buy[$i]->files; }else{ $daz8 = ""; }
            if(!empty($buy[$i]->message_answer)){ $daz9 = $buy[$i]->message_answer; }else{ $daz9 = ""; }
            if(!empty($buy[$i]->file_answer)){ $daz10 = $buy[$i]->file_answer; }else{ $daz10 = ""; }
            if(!empty($buy[$i]->st_approve)){ $daz11 = $buy[$i]->st_approve; }else{ $daz11 = 0; }
            if(!empty($buy[$i]->city)){ $daz12 = $buy[$i]->city; }else{ $daz12 = ""; }
            if(!empty($buy[$i]->shipping)){ $daz13 = $buy[$i]->shipping; }else{ $daz13 = ""; }
            if(!empty($buy[$i]->spec)){ $daz14 = $buy[$i]->spec; }else{ $daz14 = ""; }
            if(!empty($buy[$i]->eo)){ $daz15 = $buy[$i]->eo; }else{ $daz15 = 0; }
            if(!empty($buy[$i]->neo)){ $daz16 = $buy[$i]->neo; }else{ $daz16 = ""; }
			if(!empty($buy[$i]->tp)){ $daz17 = $buy[$i]->tp; }else{ $daz17 = 0; }
            if(!empty($buy[$i]->ntp)){ $daz18 = $buy[$i]->ntp; }else{ $daz18 = ""; }
            if(!empty($buy[$i]->jenis_perihal_in)){ $daz19 = $buy[$i]->jenis_perihal_in; }else{ $daz19 = ""; }
            if(!empty($buy[$i]->jenis_perihal_chn)){ $daz20 = $buy[$i]->jenis_perihal_chn; }else{ $daz20 = ""; }
            if(!empty($buy[$i]->message_perihal_en)){ $daz21 = $buy[$i]->message_perihal_en; }else{ $daz21 = ""; }
            if(!empty($buy[$i]->message_perihal_in)){ $daz22 = $buy[$i]->message_perihal_in; }else{ $daz22 = ""; }
            if(!empty($buy[$i]->message_perihal_chn)){ $daz23 = $buy[$i]->message_perihal_chn; }else{ $daz23 = ""; }
            if(!empty($buy[$i]->subyek_en)){ $daz24 = $buy[$i]->subyek_en; }else{ $daz24 = ""; }
            if(!empty($buy[$i]->subyek_in)){ $daz25 = $buy[$i]->subyek_in; }else{ $daz25 = ""; }
            if(!empty($buy[$i]->subyek_chn)){ $daz26 = $buy[$i]->subyek_chn; }else{ $daz26 = ""; }
            if(!empty($buy[$i]->deal)){ $daz27 = $buy[$i]->deal; }else{ $daz27 = 0; }
            // if(!empty($buy[$i]->id_csc_prod)){ $daz28 = $buy[$i]->id_csc_prod; }else{ $daz28 = ""; }
            if(!empty($buy[$i]->type_tracking)){ $daz29 = $buy[$i]->type_tracking; }else{ $daz29 = ""; }
            if(!empty($buy[$i]->no_track)){ $daz30 = $buy[$i]->no_track; }else{ $daz30 = ""; }
            if(!empty($buy[$i]->status_trx)){ $daz31 = $buy[$i]->status_trx; }else{ $daz31 = ""; }
            if(!empty($buy[$i]->status)){ $daz32 = $buy[$i]->status; }else{ $daz32 = 0; }
            $jsonResult[$i]["id"] = $buy[$i]->id;
            $jsonResult[$i]["id_mst_country"] = $daz1;
            $jsonResult[$i]["id_csc_prod_cat"] = $daz2;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $daz3;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $daz4;
            $jsonResult[$i]["jenis_perihal_en"] = $daz5;
            $jsonResult[$i]["subyek"] = $daz6;
            $jsonResult[$i]["message"] = $daz7;
            $jsonResult[$i]["files"] = $daz8;
            $jsonResult[$i]["message_answer"] = $daz9;
            $jsonResult[$i]["file_answer"] = $daz10;
            $jsonResult[$i]["date"] = $buy[$i]->date;
            $jsonResult[$i]["st_approve"] = $daz11;
            $jsonResult[$i]["date_approve"] = $buy[$i]->date_approve;
            $jsonResult[$i]["date_answer"] = $buy[$i]->date_answer;
            $jsonResult[$i]["by_role"] = $buy[$i]->by_role;
			if($buy[$i]->by_role == 1){
				$jsonResult[$i]["role_desc"] = "Admin";
			}else if($buy[$i]->by_role == 4){
				$jsonResult[$i]["role_desc"] = "Representative";
			}else if($buy[$i]->by_role == 3){
				$jsonResult[$i]["role_desc"] = "Importer";
			}else{
				$jsonResult[$i]["role_desc"] = "";
			}
			
            $jsonResult[$i]["id_pembuat"] = $buy[$i]->id_pembuat;
            $jsonResult[$i]["city"] = $daz12;
            $jsonResult[$i]["shipping"] = $daz13;
            $jsonResult[$i]["spec"] = $daz14;
            $jsonResult[$i]["eo"] = $daz15;
            $jsonResult[$i]["neo"] = $daz16;
            $jsonResult[$i]["tp"] = $daz17;
            $jsonResult[$i]["ntp"] = $daz18;
            $jsonResult[$i]["valid"] = $buy[$i]->valid;
            if ($buy[$i]->valid == 0) {
                $jsonResult[$i]["valid_desc"] = 'No Limit';
            } else {
                $jsonResult[$i]["valid_desc"] = 'Valid ' . $buy[$i]->valid . " days";
            }
            $jsonResult[$i]["status"] = $daz32;
            if ($buy[$i]->status == null || $buy[$i]->status == 0 || empty($buy[$i]->status) || $buy[$i]->status == 1) {
                $jsonResult[$i]["status_desc"] = "Negosiation";
            } else if ($buy[$i]->status == 4) {
                $jsonResult[$i]["status_desc"] = "Deal";
            }
            $jsonResult[$i]["jenis_perihal_in"] = $daz19;
            $jsonResult[$i]["jenis_perihal_chn"] = $daz20;
            $jsonResult[$i]["message_perihal_en"] = $daz21;
            $jsonResult[$i]["message_perihal_in"] = $daz22;
            $jsonResult[$i]["message_perihal_chn"] = $daz23;
            $jsonResult[$i]["subyek_en"] = $daz24;
            $jsonResult[$i]["subyek_in"] = $daz25;
            $jsonResult[$i]["subyek_chn"] = $daz26;
            $jsonResult[$i]["deal"] = $daz27;
            // $jsonResult[$i]["id_csc_prod"] = $daz28;
			/*
			$icp = explode(",",$buy[$i]->id_csc_prod);
			
			$ci = count($icp);
			if($ci == 0){ $ca = 0; 
			$jsonResult[$i]["csc_prod_desc"] = "";
			}else{ 
			$ca = $ci - 1; 
			$idesc = "";
			for ($i = 0; $i < $ca; $i++){
				$ambil = DB::select("select nama_kategori_en FROM csc_product WHERE id='".$icp[$i]."'");
				if(count($ambil) == 0){
					$nam = "";
				}else{
					foreach($ambil as $am){
						$nam = $am->nama_kategori_en;
					}
				}
				if($i == 0){
				$idesc = $idesc."".$nam;
				}else{
				$idesc = $idesc."-".$nam;
				}
			}
			$jsonResult[$i]["csc_prod_desc"] = $idesc;
			}
			*/
			
            $jsonResult[$i]["type_tracking"] = $daz29;
            $jsonResult[$i]["no_track"] = $daz30;
            $jsonResult[$i]["status_trx"] = $daz31;
            $id_csc = explode(",", $buy[$i]->id_csc_prod);
			$list_k = array();

            for ($a = 0; $a < count($id_csc); $a++) {
                if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
                    //$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
                    $list_k[] = $id_csc[$a];
                }
            }

            $getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
            $jsonResult[$i]["csc_prod_desc"] = $getName;

		}


        if ($buy) {
			/*
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
			$countall = count($buy2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function list_br_view(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
		$id_br = $request->id_br;
		$page = 1;
		$limit = 1;
        $buy = DB::table('csc_buying_request')
                    ->orderBy('csc_buying_request.id', 'DESC')
					->where('id', $id_br)
					->paginate($limit);
		$buy2 = DB::table('csc_buying_request')
                    ->orderBy('csc_buying_request.id', 'DESC')
					->where('id', $id_br)
					->get();
		

        $jsonResult = array();
        for ($i = 0; $i < count($buy); $i++) {
            if(!empty($buy[$i]->id_mst_country)){ $daz1 = $buy[$i]->id_mst_country; }else{ $daz1 = "0"; }
            if(!empty($buy[$i]->id_csc_prod_cat)){ $daz2 = $buy[$i]->id_csc_prod_cat; }else{ $daz2 = "0"; }
            if(!empty($buy[$i]->id_csc_prod_cat_level1)){ $daz3 = $buy[$i]->id_csc_prod_cat_level1; }else{ $daz3 = "0"; }
            if(!empty($buy[$i]->id_csc_prod_cat_level2)){ $daz4 = $buy[$i]->id_csc_prod_cat_level2; }else{ $daz4 = "0"; }
            if(!empty($buy[$i]->jenis_perihal_en)){ $daz5 = $buy[$i]->jenis_perihal_en; }else{ $daz5 = ""; }
            if(!empty($buy[$i]->subyek)){ $daz6 = $buy[$i]->subyek; }else{ $daz6 = ""; }
            if(!empty($buy[$i]->message)){ $daz7 = $buy[$i]->message; }else{ $daz7 = ""; }
            if(!empty($buy[$i]->files)){ $daz8 = $buy[$i]->files; }else{ $daz8 = ""; }
            if(!empty($buy[$i]->message_answer)){ $daz9 = $buy[$i]->message_answer; }else{ $daz9 = ""; }
            if(!empty($buy[$i]->file_answer)){ $daz10 = $buy[$i]->file_answer; }else{ $daz10 = ""; }
            if(!empty($buy[$i]->st_approve)){ $daz11 = $buy[$i]->st_approve; }else{ $daz11 = 0; }
            if(!empty($buy[$i]->city)){ $daz12 = $buy[$i]->city; }else{ $daz12 = ""; }
            if(!empty($buy[$i]->shipping)){ $daz13 = $buy[$i]->shipping; }else{ $daz13 = ""; }
            if(!empty($buy[$i]->spec)){ $daz14 = $buy[$i]->spec; }else{ $daz14 = ""; }
            if(!empty($buy[$i]->eo)){ $daz15 = $buy[$i]->eo; }else{ $daz15 = 0; }
            if(!empty($buy[$i]->neo)){ $daz16 = $buy[$i]->neo; }else{ $daz16 = ""; }
			if(!empty($buy[$i]->tp)){ $daz17 = $buy[$i]->tp; }else{ $daz17 = 0; }
            if(!empty($buy[$i]->ntp)){ $daz18 = $buy[$i]->ntp; }else{ $daz18 = ""; }
            if(!empty($buy[$i]->jenis_perihal_in)){ $daz19 = $buy[$i]->jenis_perihal_in; }else{ $daz19 = ""; }
            if(!empty($buy[$i]->jenis_perihal_chn)){ $daz20 = $buy[$i]->jenis_perihal_chn; }else{ $daz20 = ""; }
            if(!empty($buy[$i]->message_perihal_en)){ $daz21 = $buy[$i]->message_perihal_en; }else{ $daz21 = ""; }
            if(!empty($buy[$i]->message_perihal_in)){ $daz22 = $buy[$i]->message_perihal_in; }else{ $daz22 = ""; }
            if(!empty($buy[$i]->message_perihal_chn)){ $daz23 = $buy[$i]->message_perihal_chn; }else{ $daz23 = ""; }
            if(!empty($buy[$i]->subyek_en)){ $daz24 = $buy[$i]->subyek_en; }else{ $daz24 = ""; }
            if(!empty($buy[$i]->subyek_in)){ $daz25 = $buy[$i]->subyek_in; }else{ $daz25 = ""; }
            if(!empty($buy[$i]->subyek_chn)){ $daz26 = $buy[$i]->subyek_chn; }else{ $daz26 = ""; }
            if(!empty($buy[$i]->deal)){ $daz27 = $buy[$i]->deal; }else{ $daz27 = 0; }
            // if(!empty($buy[$i]->id_csc_prod)){ $daz28 = $buy[$i]->id_csc_prod; }else{ $daz28 = ""; }
            if(!empty($buy[$i]->type_tracking)){ $daz29 = $buy[$i]->type_tracking; }else{ $daz29 = ""; }
            if(!empty($buy[$i]->no_track)){ $daz30 = $buy[$i]->no_track; }else{ $daz30 = ""; }
            if(!empty($buy[$i]->status_trx)){ $daz31 = $buy[$i]->status_trx; }else{ $daz31 = ""; }
            if(!empty($buy[$i]->status)){ $daz32 = $buy[$i]->status; }else{ $daz32 = 0; }
            $jsonResult[$i]["id"] = $buy[$i]->id;
            $jsonResult[$i]["id_mst_country"] = $daz1;
            $jsonResult[$i]["id_csc_prod_cat"] = $daz2;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $daz3;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $daz4;
            $jsonResult[$i]["jenis_perihal_en"] = $daz5;
            $jsonResult[$i]["subyek"] = $daz6;
            $jsonResult[$i]["message"] = $daz7;
            $jsonResult[$i]["files"] = $daz8;
            $jsonResult[$i]["message_answer"] = $daz9;
            $jsonResult[$i]["file_answer"] = $daz10;
            $jsonResult[$i]["date"] = $buy[$i]->date;
            $jsonResult[$i]["st_approve"] = $daz11;
            $jsonResult[$i]["date_approve"] = $buy[$i]->date_approve;
            $jsonResult[$i]["date_answer"] = $buy[$i]->date_answer;
            $jsonResult[$i]["by_role"] = $buy[$i]->by_role;
			if($buy[$i]->by_role == 1){
				$jsonResult[$i]["role_desc"] = "Admin";
			}else if($buy[$i]->by_role == 4){
				$jsonResult[$i]["role_desc"] = "Representative";
			}else if($buy[$i]->by_role == 3){
				$jsonResult[$i]["role_desc"] = "Importer";
			}else{
				$jsonResult[$i]["role_desc"] = "";
			}
			
            $jsonResult[$i]["id_pembuat"] = $buy[$i]->id_pembuat;
            $jsonResult[$i]["city"] = $daz12;
            $jsonResult[$i]["shipping"] = $daz13;
            $jsonResult[$i]["spec"] = $daz14;
            $jsonResult[$i]["eo"] = $daz15;
            $jsonResult[$i]["neo"] = $daz16;
            $jsonResult[$i]["tp"] = $daz17;
            $jsonResult[$i]["ntp"] = $daz18;
            $jsonResult[$i]["valid"] = $buy[$i]->valid;
            if ($buy[$i]->valid == 0) {
                $jsonResult[$i]["valid_desc"] = 'No Limit';
            } else {
                $jsonResult[$i]["valid_desc"] = 'Valid ' . $buy[$i]->valid . " days";
            }
            $jsonResult[$i]["status"] = $daz32;
            if ($buy[$i]->status == null || $buy[$i]->status == 0 || empty($buy[$i]->status) || $buy[$i]->status == 1) {
                $jsonResult[$i]["status_desc"] = "Negosiation";
            } else if ($buy[$i]->status == 4) {
                $jsonResult[$i]["status_desc"] = "Deal";
            }
            $jsonResult[$i]["jenis_perihal_in"] = $daz19;
            $jsonResult[$i]["jenis_perihal_chn"] = $daz20;
            $jsonResult[$i]["message_perihal_en"] = $daz21;
            $jsonResult[$i]["message_perihal_in"] = $daz22;
            $jsonResult[$i]["message_perihal_chn"] = $daz23;
            $jsonResult[$i]["subyek_en"] = $daz24;
            $jsonResult[$i]["subyek_in"] = $daz25;
            $jsonResult[$i]["subyek_chn"] = $daz26;
            $jsonResult[$i]["deal"] = $daz27;
            // $jsonResult[$i]["id_csc_prod"] = $daz28;
			/*
			$icp = explode(",",$buy[$i]->id_csc_prod);
			
			$ci = count($icp);
			if($ci == 0){ $ca = 0; 
			$jsonResult[$i]["csc_prod_desc"] = "";
			}else{ 
			$ca = $ci - 1; 
			$idesc = "";
			for ($i = 0; $i < $ca; $i++){
				$ambil = DB::select("select nama_kategori_en FROM csc_product WHERE id='".$icp[$i]."'");
				if(count($ambil) == 0){
					$nam = "";
				}else{
					foreach($ambil as $am){
						$nam = $am->nama_kategori_en;
					}
				}
				if($i == 0){
				$idesc = $idesc."".$nam;
				}else{
				$idesc = $idesc."-".$nam;
				}
			}
			$jsonResult[$i]["csc_prod_desc"] = $idesc;
			}
			*/
			
            $jsonResult[$i]["type_tracking"] = $daz29;
            $jsonResult[$i]["no_track"] = $daz30;
            $jsonResult[$i]["status_trx"] = $daz31;
            $id_csc = explode(",", $buy[$i]->id_csc_prod);
			$list_k = array();

            for ($a = 0; $a < count($id_csc); $a++) {
                if (!empty($id_csc[$a]) || $id_csc[$a] != null) {
                    //$getNama = DB::table('csc_product')->where('id', $id_csc[$a])->select("nama_kategori_en")->first();
                    $list_k[] = $id_csc[$a];
                }
            }

            $getName = DB::table('csc_product')->whereIn('id', $list_k)->select("nama_kategori_en")->get();
            $jsonResult[$i]["csc_prod_desc"] = $getName;

		}


        if ($buy) {
			/*
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
			$countall = count($buy2);
			$bagi = $countall / $limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function list_br_join(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
		$id_br = $request->id_br;
        $page = $request->page;
		$limit = $request->limit;
        /*$buy = DB::select("select a.*,a.id as idjoin,b.*,c.* from csc_buying_request_join a, itdp_company_users b, itdp_profil_eks c 
		where a.id_eks = b.id and b.id_profil = c.id and a.id_br='".$request->id_br."' "); */
		$buy = DB::table('csc_buying_request_join as a')
                    ->join('itdp_company_users as b', 'b.id', '=', 'a.id_eks')
                    ->join('itdp_profil_eks as c', 'c.id', '=', 'b.id_profil')
                    ->selectRaw('a.*, a.id as idjoin, b.*, c.*')
                    ->where('a.id_br', '=', $id_br)
                    //->orderBy('a.created_at', 'DESC')
					->paginate($limit);
		$buy2 = DB::table('csc_buying_request_join as a')
                    ->join('itdp_company_users as b', 'b.id', '=', 'a.id_eks')
                    ->join('itdp_profil_eks as c', 'c.id', '=', 'b.id_profil')
                    ->selectRaw('a.*, a.id as idjoin, b.*, c.*')
                    ->where('a.id_br', '=', $id_br)
                    //->orderBy('a.created_at', 'DESC')
					->get();
		//echo count($buy);die();

        $jsonResult = array();
        for ($i = 0; $i < count($buy); $i++) {
            
            $jsonResult[$i]["id"] = $buy[$i]->idjoin;
            $jsonResult[$i]["id_br"] = $buy[$i]->id_br;
            $jsonResult[$i]["date"] = $buy[$i]->date;
            $jsonResult[$i]["expired_at"] = $buy[$i]->expired_at;
            if ($buy[$i]->status_join == 1) {
                $jsonResult[$i]["status_j"] = 'Join';
            }else if ($buy[$i]->status_join == 2) {
                $jsonResult[$i]["status_j"] = 'Negosiation';
            }else if ($buy[$i]->status_join == 4) {
                $jsonResult[$i]["status_j"] = 'Deal';
            } else {
                $jsonResult[$i]["status_j"] = '-';
            }
            $jsonResult[$i]["email"] = $buy[$i]->email;
            $jsonResult[$i]["username"] = $buy[$i]->username;
            $jsonResult[$i]["id_profil"] = $buy[$i]->id_profil;
            $jsonResult[$i]["company"] = $buy[$i]->company;
            
		}


        if ($buy) {

           /* $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
			*/
			$countall = count($buy2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function list_br_chat(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
        $buy = DB::select("select * from csc_buying_request_chat where id_join='".$request->id_join."' order by tanggal desc");
		//echo count($buy);die();

        $jsonResult = array();
        for ($i = 0; $i < count($buy); $i++) {
            
            $jsonResult[$i]["id"] = $buy[$i]->id;
            $jsonResult[$i]["id_br"] = $buy[$i]->id_br;
            $jsonResult[$i]["id_join"] = $buy[$i]->id_join;
            $jsonResult[$i]["date"] = $buy[$i]->tanggal;
            $jsonResult[$i]["id_pengirim"] = $buy[$i]->id_pengirim;
            $jsonResult[$i]["id_role"] = $buy[$i]->id_role;
            $jsonResult[$i]["username_pengirim"] = $buy[$i]->username_pengirim;
            $jsonResult[$i]["pesan"] = $buy[$i]->pesan;
            
		}


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
	
	public function br_admin_save(Request $request)
    {
        $kumpulcat = "";
        date_default_timezone_set('Asia/Jakarta');
        $g = count($request->category);
        for ($a = 0; $a < $g; $a++) {
            $kumpulcat = $kumpulcat . $request->category[$a] . ",";
        }
		
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
            'date' => date('Y-m-d H:i:s'),
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

    public function listCompany(Request $request)
    {
        $listCompany = DB::table('itdp_company_users')
                        ->select('itdp_company_users.id','id_profil', 'foto_profil', 'company', 'province_in', 'itdp_company_users.email', 'postcode', 'phone', 'agree', 'itdp_company_users.status')
                        ->leftJoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
                        ->leftJoin('mst_province', 'itdp_profil_eks.id_mst_province', '=', 'mst_province.id')
                        ->where("id_role", 2)
                        ->limit(10)
                        ->offset($request->offset)
                        ->get();

        $i = 0;
        foreach ($listCompany as $dataCom) {
            $last_activity = DB::table('log_user')
                                ->select('date', 'waktu', 'keterangan')
                                ->where('id_user', $dataCom->id)
                                ->orderBy('id_log', 'DESC')
                                ->limit(1)
                                ->first();

            if (isset($last_activity)) {
                $listCompany[$i]->last_activity = isset($last_activity->date) ? $last_activity->date : '' . ' ' . isset($last_activity->waktu) ? $last_activity->waktu : '' . ' ' . isset($last_activity->keterangan) ? $last_activity->keterangan : '';
            } else {
                $listCompany[$i]->last_activity = "No Action";
            }

            if (isset($dataCom->foto_profil)) {
                $listCompany[$i]->foto_profil = url('uploads/Profile/Eksportir/' . $dataCom->id . '/' . $dataCom->foto_profil);
            }

            $listCompany[$i]->email_confirmation = ($dataCom->id == 1) ? 'Yes' : 'No';

            if ($dataCom->status == 1) {
                $verif_by_admin = 'Verified';
            } else if ($dataCom->status == 2) {
                $verif_by_admin = 'Not Verified';
            } else {
                $verif_by_admin = 'Wait Administrator';
            }

            $listCompany[$i]->verif_by_admin = $verif_by_admin;

            $i++;
        }

        if ($listCompany) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $listCompany;
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

    public function listProductCompany(Request $request)
    {
        $listProductCompany = DB::table('csc_product_single')
                        ->select('csc_product_single.id', 'image_1', 'prodname_en', 'price_usd', 'csc_product_single.status')
                        ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
                        ->where('itdp_company_users.id_profil', $request->id)
                        ->limit(10)
                        ->offset($request->offset)
                        ->get();

        $i = 0;
        foreach ($listProductCompany as $dataPro) {
            if (isset($dataPro->image_1)) {
                $listProductCompany[$i]->image_1 = url('uploads/Eksportir_Product/Image/' . $dataPro->id . '/' . $dataPro->image_1);
            }

            if($dataPro->status == 1){
                $listProductCompany[$i]->label_status = "Publish - Not Verified";
            }else if($dataPro->status == 2){
                $listProductCompany[$i]->label_status = "Publish - Verified";
            }else if($dataPro->status == 3){
                $listProductCompany[$i]->label_status = "Publish - Verification Rejected";
            }else if($dataPro->status == 9){
                $listProductCompany[$i]->label_status = "Unpublish - Verified";
            }else{
                $listProductCompany[$i]->label_status = "Hide";
            }
            $i++;
        }

        if ($listProductCompany) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $listProductCompany;
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

    public function detailCompany(Request $request)
    {
        $detailCompany = DB::table('itdp_company_users')
                        ->select('itdp_company_users.id', 'foto_profil', 'company', 'province_in')
                        ->leftJoin('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
                        ->leftJoin('mst_province', 'mst_province.id', '=', 'itdp_profil_eks.id_mst_province')
                        ->where('itdp_company_users.id_profil', $request->id)
                        ->first();
        if (isset($detailCompany->foto_profil)) {
            $detailCompany->foto_profil = url('uploads/Profile/Eksportir/' . $detailCompany->id . '/' . $detailCompany->foto_profil);
        }

        if ($detailCompany) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $detailCompany;
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
	
	public function activate_product(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
            $id_user = $request->id_user;
            $id_product = $request->id_product;
			$verifikasi = $request->verifikasi;
			$keterangan = $request->keterangan;
			$id_csc_product = $request->id_csc_product;
            $id_csc_product_level1 = $request->id_csc_product_level1;
            $id_csc_product_level2 = $request->id_csc_product_level2;
            $datenow = date("Y-m-d H:i:s");

            $data = DB::table('csc_product_single')->where('id', $id_product)->first();
			$carieks = DB::select("select email from itdp_company_users where id='".$data->id_itdp_company_user."'");
			foreach($carieks as $teks){
				$maileks = $teks->email;
			}
            
            // var_dump($verifikasi);
            if($verifikasi == '1'){
                $status = 2;
                $ket = "This product has been added on the front page";
                $notifnya = "has been accepted";
				$ket = "Your product ".$data->prodname_en." got verified";
				$ket2 = $data->prodname_en." has been accepted by Super Admin";

				$insertnotif = DB::table('notif')->insert([
                            'dari_nama' => 'Super Admin',
                            'dari_id' => 1,
                            'untuk_nama' => 'Eksportir',
                            'untuk_id' => $data->id_itdp_company_user,
                            'keterangan' => $ket2,
                            'url_terkait' => 'eksportir/product_view',
                            'id_terkait' => $id_product,
                            'status_baca' => 0,
                            'waktu' => $datenow,
                            'to_role' => 2,
                        ]);
    
	
			$data33 = [
            'email' => "",
            'email1' => $maileks,
            'username' => $data->prodname_en,
            'main_messages' => "",
            'id' => $id_product
			];
			
			Mail::send('UM.user.sendproduct2', $data33, function ($mail) use ($data33) {
                $mail->to($data33['email1'], $data33['username']);
                $mail->subject("Your product got verified");
            });
			
            }else{
                
                // var_dump($keterangan);
                $status = 3;
                $ket = "The product that you added cannot be displayed on the front page because ".$keterangan;
                $notifnya = "has been declined";
            }

            // var_dump($status);
            // var_dump($ket);
            // die();
            $update = DB::table('csc_product_single')->where('id', $id_product)->update([
                'id_csc_product' => $id_csc_product,
                'id_csc_product_level1' => $id_csc_product_level1,
                'id_csc_product_level2' => $id_csc_product_level2,
                'status' => $status,
                'keterangan' => $ket,
                'updated_at' => $datenow,
            ]);

            if($update){
                $pengirim = DB::table('itdp_admin_users')->where('id', $id_user)->first();
                $notif = DB::table('notif')->insert([
                    'dari_nama' => $pengirim->name,
                    'dari_id' => $id_user,
                    'untuk_nama' => getCompanyName($data->id_itdp_company_user),
                    'untuk_id' => $data->id_itdp_company_user,
                    'keterangan' => 'Product '.$data->prodname_en.' '.$notifnya.' by Admin',
                    'url_terkait' => 'eksportir/product_view',
                    'status_baca' => 0,
                    'waktu' => $datenow,
                    'id_terkait' => $id_product,
                    'to_role' => 2,
                ]);
            }
			
			if($update){
				$meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
			}else{
				$meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
			}
        
		
	}
	
	public function list_eksportir(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		$data = DB::table('itdp_company_users')
		->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
		->select('itdp_company_users.id','itdp_company_users.id_profil','itdp_company_users.foto_profil','itdp_profil_eks.badanusaha','itdp_profil_eks.company','itdp_company_users.email'
		,'itdp_profil_eks.addres','itdp_profil_eks.city','itdp_profil_eks.postcode','itdp_profil_eks.phone','itdp_profil_eks.fax')
		->where('id_role', 2)
		->orderBy('itdp_company_users.created_at', 'desc')
		->paginate($limit);
        //->limit(10)
        //->offset($offset)
        //->get();
		
		$data2 = DB::table('itdp_company_users')
		->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
		->where('id_role', 2)
		->orderBy('itdp_company_users.created_at', 'desc')
        ->get();
		
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_profil"] = $data[$i]->id_profil;
            $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
            $jsonResult[$i]["company"] = $data[$i]->company;
            $jsonResult[$i]["email"] = $data[$i]->email;
            $jsonResult[$i]["addres"] = $data[$i]->addres;
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["postcode"] = $data[$i]->postcode;
            $jsonResult[$i]["phone"] = $data[$i]->phone;
            $jsonResult[$i]["fax"] = $data[$i]->fax;
            $jsonResult[$i]["foto_profil"] = $path = ($data[$i]->foto_profil) ? url('uploads/Profile/Eksportir/' . $data[$i]->id . '/' . $data[$i]->foto_profil) : url('image/nia-01-01.jpg');            
			
        }
		
		if ($data) {
			$countall = count($data2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function list_importir(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		$data = DB::table('itdp_company_users')
		->join('itdp_profil_imp', 'itdp_profil_imp.id', '=', 'itdp_company_users.id_profil')
		->select('itdp_company_users.id','itdp_company_users.id_profil','itdp_company_users.foto_profil','itdp_profil_imp.badanusaha','itdp_profil_imp.company','itdp_company_users.email'
		,'itdp_profil_imp.addres','itdp_profil_imp.city','itdp_profil_imp.postcode','itdp_profil_imp.phone','itdp_profil_imp.fax')
		->where('id_role', 3)
		->orderBy('itdp_company_users.created_at', 'desc')
		->paginate($limit);
        //->limit(10)
        //->offset($offset)
        //->get();
		
		$data2 = DB::table('itdp_company_users')
		->join('itdp_profil_imp', 'itdp_profil_imp.id', '=', 'itdp_company_users.id_profil')
		->where('id_role', 3)
		->orderBy('itdp_company_users.created_at', 'desc')
        ->get();
		
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_profil"] = $data[$i]->id_profil;
            $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
            $jsonResult[$i]["company"] = $data[$i]->company;
            $jsonResult[$i]["email"] = $data[$i]->email;
            $jsonResult[$i]["addres"] = $data[$i]->addres;
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["postcode"] = $data[$i]->postcode;
            $jsonResult[$i]["phone"] = $data[$i]->phone;
            $jsonResult[$i]["fax"] = $data[$i]->fax;
            $jsonResult[$i]["foto_profil"] = $path = ($data[$i]->foto_profil) ? url('uploads/Profile/Importir/' . $data[$i]->id . '/' . $data[$i]->foto_profil) : url('image/nia-01-01.jpg');            
			
        }
		
		if ($data) {
			$countall = count($data2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function unapprove_eksportir(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		$data = DB::table('itdp_company_users')
		->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
		->select('itdp_company_users.id','itdp_company_users.id_profil','itdp_company_users.foto_profil','itdp_profil_eks.badanusaha','itdp_profil_eks.company','itdp_company_users.email'
		,'itdp_profil_eks.addres','itdp_profil_eks.city','itdp_profil_eks.postcode','itdp_profil_eks.phone','itdp_profil_eks.fax')
		->where('itdp_company_users.id_role', 2)
		->where('itdp_company_users.status', 0)
		->orwhere('itdp_company_users.status', "")
		->orwhereNull('itdp_company_users.status')
		->orderBy('itdp_company_users.id', 'desc')
		->paginate($limit);
        //->limit(10)
        //->offset($offset)
        //->get();
		
		$data2 = DB::table('itdp_company_users')
		->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
		->where('id_role', 2)
		->orderBy('itdp_company_users.created_at', 'desc')
        ->get();
		
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_profil"] = $data[$i]->id_profil;
            $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
            $jsonResult[$i]["company"] = $data[$i]->company;
            $jsonResult[$i]["email"] = $data[$i]->email;
            $jsonResult[$i]["addres"] = $data[$i]->addres;
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["postcode"] = $data[$i]->postcode;
            $jsonResult[$i]["phone"] = $data[$i]->phone;
            $jsonResult[$i]["fax"] = $data[$i]->fax;
            $jsonResult[$i]["foto_profil"] = $path = ($data[$i]->foto_profil) ? url('uploads/Profile/Eksportir/' . $data[$i]->id . '/' . $data[$i]->foto_profil) : url('image/nia-01-01.jpg');            
			
        }
		
		if ($data) {
			$countall = count($data2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function unapprove_importir(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		$data = DB::table('itdp_company_users')
		->join('itdp_profil_imp', 'itdp_profil_imp.id', '=', 'itdp_company_users.id_profil')
		->select('itdp_company_users.id','itdp_company_users.id_profil','itdp_company_users.foto_profil','itdp_profil_imp.badanusaha','itdp_profil_imp.company','itdp_company_users.email'
		,'itdp_profil_imp.addres','itdp_profil_imp.city','itdp_profil_imp.postcode','itdp_profil_imp.phone','itdp_profil_imp.fax')
		->where('id_role', 3)
		->where('itdp_company_users.status', 0)
		->orwhere('itdp_company_users.status', "")
		->orwhere('itdp_company_users.status', null)
		->orwhereNull('itdp_company_users.status')
		->orderBy('itdp_company_users.id', 'desc')
		->paginate($limit);
        //->limit(10)
        //->offset($offset)
        //->get();
		
		$data2 = DB::table('itdp_company_users')
		->join('itdp_profil_imp', 'itdp_profil_imp.id', '=', 'itdp_company_users.id_profil')
		->where('id_role', 3)
		->orderBy('itdp_company_users.created_at', 'desc')
        ->get();
		
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_profil"] = $data[$i]->id_profil;
            $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
            $jsonResult[$i]["company"] = $data[$i]->company;
            $jsonResult[$i]["email"] = $data[$i]->email;
            $jsonResult[$i]["addres"] = $data[$i]->addres;
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["postcode"] = $data[$i]->postcode;
            $jsonResult[$i]["phone"] = $data[$i]->phone;
            $jsonResult[$i]["fax"] = $data[$i]->fax;
            $jsonResult[$i]["foto_profil"] = $path = ($data[$i]->foto_profil) ? url('uploads/Profile/Importir/' . $data[$i]->id . '/' . $data[$i]->foto_profil) : url('image/nia-01-01.jpg');            
			
        }
		
		if ($data) {
			$countall = count($data2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function saveapprove(Request $request)
    {
		
        date_default_timezone_set('Asia/Jakarta');
		$id = $request->id;
		$status = $request->status;
        $update = DB::select("update itdp_company_users set status='".$status."' where id='" . $id . "'");
        if ($update) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '';
            $res['meta'] = $meta;
            //$res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            //$res['data'] = $data;
            return $res;
        }

    }
	
	public function search_eksportir(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		$search = $request->search;
		$data = DB::table('itdp_company_users')
		->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
		->select('itdp_company_users.id','itdp_company_users.id_profil','itdp_company_users.foto_profil','itdp_profil_eks.badanusaha','itdp_profil_eks.company','itdp_company_users.email'
		,'itdp_profil_eks.addres','itdp_profil_eks.city','itdp_profil_eks.postcode','itdp_profil_eks.phone','itdp_profil_eks.fax')
		->where('id_role', 2)
		->where('itdp_company_users.username', 'like', '%' . $search . '%')
		->where('itdp_company_users.email', 'like', '%' . $search . '%')
		->orwhere('itdp_profil_eks.company', 'like', '%' . $search . '%')
		->orwhere('itdp_profil_eks.addres', 'like', '%' . $search . '%')
		->orwhere('itdp_profil_eks.city', 'like', '%' . $search . '%')
		->orderBy('itdp_company_users.created_at', 'desc')
		->paginate($limit);
        //->limit(10)
        //->offset($offset)
        //->get();
		
		$data2 = DB::table('itdp_company_users')
		->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
		->where('id_role', 2)
		->orderBy('itdp_company_users.created_at', 'desc')
        ->get();
		
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_profil"] = $data[$i]->id_profil;
            $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
            $jsonResult[$i]["company"] = $data[$i]->company;
            $jsonResult[$i]["email"] = $data[$i]->email;
            $jsonResult[$i]["addres"] = $data[$i]->addres;
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["postcode"] = $data[$i]->postcode;
            $jsonResult[$i]["phone"] = $data[$i]->phone;
            $jsonResult[$i]["fax"] = $data[$i]->fax;
            $jsonResult[$i]["foto_profil"] = $path = ($data[$i]->foto_profil) ? url('uploads/Profile/Eksportir/' . $data[$i]->id . '/' . $data[$i]->foto_profil) : url('image/nia-01-01.jpg');            
			
        }
		
		if ($data) {
			$countall = count($data2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function search_importir(Request $request)
    {
		$page = $request->page;
		$limit = $request->limit;
		$search = $request->search;
		$data = DB::table('itdp_company_users')
		->join('itdp_profil_imp', 'itdp_profil_imp.id', '=', 'itdp_company_users.id_profil')
		->select('itdp_company_users.id','itdp_company_users.id_profil','itdp_company_users.foto_profil','itdp_profil_imp.badanusaha','itdp_profil_imp.company','itdp_company_users.email'
		,'itdp_profil_imp.addres','itdp_profil_imp.city','itdp_profil_imp.postcode','itdp_profil_imp.phone','itdp_profil_imp.fax')
		->where('id_role', 3)
		->where('itdp_company_users.username', 'like', '%' . $search . '%')
		->where('itdp_company_users.email', 'like', '%' . $search . '%')
		->orwhere('itdp_profil_imp.company', 'like', '%' . $search . '%')
		->orwhere('itdp_profil_imp.addres', 'like', '%' . $search . '%')
		->orwhere('itdp_profil_imp.city', 'like', '%' . $search . '%')
		->orderBy('itdp_company_users.created_at', 'desc')
		->paginate($limit);
        //->limit(10)
        //->offset($offset)
        //->get();
		
		$data2 = DB::table('itdp_company_users')
		->join('itdp_profil_imp', 'itdp_profil_imp.id', '=', 'itdp_company_users.id_profil')
		->where('id_role', 3)
		->orderBy('itdp_company_users.created_at', 'desc')
        ->get();
		
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["id_profil"] = $data[$i]->id_profil;
            $jsonResult[$i]["badanusaha"] = $data[$i]->badanusaha;
            $jsonResult[$i]["company"] = $data[$i]->company;
            $jsonResult[$i]["email"] = $data[$i]->email;
            $jsonResult[$i]["addres"] = $data[$i]->addres;
            $jsonResult[$i]["city"] = $data[$i]->city;
            $jsonResult[$i]["postcode"] = $data[$i]->postcode;
            $jsonResult[$i]["phone"] = $data[$i]->phone;
            $jsonResult[$i]["fax"] = $data[$i]->fax;
            $jsonResult[$i]["foto_profil"] = $path = ($data[$i]->foto_profil) ? url('uploads/Profile/Importir/' . $data[$i]->id . '/' . $data[$i]->foto_profil) : url('image/nia-01-01.jpg');            
			
        }
		
		if ($data) {
			$countall = count($data2);
			$bagi = $countall / $request->limit;
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
			
			$data = [
                'page' => $request->page,
                'total_results' => $countall,
                'total_pages' => ceil($bagi),
                'results' => $jsonResult
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
	
	public function bc_admin(Request $request)
    {
		$id = $request->id_br;
		date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
		/*
		$insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('".$id."','40001','".Date('Y-m-d H:m:s')."')");
		$update = DB::select("update csc_buying_request set status='1' where id='".$id."'");
        return redirect('br_list');
		*/
		$cariprod = DB::select("select * from csc_buying_request where id='".$id."'");
		foreach($cariprod as $prodcari) { $rrr = $prodcari->id_csc_prod; $zzz = $prodcari->id_pembuat; }
		$namacom = DB::select("select * from itdp_admin_users where id='".$zzz."'");
		foreach($namacom as $comnama){ $namapembuat = $comnama->name; }
		$cr = explode(',',$rrr);
		$hitung = count($cr);
		$semuacat = "";
		
		for($a = 0; $a < ($hitung - 1); $a++){
		//echo $rrr;die();
		// echo "select * from csc_product_single where id_csc_product='".$cr[0]."' or id_csc_product_level1='".$cr[0]."' or id_csc_product_level2='".$cr[0]."'";die();
//		$namaprod = DB::select("select * from csc_product_single where id_csc_product='".$cr[$a]."' or id_csc_product_level1='".$cr[$a]."' or id_csc_product_level2='".$cr[$a]."' ");
		
		$namaprod = DB::select("select * from csc_product_single where id_csc_product='".$cr[$hitung-2]."' or id_csc_product_level1='".$cr[$hitung-2]."' or id_csc_product_level2='".$cr[$hitung-2]."' ");
		
		if(count($namaprod) == 0){
		
		}else{
		
		foreach($namaprod as $prod){
		    $napro = $prod->id_itdp_company_user;
			
//            dd($napro);
            $cekada=DB::select("select * from csc_buying_request_join where id_br='".$id."' and id_eks='".$napro."'");
//			$cekada=DB::select("select * from csc_buying_request_join where id_br='".$id."' and id_eks='".$napro."'");
			if(count($cekada) == 0){
				
				$insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
							('".$id."','".(int)$napro."','".Date('Y-m-d H:m:s')."')");
				
				//NOTIF
				
				$id_terkait = "";
				$ket = "Buying Request created by ".$namapembuat;
				$insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
					('2','".$namapembuat."','".$zzz."','Eksportir','".$napro."','".$ket."','br_list','".$id_terkait."','".$date."','0')
				");
				
				//END NOTIF
				//EMAIL
				
				$caridataeks = DB::select("select * from itdp_company_users where id='".$napro."'");
				if(count($caridataeks) != 0){
				foreach($caridataeks as $vm){ $vc1 = $vm->email; }
                $datacomeks = DB::select("select * from itdp_profil_eks where id = '".$vm->id_profil."'");
				$data = [
				    'username' => $namapembuat,
                    'id2' => '0', 'nama' => $namapembuat,
                    'password' => '',
                    'email' => $vc1,
                    'company' => $datacomeks[0]->company,
                    'bu' => $datacomeks[0]->badanusaha,
                ];
                Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['company']);
                    $mail->subject('Buying Was Created');
                });
				}
				
				//END EMAIL
				if($insert){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
			}else{
				$meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
				
			}
		}
		
		}
		}
		
		
	}
}
