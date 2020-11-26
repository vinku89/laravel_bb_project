<?php
$series_title = '';$series_description ='';$director='';$imdb_rating ='';$releaseYear =''; $presenter ='';$playlist_url='';$sprite_image = '';$thumbnail_img ='';$poster_image = '';
$seriesInfo = array();$subtitle =array();
if(!empty($webseries)){
        if($webseries['webseries_info'] != ""){
            $seriesInfo = $webseries['webseries_info']['webseries_detail'];
            $totalEpisodes = $webseries['webseries_info']["total_episodes"];
            $series_title = $seriesInfo['title'];
            $series_slug = $seriesInfo['slug'];
            $series_description = $seriesInfo["description"];
            if(!empty($webseries["related"]["data"])){
                $related_data = $webseries["related"]["data"][0];
                $season_title = $related_data['season_name'];
                $director =  $related_data["director"];
                $imdb_rating =  $related_data["imdb_rating"];
                $releaseYear =  $related_data["releaseYear"];
                $presenter =  $related_data["presenter"];
            }

            $thumbnail_img = (!empty($seriesInfo["thumbnail_image"])) ? $seriesInfo["thumbnail_image"] : url('/')."/public/vplayed/images/default-thumbnail.png";
            $poster_image = (!empty($seriesInfo["poster_image"])) ? $seriesInfo["poster_image"] : "";
        }
        $previous_page = url('/').'/webseriesList';
}
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBOX - Webseries Details List</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">
    <!-- select2 -->
    <!-- <link href="<?php echo url('/');?>/public/css/customer/select2.min.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/select2-bootstrap.css" rel="stylesheet"> -->
    <!-- All old styles include -->
    @include('customer.inc.v2.all-styles2')

    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vdplay.css">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vod.css">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/player.css">
    <script src="<?php echo url('/');?>/public/vplayed/js/play.js"></script>
    <!-- select2 -->
    <link href="<?php echo url('/');?>/public/css/customer/select2.min.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/select2-bootstrap.css" rel="stylesheet">

    <!-- <link href="<?php echo url('/');?>/public/css/customer/carousel_wv.css?q=<?php echo rand();?>" rel="stylesheet"> -->
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
        .webseries_list{
            list-style: none;
        }

        .select2-search__field::placeholder{
            display: none !important;
        }

        .select2-container--bootstrap .select2-selection--single .select2-selection__rendered{
            font-size: 20px;
            font-weight: 600;
        }
        .select2-container--bootstrap .select2-results__option{
            font-size: 20px;
            font-weight: 600;
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
                                <a href="<?php echo url('/').'/webseriesList';?>" class="vod-back-btn" style="text-decoration: none"><i class="fas fa-arrow-left mr-1"></i> back</a>
                            </div>
                        </div>

                        <div class="col-12 col-xl-4 bg-new-dark-xl mb-3 md-xl-0">
                            <!-- VOD Banner Section Here web series details234 -->
                            <?php
                                if(!empty($webseries)){?>
                                <div class="info_wrapper p-0 mt-4 mt-xl-0">
                                    <div class="movie_info f16">

                                        <h1 class="semi-bold f24"><?php echo $series_title; ?></h1>
                                        <div class="mb-3">
                                            <span class="f18"><?php echo $totalEpisodes; ?></span>
                                            <span class="f16">Episode<?php echo ($totalEpisodes>1) ? 's': '';?></span>
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
                                    <div class="row my-3">
                                        <div class="col-lg-9 my-3">
                                            <div class="filter_wrap_select_country">
                                                        <select class="form-control filter_wrap_select_country_now season_filter new_select f20 semi-bold" name="season" data-tabindex="1">
                                                    <?php
                                                        if(!empty($webseries['seasons'])){
                                                            foreach ($webseries['seasons'] as $season) {
                                                            $s1 = $season['title']. ' ('.$season['season_count'];
                                                            $ep = ($season['season_count']>1) ? 'Episodes': 'Episode';
                                                            $name = trim($s1).trim($ep).')';?>
                                                    <option value="<?php echo trim($season['id']); ?>"
                                                        <?php if($season['id'] == $season_id) echo 'selected';?>>
                                                        <?php echo trim($name);?>
                                                    </option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <!-- VOD Player Section Here -->
                            <!-- END VOD Banner Section  -->
                            <?php }
                            else{
                                echo '<div class="no-record-wrp1">
                                    <div class="no-record-wrp2">
                                        <h1>Oops... Something went wrong</h2>
                                    </div>
                                </div>';
                            }?>
                        </div>

                        <div class="col-12 col-xl-8">
                            <div class="">
                                <?php
                                if(!empty($webseries["related"])){
                                $series_related = $webseries["related"];
                                $current_page = $series_related["current_page"];
                                if(!empty($series_related["data"])){?>
                                <ul class="m-auto p-0 row detail-wra webseries_list" >
                                    <?php
                                    foreach($series_related["data"] as $res){
                                        $title = $res["title"];
                                        $slug = $res["slug"];
                                        $poster_image = $res["poster_image"];
                                        if(!empty($res["thumbnail_image"])){
                                            $thumbnail_img = $res["thumbnail_image"];
                                        }else{
                                            $thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
                                        }
                                        $episode_order = $res["episode_order"];
                                        $web_description = $res["description"];
                                        $episode_order = $res["episode_order"];
                                    ?>
                                    <li class="text-center col-6 col-md-4 col-lg-4 col-xl-3 mb-3 episodes-list">
                                        <a class="all-ite" href="<?php echo url('/');?>/webseriesEpisodeView/<?php echo $slug;?>">
                                            <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid" />
                                        </a>
                                        <div class="text-white py-2"><?php echo $title;?></div>
                                    </li>
                                    <!-- <div class="mb-5 movie_list_wrap_filter">
                                        <div class="movie_list_wrap_filter_wrap">
                                            <a href="<?php echo url('/');?>/webseriesEpisodeView/<?php echo $slug; ?>"
                                                class="movie_list_wrap_item">
                                                <img src="<?php echo $thumbnail_img; ?>" class="img-fluid">
                                            </a>
                                            <div class="movie_list_wrap_item_title_wrap w-100">
                                                <div class="text-center movie_list_wrap_item_title mt-0">
                                                    <?php echo $title;?></div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <?php
                                        }?>
                                </ul>
                                <?php }else{
                                echo '<div class="no-record-wrp1">
                                        <div class="no-record-wrp2">
                                            <h1>No Episodes Found</h2>
                                        </div>
                                    </div>';
                                }
                                }?>
                            </div>
                        </div>

                        <!-- <section class="vod_main_body_section scroll_div col-12">

                        </section> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('inc.v2.footer2')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" ></script>
    <script src="<?php echo url('/');?>/public/vplayed/js/jquery.ddslick.min.js"></script>
    <script src="<?php echo url('/');?>/public/vplayed/js/dropkick.js" type=""></script>


    <script type="text/javascript">
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {
            $('.filter_wrap_select_country_now').select2();
        });

        url = "<?php echo url('/webseriesDetailsList').'/'.$video_slug; ?>";
        $(".season_filter").on('change', function (e) {
            e.preventDefault();
            var season_id = $(this).val();
            location.href = url + '/' + season_id;
        });
        var ph = $(".select2-search__field").attr('placeholder');
        console.log(ph);


    </script>
</body>

</html>
