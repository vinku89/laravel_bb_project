<?php

function safe_encrypt($string_to_encrypt,$key,$cipher = 'aes-128-cbc'){
	$iv = config('constants.encrypt_iv');
    return base64_encode(openssl_encrypt ($string_to_encrypt, $cipher, $key, true, $iv));
}

function safe_decrypt($encrypted_string,$key,$cipher = 'aes-128-cbc'){
	$encrypted_string = base64_decode($encrypted_string);
	$iv = config('constants.encrypt_iv');
    return openssl_decrypt($encrypted_string, $cipher, $key, true, $iv);
}
function findLocationByIp($ip=''){
    if($ip == ''){
        $ip = $_SERVER['REMOTE_ADDR'];
    }

	//$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
	// if(empty($details->country)){
	// 	return "IN";
	// }else{
	// 	return $details->country;
    // }
    $ipurl = 'http://api.ipstack.com/'.$ip.'?access_key=31393445321d3c61177ae1e1760baf63';

    $details = json_decode(file_get_contents($ipurl));
	if(empty($details->country_code)){
		return "IN";
	}else{
		return $details->country_code;
    }

	/*if (isset($_SERVER['HTTP_CLIENT_IP']))
	{
	    $real_ip_adress = $_SERVER['HTTP_CLIENT_IP'];
	}

	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
	    $real_ip_adress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	    $real_ip_adress = $_SERVER['REMOTE_ADDR'];
	}

	$cip = $real_ip_adress;
	$iptolocation = 'http://api.hostip.info/country.php?ip=' . $cip;
	//$iptolocation = 'http://api.hostip.info/country.php?ip=2.109.61.100';
	return $creatorlocation = file_get_contents($iptolocation);*/
}

function findTimeZoneByIp($ip=''){
    if($ip == ''){
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $ipurl = 'http://ip-api.com/json/'.$ip;
    $details = json_decode(file_get_contents($ipurl));
    if(empty($details->timezone)){
        return "";
    }else{
        return $details->timezone;
    }
}

if (! function_exists('number_format_eight_dec')) {
    function number_format_eight_dec($amount){
        $str=substr($amount, 0, 1);
        $f="";
        if($str=='-'){
            $f="-";
            $amount = ltrim($amount, '-');
        }
        $amount=exp2dec($amount);
        $t=explode(".",$amount);
        if($t[0]==="-0"){
            $beforeDecimal=$t[0];
        }else{
            $beforeDecimal=number_format(floatval($t[0]));
        }
        if(!empty($t[1])){
            $afterDecimal=substr($t[1],0,8);
            if(rtrim($afterDecimal,0)!=""){
                 $afterDecimal = rtrim($afterDecimal,0);
            }else{
                $afterDecimal = "00";
            }
            $formatAmt=$beforeDecimal.".".$afterDecimal;
        }else{
            $formatAmt=$beforeDecimal;
        }
        if (strpos($formatAmt, '.') !== false) {
            $amttemp=explode(".",$formatAmt);
            if(strlen($amttemp[1])==1){
                $formatAmt = $formatAmt."0";
            }else{

            }
        }else{

            $formatAmt = $formatAmt.".00";
        }

        return $f.$formatAmt;
    }
}

if (! function_exists('exp2dec')) {
    function exp2dec($number) {
        if(preg_match('/(.*)E-(.*)/', str_replace(".", "", $number), $matches)){
            $num = "0.";
            while ($matches[2] > 1) {
                $num .= "0";
                $matches[2]--;
            }
            //return rtrim(number_format($num . $matches[1],8), "0");
            return $num . $matches[1];
        }else{
            //return rtrim(number_format($number,8),"0");
            return $number;
        }

    }
}

if (! function_exists('number_format_eight_dec_currency')) {
    function number_format_eight_dec_currency($amount){
        $str=substr($amount, 0, 1);
        $f="";
        if($str=='-'){
            $f="-";
            $amount = ltrim($amount, '-');
        }
        $amount=exp2dec($amount);
        if($amount>1){
            $formatAmt= number_format($amount,2);
            return $f.$formatAmt;
        }
        $t=explode(".",$amount);
        if($t[0]==="-0"){
            $beforeDecimal=$t[0];
        }else{
            $beforeDecimal=number_format(floatval($t[0]));
        }
        if(!empty($t[1])){
            $afterDecimal=substr($t[1],0,8);
            if(rtrim($afterDecimal,0)!=""){
                 $afterDecimal = rtrim($afterDecimal,0);
            }else{
                $afterDecimal = "00";
            }
            $formatAmt=$beforeDecimal.".".$afterDecimal;
        }else{
            $formatAmt=$beforeDecimal;
        }
        if (strpos($formatAmt, '.') !== false) {
            $amttemp=explode(".",$formatAmt);
            if(strlen($amttemp[1])==1){
                $formatAmt = $formatAmt."0";
            }else{

            }
        }else{

            $formatAmt = $formatAmt.".00";
        }

        return $f.$formatAmt;
    }
}
