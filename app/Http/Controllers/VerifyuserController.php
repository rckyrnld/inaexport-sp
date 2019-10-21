<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VerifyuserController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Eksportir";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
        return view('verifyuser.index', compact('pageTitle','data'));
    }

	 public function index2()
    {
//        dd("mantap");die();
        $pageTitle = "Importir";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
        return view('verifyuser.index2', compact('pageTitle','data'));
    }
	
	 public function getimportir()
    {
      $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return $pesan->company;
            })
			->addColumn('f2', function ($pesan) {
				 return $pesan->addres;
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->postcode;
            })
			->addColumn('f4', function ($pesan) {
				 return $pesan->phone;
            })
			->addColumn('f5', function ($pesan) {
				 return $pesan->fax;
            })
			->addColumn('f6', function ($pesan) {
				 if($pesan->agree == 1){ 
				 return "<center><font color='green'>Sudah</font></center>";
				 }else{ 
				 return "<center><font color='red'>Belum</font></center>";
				 }
            })
			->addColumn('f7', function ($pesan) {
				if($pesan->status_a == 1){ 
				return "<center><font color='green'>Verified</font></center>";
				} else if($pesan->status_a == 2){ 
				return "<center><font color='red'>Not Verified</font></center>";
				}else{ 
				return "<center><font color='orange'>Wait Administrator</font></center>";
				}
				 
            })
            ->addColumn('action', function ($pesan) {
           
                if($pesan->status_a == 1 || $pesan->status_a == 2){ 
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i> Detail</a>';
				}else{
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-success"><i class="fa fa-edit text-white"></i> Verify</a>';
				}
               
                
           
                
            })
			->rawColumns(['action','f6','f7'])
            ->make(true);
    }
	
	public function geteksportir()
    {
      $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='2' order by a.id desc ");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return $pesan->company;
            })
			->addColumn('f2', function ($pesan) {
				 return $pesan->addres;
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->postcode;
            })
			->addColumn('f4', function ($pesan) {
				 return $pesan->phone;
            })
			->addColumn('f5', function ($pesan) {
				 return $pesan->fax;
            })
			->addColumn('f6', function ($pesan) {
				 if($pesan->agree == 1){ 
				 return "<center><font color='green'>Sudah</font></center>";
				 }else{ 
				 return "<center><font color='red'>Belum</font></center>";
				 }
            })
			->addColumn('f7', function ($pesan) {
				if($pesan->status_a == 1){ 
				return "<center><font color='green'>Verified</font></center>";
				} else if($pesan->status_a == 2){ 
				return "<center><font color='red'>Not Verified</font></center>";
				}else{ 
				return "<center><font color='orange'>Wait Administrator</font></center>";
				}
				 
            })
            ->addColumn('action', function ($pesan) {
           
                if($pesan->status_a == 1 || $pesan->status_a == 2){ 
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info"><i class="fa fa-edit text-white"></i> Detail</a>';
				}else{
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-success"><i class="fa fa-edit text-white"></i> Verify</a>';
				}
               
                
           
                
            })
			->rawColumns(['action','f6','f7'])
            ->make(true);
    }
	
	public function getpw()
    {
      $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from itdp_admin_users where id_group='4' order by id desc");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return $pesan->name;
            })
			->addColumn('f2', function ($pesan) {
				 return $pesan->email;
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->website;
            })
			->addColumn('f6', function ($pesan) {
				 if($pesan->id_admin_ln == null || $pesan->id_admin_ln == 0){ 
				 return "<center>Dalam Negeri</center>";
				 }else{ 
				 return "<center>Luar Negeri</center>";
				 }
            })
			->addColumn('f7', function ($pesan) {
				return "<center>".$pesan->type."</center>";
				 
            })
            ->addColumn('action', function ($pesan) {
           
               return '<center><a class="btn btn-danger" href="'.url('hapusperwakilan/'.$pesan->id).'"><i class="fa fa-trash"></i> Hapus</a></center>';
				
            })
			->rawColumns(['action','f6','f7'])
            ->make(true);
    }
	
	public function tambahperwakilan()
    {
		$pageTitle = "Tambah Perwakilan";
		return view('verifyuser.tambahperwakilan', compact('pageTitle'));
	}
	
	public function index3()
    {
//        dd("mantap");die();
        $pageTitle = "Perwakilan";
		$data = DB::select("select * from itdp_admin_users where id_group='4' order by id desc ");
        return view('verifyuser.index3', compact('pageTitle','data'));
    }

	public function hapusperwakilan($id)
    {
		$delete = DB::select("delete from itdp_admin_users where id='".$id."'");
		return redirect('profilperwakilan');
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
		}else if($id == 3){
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
	
	public function profil2($id,$id2)
    {
		if($id == 2){
			$pageTitle = "Profil Eksportir";
			$tx = "Eksportir";
		}else if($id == 3){
			$pageTitle = "Profil Importir";
			$tx = "Importir";
		}else{
			$pageTitle = "Profil ";
			$tx ="";
		}
		$ida = $id;
		$idb = $id2;
		return view('verifyuser.profil2', compact('pageTitle','tx','ida','idb'));
	}
	
	public function simpanperwakilan(Request $request)
	{
		if($request->type == "DINAS PERDAGANGAN"){
			$insert1 = DB::select("
			insert into itdp_admin_dn (nama,id_country,email,web,telp,kepala,username,password,status) values
			('".$request->pejabat."','".$request->country."','".$request->email."','".$request->web."','".$request->phone."'
			,'".$request->username."','".$request->username."','".bcrypt($request->password)."','".$request->status."')
			");
			$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_ln");
			foreach($ambilmaxid as $rt){
				$id1 = $rt->maxid;
			}
			$insert2 = DB::select("
			insert into itdp_admin_users (name,email,password,password_real,id_group,created_at,id_admin_dn,type,website) values
			('".$request->username."','".$request->email."','".bcrypt($request->password)."','-','4'
			,'".Date('Y-m-d H:m:s')."','".$id1."','".$request->type."','".$request->web."')
			");
		}else{
			$insert1 = DB::select("
			insert into itdp_admin_ln (nama,id_country,email,web,telp,kepala,username,password,status) values
			('".$request->pejabat."','".$request->country."','".$request->email."','".$request->web."','".$request->phone."'
			,'".$request->username."','".$request->username."','".bcrypt($request->password)."','".$request->status."')
			");
			$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_ln");
			foreach($ambilmaxid as $rt){
				$id1 = $rt->maxid;
			}
			$insert2 = DB::select("
			insert into itdp_admin_users (name,email,password,password_real,id_group,created_at,id_admin_ln,type,website) values
			('".$request->username."','".$request->email."','".bcrypt($request->password)."','-','4'
			,'".Date('Y-m-d H:m:s')."','".$id1."','".$request->type."','".$request->web."')
			");
			
		}
		
		return redirect('profilperwakilan');
	}
	public function simpan_profil(Request $request)
    {
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		//UPDATE TAB 1
		if($request->password == null ){
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', email='".$request->email."', status='".$request->staim."' where id='".$request->id_user."' ");
		}else{
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', password='".bcrypt($request->password)."', status='".$request->staim."', email='".$request->email."' where id='".$request->id_user."' ");
			
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
	
	public function simpan_profil2(Request $request)
    {
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		if(empty($request->file('foto_profil'))){
			$file = "";
		}else{
			$file = $request->file('foto_profil')->getClientOriginalName();
			$destinationPath = public_path() . "/image/fotoprofil";
			$request->file('foto_profil')->move($destinationPath, $file);
			$updatetab12 = DB::select("update itdp_company_users set foto_profil='".$file."'  where id='".$request->id_user."' ");
			$updatetab22 = DB::select("update itdp_profil_imp set logo='".$file."' where id='".$id_user_b."'");
		}
		
		//UPDATE TAB 1
		if($request->password == null ){
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', email='".$request->email."', status='".$request->staim."'  where id='".$request->id_user."' ");
		}else{
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', password='".bcrypt($request->password)."', status='".$request->staim."' ,  email='".$request->email."' where id='".$request->id_user."' ");
			
		}
		//UPDATE TAB 2
		$updatetab2 = DB::select("update itdp_profil_imp set company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
		, id_mst_province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' , status='".$request->staim."'
		where id='".$id_user_b."'");
		
		if($request->staim == 2){
			if($request->template_reject == 1){
				$updatetabz = DB::select("update itdp_company_users set id_template_reject='".$request->template_reject."', keterangan_reject='".$request->txtreject."'  where id='".$request->id_user."' ");
		
			}else{
				$updatetabz = DB::select("update itdp_company_users set id_template_reject='".$request->template_reject."'  where id='".$request->id_user."' ");
		
			}
		}
		
		return redirect('profil2/'.$id_role.'/'.$id_user);
		
	
	}
    
}
