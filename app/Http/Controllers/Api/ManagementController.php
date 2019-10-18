<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Routing\Helpers;
use App\Models\ContactUs;

class ManagementController extends Controller
{
	use Helpers;

    public function __construct()
    {
        $this->middleware('api.auth');
		}

    public function getRekapAnggota(){

		$eksportirs = DB::select(
			"select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a LEFT JOIN
			itdp_profil_eks b ON a.id_profil = b.id where a.id_role='2' order by a.id desc ");
		$importirs = DB::select(
			"select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a LEFT JOIN 
			itdp_profil_imp b ON a.id_profil = b.id where a.id_role='3' order by a.id desc ");
	   
		if(count($eksportirs) > 0 && count($importirs) > 0){
			$res['message'] = "Success";
			$res['data'] = ["importirs" => $importirs, "eksportirs" => $eksportirs];
        	return response($res);
		}else{
			$res['message'] = "Failed";
			return response($res);
		}
	}

    public function detailVerifikasiImportir($id){
		$companyUsers = DB::select("select * from itdp_company_users where id='$id' limit 1");
	
		$detailCompanyUsers = DB::select("select b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='$id' limit 1");
		
		if((count($companyUsers) > 0) && (count($detailCompanyUsers) > 0)){
			$res['message'] = "Success";
			$result = ['companyUser'=>$companyUsers, 'profilUser'=>$detailCompanyUsers];
			$res['data'] = $result;
			return response($res);
		}else{
			$res['message'] = "Failed";
			return response($res);
		}
	}
	
	public function detailVerifikasiEksportir($id){
		$companyUsers = DB::select("select * from itdp_company_users where id='$id' limit 1");
	
		$detailCompanyUsers = DB::select("select b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and a.id='$id' limit 1");
		
		if((count($companyUsers) > 0) && (count($detailCompanyUsers) > 0)){
			$res['message'] = "Success";
			$result = ['companyUser'=>$companyUsers, 'profilUser'=>$detailCompanyUsers];
			$res['data'] = $result;
			return response($res);
		}else{
			$res['message'] = "Failed";
			return response($res);
		}
    }

    public function submitVerifikasiImportir(Request $request){
        $id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;

		$isTrue1 = false;
		$isTrue2 = false;
		$isTrue3 = false;
		//UPDATE TAB 1
		if($request->password == null ){
			$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', email='".$request->email."', status='".$request->staim."' where id='".$request->id_user."' ");
			$isTrue1 = true;
		}else{
			$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', password='".bcrypt($request->password)."', status='".$request->staim."', email='".$request->email."' where id='".$request->id_user."' ");
			$isTrue1 = true;
		}
		//UPDATE TAB 2
		if($id_role == 2){
			$updatetab2 = DB::select("update itdp_profil_eks set company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
			, id_mst_province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' 
			where id='".$id_user_b."'");
			$isTrue2 = true;
		}else{
			$updatetab2 = DB::select("update itdp_profil_imp set company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
			, province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' 
			where id='".$id_user_b."'");
			$isTrue2 = true;
		}
		
		//UPDATE TAB 3
		if($id_role == 2){
			if($request->npwp == null){
				
				$isTrue3 = false;
			}else{
				$updatetab2 = DB::select("update itdp_profil_eks set npwp='".$request->npwp."', tdp='".$request->tanda_daftar."', siup='".$request->siup."' , doc='1.jpg' 
				, upduserid='".$request->situ."' , id_eks_business_size='".$request->scoope."', id_business_role_id='".$request->tob."', employe='".$request->employee."', status='".$request->staim."' 
				where id='".$id_user_b."'");
				
				$isTrue3 = true;
			}
		}
		if($isTrue1 && $isTrue2 && $isTrue3){
			$res['message'] = "Success";
			return response($res);
		}else{
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
		if(empty($request->file('foto_profil'))){
			$file = "";
			$isTrue1 = true;
		}else{
			$file = $request->file('foto_profil')->getClientOriginalName();
			$destinationPath = public_path() . "/image/fotoprofil";
			$request->file('foto_profil')->move($destinationPath, $file);
			$updatetab12 = DB::select("update itdp_company_users set foto_profil='".$file."'  where id='".$request->id_user."' ");
			$updatetab22 = DB::select("update itdp_profil_imp set logo='".$file."' where id='".$id_user_b."'");
			$isTrue1 = true;
		}
		
		//UPDATE TAB 1
		if($request->password == null ){
			$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', email='".$request->email."', status='".$request->staim."'  where id='".$request->id_user."' ");
			$isTrue2 = true;
		}else{
			$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', password='".bcrypt($request->password)."', status='".$request->staim."' ,  email='".$request->email."' where id='".$request->id_user."' ");
			$isTrue2 = true;
		}
		//UPDATE TAB 2 belum kelar
		if($request->npwp == null){
				
			$isTrue3 = false;
		}else{
			$updatetab2 = DB::select("update itdp_profil_imp set company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
			, id_mst_province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' , status='".$request->staim."'
			where id='".$id_user_b."'");
			$isTrue3 = true;
		}
		if($isTrue1 && $isTrue2 && $isTrue3){
			$res['message'] = "Success";
			return response($res);
		}else{
			$res['message'] = "Failed";
			return response($res);
		}	
	}
    
}
