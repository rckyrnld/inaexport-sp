<?php

namespace App\Http\Controllers\UM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Group;
use App\User;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Users';
       //  $user = User::join('group','group.id_group','=','users.id_group')->orderBy('id', 'DESC')->get();
		$user = DB::select('select a.*,a.created_at as ca,b.* from itdp_admin_users a , "group" b where a.id_group = b.id_group order by a.id DESC');
        $url = '/user_save';
        // $group = Group::all();
		$nb = "group";
        $group = DB::select("select * from public.group where id_group!='2' and id_group!='3' order by id_group asc");
        return view('UM.user.index',compact('pageTitle','user','url','group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getem($id){
		// echo $id;die();
		$cek = DB::select("select * from vms.users where email='".$id."'");
		$itung = count($cek);
		if($itung == 0){
			echo "0";
		}else{
			echo "1";
		}
	}
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		date_default_timezone_set('Asia/Jakarta');
        $insert = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'password_real' => $request->password,
            'created_at' => date('Y-m-d H:i:s'),
            'id_group' => $request->id_group
        ]);

        if($insert){
            if ($request->id_group==3) {
                 Session::flash('success','Register');
            return redirect('/users');
            }
            else{
            return redirect('/users');
            }
          
        }else{
            Session::flash('failed','Menambah Data');
            return redirect('/users');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Users';
        $user = User::join('group','group.id_group','=','users.id_group')->get();
        $url = '/user_update/'.$id;
        $res = User::find($id);
        $group = Group::all();
        return view('UM.user.index',compact('pageTitle','user','url','group','res'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = User::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'password_real' => $request->password,
            'id_group' => $request->id_group
        ]);

        if($update){
            Session::flash('success','Mengubah Data');
            return redirect('/users');
        }else{
            Session::flash('failed','Mengubah Data');
            return redirect('/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		
		$hapususer=DB::select("delete from users where id='".$id."'");
		return redirect('/users');
    }
}
