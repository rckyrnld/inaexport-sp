<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mail;

class VerifyuserController extends Controller
{
    public function index()
    {
//        dd("mantap");die();
        $pageTitle = "Indonesian Exporter";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
        return view('verifyuser.index', compact('pageTitle','data'));
    }

	 public function index2()
    {
//        dd("mantap");die();
        $pageTitle = "Buyer";
		$data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
        return view('verifyuser.index2', compact('pageTitle','data'));
    }
	
	public function listactv($id)
    {
        $pageTitle = "Log Activity";
		return view('verifyuser.logactivity', compact('pageTitle','id'));
    }
	
	 public function getimportir()
    {
		if(Auth::user()->id_group == 1) {
      $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
      }else if(Auth::user()->id_group == 4){
		$a = Auth::user()->id;
		if(Auth::user()->id_admin_dn == 0){
		// luar
		$b = Auth::user()->id_admin_ln;
		$quer = DB::select("select * from  itdp_admin_ln where id='".$b."'");
		foreach($quer as $t1){ $ic = $t1->id_country; }
		// echo $ic;die();
		$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b, mst_country c, mst_group_country d where d.id = c.mst_country_group_id and d.id='".$ic."' and b.id_mst_country = c.id and  a.id_profil = b.id and id_role='3' order by a.id desc ");
      
		}else{
		//dalam
		$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and id_role='3' order by a.id desc ");
      
		
		}
		
		}
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return '<div align="left">'.$pesan->company.'</div>';
            })
			->addColumn('f2', function ($pesan) {
				 return $pesan->email;
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->postcode;
            })
			->addColumn('f4', function ($pesan) {
				 return $pesan->phone;
            })
			->addColumn('f5', function ($pesan) {
				 $cariac = DB::select("select * from log_user where id_user='".$pesan->ida."' and id_role='".$pesan->id_role."' order by id_log desc limit 1");
				 if(count($cariac) == 0){
					return "<font color='red'>No Action</font>";
				 }else{
					 foreach($cariac as $cc){
						 if($cc->keterangan == null){
							 $kt ="Login";
						 }else{
							 
							$kt = $cc->keterangan;
						 }
						 
						 return '<a target="_BLANK" href="'.url('listactv/'.$pesan->ida).'">'.$cc->date."(".$cc->waktu.") ".$kt.'</a>';
					 }
				 }
            })
			->addColumn('f6', function ($pesan) {
				 if($pesan->agree == 1){ 
				 return "<center><font color='green'>Yes</font></center>";
				 }else{ 
				 return "<center><font color='red'>No</font></center>";
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
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-edit text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapusimportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('resetimportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
				';
				}else{
				return '<a href="'.url('profil2/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-success" title="Verify"><i class="fa fa-check text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapusimportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('resetimportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
				';
				}
            })
			->rawColumns(['action','f6','f7','f1','f5'])
            ->make(true);
    }
	
	public function geteksportir()
    {
	if(Auth::user()->id_group == 1) {
      $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a,b.company, b.postcode, b.phone from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
	}else if(Auth::user()->id_group == 4){
		$a = Auth::user()->id;
		if(Auth::user()->id_admin_dn == 0){
		// luar
		$b = Auth::user()->id_admin_ln;
		$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a,b.company, b.postcode, b.phone from itdp_company_users a, itdp_profil_eks b where b.id_mst_province = '9999999' and a.id_profil = b.id and id_role='2' order by a.id desc ");
	
		}else{
		//dalam
		$b = Auth::user()->id_admin_dn;
		$quer = DB::select("select * from  itdp_admin_dn where id='".$b."'");
		foreach($quer as $t1){ $ic = $t1->id_country; }
		// echo $ic;die();
		$pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY a.id DESC) AS Row, a.email, a.id_role, a.agree, a.id as ida,a.status as status_a,b.company, b.postcode, b.phone from itdp_company_users a, itdp_profil_eks b where b.id_mst_province = '".$ic."' and a.id_profil = b.id and id_role='2' order by a.id desc ");
	
		
		}
		
		}
	 return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return '<div align="left">'.$pesan->company.'</div>';
            })
			->addColumn('f2', function ($pesan) {
				 return $pesan->email;
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->postcode;
            })
			->addColumn('f4', function ($pesan) {
				 return $pesan->phone;
            })
			->addColumn('f5', function ($pesan) {
				 $cariac = DB::select("select * from log_user where id_user='".$pesan->ida."' and id_role='".$pesan->id_role."' order by id_log desc limit 1");
				 if(count($cariac) == 0){
					return "<font color='red'>No Action</font>";
				 }else{
					 foreach($cariac as $cc){
						 if($cc->keterangan == null){
							 $kt ="Login";
						 }else{
							 
							$kt = $cc->keterangan;
						 }
						 
						 return '<a target="_BLANK" href="'.url('listactv/'.$pesan->ida).'">'.$cc->date."(".$cc->waktu.") ".$kt.'</a>';
					 }
				 }
            })
			->addColumn('f6', function ($pesan) {
				 if($pesan->agree == 1){ 
				 return "<center><font color='green'>Yes</font></center>";
				 }else{ 
				 return "<center><font color='red'>No</font></center>";
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
				return '<a href="'.url('profil/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-edit text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapuseksportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('reseteksportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
				';
				}else{
				return '<a href="'.url('profil/'.$pesan->id_role.'/'.$pesan->ida).'" class="btn btn-sm btn-success" title="Verify"><i class="fa fa-check text-white"></i></a>
				<a Onclick="return ConfirmDelete();" href="'.url('hapuseksportir/'.$pesan->ida).'" class="btn btn-sm btn-danger" title="hapus"><i class="fa fa-trash text-white"></i></a>
				<a href="'.url('reseteksportir/'.$pesan->ida).'" class="btn btn-sm btn-warning" title="Reset Password"><i class="fa fa-key text-white"></i></a>
				';
				}
               
                
           
                
            })
			->rawColumns(['action','f6','f7','f1','f5'])
            ->make(true);
    }
	
	public function getpw()
    {
      $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from itdp_admin_users where id_group='4' order by id desc");
      return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
				 return '<div align="left">'.$pesan->name.'</div>';
            })
			->addColumn('f2', function ($pesan) {
				 return $pesan->email;
            })
			->addColumn('f3', function ($pesan) {
				 return $pesan->website;
            })
			->addColumn('f6', function ($pesan) {
				 if($pesan->id_admin_ln == null || $pesan->id_admin_ln == 0){ 
				 return "<center>Domestic</center>";
				 }else{ 
				 return "<center>Overseas</center>";
				 }
            })
			->addColumn('f7', function ($pesan) {
				return "<center>".$pesan->type."</center>";
				 
            })
            ->addColumn('action', function ($pesan) {
           
//               return '<center>
//			   <a class="btn btn-success" href="'.url('editperwakilan/'.$pesan->id).'"><i class="fa fa-edit"></i> &nbsp;&nbsp;Edit&nbsp;</a>
//			   <a class="btn btn-danger" href="'.url('hapusperwakilan/'.$pesan->id).'"><i class="fa fa-trash"></i> Hapus</a>
//
//			   </center>';

                return '<center>
			   <a class="btn btn-success" href="'.url('editperwakilan/'.$pesan->id).'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
			   <a class="btn btn-danger" onclick="return confirm(\'Are You Sure ?\')" href="'.url('hapusperwakilan/'.$pesan->id).'" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
			   
			   </center>';
				
            })
			->rawColumns(['action','f6','f7','f1'])
            ->make(true);
    }
	
	public function tambahperwakilan()
    {
		$pageTitle = "Add Representative";
		return view('verifyuser.tambahperwakilan', compact('pageTitle'));
	}
	
	public function index3()
    {
//        dd("mantap");die();
        $pageTitle = "Representative";
		$data = DB::select("select * from itdp_admin_users where id_group='4' order by id desc ");
        return view('verifyuser.index3', compact('pageTitle','data'))->with('success');
    }

	public function hapusimportir($id)
    {
		$delete = DB::select("delete from itdp_company_users where id='".$id."'");
		return redirect('verifyimportir')->with('success', 'Success Delete Data');
	}
	
	public function hapuseksportir($id)
    {
		$delete = DB::select("delete from itdp_company_users where id='".$id."'");
		return redirect('verifyuser')->with('success', 'Success Delete Data');
	}
	
	public function resetimportir($id)
    {
			$ei = DB::select("select * from itdp_company_users where id='".$id."'");
			
			foreach($ei as $ie){
				$d1 = $ie->id;
				$d2 = $ie->username;
				$d3 = $ie->email;
			}
			$data = ['username' => $d2, 'id2' => $d1, 'nama' => $d2, 'email' => $d3];

                Mail::send('UM.user.emailforget', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Forget Password');

                });
			
		
		return redirect('verifyimportir')->with('success','Ask User to Check Email');
	}
	
	public function reseteksportir($id)
    {
			$ei = DB::select("select * from itdp_company_users where id='".$id."'");
			
			foreach($ei as $ie){
				$d1 = $ie->id;
				$d2 = $ie->username;
				$d3 = $ie->email;
			}
			$data = ['username' => $d2, 'id2' => $d1, 'nama' => $d2, 'email' => $d3];

                Mail::send('UM.user.emailforget', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Forget Password');

                });
			
		
		return redirect('verifyuser')->with('success','Ask User to Check Email');
	}
	
	public function hapusperwakilan($id)
    {
		$delete = DB::select("delete from itdp_admin_users where id='".$id."'");
		return redirect('profilperwakilan')->with('success','Success Delete Data');
	}
	
	public function bacanotif($id)
    {
		$update = DB::select("update notif set status_baca='1' where id_notif='".$id."'");
		
	}
	
	public function editperwakilan($id)
    {
		$pageTitle = "Representative";
		return view('verifyuser.editperwakilan', compact('pageTitle','id'));
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
        if (Auth::guard('eksmp')->user() || Auth::user()) {
            if($id == 2){
                $pageTitle = "Exporter Profile";
                $tx = "Exporter";
            }else if($id == 3){
                $pageTitle = "Importer Profile";
                $tx = "Importer";
            }else{
                $pageTitle = "Profile ";
                $tx ="";
            }
            $ida = $id;
            $idb = $id2;

            return view('verifyuser.profil', compact('pageTitle','tx','ida','idb'));
        }else {
            return redirect('/login');
        }
	}
	
	public function profil2($id,$id2)
    {
		if($id == 2){
			$pageTitle = "Exporter Profile";
			$tx = "Eksportir";
		}else if($id == 3){
			$pageTitle = "Buyer Profile";
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

		$data = [
            'email' => "",
            'email1' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'main_messages' => "",
            'id' => 0,
			];
//		dd($data);
		Mail::send('UM.user.sendpw', $data, function ($mail) use ($data) {
        $mail->to($data['email1'], $data['username']);
        $mail->subject('Admin Had Created and Set you as Representative');
		});
		
//		$data22 = [
//            'email' => $request->email,
//            'email1' => "kementerianperdagangan.max@gmail.com",
//            'username' => $request->username,
//            'password' => $request->password,
//            'main_messages' => "",
//            'id' => 0
//			];
//		Mail::send('UM.user.sendpw2', $data22, function ($mail) use ($data22) {
//        $mail->to($data22['email1'], $data22['username']);
//        $mail->subject('You Had Created and Set Representative');
//		});
		// echo "hello";die();
		if($request->type == "DINAS PERDAGANGAN"){
			$insert1 = DB::select("
			insert into itdp_admin_dn (nama,id_country,email,web,telp,kepala,username,password,status) values
			('".$request->pejabat."','".$request->country."','".$request->email."','".$request->web."','".$request->phone."'
			,'".$request->username."','".$request->username."','".bcrypt($request->password)."','".$request->status."')
			");
			$ambilmaxid = DB::select("select max(id) as maxid from itdp_admin_dn");
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
		
		return redirect('profilperwakilan')->with('success', 'Success Add Data!');
	}
	
	public function updateperwakilan(Request $request)
	{
		if($request->type == "DINAS PERDAGANGAN"){
			if(empty($request->password) || $request->password == null){
			$update1 = DB::select("
			update itdp_admin_dn set nama='".$request->pejabat."', id_country ='".$request->country."', email ='".$request->email."', web='".$request->web."'
			, telp='".$request->phone."', kepala='".$request->username."', username='".$request->username."', status='".$request->status."'
			where id='".$request->idb."'
			");
			
			$update2 = DB::select("
			update itdp_admin_users set name='".$request->username."', email ='".$request->email."', website='".$request->web."'
			where id='".$request->ida."'
			");
			}else{
			$update1 = DB::select("
			update itdp_admin_dn set nama='".$request->pejabat."', id_country ='".$request->country."', email ='".$request->email."', web='".$request->web."'
			, telp='".$request->phone."', kepala='".$request->username."', username='".$request->username."', password='".bcrypt($request->password)."', status='".$request->status."'
			where id='".$request->idb."'
			");
			
			$update2 = DB::select("
			update itdp_admin_users set name='".$request->username."', email ='".$request->email."', password ='".bcrypt($request->password)."', website='".$request->web."'
			where id='".$request->ida."'
			");
			}
			
		}else{
			// echo "b";die();
			if(empty($request->password) || $request->password == null){
			$update1 = DB::select("
			update itdp_admin_ln set nama='".$request->pejabat."', id_country ='".$request->country."', email ='".$request->email."', web='".$request->web."'
			, telp='".$request->phone."', kepala='".$request->username."', username='".$request->username."', status='".$request->status."'
			where id='".$request->idb."'
			");
			
			$update2 = DB::select("
			update itdp_admin_users set name='".$request->username."', email ='".$request->email."', website='".$request->web."'
			where id='".$request->ida."'
			");
			
			}else{
			$update1 = DB::select("
			update itdp_admin_ln set nama='".$request->pejabat."', id_country ='".$request->country."', email ='".$request->email."', web='".$request->web."'
			, telp='".$request->phone."', kepala='".$request->username."', username='".$request->username."', password='".bcrypt($request->password)."', status='".$request->status."'
			where id='".$request->idb."'
			");
			
			$update2 = DB::select("
			update itdp_admin_users set name='".$request->username."', email ='".$request->email."', password ='".bcrypt($request->password)."', website='".$request->web."'
			where id='".$request->ida."'
			");
			}

		}
		
		return redirect('profilperwakilan')->with('success','Success Update Data!');
	}
	public function simpan_profil(Request $request)
    {
//        dd($request->idu);
        date_default_timezone_set('Asia/Jakarta');
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
//		dd($id_user_b);
		if(Auth::guard('eksmp')->user()) {
            //di edit indonesian exporter
            //ini yang masih mau di edit
            if(empty($request->file('doc'))){
                $file = "";
            }else{
                $file = $request->file('doc')->getClientOriginalName();
                $destinationPath = public_path() . "/eksportir";
                $request->file('doc')->move($destinationPath, $file);
                $updatetabd = DB::select("update itdp_profil_eks set doc='".$file."' where id='".$id_user_b."'");
            }

            if(empty($request->file('npwpfile'))){
                $file = "";
            }else{
                $file = $request->file('npwpfile')->getClientOriginalName();
                $destinationPath = public_path() . "/eksportir";
                $request->file('npwpfile')->move($destinationPath, $file);
                $updatetabd = DB::select("update itdp_profil_eks set uploadnpwp='".$file."' where id='".$id_user_b."'");
            }

            if(empty($request->file('tdpfile'))){
                $file = "";
            }else{
                $file = $request->file('tdpfile')->getClientOriginalName();
                $destinationPath = public_path() . "/eksportir";
                $request->file('tdpfile')->move($destinationPath, $file);
                $updatetabd = DB::select("update itdp_profil_eks set uploadtdp='".$file."' where id='".$id_user_b."'");
            }

            if(empty($request->file('siupfile'))){
                $file = "";
            }else{
                $file = $request->file('siupfile')->getClientOriginalName();
                $destinationPath = public_path() . "/eksportir";
                $request->file('siupfile')->move($destinationPath, $file);
                $updatetabd = DB::select("update itdp_profil_eks set uploadsiup='".$file."' where id='".$id_user_b."'");
            }

            $date = date('Y-m-d H:i:s');
            $notif = DB::table('notif')->insert([
                'dari_nama' =>getCompanyName(auth::guard('eksmp')->user()->id),
                'dari_id' => auth::guard('eksmp')->user()->id,
                'untuk_nama' => "Super Admin",
                'untuk_id' => '1',
                'keterangan' => 'Exporter "'.getExBadan(auth::guard('eksmp')->user()->id).getCompanyName(auth::guard('eksmp')->user()->id).'" Update The Company Data',
                'url_terkait' => 'profil/2',
                'status_baca' => 0,
                'waktu' => $date,
                'id_terkait' => $id_user,
                'to_role' => "1",
            ]);

            $admin_all = DB::select("select name,email from itdp_admin_users where id_group='1'");
            foreach($admin_all as $aa){
                $data = [
                    'email' => $aa->email,
                    'email1' => $aa->email,
                    'username' => $aa->name,
                    'company' =>getCompanyName(auth::guard('eksmp')->user()->id),
                    'id' => $id_user,
                    'bu' => getExBadan(auth::guard('eksmp')->user()->id),
                ];
                Mail::send('UM.user.emailexupload', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['username']);
                    $mail->subject('Exporter Update their Profile');
                });
            }


//            if($request->file('doc') and $request->file('npwpfile') and $request->file('tdpfile') and $request->file('siupfile')){
//
//            }
        }
		$destination= 'uploads\Profile\Eksportir\\'.$id_user;
        if($request->hasFile('image_1')){ 
            $file1 = $request->file('image_1');
            $nama_file1 = time().'_'.$request->file('image_1')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
            $updfoto = DB::table('itdp_company_users')->where('id', $id_user)->update([
            	"foto_profil" => $nama_file1,
            ]);
        }
		

		//UPDATE TAB 1
		if($request->password == null ){
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', email='".$request->email."', status='".$request->staim."' where id='".$request->id_user."' ");
		}else{
		$updatetab1 = DB::select("update itdp_company_users set username='".$request->username."', password='".bcrypt($request->password)."', status='".$request->staim."', email='".$request->email."' where id='".$request->id_user."' ");
			
		}

        if($request->staim == 1){
            if(auth::user()) {
                $data3 = ['username' => $request->username, 'id2' => 0, 'company' => $request->company, 'password' => $request->password, 'email' => $request->email, 'by' => auth::user()->name];
                Mail::send('UM.user.emailverif1', $data3, function ($mail) use ($data3) {
                    $mail->to($data3['email'], $data3['username']);
                    $mail->subject('Your Account Was Verifed');
                });
                $date = date('Y-m-d H:i:s');
                $notif = DB::table('notif')->insert([
                    'dari_nama' =>auth::user()->name,
                    'dari_id' => auth::id(),
                    'untuk_nama' => $request->company,
                    'untuk_id' => $id_user,
                    'keterangan' => 'Your account is verified by "'.auth::user()->name.'"',
                    'url_terkait' => 'profil/2',
                    'status_baca' => 0,
                    'waktu' => $date,
                    'id_terkait' => $id_user,
                    'to_role' => $id_role,
                ]);
            }
		}
		//UPDATE TAB 2
		if($id_role == 2){
		$updatetab2 = DB::select("update itdp_profil_eks set badanusaha='".$request->badanusaha."', company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
		, id_mst_province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."', email='".$request->email."' 
		where id='".$id_user_b."'");
		}else{
		$updatetab2 = DB::select("update itdp_profil_imp set badanusaha='".$request->badanusaha."', company='".$request->company."', addres='".$request->addres."', city='".$request->city."' 
		, province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' 
		where id='".$id_user_b."'");
		}
		
		//UPDATE TAB 3
		if($id_role == 2){
			if($request->npwp == null){
				
			}else{
				$updatetab2 = DB::select("update itdp_profil_eks set npwp='".$request->npwp."', tdp='".$request->tanda_daftar."', siup='".$request->siup."' 
				, upduserid='".$request->situ."' , id_eks_business_size='".$request->scoope."', id_business_role_id='".$request->tob."', employe='".$request->employee."', status='".$request->staim."' 
				where id='".$id_user_b."'");
			}
		}



//
        if(Auth::guard('eksmp')->user()){
//            return redirect('profil/'.$id_role.'/'.$id_user)->with('success','Success Update Data');
            return redirect('/home')->with('success','Success Update Data');
        }else{
            return redirect('/verifyuser')->with('success','Success Update Data');
        }

	
	}
	
	public function simpan_kontak(Request $request)
    {
		$insert= DB::select("insert into itdp_contact_imp (name,email,phone,id_user) values
		('".$request->name."','".$request->email."','".$request->phone."','".$request->idb."')
		");
		return redirect('profil2/3/'.$request->idb);
	}
	
	public function simpan_profil2(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
		$id_role = $request->id_role;
		$id_user = $request->id_user;
		$id_user_b = $request->idu;
		$date = date('Y-m-d H:i:s');
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
		if($request->staim == 1){
		    if(auth::user()){
                $data3 = ['username' => $request->username, 'id2' => 0, 'company' => $request->company, 'password' => $request->password, 'email' => $request->email, 'by' => auth::user()->name];

                Mail::send('UM.user.emailverif2', $data3, function ($mail) use ($data3) {
                    $mail->to($data3['email'], $data3['username']);
                    $mail->subject('Your Account Was Verifed');

                });
                $notif = DB::table('notif')->insert([
                    'dari_nama' =>auth::user()->name,
                    'dari_id' => auth::id(),
                    'untuk_nama' => $request->company,
                    'untuk_id' => $id_user,
                    'keterangan' => 'Your account is verified by "'.auth::user()->name.'"',
                    'url_terkait' => 'profil2/3',
                    'status_baca' => 0,
                    'waktu' => $date,
                    'id_terkait' => $id_user,
                    'to_role' => $id_role,
                ]);
            }
		}
		//UPDATE TAB 2
		$updatetab2 = DB::select("update itdp_profil_imp set company='".$request->company."', addres='".$request->addres."', city='".$request->city."' ,email='".$request->email."'
		, id_mst_province='".$request->province."' , postcode='".$request->postcode."', fax='".$request->fax."', website='".$request->website."', phone='".$request->phone."' , status='".$request->staim."'
		where id='".$id_user_b."'");
		
		if($request->staim == 2){
			if($request->template_reject == 1){
				$updatetabz = DB::select("update itdp_company_users set id_template_reject='".$request->template_reject."', keterangan_reject='".$request->txtreject."'  where id='".$request->id_user."' ");
		
			}else{
				$updatetabz = DB::select("update itdp_company_users set id_template_reject='".$request->template_reject."'  where id='".$request->id_user."' ");
		
			}
		}
//		if($request->staim == 1){
//			$it = "3".$id_user_b;
//			$data = [
//            'email' => "",
//            'email1' => $request->email,
//            'username' => $request->username,
//            'main_messages' => "",
//            'id' => $it
//			];
//		Mail::send('UM.user.sendverif', $data, function ($mail) use ($data) {
//        $mail->to($data['email1'], $data['username']);
//        $mail->subject('Your account had Verified');
//		});
//		}

		return redirect('verifyimportir')->with('success','Success Update Data');
//		return redirect('profil2/'.$id_role.'/'.$id_user);
		
	
	}
	
	public function ceknpwp()
	{
		$npwpz =	str_replace(".","",$_GET['id']);
		$npwpx =	str_replace("-","",$npwpz);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://perizinan.kemendag.go.id/index.php/website_api/kswp/153/".$npwpx,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
		    "postman-token: f3e1235e-d688-a840-efd7-c7eb19691494",
		    "x-api-key: kpzgMbTYlv2VmXSeOf03KxirsyBIGt48LcRPd7nN"
		  ),
		));
/*
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
*/
/*
if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
*/
	$server_output = curl_exec ($curl);

		curl_close ($curl);

		// print  $server_output ;
		$r = json_decode($server_output);
		echo json_encode(array('status'=> $r->status,'nama'=> $r->nama));
		//die('asd');
		/*
		define('API_KEY', '2F0WpJ9Ija4VksioxSlc3tUywdzD7X8uMLbQHEGP');
		define('SECRET_KEY', 'MY_SECRET_KEY');

		$Sig = base64_encode(hash_hmac('sha256', 'date: "'.gmdate('D, d M Y H:i:s T').'"', SECRET_KEY, true));

		$ch = curl_init();
		$npwpz =	str_replace(".","",$_GET['id']);
		$npwpx =	str_replace("-","",$npwpz);
		
		curl_setopt($ch, CURLOPT_URL,"http://www.kemendag.go.id/addon/api/website_api/kswp/153/".$npwpx);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
			//'Accept: application/json',
			//'Accept-Encoding: gzip, deflate',
			//'Cache-Control: no-cache',
			//'Content-Type: application/json; charset=utf-8',
			//'Host: localhost',
			//'Date: "'.gmdate('D, d M Y H:i:s T').'"',
			'X-Api-Key: '.API_KEY,
			//'Authorization: Signature keyId="'.API_KEY.'",algorithm="hmac-sha256",headers="date",signature="'.$Sig.'"'
		];
		//var_dump($headers);die();

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

		// print  $server_output ;
		$r = json_decode($server_output);
		// echo json_decode($server_output);
		//var_dump($r);die();
		echo json_encode(array('status'=> $r->status,'nama'=> $r->nama));
		// var_dump($r->status);
		*/
	}
    
}
