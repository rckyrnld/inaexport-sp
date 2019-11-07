<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->id_group == 1){
            $pageTitle  = "Dashboard";
            $company    = $this->getDataTopDownloadCompany();
            $rc         = $this->getDataTopDownloadRc();
            $user       = $this->getDataUser();
            $inquiry    = $this->getDataInquiry();
            
            return view('Dashboard',compact('pageTitle', 'top_download'))->with('Top_Company_Download', json_decode($company, true))->with('Top_Downloaded_RC', json_decode($rc, true))->with('User', json_decode($user, true))->with('Inquiry', json_decode($inquiry, true));
        } elseif(Auth::user()->id_group == 4) {
            dd(Auth::user());
        } else {
            return redirect('/');
        }
    }

    private function getDataUser(){
        $fetch_data_new_user = '';
        $fetch_sub_data = '';
        $tahun = $this->tahun();

        $new_user = DB::table('itdp_company_users as a')->selectRaw('extract(year from created_at) as year, count(b.id) as eksportir, count(c.id) as importir')
            ->leftjoin('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
            ->leftjoin('itdp_profil_imp as c', 'a.id_profil', '=', 'c.id')
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->groupby('year')
            ->get();

        for ($i=0; $i < 2; $i++) { 
            if($i == 0){
                $fetch_data_new_user .= '[{"name": "Exporter", "color": "#4cd25c", "data": [';
                $end = ']},';
            } else {
                $fetch_data_new_user .= '{"name": "Importer", "color": "#8085e9", "data": [';
                $end = ']}]';
            }
            foreach ($new_user as $key => $value) {
                if($i == 0){
                    $jumlah = $value->eksportir;
                    $id = 'Ex-'.$value->year;
                    if($value->year == date('Y')-4){
                        $fetch_sub_data .= '[{"name": "Exporter", "id": "Ex-'.$value->year.'", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Exporter", "id": "Ex-'.$value->year.'", "data": [';
                    }
                    $endnya = ']},';
                } else {
                    $jumlah = $value->importir;
                    $id = 'Imp-'.$value->year;
                    $fetch_sub_data .= '{"name": "Importer", "id": "Imp-'.$value->year.'", "data": [';
                    if($value->year === date('Y')){
                        $endnya = ']}]';
                    } else {
                        $endnya = ']},';
                    }
                }

                if ($value->year === date('Y')) {
                    $fetch_data_new_user .= '{"name": "'.$value->year.'", "y": '.$jumlah.', "drilldown": "'.$id.'"}';
                } else {
                    $fetch_data_new_user .= '{"name": "'.$value->year.'", "y": '.$jumlah.', "drilldown": "'.$id.'"},';
                }

                for ($m=1; $m < 13; $m++) { 
                    if($i == 0){
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'eksportir');
                    } else {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'importir');
                    }
                    if($m != 12){
                        $fetch_sub_data .= ',';
                    }
                }
                $fetch_sub_data .= $endnya;
            }
            $fetch_data_new_user .= $end;
        }
        $return = '['.$fetch_data_new_user.','.$fetch_sub_data.']';
        return $return;
    } 

    private function getDataInquiry(){
        $fetch_inquiry = '';
        $fetch_sub_data = '';
        $tahun = $this->tahun();

        $inquiry = DB::table('csc_inquiry_br')
            ->select(DB::raw('extract(year from created_at) as year, count(*) as jumlah, type'))
            ->groupby('type')->groupby('year')
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->orderby('year','asc')->orderby('type','asc')
            ->limit(5)->get();

        for ($i=0; $i < 3 ; $i++) { 
            if($i == 0){
                $fetch_inquiry .= '[{"name": "Admin", "color": "#789ec5", "data": [';
                $end = ']},';
            } elseif($i == 1) {
                $fetch_inquiry .= '{"name": "Representative", "color": "#f3cb3a", "data": [';
                $end = ']},';
            } else {
                $fetch_inquiry .= '{"name": "Importer", "color": "#52e440", "data": [';
                $end = ']}]';
            }

            foreach ($inquiry as $key => $value) {
                if($i == 0 && $value->type == 'admin'){
                    $id = 'Admin-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                }

                if($i == 1 && $value->type == 'perwakilan') {
                    $id = 'Perwakilan-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                } 

                if($i == 2 && $value->type == 'importir') {
                    $id = 'Importir-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                }
            }
            $fetch_inquiry .= $end;
        }
        return $fetch_inquiry;
    }

    private function getDataTopDownloadCompany(){
        $top_download_company = DB::table('csc_download_research_corner')
        ->select(DB::raw('count(*) as jumlah, id_itdp_profil_eks'))
        ->groupby('id_itdp_profil_eks')
        ->orderby('jumlah', 'desc')
        ->limit(5)->get();

        $company = '';
        $color = array(
            0 => '#789ec5',
            1 => '#44c742',
            2 => '#c74242',
            3 => '#e69419',
            4 => '#855c9a',
        );

        foreach ($top_download_company as $key => $value) {
            if($key == 0){
                $company .= '[{"name": "Company", "data":[{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks, $key).'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            } else if ($key == count($top_download_company)-1){
                $company .= '{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks, $key).'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'}]}]';
            } else {
                $company .= '{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks, $key).'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            }
        }

        return $company;
    }

    private function getDataTopDownloadRc(){
        $top_download_rc = DB::table('csc_download_research_corner')
        ->select(DB::raw('count(*) as jumlah, id_research_corner'))
        ->groupby('id_research_corner')->orderby('jumlah', 'desc')
        ->limit(5)->get();

        $rc = '';
        $color = array(
            0 => '#855c9a',
            1 => '#e69419',
            2 => '#44c742',
            3 => '#c74242',
            4 => '#789ec5',
        );

        foreach ($top_download_rc as $key => $value) {
            if($key == 0){
                $rc .= '[{"name": "Research Corner", "data":[{"name": "'.$this->getRcName($value->id_research_corner, $key).'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            } else if ($key == count($top_download_rc)-1){
                $rc .= '{"name": "'.$this->getRcName($value->id_research_corner, $key).'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'}]}]';
            } else {
                $rc .= '{"name": "'.$this->getRcName($value->id_research_corner, $key).'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            }
        }

        return $rc;
    }

    private function getDataSub($month, $year, $param){
        if($param == "eksportir"){
            $user_perbulan = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as banyak')
                ->leftjoin('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
                ->whereRaw('extract(year from created_at) in ('.$year.')')
                ->whereRaw('extract(month from created_at) in ('.$month.')')
                ->groupby('month')
                ->first(); 
        } else {
            $user_perbulan = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as banyak')
                ->leftjoin('itdp_profil_imp as b', 'a.id_profil', '=', 'b.id')
                ->whereRaw('extract(year from created_at) in ('.$year.')')
                ->whereRaw('extract(month from created_at) in ('.$month.')')
                ->groupby('month')
                ->first(); 
        }

        if($user_perbulan){
            return '["'.$this->getMonth($month).'", '.$user_perbulan->banyak.']';
        } else {
            return '["'.$this->getMonth($month).'", 0]';
        }
    }

    private function getMonth($month){
        $array = array (
           1     => 'January',
           2     => 'February',
           3     => 'March',
           4     => 'April',
           5     => 'May',
           6     => 'June',
           7     => 'July',
           8     => 'August',
           9     => 'September',
           10    => 'October',
           11    => 'November',
           12    => 'December'
        );
        return $array[$month]; 
    }

    private function getCompanyName($id, $key){
        $data = DB::table('itdp_profil_eks')->where('id', $id)->first();
        if($data){
            return $data->company;
        } else {
            $number = $key + 1;
            return 'Company not Found '.$number; 
        }
    }

    private function getRcName($id, $key){
        $data = DB::table('csc_research_corner')->where('id', $id)->first();
        if($data){
            $banyak = DB::table('csc_research_corner')->where('title_en', $data->title_en)->get();
            if(count($banyak) > 1){
                $space = '';
                for ($i=0; $i < $key+1 ; $i++) { 
                    $space .= ' ';
                }
                return $data->title_en.' ( '.rc_country($data->id_mst_country).' )'.$space;
            } else {
                return $data->title_en.' ( '.rc_country($data->id_mst_country).' )';
            }
        } else {
            $number = $key + 1;
            return 'Name not Found '.$number;
        }
    }

    private function tahun(){
        $tahun='';
        for($year = intval(date('Y')); $year >= date('Y')-4; $year--){
            if($year == date('Y')-4){
                $tahun .= $year;
            } else {
                $tahun .= $year.',';
            }
        }
        return $tahun;
    }
}
