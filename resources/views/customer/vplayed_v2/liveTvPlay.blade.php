<?php
$video_sprite_image = '';$channel_title = '';$playlist_url='';$sprite_image = '';$thumbnail_img ='';$country_name = '';$category_name = '';
$channelInfo = array(); $relatedChannels = array();
//echo '<pre>';print_R($livetv_info);exit;
if(!empty($livetv_info)){
    if($livetv_info["statusCode"]== 200 && $livetv_info["status"] =="success"){
        if($livetv_info["response"]["video_info"] != ""){
            $channelInfo = $livetv_info["response"]["video_info"];
            $channel_title = $channelInfo['title'];
            $country_name = $channelInfo['country'];
            $playlist_url = $channelInfo["hls_playlist_url"];
            $sprite_image = $channelInfo["sprite_image"];
            $ext = pathinfo($playlist_url, PATHINFO_EXTENSION);
            $thumbnail_img = (!empty($channelInfo["thumbnail_image"])) ? $channelInfo["thumbnail_image"] : url('/')."/public/vplayed/images/default-thumbnail.png";
            $category_name = $channelInfo["video_category_name"];
            if(strtoupper($ext) == 'MP4'){
                $type = 'video/mp4';
            }else{
                $type = 'application/x-mpegURL';
            }
        }
        if($livetv_info["response"]["similar"] != ""){
            $relatedChannels = $livetv_info["response"]["similar"];

        }
        
    }
    if(Session::has('live_redirectURL') && Session::get('live_redirectURL') != ''){
        $redirectURL = Session::get('live_redirectURL');
    }else{
        $redirectURL = url('/').'/livetv';
    }
    
}
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBOX - Live tv Play</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/plyr.css?q=<?php echo rand();?>" rel="stylesheet">
    <!-- select2 -->
    <link href="<?php echo url('/');?>/public/css/customer/select2.min.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/select2-bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vdplay.css?q=<?php echo rand();?>">

    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vod.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/player.css?q=<?php echo rand();?>">
    <!-- <script src="<?php echo url('/');?>/public/vplayed/js/play.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.15.0/videojs-contrib-hls.min.js"></script> -->
    <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.carousel.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.theme.default.css">

    <link href="<?php echo url('/');?>/public/css/customer/carousel.css?q=<?php echo rand();?>" rel="stylesheet">

    <!-- <link href="https://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css" rel="stylesheet"> -->
    <link href="<?php echo url('/');?>/public/css/customer/jquery.mCustomScrollbar.min.css" rel="stylesheet">


    <!-- for tracking -->
    <script src="https://www.datadoghq-browser-agent.com/datadog-rum-eu.js" type="text/javascript">
    </script>
    <script>
    window.DD_RUM && window.DD_RUM.init({
        clientToken: 'pub36cb304d6b4093ef35d15e60b03c3772',
        applicationId: '04797c6b-7265-4dc6-802a-1e896506548b',
        trackInteractions: true,
    });
    </script>
    <!-- for tracking -->
    <style>

        @media (max-width: 1200px){
            .mCSB_container{
                    overflow-y: scroll !important;
            }
        }

        /* .mCustomScrollBox>.mCSB_scrollTools{ opacity: 0 !important; } */

        @media (min-width: 1200.99px){
            .mCSB_container::-webkit-scrollbar { width: 0 !important;
            /* display: none;  */

        }

            .mCSB_container { overflow: -moz-scrollbars-none;
                /* display: none; */
            }

            .mCSB_container { -ms-overflow-style: none;
                /* display: none;  */
            }
        }

        .video-js {
            padding: 55.25% 8px 8px;
            width: 100%;
            height: 100%;
            max-height: 550px;
        }

        .video-js.vjs-fullscreen {
            width: 100% !important;
            height: 100% !important;
            padding-top: 0 !important;
        }
        
        .fullview{
            background: transparent !important;
            border: none !important;
            color: #fff;
            width: 22px !important;
            height: 20px !important;
            right: 9px !important;
            bottom: 9px !important;
            position: absolute;
        }
        .video-js .vjs-progress-holder .vjs-play-progress { display: none !important; }

    </style>
</head>

<body>
    @include('inc.v2.sidenav')

    <div class="main-wrap w-100">
        <div class="container-fluid">
        @include('inc.v2.headernav')
            <div class="row">
                <?php if($maintanance_mode['is_livetv_maintanance_flag']){?>
                    <div class="section_div col-12 mb-0">
                        <img src="<?php echo url('/');?>/public/images/maintanance_mode.JPG" class="img-fluid">
                    </div>
                <?php }else{?>
                    <div class="section_div col-12">
                        <!-- border -->
                        <hr class="grey-dark">

                        <div class="row text-white">

                            <div class="col-12">
                                <div class="back-btn-wrap">
                                    <a href="<?php echo $redirectURL;?>" class="vod-back-btn" style="text-decoration: none"><i class="fas fa-arrow-left mr-1"></i> back</a>
                                </div>
                            </div>

                            <div class="col-xl-8 my-3">
                                <!-- player -->
                                <div id="container" style="position: relative;">
                                    <video 
                                    id="my-video"
                                    class="video-js"
                                    controls
                                    preload="auto"
                                    width="100%"
                                    height=""
                                    data-setup="{}"
                                    autoplay
                                    playsinline
                                    >
                                    <source src="<?php echo $playlist_url; ?>" type="application/x-mpegURL" />
                                    </video>

                                    <button class="fullview" onclick="openFullscreen();"><img src="<?php echo url('/');?>/public/images/fullscreen.png" class="img-fluid" style="width: 20px; height: auto;"></button>
                                    <!-- <button id="wbfs">webkit fullscreen</button> -->

                                    <script>
                                        // videojs("#my-video", {
                                        //     controlBar: {
                                        //     fullscreenToggle: true
                                        //     }
                                        // });
                                        // wbfs.onclick = () => videojs.players.my_video.tech_.openFullScreen();
                                        // fake a livestream for easy testing
                                        // var vid = document.getElementById('my-video');
                                        // var liveui = true

                                        // if (videojs.browser.IS_ANDROID) {
                                        // liveui = false;
                                        // }
                                        // var player = videojs(vid, {liveui: liveui});
                                        
                                        var elem = document.getElementById("my-video");
                                        function openFullscreen() {
                                            if (elem.requestFullscreen) {
                                                elem.requestFullscreen();
                                            } else if (elem.mozRequestFullScreen) { /* Firefox */
                                                elem.mozRequestFullScreen();
                                            } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
                                                elem.webkitRequestFullscreen();
                                            } else if (elem.msRequestFullscreen) { /* IE/Edge */
                                                elem.msRequestFullscreen();
                                            }
                                        }

                                        var elem = document.getElementById("my-video");
                                        $(".vjs-fullscreen-control").click(function(e){
                                            
                                            if (elem.requestFullscreen) {
                                                elem.requestFullscreen();
                                            } else if (elem.mozRequestFullScreen) { /* Firefox */
                                                elem.mozRequestFullScreen();
                                            } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
                                                elem.webkitRequestFullscreen();
                                            } else if (elem.msRequestFullscreen) { /* IE/Edge */
                                                elem.msRequestFullscreen();
                                            }
                                        });

                                        // var fullwid = videojs(elem);

                                        // fullwid.webkitEnterFullScreen();
                                        // fullwid.openFullscreen();

                                        // $(".vjs-fullscreen-control").onclick = () => videojs.players.my_video.tech_.enterFullScreen()
                                    </script>
                                    

                                </div>
                            </div>
                            <!-- end player -->

                            <div class="col-xl-4 my-3">
                                <div class="player_epg h-100">
                                    <div class="row mx-0 pt-1"
                                        style="background-color: #303030 !important; position: relative; z-index: 9;">
                                        <div class="col-4 align-self-center">
                                            <img src="<?php echo $thumbnail_img;?>" class="img-fluid" style="width: 150px;">
                                        </div>

                                        <div class="col-8">
                                            <div class="text-right">
                                                <div class="text-white f17" style="letter-spacing: 1.06px"><?php echo $channel_title;?></div>
                                                <div class="f13 text-gret"  style="letter-spacing: 0.8px"><span class="font-light">Language:</span> <span class="font-medium">English</span>
                                                </div>
                                                <div class="f13 text-gret" style="letter-spacing: 0.8px"><span class="font-light">Genre:</span> <span class="font-medium"><?php echo $category_name;?></span></div>
                                                <div class="f13 text-gret" style="letter-spacing: 0.8px"><span class="font-light">Country:</span> <span class="font-medium"><?php echo $country_name;?></span></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr class="grey-dark my-1">
                                        </div>
                                    </div>

                                    <div class="epg-list mt-1 mb-4 px-3" style="">
                                        <div class="row my-2 text-white">
                                            <div class="col-md-4 f14 d-md-block d-none text-grey" style="letter-spacing: 0.8px">TIME</div>
                                            <div class="col-md-8 f14 d-md-block d-none text-grey" style="letter-spacing: 0.8px">PROGRAMME</div>
                                        </div>
                                        <?php
                                                if(!empty($epg_info) && count($epg_info)>0){
                                                    $i = 1;
                                                    foreach ($epg_info as $value) {
                                                    // $cur_time = $_COOKIE["datecookie"];

                                                    // $cur_time = strtotime($cur_time);
                                                    // $start_time = strtotime($value['start_date']);
                                                    // $end_time = strtotime($value['end_date']);

                                                    //if($start_time == $cur_time || $start_time > $cur_time || $end_time > $cur_time) {
                                                    ?>
                                                    <div class="row my-2 text-white <?php if($i==1) echo 'currentvieww';?>">
                                                        <div class="col-md-4 f16 font-light" style="letter-spacing: 1.06px"><?php echo $value['start'];?></div>
                                                        <div class="col-md-8">
                                                            <div class="f16 font-light" style="letter-spacing: 1.06px"><?php echo $value['title'];?></div>
                                                            <div class="f12 font-extralight"><?php echo substr($value['desc'], 0, 30).'...';?>
                                                            </div>
                                                        </div>

                                                    </div>

                                            <hr class="my-1" style="border-color: #6D7278">
                                            <?php $i++; //}
                                                }
                                                }else{
                                                    echo '<div class="row my-5 pt-0 pt-lg-3 text-white"><div class="col-md-12 text-center">Program Information is not available right now</div></div>';
                                                }?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- row title with line -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="row-title text-white d-inline-block pr-4 position-relative">
                                    SIMILAR CHANNELS
                                </div>
                            </div>
                        </div>

                        <!-- News Grid -->
                        <?php
                        $cj=1;
                            if(!empty($relatedChannels)){ $i=0;?>
                        <div class="row py-2">
                            <div id="carousel<?php echo $cj;?>" class="col-12">
                                <ul class="owl-carousel carousel-main m-auto p-0 with-similar">
                                    <?php foreach($relatedChannels['data'] as $item) {
                                            $title = (!empty($item['title'])) ? $item['title'] : '';
                                            $slug = (!empty($item['slug'])) ? $item['slug'] : '';
                                            if($videoSlug == $slug) continue;
                                            if(!empty($item["thumbnail_image"])){
                                                $substring = 'https://';
                                                $thumbnail_img = $item["thumbnail_image"];
                                                if(strpos($thumbnail_img, $substring) === false){
                                                    $url = url('/');
                                                    if($url == 'https://bestbox.net' || $url == 'https://bb3778.com/') {
                                                        $urlpath = 'https://prodstore.bb3778.com/bestbox/';
                                                    }else if($url == 'https://staging.bestbox.net' || $url == 'https://staging.bb3778.com/') {
                                                        $urlpath = 'https://stgstore.bb3778.com/bestbox/';
                                                    }else{
                                                        $urlpath = '';
                                                    }
                                                $thumbnail_img = $urlpath.$thumbnail_img;
                                                }
                                            }else{
                                                $thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
                                            }?>
                                    <!-- News Grid -->

                                    <li class="text-center d-inline-block">
                                        <a class="carousel-tile" href="<?php echo url('/');?>/livetvChannelView/<?php echo $slug;?>">
                                            <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                        </a>
                                        <div class="text-white"><?php echo $title;?></div>
                                    </li>
                                <?php $i++;}?>
                                </ul>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    @include('inc.v2.footer2')


     <!-- <script src="https://vjs.zencdn.net/7.8.4/video.js"></script>      -->
    <script src="https://unpkg.com/video.js/dist/video.js"></script>
    <script src="<?php echo url('/');?>/public/js/customer/owlcarousel/owl.carousel.min.js"></script>
    <script>

        $('.carousel-main').owlCarousel({
            loop:false,
            margin:10,
            nav:true,
            autoWidth:true,
            dots: false,
        });

        $(".epg-list").mCustomScrollbar({
            advanced: {
                updateOnContentResize: false
            }
        });
        $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        });
    </script>

</body>

</html>
