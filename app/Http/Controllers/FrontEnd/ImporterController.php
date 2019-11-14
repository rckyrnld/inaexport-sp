<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImporterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
    }

    public function index()
    {
        // NONE
    }

    public function profile()
    {
        $id = Auth::guard('eksmp')->user()->id;
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $country = DB::table('mst_country')->orderby('country','asc')->get();
            $profile = DB::table('itdp_profil_imp as a')->join('itdp_company_users as b', 'a.id', '=', 'b.id_profil')
                ->select('b.username', 'a.*')
                ->where('a.id', Auth::guard('eksmp')
                ->user()->id_profil)->first();

            return view('frontend.importir.profile', compact('id', 'country', 'profile'));
        } else {
            return redirect('/front_end');
        }
    }

    public function getCity(Request $req, $param)
    {
        $city = '';
        $data = DB::table('mst_city')->where('id_mst_country', $req->id)->orderby('city', 'asc')->get();
        $profile = DB::table('itdp_profil_imp')->where('id', Auth::guard('eksmp')->user()->id_profil)->first();
        if(count($data) > 0){
            $city .= '<option class="option_city" style="display: none;" value="">- Select City -</option>';
            foreach ($data as $key => $value) {
                if($param != 'null' && $value->city == $profile->city){ $select = 'selected'; } else { $select = ''; }
                $city .= '<option class="option_city" value="'.$value->id.'"'.$select.'>'.$value->city.'</option>';
            }
        } else {
            $city .='<option class="option_city" style="display:none;" value="">- City Not Found in this Country -</option>';
        }

        return json_encode($city);
    }

    public function update(Request $req)
    {
        $tes = $req->all();
        dd($tes);
    }
}
