<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class TrackingController extends Controller
{

    public function tracking(Request $request){
		
		$client = new Client();
        $res = $client->request('POST', 'http://api.trackingmore.com/v2/trackings/realtime', [
            'headers' => [
		        'Content-Type' 			=> 'application/json',
		        'Accept'     			=> 'application/json',
		        'Trackingmore-Api-Key' 	=> 'bdfbf7bb-93e5-45b3-9136-24b05cf2d443'
		    ],
		    'json' => ['tracking_number' =>  $request->number, 'carrier_code' =>  $request->type]
        ]);

        // $tampung = $res->getStatusCode();
        // 200
        $tampung = $res->getBody();
        // {"type":"User"...'
				
		return response($tampung);
		// if($fullName != null && $email != null && $subjek != null && $message != null){
		// 	// dd($fullName.",".$email.",".$email.",".$subjek.",".$message.",".$dateNow);
		// 	$contactUs = new ContactUs;
		// 	$contactUs->fullname = $fullName;
		// 	$contactUs->email = $email;
		// 	$contactUs->subyek = $subjek;
		// 	$contactUs->message = $message;
		// 	$contactUs->status = 0;
		// 	$contactUs->date_created = $dateNow;
		// 	$isSuccess = $contactUs->save();

		// 	if($isSuccess){
		// 		$res['message'] = "Success";
		// 		return response($res);
		// 	}else{
		// 		$res['message'] = "Failed";
		// 		return response($res);
		// 	}
		// }else{
		// 	$res['message'] = "Failed";
		// 	return response($res);
		// }
		
	}
    
}
