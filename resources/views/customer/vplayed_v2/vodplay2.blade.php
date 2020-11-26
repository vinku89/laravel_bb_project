<?php
$vod_title = '';$vod_description ='';$director='';$imdb_rating ='';$releaseYear =''; $presenter ='';$playlist_url='';$sprite_image = '';$thumbnail_img ='';$poster_image = '';$category_name = "";
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
            $playlist_url = $vodInfo["hls_playlist_url"];
            $sprite_image = $vodInfo["sprite_image"];
            $ext = pathinfo($playlist_url, PATHINFO_EXTENSION);
            $thumbnail_img = (!empty($vodInfo["thumbnail_image"])) ? $vodInfo["thumbnail_image"] : url('/')."/public/vplayed/images/default-thumbnail.png";
            $poster_image = (!empty($vodInfo["poster_image"])) ? $vodInfo["poster_image"] : "";
            $category_name = $vodInfo["video_category_name"];
            $ext = pathinfo($playlist_url, PATHINFO_EXTENSION);
            if(strtoupper($ext) == 'MP4'){
                $type = 'video/mp4';
            }else if(strtoupper($ext) == 'webm'){
                $type = 'video/webm';
            }else if(strtoupper($ext) == 'webm'){
                $type = 'video/ogv';
            }else if(strtoupper($ext) == 'ogv'){
                $type = 'video/ogv';
            }else if(strtoupper($ext) == 'ogv'){
                $type = 'video/ogv';
            }else if(strtoupper($ext) == 'avi'){
                $type = 'video/avi';
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

    <!--plyr for player starts-->
    <script src="https://cdn.plyr.io/3.6.2/plyr.polyfilled.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.2/plyr.css" />
    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
      crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/video-dev/hls.js/18bb552/dist/hls.min.js"></script>

    <!--plyr for player ends-->

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
                                <a href="javascript:history.go(-1)" class="vod-back-btn" style="text-decoration: none"><i class="fas fa-arrow-left mr-1"></i> back</a>
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
                                </div>
                            </div>
                        </div>

                        <div class="col-12 order-1 order-xl-2 col-xl-8">
                            <!-- player -->
                            <div id="container">
                                <video controls crossorigin playsinline autoplay poster="<?php echo $poster_image;?>" id="player_id"></video>
                                
                                <!-- Plyr resources and browser polyfills are specified in the pen settings -->
<!-- Hls.js 0.9.x and 0.10.x both have critical bugs affecting this demo. Using fixed git hash to when it was working (0.10.0 pre-release), until https://github.com/video-dev/hls.js/issues/1790 has been resolved -->
                                <script type="text/javascript">

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
                                    ];
                                    var i = 1;
                                    subtitlesArray.forEach(element => {
                                        if(i == 1) { flag = true; }
                                        else { flag = false; }
                                        subtitle.push({
                                            title: 'captions',
                                            srclang: element.language,
                                            label: element.label,
                                            src: element.url,
                                            default: flag
                                        })
                                        $i++;
                                    });
                                    subtitle.push({});
                                    return subtitle;
                                }

                                document.addEventListener('DOMContentLoaded', () => {
                                const source = '<?php echo $playlist_url; ?>';
                                const video = document.querySelector('video');
                                  // Default controls
                                  
                                  // For more options see: https://github.com/sampotts/plyr/#options
                                  // captions.update is required for captions to work with hls.js
                                  const player = new Plyr(video, { 
                                  controls: [
                                    'play-large',
                                    //'restart',
                                    'rewind',
                                    'play',
                                    'fast-forward',
                                    'progress',
                                    'current-time',
                                    'duration',
                                    'mute',
                                    'volume',
                                    'captions',
                                    'settings',
                                    'pip',
                                    'airplay',
                                    // 'download',
                                    'fullscreen',
                                  ],
                                  debug: true,
                                  autoplay: true,
                                  seekTime:10,
                                  tooltips:{ controls: false, seek: true },
                                  storage:{ enabled: true, key: 'plyr' },
                                  quality:{ default: 720, options: [720, 480] },
                                  fullscreen:{ enabled: true, fallback: true, iosNative: false },
                                  tooltips: {
                                    controls: true,
                                    seek: true,
                                  },
                                  autoplay:true
                                });

                                  if (!Hls.isSupported()) {
                                    console.log('hi');
                                        player.source = {
                                          type: 'video',
                                          sources: [
                                            {
                                              src: source,
                                              type: '<?php echo $type;?>',
                                              size: 480,
                                            },
                                            {
                                              src: source,
                                              type: '<?php echo $type;?>',
                                              size: 720,
                                            },
                                          ],
                                          poster: '<?php echo $sprite_image; ?>',
                                          // previewThumbnails: {
                                          //   src: '/path/to/thumbnails.vtt',
                                          // },
                                          tracks: setTracks(),
                                        }; 

                                        player.on("loadedmetadata",onDataLoaded);

                                        function onDataLoaded() {
                                            player.currentTime = 3600;
                                            // player.muted = true;
                                            // player.play();
                                        }

                                        // Handle changing captions
                                        // player.on('languagechange', () => {
                                        //   // Caption support is still flaky. See: https://github.com/sampotts/plyr/issues/994
                                        //   setTimeout(() => hls.subtitleTrack = player.currentTrack, 50);
                                        // });

                                      } else {
                                        console.log('bye');
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

                                       window.player = player;
                                 
                                    });
  
                            </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     @include('inc.v2.footer2')

</body>

</html>
