<?php
$series_title = '';$series_description ='';$director='';$imdb_rating ='';$releaseYear =''; $presenter ='';$playlist_url='';$sprite_image = '';$thumbnail_img ='';$poster_image = '';$category_name = "";$maincategory_slug = '';$episode_order = '';$type='';$slug = '';$tot_duration = 0;
$seriesInfo = array();$subtitle =array();
if(!empty($series_info)){
  if($series_info["statusCode"]== 200 && $series_info["status"] =="success"){
        if($series_info["response"]["videos"] != ""){
            $seriesInfo = $series_info["response"]["videos"];
            $slug = $seriesInfo['slug'];
            $episode_order = $seriesInfo["episode_order"];
            $series_title = $seriesInfo['title'];
            $subtitle = $seriesInfo['subtitle'];
            $series_description = $seriesInfo["description"];
            $director = $seriesInfo["director"];
            $imdb_rating = $seriesInfo["imdb_rating"];
            $releaseYear = $seriesInfo["releaseYear"];
            $presenter =  $seriesInfo["presenter"];
            $current_duration = $seriesInfo["current_duration"];
            $video_duration = $seriesInfo['video_duration'];
            $duration = explode(':',$video_duration);
            if(!empty($duration)) {
                if(isset($duration[0])) $tot_duration = ($duration[0]*60*60);
                if(isset($duration[1])) $tot_duration += ($duration[1]*60);
                if(isset($duration[2])) $tot_duration += ($duration[2]);
            }
            $playlist_url = $seriesInfo["hls_playlist_url"];
            $sprite_image = $seriesInfo["sprite_image"];
            $ext = pathinfo($playlist_url, PATHINFO_EXTENSION);
            $thumbnail_img = (!empty($seriesInfo["thumbnail_image"])) ? $seriesInfo["thumbnail_image"] : url('/')."/public/vplayed/images/default-thumbnail.png";
            $poster_image = (!empty($seriesInfo["poster_image"])) ? $seriesInfo["poster_image"] : url('/')."/public/vplayed/images/default-thumbnail.png";
            $category_name = $seriesInfo["video_category_name"];
            $season_id = $seriesInfo["season_id"];
            $seid = ($season_id <10) ? '0'.$season_id : $season_id;
            $setitle = $category_name.'    SE'.$seid.'/EP'.$episode_order;
            $epname = $series_title.'    SE'.$seid.'/EP'.$episode_order;
            $maincategory_slug = str_replace(" ","-",strtolower($category_name));
            $category_slug = DB::connection('mysql2')->select("SELECT `slug` FROM `video_webseries_detail` WHERE `title`='".$category_name."' LIMIT 1");
            if(!empty($category_slug)){
              foreach ($category_slug as $value)
              {
                  $maincategory_slug = $value->slug;
              }
            }
            $maincategory_slug = $maincategory_slug.'/'.$season_id;

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
    <title>BestBOX - Webseries Play</title>
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
                        <?php //echo url('/')/webseriesDetailsList/<?php echo $maincategory_slug; ?>
                        <div class="col-12 col-xl-4 order-2 order-xl-1 bg-new-dark-xl">
                            <div class="info_wrapper p-0 mt-4 mt-xl-0">
                                <div class="movie_info f16">

                                    <h1 class="semi-bold f24"><?php echo $series_title." (".$category_name." )"; ?></h1>

                                    <div class="movie_rating mb-3">
                                        Episode - <?php echo $episode_order; ?>
                                    </div>
                                    <div class="d-inline-block mr-3">
                                        <?php if(!empty($imdb_rating)){?>
                                        <p class="movie_intro rating semi-bold">
                                            <span><img style="width: 30px; height: auto;" src="<?php echo url('/');?>/public/customer/images/imdb.png"></span> : <span class="f16"><?php echo $imdb_rating; ?></span>/10
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
                                        <?php echo $series_description; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 order-1 order-xl-2 col-xl-8">
                        <!-- player -->
                        <div id="container">
                            <video id="player_id"></video>
                            <input type="hidden" id="current_time" value="<?php echo $current_duration;?>" />
                            <input type="hidden" id="previous_time" value="<?php echo $current_duration;?>" />
                            <input type="hidden" id="episode_title" value="<?php echo $setitle;?>" />
                            <input type="hidden" id="total_duration" value="<?php echo $tot_duration;?>" />
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
            var tot_duration = $("#total_duration").val();
            if(current_time == tot_duration-1) {
            // setInterval(function(){
                $.ajax({
                    url: "<?php echo url('/');?>/updateDuration",
                    method: 'POST',
                    dataType: "json",
                    data: {
                        'current_time': current_time,
                        'user_id': <?php echo $user_id;?>,
                        'episode_title': "<?php echo $setitle;?>",
                        'video_slug': "<?php echo $slug;?>",
                        'is_series' : 1,
                        'series_title' : "<?php echo $category_name;?>",
                        'episode_name' : "<?php echo $epname;?>",
                        "_token": csrf_Value
                    },
                    success: function (response) {
                        $("#previous_time").val(current_time);
                    }
                });
            // }, 10000);
            }
        });

        $(window).bind('beforeunload', function(){
            current_time = $("#current_time").val();
            var episode_title = $("#episode_title").val();
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
                        'episode_title': "<?php echo $setitle;?>",
                        'video_slug': "<?php echo $slug;?>",
                        'is_series' : 1,
                        'series_title' : "<?php echo $category_name;?>",
                        'episode_name' : "<?php echo $epname;?>",
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
            var episode_title = $("#episode_title").val();
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
                        'episode_title': "<?php echo $setitle;?>",
                        'video_slug': "<?php echo $slug;?>",
                        'is_series' : 1,
                        'series_title' : "<?php echo $category_name;?>",
                        'episode_name' : "<?php echo $epname;?>",
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
        // player.addEventListener("loadeddata", function () {
        //     player.currentTime(<?php echo $current_duration;?>);
        // });

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
        player.autoPlay(true);
        player.play();

        //Following method is used to pause the video.
        player.pause();


    </script>
    <script>
    $(".vod-back-btn").click(function() {
        var is_home  = "<?php echo $is_home;?>";
        window.location.href = is_home;
    });
    </script>
</body>

</html>
