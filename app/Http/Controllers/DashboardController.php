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
            $pageTitle = "Dashboard";
            $company = $this->getDataTopDownloadCompany();
            $rc      = $this->getDataTopDownloadRc();
            
            return view('Dashboard',compact('pageTitle', 'top_download'))->with('Top_Company_Download', json_decode($company, true))->with('Top_Downloaded_RC', json_decode($rc, true));
        } elseif(Auth::user()->id_group == 4) {
            dd(Auth::user());
        } else {
            return redirect('/');
        }

        // $tes = DB::table('csc_inquiry_br')
        //     ->select(DB::raw('extract(year from created_at) as year, count(*) as jumlah, type'))
        //     ->groupby('year')
        //     ->groupby('type')
        //     ->limit(5)->get();
        // dd($tes);

        // foreach ($tes as $key => $value) {
        //     if($key == 0){
        //         $company .= '[{"name": "Company", "colorByPoint": true, "data":[{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks).'", "y": '.$value->jumlah.'},';
        //     } else if ($key == count($top_download_company)-1){
        //         $company .= '{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks).'", "y": '.$value->jumlah.'}]}]';
        //     } else {
        //         $company .= '{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks).'", "y": '.$value->jumlah.'},';
        //     }
        // }

    }

    public function data_new_user(){
        $fetch_data_new_user = '';
        $fetch_sub_data = '';
        $new_user = [];
        $tahun='';
        for($year = intval(date('Y')); $year >= date('Y')-4; $year--){
            if($year == date('Y')-4){
                $tahun .= $year;
                $new_user[$year] = '';
            } else {
                $tahun .= $year.',';
                $new_user[$year] = '';
            }
        }

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
        return json_decode($return);
    } 

    private function getDataTopDownloadCompany(){
        $top_download_company = DB::table('csc_download_research_corner')
        ->select(DB::raw('count(*) as jumlah, id_itdp_profil_eks'))
        ->groupby('id_itdp_profil_eks')
        ->orderby('jumlah', 'desc')
        ->limit(5)->get();

        $company = '';

        foreach ($top_download_company as $key => $value) {
            if($key == 0){
                $company .= '[{"name": "Company", "colorByPoint": true, "data":[{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks).'", "y": '.$value->jumlah.'},';
            } else if ($key == count($top_download_company)-1){
                $company .= '{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks).'", "y": '.$value->jumlah.'}]}]';
            } else {
                $company .= '{"name": "'.$this->getCompanyName($value->id_itdp_profil_eks).'", "y": '.$value->jumlah.'},';
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

        foreach ($top_download_rc as $key => $value) {
            $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            if($color == "#ffffff"){
                $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }

            if($key == 0){
                $rc .= '[{"name": "Research Corner", "data":[{"name": "'.$this->getRcName($value->id_research_corner).'", "color": "'.$color.'", "y": '.$value->jumlah.'},';
            } else if ($key == count($top_download_rc)-1){
                $rc .= '{"name": "'.$this->getRcName($value->id_research_corner).'", "color": "'.$color.'", "y": '.$value->jumlah.'}]}]';
            } else {
                $rc .= '{"name": "'.$this->getRcName($value->id_research_corner).'", "color": "'.$color.'", "y": '.$value->jumlah.'},';
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

    private function getCompanyName($id){
        $data = DB::table('itdp_profil_eks')->where('id', $id)->first();
        if($data){
            return $data->company;
        } else {
            return 'Name not Found';
        }
    }

    private function getRcName($id){
        $data = DB::table('csc_research_corner')->where('id', $id)->first();
        if($data){
            return $data->title_en;
        } else {
            return 'Name not Found';
        }
    }
}
