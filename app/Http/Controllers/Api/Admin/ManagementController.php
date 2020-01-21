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
        $buy = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request order by id desc ");
		//echo count($buy);die();

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

}
