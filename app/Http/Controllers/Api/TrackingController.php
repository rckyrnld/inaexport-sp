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
		$api = explode('|', $request->type);
		if($api[0] == 'mytm'){
	        $res = $client->request('POST', 'http://api.trackingmore.com/v2/trackings/realtime', [
	            'headers' => [
			        'Content-Type' 			=> 'application/json',
			        'Accept'     			=> 'application/json',
			        'Trackingmore-Api-Key' 	=> 'ea90fcce-426c-4a73-b7ae-c1dc308f5d9e'
			    ],
			    'json' => ['tracking_number' =>  $request->number, 'carrier_code' =>  $api[1]]
	        ]);

			return response($res->getBody());

		} else if($api[0] == 'dhl') {
			$res = $client->request('GET', 'https://api-eu.dhl.com/track/shipments', [
	            'headers' => [
			        'Content-Type' 		=> 'application/json',
			        'Accept'     		=> 'application/json',
			        'DHL-API-Key' 		=> 'dhl-try-it-out-key'
			    ],
			    'query' => ['trackingNumber' => $request->number, 'service' => $api[1]]
	        ]);
			
			$tampung =  $res->getBody();
			return response($tampung->getContents());
		}		
	}
    
}
