<?php
$video_sprite_image = '';$channel_title = '';$playlist_url='';$sprite_image = '';$thumbnail_img ='';$country_name = '';
$channelInfo = array(); $relatedChannels = array();
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
    <script src="<?php echo url('/');?>/public/vplayed/js/play.js"></script>

    <link href="https://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.carousel.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.theme.default.css">

    <link href="<?php echo url('/');?>/public/css/customer/carousel.css?q=<?php echo rand();?>" rel="stylesheet">

    <!--plyr for player starts-->
    <script src="https://cdn.plyr.io/3.6.2/plyr.polyfilled.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.2/plyr.css" />
    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>

    <!--plyr for player ends-->

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

        @media (min-width: 1200.99px){
            .mCSB_container::-webkit-scrollbar { width: 0 !important;
            display: none; }

            .mCSB_container { overflow: -moz-scrollbars-none;
                display: none; }

            .mCSB_container { -ms-overflow-style: none;
                display: none; }
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

                        <div class="col-12">
                            <div class="back-btn-wrap">
                                <a href="javascript:history.go(-1)" class="vod-back-btn" style="text-decoration: none"><i class="fas fa-arrow-left mr-1"></i> back</a>
                            </div>
                        </div>

                        <div class="col-xl-8 my-3">
                            <!-- player -->
                            <div id="container">
                                <video id="player_id" controls crossorigin playsinline></video>
                                <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
  const source = '<?php echo $playlist_url;?>';
  const video = document.querySelector('video');

  const video2 = document.getElementById('video').attr('data-plyr');
  if(video2 == 'fullscreen')

  // For more options see: https://github.com/sampotts/plyr/#options
  // captions.update is required for captions to work with hls.js
  const player = new Plyr(video, { controls: [
    'play-large',
    //'restart',
    //'rewind',
    'play',
    //'fast-forward',
    'progress',
    //'current-time',
    //'duration',
    'mute',
    'volume',
    'captions',
    'settings',
    'pip',
    'airplay',
    // 'download',
    'fullscreen',
  ],
  // Fullscreen settings
  fullscreen: {
    enabled: true, // Allow fullscreen?
    fallback: true, // Fallback using full viewport/window
    iosNative: true, // Use the native fullscreen in iOS (disables custom controls)
    // Selector for the fullscreen container so contextual / non-player content can remain visible in fullscreen mode
    // Non-ancestors of the player element will be ignored
    // container: null, // defaults to the player element
  },
  captions: { active: true, update: true, language: 'en' } ,
  });


  if (!Hls.isSupported()) {
    video.src = source;
  } else {
    // For more Hls.js options, see https://github.com/dailymotion/hls.js
    const hls = new Hls();
    hls.loadSource(source);
    hls.attachMedia(video);
    window.hls = hls;

    // Handle changing captions
    player.on('languagechange', () => {
      // Caption support is still flaky. See: https://github.com/sampotts/plyr/issues/994
      setTimeout(() => hls.subtitleTrack = player.currentTrack, 50);
    });

  }

  
    
  player.on('timeupdate enterfullscreen exitfullscreen', event => console.log(event.type));

  // Expose player so it can be used from the console
  window.player = player;
  video.addEventListener('webkitfullscreenchange', onFullScreen);
  function onFullScreen(){
    var elem = document.getElementById("player_id");
      if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
        elem.webkitRequestFullscreen();
      }
  }
  
});
    </script>
   <script>
var elem = document.getElementById("player_id");
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
function onFullScreen() {
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
   <button onclick="openFullscreen();">Open Video in Fullscreen Mode</button>

                            </div>
                        </div>
                        <!-- end player -->

                        <div class="col-xl-4 my-3">
                            <div class="player_epg h-100">
                                <div class="row mx-0 pt-1"
                                    style="background-color: #303030 !important; position: relative; z-index: 9;">
                                    <div class="col-4 align-self-center">
                                        <img src="<?php echo $thumbnail_img;?>" class="img-fluid img-xl-half" style="width: 150px;">
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

                                <div class="epg-list mt-1 mb-4 col-12" style="">
                                    <div class="row my-2 text-white">
                                        <div class="col-md-4 f14 d-md-block d-none text-grey" style="letter-spacing: 0.8px">TIME</div>
                                        <div class="col-md-8 f14 d-md-block d-none text-grey" style="letter-spacing: 0.8px">PROGRAMME</div>
                                    </div>
                                    <script>
                                        var today = new Date();
                                        var day = today.getDate();
                                        var month = today.getMonth() + 1;
                                        var year = today.getFullYear();
                                        var hours = today.getHours();
                                        var minutes = today.getMinutes();
                                        var seconds = today.getSeconds();

                                        if (day < 10) {
                                        day = '0' + day;
                                        }
                                        if (month < 10) {
                                        month = '0' + month;
                                        }
                                        if (hours < 10) {
                                        hours = '0' + hours;
                                        }
                                        if (minutes < 10) {
                                        minutes = '0' + minutes;
                                        }
                                        if (seconds < 10) {
                                        seconds = '0' + seconds;
                                        }

                                        var time = year+'-'+month+'-'+day+' '+hours+':'+minutes+':'+seconds;
                                        document.cookie='datecookie='+time;
                                        </script>
                                        <?php
                                        if (isset($_COOKIE["datecookie"])){
                                        $time = $_COOKIE["datecookie"];
                                        }
                                        else{
                                        $time = "";
                                        }
                                        ?>
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
            </div>
        </div>
    </div>
    @include('inc.v2.footer2')

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
    </script>
</body>

</html>
