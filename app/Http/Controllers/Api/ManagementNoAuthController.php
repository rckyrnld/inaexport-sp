<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Routing\Helpers;
use App\Models\ContactUs;

class ManagementNoAuthController extends Controller
{
	use Helpers;

    public function contactUs(Request $request){
		$fullName = $request->full_name;
		$email = $request->email;
		$subjek = $request->subject;
		$message = $request->message;
		$dateNow = date("Y-m-d h:i:s a");
		if($fullName != null && $email != null && $subjek != null && $message != null){
			// dd($fullName.",".$email.",".$email.",".$subjek.",".$message.",".$dateNow);
			$contactUs = new ContactUs;
			$contactUs->fullname = $fullName;
			$contactUs->email = $email;
			$contactUs->subyek = $subjek;
			$contactUs->message = $message;
			$contactUs->status = 0;
			$contactUs->date_created = $dateNow;
			$isSuccess = $contactUs->save();

			if($isSuccess){
				$res['message'] = "Success";
				return response($res);
			}else{
				$res['message'] = "Failed";
				return response($res);
			}
		}else{
			$res['message'] = "Failed";
			return response($res);
		}
		
	}
    
}
