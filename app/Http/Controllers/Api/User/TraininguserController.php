<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class TraininguserController extends Controller
{

    // use AuthenticatesUsers;  
    public function __construct()
    {
        auth()->shouldUse('api_admin');
    }

    public function joinTraining(Request $request)
    {
        $store = DB::table('training_join')->insert([
            'id_training_admin' => $request->id_training_admin,
            'id_profil_eks' => $request->id_profil,
            'date_join' => date('Y-m-d H:i:s'),
            'status' => 0
        ]);

        $notif = DB::table('notif')->insert([
            'dari_id' => $request->id_profil,
            'untuk_id' => 1,
            'keterangan' => '<b>Request To Join Training',
            'waktu' => date('Y-m-d H:i:s'),
            'url_terkait' => 'admin/training/view',
            'status_baca' => 0,
            'id_terkait' => $request->id_training_admin,
            'to_role' => 1
        ]);
        if (count($store) > 0) {
            $meta = [
                'code' => '200',
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => '204',
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '0';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }
    }

    public function insertProduct(Request $request)
    {
        if ($request->id_role != "1" || $request->id_role != "4") {
            $id_user = $request->id;
            $id_profil = $request->id_profil;
            $datenow = date("Y-m-d H:i:s");

            $idn = DB::table('csc_product_single')->max('id');
            $idnew = $idn + 1;

            $nama_file1 = NULL;
            $nama_file2 = NULL;
            $nama_file3 = NULL;
            $nama_file4 = NULL;

            $destination = 'uploads\Eksportir_Product\Image\\' . $idnew;
            if ($request->hasFile('image_1')) {
                $file1 = $request->file('image_1');
                $nama_file1 = time() . '_' . $request->prodname_en . '_' . $request->file('image_1')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
            }

            if ($request->hasFile('image_2')) {
                $file2 = $request->file('image_2');
                $nama_file2 = time() . '_' . $request->prodname_en . '_' . $request->file('image_2')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
            }

            if ($request->hasFile('image_3')) {
                $file3 = $request->file('image_3');
                $nama_file3 = time() . '_' . $request->prodname_en . '_' . $request->file('image_3')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
            }

            if ($request->hasFile('image_4')) {
                $file4 = $request->file('image_4');
                $nama_file4 = time() . '_' . $request->prodname_en . '_' . $request->file('image_4')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
            }
            $insertRecord = DB::table('csc_product_single')->insert([
                'id' => $idnew,
                'id_csc_product' => $request->id_csc_product,
                'id_csc_product_level1' => $request->id_csc_product_level1,
                'id_csc_product_level2' => $request->id_csc_product_level2,
                'prodname_en' => $request->prodname_en,
                'prodname_in' => $request->prodname_in,
                'prodname_chn' => $request->prodname_chn,
                'code_en' => $request->code,
                'code_in' => $request->code,
                'code_chn' => $request->code_,
                'color_en' => $request->color_en,
                'color_in' => $request->color_in,
                'color_chn' => $request->color_chn,
                'size_en' => $request->size_en,
                'size_in' => $request->size_in,
                'size_chn' => $request->size_chn,
                'raw_material_en' => $request->raw_material_en,
                'raw_material_in' => $request->raw_material_in,
                'raw_material_chn' => $request->raw_material_chn,
                'capacity' => $request->capacity,
                'price_usd' => $this->setValue($request->price_usd),
                'image_1' => $nama_file1,
                'image_2' => $nama_file2,
                'image_3' => $nama_file3,
                'image_4' => $nama_file4,
                'id_itdp_profil_eks' => $id_profil,
                'id_itdp_company_user' => $id_user,
                'minimum_order' => $request->minimum_order,
                'product_description_en' => $request->product_description_en,
                'product_description_in' => $request->product_description_in,
                'product_description_chn' => $request->product_description_chn,
                'status' => $request->status,
                'created_at' => $datenow,
            ]);
            if ($insertRecord) {
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

    public function updateProduct(Request $request)
    {
        if ($request->id_role != "1" || $request->id_role != "4") {
            $id_user = $request->id;
            $id_profil = $request->id_profil;
            $datenow = date("Y-m-d H:i:s");

            $dtawal = DB::table('csc_product_single')->where('id', $request->id_product)->first();

            $destination = 'uploads\Eksportir_Product\Image\\' . $request->id_product;
            if ($request->hasFile('image_1')) {
                $file1 = $request->file('image_1');
                $nama_file1 = time() . '_' . $request->prodname_en . '_' . $request->file('image_1')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
            } else {
                $nama_file1 = $dtawal->image_1;
            }

            if ($request->hasFile('image_2')) {
                $file2 = $request->file('image_2');
                $nama_file2 = time() . '_' . $request->prodname_en . '_' . $request->file('image_2')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file2, $nama_file2);
            } else {
                $nama_file2 = $dtawal->image_2;
            }

            if ($request->hasFile('image_3')) {
                $file3 = $request->file('image_3');
                $nama_file3 = time() . '_' . $request->prodname_en . '_' . $request->file('image_3')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file3, $nama_file3);
            } else {
                $nama_file3 = $dtawal->image_3;
            }

            if ($request->hasFile('image_4')) {
                $file4 = $request->file('image_4');
                $nama_file4 = time() . '_' . $request->prodname_en . '_' . $request->file('image_4')->getClientOriginalName();
                Storage::disk('uploads')->putFileAs($destination, $file4, $nama_file4);
            } else {
                $nama_file4 = $dtawal->image_4;
            }


            $insertRecord = DB::table('csc_product_single')->where('id', $request->id_product)->update([
                'id_csc_product' => $request->id_csc_product,
                'id_csc_product_level1' => $request->id_csc_product_level1,
                'id_csc_product_level2' => $request->id_csc_product_level2,
                'prodname_en' => $request->prodname_en,
                'prodname_in' => $request->prodname_in,
                'prodname_chn' => $request->prodname_chn,
                'code_en' => $request->code,
                'code_in' => $request->code,
                'code_chn' => $request->code_,
                'color_en' => $request->color_en,
                'color_in' => $request->color_in,
                'color_chn' => $request->color_chn,
                'size_en' => $request->size_en,
                'size_in' => $request->size_in,
                'size_chn' => $request->size_chn,
                'raw_material_en' => $request->raw_material_en,
                'raw_material_in' => $request->raw_material_in,
                'raw_material_chn' => $request->raw_material_chn,
                'capacity' => $request->capacity,
                'price_usd' => $this->setValue($request->price_usd),
                'image_1' => $nama_file1,
                'image_2' => $nama_file2,
                'image_3' => $nama_file3,
                'image_4' => $nama_file4,
                'minimum_order' => $request->minimum_order,
                'product_description_en' => $request->product_description_en,
                'product_description_in' => $request->product_description_in,
                'product_description_chn' => $request->product_description_chn,
                'status' => $request->status,
                'updated_at' => $datenow,
            ]);
            if ($insertRecord) {
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

    public function deleteProduct(Request $request)
    {
        if ($request->id_role != "1" || $request->id_role != "4") {
            $deleteRecord = DB::table('csc_product_single')->where('id', $request->id_product)
                ->delete();
            if ($deleteRecord) {
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

    public function detailProduk(Request $request)
    {
        //Product
        $data = DB::table('csc_product_single')
            ->where('id', '=', $request->id)
            ->first();
        if (count($data) > 0) {
            $res['message'] = "Success";
            $res['data'] = $data;
            return response($res);
        } else {
            $res['message'] = "Failed";
            return response($res);
        }
    }
}
