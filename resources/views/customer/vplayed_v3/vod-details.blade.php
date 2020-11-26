<?php
  if(!empty($vod_details_info)){
    if($vod_details_info["statusCode"]== 200 && $vod_details_info["status"] =="success"){
      $vinfo = $vod_details_info["response"]["video_info"];
      if(!empty($vinfo)){
        $video_title = $vinfo["title"];
        $video_slug =  $vinfo["slug"];
        $video_description =  $vinfo["description"];
        $director =  $vinfo["director"];
        $imdb_rating =  $vinfo["imdb_rating"];
        $releaseYear =  $vinfo["releaseYear"];
        $presenter =  $vinfo["presenter"];
        $video_thumbnail_image =  $vinfo["thumbnail_image"];
        $video_hls_playlist_url =  $vinfo["hls_playlist_url"];
        $is_live =  $vinfo["is_live"];
        $video_poster_image =  (!empty($vinfo["poster_image"])) ? $vinfo["poster_image"] : '';
        $video_sprite_image =  $vinfo["sprite_image"];
        $ext = pathinfo($video_hls_playlist_url, PATHINFO_EXTENSION);
        if(strtoupper($ext) == 'MP4'){
          $type = 'video/mp4';
        }
        else{
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
    <title>>BestBox - VOD Details </title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/plyr.css?q=<?php echo rand();?>" rel="stylesheet">
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
</head>

  <body>
    @include('inc.v2.sidenav')
    <div class="main-wrap">
      <div class="container-fluid">
        @include('inc.v2.headernav')
        <div class="row">
          <div class="section_div col-12">
            <!-- border -->
            <hr class="grey-dark">
            <div class="row text-white vod_banerWrp">
              <div class="col-xl-6 align-self-center">
                <?php if($video_poster_image != ''){?>
                  <img src="<?php echo $video_poster_image; ?>" class="img-fluid">
                <?php }?>
              </div>

              <div class="col-xl-6 align-self-center">
                <div class="info_wrapper py-3">
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
              </div>

              <div class="vod_bannerContent_wrp col-12">
                <div class="vod_bannerinner_Content_wrp">

                  <!-- VOD Player Section Here -->
                  <div class="">
                    <!-- player -->
                    <div id="container">
                        <video controls crossorigin playsinline
                            data-poster="<?php echo $video_sprite_image; ?>" id="player" class="w-100">
                            <source src="<?php echo $video_hls_playlist_url; ?>" type="<?php echo $type;?>"
                                size="720" />
                            <source src="<?php echo $video_hls_playlist_url; ?>" type="<?php echo $type;?>"
                                size="1080" />
                            <!-- Caption files -->
                            <?php
                              if(!empty($vinfo['subtitle']['subtitle_list'])){
                              $url_vtt = $vinfo['subtitle']['base_url'];
                              foreach ($vinfo['subtitle']['subtitle_list'] as $key1 => $value1) {?>
                            <track kind="captions" label="<?php echo $value1['language']; ?>"
                                srclang="<?php echo $value1['language']; ?>"
                                src="<?php echo $url_vtt . $value1['url']?>" default />
                            <?php
                                }
                              }?>
                        </video>
                    </div>
                    <!-- end player -->
                  </div>
                </div>
                <!-- News Grid -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('inc.v2.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" defer></script>
    <script type="text/javascript" src="<?php echo url('/');?>/public/js/customer/plyr.js"></script>
  </body>

</html>
