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
            <?php 
		if(!empty($vod_details_info)){
			if($vod_details_info["statusCode"]== 200 && $vod_details_info["status"] =="success"){
				if($vod_details_info["response"]["video_info"] != ""){
					$video_title = $vod_details_info["response"]["video_info"]["title"];
					$video_slug =  $vod_details_info["response"]["video_info"]["slug"];
					$video_description =  $vod_details_info["response"]["video_info"]["description"];
          $director =  $vod_details_info["response"]["video_info"]["director"];
          $imdb_rating =  $vod_details_info["response"]["video_info"]["imdb_rating"];
          $releaseYear =  $vod_details_info["response"]["video_info"]["releaseYear"];
          $presenter =  $vod_details_info["response"]["video_info"]["presenter"];
					$video_thumbnail_image =  $vod_details_info["response"]["video_info"]["thumbnail_image"];
					$video_hls_playlist_url =  $vod_details_info["response"]["video_info"]["hls_playlist_url"];
					$is_live =  $vod_details_info["response"]["video_info"]["is_live"];
					$video_poster_image1 =  $vod_details_info["response"]["video_info"]["poster_image"];
					$video_sprite_image =  $vod_details_info["response"]["video_info"]["sprite_image"];
					
					if(!empty($video_poster_image1)){ 
						$video_poster_image = $video_poster_image1;
					}else{
						$video_poster_image = '';//url('/')."/public/vplayed/images/vod-banner.jpg";
          }

          $ext = pathinfo($video_hls_playlist_url, PATHINFO_EXTENSION);
          if(strtoupper($ext) == 'MP4'){
            $type = 'video/mp4';
          }else{
            $type = 'application/x-mpegURL';
          }
					
				
	  ?>
            <!-- VOD Banner Section Here -->
            <div class="vod_banerWrp col-12">
                <?php if($video_poster_image != ''){?>
                <img src="<?php echo $video_poster_image; ?>" class="img-fluid">
                <?php }?>
                <div class="vod_bannerContent_wrp">
                    <div class="vod_bannerinner_Content_wrp">

                        <div class="info_wrapper">

                            <div class="movie_info">
                                <h1><?php echo $video_title; ?></h1>
                                <p class="movie_intro">
                                    <?php echo $video_description; ?>
                                </p>
                                <?php if(!empty($presenter)){?>
                                <p class="movie_intro">
                                    Starring : <?php echo $presenter; ?>
                                </p>
                                <?php }?>
                                <?php if(!empty($director)){?>
                                <p class="movie_intro">
                                    Director : <?php echo $director; ?>
                                </p>
                                <?php }?>
                                <?php if(!empty($releaseYear)){?>
                                <p class="movie_intro">
                                    Release Year : <?php echo $releaseYear; ?>
                                </p>
                                <?php }?>
                                <?php if(!empty($imdb_rating)){?>
                                <p class="movie_intro">
                                    IMDB Rating : <?php echo $imdb_rating; ?>/10
                                </p>
                                <?php }?>

                            </div>

                        </div>
                        <!-- VOD Player Section Here -->
                        <div class="vod_player_section">
                            <div class="player_wrp">
                                <video id="example-video1"></video>
                                <script>
                                    function setTracks() {
                                        var subtitle = []
                                        var subtitlesArray = [

                                            <
                                            ? php


                                            // print_r($vod_details_info);

                                            if (!empty($vod_details_info['response']['video_info']['subtitle'][
                                                    'subtitle_list'
                                                ])) {
                                                $url_vtt = $vod_details_info['response']['video_info']['subtitle'][
                                                    'base_url'
                                                ];
                                                foreach($vod_details_info['response']['video_info']['subtitle'][
                                                    'subtitle_list'
                                                ] as $key1 => $value1) {


                                                    ?
                                                    > {
                                                        language: '<?php echo $value1['
                                                        language ']; ?>',
                                                        label: '<?php echo $value1['
                                                        language ']; ?>',
                                                        url: '<?php echo $url_vtt . $value1['
                                                        url ']?>'
                                                    },

                                                    <
                                                    ? php
                                                }
                                            }

                                            ?
                                            >

                                            // {
                                            //   language: 'French',
                                            //   label: 'French',
                                            //   url: '"https://d2rq7c4c4iu0a6.cloudfront.net/vtt/190/French-396829365.vtt',
                                            // }
                                        ];
                                        subtitlesArray.forEach(element => {
                                            subtitle.push({
                                                title: 'subtitles',
                                                kind: 'subtitles',
                                                language: element.language,
                                                label: element.label,
                                                src: element.url,
                                                default: false
                                            })
                                        });
                                        subtitle.push({});
                                        return subtitle;
                                    }

                                    // Following script is used to handle the player events
                                    /*videojs.Hls.xhr.beforeRequest = function (options) {
                                      options.headers = [];
                                      options.headers['X-REQUEST-TYPE'] = 'admin'; //Do not change this line.
                                    };
                                    */
                                    var is_live_status = '<?php echo $is_live; ?>';
                                    var video;
                                    videojs.Hls.xhr.beforeRequest = function (options) {
                                        if (video && video.is_live ==
                                            is_live_status) { // If videos are not live, then only following conditions should execute
                                            options.headers = [];
                                            options.headers['X-REQUEST-TYPE'] = 'admin';
                                        }
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
                                            "type": '<?php echo $type; ?>'
                                        }],
                                        "html5": {
                                            "nativeAudioTracks": false,
                                            "nativeVideoTracks": false,
                                            "nativeTextTracks": false,
                                            "hls": {
                                                "overrideNative": true,
                                            }
                                        },
                                        "tracks": setTracks(),
                                        "plugins": {
                                            "hlsQualitySelector": {},
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
                                    player.autoplay(true);
                                    player.play();

                                    //Following method is used to pause the video.
                                    player.pause();

                                </script>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- END VOD Banner Section  -->


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

            <!-- End VOD Player Section  -->

        </section>


    </div>


    // <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
    <script src="<?php echo url('/');?>/public/vplayed/js/jquery.ddslick.min.js"></script>
    <script src="<?php echo url('/');?>/public/vplayed/js/dropkick.js" type=""></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#fromDate").datepicker({
                autoclose: true,
                todayHighlight: true,
                endDate: "today"
            });

            $("#toDate").datepicker({
                autoclose: true,
                todayHighlight: true,
                endDate: "today"
            });
        });


        var url = "<?php echo url('/getReferralsList'); ?>";

        /*$("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                $("#from_date").val('');
                $("#to_date").val('');
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
            }
        });*/


        /* filter data */
        $("#filter_data").click(function (e) {
            e.preventDefault();

            var from_date = $("#from_date").val().trim();
            var to_date = $("#to_date").val().trim();
            var searchKey = $("#searchKey").val().trim();
            //alert(searchKey);return false;
            if ((searchKey == '') && (from_date == '' || to_date == '')) {
                alert('Please select atleast one filter');
                return false;
            } else if (to_date < from_date) {
                alert('To date should be grater than From Date');
                return false;
            } else {
                var searchUrl = url + '?searchKey=' + searchKey + '&from_date=' + from_date + '&to_date=' +
                    to_date;
                location.href = searchUrl;
            }
        });

        /* clear filter data */
        $("#clear_filter_data").click(function (e) {
            e.preventDefault();
            //alert("test");
            $("#from_date").val('');
            $("#to_date").val('');
            var searchKey = $("#searchKey").val().trim();

            //var searchUrl = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
            location.href = "<?php echo url('/getReferralsList'); ?>";

        });

    </script>

    <script>
        $(document).ready(function () {
            $(".set > a").on("click", function () {
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
