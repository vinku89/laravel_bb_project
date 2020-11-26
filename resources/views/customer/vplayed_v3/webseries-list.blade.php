<?php
Session::put('series_redirectURL','webseriesList');
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBOX - Webseries List</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css?q=<?php echo rand();?>" rel="stylesheet">
    <!-- select2 -->
    <link href="<?php echo url('/');?>/public/css/customer/select2.min.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/select2-bootstrap.css" rel="stylesheet">

    <link href="<?php echo url('/');?>/public/css/customer/carousel_wv.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.carousel.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.theme.default.css">
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
        .movie_list_wrap_item_title {
            font-size: 12px !important;
        }
        .movie_list_wrap_it{display:block !important;}
        .showmore{
            display:block;
        }
        .hideShowmore{
            display:none;
        }

        .all-ite img {
            border-radius: 10px;
        }

        .no-view-btn .owl-nav{
            right: 0 !important;
        }

        .watch__list {
            margin-bottom: 80px !important;
        }

        .watchprog{
            height: 170px;
        }
        .watchprog .owl-item{
            width: 300px !important;
        }

        .watchprog .owl-nav{
           background-color:#000 !important;
        }

        .watchprog .carousel-tile{
            width: 300px !important;
            height: 170px !important;
        }

        .progress-container {
            width: 300px;
            height: 7px;
            /* margin-top: -50px; */
            margin: 0px 0px 0;
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

        .ply-btn{
            position: absolute;
            bottom: 20px;
            left: 20px;
            display: inline-block;
        }

        .movietitle_new{
            position: absolute;
            width: 100%;
        }

        .cont_watch_bg{
            background-color: #000;
            height: 330px;
            padding: 19px 0 20px 15px;
            /* margin: 0 auto 30px; */
            margin-bottom: 30px;
        }

    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>

<body>
    @include('inc.v2.sidenav')
    @include('inc.v2.loader')
    <div class="main-wrap">
        <div class="container-fluid">
            @include('inc.v2.headernav')
            <div class="row">
                <?php if($maintanance_mode['is_series_maintanance_flag']){?>
                    <div class="section_div col-12 mb-0">
                        <img src="<?php echo url('/');?>/public/images/maintanance_mode.JPG" class="img-fluid">
                    </div>
                <?php }else{?>
                    <div class="section_div col-12">
                        <!-- border -->
                        <hr class="grey-dark">

                        <!-- Filter -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group my-2">
                                    <input type="text"
                                        class="form-control bg-transparent no-border-right text-white border-rounded-left"
                                        id="searchKey" value="<?php echo (isset($searchKey)) ? $searchKey : ""; ?>"
                                        placeholder="Search Webseries" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent no-border-left border-rounded-right search_btn" id="basic-addon2">
                                            <img src="<?php echo url('/');?>/public/img/customer/search.png" class="img-fluid">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- continue watch series List starts-->
                        <?php
                        $cj=1;
                        if(!empty($continue_watch_list)){
                        foreach($continue_watch_list as $res){
                        $totalCount_series = @count($res["data"]);
                        $category_name = $res["title"];
                        $category_slug = $res["slug"];

                        if($totalCount_series){?>

                        <!-- row title with line -->
                        <div class="cont_watch_bg row">
                            <div class="position-relative col-12">
                                <!-- <hr class="grey-dark with-title"> -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row-title d-inline-block pr-4" style="background-color: #000 !important;">
                                            <?php echo $category_name .' for '.$userInfo['first_name'].' '.$userInfo['last_name']; ?>
                                        </div>
                                    </div>
                                    <?php //$viewmore_url = url('/').'/webseriesList';?>
                                    <!--<div class="col-6 text-right">
                                        <div class="row-btn d-inline-block pl-4">
                                            <a href="<?php //echo $viewmore_url;?>" type="button"
                                                class="btn btn-outline-secondary text-white border-rounded-full veewmore px-4">View more</a>
                                        </div>
                                    </div>-->
                                </div>
                            </div>

                            <div class="position-relative col-12">
                                <?php
                                if(!empty($res["data"]) && @count($res["data"])){ $i=0;?>
                                <div class="position-relative my-4 watch__list col-12">
                                    <ul class="owl-carousel carousel-main p-0 m-auto watchprog no-view-btn">
                                        <?php foreach($res["data"] as $item) {
                                            $title = (!empty($item['episode_title'])) ? $item['episode_title'] : $item["title"];
                                            $title = str_replace('_',' ',$title);
                                            $slug = $item["slug"];
                                            $percentage = $item['percentage'];
                                            if($i == 20) continue;
                                            if(!empty($item["poster_image"])){
                                                $substring = 'https://';
                                                $thumbnail_img = $item["poster_image"];
                                                if(strpos($thumbnail_img, $substring) === false){
                                                    $url = url('/');
                                                    if($url == 'https://bestbox.net' || $url == 'https://bb3778.com/') {
                                                        $urlpath = 'https://prodstore.bb3778.com/bestbox/';
                                                    }else if($url == 'https://staging.bestbox.net' || $url == 'https://staging.bb3778.com/') {
                                                        $urlpath = 'https://stgstore.bb3778.com/bestbox/';
                                                    }else{
                                                        $urlpath = 'https://stgstore.bb3778.com/bestbox/';
                                                    }
                                                $thumbnail_img = $urlpath.$thumbnail_img;
                                                }
                                            }else{
                                                $thumbnail_img = url('/')."/public/vplayed/images/continue_watch_thumbnail.jpeg";
                                            }
                                        ?>
                                        <li class="text-center d-inline-block" style="height: 280px !important">
                                            <a href="<?php echo url('/');?>/webseriesEpisodeView/<?php echo $slug;?>/is_home" class="carousel-tile"  style="border-radius: 7px 7px 0 0 !important;">
                                                <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                                <div class="ply-btn"><img src="<?php echo url('/');?>/public/img/customer/play_btn_new.png" class="img-fluid"></div>
                                            </a>
                                            <div class="text-white py-3 movietitle_new"><?php echo $title;?></div>
                                            <div class="progress-container">
                                                <div class="progress" style="width:<?php echo $percentage.'%';?>"></div>
                                            </div>
                                        </li>
                                        <?php $i++;}?>
                                    </ul>
                                </div>
                                    <?php }
                                    }
                                    $cj++;}
                                    } ?>
                                    <!-- New movies starts-->
                                    <?php
                                    $cj=1;
                                    if(!empty($webseries)){
                                        foreach($webseries as $key => $res){
                                            if($key == 'popular' || $key == 'new') continue;
                                            $episodes_data = $res['episodes'];
                                            $total_records = $res['total'];
                                            $totalCount = @count($res["data"]);
                                            $page = $res['current_page'];
                                            $perpage = $res['to'];
                                            $records = $perpage*$page;
                                            if($totalCount >0){
                                                $pageno = $page+1;
                                            }else{
                                                $page_no = $page-1;
                                                $pageno = ($page_no == 0) ? 1 : $page_no;
                                            }
                                            ?>
                                <!-- row title with line -->
                                <div class="position-relative">
                                    <hr class="grey-dark with-title">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row-title d-inline-block pr-4">
                                                <?php if(!empty($searchKey)){
                                                    echo 'Search key : '.$searchKey;
                                                }else{
                                                    echo $res['category_name'];;
                                                }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <?php
                                    if(!empty($res["data"]) && @count($res['data'])>0){ $i=0;?>
                                    <div class="my-4">
                                        <ul class="cards-portrait-wrapper cards-portrait-wrapper--mobile d-flex flex-wrap justify-content-start px-1 vodmore_list2">
                                            <?php foreach($res["data"] as $item) {
                                                $title = $item["title"];
                                                $slug = $item["slug"];
                                                $episode_count = 0;
                                                if(!empty($episodes_data) && @count($episodes_data)){
                                                    foreach($episodes_data as $eps) {
                                                        if($eps['slug'] == $slug) $episode_count = $eps['episode_count'];
                                                    }
                                                }

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
                                                }
                                            ?>
                                            <li class="cards cards-portrait cards-portrait--grid cards-portrait--grid-large">
                                                <a class="all-ite d-block" href="<?php echo url('/');?>/webseriesDetailsList/<?php echo $slug;?>">
                                                    <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                                </a>
                                                <div class="text-white vodcat-title f12 pt-1"><?php echo $title;?></div>
                                                <div class="text-white vodcat-title f11"><?php echo $episode_count;?> Episode<?php echo ($episode_count>1) ? 's': '';?></div>
                                            </li>
                                            <?php $i++;}?>
                                        </ul>
                                    </div>

                                    <?php } else{?>

                                    <div class="row" style="height: 40vh;">
                                        <div class="col text-center align-self-center ">
                                            <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                                        </div>
                                    </div>
                                    <?php }
                                    $cj++; }
                                    }else{?>
                                    <div class="row" style="height: 40vh;">
                                        <div class="col text-center align-self-center ">
                                            <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="divider mb-5 <?php echo ($records < $total_records) ? '': 'd-none';?>" id="show-more-div">
                                        <div class="more_movies center_align text-center">
                                            <input type="hidden" id="page" value="<?php echo $pageno;?>">
                                            <a href='javascript:void(0);' class="show-more btn btn-primary" >Show more</a>
                                        </div>
                                    </div>
                                    <!-- New movies ends-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    @include('inc.v2.footer')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" defer></script>

     <script src="<?php echo url('/');?>/public/js/customer/owlcarousel/owl.carousel.min.js"></script>
     <script>

         $('.carousel-main').owlCarousel({
             loop:false,
             margin:20,
             nav:true,
             autoWidth:true,
             dots: false,
             singleItem: true,
         })
     </script>
    <script type="text/javascript">
        var url = "<?php echo url('/webseriesList'); ?>";

        //search
        $('#searchKey').keypress(function (ev) {
            if (ev.which === 13)
                $('.search_btn').click();
        });

        $(".search_btn").click(function (e) {
            e.preventDefault();
            var searchKey = $("#searchKey").val().trim();
            location.href = url+'?searchKey='+searchKey;
        });

        </script>
        <script type="text/javascript">

    $(document).ready(function(){
        // Load more data
        $('.show-more').click(function(){
            var page = Number($('#page').val());

            var csrf_Value= "<?php echo csrf_token(); ?>";
            $.ajax({
                url: "<?php echo url('/');?>/webserieslistLoadMore",
                method: 'POST',
                dataType: "json",
                data: {'page': page, "_token": csrf_Value},
                beforeSend:function(){
                    $(".show-more").text("Loading...");
                    $(".sk-circle").show();
                },
                success: function(response){
                    setTimeout(function() {
                        $('.show-more').text("Show more");
                        if(response.status == 'Success'){
                            // appending posts after last post with class="post"
                            $(".vodmore_list2").append(response.result).show().fadeIn("slow");
                            $('#page').val(response.page);
                            $('.sk-circle').hide();
                            if(response.webSeriesCnt < 30){
                                $('#show-more-div').hide();
                            }else{
                                $('#show-more-div').show();
                            }
                        }else{
                            $(".vodmore_list2").append(response.result).show().fadeIn("slow");
                            $('#page').val(response.page);
                            $('#show-more-div').hide();
                            $(".sk-circle").hide();
                        }

                    }, 1000);
                }
            });
        });
    });
    </script>
    <!-- loader -->
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function(){
                $(".sk-circle").hide();
            },3000);
        });
    </script>
</body>

</html>
