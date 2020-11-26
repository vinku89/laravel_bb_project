<?php 
	$urlName = request()->segment(1);
	//echo $urlName;
	
	if($urlName == "getInstalledVersionsList"){
		$active_class1="tab_btn_active";
	}else{
		$active_class1 ="";
	}
	if($urlName == "forceLogout"){
		$active_class2="tab_btn_active";
	}else{
		$active_class2 ="";
	}
	if($urlName == "getMobileVersions"){
		$active_class3="tab_btn_active";
	}else{
		$active_class3 ="";
	} 
	
	if($urlName == "getTabMobileVersions"){
		$active_class4="tab_btn_active";
	}else{
		$active_class4 ="";
	}
	
	// if($urlName == "recentMoviesImages"){
	// 	$active_class5="tab_btn_active";
	// }else{
	// 	$active_class5 ="";
	// }
?>


<div class="row clearfix">
	<a href="<?php echo url('/');?>/getInstalledVersionsList" ><button class="btn <?php echo ($active_class1)?$active_class1:"tab_btn"; ?>">Installed Versions List</button></a>
	<a href="<?php echo url('/');?>/forceLogout"><button class="btn <?php echo ($active_class2)?$active_class2:"tab_btn"; ?>">Force Logout </button></a>
	<a href="<?php echo url('/');?>/getMobileVersions"><button class="btn <?php echo ($active_class3)?$active_class3:"tab_btn"; ?>">BestBox Force Update </button></a>
	<?php 
		$VODREX_ADMIN_ID = config('constants.VODREX_ADMIN_ID');
		if($userInfo['rec_id'] == $VODREX_ADMIN_ID)	{
	?>
	<a href="<?php echo url('/');?>/getTabMobileVersions"><button class="btn <?php echo ($active_class4)?$active_class4:"tab_btn"; ?>">Vodrex Force Update </button></a>
	<?php } ?>
	<!-- <a href="<?php //echo url('/');?>/recentMoviesImages"><button class="btn <?php //echo ($active_class5)?$active_class5:"tab_btn"; ?>">Mobile Banners</button></a> -->
</div>