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
        $id_user = Auth::guard('eksmp')->user()->id;
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $country = DB::table('mst_country')->orderby('country','asc')->get();
            $profile = DB::table('itdp_profil_imp as a')->join('itdp_company_users as b', 'a.id', '=', 'b.id_profil')
                ->select('b.username', 'a.*', 'b.foto_profil')
                ->where('a.id', Auth::guard('eksmp')
                ->user()->id_profil)->first();

            $contact = DB::table('itdp_contact_imp')
                ->where('id_user', $id_user)
                ->orderby('name', 'ASC')
                ->get();

            return view('frontend.importir.profile', compact('id_user', 'country', 'profile', 'contact'));
        } else {
            return redirect('/');
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
                $city .= '<option class="option_city" value="'.$value->city.'"'.$select.'>'.$value->city.'</option>';
            }
        } else {
            $city .='<option class="option_city" style="display:none;" value="">- City Not Found in this Country -</option>';
        }

        return json_encode($city);
    }

    public function update(Request $req)
    {
        $id_user = Auth::guard('eksmp')->user()->id;
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $datenow = date("Y-m-d H:i:s");
            $profile = DB::table('itdp_profil_imp as a')
                ->join('itdp_company_users as b', 'a.id', '=', 'b.id_profil')
                ->select('b.username', 'a.*', 'b.foto_profil')
                ->where('a.id', $id_profil)
                ->first();

            $nama_file = NULL;
            $destination= 'uploads\Profile\Importir\\'.$id_user;
            if($req->hasFile('avatar')){ 
                $file1 = $req->file('avatar');
                $nama_file = time().'_'.$file1->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file);
            }else{
                $nama_file = $profile->foto_profil;
            }
			

            if($req->password != NULL){
                $users = DB::table('itdp_company_users')->where('id', $id_user)->update([
                    'username' => $req->username,
                    'password' => Hash::make($req->password),
                    'email' => $req->email,
                    'foto_profil' => $nama_file,
                    'updated_at' => $datenow,
                ]);
            }else{
                $users = DB::table('itdp_company_users')->where('id', $id_user)->update([
                    'username' => $req->username,
                    'email' => $req->email,
                    'foto_profil' => $nama_file,
                    'updated_at' => $datenow,
                ]);
            }

            if($users){
                $profilenya = DB::table('itdp_profil_imp')->where('id', $id_profil)->update([
                    'id_mst_country' => $req->country,
                    'badanusaha' => $req->badanusaha,
                    'company' => $req->name_company,
                    'addres' => $req->address,
                    'city' => $req->city,
                    'postcode' => $req->zip_code,
                    'email' => $req->email,
                    'fax' => $req->fax,
                    'website' => $req->website,
                    'phone' => $req->phone,
                ]);  
            }else{
                // dd($users);
            }

            if($profilenya){
                return redirect('/profile');
            }else{
                // return redirect('/front_end');
                // dd($profilenya);
            }
        } else {
            return redirect('/');
        }
    }

    public function contact_update(Request $req)
    {
        $id_user = Auth::guard('eksmp')->user()->id;
        $id_profil = Auth::guard('eksmp')->user()->id_profil;
        if(Auth::guard('eksmp')->user()->id_role == 3){
            $datenow = date("Y-m-d H:i:s");
            $coinput = count($req->name_contact);

            $del = DB::table('itdp_contact_imp')->where('id_user', $id_user)->delete();
            for ($i=0; $i < $coinput; $i++) { 
                $idn = DB::table('itdp_contact_imp')->max('id');
                $idnew = $idn + 1;
                $contact = DB::table('itdp_contact_imp')->insert([
                    'id' => $idnew,
                    'name' => $req->name_contact[$i],
                    'email' => $req->email_contact[$i],
                    'phone' => $req->phone_contact[$i],
                    'id_user' => $id_user,
                ]);   
            }

            return redirect('/profile');

        } else {
            return redirect('/');
        }
    }
}
