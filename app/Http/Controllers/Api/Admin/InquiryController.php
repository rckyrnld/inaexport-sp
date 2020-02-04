<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Models\Api\AdminApi;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class InquiryController extends Controller
{

    public function __construct()
    {
        auth()->shouldUse('api_admin');
    }
	
	public function list_inquiry_admin(Request $request)
    {
		$offset = $request->offset;
		$user = DB::table('csc_inquiry_br')
			->where('csc_inquiry_br.type', 'admin')
            ->orderBy('csc_inquiry_br.created_at', 'DESC')
			->limit(10)
            ->offset($offset)
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_pembuat"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["type"] = $user[$i]->type;
            $jsonResult[$i]["id_csc_prod_cat"] = $user[$i]->id_csc_prod_cat;
            $jsonResult[$i]["id_csc_prod_cat_level1"] = $user[$i]->id_csc_prod_cat_level1;
            $jsonResult[$i]["id_csc_prod_cat_level2"] = $user[$i]->id_csc_prod_cat_level2;
            $jsonResult[$i]["jenis_perihal_en"] = $user[$i]->jenis_perihal_en;
            $jsonResult[$i]["jenis_perihal_in"] = $user[$i]->jenis_perihal_in;
            $jsonResult[$i]["jenis_perihal_chn"] = $user[$i]->jenis_perihal_chn;
            $jsonResult[$i]["id_mst_country"] = $user[$i]->id_mst_country;
            $jsonResult[$i]["messages_en"] = $user[$i]->messages_en;
            $jsonResult[$i]["messages_in"] = $user[$i]->messages_in;
            $jsonResult[$i]["messages_chn"] = $user[$i]->messages_chn;
            $jsonResult[$i]["subyek_en"] = $user[$i]->subyek_en;
            $jsonResult[$i]["subyek_in"] = $user[$i]->subyek_in;
            $jsonResult[$i]["subyek_chn"] = $user[$i]->subyek_chn;
            $jsonResult[$i]["to"] = $user[$i]->id_pembuat;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["duration"] = $user[$i]->duration;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;

			}
//        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

		
	}
	
	public function list_inquiry_broadcast(Request $request)
    {
		$id_inquiry = $request->id_inquiry;
		$user = DB::table('csc_inquiry_broadcast')
			->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_inquiry_broadcast.id_itdp_company_users')
			->join('itdp_profil_eks', 'itdp_profil_eks.id', '=', 'itdp_company_users.id_profil')
			->where('csc_inquiry_broadcast.id_inquiry', $id_inquiry)
            ->orderBy('csc_inquiry_broadcast.created_at', 'DESC')
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_itdp_company_users"] = $user[$i]->id_itdp_company_users;
			$jsonResult[$i]["company"] = $user[$i]->badanusaha." ".$user[$i]->company;
            $jsonResult[$i]["status"] = $user[$i]->status;
            $jsonResult[$i]["created_at"] = $user[$i]->created_at;
            $jsonResult[$i]["updated_at"] = $user[$i]->updated_at;
            $jsonResult[$i]["date"] = $user[$i]->date;
            $jsonResult[$i]["due_date"] = $user[$i]->due_date;
            
            

			}
//        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

		
	}
	
	public function list_inquiry_hc(Request $request)
    {
		$id_inquiry = $request->id_inquiry;
		$id_broad = $request->id_broad;
		$user = DB::table('csc_chatting_inquiry')
			->where('csc_chatting_inquiry.id_inquiry', $id_inquiry)
			->where('csc_chatting_inquiry.id_broadcast_inquiry', $id_broad)
            ->orderBy('csc_chatting_inquiry.created_at', 'DESC')
            ->get();
//        dd($user);
        $jsonResult = array();
        for ($i = 0; $i < count($user); $i++) {
            $jsonResult[$i]["id"] = $user[$i]->id;
            $jsonResult[$i]["id_inquiry"] = $user[$i]->id_inquiry;
            $jsonResult[$i]["id_broadcast_inquiry"] = $user[$i]->id_broadcast_inquiry;
			$jsonResult[$i]["sender"] = $user[$i]->sender;
            $jsonResult[$i]["receive"] = $user[$i]->receive;
            $jsonResult[$i]["messages"] = $user[$i]->messages;
            $jsonResult[$i]["status"] = $user[$i]->status;
            
            

			}
//        dd($jsonResult);
        if (count($user) > 0) {
            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];
            $data = $jsonResult;
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        } else {
            $meta = [
                'code' => 204,
                'message' => 'Data Not Found',
                'status' => 'No Content'
            ];
            $data = '';
            $res['meta'] = $meta;
            $res['data'] = $data;
            return response($res);
        }

		
	}
	
	public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datenow = date("Y-m-d H:i:s");
        $type = "admin";


                //Jenis Perihal
                $jpen = "";
                $jpin = "";
                $jpchn = "";
                if($request->kos == "offer to sell"){
                    $jpen = $request->kos;
                    $jpin = "menawarkan untuk menjual";
                    $jpchn = "出售要约";
                }else if($request->kos == "offer to buy"){
                    $jpen = $request->kos;
                    $jpin = "menawarkan untuk membeli";
                    $jpchn = "报价购买";
                }else if($request->kos == "consultation"){
                    $jpen = $request->kos;
                    $jpin = "konsultasi";
                    $jpchn = "咨询服务";
                }

                if($request->duration == NULL){
                    $duration = "None";
                }else{
                    $duration = $request->duration;
                }

                $save = DB::table('csc_inquiry_br')->insertGetId([
                    'id_pembuat' => '1',
                    'type' => $type,
                    'prodname' => $request->prodname,
                    'jenis_perihal_en' => $jpen,
                    'jenis_perihal_in' => $jpin,
                    'jenis_perihal_chn' => $jpchn,
                    'messages_en' => $request->messages,
                    'messages_in' => $request->messages,
                    'messages_chn' => $request->messages,
                    'subyek_en' => $request->subject,
                    'subyek_in' => $request->subject,
                    'subyek_chn' => $request->subject,
                    'status' => 1,
                    'date' => $request->dateinquiry,
                    'duration' => $duration,
                    'created_at' => $datenow,
                ]);

                $nama_file1 = NULL;
                $destination= 'uploads\Inquiry\\'.$save;
                if($request->hasFile('file')){
                    $file1 = $request->file('file');
                    $nama_file1 = time().'_'.$request->subject.'_'.$file1->getClientOriginalName();
                    Storage::disk('uploads')->putFileAs($destination, $file1, $nama_file1);
                }

                $savefile = DB::table('csc_inquiry_br')->where('id', $save)->update([
                    'file' => $nama_file1,
                ]);
                if($save){
                    $meta = [
                    'code' => 200,
                    'message' => 'Success',
                    'status' => 'OK'
					];
					$data = '';
					$res['meta'] = $meta;
					return response($res);
                }
                else{
                    $meta = [
						'code' => 100,
						'message' => 'Unauthorized',
						'status' => 'Failed'
					];
					$data = "";
					$res['meta'] = $meta;
					return $res;
                }
            

    }

    

}
