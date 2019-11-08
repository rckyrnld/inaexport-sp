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
            $pageTitle      = "Dashboard";
            $company        = $this->getDataTopDownloadCompany();
            $rc             = $this->getDataTopDownloadRc();
            $user           = $this->getDataUser();
            $inquiry        = $this->getDataInquiry();
            $top_inquiry    = $this->getDataTopInquiry();
            $buying         = $this->getDataBuying();
            $top_buying     = $this->getDataTopBuying();
            $event          = $this->getDataEvent();

            // DATA TABLE TOP TOP-AN
            $table_download_company = DB::table('csc_download_research_corner')
                ->select(DB::raw('count(*) as jumlah, id_itdp_profil_eks'))
                ->groupby('id_itdp_profil_eks')
                ->orderby('jumlah', 'desc')
                ->limit(5)->get();

            $table_download_rc = DB::table('csc_download_research_corner')
                ->select(DB::raw('count(*) as jumlah, id_research_corner'))
                ->groupby('id_research_corner')->orderby('jumlah', 'desc')
                ->limit(5)->get();

            $table_inquiry = DB::table('csc_inquiry_br')
                ->select(DB::raw('count(*) as jumlah, id_pembuat, type'))
                ->groupby('id_pembuat')
                ->groupby('type')
                ->orderby('jumlah', 'desc')
                ->limit(5)->get();
            
            return view('Dashboard',compact('pageTitle', 'table_download_company', 'table_download_rc', 'table_inquiry'))->with('Top_Company_Download', json_decode($company, true))->with('Top_Downloaded_RC', json_decode($rc, true))->with('User', json_decode($user, true))->with('Inquiry', json_decode($inquiry, true))->with('Top_Inquiry', json_decode($top_inquiry, true))->with('Buying', json_decode($buying, true))->with('Event', json_decode($event, true));

        } elseif(Auth::user()->id_group == 4) {
            // $this->getMemberPerwakilan();
            dd(Auth::user());
        } else {
            return redirect('/');
        }
    }


    // DATA ADMIN
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
                    if($value->year == (date('Y')-count($new_user))+1){
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
                        $fetch_sub_data .= $this->getDataSubUser($m, $value->year, 'eksportir');
                    } else {
                        $fetch_sub_data .= $this->getDataSubUser($m, $value->year, 'importir');
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
        $tampung_tahun = [];
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
                if(!in_array($value->year, $tampung_tahun)){
                    array_push($tampung_tahun, $value->year);
                }
                if($i == 0 && $value->type == 'admin'){
                    $id = 'Admin-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                    // Data Drilldown
                    if($value->year == min($tampung_tahun)){
                        $fetch_sub_data .= '[{"name": "Admin", "id": "'.$id.'", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Admin", "id": "'.$id.'", "data": [';
                    }

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSubInquiry($m, $value->year, 'admin');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }

                if($i == 1 && $value->type == 'perwakilan') {
                    $id = 'Perwakilan-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Perwakilan", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSubInquiry($m, $value->year, 'perwakilan');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                } 

                if($i == 2 && $value->type == 'importir') {
                    $id = 'Importir-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Importir", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSubInquiry($m, $value->year, 'importir');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    if($value->year == max($tampung_tahun)){
                        $fetch_sub_data .= ']}]';
                    } else {
                        $fetch_sub_data .= ']},';
                    }
                }
            }
            $fetch_inquiry .= $end;
        }
        $return = '['.$fetch_inquiry.','.$fetch_sub_data.']';
        return $return;
    }

    private function getDataBuying(){
        $fetch_buying = '';
        $fetch_sub_data = '';
        $tampung_tahun = [];
        $tahun = $this->tahun();

        $buying = DB::table('csc_buying_request')
            ->select(DB::raw('extract(year from date) as year, count(*) as jumlah, by_role as type'))
            ->groupby('type')->groupby('year')
            ->whereRaw('extract(year from date) in ('.$tahun.')')
            ->orderby('year','asc')->orderby('type','asc')
            ->limit(5)->get();


        for ($i=0; $i < 3 ; $i++) { 
            if($i == 0){
                $fetch_buying .= '[{"name": "Admin", "color": "#855c9a", "data": [';
                $end = ']},';
            } elseif($i == 1) {
                $fetch_buying .= '{"name": "Representative", "color": "#8085e9", "data": [';
                $end = ']},';
            } else {
                $fetch_buying .= '{"name": "Importer", "color": "#4cd25c", "data": [';
                $end = ']}]';
            }

            foreach ($buying as $key => $value) {
                if(!in_array($value->year, $tampung_tahun)){
                    array_push($tampung_tahun, $value->year);
                }
                if($i == 0 && $value->type == 1){
                    $id = 'Admin-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                    // Data Drilldown
                    if($value->year == min($tampung_tahun)){
                        $fetch_sub_data .= '[{"name": "Admin", "id": "'.$id.'", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Admin", "id": "'.$id.'", "data": [';
                    }

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSubBuying($m, $value->year, 1);
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }

                if($i == 1 && $value->type == 4) {
                    $id = 'Perwakilan-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Perwakilan", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSubBuying($m, $value->year, 4);
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                } 

                if($i == 2 && $value->type == 3) {
                    $id = 'Importir-'.$value->year;
                    if ($value->year === date('Y')) {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                    } else {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"},';
                    }
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Importir", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSubBuying($m, $value->year, 3);
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    if($value->year == max($tampung_tahun)){
                        $fetch_sub_data .= ']}]';
                    } else {
                        $fetch_sub_data .= ']},';
                    }
                }
            }
            $fetch_buying .= $end;
        }
        $return = '['.$fetch_buying.','.$fetch_sub_data.']';
        return $return;
    }

    private function getDataEvent(){
        $fetch_event = '';
        $fetch_sub_data = '';
        $tampung_tahun = [];
        $tahun='';
        for($year = intval(date('Y')); $year >= date('Y')-9; $year--){
            if($year == date('Y')-9){
                $tahun .= $year;
            } else {
                $tahun .= $year.',';
            }
        }

        $color = array(
            0 => '#A93226',
            1 => '#884EA0',
            2 => '#2471A3',
            3 => '#229954',
            4 => '#D4AC0D',
            5 => '#D68910',
            6 => '#2ECC71',
            7 => '#3498DB',
            8 => '#AF7AC5',
            9 => '#EC7063',
        );

        $event = DB::table('event_detail')
            ->select(DB::raw('extract(year from created_at) as year, count(*) as jumlah'))
            ->groupby('year')
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->orderby('year','asc')
            ->limit(10)->get();

        $fetch_event .= '[{"name": "Event", "data": [';
            foreach ($event as $key => $value) {
                if(!in_array($value->year, $tampung_tahun)){
                    array_push($tampung_tahun, $value->year);
                }

                if ($value->year === date('Y')) {
                    $fetch_event .= '{"name": "'.$value->year.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.', "drilldown": "'.$value->year.'"}';
                    $endnya = ']}]';
                } else {
                    $fetch_event .= '{"name": "'.$value->year.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.', "drilldown": "'.$value->year.'"},';
                    $endnya = ']},';
                }
                // Data Drilldown
                if($value->year == min($tampung_tahun)){
                    $fetch_sub_data .= '[{"name": "Event", "id": "'.$value->year.'", "data": [';
                } else {
                    $fetch_sub_data .= '{"name": "Event", "id": "'.$value->year.'", "data": [';
                }

                for ($m=1; $m < 13; $m++) { 
                    $fetch_sub_data .= $this->getDataSubEvent($m, $value->year);
                    if($m != 12){
                        $fetch_sub_data .= ',';
                    }
                }

                $fetch_sub_data .= $endnya;
            }

        $fetch_event .= ']}]';

        $return = '['.$fetch_event.','.$fetch_sub_data.']';
        return $return;
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

    private function getDataTopInquiry(){
        $top_inquiry = DB::table('csc_inquiry_br')
        ->select(DB::raw('count(*) as jumlah, id_pembuat, type'))
        ->groupby('id_pembuat')
        ->groupby('type')
        ->orderby('jumlah', 'desc')
        ->limit(5)->get();

        $inquiry = '';
        $color = array(
            0 => '#EC7063',
            1 => '#AF7AC5',
            2 => '#3498DB',
            3 => '#2ECC71',
            4 => '#D4AC0D',
            5 => '#D68910',
        );

        foreach ($top_inquiry as $key => $value) {
            switch ($value->type) {
                case 'admin':
                        $name = getAdminName($value->id_pembuat);
                    break;
                case 'perwakilan':
                        $name = getPerwakilanName($value->id_pembuat);
                    break;
                case 'importir':
                        $name = getCompanyNameImportir($value->id_pembuat);
                    break;
            }

            if($key == 0){
                $inquiry .= '[{"name": "Inquiry", "data":[{"name": "'.$name.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            } else if ($key == count($top_inquiry)-1){
                $inquiry .= '{"name": "'.$name.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'}]}]';
            } else {
                $inquiry .= '{"name": "'.$name.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            }
        }
        return $inquiry;
    }

    private function getDataTopBuying(){
        $top_buyer = DB::table('csc_buying_request')
        ->select(DB::raw('count(*) as jumlah, id_pembuat, by_role as type'))
        ->groupby('id_pembuat')
        ->groupby('by_role')
        ->orderby('jumlah', 'desc')
        ->limit(10)->get();

        $buyer = '';
        $color = array(
            0 => '#789ec5',
            1 => '#44c742',
            2 => '#c74242',
            3 => '#e69419',
            4 => '#855c9a',
            0 => '#789ec5',
            1 => '#44c742',
            2 => '#c74242',
            3 => '#e69419',
            4 => '#855c9a',
        );

        foreach ($top_buyer as $key => $value) {
            switch ($value->type) {
                case 1:
                        $name = getAdminName($value->id_pembuat).' ( Admin )';
                    break;
                case 4:
                        $name = getPerwakilanName($value->id_pembuat).' ( Representative )';
                    break;
                case 3:
                        $name = getCompanyNameImportir($value->id_pembuat).' ( Importer )';
                    break;
            }

            if($key == 0){
                $buyer .= '[{"name": "Buyer", "data":[{"name": "'.$name.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            } else if ($key == count($top_buyer)-1){
                $buyer .= '{"name": "'.$name.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'}]}]';
            } else {
                $buyer .= '{"name": "'.$name.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.'},';
            }
        }
        return $buyer;
    }

    private function getDataSubUser($month, $year, $param){
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

    private function getDataSubInquiry($month, $year, $param){
        $inquiry_perbulan = DB::table('csc_inquiry_br')
            ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah, type'))
            ->where('type', $param)
            ->whereRaw('extract(year from created_at) in ('.$year.')')
            ->whereRaw('extract(month from created_at) in ('.$month.')')
            ->groupby('month')
            ->groupby('type')
            ->first();

        if($inquiry_perbulan){
            return '["'.$this->getMonth($month).'", '.$inquiry_perbulan->jumlah.']';
        } else {
            return '["'.$this->getMonth($month).'", 0]';
        }
    }

    private function getDataSubBuying($month, $year, $param){
        $buying_perbulan = DB::table('csc_buying_request')
            ->select(DB::raw('extract(month from date) as month, count(*) as jumlah, by_role as type'))
            ->where('by_role', $param)
            ->whereRaw('extract(year from date) in ('.$year.')')
            ->whereRaw('extract(month from date) in ('.$month.')')
            ->groupby('month')
            ->groupby('type')
            ->first();

        if($buying_perbulan){
            return '["'.$this->getMonth($month).'", '.$buying_perbulan->jumlah.']';
        } else {
            return '["'.$this->getMonth($month).'", 0]';
        }
    }

    private function getDataSubEvent($month, $year){
        $event_perbulan = DB::table('event_detail')
            ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
            ->whereRaw('extract(year from created_at) in ('.$year.')')
            ->whereRaw('extract(month from created_at) in ('.$month.')')
            ->groupby('month')
            ->first();

        if($event_perbulan){
            return '["'.$this->getMonth($month).'", '.$event_perbulan->jumlah.']';
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
                return $data->title_en.$space;
            } else {
                return $data->title_en;
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

    // DATA PERWAKILAN
    private function getMemberPerwakilan(){
        $fetch_data_new_user = '';
        $fetch_sub_data = '';
        $tahun = $this->tahun();

        if(Auth::user()->id_admin_ln == 0){
            $new_user = DB::table('itdp_company_users as a')->selectRaw('extract(year from created_at) as year, count(b.id) as eksportir, count(c.id) as importir')
                ->leftjoin('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
                ->leftjoin('itdp_profil_imp as c', 'a.id_profil', '=', 'c.id')
                ->whereRaw('extract(year from created_at) in ('.$tahun.')')
                ->groupby('year')
                ->get();
        } else {
            $country = getPerwakilanCountry(Auth::user()->id_admin_ln);
            $tes = DB::table('itdp_company_users as a')->selectRaw('extract(year from created_at) as year, a.id, b.id as profil')->leftjoin('itdp_profil_imp as b', 'a.id_profil', '=', 'b.id')
            // ->where('b.id_mst_country', $country)
            ->wherein('a.id_profil', [15829,5500,16420,15807,16419,15816,16422,15809,15803,15814,16423])
            // ->limit(10)
            ->get();
            $new_user = DB::table('itdp_company_users as a')->selectRaw('extract(year from created_at) as year, count(c.id) as importir')
                ->leftjoin('itdp_profil_imp as c', 'a.id_profil', '=', 'c.id')
                ->whereRaw('extract(year from created_at) in ('.$tahun.')')
                ->where('c.id_mst_country', $country)
                ->groupby('year')
                ->get();
        }

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
                    if($value->year == (date('Y')-count($new_user))+1){
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
                        $fetch_sub_data .= $this->getDataSubUser($m, $value->year, 'eksportir');
                    } else {
                        $fetch_sub_data .= $this->getDataSubUser($m, $value->year, 'importir');
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
}
