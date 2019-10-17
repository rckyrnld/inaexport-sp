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
    function rc_type($id){
        $data = DB::table('csc_research_type')->where('id', $id)->first();

        return $data->nama_en;
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
    function getNameCategoryProduct($id){
        $data = DB::table('csc_product')->where('id', $id)->first();
        return $data->nama_kategori_en;
    }
}