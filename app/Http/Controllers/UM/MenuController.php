<?php

namespace App\Http\Controllers\UM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Group;
use Session;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Menus';
        $menu = DB::table('menu')->get();
        return view('UM.menu.index',compact('pageTitle','menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Menus';
        $url = "/menu_save";
        return view('UM.menu.form',compact('url','pageTitle'));
    }

      public function create_submenu($id)
    {
        $pageTitle = 'Menus';
        $url = "/submenu_save";
        $res = DB::table('menu')->where('id_menu',$id)->first();
        $parent = DB::table('menu')->where('id_menu',$res->parent)->first();
        return view('UM.menu.add',compact('url','pageTitle','res','parent'));
    }


    public function store_submenu(Request $request)
    {
         $insert = DB::table('menu')->insert(["menu_name" => $request->nama_submenu,
                                 "url" => $request->url,
                                 "order" => $request->urutan,
                                 "icon" => $request->icon,
                                 "ket" => $request->ket,
                                 "parent" => $request->id_menu]);

         if($insert){
            Session::flash('success','Menambah Data');
            return redirect('/menus');
         }else{
            Session::flash('failed','Menambah Data');
            return redirect('/menus');
         }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $insert = DB::table('menu')->insert(["menu_name" => $request->nama_menu,
                                 "url" => $request->url,
                                 "order" => $request->urutan,
                                 "icon" => $request->icon,
                                 "ket" => $request->ket]);


         if($insert){
            Session::flash('success','Menambah Data');
            return redirect('/menus');
         }else{
            Session::flash('failed','Menambah Data');
            return redirect('/menus');
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
        $pageTitle = "Menus";
        $url = "/submenu_update/".$id;
        $res = DB::table('menu')->where('id_menu',$id)->first();
        $parent = DB::table('menu')->where('id_menu',$res->parent)->first();
        return view('UM.menu.add',compact('url','res','pageTitle','parent'));
    }

    public function edit_submenu($id)
    {
        $pageTitle = "Menus";
        $url = "/submenu_update/".$id;
        $res = DB::table('menu')->where('id_menu',$id)->first();
        $parent = DB::table('menu')->where('id_menu',$res->parent)->first();
        return view('UM.menu.add',compact('url','res','pageTitle','parent'));
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
        $update = DB::table('menu')->where('id_menu',$id)->update(["menu_name" => $request->nama_menu,
                                 "url" => $request->url,
                                 "order" => $request->urutan,
                                 "icon" => $request->icon,
                                 "ket" => $request->ket]);


         if($update){
            Session::flash('success','Menambah Data');
            return redirect('/menus');
         }else{
            Session::flash('failed','Menambah Data');
            return redirect('/menus');
         }
    }

    public function update_submenu(Request $request, $id)
    {
        $update = DB::table('menu')->where('id_menu',$id)->update(["menu_name" => $request->nama_submenu,
                                 "url" => $request->url,
                                 "order" => $request->urutan,
                                 "icon" => $request->icon,
                                 "ket" => $request->ket,
                                 "parent" => $request->id_menu]);

         if($update){
            Session::flash('success','Menambah Data');
            return redirect('/menus');
         }else{
            Session::flash('failed','Menambah Data');
            return redirect('/menus');
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
         $delete = DB::table('menu')->where('id_menu',$id)->delete();      
 
         if($delete){
            Session::flash('success','Menambah Data');
            return redirect('/menus');
         }else{
            Session::flash('failed','Menambah Data');
            return redirect('/menus');
         }
    }
}
