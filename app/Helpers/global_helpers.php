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