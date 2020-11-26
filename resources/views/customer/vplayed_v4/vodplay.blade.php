<?php
$vod_title = '';$vod_description ='';$director='';$imdb_rating ='';$releaseYear =''; $presenter ='';$playlist_url='';$sprite_image = '';$thumbnail_img ='';$poster_image = '';$category_name = "";$tot_duration = 0;
$vodInfo = array();$subtitle  =array();
if(!empty($vod_info)){
    if($vod_info["statusCode"]== 200 && $vod_info["status"] =="success"){
        if($vod_info["response"]["video_info"] != ""){
            $vodInfo = $vod_info["response"]["video_info"];
            $vod_title = $vodInfo['title'];
            $subtitle = $vodInfo['subtitle'];
            $vod_description = $vodInfo["description"];
            $director = $vodInfo["director"];
            $imdb_rating = $vodInfo["imdb_rating"];
            $releaseYear = $vodInfo["releaseYear"];
            $presenter =  $vodInfo["presenter"];
            $current_duration = $vodInfo["current_duration"];
            $video_duration = $vodInfo['video_duration'];
            $duration = explode(':',$video_duration);
            if(!empty($duration)) {
                if(isset($duration[0])) $tot_duration = ($duration[0]*60*60);
                if(isset($duration[1])) $tot_duration += ($duration[1]*60);
                if(isset($duration[2])) $tot_duration += ($duration[2]);
            }
            $playlist_url = $vodInfo["hls_playlist_url"];
            $sprite_image = $vodInfo["sprite_image"];
            $ext = pathinfo($playlist_url, PATHINFO_EXTENSION);
            $thumbnail_img = (!empty($vodInfo["thumbnail_image"])) ? $vodInfo["thumbnail_image"] : url('/')."/public/vplayed/images/vod-thumbnail.png";
            $poster_image = (!empty($vodInfo["poster_image"])) ? $vodInfo["poster_image"] : "";
            $category_name = $vodInfo["video_category_name"];
            $ext = pathinfo($playlist_url, PATHINFO_EXTENSION);
            if(strtoupper($ext) == 'MP4'){
                $type = 'video/mp4';
            }else{
                $type = 'application/x-mpegURL';
            }

        }
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
    <title>BestBOX - VOD Play</title>
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
    <script src="<?php echo url('/');?>/public/vplayed/js/play.js"></script>

    <link href="<?php echo url('/');?>/public/css/customer/carousel.css?q=<?php echo rand();?>" rel="stylesheet">
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
        .info_wrapper {
            position: relative !important;
            top: 0% !important;
            padding: 15px;
            width: 100%;
        }

        .plaaybtn a{
            background: #493D00;
            border: 1px solid #F8BF00;
            border-radius: 10px;
            display: block;
            max-width: 350px;
            padding: 20px;
            text-align: center;
            color: #fff;
            font-size: 12px;
        }

        .startover a{
            background: #1E1E1E;
            border: 1px solid #747474;
            border-radius: 10px;
            display: block;
            max-width: 350px;
            padding: 20px;
            text-align: center;
            color: #fff;
            font-size: 12px;
        }

        .progress-container {
            max-width: 350px;
            width:100%;
            height: 7px;
            /* margin-top: -50px; */
            margin: -7px 0px 0;
            border: solid 0px;
            box-sizing: border-box;
            background-color: #5C5C5C;
            position: relative;
            border-radius: 0 0 80px 80px;
        }

        .progress {
            background-color: red;
            height: 100%;
            width: 20%;
            border-radius: 0 0 0px 80px !important;
        }
    </style>

</head>

<body>
    @include('inc.v2.sidenav')

    <div class="main-wrap w-100">
        <div class="container-fluid">
            @include('inc.v2.headernav')
            <div class="row">
                <div class="section_div col-12">
                    <!-- border -->
                    <hr class="grey-dark">

                    <div class="row text-white">

                        <div class="col-12 mb-3">
                            <div class="back-btn-wrap">
                                <a href="javascript:void(0)" class="vod-back-btn" style="text-decoration: none"><i class="fas fa-arrow-left mr-1"></i> back</a>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4 order-2 order-xl-1 bg-new-dark-xl">
                            <div class="info_wrapper p-0 mt-4 mt-xl-0">
                                <div class="movie_info f16">
                                    <h1 class="semi-bold f24"><?php echo $vod_title; ?></h1>
                                    <div class="d-inline-block mr-3">
                                        <?php if(!empty($imdb_rating)){?>
                                        <p class="movie_intro rating semi-bold">
                                            <span><img style="width: 30px; height: auto;" src="<?php echo url('/');?>/public/customer/images/imdb.png"></span> :  <span class="f16"><?php echo $imdb_rating; ?></span>/10
                                        </p>
                                        <?php }?>
                                    </div>
                                    <div class="d-inline-block mr-3">
                                        <p class="movie_intro">
                                            <span><img style="width: 20px; height: auto;" src="<?php echo url('/');?>/public/customer/images/rottom.png"></span> : N/A
                                        </p>
                                    </div>
                                    <div class="d-inline-block ml-3">
                                        <?php if(!empty($releaseYear)){?>
                                        <p class="movie_intro">
                                            <span class="semi-bold">Release Year</span> : <span class="f16"><?php echo $releaseYear; ?></span>
                                        </p>
                                        <?php }?>
                                    </div>

                                    <div class="my-3 f16">
                                        <?php if(!empty($presenter)){?>
                                        <p class="movie_intro">
                                            <span style="color: #F2E000;" class="semi-bold">Starring</span> : <?php echo $presenter; ?>
                                        </p>
                                        <?php }?>
                                    </div>

                                    <div class="my-3 f16">
                                        <?php if(!empty($director)){?>
                                        <p class="movie_intro">
                                            <span style="color: #F2E000;" class="semi-bold">Director</span> : <?php echo $director; ?>
                                        </p>
                                        <?php }?>
                                    </div>
                                    <p class="movie_intro f18">
                                        <?php echo $vod_description; ?>
                                    </p>
                                    <div class="row">
                                    <?php
                                    /*
                                    if($current_duration<=1){?>
                                    <div class="plaaybtn my-4">
                                        <a href="javascript:void(0);" class="" onclick="openFullscreen();"><span class="mx-2"><img src="<?php echo url('/');?>/public/img/customer/play-icon.png" class="img-fluid"></span><span>Play</a>
                                        <!-- <div class="progress-container">
                                            <div class="progress" style="width:40%"></div>
                                        </div> -->
                                    </div>
                                    <?php }else if($percentage>95){?>
                                        <div class="startover my-4 col-12 col-sm-6">
                                            <a href="javascript:void(0);" class="start_over" onclick="openFullscreen();"><span class="mx-2"><img src="<?php echo url('/');?>/public/img/customer/startover.png" class="img-fluid"></span><span>Start Over</a>
                                            <div class="progress-container">
                                                <div class="progress" style="width:<?php echo $percentage;?>%"></div>
                                            </div>
                                        </div>
                                        <?php }else{?>
                                        <div class="startover my-4 col-12 col-sm-6">
                                            <a href="javascript:void(0);" class="" onclick="openFullscreen();"><span class="mx-2"><img src="<?php echo url('/');?>/public/img/customer/startover.png" class="img-fluid"></span><span>Resume</a>
                                            <div class="progress-container">
                                                <div class="progress" style="width:<?php echo $percentage;?>%"></div>
                                            </div>
                                        </div>

                                        <div class="startover my-4 col-12 col-sm-6">
                                            <a href="javascript:void(0);" class="start_over" ><span class="mx-2"><img src="<?php echo url('/');?>/public/img/customer/startover.png" class="img-fluid"></span><span>Play from beginning</a>
                                            <div class="progress-container">
                                                <div class="progress" style="width:<?php echo $percentage;?>%"></div>
                                            </div>
                                        </div>
                                        <?php }
                                        */?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-xl-8 order-1 order-xl-2 ">
                            <!-- player -->
                            <div id="container">
                                <video id="player_id"></video>
                                <input type="hidden" id="current_time" value="<?php echo $current_duration;?>" />
                                <input type="hidden" id="previous_time" value="<?php echo $current_duration;?>" />
                                <input type="hidden" id="total_duration" value="<?php echo $tot_duration;?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     @include('inc.v2.footer2')
     <script>
        function setTracks() {
            var subtitle = []
            var subtitlesArray = [
                <?php
                    if (!empty($subtitle['subtitle_list'])) {
                    $url_vtt = $subtitle['base_url'];
                    foreach($subtitle['subtitle_list'] as $key => $value) {?> {
                            language: '<?php echo $value['language']; ?>',
                            label: '<?php echo $value['language']; ?>',
                            url: '<?php echo $url_vtt.$value['url']?>'
                        },
                    <?php
                    }
                }?>
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
        var video;
        videojs.Hls.xhr.beforeRequest = function (options) {
            if (video && video.is_live ==
                is_live_status) { // If videos are not live, then only following conditions should execute
                options.headers = [];
                options.headers['X-REQUEST-TYPE'] = 'admin';
            }
        };


            jQuery('#player_id').on('timeupdate', function(){
                var current_time = parseInt(this.currentTime);
                $("#current_time").val(current_time);
                var csrf_Value = "<?php echo csrf_token(); ?>";
                var previous_time = parseInt($("#previous_time").val());
                var tot_duration = $("#total_duration").val();
                if(current_time == tot_duration-1) {
                //setInterval(function(){
                    $.ajax({
                        url: "<?php echo url('/');?>/updateDuration",
                        method: 'POST',
                        dataType: "json",
                        data: {
                            'current_time': current_time,
                            'user_id': <?php echo $user_id;?>,
                            'video_slug': '<?php echo $slug;?>',
                            'episode_title': '',
                            'series_title' : '',
                            'episode_name' : '',
                            'is_series' : 0,
                            "_token": csrf_Value
                        },
                        success: function (response) {
                            $("#previous_time").val(current_time);
                        }
                    });
                //}, 10000);
                }
            });


        // jQuery('#player_id').on('webkitfullscreenchange', function () {
        //     console.log('hisdfsf');
        //     if (this.isFullscreen()) {
        //         console.log("Video fullscreenchange: Video exited fullscreen");
        //     }else{
        //         console.log('exit screen');
        //     }
        // });

        // var myEvent = window.attachEvent || window.addEventListener;
        // var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compitable

        // myEvent(chkevent, function(e) {
        //     current_time = $("#current_time").val();
        //     var previous_time = parseInt($("#previous_time").val());
        //     if(current_time != previous_time) {
        //         var csrf_Value = "<?php echo csrf_token(); ?>";
        //         $.ajax({
        //             url: "<?php echo url('/');?>/updateDuration",
        //             method: 'POST',
        //             dataType: "json",
        //             data: {
        //                 'current_time': current_time,
        //                 'user_id': <?php echo $user_id;?>,
        //                 'video_slug': '<?php echo $slug;?>',
        //                 'episode_title': '',
        //                 'series_title' : '',
        //                 'episode_name' : '',
        //                 'is_series' : 0,
        //                 "_token": csrf_Value
        //             },

        //             success: function (response) {
        //                 $("#previous_time").val(current_time);
        //             }
        //         });
        //     }
        // });

        $(window).bind('beforeunload', function(){
            current_time = $("#current_time").val();
            var previous_time = parseInt($("#previous_time").val());
            if(current_time != previous_time) {
                var csrf_Value = "<?php echo csrf_token(); ?>";
                $.ajax({
                    url: "<?php echo url('/');?>/updateDuration",
                    method: 'POST',
                    dataType: "json",
                    data: {
                        'current_time': current_time,
                        'user_id': <?php echo $user_id;?>,
                        'video_slug': '<?php echo $slug;?>',
                        'episode_title': '',
                        'series_title' : '',
                        'episode_name' : '',
                        'is_series' : 0,
                        "_token": csrf_Value
                    },

                    success: function (response) {
                        $("#previous_time").val(current_time);
                    }
                });
           }
        });

        $(window).bind('unload', function(){
            current_time = $("#current_time").val();
            var previous_time = parseInt($("#previous_time").val());
            if(current_time != previous_time) {
                var csrf_Value = "<?php echo csrf_token(); ?>";
                $.ajax({
                    url: "<?php echo url('/');?>/updateDuration",
                    method: 'POST',
                    dataType: "json",
                    data: {
                        'current_time': current_time,
                        'user_id': <?php echo $user_id;?>,
                        'video_slug': '<?php echo $slug;?>',
                        'episode_title': '',
                        'series_title' : '',
                        'episode_name' : '',
                        'is_series' : 0,
                        "_token": csrf_Value
                    },

                    success: function (response) {
                        $("#previous_time").val(current_time);
                    }
                });
            }
        });

        var player = videojs('player_id', {
            "controls": true,
            "autoplay": true,
            "preload": "auto",
            "fluid": true,
            "playsinline" : true,
            "allowfullscreen" : true,
            "playbackRates": [0.25, 0.5, 1, 1.25, 1.5, 2],
            "sources": [{
                //Following src url should be changed as per your project. Here I have mentioned it as static for demo purpose.
                "src": '<?php echo $playlist_url; ?>',
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


        player.currentTime(<?php echo $current_duration;?>);


        /** Following function is used to display thumbnails in the player seek bar. If you have
        sprite image url, then use the following function. Url should be changed as per your project. Here
        I have mentioned it as static for demo purpose**/
        player.spriteThumbnails({
            url: '<?php echo $sprite_image; ?>',
            width: 192,
            height: 113,
            stepTime: 20
        });
        player.webkitEnterFullScreen();
        //Following method is used to play the video.
        player.autoplay(true);
        player.play();
        //Following method is used to pause the video.
        player.pause();
        /* Function to open fullscreen mode */

        // $(document).ready(function()
        // {
        //     var initdone = false;

        //     // wait for video metadata to load, then set time
        //     video.on("loadedmetadata", function(){
        //         video.currentTime(<?php echo $current_duration;?>);
        //     });

        //     // iPhone/iPad need to play first, then set the time
        //     // events: https://www.w3.org/TR/html5/embedded-content-0.html#mediaevents
        //     video.on("canplaythrough", function(){
        //         if(!initdone)
        //         {
        //             video.currentTime(<?php echo $current_duration;?>);
        //             initdone = true;
        //         }
        //     });

        // }); //


    </script>

    <script type="text/javascript">
    $(".vod-back-btn").click(function() {
        var is_home  = "<?php echo $is_home;?>";
        window.location.href = is_home;
    });

    </script>
    <script>
        function openFullscreen() {

            var elem = document.getElementById("player_id");
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
    </script>
</body>

</html>
