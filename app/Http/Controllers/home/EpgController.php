<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\EPG_list;
use App\EPG_list2;
use DB;
use Session;
use App\Library\Common;
//use Excel;

class EpgController extends Controller {

	public function ImportEpgListToDB(){
		// $xml_url = url('/').'/resources/views/customer/vplayed/epg_guide/UK.xml';
		$xml_url = url('/').'/resources/views/customer/vplayed/epg_guide/US_latest.xml';
       	//$xml2=simplexml_load_file($xml_url) or die("Error: Cannot create object");
       	//denmark - 63, malaysia - 137, France -78, Norway -168, south Africa - 208, Sweden - 216, UK - 236 US ->237
		$curl_handle=curl_init();
		curl_setopt($curl_handle, CURLOPT_URL,$xml_url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5555555555);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
		$response = curl_exec($curl_handle);
		curl_close($curl_handle);

		$xml2 = simplexml_load_string($response);

       	foreach($xml2->programme as $iprogrammendex => $prg) {
            $time = Common::convertIntoDate($prg->attributes()->start);

            $result = EPG_list::where(['xmltv_id' => trim($prg->attributes()->channel),'start_timezone' => $time, 'country_id' => 237])->get();

            if($result->count() == 0) {
                $data = [
                    'xmltv_id' => trim($prg->attributes()->channel),
                    'title' => $prg->title,
                    'description' => $prg->desc,
                    'start_time' => Common::convertDateIntoHours($prg->attributes()->start),
                    'end_time' => Common::convertDateIntoHours($prg->attributes()->stop),
                    'start_timezone' => Common::convertIntoDate($prg->attributes()->start),
                    'end_timezone' => Common::convertIntoDate($prg->attributes()->stop),
                    'stimezone' => Common::convertIntoDateTImezone($prg->attributes()->start),
                    'etimezone' => Common::convertIntoDateTImezone($prg->attributes()->stop),
                    'country_id' => 237,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];

                EPG_list::insert($data);
            }

        }

            echo 'EPG Data Imported successfully';
            exit;
	}

	public static function compareDate($date){
		$date1 = substr($date,0,8);
		$date2 = date('Ymd');
		if(strval($date1) == strval($date2)){
			return true;
		}else{
			return false;
		}
    }
}
