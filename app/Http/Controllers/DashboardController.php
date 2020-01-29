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
        if (Auth::user()->id_group == 1) {
            $pageTitle = "Dashboard";
            $company = $this->getDataTopDownloadCompany();
            $rc = $this->getDataTopDownloadRc();
            $user = $this->getDataUser();
            $inquiry = $this->getDataInquiry();
            $top_inquiry = $this->getDataTopInquiry();
            $buying = $this->getDataBuying();
            $event = $this->getDataEvent();
            $training = $this->getDataTraining();
            $statistik = $this->getDataStatistik();
            $zeke = $this->getDataZeke();
            $top_event = $this->getDataTopEvent();
            $top_training = $this->getDataTopTraining();
            //            dd($zeke);

            return view('Dashboard.Admin', compact('pageTitle'))->with('Top_Company_Download', json_decode($company, true))->with('Top_Downloaded_RC', json_decode($rc, true))->with('User', json_decode($user, true))->with('Inquiry', json_decode($inquiry, true))->with('Top_Inquiry', json_decode($top_inquiry, true))->with('Buying', json_decode($buying, true))->with('Event', json_decode($event, true))->with('Training', json_decode($training, true))->with('Statistik', json_decode($statistik, true))->with('zeke', json_decode($zeke, true))->with('Top_Event', json_decode($top_event, true))->with('Top_Training', json_decode($top_training, true));

        } elseif (Auth::user()->id_group == 4) {
            $pageTitle = "Dashboard";
            $id_user = Auth::user()->id;
            if (Auth::user()->id_admin_ln == 0) {
                $ambil = DB::table('itdp_admin_dn')->where('id', Auth::user()->id_admin_dn)->first();
                $type = 'dn';
            } else {
                $ambil = DB::table('itdp_admin_ln')->where('id', Auth::user()->id_admin_ln)->first();
                $type = 'ln';
            }
            $country = $ambil->id_country;

            $member = $this->getMemberPerwakilan($country, $type);
            $inquiry = $this->getInquiryPerwakilan($id_user);
            $buying = $this->getBuyingPerwakilan($id_user);

            return view('Dashboard.Perwakilan', compact('pageTitle'))->with('User', json_decode($member, true))->with('Inquiry', json_decode($inquiry, true))->with('Buying', json_decode($buying, true));
        } else {
            return redirect('/');
        }
    }


// Start Data Dashboard Admin
    private function getDataZeke(){
        $arrayJumlah = array();
        $data = array();
        $break = false;
        $fetch_data = '[';
        
		/* $ambil = DB::select(
            "SELECT a.id, a.name, b.rc, c.inquiry, d.br, e.importir FROM itdp_admin_users AS a
             LEFT JOIN (SELECT  COUNT(*) AS rc, created_by FROM csc_research_corner GROUP BY created_by) b ON b.created_by = a.id
             LEFT JOIN (SELECT COUNT(*) AS inquiry, id_pembuat FROM csc_inquiry_br WHERE type='perwakilan' GROUP BY id_pembuat) c ON c.id_pembuat = a.id
             LEFT JOIN (SELECT COUNT(*) AS br, id_pembuat FROM csc_buying_request WHERE by_role=4 GROUP BY id_pembuat) d ON d.id_pembuat = a.id
             LEFT JOIN (SELECT COUNT(*) AS importir, verified_by FROM itdp_company_users WHERE id_role=3 GROUP BY verified_by) e on e.verified_by = a.id
             WHERE a.id_group = 4" );
        foreach ($ambil as $value) {
            $total = $value->rc + $value->inquiry + $value->br;
            $arrayJumlah[$value->id] = $total;
            $data[$value->id] = [$value->name, intval($value->inquiry), intval($value->br), intval($value->rc)];
        } */
        $year = date('Y');

        $ambil = DB::select(
            "SELECT c.company,b.id, a.tp, DATE_PART('year', to_date(a.created_at::TEXT,'YYYY')) as date FROM csc_transaksi a, itdp_company_users b, itdp_profil_eks c where a.id_eksportir = b.id and b.id_profil = c.id group by c.company,b.id,a.tp, a.created_at order by a.tp DESC" );

        foreach ($ambil as $value) {
			$qw = DB::select("select sum(tp) as suma from csc_transaksi where id_eksportir='".$value->id."' AND DATE_PART('year', to_date(csc_transaksi.created_at::TEXT,'YYYY')) = $year-2 ");
			foreach($qw as $r1){ $al1 = $r1->suma; }
			$qw2 = DB::select("select sum(tp) as sumb from csc_transaksi where id_eksportir='".$value->id."' AND DATE_PART('year', to_date(csc_transaksi.created_at::TEXT,'YYYY')) = $year-1 ");
			foreach($qw2 as $r2){ $al2 = $r2->sumb; }
            $qw3 = DB::select("select sum(tp) as sumc from csc_transaksi where id_eksportir='".$value->id."' AND DATE_PART('year', to_date(csc_transaksi.created_at::TEXT,'YYYY')) = $year ");
            foreach($qw3 as $r3){ $al3 = $r3->sumc; }
            $total = 3;
        //  $arrayJumlah[$value->id] = $total;
            $data[$value->id] = [$value->company, intval($al1), intval($al2), intval($al3)];
        }

        for($f = 0 ; $f < count($data); $f++){
            $arrayJumlah[$f] = $total;
        }

        usort($data, function($a, $b) {
            if($a[3]==$b[3]) return 0;
            return $a[3] < $b[3]?1:-1;
        });
		/*
		$data[0] = ["12", intval(200), intval(200), intval(200)];
		$data[1] = ["57", intval(200), intval(200), intval(200)];
		$data[2] = ["45", intval(200), intval(200), intval(200)]; 
		*/
        arsort($arrayJumlah);
        $arrayJumlah = array_slice($arrayJumlah, 0, 10, true);
        end($arrayJumlah);
        $LastKey = key($arrayJumlah);
        for ($i=0; $i < 3; $i++) { 
            if($i == 0){
                $fetch_data .= '{"name":"'.(Date('Y')-2).'", "data":[';
            } else if($i == 1){
                $fetch_data .= '{"name":"'.(Date('Y')- 1).'", "color":"#28a745", "data":[';
            } else if($i == 2){
                $fetch_data .= '{"name":"'.Date('Y').'", "color":"#fd7e14", "data":[';
            } 
			/*else if($i == 3){
                $fetch_data .= '{"name":"'.(Date('Y')- 3).'", "color":"#ffc107", "data":[';
            } */
            foreach ($arrayJumlah as $key => $value) {
                if($value == 0){
                    break;
                }
                //ini dirubah yaa $ nya
            //                $fetch_data .= '{"name": "'.$data[$key][0].'", "y": $'.$data[$key][$i+1].'},';
                $fetch_data .= '{"name": "'.$data[$key][0].'", "y": '.$data[$key][$i+1].'},';
            }
            $fetch_data = rtrim($fetch_data, ", ");
            $fetch_data .= ']},';
        }
        $fetch_data = rtrim($fetch_data, ", ");
        $fetch_data .= ']';
        return $fetch_data;
    }
	
	private function getDataStatistik(){
        $arrayJumlah = array();
        $data = array();
        $break = false;
        $fetch_data = '[';
        $ambil = DB::select(
            "SELECT a.id, a.name, b.rc, c.inquiry, d.br, e.importir FROM itdp_admin_users AS a
             LEFT JOIN (SELECT  COUNT(*) AS rc, created_by FROM csc_research_corner GROUP BY created_by) b ON b.created_by = a.id
             LEFT JOIN (SELECT COUNT(*) AS inquiry, id_pembuat FROM csc_inquiry_br WHERE type='perwakilan' GROUP BY id_pembuat) c ON c.id_pembuat = a.id
             LEFT JOIN (SELECT COUNT(*) AS br, id_pembuat FROM csc_buying_request WHERE by_role=4 GROUP BY id_pembuat) d ON d.id_pembuat = a.id
             LEFT JOIN (SELECT COUNT(*) AS importir, verified_by FROM itdp_company_users WHERE id_role=3 GROUP BY verified_by) e on e.verified_by = a.id
             WHERE a.id_group = 4");
        foreach ($ambil as $value) {
            $total = $value->rc + $value->inquiry + $value->br;
            $arrayJumlah[$value->id] = $total;
            $data[$value->id] = [$value->name, intval($value->inquiry), intval($value->br), intval($value->importir), intval($value->rc)];
        }
        arsort($arrayJumlah);
        $arrayJumlah = array_slice($arrayJumlah, 0, 10, true);
        end($arrayJumlah);
        $LastKey = key($arrayJumlah);
        for ($i=0; $i < 4; $i++) { 
            if($i == 0){
                $fetch_data .= '{"name":"Inquiry", "data":[';
            } else if($i == 1){
                $fetch_data .= '{"name":"BR", "color":"#28a745", "data":[';
            } else if($i == 2){
                $fetch_data .= '{"name":"Importer (Verified)", "color":"#fd7e14", "data":[';
            } else if($i == 3){
                $fetch_data .= '{"name":"RC Upload", "color":"#ffc107", "data":[';
            }
            foreach ($arrayJumlah as $key => $value) {
                if($value == 0){
                    break;
                }
                $fetch_data .= '{"name": "'.$data[$key][0].'", "y": '.$data[$key][$i+1].'},';
            }
            $fetch_data = rtrim($fetch_data, ", ");
            $fetch_data .= ']},';
        }
        $fetch_data = rtrim($fetch_data, ", ");
        $fetch_data .= ']';
        //        dd($fetch_data);
        return $fetch_data;
    }

    private function getDataUser()
    {
        $fetch_data_new_user = '[';
        $fetch_sub_data = '[';
        $tahun = $this->tahun();

        $new_user = DB::table('itdp_company_users as a')->selectRaw('extract(year from created_at) as year, count(b.id) as eksportir, count(c.id) as importir')
            ->leftjoin('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
            ->leftjoin('itdp_profil_imp as c', 'a.id_profil', '=', 'c.id')
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->groupby('year')
            ->get();
            
        for ($i = 0; $i < 2; $i++) {
            if ($i == 0) {
                $fetch_data_new_user .= '{"name": "Exporter", "color": "#4cd25c", "data": [';
            } else {
                $fetch_data_new_user .= '{"name": "Importer", "color": "#8085e9", "data": [';
            }
            foreach ($new_user as $key => $value) {
                if ($i == 0) {
                    $jumlah = $value->eksportir;
                    $id = 'Ex-' . $value->year;
                    $fetch_sub_data .= '{"name": "Exporter", "id": "Ex-' . $value->year . '", "data": [';
                } else {
                    $jumlah = $value->importir;
                    $id = 'Imp-' . $value->year;
                    $fetch_sub_data .= '{"name": "Importer", "id": "Imp-' . $value->year . '", "data": [';
                }

                $fetch_data_new_user .= '{"name": "' . $value->year . '", "y": ' . $jumlah . ', "drilldown": "' . $id . '"},';

                for ($m = 1; $m < 13; $m++) {
                    if ($i == 0) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'eksportir', 'user');
                    } else {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'importir', 'user');
                    }
                    if ($m != 12) {
                        $fetch_sub_data .= ',';
                    }
                }
                $fetch_sub_data .= ']},';
            }
            $fetch_data_new_user = rtrim($fetch_data_new_user,',').']},';
        }
        $fetch_sub_data = rtrim($fetch_sub_data, ',').']';
        $fetch_data_new_user = rtrim($fetch_data_new_user, ',').']';
        $return = '[' . $fetch_data_new_user . ',' . $fetch_sub_data . ']';
        return $return;
    }

    private function getDataInquiry()
    {
        $fetch_inquiry = '[';
        $fetch_sub_data = '[';
        $tahun = $this->tahun();

        $inquiry = DB::table('csc_inquiry_br')
            ->select(DB::raw('extract(year from created_at) as year, count(*) as jumlah, type'))
            ->groupby('type')->groupby('year')
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->orderby('year', 'asc')->orderby('type', 'asc')
            ->get();

        for ($i = 0; $i < 3; $i++) {
            if ($i == 0) {
                $fetch_inquiry .= '{"name": "Admin", "color": "#789ec5", "data": [';
            } elseif ($i == 1) {
                $fetch_inquiry .= '{"name": "Representative", "color": "#f3cb3a", "data": [';
            } else {
                $fetch_inquiry .= '{"name": "Importer", "color": "#52e440", "data": [';
            }

            foreach ($inquiry as $key => $value) {
                if ($i == 0 && $value->type == 'admin') {
                    $id = 'Admin-' . $value->year;
                    $fetch_inquiry .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $id . '"},';

                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Admin", "id": "' . $id . '", "data": [';

                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'admin', 'inquiry');
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }

                if ($i == 1 && $value->type == 'perwakilan') {
                    $id = 'Perwakilan-' . $value->year;
                    $fetch_inquiry .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $id . '"},';

                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Perwakilan", "id": "' . $id . '", "data": [';

                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'perwakilan', 'inquiry');
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }

                if ($i == 2 && $value->type == 'importir') {
                    $id = 'Importir-' . $value->year;
                    $fetch_inquiry .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $id . '"},';
                    
                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Importir", "id": "' . $id . '", "data": [';

                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'importir', 'inquiry');
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }
            }
            $fetch_inquiry = rtrim($fetch_inquiry,',').']},';
        }
        $fetch_sub_data = rtrim($fetch_sub_data,',').']';
        $fetch_inquiry = rtrim($fetch_inquiry,',').']';
        $return = '[' . $fetch_inquiry . ',' . $fetch_sub_data . ']';
        return $return;
    }

    private function getDataBuying()
    {
        $fetch_buying = '[';
        $fetch_sub_data = '[';
        $tahun = $this->tahun();

        $buying = DB::table('csc_buying_request')
            ->select(DB::raw('extract(year from date) as year, count(*) as jumlah, by_role as type'))
            ->groupby('type')->groupby('year')
            ->whereRaw('extract(year from date) in (' . $tahun . ')')
            ->orderby('year', 'asc')->orderby('type', 'asc')
            ->get();

        for ($i = 0; $i < 3; $i++) {
            if ($i == 0) {
                $fetch_buying .= '{"name": "Admin", "color": "#4cd25c", "data": [';
            } elseif ($i == 1) {
                $fetch_buying .= '{"name": "Representative", "color": "#8085e9", "data": [';
            } else {
                $fetch_buying .= '{"name": "Importer", "color": "#855c9a", "data": [';
            }

            foreach ($buying as $key => $value) {
                if ($i == 0 && $value->type == 1) {
                    $id = 'Admin-' . $value->year;
                    $fetch_buying .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $id . '"},';

                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Admin", "id": "' . $id . '", "data": [';
                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 1, 'buying');
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }
                    $fetch_sub_data .= ']},';
                }

                if ($i == 1 && $value->type == 4) {
                    $id = 'Perwakilan-' . $value->year;
                    $fetch_buying .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $id . '"},';

                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Perwakilan", "id": "' . $id . '", "data": [';
                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 4, 'buying');
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }
                    $fetch_sub_data .= ']},';
                }

                if ($i == 2 && $value->type == 3) {
                    $id = 'Importir-' . $value->year;
                    $fetch_buying .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $id . '"},';

                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "Importir", "id": "' . $id . '", "data": [';
                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 3, 'buying');
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }
                    $fetch_sub_data .= ']},';
                }
            }
            $fetch_buying = rtrim($fetch_buying, ',').']},';
        }
        $fetch_sub_data = rtrim($fetch_sub_data,',').']';
        $fetch_buying = rtrim($fetch_buying,',').']';
        $return = '[' . $fetch_buying . ',' . $fetch_sub_data . ']';
        return $return;
    }

    private function getDataEvent()
    {
        $fetch_event = '[';
        $fetch_sub_data = '[';
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
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->orderby('year', 'asc')
            ->limit(5)->get();

        $fetch_event .= '{"name": "Event", "data": [';
        foreach ($event as $key => $value) {
            $fetch_event .= '{"name": "' . $value->year . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . ', "drilldown": "' . $value->year . '"},';

            // Data Drilldown
            $fetch_sub_data .= '{"name": "Event", "id": "' . $value->year . '", "data": [';
            for ($m = 1; $m < 13; $m++) {
                $fetch_sub_data .= $this->getDataSub($m, $value->year, 0, 'event');
                if ($m != 12) {
                    $fetch_sub_data .= ',';
                }
            }
            $fetch_sub_data .= ']},';
        }

        $fetch_sub_data = rtrim($fetch_sub_data, ',').']';
        $fetch_event = rtrim($fetch_event, ',').']}]';

        $return = '[' . $fetch_event . ',' . $fetch_sub_data . ']';
        return $return;
    }

    private function getDataTopEvent()
    {
        $event = DB::table('event_detail as a')
            ->join('event_interest as b', 'a.id','b.id_event')
            ->select(DB::raw('count(b.*) as jumlah, id_event, a.event_name_en as nama'))
            ->groupby('id_event')
            ->groupby('nama')
            ->orderby('jumlah', 'desc')
            ->limit(5)->get();
        $fetch_data = '[{"name": "Event", "data":[';
        $color = array(
            0 => '#789ec5',
            1 => '#44c742',
            2 => '#c74242',
            3 => '#e69419',
            4 => '#855c9a',
        );

        foreach ($event as $key => $value) {
            $fetch_data .= '{"name": "' . $value->nama . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . '},';
        }
        $fetch_data = rtrim($fetch_data, ',').']}]';
        return $fetch_data;
    }

    private function getDataTraining()
    {
        $fetch_training = '[';
        $fetch_sub_data = '[';
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
            ->whereRaw('extract(year from start_date) in (' . $tahun . ')')
            ->orderby('year', 'asc')
            ->limit(5)->get();

        $fetch_training .= '{"name": "Training", "data": [';
        foreach ($training as $key => $value) {
            $fetch_training .= '{"name": "' . $value->year . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . ', "drilldown": "' . $value->year . '"},';

            // Data Drilldown
            $fetch_sub_data .= '{"name": "Training", "id": "' . $value->year . '", "data": [';
            for ($m = 1; $m < 13; $m++) {
                $fetch_sub_data .= $this->getDataSub($m, $value->year, 0, 'training');
                if ($m != 12) {
                    $fetch_sub_data .= ',';
                }
            }

            $fetch_sub_data .= ']},';
        }

        $fetch_sub_data = rtrim($fetch_sub_data, ',').']';
        $fetch_training = rtrim($fetch_training, ',').']}]';

        $return = '[' . $fetch_training . ',' . $fetch_sub_data . ']';
        return $return;
    }

    private function getDataTopTraining()
    {
        $training = DB::table('training_admin as a')
            ->join('training_interest as b', 'a.id','b.id_training')
            ->select(DB::raw('count(b.*) as jumlah, id_training, a.training_en as nama'))
            ->groupby('id_training')
            ->groupby('nama')
            ->orderby('jumlah', 'desc')
            ->limit(5)->get();
        $fetch_data = '[{"name": "Training", "data":[';
        $color = array(
            0 => '#855c9a',
            1 => '#e69419',
            2 => '#44c742',
            3 => '#c74242',
            4 => '#789ec5',
        );

        foreach ($training as $key => $value) {
            $fetch_data .= '{"name": "' . $value->nama . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . '},';
        }
        $fetch_data = rtrim($fetch_data, ',').']}]';
        return $fetch_data;
    }

    private function getDataTopDownloadCompany()
    {
        $top_download_company = DB::table('csc_download_research_corner')
            ->join('itdp_company_users', 'itdp_company_users.id_profil','csc_download_research_corner.id_itdp_profil_eks')
            ->select(DB::raw('count(*) as jumlah, id_itdp_profil_eks'))
            ->groupby('id_itdp_profil_eks')
            ->orderby('jumlah', 'desc')
            ->limit(5)->get();
        $company = '[{"name": "Company", "data":[';
        $color = array(
            0 => '#789ec5',
            1 => '#44c742',
            2 => '#c74242',
            3 => '#e69419',
            4 => '#855c9a',
        );

        foreach ($top_download_company as $key => $value) {
            $company .= '{"name": "' . $this->getCompanyName($value->id_itdp_profil_eks, $key) . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . '},';
        }
        $company = rtrim($company, ',').']}]';
        return $company;
    }

    private function getDataTopDownloadRc()
    {
        $top_download_rc = DB::table('csc_download_research_corner')
            ->select(DB::raw('count(*) as jumlah, id_research_corner'))
            ->groupby('id_research_corner')->orderby('jumlah', 'desc')
            ->limit(5)->get();

        $rc = '[{"name": "Research Corner", "data":[';
        $color = array(
            0 => '#855c9a',
            1 => '#e69419',
            2 => '#44c742',
            3 => '#c74242',
            4 => '#789ec5',
        );

        foreach ($top_download_rc as $key => $value) {
           $rc .= '{"name": "' . $this->getRcName($value->id_research_corner, $key) . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . '},';
        }
        $rc = rtrim($rc, ',').']}]';
        return $rc;
    }

    private function getDataTopInquiry()
    {
        $top_inquiry = DB::table('csc_inquiry_br')
            ->select(DB::raw('count(*) as jumlah, id_pembuat, type'))
            ->groupby('id_pembuat')
            ->groupby('type')
            ->orderby('jumlah', 'desc')
            ->limit(5)->get();

        $inquiry = '[{"name": "Inquiry", "data":[';
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
            $inquiry .= '{"name": "' . $name . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . '},';
        }
        $inquiry = rtrim($inquiry, ',').']}]';
        return $inquiry;
    }

    private function getDataSub($month, $year, $param, $jenis)
    {
        if ($jenis == 'user') {
            if ($param == "eksportir") {
                $data = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as jumlah')
                    ->leftjoin('itdp_profil_eks as b', 'a.id_profil', '=', 'b.id')
                    ->whereRaw('extract(year from created_at) in (' . $year . ')')
                    ->whereRaw('extract(month from created_at) in (' . $month . ')')
                    ->groupby('month')
                    ->first();
            } else {
                $data = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as jumlah')
                    ->leftjoin('itdp_profil_imp as b', 'a.id_profil', '=', 'b.id')
                    ->whereRaw('extract(year from created_at) in (' . $year . ')')
                    ->whereRaw('extract(month from created_at) in (' . $month . ')')
                    ->groupby('month')
                    ->first();
            }
        } else if ($jenis == 'inquiry') {
            $data = DB::table('csc_inquiry_br')
                ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah, type'))
                ->where('type', $param)
                ->whereRaw('extract(year from created_at) in (' . $year . ')')
                ->whereRaw('extract(month from created_at) in (' . $month . ')')
                ->groupby('month')
                ->groupby('type')
                ->first();
        } else if ($jenis == 'buying') {
            $data = DB::table('csc_buying_request')
                ->select(DB::raw('extract(month from date) as month, count(*) as jumlah, by_role as type'))
                ->where('by_role', $param)
                ->whereRaw('extract(year from date) in (' . $year . ')')
                ->whereRaw('extract(month from date) in (' . $month . ')')
                ->groupby('month')
                ->groupby('type')
                ->first();
        } else if ($jenis == 'event') {
            $data = DB::table('event_detail')
                ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from created_at) in (' . $year . ')')
                ->whereRaw('extract(month from created_at) in (' . $month . ')')
                ->groupby('month')
                ->first();
        } else if ($jenis == 'training') {
            $data = DB::table('training_admin')
                ->select(DB::raw('extract(month from start_date) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from start_date) in (' . $year . ')')
                ->whereRaw('extract(month from start_date) in (' . $month . ')')
                ->groupby('month')
                ->first();
        }

        if ($data) {
            return '["' . $this->getMonth($month) . '", ' . $data->jumlah . ']';
        } else {
            return '["' . $this->getMonth($month) . '", 0]';
        }
    }

// End Data Dashboard Admin

// Start Data Dashboard Perwakilan
    private function getMemberPerwakilan($country, $jenis)
    {
        $fetch_data_new_user = '';
        $fetch_sub_data = '[';
        $tahun = $this->tahun();

        $color = array(
            0 => '#855c9a',
            1 => '#e69419',
            2 => '#44c742',
            3 => '#c74242',
            4 => '#789ec5',
        );

        if ($jenis == 'dn') {
            $param = 'id_mst_province';
            $profil = 'eks';
            $nama = 'Exporter';
            $country = [$country];
        } else {
            $param = 'id_mst_country';
            $profil = 'imp';
            $nama = 'Buyer';
            $db = DB::table('mst_country')->where('id',$country)->first();
            if($db){
                $db = DB::table('mst_country')->where('mst_country_group_id',$db->mst_country_group_id)->get();
                $country = [];
                foreach ($db as $key => $value) {
                    array_push($country, $value->id);
                }
            } else {
                $country = [$country];
            }
        }

        $new_user = DB::table('itdp_company_users as a')->selectRaw('extract(year from created_at) as year, count(b.id) as jumlah')
            ->leftjoin('itdp_profil_' . $profil . ' as b', 'a.id_profil', '=', 'b.id')
            ->whereIn('b.' . $param, $country)
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->groupby('year')
            ->limit(5)->get();

        if (count($new_user) > 0) {
            $fetch_data_new_user .= '[{"name": "' . $nama . '", "data": [';
            foreach ($new_user as $key => $value) {
                $fetch_data_new_user .= '{"name": "' . $value->year . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . ', "drilldown": "' . $value->year . '"},';

                // Data Drilldown
                $fetch_sub_data .= '{"name": "' . $nama . '", "id": "' . $value->year . '", "data": [';
                for ($m = 1; $m < 13; $m++) {
                    $fetch_sub_data .= $this->getDataSubPerwakilan($m, $value->year, $country, 'user', $jenis);
                    if ($m != 12)
                        $fetch_sub_data .= ',';
                    else
                        $fetch_sub_data .= ']},';
                }

            }

            $fetch_data_new_user = rtrim($fetch_data_new_user, ',').']}]';
            $fetch_sub_data = rtrim($fetch_sub_data, ',').']';
            $return = '[' . $fetch_data_new_user . ',' . $fetch_sub_data . ']';
        } else {
            $return = null;
        }

        return $return;
    }

    private function getInquiryPerwakilan($id_user)
    {
        $fetch_data_inquiry = '[';
        $fetch_sub_data = '[';
        $tahun = $this->tahun();

        $inquiry = DB::table('csc_inquiry_br as a')->selectRaw('extract(year from created_at) as year, count(*) as jumlah')
            ->where('id_pembuat', $id_user)
            ->where('type', 'perwakilan')
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->groupby('year')
            ->limit(5)->get();

        $inquiry_deal = DB::table('csc_inquiry_br as a')->selectRaw('extract(year from created_at) as year, count(*) as jumlah')
            ->where('id_pembuat', $id_user)
            ->where('type', 'perwakilan')
            ->where('status', 3)
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->groupby('year')
            ->limit(5)->get();

        if (count($inquiry) > 0) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $fetch_data_inquiry .= '{"name": "Inquiry", "color": "#789ec5", "data": [';
                    $jenis = 'all';
                    $data = $inquiry;
                } else {
                    $fetch_data_inquiry .= '{"name": "Deal", "color": "#44c742", "data": [';
                    $jenis = 'deal';
                    $data = $inquiry_deal;
                }
                foreach ($data as $key => $value) {
                    $drilldown = $value->year . $i;
                    $fetch_data_inquiry .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $drilldown . '"},';

                    // Data Drilldown
                    if ($i == 0) {
                        $fetch_sub_data .= '{"name": "Inquiry", "id": "' . $drilldown . '", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Deal", "id": "' . $drilldown . '", "data": [';
                    }

                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSubPerwakilan($m, $value->year, $id_user, 'inquiry', $jenis);
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data .= ']},';
                }
                $fetch_data_inquiry = rtrim($fetch_data_inquiry,',').']},';
            }
            $fetch_sub_data = rtrim($fetch_sub_data,',').']';
            $fetch_data_inquiry = rtrim($fetch_data_inquiry,',').']';
            $return = '[' . $fetch_data_inquiry . ',' . $fetch_sub_data . ']';
        } else {
            $return = null;
        }

        return $return;
    }

    private function getBuyingPerwakilan($id_user)
    {
        $fetch_data_buying = '[';
        $fetch_sub_data = '[';
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
            ->whereRaw('extract(year from date) in (' . $tahun . ')')
            ->groupby('year')
            ->limit(5)->get();

        $buying_deal = DB::table('csc_buying_request as a')->selectRaw('extract(year from date) as year, count(*) as jumlah')
            ->where('id_pembuat', $id_user)
            ->where('by_role', 4)
            ->where('status', 4)
            ->whereRaw('extract(year from date) in (' . $tahun . ')')
            ->groupby('year')
            ->limit(5)->get();

        if (count($buying) > 0) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $fetch_data_buying .= '{"name": "Buying Request", "color": "#855c9a", "data": [';
                    $jenis = 'all';
                    $data = $buying;
                } else {
                    $fetch_data_buying .= '{"name": "Deal", "color": "#44c742", "data": [';
                    $jenis = 'deal';
                    $data = $buying_deal;
                }
                foreach ($data as $key => $value) {
                    $drilldown = $value->year . $i;
                    $fetch_data_buying .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $drilldown . '"},';
                    
                    // Data Drilldown
                    if ($i == 0) {
                        $fetch_sub_data .= '{"name": "Buying Request", "id": "' . $drilldown . '", "data": [';
                    } else {
                        $fetch_sub_data .= '{"name": "Deal", "id": "' . $drilldown . '", "data": [';
                    }

                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSubPerwakilan($m, $value->year, $id_user, 'buying', $jenis);
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }

                    $fetch_sub_data = rtrim($fetch_sub_data).']},';
                }

                $fetch_data_buying = rtrim($fetch_data_buying,',').']},';
            }
            $fetch_sub_data = rtrim($fetch_sub_data,',').']';
            $fetch_data_buying = rtrim($fetch_data_buying,',').']';
            $return = '[' . $fetch_data_buying . ',' . $fetch_sub_data . ']';
        } else {
            $return = null;
        }

        return $return;
    }

    private function getDataSubPerwakilan($month, $year, $param, $jenis, $jenis2)
    {
        if ($jenis == 'user') {
            if ($jenis2 == 'dn') {
                $country = 'id_mst_province';
                $profil = 'eks';
            } else {
                $country = 'id_mst_country';
                $profil = 'imp';
            }
            $data = DB::table('itdp_company_users as a')->selectRaw('extract(month from created_at) as month, count(b.id) as jumlah')
                ->leftjoin('itdp_profil_' . $profil . ' as b', 'a.id_profil', '=', 'b.id')
                ->whereIn('b.' . $country . '', $param)
                ->whereRaw('extract(year from created_at) in (' . $year . ')')
                ->whereRaw('extract(month from created_at) in (' . $month . ')')
                ->groupby('month')
                ->first();
        } else if ($jenis == 'inquiry') {
            if ($jenis2 == 'all') {
                $data = DB::table('csc_inquiry_br')
                    ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                    ->where('id_pembuat', $param)
                    ->where('type', 'perwakilan')
                    ->whereRaw('extract(year from created_at) in (' . $year . ')')
                    ->whereRaw('extract(month from created_at) in (' . $month . ')')
                    ->groupby('month')
                    ->first();
            } else {
                $data = DB::table('csc_inquiry_br')
                    ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                    ->where('id_pembuat', $param)
                    ->where('type', 'perwakilan')
                    ->where('status', 3)
                    ->whereRaw('extract(year from created_at) in (' . $year . ')')
                    ->whereRaw('extract(month from created_at) in (' . $month . ')')
                    ->groupby('month')
                    ->first();
            }
        } else if ($jenis == 'buying') {
            if ($jenis2 == 'all') {
                $data = DB::table('csc_buying_request')
                    ->select(DB::raw('extract(month from date) as month, count(*) as jumlah, by_role as type'))
                    ->where('id_pembuat', $param)
                    ->where('by_role', 4)
                    ->whereRaw('extract(year from date) in (' . $year . ')')
                    ->whereRaw('extract(month from date) in (' . $month . ')')
                    ->groupby('month')
                    ->groupby('type')
                    ->first();
            } else {
                $data = DB::table('csc_buying_request')
                    ->select(DB::raw('extract(month from date) as month, count(*) as jumlah, by_role as type'))
                    ->where('id_pembuat', $param)
                    ->where('by_role', 4)
                    ->where('status', 4)
                    ->whereRaw('extract(year from date) in (' . $year . ')')
                    ->whereRaw('extract(month from date) in (' . $month . ')')
                    ->groupby('month')
                    ->groupby('type')
                    ->first();
            }
        } else if ($jenis == 'event') {
            $data = DB::table('event_detail')
                ->select(DB::raw('extract(month from created_at) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from created_at) in (' . $year . ')')
                ->whereRaw('extract(month from created_at) in (' . $month . ')')
                ->groupby('month')
                ->first();
        } else if ($jenis == 'training') {
            $data = DB::table('training_admin')
                ->select(DB::raw('extract(month from start_date) as month, count(*) as jumlah'))
                ->whereRaw('extract(year from start_date) in (' . $year . ')')
                ->whereRaw('extract(month from start_date) in (' . $month . ')')
                ->groupby('month')
                ->first();
        }

        if ($data) {
            return '["' . $this->getMonth($month) . '", ' . $data->jumlah . ']';
        } else {
            return '["' . $this->getMonth($month) . '", 0]';
        }
    }
// End Data Dashboard Perwakilan

// Start General Private Function

    private function getMonth($month)
    {
        $array = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );
        return $array[$month];
    }

    private function getCompanyName($id, $key)
    {
        $data = DB::table('itdp_profil_eks')->where('id', $id)->first();
        if ($data) {
            return $data->company;
        } else {
            $number = $key + 1;
            return 'Company not Found ' . $number;
        }
    }

    private function getRcName($id, $key)
    {
        $data = DB::table('csc_research_corner')->where('id', $id)->first();
        if ($data) {
            $banyak = DB::table('csc_research_corner')->where('title_en', $data->title_en)->get();
            if (count($banyak) > 1) {
                $space = '';
                for ($i = 0; $i < $key + 1; $i++) {
                    $space .= ' ';
                }
                return $data->title_en .' ( '.rc_country($data->id_mst_country).' )' . $space;
            } else {
                return $data->title_en;
            }
        } else {
            $number = $key + 1;
            return 'Name not Found ' . $number;
        }
    }

    private function tahun()
    {
        $tahun = '';
        for ($year = intval(date('Y')); $year >= date('Y') - 4; $year--) {
            if ($year == date('Y') - 4) {
                $tahun .= $year;
            } else {
                $tahun .= $year . ',';
            }
        }
        return $tahun;
    }

// End General Private Function
}