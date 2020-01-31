<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class EventNonAuthController extends Controller
{

    public function event_suggest(Request $request)
    {
		//$name = $request->search;
		// $offset = $request->offset;
        // $data = DB::select("select * from event_detail where event_name_en like '%".$name."%' or event_name_in like '%".$name."%' or event_name_chn like '%".$name."%' order by event_name_en asc");
        $data = DB::table('event_detail')
		//	->where('event_detail.event_name_en', 'like', '%' . $name . '%')
		//	->orwhere('event_detail.event_name_in', 'like', '%' . $name . '%')
		//	->orwhere('event_detail.event_name_chn', 'like', '%' . $name . '%')
		//	->orderBy('event_detail.event_name_en', 'asc')
        //    ->limit(10)
        //    ->offset($offset)
            ->get();
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["event_name_en"] = $data[$i]->event_name_en;
            $jsonResult[$i]["event_name_in"] = $data[$i]->event_name_in;
            $jsonResult[$i]["event_name_chn"] = $data[$i]->event_name_chn;
            
        }
//        dd($jsonResult);
        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }

    }
	
	public function event_list(Request $request)
    {
		$name = $request->search;
		//$offset = $request->offset;
        // $data = DB::select("select * from event_detail where event_name_en like '%".$name."%' or event_name_in like '%".$name."%' or event_name_chn like '%".$name."%' order by event_name_en asc");
        $data = DB::table('event_detail')
			->where('event_detail.event_name_en', 'like', '%' . $name . '%')
			->orwhere('event_detail.event_name_in', 'like', '%' . $name . '%')
			->orwhere('event_detail.event_name_chn', 'like', '%' . $name . '%')
			->orderBy('event_detail.event_name_en', 'asc')
        //   ->limit(10)
            //->offset($offset)
            ->get();
		$jsonResult = array();
        for ($i = 0; $i < count($data); $i++) {
            $jsonResult[$i]["id"] = $data[$i]->id;
            $jsonResult[$i]["event_name_en"] = $data[$i]->event_name_en;
            $jsonResult[$i]["event_name_in"] = $data[$i]->event_name_in;
            $jsonResult[$i]["event_name_chn"] = $data[$i]->event_name_chn;
            $jsonResult[$i]["event_type_in"] = $data[$i]->event_type_in;
            $jsonResult[$i]["id_event_organizer"] = $data[$i]->id_event_organizer;
            $jsonResult[$i]["event_organizer_text_en"] = $data[$i]->event_organizer_text_en;
            $jsonResult[$i]["id_event_place"] = $data[$i]->id_event_place;
            $jsonResult[$i]["event_place_text_en"] = $data[$i]->event_place_text_en;
            $jsonResult[$i]["website"] = $data[$i]->website;
            $jsonResult[$i]["jenis_en"] = $data[$i]->jenis_en;
            $jsonResult[$i]["event_comodity"] = $data[$i]->event_comodity;
            $jsonResult[$i]["event_scope_en"] = $data[$i]->event_scope_en;
            $jsonResult[$i]["id_prod_cat"] = $data[$i]->id_prod_cat;
            $jsonResult[$i]["id_articles"] = $data[$i]->id_articles;
            $jsonResult[$i]["id_prod_sub1_kat"] = $data[$i]->id_prod_sub1_kat;
            $jsonResult[$i]["id_prod_sub2_kat"] = $data[$i]->id_prod_sub2_kat;
            $jsonResult[$i]["status_en"] = $data[$i]->status_en;
            $jsonResult[$i]["created_at"] = $data[$i]->created_at;
            $jsonResult[$i]["reg_date"] = $data[$i]->reg_date;
            $jsonResult[$i]["image_1"] = $path = ($data[$i]->image_1) ? url('uploads/Event/Image/' . $data[$i]->id . '/' . $data[$i]->image_1) : url('image/nia3.png');
            $jsonResult[$i]["image_2"] = $path = ($data[$i]->image_2) ? url('uploads/Event/Image/' . $data[$i]->id . '/' . $data[$i]->image_2) : url('image/nia3.png');
            $jsonResult[$i]["image_3"] = $path = ($data[$i]->image_3) ? url('uploads/Event/Image/' . $data[$i]->id . '/' . $data[$i]->image_3) : url('image/nia3.png');
            $jsonResult[$i]["image_4"] = $path = ($data[$i]->image_4) ? url('uploads/Event/Image/' . $data[$i]->id . '/' . $data[$i]->image_4) : url('image/nia3.png');
            
        }
//        dd($jsonResult);
        if ($data) {

            $meta = [
                'code' => 200,
                'message' => 'Success',
                'status' => 'OK'
            ];

            $res['meta'] = $meta;
            $res['data'] = $jsonResult;
            return response($res);
        } else {
            $meta = [
                'code' => 100,
                'message' => 'Unauthorized',
                'status' => 'Failed'
            ];
            $data = "";
            $res['meta'] = $meta;
            $res['data'] = $data;
            return $res;
        }

    }
}
