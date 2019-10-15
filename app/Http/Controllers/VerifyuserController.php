<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VerifyuserController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Verifikasi User";
		$data = DB::select("select a.* from itdp_company_users a order by a.id desc ");
        return view('verifyuser.index', compact('pageTitle','data'));
    }

   

    public function detailverify($id)
    {
        $pageTitle = 'Detail User';
        $data = DB::table('itdp_company_users')
            ->where('id', '=', $id)
            ->get();
        return view('verifyuser.edit', compact('pageTitle', 'data'));
    }
	
	public function saveverify($id)
    {
		$update = DB::select("update itdp_company_users set status='1' where id='".$id."'");
		return redirect('verifyuser');
	}
	
	public function profil($id,$id2)
    {
		if($id == 2){
			$pageTitle = "Profil Eksportir";
			$tx = "Eksportir";
		}else if($id == 2){
			$pageTitle = "Profil Importir";
			$tx = "Importir";
		}else{
			$pageTitle = "Profil ";
			$tx ="";
		}
		$ida = $id;
		$idb = $id2;
		return view('verifyuser.profil', compact('pageTitle','tx','ida','idb'));
	}
	
	public function simpan_profil(Request $request)
    {
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		//UPDATE TAB 1
		if($request->password == null ){
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', email='".$request->email."' where id='".$request->id_user."' ");
		}else{
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', password='".bcrypt($request->password)."', email='".$request->email."' where id='".$request->id_user."' ");
			
		}
		//UPDATE TAB 2
		if($id_role == 2){
		$updatetab2 = DB::select("update itdp_profil_eks set company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
		, id_mst_province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' 
		where id='".$id_user_b."'");
		}else{
		$updatetab2 = DB::select("update itdp_profil_imp set company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
		, province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' 
		where id='".$id_user_b."'");
		}
		
		//UPDATE TAB 3
		if($id_role == 2){
			if($request->npwp == null){
				
			}else{
				$updatetab2 = DB::select("update itdp_profil_eks set npwp='".$request->npwp."', tdp='".$request->tanda_daftar."', siup='".$request->siup."' , doc='1.jpg' 
				, upduserid='".$request->situ."' , id_eks_business_size='".$request->scoope."', id_business_role_id='".$request->tob."', employe='".$request->employee."', status='".$request->staim."' 
				where id='".$id_user_b."'");
			}
		}
		return redirect('profil/'.$id_role.'/'.$id_user);
		
	
	}
    
}
