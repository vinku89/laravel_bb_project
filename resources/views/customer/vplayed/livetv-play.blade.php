<?php
  function convertDate($date){
  $to = substr($date,0,8);
  $hh = substr($date,8,2);
  $mm = substr($date,10,2);
  $ss = substr($date,12,2);
  return $hh.':'.$mm;
}

function compareDate($date){
  $date1 = substr($date,0,8);
  $date2 = date('Ymd');
  if(strval($date1) == strval($date2)){
    return true;
  }else{
    return false;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png" sizes="32x32" />
    <!-- All styles include -->
	
	 
		
     @include('customer.inc.all-styles')
	 <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vdplay.css">

	<link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vod.css">
	<link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/player.css">
    <style>
        
        
    </style>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	  <script src="<?php echo url('/');?>/public/vplayed/js/play.js"></script>
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
		
		  <!-- Header Section End Here -->
    <section class="vod_main_body_section scroll_div"> 
		
      <!-- VOD Banner Section Here -->
      <div class="vod_banerWrp vodbanner_height">
	  <?php 
	  $video_sprite_image = '';
		if(!empty($livetv_details_info)){
			if($livetv_details_info["statusCode"]== 200 && $livetv_details_info["status"] =="success"){

				if($livetv_details_info["response"]["video_info"] != ""){
					$video_title = $livetv_details_info["response"]["video_info"]["title"];
					$video_slug =  $livetv_details_info["response"]["video_info"]["title"];
					$video_description =  $livetv_details_info["response"]["video_info"]["description"];
					$video_thumbnail_image =  $livetv_details_info["response"]["video_info"]["thumbnail_image"];
					$video_hls_playlist_url =  $livetv_details_info["response"]["video_info"]["hls_playlist_url"];
					$is_live =  $livetv_details_info["response"]["video_info"]["is_live"];
					$video_poster_image =  $livetv_details_info["response"]["video_info"]["poster_image"];
					$video_sprite_image =  $livetv_details_info["response"]["video_info"]["sprite_image"];
          $xmltv_id = $livetv_details_info["response"]["video_info"]["xmltv_id"];
				
	  ?>
        
        <div class="vod_bannerContent_wrp">
          <div class="vod_bannerinner_Content_wrp">
            <div class="info_wrapper">
			  	
              <div class="movie_info">
                <h1><?php echo $video_title; ?></h1>
              </div>
			
            </div>
          </div>
        </div>
		<?php 
					}
				}else{ ?>
					<div class="no-record-wrp1">
						<div class="no-record-wrp2">
						<h1>Oops... Something went wrong</h2>
						</div>
					</div>
			<?php }
			}else{
			?>
				<div class="no-record-wrp1">
					<div class="no-record-wrp2">
					<h1>Oops... Something went wrong</h2>
					</div>
				</div>
			<?php } ?>
		
		
      </div>
      <!-- END VOD Banner Section  -->

      <!-- VOD Player Section Here -->
      <?php 
      if(!empty($livetv_details_info)){
      if($livetv_details_info["statusCode"]== 200 && $livetv_details_info["status"] =="success"){
        if($livetv_details_info["response"]["video_info"] != ""){?>
        
      <div class="vod_player_section livetv-margin">
        <div class="player_wrp">
          <video id="example-video1"></video>  
          <script>
            // Following script is used to handle the player events
            /*videojs.Hls.xhr.beforeRequest = function (options) {
              options.headers = [];
              options.headers['X-REQUEST-TYPE'] = 'admin'; //Do not change this line.
            };*/
			
			var is_live_status = '<?php echo $is_live; ?>';
			
			videojs.Hls.xhr.beforeRequest = function(options) {
				
				/*if (video && video.is_live == is_live_status) { // If videos are not live, then only following conditions should execute
				console.log("testet 5555");
				  options.headers = [];
				  options.headers['X-REQUEST-TYPE'] = 'admin';
				}else{
					console.log("testet 4444");
				}*/
			};
			
            var player = videojs('example-video1', {
              "controls": true,
              "autoplay": true,
              "preload": "auto",
              "fluid": true,
              "playbackRates": [0.25, 0.5, 1, 1.25, 1.5, 2],
              "sources": [{
                //Following src url should be changed as per your project. Here I have mentioned it as static for demo purpose.
                "src": '<?php echo $video_hls_playlist_url; ?>',
                "type": 'application/x-mpegURL'
              }],
              "html5": {
                "nativeAudioTracks": false,
                "nativeVideoTracks": false,
                "nativeTextTracks": false,
                "hls": {
                  "overrideNative": true,
                }
              },
              "plugins": {
                
                "keyboardShortCuts": {},
                "seekButtons": {
                  "forward": 10,
                  "back": 10
                },
              }
            });

            /** Following function is used to display thumbnails in the player seek bar. If you have
            sprite image url, then use the following function. Url should be changed as per your project. Here
            I have mentioned it as static for demo purpose**/
            player.spriteThumbnails({
              url: '<?php echo $video_sprite_image; ?>',
              width: 192,
              height: 113,
              stepTime: 20
            });

            //Following method is used to play the video.
            player.play();

            //Following method is used to pause the video.
            player.pause();
          </script>
        </div>
      </div>


      <!-- epg section start -->
      <?php
      /*
       $xml_url = url('/').'/resources/views/customer/vplayed/epg_guide/uk_country.xml';
       $xml2=simplexml_load_file($xml_url) or die("Error: Cannot create object");
       ?>
      <div style="color:#000;font-size: 16px;">
  <div class="font-weight-bold">
    <?php 
    foreach($xml2->channel as $chn) {
      if($chn->attributes()->id == $xmltv_id){
        echo $chn->attributes()->id;
      }
    }
    ?>
  </div>
  <div class='row'>
    <div class="col-sm-4 font-weight-bold">Time</div>
    <div class="col-sm-4 font-weight-bold">Tile</div>
    <div class="col-sm-4 font-weight-bold">Program</div>
  </div>
  <?php 
  foreach($xml2->programme as $iprogrammendex => $prg) {
    if($prg->attributes()->channel == $xmltv_id && compareDate($prg->attributes()->start)){
      ?>
    <div class='row'>
      <div class="col-sm-4"><?php echo convertDate($prg->attributes()->start);?></div>
      <div class="col-sm-4"><?php echo $prg->title;?></div>
      <div class="col-sm-4"><?php echo $prg->desc;?></div>
    </div>
  <?php }
  }
  ?>
</div>
<?php */?>
      <!-- epg section end -->
      <?php
    }
  }
}?>
      <!-- End VOD Player Section  -->

    </section>
		
		
    </div>
	  <!-- Modal -->
  
    <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
    <script src="<?php echo url('/');?>/public/vplayed/js/jquery.ddslick.min.js"></script> 
	<script src="<?php echo url('/');?>/public/vplayed/js/dropkick.js" type=""></script>
	
     
</body>
</html>