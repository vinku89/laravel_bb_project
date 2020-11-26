<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Validator;
use Session;
use App\User;
use App\UsersDevicesList;
use App\EPG_list;
use App\Wallet;
use App\RolesPermissions;
use App\Left_menu;
use App\MobileLeftMenu;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Bank_details;
use App\Packages;
use App\Package_purchase_list;
use App\Http\Controllers\API\UserController;
use Carbon\Carbon;
use App\Library\VodCommon;
use DateTime;
use DateTimeZone;
use DateInterval;
use App\Countries;
class EpgController extends Controller
{
	public function getEpgList(Request $request)
	{
		$udata = $request->user();
		$rec_id = $udata['rec_id'];
		$user_role = $udata['user_role'];

		$applications = config('constants.applications');
		if (!in_array(request('app_name'), $applications))
		{
			return response()->json(['status' => 'Failure', 'Result' => 'Invalid request'], 200);
		}
        /*$validator = Validator::make($request->all(), [
            'app_name' => 'required',
			'platform' => 'required',
            'xmltv_id' => 'require'
        ]);

        {app_name=VODREX, device_id=dcmOsYQ08xo:APA91bEQ36JnX7FwTn4S0qhL0Njz38LD6hDN48mTN5DsaishR7rxy3s1GBZB1gjIkgqPpIVRsr3N4diXmPC_OLeg3qnP1RAZbmG4-gMjEbNs7by2Cpfv3iuXqNs4SDWVJFGAMmjrygXF, current_country_code=IN, xmltv_id=CNBC.us, ip_address=, isTv=0, platform=1, country_id=237.0}
        if ($validator->fails()) {
			$res = array_combine($validator->messages()->keys(), $validator->messages()->all());
			$result = implode($res, ',');
			return response()->json(['status' => 'Failure', 'Result' => $result], 200);
		}else{*/
        	$xmltv_id = $request->xmltv_id;
        	$country_id = $request->country_id; // channel country id
        	$expt_country_code = strtoupper($request->current_country_code); //from which location he is watching that country code
			$is_tv = $request->isTv;
			$slug = $request->slug;
        	$device_id = $request->device_id;
            $app_name = $request->app_name;
            $timezone = (isset($request->timezone)) ? $request->timezone : '';
            //Log::info('zone:'. $timezone );
			$hls_playlist_url = "";
			if(!empty($slug)){
				$data['livetv_info'] = VodCommon::getLivetvView($slug);
				$hls_playlist_url = $data['livetv_info']['response']['video_info']['hls_playlist_url'];
			}
        	if($is_tv == 1 && $expt_country_code == '') {
        		$ip_address = $request->ip_address;
        		$deviceInfo = UsersDevicesList::where(['user_id' => $rec_id, 'device_id' => $device_id,'application_name' => $app_name])->first();
				if(@count($deviceInfo) > 0){
					if($deviceInfo->tv_ipaddress != '' && $deviceInfo->country_code!= '') {
                        $expt_country_code = $deviceInfo->country_code;
                        $timezone = $deviceInfo->timezone;
                        if($timezone == '') {
                            $timezone = findTimeZoneByIp($deviceInfo->tv_ipaddress);
                            UsersDevicesList::where(['user_id' => $rec_id, 'device_id' => $device_id,'application_name' => $app_name])->update(['tv_ipaddress' => $ip_address, 'country_code' => $expt_country_code, 'timezone' => $timezone]);
                        }
                    }else{
                        $expt_country_code = findLocationByIp($ip_address);
                        $timezone = findTimeZoneByIp($ip_address);
                        UsersDevicesList::where(['user_id' => $rec_id, 'device_id' => $device_id,'application_name' => $app_name])->update(['tv_ipaddress' => $ip_address, 'country_code' => $expt_country_code, 'timezone' => $timezone]);
					}
				}else{
					$expt_country_code = findLocationByIp($ip_address);
                    $timezone = findTimeZoneByIp($ip_address);
				}
			}
		
			if($timezone == ''){
                $currentDate = self::getCurrentDateByCountry($expt_country_code);
            }else{
                if($timezone == 'Asia/Calcutta') {
                    $timezone = 'Asia/Kolkata';
                }
                //Log::Info('Zone4:'.$timezone);
                $currentDate = self::getCurrentDateByZone($timezone);
            }


        	if(!empty($country_id) && $country_id !=0){
        		$epg_data = EPG_list::where(['xmltv_id' => $xmltv_id,'country_id' => $country_id])->whereDate('start_timezone', '=', $currentDate)->orderBy('start_timezone', 'ASC')->get();
        	}else{
        		$epg_data = EPG_list::where(['xmltv_id' => $xmltv_id])->whereDate('start_timezone', '=', $currentDate)->orderBy('start_timezone', 'ASC')->get();
            }

        	$src_country = Countries::where(['id' => $country_id])->first();
			$src_country_code = $src_country->code;

			$epg_info = array();
        	if(!empty($epg_data)) {
        		foreach($epg_data as $list) {

        			if($expt_country_code != '') {

                        if($timezone == ''){
                            $expt_start_time = self::getAdjustedTime($list['start_timezone'],$src_country_code, $expt_country_code,2);
                            $expt_end_time = self::getAdjustedTime($list['end_timezone'],$src_country_code, $expt_country_code,2);

                            $start_timezone = self::getAdjustedTime($list['start_timezone'],$src_country_code, $expt_country_code,1);
                            $end_timezone = self::getAdjustedTime($list['end_timezone'],$src_country_code, $expt_country_code,1);

                            $currentTime = self::getCurrentTimeByCountry($expt_country_code);
                        }else{
                            $currentTime = self::getCurrentTimeByZone($timezone);

                            $expt_start_time = self::adjustTime($list['stimezone'],$list['start_timezone'], $timezone,2);
		        		    $expt_end_time = self::adjustTime($list['etimezone'], $list['end_timezone'],$timezone,2);

		        			$start_timezone = self::adjustTime($list['stimezone'],$list['start_timezone'], $timezone,1);
		        			$end_timezone = self::adjustTime($list['etimezone'],$list['end_timezone'],$timezone,1);
                        }

	        			$cur_time = strtotime($currentTime);
	                    $start_time = strtotime($start_timezone);
	                    $end_time = strtotime($end_timezone);

	                    if($start_time == $cur_time || $start_time >= $cur_time || $end_time >= $cur_time)
	                    {
							$epg_info[] = array(
			        			'rec_id' => $list['rec_id'],
			        			'title' => $list['title'],
			        			'desc' => $list['description'],
			        			'xmltv_id' => $list['xmltv_id'],
			        			'start' => $expt_start_time,
			        			'end' => $expt_end_time,
			        			'start_date' => $start_timezone,
					        	'end_date' => $end_timezone,
					        	'country_id' => $list['country_id']
			        		);
		        		}
        			}else{
        				$epg_info[] = array(
		        			'rec_id' => $list['rec_id'],
		        			'title' => $list['title'],
		        			'desc' => $list['description'],
		        			'xmltv_id' => $list['xmltv_id'],
		        			'start' => $list['start_time'],
		        			'end' => $list['start_time'],
		        			'start_date' => $list['start_timezone'],
				        	'end_date' => $list['end_timezone'],
				        	'country_id' => $list['country_id']
		        		);
        			}
        		}
        	}

        	return response()->json(['status' => 'Success','Result' => $epg_info, 'hls_playlist_url' => $hls_playlist_url], 200);
        //}


	}




	public static function addMinutesToTime( $time, $plusMinutes) {
        if($plusMinutes > 0){
	        $time = Carbon::createFromFormat('Y-m-d H:i:s', $time);
	        $time->add(new DateInterval('PT'.((integer)$plusMinutes).'M'));
	        $newTime = $time->format( 'Y-m-d H:i:s' );
	        return $newTime;
    	}else{
	        return date("Y-m-d H:i:s", strtotime($plusMinutes ." minutes", strtotime($time)));
	   }
    }

	public static function get_offset($req){
        $timezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $req);
        if($timezone && is_array($timezone) && isset($timezone[0])) {
        	$timezone_id = $timezone[0];
        	$target_time_zone = new DateTimeZone($timezone_id);
        	$kolkata_date_time = new \DateTime('now', $target_time_zone);
	        $offset = $kolkata_date_time->format('P');
	        if(substr($offset, 0, 1) == '+'){
	        	$type  =   "-";
	       	}else{
	            $type =   '+';
	        }

	        $a = explode(':', $offset);
	        $min = (int) $a[0] * 60 + $a[1];
	        return $type . $min;
        }else{
        	return 0;
        }
    }

	public static function get_country_time($source_date,$source_zone,$expected_zone){
	    $offset = self::get_offset($source_zone);
	    $adjustedTime = self::addMinutesToTime( $source_date, $offset);
		$offset = self::get_offset($expected_zone);
		$adjustedTime = self::addMinutesToTime( $adjustedTime, -$offset);
		//return $adjustedTime;
		$finaltime = date("H:i", strtotime($adjustedTime));
		return $finaltime;
	}

	public static function get_country_time2($source_date,$source_zone,$expected_zone){
	    $offset = self::get_offset($source_zone);
	    $adjustedTime = self::addMinutesToTime( $source_date, $offset);
		$offset = self::get_offset($expected_zone);
		$adjustedTime = self::addMinutesToTime( $adjustedTime, -$offset);
		return $adjustedTime;
	}

	public static function getCurrentTimeByCountry($country_code){
		$timezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
		if($timezone && is_array($timezone) && isset($timezone[0])) {
		    $timezone_id = $timezone[0];
		    $target_time_zone = new DateTimeZone($timezone_id);
		    $kolkata_date_time = new \DateTime('now', $target_time_zone);
		    $newTime = $kolkata_date_time->format( 'Y-m-d H:i:s' );
		    return $newTime;
		}
    }

    public static function getCurrentTimeByZone($timezone_id){

        $target_time_zone = new DateTimeZone($timezone_id);
        $kolkata_date_time = new \DateTime('now', $target_time_zone);
        $newTime = $kolkata_date_time->format( 'Y-m-d H:i:s' );
        return $newTime;

    }


    public static function getCurrentDateByCountry($country_code){
		Log::info('issue country_code'.$country_code);
		$timezone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
		if($timezone && is_array($timezone) && isset($timezone[0])) {
		    $timezone_id = $timezone[0];
		    $target_time_zone = new DateTimeZone($timezone_id);
		    $kolkata_date_time = new \DateTime('now', $target_time_zone);
		    $newTime = $kolkata_date_time->format( 'Y-m-d' );
		    return $newTime;
		}
    }

    public static function getCurrentDateByZone($timezone_id){

        $target_time_zone = new DateTimeZone($timezone_id);
        $kolkata_date_time = new \DateTime('now', $target_time_zone);
        $newTime = $kolkata_date_time->format( 'Y-m-d' );
        return $newTime;

    }

    /*********New for time conversion**************/

    public static function get_timezone_offset($remote_tz, $origin_tz = null) {
        if($origin_tz === null) {
            if(!is_string($origin_tz = date_default_timezone_get())) {
                return false; // A UTC timestamp was returned -- bail out!
            }
        }
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime("now", $origin_dtz);
        $remote_dt = new DateTime("now", $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
        return $offset/60;
    }
    public static function getTimeZone($country_code){
        $timezone = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $country_code);
        $target_time_zone = $timezone[0];
        return $target_time_zone;
    }

    public static function getAdjustedTime($date, $source, $destination,$flag){
        $source_zone = self::getTimeZone($source);
        $destination_zone = self::getTimeZone($destination);
        $offset_diff = self::get_timezone_offset($source_zone,$destination_zone);
        $adjustedTime = self::addMinutesToTime($date, $offset_diff);
		if($flag == 1){
			return $adjustedTime;
		}else{
			$finaltime = date("H:i", strtotime($adjustedTime));
			return $finaltime;
		}
    }

    /*** New EPGlist based on timezone *******/

    public static  function getTimeZoneBasedOnOffset($offset){
        // Calculate seconds from offset
        $tdate = explode(' ',$offset);
        return $tdate[2];
    }

    public static function getRemoteOffset($dst_timezone){
        $target_time_zone = new DateTimeZone($dst_timezone);
        $kolkata_date_time = new \DateTime('now', $target_time_zone);
        $dst_offset = $kolkata_date_time->format('P');
        $dst_offset = self::getOffsetInMinutes($dst_offset);
        return $dst_offset;
    }

    //echo getOffsetInMinutes('+05:30');
    public static function getOffsetInMinutes($offset){
        if(substr($offset, 0, 1) == '+'){
            $type  =   "+";
        }else{
            $type =   '-';
        }
        $offset = substr($offset, 1);
        $a = explode(':', $offset);
        $minutes = $a[0]*60+$a[1];
        return $type.$minutes;
    }
    public static function adjustTime($date, $st_date, $remote_timezone, $flag){
        $src_offset = self::getTimeZoneBasedOnOffset($date);
        $src_offset = self::getOffsetInMinutes($src_offset);
        $dst_offset = self::getRemoteOffset($remote_timezone);
        if($src_offset>$dst_offset){
        $diff = $src_offset-$dst_offset;
        $diff = -$diff;
        }else{
        $diff = -$src_offset+$dst_offset;
        }

        $adjustedTime = date("Y-m-d H:i:s", strtotime($diff ." minutes", strtotime($st_date)));
        if($flag == 1){
            return $adjustedTime;
        }else{
            $finaltime = date("H:i", strtotime($adjustedTime));
            return $finaltime;
        }
    }

}
