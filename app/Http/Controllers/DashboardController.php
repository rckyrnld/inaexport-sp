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
            $event          = $this->getDataEvent();
            $training       = $this->getDataTraining();
            $table_top_event = [];
            $table_top_join_event = [];

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

            $table_top_buying = DB::table('csc_buying_request_join')
                ->select(DB::raw('count(*) as jumlah, id_eks'))
                ->groupby('id_eks')
                ->orderby('jumlah', 'desc')
                ->limit(5)->get();

            $table_top_training = DB::table('training_join')
                ->select(DB::raw('count(*) as jumlah, id_training_admin'))
                ->where('status', 1)
                ->groupby('id_training_admin')
                ->orderby('jumlah','desc')->get();

            $table_top_join_training = DB::table('training_join')
                ->select(DB::raw('count(*) as jumlah, id_profil_eks'))
                ->where('status', 1)
                ->groupby('id_profil_eks')
                ->orderby('jumlah','desc')->get();
            // DATA EVENT
         $notif_event = DB::table('notif')
            ->select(DB::raw('count(*) as jumlah, untuk_id as id_itdp_profil_eks'))
            ->where('url_terkait', 'event/show/read')
            ->where('status', 2)
            ->groupby('untuk_id')
            ->orderby('jumlah', 'desc')
            ->get();
         $tambahan_event = DB::table('event_company_add')
            ->select(DB::raw('count(*) as jumlah, id_itdp_profil_eks'))
            ->where('status', 2)
            ->groupby('id_itdp_profil_eks')
            ->orderby('jumlah','desc')->get();
         $merge = $tambahan_event->merge($notif_event);
            foreach ($merge as $key => $value) {
                if(isset($table_top_join_event[$value->id_itdp_profil_eks])){
                    $table_top_join_event[$value->id_itdp_profil_eks] += $value->jumlah;
                } else {
                    $table_top_join_event[$value->id_itdp_profil_eks] = intval($value->jumlah);
                }
            }
         arsort($table_top_join_event);
         $table_top_join_event = array_slice($table_top_join_event, 0, 5, true);

         $notif_event2 = DB::table('notif')
            ->select(DB::raw('count(*) as jumlah, id_terkait as id_event'))
            ->where('url_terkait', 'event/show/read')
            ->where('status', 2)
            ->groupby('id_terkait')
            ->orderby('jumlah', 'desc')
            ->get();
         $tambahan_event2 = DB::table('event_company_add')
            ->select(DB::raw('count(*) as jumlah, id_event_detail as id_event'))
            ->where('status', 2)
            ->groupby('id_event_detail')
            ->orderby('jumlah','desc')->get();
         $merge2 = $tambahan_event2->merge($notif_event2);
            foreach ($merge2 as $key => $value) {
                if(isset($table_top_event[$value->id_event])){
                    $table_top_event[$value->id_event] += $value->jumlah;
                } else {
                    $table_top_event[$value->id_event] = intval($value->jumlah);
                }
            }
         arsort($table_top_event);
         $table_top_event = array_slice($table_top_event, 0, 5, true);
         // END OF DATA EVENT
            return view('Dashboard.Admin',compact('pageTitle', 'table_download_company', 'table_download_rc', 'table_inquiry', 'table_top_buying','table_top_join_event','table_top_event','table_top_training','table_top_join_training'))->with('Top_Company_Download', json_decode($company, true))->with('Top_Downloaded_RC', json_decode($rc, true))->with('User', json_decode($user, true))->with('Inquiry', json_decode($inquiry, true))->with('Top_Inquiry', json_decode($top_inquiry, true))->with('Buying', json_decode($buying, true))->with('Event', json_decode($event, true))->with('Training', json_decode($training, true));

        } elseif(Auth::user()->id_group == 4) {
            $pageTitle      = "Dashboard";
            $id_user = Auth::user()->id;
            if(Auth::user()->id_admin_ln == 0){
                $ambil = DB::table('itdp_admin_dn')->where('id', Auth::user()->id_admin_dn)->first();
            } else {
                $ambil = DB::table('itdp_admin_ln')->where('id', Auth::user()->id_admin_ln)->first();
            }
            $country = $ambil->id_country;

            $member = $this->getMemberPerwakilan($country);
            $inquiry = $this->getInquiryPerwakilan($id_user);
            $buying = $this->getBuyingPerwakilan($id_user);

            return view('Dashboard.Perwakilan',compact('pageTitle'))->with('User', json_decode($member, true))->with('Inquiry', json_decode($inquiry, true))->with('Buying', json_decode($buying, true));
        } else {
            return redirect('/');
        }
    }


// Start Data Dashboard Admin
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
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'eksportir', 'user');
                    } else {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'importir', 'user');
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
        $tahun_awal = [];
        $tahun_akhir = $this->getLastCondition('csc_inquiry_br', 'created_at', 'type', 'importir');
        $tahun = $this->tahun();

        $inquiry = DB::table('csc_inquiry_br')
            ->select(DB::raw('extract(year from created_at) as year, count(*) as jumlah, type'))
            ->groupby('type')->groupby('year')
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->orderby('year','asc')->orderby('type','asc')
            ->get();

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

            $tahun = 9999;
            foreach ($inquiry as $key => $value) {
                if($i == 0 && $value->type == 'admin'){
                    if(!in_array($value->year, $tahun_awal)){
                        array_push($tahun_awal, $value->year);
                    }
                    $id = 'Admin-'.$value->year;
                    if (intval($value->year) > intval($tahun)) {
                        $fetch_inquiry .= ',{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    }

                    // Data Drilldown
                    if($value->year == min($tahun_awal)){
                        $fetch_sub_data .= '[{"name": "Admin", "id": "'.$id.'", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Admin", "id": "'.$id.'", "data": [';
                    }

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'admin', 'inquiry');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }

                if($i == 1 && $value->type == 'perwakilan') {
                    $id = 'Perwakilan-'.$value->year;
                    if (intval($value->year) > intval($tahun)) {
                        $fetch_inquiry .= ',{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    }

                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Perwakilan", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'perwakilan', 'inquiry');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                } 

                if($i == 2 && $value->type == 'importir') {
                    $id = 'Importir-'.$value->year;
                    if (intval($value->year) > intval($tahun)) {
                        $fetch_inquiry .= ',{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    } else {
                        $fetch_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    }
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Importir", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'importir', 'inquiry');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    if($value->year == $tahun_akhir){
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
        $tahun = $this->tahun();
        $tahun_akhir = $this->getLastCondition('csc_buying_request', 'date', 'by_role', 3);
        $tahun_awal = [];
        

        $buying = DB::table('csc_buying_request')
            ->select(DB::raw('extract(year from date) as year, count(*) as jumlah, by_role as type'))
            ->groupby('type')->groupby('year')
            ->whereRaw('extract(year from date) in ('.$tahun.')')
            ->orderby('year','asc')->orderby('type','asc')
            ->get();

        for ($i=0; $i < 3 ; $i++) { 
            if($i == 0){
                $fetch_buying .= '[{"name": "Admin", "color": "#4cd25c", "data": [';
                $end = ']},';
            } elseif($i == 1) {
                $fetch_buying .= '{"name": "Representative", "color": "#8085e9", "data": [';
                $end = ']},';
            } else {
                $fetch_buying .= '{"name": "Importer", "color": "#855c9a", "data": [';
                $end = ']}]';
            }

            $tahun = 9999;
            foreach ($buying as $key => $value) {
                if($i == 0 && $value->type == 1){
                    if(!in_array($value->year, $tahun_awal)){
                        array_push($tahun_awal, $value->year);
                    }
                    $id = 'Admin-'.$value->year;
                    if (intval($value->year) > intval($tahun)) {
                        $fetch_buying .= ',{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    } else {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    }
                    // Data Drilldown
                    if($value->year == min($tahun_awal)){
                        $fetch_sub_data .= '[{"name": "Admin", "id": "'.$id.'", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Admin", "id": "'.$id.'", "data": [';
                    }

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 1, 'buying');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }

                if($i == 1 && $value->type == 4) {
                    $id = 'Perwakilan-'.$value->year;
                    if (intval($value->year) > intval($tahun)) {
                        $fetch_buying .= ',{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    } else {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    }
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Perwakilan", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 4, 'buying');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                } 

                if($i == 2 && $value->type == 3) {
                    $id = 'Importir-'.$value->year;
                    if (intval($value->year) > intval($tahun)) {
                        $fetch_buying .= ',{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    } else {
                        $fetch_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$id.'"}';
                        $tahun = $value->year;
                    }
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Importir", "id": "'.$id.'", "data": [';

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 3, 'buying');
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    if($value->year == $tahun_akhir){
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
        $tahun = $this->tahun();

        $color = array(
            0 => '#A93226',
            1 => '#884EA0',
            2 => '#2471A3',
            3 => '#229954',
            4 => '#D68910',
        );

        $event = DB::table('event_detail')
            ->select(DB::raw('extract(year from created_at) as year, count(*) as jumlah'))
            ->groupby('year')
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->orderby('year','asc')
            ->limit(5)->get();

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
                    $fetch_sub_data .= $this->getDataSub($m, $value->year, 0, 'event');
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

    private function getDataTraining(){
        $fetch_training = '';
        $fetch_sub_data = '';
        $tampung_tahun = [];
        $tahun = $this->tahun();

        $color = array(
            0 => '#EC7063',
            1 => '#AF7AC5',
            2 => '#3498DB',
            3 => '#2ECC71',
            4 => '#D4AC0D',
        );

        $training = DB::table('training_admin')
            ->select(DB::raw('extract(year from start_date) as year, count(*) as jumlah'))
            ->groupby('year')
            ->whereRaw('extract(year from start_date) in ('.$tahun.')')
            ->orderby('year','asc')
            ->limit(5)->get();

        $fetch_training .= '[{"name": "Training", "data": [';
            foreach ($training as $key => $value) {
                if(!in_array($value->year, $tampung_tahun)){
                    array_push($tampung_tahun, $value->year);
                }

                if ($value->year === date('Y')) {
                    $fetch_training .= '{"name": "'.$value->year.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.', "drilldown": "'.$value->year.'"}';
                    $endnya = ']}]';
                } else {
                    $fetch_training .= '{"name": "'.$value->year.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.', "drilldown": "'.$value->year.'"},';
                    $endnya = ']},';
                }
                // Data Drilldown
                if($value->year == min($tampung_tahun)){
                    $fetch_sub_data .= '[{"name": "Training", "id": "'.$value->year.'", "data": [';
                } else {
                    $fetch_sub_data .= '{"name": "Training", "id": "'.$value->year.'", "data": [';
                }

                for ($m=1; $m < 13; $m++) { 
                    $fetch_sub_data .= $this->getDataSub($m, $value->year, 0, 'training');
                    if($m != 12){
                        $fetch_sub_data .= ',';
                    }
                }

                $fetch_sub_data .= $endnya;
            }

        $fetch_training .= ']}]';

        $return = '['.$fetch_training.','.$fetch_sub_data.']';
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
            0 => '#e45344',
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

    private function getDataSub($month, $year, $param, $jenis){
        if($jenis == 'user'){
            if($param == "eksportir"){
                $data = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as jumlah')
                    ->leftjoin('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
                    ->whereRaw('extract(year from created_at) in ('.$year.')')
                    ->whereRaw('extract(month from created_at) in ('.$month.')')
                    ->groupby('month')
                    ->first(); 
            } else {
                $data = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as jumlah')
                    ->leftjoin('itdp_profil_imp as b', 'a.id_profil', '=', 'b.id')
                    ->whereRaw('extract(year from created_at) in ('.$year.')')
                    ->whereRaw('extract(month from created_at) in ('.$month.')')
                    ->groupby('month')
                    ->first(); 
            }
        } else if($jenis == 'inquiry'){
            $data = DB::table('csc_inquiry_br')
                ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah, type'))
                ->where('type', $param)
                ->whereRaw('extract(year from created_at) in ('.$year.')')
                ->whereRaw('extract(month from created_at) in ('.$month.')')
                ->groupby('month')
                ->groupby('type')
                ->first();
        } else if($jenis == 'buying'){
            $data = DB::table('csc_buying_request')
                ->select(DB::raw('extract(month from date) as month, count(*) as jumlah, by_role as type'))
                ->where('by_role', $param)
                ->whereRaw('extract(year from date) in ('.$year.')')
                ->whereRaw('extract(month from date) in ('.$month.')')
                ->groupby('month')
                ->groupby('type')
                ->first();
        } else if($jenis == 'event'){
            $data = DB::table('event_detail')
                ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from created_at) in ('.$year.')')
                ->whereRaw('extract(month from created_at) in ('.$month.')')
                ->groupby('month')
                ->first();
        } else if($jenis == 'training'){
            $data = DB::table('training_admin')
                ->select(DB::raw('extract(month from start_date) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from start_date) in ('.$year.')')
                ->whereRaw('extract(month from start_date) in ('.$month.')')
                ->groupby('month')
                ->first();
        }

        if($data){
            return '["'.$this->getMonth($month).'", '.$data->jumlah.']';
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

    private function getLastCondition($table, $param, $type, $param_type){
        $data = DB::table($table)
                ->select(DB::raw('extract(year from '.$param.') as year'))
                ->groupby('year')
                ->where($type, $param_type)
                ->orderby('year', 'desc')
                ->first(); 
        return $data->year;
    }

// End Data Dashboard Admin

// Start Data Dashboard Perwakilan
    private function getMemberPerwakilan($country){
        $fetch_data_new_user = '';
        $fetch_sub_data = '';
        $tampung_tahun = [];
        $tahun = $this->tahun();

        $color = array(
            0 => '#855c9a',
            1 => '#e69419',
            2 => '#44c742',
            3 => '#c74242',
            4 => '#789ec5',
        );

        $new_user = DB::table('itdp_company_users as a')->selectRaw('extract(year from created_at) as year, count(b.id) as jumlah')
            ->leftjoin('itdp_profil_imp as b', 'a.id_profil', '=', 'b.id')
            ->where('b.id_mst_country', $country)
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->groupby('year')
            ->limit(5)->get();

        if(count($new_user) > 0){
            $fetch_data_new_user .= '[{"name": "Buyer", "data": [';
                foreach ($new_user as $key => $value) {
                    if(!in_array($value->year, $tampung_tahun)){
                        array_push($tampung_tahun, $value->year);
                    }

                    if ($value->year === date('Y')) {
                        $fetch_data_new_user .= '{"name": "'.$value->year.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.', "drilldown": "'.$value->year.'"}';
                        $endnya = ']}]';
                    } else {
                        $fetch_data_new_user .= '{"name": "'.$value->year.'", "color": "'.$color[$key].'", "y": '.$value->jumlah.', "drilldown": "'.$value->year.'"},';
                        $endnya = ']},';
                    }
                    // Data Drilldown
                    if($value->year == min($tampung_tahun)){
                        $fetch_sub_data .= '[{"name": "Buyer", "id": "'.$value->year.'", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Buyer", "id": "'.$value->year.'", "data": [';
                    }

                    for ($m=1; $m < 13; $m++) { 
                        $fetch_sub_data .= $this->getDataSubPerwakilan($m, $value->year, $country, 'user', 0);
                        if($m != 12){
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= $endnya;
                }

            $fetch_data_new_user .= ']}]';
            $return = '['.$fetch_data_new_user.','.$fetch_sub_data.']';
        } else {
            $return = null;
        }

        return $return;
    } 

    private function getInquiryPerwakilan($id_user){
        $fetch_data_inquiry = '';
        $fetch_sub_data = '';
        $tampung_tahun = [];
        $tahun = $this->tahun();

        $inquiry = DB::table('csc_inquiry_br as a')->selectRaw('extract(year from created_at) as year, count(*) as jumlah')
            ->where('id_pembuat', $id_user)
            ->where('type', 'perwakilan')
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->groupby('year')
            ->limit(5)->get();

        if(count($inquiry) > 0 ){
            $tahun_akhir = $this->getLastConditionPerwakilan('csc_inquiry_br', 'created_at', 'id_pembuat = '.$id_user, 'type = \'perwakilan\'', 'type = \'perwakilan\'');
        }

        $inquiry_deal = DB::table('csc_inquiry_br as a')->selectRaw('extract(year from created_at) as year, count(*) as jumlah')
            ->where('id_pembuat', $id_user)
            ->where('type', 'perwakilan')
            ->where('status', 3)
            ->whereRaw('extract(year from created_at) in ('.$tahun.')')
            ->groupby('year')
            ->limit(5)->get();
        if(count($inquiry_deal) > 0 ){
            $tahun_akhir_2 = $this->getLastConditionPerwakilan('csc_inquiry_br', 'created_at', 'id_pembuat = '.$id_user, 'type = \'perwakilan\'', 'status = 3');
        }

        if(count($inquiry) > 0 ){
            for ($i=0; $i < 2; $i++) { 
                if ($i == 0) {
                    $fetch_data_inquiry .= '[{"name": "Inquiry", "color": "#789ec5", "data": [';
                    $data = $inquiry;
                } else {
                    $fetch_data_inquiry .= '{"name": "Deal", "color": "#44c742", "data": [';
                    $data = $inquiry_deal;
                }
                    foreach ($data as $key => $value) {
                        if ($i == 0) {
                            $jenis = 'all';
                        } else {
                            $jenis = 'deal';
                        }
                        $drilldown = $value->year.$i;

                        if(!in_array($value->year, $tampung_tahun)){
                            array_push($tampung_tahun, $value->year);
                        }

                        if ($i==0 && $value->year == $tahun_akhir) {
                            $fetch_data_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$drilldown.'"}';
                        } else if($i == 1  && $value->year == $tahun_akhir_2){
                            $fetch_data_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$drilldown.'"}';
                        } else {
                            $fetch_data_inquiry .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$drilldown.'"},';
                        }

                        if($i == 1 && $value->year == $tahun_akhir_2 || $i == 0 && count($inquiry_deal) == 0){
                            $endnya = ']}]';
                        } else {
                            $endnya = ']},';
                        }
                        // Data Drilldown
                        if($value->year == min($tampung_tahun) && $i == 0){
                            $fetch_sub_data .= '[{"name": "Inquiry", "id": "'.$drilldown.'", "data": [';
                        } else {
                            if($i == 0){
                                $fetch_sub_data .= '{"name": "Inquiry", "id": "'.$drilldown.'", "data": [';
                            } else {
                                $fetch_sub_data .= '{"name": "Deal", "id": "'.$drilldown.'", "data": [';
                            }
                        }

                        for ($m=1; $m < 13; $m++) { 
                            $fetch_sub_data .= $this->getDataSubPerwakilan($m, $value->year, $id_user, 'inquiry', $jenis);
                            if($m != 12){
                                $fetch_sub_data .= ',';
                            }
                        }

                        $fetch_sub_data .= $endnya;
                    }
                if($i == 0){
                    $fetch_data_inquiry .= ']},';
                } else {
                    $fetch_data_inquiry .= ']}]';
                }
            }
            $return = '['.$fetch_data_inquiry.','.$fetch_sub_data.']';
        } else {
            $return = null;
        }

        return $return;
    } 

    private function getBuyingPerwakilan($id_user){
        $fetch_data_buying = '';
        $fetch_sub_data = '';
        $tampung_tahun = [];
        $tahun = $this->tahun();

        $color = array(
            0 => '#855c9a',
            1 => '#e69419',
            2 => '#44c742',
            3 => '#c74242',
            4 => '#789ec5',
        );

        $buying = DB::table('csc_buying_request as a')->selectRaw('extract(year from date) as year, count(*) as jumlah')
            ->where('id_pembuat', $id_user)
            ->where('by_role', 4)
            ->whereRaw('extract(year from date) in ('.$tahun.')')
            ->groupby('year')
            ->limit(5)->get();
        if(count($buying) > 0 ){
            $tahun_akhir = $this->getLastConditionPerwakilan('csc_buying_request', 'date', 'id_pembuat = '.$id_user, 'by_role = 4', 'by_role = 4');
        }

        $buying_deal = DB::table('csc_buying_request as a')->selectRaw('extract(year from date) as year, count(*) as jumlah')
            ->where('id_pembuat', $id_user)
            ->where('by_role', 4)
            ->where('status', 4)
            ->whereRaw('extract(year from date) in ('.$tahun.')')
            ->groupby('year')
            ->limit(5)->get();
        if(count($buying_deal) > 0 ){
            $tahun_akhir_2 = $this->getLastConditionPerwakilan('csc_buying_request', 'date', 'id_pembuat = '.$id_user, 'by_role = 4', 'status = 4');
        }

        if(count($buying) > 0 ){
            for ($i=0; $i < 2; $i++) { 
                if ($i == 0) {
                    $fetch_data_buying .= '[{"name": "Buying Request", "color": "#789ec5", "data": [';
                    $data = $buying;
                } else {
                    $fetch_data_buying .= '{"name": "Deal", "color": "#44c742", "data": [';
                    $data = $buying_deal;
                }
                    foreach ($data as $key => $value) {
                        if ($i == 0) {
                            $jenis = 'all';
                        } else {
                            $jenis = 'deal';
                        }
                        $drilldown = $value->year.$i;

                        if(!in_array($value->year, $tampung_tahun)){
                            array_push($tampung_tahun, $value->year);
                        }

                        if ($i==0 && $value->year == $tahun_akhir) {
                            $fetch_data_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$drilldown.'"}';
                        } else if($i == 1  && $value->year == $tahun_akhir_2){
                            $fetch_data_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$drilldown.'"}';
                        } else {
                            $fetch_data_buying .= '{"name": "'.$value->year.'", "y": '.$value->jumlah.', "drilldown": "'.$drilldown.'"},';
                        }

                        if($i == 1 && $value->year == $tahun_akhir_2 || $i == 0 && count($buying_deal) == 0){
                            $endnya = ']}]';
                        } else {
                            $endnya = ']},';
                        }
                        // Data Drilldown
                        if($value->year == min($tampung_tahun) && $i == 0){
                            $fetch_sub_data .= '[{"name": "Buying Request", "id": "'.$drilldown.'", "data": [';
                        } else {
                            if($i == 0){
                                $fetch_sub_data .= '{"name": "Buying Request", "id": "'.$drilldown.'", "data": [';
                            } else {
                                $fetch_sub_data .= '{"name": "Deal", "id": "'.$drilldown.'", "data": [';
                            }
                        }

                        for ($m=1; $m < 13; $m++) { 
                            $fetch_sub_data .= $this->getDataSubPerwakilan($m, $value->year, $id_user, 'buying', $jenis);
                            if($m != 12){
                                $fetch_sub_data .= ',';
                            }
                        }

                        $fetch_sub_data .= $endnya;
                    }
                if($i == 0){
                    $fetch_data_buying .= ']},';
                } else {
                    $fetch_data_buying .= ']}]';
                }
            }
            $return = '['.$fetch_data_buying.','.$fetch_sub_data.']';
        } else {
            $return = null;
        }

        return $return;
    } 

    private function getDataSubPerwakilan($month, $year, $param, $jenis, $jenis2){
        if($jenis == 'user'){
            $data = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as jumlah')
                ->leftjoin('itdp_profil_imp as b', 'a.id_profil', '=', 'b.id')
                ->where('b.id_mst_country', $param)
                ->whereRaw('extract(year from created_at) in ('.$year.')')
                ->whereRaw('extract(month from created_at) in ('.$month.')')
                ->groupby('month')
                ->first(); 
        } else if($jenis == 'inquiry'){
            if($jenis2 == 'all'){
                $data = DB::table('csc_inquiry_br')
                    ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                    ->where('id_pembuat', $param)
                    ->where('type', 'perwakilan')
                    ->whereRaw('extract(year from created_at) in ('.$year.')')
                    ->whereRaw('extract(month from created_at) in ('.$month.')')
                    ->groupby('month')
                    ->first();
            } else {
                $data = DB::table('csc_inquiry_br')
                    ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                    ->where('id_pembuat', $param)
                    ->where('type', 'perwakilan')
                    ->where('status', 3)
                    ->whereRaw('extract(year from created_at) in ('.$year.')')
                    ->whereRaw('extract(month from created_at) in ('.$month.')')
                    ->groupby('month')
                    ->first();
            }
        } else if($jenis == 'buying'){
            if($jenis2 == 'all'){
                $data = DB::table('csc_buying_request')
                    ->select(DB::raw('extract(month from date) as month, count(*) as jumlah, by_role as type'))
                    ->where('id_pembuat', $param)
                    ->where('by_role', 4)
                    ->whereRaw('extract(year from date) in ('.$year.')')
                    ->whereRaw('extract(month from date) in ('.$month.')')
                    ->groupby('month')
                    ->groupby('type')
                    ->first();
            } else {
                $data = DB::table('csc_buying_request')
                    ->select(DB::raw('extract(month from date) as month, count(*) as jumlah, by_role as type'))
                    ->where('id_pembuat', $param)
                    ->where('by_role', 4)
                    ->where('status', 4)
                    ->whereRaw('extract(year from date) in ('.$year.')')
                    ->whereRaw('extract(month from date) in ('.$month.')')
                    ->groupby('month')
                    ->groupby('type')
                    ->first();
            }
        } else if($jenis == 'event'){
            $data = DB::table('event_detail')
                ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from created_at) in ('.$year.')')
                ->whereRaw('extract(month from created_at) in ('.$month.')')
                ->groupby('month')
                ->first();
        } else if($jenis == 'training'){
            $data = DB::table('training_admin')
                ->select(DB::raw('extract(month from start_date) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from start_date) in ('.$year.')')
                ->whereRaw('extract(month from start_date) in ('.$month.')')
                ->groupby('month')
                ->first();
        }

        if($data){
            return '["'.$this->getMonth($month).'", '.$data->jumlah.']';
        } else {
            return '["'.$this->getMonth($month).'", 0]';
        }
    }

    private function getLastConditionPerwakilan($table, $param, $where, $where2, $where3){
        $data = DB::table($table)
                ->select(DB::raw('extract(year from '.$param.') as year'))
                ->groupby('year')
                ->whereRaw($where)
                ->whereRaw($where2)
                ->whereRaw($where3)
                ->orderby('year', 'desc')
                ->first(); 
        return $data->year;
    }
// End Data Dashboard Perwakilan
}