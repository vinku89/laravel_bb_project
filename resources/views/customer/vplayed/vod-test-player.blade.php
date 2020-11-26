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
		.lessthan8{
			display:block;	
		}
		.greaterthan8{
			display:none !important;
		} 
		.movie_list_wrap_it2 {
			display: inline-table;
			margin-bottom: 50px;
			width: 175px;
			height: auto;
			margin-right: 20px;
			/*float: left;*/
		}
		.movie_list_wrap_item img {
			border-radius: 5px;
			object-fit: fill;
		}
		.movie_list_wrap_it3 {
			display: block;
			margin-bottom: 50px;
			width: 175px;
			height: auto;
			margin-right: 20px;
			float: left;
		}
        .movie_list_wrap_item_title {
			
			font-size: 12px !important;
			
		}
		.showmore{
			display:block !important;
		}
        .hideShowmore{
			display:none !important;
		}
		
    </style>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
      <script src="<?php echo url('/');?>/public/vplayed/js/hls.js"></script>
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
         <!-- Header Section End Here -->
		
        <section class="dark_bg scroll_div">

            <!-- Filter -->
         <center>
          <h1>Hls.js demo - basic usage</h1>
          <video height="400" id="video" controls></video>
      </center>

      <script>
        if(Hls.isSupported()) {
          var video = document.getElementById('video');
          var hls = new Hls();
          hls.loadSource('https://vod.bestbox.net:82/hls/Animation/,A.charlie.brown.christmas.1965.1080p.bluray.x264-cinefile.mp4,lang/eng/A.charlie.brown.christmas.1965.1080p.bluray.x264-cinefile.extr.eng.srt,.urlset/master.m3u8');
          hls.attachMedia(video);
          hls.on(Hls.Events.MANIFEST_PARSED,function() {
            video.play();
        });
       }
       // hls.js is not supported on platforms that do not have Media Source Extensions (MSE) enabled.
       // When the browser has built-in HLS support (check using `canPlayType`), we can provide an HLS manifest (i.e. .m3u8 URL) directly to the video element throught the `src` property.
       // This is using the built-in support of the plain video element, without using hls.js.
        else if (video.canPlayType('application/vnd.apple.mpegurl')) {
          video.src = 'https://vod.bestbox.net:82/hls/Animation/,A.charlie.brown.christmas.1965.1080p.bluray.x264-cinefile.mp4,lang/eng/A.charlie.brown.christmas.1965.1080p.bluray.x264-cinefile.extr.eng.srt,.urlset/master.m3u8';
          video.addEventListener('canplay',function() {
            video.play();
          });
        }
      </script>   
  


                         


                        
                    
			
				
		</section>
    </div>


    <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
	<script src="<?php echo url('/');?>/public/vplayed/js/jquery.ddslick.min.js"></script> 
	<script src="<?php echo url('/');?>/public/vplayed/js/dropkick.js" type=""></script> 
     <script type="text/javascript">
        // In your Javascript (external .js resource or <script> tag)
        
    </script>

           
    
    <script>
            $(document).ready(function() {
                $(".set > a").on("click", function() {
                    if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                    $(this)
                        .siblings(".content")
                        .slideUp(200);
                    $(".set > a i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    } else {
                    $(".set > a i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    $(this)
                        .find("i")
                        .removeClass("fa-angle-down")
                        .addClass("fa-angle-up");
                    $(".set > a").removeClass("active");
                    $(this).addClass("active");
                    $(".content").slideUp(200);
                    $(this)
                        .siblings(".content")
                        .slideDown(200);
                    }
                });
            });


 </script>
  
</body>
</html>