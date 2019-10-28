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

        // $tampung = $res->getBody();
				
		return response($res->getBody());
	}
    
}
