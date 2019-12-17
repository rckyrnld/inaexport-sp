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

    public function getRekapAnggota()
    {
        // dd(auth()->authenticate());
        $data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
        $eksportirs = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
            ->where('itdp_company_users.id_role', '2')
            ->select('itdp_company_users.*', 'itdp_profil_eks.*')
            ->orderBy('itdp_company_users.id', 'desc')->skip($request->skip)
            ->take($request->take)->get();
        $importirs = DB::table('itdp_company_users')
            ->leftJoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
            ->where('itdp_company_users.id_role', '3')
            ->select('itdp_company_users.*', 'itdp_profil_imp.*')
            ->orderBy('itdp_company_users.id', 'desc')->skip($request->skip)
            ->take($request->take)->get();
        $data = ['importirs' => $importirs, 'eksportirs' => $eksportirs];
        $dataResult = $this->customPaginate($data, $pageNya);
        if (count($eksportirs) > 0 && count($importirs) > 0) {
            $res['message'] = "Success";
            $res['data'] = $dataResult;
            $res['status_code'] = 200;
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }

    public function detailVerifikasiImportir(Request $request)
    {
        $companyUsers = DB::select("select * from itdp_company_users where id='$request->id' limit 1");

        $detailCompanyUsers = DB::select("select b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$request->id' limit 1");

        if ((count($companyUsers) > 0) && (count($detailCompanyUsers) > 0)) {
            $res['message'] = "Success";
            $result = ['companyUser' => $companyUsers, 'profilUser' => $detailCompanyUsers];
            $res['data'] = $result;
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }

    public function detailVerifikasiEksportir(Request $request)
    {
        $companyUsers = DB::select("select * from itdp_company_users where id='$request->id' limit 1");

        $detailCompanyUsers = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$request->id' limit 1");

        if ((count($companyUsers) > 0) && (count($detailCompanyUsers) > 0)) {
            $res['message'] = "Success";
            $result = ['companyUser' => $companyUsers, 'profilUser' => $detailCompanyUsers];
            $res['data'] = $result;
            return response($res);
        } else {
            $res['message'] = "Failed";
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

}
