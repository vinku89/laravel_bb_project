<?php

$panel_url = 'http://portal.bestbox.net:25461/';
$username = 'test33e43';
$password = 'test1233e43';
$max_connections = 1;
$reseller = 1;
$bouquet_ids = array(
    1,2);
$expire_date = strtotime( "+1 month" );

###############################################################################
$post_data = array( 'user_data' => array(
        'username' => $username,
        'password' => $password,
        'max_connections﻿' => $max_connections,
        'is_restreamer﻿' => $reseller,
		'exp_date' => $expire_date,
		'bouquet' => json_encode( $bouquet_ids )) );

$opts = array( 'http' => array(
        'method' => 'POST',
        'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen(http_build_query( $post_data )) . "\r\n",
        'content' => http_build_query( $post_data ) ) );

$context = stream_context_create( $opts );
$api_result = json_decode( file_get_contents( $panel_url . "api.php?action=user&sub=create", false, $context ) );
print_r($api_result);

?>