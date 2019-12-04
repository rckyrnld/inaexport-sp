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

if (! function_exists('checkJoinEvent')) {
    function checkJoinEvent($id_event, $id_user){
        $cek = DB::table('notif')->where('url_terkait', 'event/show/read')->where(function($param) use ($id_user,$id_event){
            $param->where('untuk_id', $id_user)
                  ->where('id_terkait', $id_event);
        })->first();

        $return = 0;
        if($cek){
          if($cek->status == 2){
            $return = 1;
          } elseif($cek->status == 1) {
            $return = 2;
          } else {
            $return = 0;
          }
        } else {
          $cek = DB::table('event_company_add')->where('id_event_detail', $id_event)->where('id_itdp_profil_eks', $id_user)->first();
          if($cek){
            if($cek->status == 2){
              $return = 1;
            } else {
              $return = 2;
            }
          } else {
            $return = 0;
          }
        }

        return $return;
    }
}

if (! function_exists('EvenOrgZ')) {
    function EvenOrgZ($id, $lang){
        $data = DB::table('event_organizer')->where('id', $id)->first();
        if ($lang=='in') {
          return $data->name_in;
        }else if ($lang == 'en'){
          return $data->name_en;
        } else {
          return $data->name_chn;
        }
    }
}

if (! function_exists('EventPlaceZ')) {
    function EventPlaceZ($id, $lang){
        $data = DB::table('event_place')->where('id', $id)->first();
        if ($lang=='in') {
          return $data->name_in;
        }elseif($lang == 'en'){
          return $data->name_en;
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
          }else{
            $dt = $col.'_en';
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
        if($data){
          if($data->id_profil != NULL){
            $profil = DB::table('itdp_profil_eks')->where('id', $data->id_profil)->first();
            if($profil){
              $nama = $profil->company;
            }
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
          }else{
            $col = "nama_kategori_en";
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
        if($data){
          return $data->status;
        } else {
          $data = DB::table('event_company_add')->where('id_itdp_profil_eks', $id_user)->where('id_event_detail', $id)->first();
          return $data->status;
        }
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
        if($data){
          if($data->id_profil != NULL){
            $profil = DB::table('itdp_profil_imp')->where('id', $data->id_profil)->first();
            if($profil){
              $nama = $profil->company;
            }
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

if (! function_exists('getPerwakilanName')) {
    function getPerwakilanName($id){
        $nama = "-";
        $data = DB::table('itdp_admin_users')->where('id', $id)->first();
        if($data){
          $nama = $data->name;
          // if($data->id_admin_dn || $data->id_admin_ln){
          //   if($data->id_admin_dn == 0){
          //     $ln = DB::table('itdp_admin_ln')->where('id', $data->id_admin_ln)->first();
          //     if($ln){
          //       $nama = $ln->nama;
          //     }
          //   }else if($data->id_admin_ln == 0){
          //     $dn = DB::table('itdp_admin_dn')->where('id', $data->id_admin_dn)->first();
          //     if($dn){
          //       $nama = $dn->nama;
          //     }
          //   }
          // }
        }

        return $nama;
    }
}

if (! function_exists('getAdminName')) {
    function getAdminName($id){
        $nama = "-";
        $data = DB::table('itdp_admin_users')->where('id', $id)->first();
        if($data){
          if($data->name != NULL){
            $nama = $data->name;
          }
        }

        return $nama;
    }
}

if (! function_exists('changeStatusInquiry')) {
    function changeStatusInquiry(){
        $data = DB::table('csc_inquiry_br')->get();
        $datenow = strtotime(date('Y-m-d H:i:s'));
        $different = [];
        foreach ($data as $key) {
          if($key->status == 2){
            $date = [];
            if($key->type == "importir"){
              if($key->due_date != NULL){
                if($datenow >= strtotime($key->due_date)){
                  $updstat = DB::table('csc_inquiry_br')->where('id', $key->id)->update([
                    'status' => 5,
                  ]);
                }
              }
            }else{
              $broadcast = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $key->id)->get();
              $brostat = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $key->id)->where('status', 5)->get();
              foreach ($broadcast as $key2) {
                if($key2->status == 2){
                  if($key2->due_date != NULL){
                    if($datenow >= strtotime($key2->due_date)){
                      // array_push($date, $key2->id);
                      $updstat = DB::table('csc_inquiry_broadcast')->where('id', $key2->id)->update([
                        'status' => 5,
                      ]);
                    }
                  }
                }
              }
              // array_push($different, $date);
              if(count($broadcast) == count($brostat)){
                $updstat = DB::table('csc_inquiry_br')->where('id', $key->id)->update([
                  'status' => 5,
                ]);
              }
            }
          }
        }
        return 1;
    }
}

if (! function_exists('getPerwakilanCountry')) {
    function getPerwakilanCountry($id){
        $country = 0;
        $data = DB::table('itdp_admin_ln')->where('id', $id)->first();
        if($data){
          if($data->id_country != NULL){
            $country = $data->id_country;
          }
        }

        return $country;
    }
}


if (! function_exists('getCompanyNameRC')) {
    function getCompanyNameRC($id, $key, $param){
      if($param == 'null'){
          $data = DB::table('itdp_profil_eks')->where('id', $id)->first();
          if($data){
              return $data->company;
          } else {
              $number = $key + 1;
              return 'Company not Found '.$number; 
          }
      } else {
        $data = DB::table('itdp_company_users')->where('id', $id)->first();
        $data = DB::table('itdp_profil_eks')->where('id', $data->id_profil)->first();
          if($data){
              return $data->company;
          } else {
              $number = $key + 1;
              return 'Company not Found '.$number; 
          }
      }
    }
}

if (! function_exists('getRcName')) {
    function getRcName($id, $key){
        $data = DB::table('csc_research_corner')->where('id', $id)->first();
        if($data){
            return $data->title_en.' ( '.rc_country($data->id_mst_country).' )';
        } else {
            $number = $key + 1;
            return 'Name not Found '.$number;
        }
    }
}

if (! function_exists('getNameEvent')) {
    function getNameEvent($id, $key){
        $data = DB::table('event_detail')->where('id', $id)->first();
        if($data){
            return $data->event_name_en;
        } else {
            $number = $key + 1;
            return 'Event not Found '.$number;
        }
    }
}

if (! function_exists('getNameTraining')) {
    function getNameTraining($id, $key){
        $data = DB::table('training_admin')->where('id', $id)->first();
        if($data){
            return $data->training_en;
        } else {
            $number = $key + 1;
            return 'Training not Found '.$number;
        }
    }
}


if (! function_exists('getCategoryLevel')) {
    function getCategoryLevel($level, $idutama, $idcat1){
      if($level == 1){
        $category = DB::table('csc_product')->where('level_1', $idutama)->where('level_2', 0)->orderby('nama_kategori_en', 'ASC')->get();
      }else{
        $category = DB::table('csc_product')->where('level_1', $idcat1)->where('level_2', $idutama)->orderby('nama_kategori_en', 'ASC')->get();
      }

      return $category;
    }
}


if (! function_exists('getCountProduct')) {
    function getCountProduct($jenis, $ideksportir){
      if($jenis == "company"){
        $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.id_itdp_company_user', $ideksportir)
            ->count();
      }

      return $product;
    }
}

if (! function_exists('getCountData')) {
    function getCountData($tbl){
      if($tbl == "event_detail"){
        $data = DB::table($tbl)->where('status_en', 'Verified')->count();
      }else if($tbl == "csc_product_single"){
        $data = DB::table($tbl)
          ->join('itdp_company_users', 'itdp_company_users.id', '=', $tbl.'.id_itdp_company_user')
          ->select($tbl.'.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
          ->where('itdp_company_users.status', 1)
          ->where($tbl.'.status', 2)
          ->count();
      }else if($tbl == "itdp_company_users"){
        $data = DB::table($tbl)
          ->join('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
          ->where('itdp_company_users.id_role', 2)
          ->count();
      }

      return $data;
    }
}

if (! function_exists('getProductByCategory')) {
    function getProductByCategory($category){
      $product = DB::table('csc_product_single')
            ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
            ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
            ->where('itdp_company_users.status', 1)
            ->where('csc_product_single.status', 2)
            ->where('csc_product_single.id_csc_product', $category)
            ->inRandomOrder()
            ->limit(6)
            ->get();

      return $product;
    }
}

if (! function_exists('getPerwakilanCountry2')) {
    function getPerwakilanCountry2($id){
        $nama = "-";
        $data = DB::table('itdp_admin_users')->where('id', $id)->first();
        if($data){
          if($data->id_admin_dn || $data->id_admin_ln){
            if($data->id_admin_dn == 0){
              $ln = DB::table('itdp_admin_ln')->where('id', $data->id_admin_ln)->first();
              $country = DB::table('mst_country')->where('id', $ln->id_country)->first(); 
              if($country){
                $nama = $country->country;
            }else if($data->id_admin_ln == 0){
              $dn = DB::table('itdp_admin_dn')->where('id', $data->id_admin_dn)->first();
              $country = DB::table('mst_country')->where('id', $dn->id_country)->first(); 
              }if($country){
                $nama = $country->country;
              }
            }
          }
        }

        return $nama;
    }
}


if (! function_exists('getProductbyEksportir')) {
    function getProductbyEksportir($user, $limit, $order, $lct){
      if($order == NULL){
        if($limit == NULL){
          $product = DB::table('csc_product_single')
              ->where('status', 2)
              ->where('id_itdp_company_user', $user)
              ->inRandomOrder()
              ->get();
        }else{
          $product = DB::table('csc_product_single')
                ->where('status', 2)
                ->where('id_itdp_company_user', $user)
                ->inRandomOrder()
                ->paginate($limit);
        }
      }else{
        if($order == ""){
          if($limit == NULL){
            $product = DB::table('csc_product_single')
                ->where('status', 2)
                ->where('id_itdp_company_user', $user)
                ->inRandomOrder()
                ->get();
          }else{
            $product = DB::table('csc_product_single')
                  ->where('status', 2)
                  ->where('id_itdp_company_user', $user)
                  ->inRandomOrder()
                  ->paginate($limit);
          }
        }else{
          if($order == "new"){
              $col = "created_at";
              $urut = "DESC";
          }else if($order == "asc"){
              $col = "prodname_".$lct;  
              $urut = "ASC";
          }
          if($limit == NULL){
            $product = DB::table('csc_product_single')
                ->where('status', 2)
                ->where('id_itdp_company_user', $user)
                ->orderBy($col, $urut)
                ->get();
          }else{
            $product = DB::table('csc_product_single')
                  ->where('status', 2)
                  ->where('id_itdp_company_user', $user)
                  ->orderBy($col, $urut)
                  ->paginate($limit);
          }
        }
      }

      return $product;
    }
}

if (! function_exists('getProvinceName')) {
    function getProvinceName($id, $loc){
      $nama = "-";
      $product = DB::table('mst_province')
            ->where('id', $id)
            ->first();

      if($product != NULL){
        $nbhs = "province_".$loc;
        $nama = $product->$nbhs;
      }

      return $nama;
    }
}

if (! function_exists('getContactPerson')) {
    function getContactPerson($id, $param){
      $return = '-';
      $cp = DB::table('contact_person')
            ->where('id_type', $id)
            ->where('type', $param)
            ->first();
            
      if($cp != NULL){
        $return = $cp->name.'|'.$cp->phone.'|'.$cp->email;
      }

      return $return;
    }
}

if (! function_exists('getDataDownload')) {
    function getDataDownload($id){
      $download = DB::table('csc_download_research_corner')
            ->where('id_research_corner', $id)
            ->select('id_itdp_profil_eks')
            ->groupby('id_itdp_profil_eks')
            ->get();

      $return = count($download);
      
      return $return;
    }
}

if (! function_exists('getServiceAttribute')) {
    function getServiceAttribute($id, $col, $lang){
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

        return $isi;
    }
}

if (! function_exists('EventPlaceName')) {
    function EventPlaceName($id, $lang){
        $data = DB::table('event_place')->where('id', $id)->first();
        $place = $data->name_en;
        if ($lang=='in') {
          if($data->name_in != null){
            $place = $data->name_in;
          }
        }else if($lang == 'ch'){
          if($data->name_chn != null){
            $place = $data->name_chn;
          }
        }
        return $place;
    }
}

if (! function_exists('EventComodityName')) {
    function EventComodityName($id, $lang){
        $data = DB::table('event_comodity')->where('id', $id)->first();
        $comodity = $data->comodity_en;
        if ($lang=='in') {
          if($data->comodity_in != null){
            $comodity = $data->comodity_in;
          }
        }else if($lang == 'ch'){
          if($data->comodity_chn != null){
            $comodity = $data->comodity_chn;
          }
        }
        return $comodity;
    }
}

if (! function_exists('EventOrganizerName')) {
    function EventOrganizerName($id, $lang){
        $data = DB::table('event_organizer')->where('id', $id)->first();
        $organizer = $data->name_en;
        if ($lang=='in') {
          if($data->name_in != null){
            $organizer = $data->name_in;
          }
        }else if($lang == 'ch'){
          if($data->name_chn != null){
            $organizer = $data->name_chn;
          }
        }
        return $organizer;
    }
}