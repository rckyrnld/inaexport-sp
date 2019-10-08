<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Auth;
class Permissions {
    public static function get() {

    	$id_group = Auth::user()->id_group; 

        // $menu = DB::table('permissions')->where('id_group',$id_group)->join('menu','menu.id_menu','=','permissions.id_menu')->orderBy('order','ASC')->get();
		$menu = DB::select("select a.*,b.* from permissions a, menu b where a.id_group = '".$id_group."' and a.id_menu = b.id_menu order by b.order asc");
        return $menu;
    }
}