<?php
$channel_name = ''; $playlist_url = '';
if(!empty($channelDetails)){
    $channel_name = $channelDetails['channel_name'];
    $playlist_url = $channelDetails['url_play'];
    $ext = pathinfo($playlist_url, PATHINFO_EXTENSION);
    if(strtoupper($ext) == 'MP4'){
        $type = 'video/mp4';
    }else{
        $type = 'application/x-mpegURL';
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
    <title>BestBOX - Catchup tv Play</title>
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
    <!-- <link href="https://vjs.zencdn.net/7.8.4/video-js.css" rel="stylesheet" /> -->
    <link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

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

        }

            .mCSB_container { overflow: -moz-scrollbars-none;
            }

            .mCSB_container { -ms-overflow-style: none;
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
    
    <div class="main-wrap w-100 p-0">
        <div class="container-fluid">
            <div class="row text-white">

                <div class="col-12">
                    <div class="back-btn-wrap">
                        <a href="javascript:history.go(-1)" class="vod-back-btn" style="text-decoration: none"><i class="fas fa-arrow-left mr-1"></i> back</a>
                    </div>
                </div>

                <div class="col-xl-9  mx-auto  my-3">
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
                            <source src="<?php echo $playlist_url; ?>" type="<?php echo $type;?>" />
                        </video>

                        <button class="fullview" onclick="openFullscreen();"><img src="<?php echo url('/');?>/public/images/fullscreen.png" class="img-fluid" style="width: 20px; height: auto;"></button>
                        <!-- <button id="wbfs">webkit fullscreen</button> -->

                        <script>
                                                                    
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
                        </script>
                    </div>
                </div>
                <!-- end player -->
            </div>
        </div>
    </div>
    <!--<button onclick="openFullscreen();" id="fullscreen">Open Video in Fullscreen Mode</button>-->
    @include('inc.v2.footer2')
    <script src="https://unpkg.com/video.js/dist/video.js"></script>
    <script>
        $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        });

        var player = videojs('my-video', {
            responsive: true
        });
        $(document).ready(function(){
            setTimeout(function(){ 
                $("#fullscreen").trigger("click"); 
            }, 3000);
            
        });  
    </script>

</body>

</html>
