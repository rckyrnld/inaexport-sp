<?php
if (! function_exists('getTanggalIndo')) {
    function getTanggalIndo($tanggal){
        date_default_timezone_set("Asia/Bangkok");
        $bulan = array (
           1 =>   'Januari',
           2 => 'Februari',
           3 => 'Maret',
           4 => 'April',
           5 => 'Mei',
           6 => 'Juni',
           7 => 'Juli',
           8 =>'Agustus',
           9 =>'September',
           10 =>'Oktober',
           11 =>'November',
           12 =>'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}

if (! function_exists('rc_type')) {
    function rc_type($id, $lang){
        $data = DB::table('csc_research_type')->where('id', $id)->first();
        if($lang == 'in'){
          if($data->nama_in != null || $data->nama_in != ''){
            return $data->nama_in;
          } else {
            return $data->nama_en;
          }
        } else {
          return $data->nama_en;
        }
    }
}

if (! function_exists('optionCategory')) {
    function optionCategory(){
      $option = '';
      $categori = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product')->distinct('id_csc_product')->get();
      $level1 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level1')->where('id_csc_product_level1', '!=', null)->distinct('id_csc_product_level1')->get();
      $level2 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level2')->where('id_csc_product_level2', '!=', null)->distinct('id_csc_product_level2')->get();

      foreach ($categori as $data) {
        $category = DB::table('csc_product')->where('id', $data->id_csc_product)->first();
        $option .= '<option value="'.$category->id.'">'.$category->nama_kategori_en.'</option>';
      }
      foreach ($level1 as $data) {
        $category = DB::table('csc_product')->where('id', $data->id_csc_product_level1)->first();
        $option .= '<option value="'.$category->id.'">'.$category->nama_kategori_en.'</option>';
      }
      foreach ($level2 as $data) {
        $category = DB::table('csc_product')->where('id', $data->id_csc_product_level2)->first();
        $option .= '<option value="'.$category->id.'">'.$category->nama_kategori_en.'</option>';
      }

      echo $option;
    }
}



if (! function_exists('rc_country')) {
    function rc_country($id){
        $data = DB::table('mst_country')->where('id', $id)->first();

        return $data->country;
    }
}

if (! function_exists('rc_hscodes')) {
    function rc_hscodes($id){
        $data = DB::table('mst_hscodes')->where('id', $id)->first();

        return $data->desc_eng;
    }
}

if (! function_exists('getNameCategoryProduct')) {
    function getNameCategoryProduct($id, $jns){
        $data = DB::table('csc_product')->where('id', $id)->first();
        $name = 'nama_kategori_'.$jns;
        return $data->$name;
    }
}

if (! function_exists('getNameCompany')) {
    function getNameCompany($id){
        $name = "";
        if($id != NULL){
            $companynya = DB::table('itdp_company_users')
                ->where('id', $id)
                ->first();
            if($companynya){
                $profiles = DB::table('itdp_profil_eks')->where('id', $companynya->id_profil)->first();
                if($profiles){
                    $name = $profiles->company;
                }
            }
        }
        return $name;
    }
}

if (! function_exists('getEventComodity')) {
    function getEventComodity($id){
        $data = DB::table('event_comodity')->where('id', $id)->first();
        return $data->comodity_en;
    }
}
if (! function_exists('getEventCom')) {
    function getEventCom($id,$lang){
        $data = DB::table('event_comodity')->where('id', $id)->first();
        if ($lang=='ch') {
          return $data->comodity_chn;
        }elseif($lang=='in'){
          return $data->comodity_in;
        }else{
          return $data->comodity_en;
        }
    }
}

if (! function_exists('getEventPlace')) {
    function getEventPlace($id){
        $data = DB::table('event_place')->where('id', $id)->first();
        return $data->name_en;
    }
}

if (! function_exists('getEventStatus')) {
    function getEventStatus($id){
        $data = DB::table('event_detail')->where('id', $id)->first();
        return $data->status_en;
    }
}

if (! function_exists('getKatagori')) {
    function getKatagori($id){
        $data = DB::table('event_detail_kategori')->where('id_event_detail', $id)->get();
        foreach ($data as $key => $value) {
          $nama = DB::table('csc_product')->where('id', $value->id_prod_cat)->first();
          echo '<br> -'.$nama->nama_kategori_en;

        }
    }
}

if (! function_exists('checkJoin')) {
    function checkJoin($id_training_admin, $id_profil_eks){
        $data = DB::table('training_join')
          ->where('id_training_admin', $id_training_admin)
          ->where('id_profil_eks', $id_profil_eks)
          ->first();
        if($data){
          return 1;
        }else{
          return 0;
        }
    }
}

if (! function_exists('EvenOrgZ')) {
    function EvenOrgZ($id, $lang){
        $data = DB::table('event_organizer')->where('id', $id)->first();
        if ($lang=='in') {
          return $data->name_in;
        }else{
          return $data->name_chn;
        }
    }
}

if (! function_exists('EventPlaceZ')) {
    function EventPlaceZ($id, $lang){
        $data = DB::table('event_place')->where('id', $id)->first();
        if ($lang=='in') {
          return $data->name_in;
        }else{
          return $data->name_chn;
        }
    }
}

if (! function_exists('optionCategoryZ')) {
    function optionCategoryZ($id){
      $data = DB::table('event_detail_kategori')->where('id_event_detail', $id)->get();
      $arr = [];
      foreach ($data as $value) {
          array_push($arr, $value->id_prod_cat);
      }

      $option = '';
      $categori = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product')->distinct('id_csc_product')->get();
      $level1 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level1')->where('id_csc_product_level1', '!=', null)->distinct('id_csc_product_level1')->get();
      $level2 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level2')->where('id_csc_product_level2', '!=', null)->distinct('id_csc_product_level2')->get();

      foreach ($categori as $data) {
        $category = DB::table('csc_product')->where('id', $data->id_csc_product)->first();

        if(in_array($category->id, $arr)){ $selec = "selected";
        }else{ $selec=""; }

        $option .= '<option value="'.$category->id.'" '.$selec.'>'.$category->nama_kategori_en.'</option>';
      }
      foreach ($level1 as $data) {
        $category = DB::table('csc_product')->where('id', $data->id_csc_product_level1)->first();

        if(in_array($category->id, $arr)){ $selec = "selected";
        }else{ $selec=""; }

        $option .= '<option value="'.$category->id.'" '.$selec.'>'.$category->nama_kategori_en.'</option>';
      }
      foreach ($level2 as $data) {
        $category = DB::table('csc_product')->where('id', $data->id_csc_product_level2)->first();

        if(in_array($category->id, $arr)){ $selec = "selected";
        }else{ $selec=""; }

        $option .= '<option value="'.$category->id.'" '.$selec.'>'.$category->nama_kategori_en.'</option>';
      }

      echo $option;
    }
}

if (! function_exists('getProductAttr')) {
    function getProductAttr($id, $col, $lang){
        $data = DB::table('csc_product_single')->where('id', $id)->first();
        $isi = NULL;
        if($lang != ""){
          $dt = $col.'_'.$lang;
          if($data->$dt != NULL){
            $isi = $data->$dt;
          }
        }else{
          if($data->$col != NULL){
            $isi = $data->$col;
          }
        }

        if($isi == NULL){
          $isi = "-";
        }

        return $isi;
    }
}

if (! function_exists('getCompanyName')) {
    function getCompanyName($id){
        $nama = "-";
        $data = DB::table('itdp_company_users')->where('id', $id)->first();
        if($data->id_profil != NULL){
          $profil = DB::table('itdp_profil_eks')->where('id', $data->id_profil)->first();
          if($profil){
            $nama = $profil->company;
          }
        }

        return $nama;
    }
}

if (! function_exists('getCategoryName')) {
    function getCategoryName($id, $loc){
        $nama = "-";
        if($id != NULL){
          $col = "nama_kategori_".$loc;
          $data = DB::table('csc_product')->where('id', $id)->first();
          if($data->$col != NULL){
            $nama = $data->$col;
          }
        }

        return $nama;
    }
}

if (! function_exists('cekid')) {
    function cekid($id){
      $id = DB::table('itdp_company_users as icu')
      ->selectRaw('ipe.id')
      ->leftJoin('itdp_profil_eks as ipe','icu.id_profil','=','ipe.id')
      ->where('icu.id', $id)
      ->first();

        return $id;
      }
    }
if (! function_exists('StatusJoin')) {
    function StatusJoin($id, $id_user){
        $data = DB::table('notif')->where('untuk_id', $id_user)->where('id_terkait', $id)->first();
        return $data->status;
    }
}

if (! function_exists('CompanyZ')) {
    function CompanyZ($id){
        $da = DB::table('itdp_company_users')->where('id', $id)->first();
        $dat = DB::table('itdp_profil_eks')->where('id', $da->id_profil)->first();
        return $dat->company;

    }
}

if (! function_exists('getCompanyNameImportir')) {
    function getCompanyNameImportir($id){
        $nama = "-";
        $data = DB::table('itdp_company_users')->where('id', $id)->first();
        if($data->id_profil != NULL){
          $profil = DB::table('itdp_profil_imp')->where('id', $data->id_profil)->first();
          if($profil){
            $nama = $profil->company;
          }
        }

        return $nama;
    }
}

if (! function_exists('getIdUserEks')) {
    function getIdUserEks($id){
        $data = DB::table('itdp_company_users')->where('id_profil', $id)->first();
        return $data->id;
    }
}

if (! function_exists('getServiceAttr')) {
    function getServiceAttr($id, $col, $lang){
        $data = DB::table('itdp_service_eks')->where('id', $id)->first();

        if($lang != ""){
          $dt = $col.'_'.$lang;
          if($data->$dt != NULL){
            $isi = $data->$dt;
          } else {
            $dt = $col.'_en';
            $isi = $data->$dt;
          }
        } else {
          $isi = $data->$col;
        }

        echo $isi;
    }
}
