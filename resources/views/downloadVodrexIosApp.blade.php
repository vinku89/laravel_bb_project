<?php 
	set_time_limit(0);
	header("location:".url('/')."/public/VodrexappIOS/Vodrex.ipa");
    exit(0);
	$apk = "Vodrex.ipa";
	$file = './public/VodrexappIOS/'.$apk;   
	if(!empty($file)) { 
		header('Content-Disposition: attachment; filename='.$apk);
		header('Content-Type: application/vnd.android.package-archive');
		header('Content-Length: '.filesize($file));
		echo file_get_contents($file);
	}else{
		echo "testes";
	}
	
?>

