<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ContactUs;
use Mail;

class ManagementNoAuthController extends Controller
{

    public function contactUs(Request $request)
    {
        $fullName = $request->full_name;
        $email = $request->email;
        $subjek = $request->subject;
        $message = $request->message;
        $dateNow = date("Y-m-d h:i:s a");
        if ($fullName != null && $email != null && $subjek != null && $message != null) {
            // dd($fullName.",".$email.",".$email.",".$subjek.",".$message.",".$dateNow);
            $contactUs = new ContactUs;
            $contactUs->fullname = $fullName;
            $contactUs->email = $email;
            $contactUs->subyek = $subjek;
            $contactUs->message = $message;
            $contactUs->status = 0;
            $contactUs->date_created = $dateNow;
            $isSuccess = $contactUs->save();

            if ($isSuccess) {
                $res['message'] = "Success";
                return response($res);
            } else {
                $res['message'] = "Failed";
                return response($res);
            }
        } else {
            $res['message'] = "Failed";
            return response($res);
        }

    }

    public function getCountry()
    {
        $dataTraining = DB::table('mst_country')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function getProvince()
    {
        $dataTraining = DB::table('mst_province')
            ->get();
        if (count($dataTraining) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = $dataTraining;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function RegisterExp(Request $request)
    {
        $company = $request->company;
        $email = $request->email;
        $username = $request->username;
        $phone = $request->phone;
        $fax = $request->fax;
        $website = $request->website;
        $password = $request->password;
        $postcode = $request->postcode;
        $address = $request->address;
        $dateNow = date("Y-m-d H:m:s");
        $id_province = $request->id_province;
        $city = $request->city;
        if ($company != null && $email != null && $username != null && $phone != null && $fax != null && $website != null && $password != null && $postcode != null && $address != null && $id_province != null && $city != null) {

            $chek = DB::table('itdp_company_users')
                ->where('email', '=', $email)
                ->orWhere('username', '=', $username)
                ->get();
            $hasil = count($chek);
//            dd($hasil);
            if ($hasil == 0) {
                $insert = DB::table('itdp_profil_eks')
                    ->insertGetId([
                        "company" => $company,
                        "addres" => $address,
                        "postcode" => $postcode,
                        "phone" => $phone,
                        "fax" => $fax,
                        "email" => $email,
                        "website" => $website,
                        "created" => $dateNow,
                        "status" => '1',
                        "id_mst_province" => $id_province,
                        "city" => $city
                    ]);
                $insert2 = DB::table('itdp_company_users')
                    ->insertGetId([
                        "id_profil" => $insert,
                        "type" => 'Dalam Negeri',
                        "username" => $username,
                        "password" => bcrypt($password),
                        "email" => $email,
                        "status" => '0',
                        "id_role" => '2',
                    ]);
                // notif
                $id_terkait = "2/" . $insert2;
                $ket = "User baru Eksportir dengan nama " . $company;
                $insert3 = DB::table('notif')
                    ->insert([
                        "to_role" => '1',
                        "dari_nama" => $company,
                        "dari_id" => $insert,
                        "untuk_nama" => 'Super Admin',
                        "untuk_id" => '1',
                        "keterangan" => $ket,
                        "url_terkait" => 'profil',
                        "id_terkait" => $id_terkait,
                        "waktu" => Date('Y-m-d H:m:s'),
                        "status_baca" => '0',
                    ]);

                $data = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'password' => $password, 'email' => $email];

                Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
                $data2 = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'password' => $password, 'email' => 'safaririch12@gmail.com'];

                Mail::send('UM.user.emailsuser', $data2, function ($mail) use ($data2) {
                    $mail->to($data2['email'], $data2['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
                $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
                ];
                $data = '0';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            } else {
                $meta = [
                    'code' => 208,
                    'message' => 'Username Or Email Already Used',
                    'status' => 'Failed'
                ];
                $data = '0';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            }
        } else {
            $meta = [
                'code' => 400,
                'message' => 'All Data Must Be Filled In',
                'status' => 'Failed'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

    }

    public function RegisterImp(Request $request)
    {
        $company = $request->company;
        $email = $request->email;
        $username = $request->username;
        $phone = $request->phone;
        $fax = $request->fax;
        $website = $request->website;
        $password = $request->password;
        $postcode = $request->postcode;
        $address = $request->address;
        $id_country = $request->id_country;
        $city = $request->city;
        $dateNow = date("Y-m-d H:m:s");
        if ($company != null && $email != null && $username != null && $phone != null && $fax != null && $website != null && $password != null && $postcode != null && $address != null && $id_country != null && $city != null) {

            $chek = DB::table('itdp_company_users')
                ->where('email', '=', $email)
                ->orWhere('username', '=', $username)
                ->get();
            $hasil = count($chek);
//            dd($hasil);
            if ($hasil == 0) {
                $insert = DB::table('itdp_profil_imp')
                    ->insertGetId([
                        "company" => $company,
                        "addres" => $address,
                        "postcode" => $postcode,
                        "phone" => $phone,
                        "fax" => $fax,
                        "email" => $email,
                        "website" => $website,
                        "created" => $dateNow,
                        "status" => '1',
                        "id_mst_country" => $id_country,
                        "city" => $city
                    ]);
                $insert2 = DB::table('itdp_company_users')
                    ->insertGetId([
                        "id_profil" => $insert,
                        "type" => 'Luar Negeri',
                        "username" => $username,
                        "password" => bcrypt($password),
                        "email" => $email,
                        "status" => '0',
                        "id_role" => '3',
                    ]);
                // notif
                $id_terkait = "2/" . $insert2;
                $ket = "User baru Importir dengan nama " . $company;
                $insert3 = DB::table('notif')
                    ->insert([
                        "to_role" => '1',
                        "dari_nama" => $company,
                        "dari_id" => $insert,
                        "untuk_nama" => 'Super Admin',
                        "untuk_id" => '1',
                        "keterangan" => $ket,
                        "url_terkait" => 'profil',
                        "id_terkait" => $id_terkait,
                        "waktu" => Date('Y-m-d H:m:s'),
                        "status_baca" => '0',
                    ]);

                $data = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'password' => $password, 'email' => $email];

                Mail::send('UM.user.emailsuser', $data, function ($mail) use ($data) {
                    $mail->to($data['email'], $data['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
                $data2 = ['username' => $username, 'id2' => $insert2, 'nama' => $company, 'password' => $password, 'email' => 'safaririch12@gmail.com'];

                Mail::send('UM.user.emailsuser', $data2, function ($mail) use ($data2) {
                    $mail->to($data2['email'], $data2['username']);
                    $mail->subject('Notifikasi Aktifasi Akun');

                });
                $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
                ];
                $data = '0';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            } else {
                $meta = [
                    'code' => 208,
                    'message' => 'Username Or Email Already Used',
                    'status' => 'Failed'
                ];
                $data = '0';
                $res['meta'] = $meta;
                $res['data'] = $data;
                return response($res);
            }
        } else {
            $meta = [
                'code' => 400,
                'message' => 'All Data Must Be Filled In',
                'status' => 'Failed'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

    }

}
