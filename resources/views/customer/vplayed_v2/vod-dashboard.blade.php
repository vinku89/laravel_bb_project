<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBOX - VOD Dashboard</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css?q=<?php echo rand();?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vdplay.css?q=<?php echo rand();?>">
    <!-- select2 -->
    <link href="<?php echo url('/');?>/public/css/customer/select2.min.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/select2-bootstrap.css" rel="stylesheet">

    <link href="<?php echo url('/');?>/public/css/customer/carousel_wv.css?q=<?php echo rand();?>" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.carousel.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/customer/owlcarousel/owl.theme.default.css?q=<?php echo rand();?>">
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
        @include('inc.v2.loader')
        <div class="main-wrap">
            <div class="container-fluid">
                @include('inc.v2.headernav')
                <div class="row">
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
                                    placeholder="Search Movies" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2" autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent no-border-left border-rounded-right search_btn" id="basic-addon2">
                                        <img src="<?php echo url('/');?>/public/img/customer/search.png" class="img-fluid">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 align-self-center my-2">
                            <select class="form-control category_filter new_select" id="select2-single-box" name="select2-single-box"
                                data-placeholder="Category(All)" data-tabindex="1">
                                <?php $selectedCategory = ($filterCatName) ? $filterCatName : "";?>
                                <option value="all" attr-type="all">Category(All)</option>
                                <option value="new" <?php if($selectedCategory == "new") echo 'selected';?> attr-type="new">New Movies</option>
                                <option value="popular" <?php if($selectedCategory == "popular") echo 'selected';?> attr-type="popular">Popular Movies</option>
                                <?php
                                    if(!empty($vod_categories)){

                                        foreach ($vod_categories as $k => $res) {
                                            $cat_title = $res['title'];
                                            $cat_slug = $res['slug'];
                                            if($cat_title != "Web Series"){?>
                                            <option value="<?php echo $cat_slug; ?>" <?php if($cat_slug == $selectedCategory) echo 'selected';?> attr-type="category"><?php echo $cat_title;?></option>
                                    <?php   }
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>

                    <!-- search movies -->
                    <?php
                    if(!empty($searchKey) )  {
                    $cj=1;

                    if(!empty($vod_search) && @count($res4["video_list"]["data"] >0)){
                        foreach($vod_search['all'] as $res4){
                        $totalCount_movies = @count($res4["video_list"]["data"]);
                        //if($totalCount_movies == 0) {continue;}?>
                    <!-- row title with line -->
                    <div class="position-relative">
                        <hr class="grey-dark with-title">
                        <div class="row">
                            <div class="col-6">
                                <div class="row-title d-inline-block pr-4">
                                    Search key : <?php echo $searchKey; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if(!empty($res4["video_list"]["data"]) && @count($res4["video_list"]["data"])){ $i=0;?>
                    <div class="my-4">
                        <ul class="owl-carousel carousel-main p-0 m-auto">
                            <?php foreach($res4["video_list"]["data"] as $item3) {
                                $title = $item3["title"];
                                $slug = $item3["slug"];
                                //if($i == 16) continue;
                                if(!empty($item3["thumbnail_image"])){
                                    $substring = 'https://';
                                    $thumbnail_img = $item3["thumbnail_image"];
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
                                    $thumbnail_img = url('/')."/public/vplayed/images/vod_thumbnail.png";
                                }
                            ?>
                            <li class="text-center d-inline-block ">
                                <a class="carousel-tile" href="<?php echo url('/');?>/vodDetailView/<?php echo $slug;?>">
                                    <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                </a>
                                <div class="text-white py-1"><?php echo $title;?></div>
                            </li>
                            <?php $i++;}?>
                        </ul>
                    </div>
                    <?php }else{?>
                    <div class="row" style="height: 40vh;">
                        <div class="col text-center align-self-center ">
                            <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                        </div>
                    </div>
                    <?php }
                    $cj++;}
                    }else{?>
                    <div class="row" style="height: 40vh;">
                        <div class="col text-center align-self-center ">
                            <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                        </div>
                    </div>
                    <?php }

                    }else{
                    // New movies starts-->

                    $cj=1;
                    if(!empty($vod_latest_popular_category)){
                        foreach($vod_latest_popular_category as $res){
                            $totalCount_movies = @count($res["video_list"]["data"]);
                            $category_name = $res["title"];
                            $category_slug = $res["id"];
                            $type= $res["type"];  ?>
                    <!-- row title with line -->
                    <div class="position-relative">
                        <hr class="grey-dark with-title">
                        <div class="row">
                            <div class="col-6">
                                <div class="row-title d-inline-block pr-4">
                                    <?php echo $category_name; ?>
                                </div>
                            </div>
                            <?php
                                $viewmore_url = url('/').'/vodCategory?type='.$type.'&category='.$type;
                            ?>
                            <div class="col-6 text-right">
                                <div class="row-btn d-inline-block pl-4">
                                    <a href="<?php echo $viewmore_url;?>" type="button"
                                        class="btn btn-outline-secondary text-white border-rounded-full veewmore px-4">View more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if(!empty($res["video_list"]["data"])){ $i=0;?>
                    <div class="my-4">
                        <ul class="owl-carousel carousel-main p-0 m-auto">
                            <?php foreach($res["video_list"]["data"] as $item) {
                                if($item["video_category_name"] == 'Restricted'){
                                    continue;
                                }
                                $title = $item["title"];
                                $slug = $item["slug"];
                                if($i == 16) continue;
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
                                    $thumbnail_img = url('/')."/public/vplayed/images/vod-thumbnail.png";
                                }
                            ?>
                            <li class="text-center d-inline-block">
                                <a class="carousel-tile" href="<?php echo url('/');?>/vodDetailView/<?php echo $slug;?>">
                                    <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                </a>
                                <div class="text-white py-1"><?php echo $title;?></div>
                            </li>
                            <?php $i++;}?>
                        </ul>
                    </div>

                    <?php }
                    $cj++;}
                    }else{?>
                    <div class="row" style="height: 40vh;">
                        <div class="col text-center align-self-center ">
                            <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                        </div>
                    </div>
                    <?php }?>
                    <!-- New movies ends-->
                    <!-- category wise starts-->
                    <?php
                    if(!empty($vod_category_wise['category_videos'])){
                        foreach($vod_category_wise['category_videos'] as $res2){
                            $totalCount_movies = @count($res2["video_list"]["data"]);
                            if($res2["title"] == 'Restricted' || $totalCount_movies == 0) {continue;}
                            $category_name = $res2["title"];
                            $category_slug = $res2["slug"];
                            $type= 'category';  ?>
                    <!-- row title with line -->
                    <div class="position-relative">
                        <hr class="grey-dark with-title">
                        <div class="row">
                            <div class="col-6">
                                <div class="row-title d-inline-block pr-4">
                                    <?php echo $category_name; ?>
                                </div>
                            </div>
                            <?php
                                $viewmore_url = url('/').'/vodCategory?type='.$type.'&category='.$category_slug;
                            ?>
                            <div class="col-6 text-right">
                                <div class="row-btn d-inline-block pl-4">
                                    <a href="<?php echo $viewmore_url;?>" type="button"
                                        class="btn btn-outline-secondary text-white border-rounded-full px-4 veewmore">View more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if(!empty($res2["video_list"]["data"])){ $i=0;?>
                    <div class="my-4">
                        <ul class="owl-carousel carousel-main p-0 m-auto">
                            <?php foreach($res2["video_list"]["data"] as $item2) {
                                $title = $item2["title"];
                                $slug = $item2["slug"];
                                if($i == 16) continue;
                                if(!empty($item2["thumbnail_image"])){
                                    $substring = 'https://';
                                    $thumbnail_img = $item2["thumbnail_image"];
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
                                    $thumbnail_img = url('/')."/public/vplayed/images/vod-thumbnail.png";
                                }
                            ?>
                            <li class="text-center d-inline-block fixed-wid">
                                <a class="carousel-tile" href="<?php echo url('/');?>/vodDetailView/<?php echo $slug;?>">
                                    <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                </a>
                                <div class="text-white py-1"><?php echo $title;?></div>
                            </li>
                            <?php $i++;}?>
                        </ul>
                    </div>

                    <?php }
                    $cj++;}
                    }else{?>
                        <!-- <div class="row"  style="height: 40vh;">
                            <div class="col text-center align-self-center ">
                                <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                            </div>
                        </div> -->
                    <?php }?>
                    <!-- category wise ends-->
                    <!-- genre wise starts -->
                    <?php
                    if(!empty($vod_category_wise['genre_videos'])){
                        foreach($vod_category_wise['genre_videos'] as $res3){
                            $totalCount_movies = @count($res3["video_list"]["data"]);
                            if($totalCount_movies == 0) {continue;}
                            $category_name = $res3["title"];
                            $category_slug = $res3["slug"];
                            $type= 'genre';  ?>
                    <!-- row title with line -->
                    <div class="position-relative">
                        <hr class="grey-dark with-title">
                        <div class="row">
                            <div class="col-6">
                                <div class="row-title d-inline-block pr-4">
                                    <?php echo $category_name; ?>
                                </div>
                            </div>
                            <?php
                                $viewmore_url = url('/').'/vodCategory?type='.$type.'&category='.$category_slug;
                            ?>
                            <div class="col-6 text-right">
                                <div class="row-btn d-inline-block pl-4">
                                    <a href="<?php echo $viewmore_url;?>" type="button"
                                        class="btn btn-outline-secondary text-white border-rounded-full px-4">View more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if(!empty($res3["video_list"]["data"])){ $i=0;?>
                    <div class="my-4">
                        <ul class="owl-carousel carousel-main p-0 m-auto">
                            <?php foreach($res3["video_list"]["data"] as $item3) {
                                $title = $item3["title"];
                                $slug = $item3["slug"];
                                if($i == 16) continue;
                                if(!empty($item3["thumbnail_image"])){
                                    $substring = 'https://';
                                    $thumbnail_img = $item3["thumbnail_image"];
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
                                    $thumbnail_img = url('/')."/public/vplayed/images/vod-thumbnail.png";
                                }
                            ?>
                            <li class="text-center d-inline-block">
                                <a class="carousel-tile" href="<?php echo url('/');?>/vodDetailView/<?php echo $slug;?>">
                                    <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                </a>
                                <div class="text-white"><?php echo $title;?></div>
                            </li>
                            <?php $i++;}?>
                        </ul>
                    </div>

                    <?php }
                    $cj++;}
                    }
                    else{?>
                        <!-- <div class="row"  style="height: 40vh;">
                            <div class="col text-center align-self-center ">
                                <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                            </div>
                        </div> -->
                    <?php }
                //genre wise ends -->

                    }?>
                </div>


            </div>
        </div>

        <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-none">
                        <div class="text-center w-100">
                            <img src="https://bestbox.net/public/website/assets/images/bestbox_logo_nav.png"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="modal-body">
                        <p class="modalTitle">Enter your password</p>
                        <div class="pl-3 pr-3">
                            <input type="text" name="otp_code" class="form-control otp_code">
                            <div class="f-12 text-red pt-2 otp_msg" style="display: none">Wrong Password</div>
                            <div class="f-12 text-red pt-2 otp_msg_no" style="display: none">Wrong Password</div>
                        </div>

                    </div>
                    <div class="modal-footer border-top-0 p-0 mt-4">
                        <div class="col-12 pl-0 pr-0">
                            <div class="row">
                                <div class="col-6 pr-0">
                                    <a href="<?php echo url('/');?>/vod?type=category&category=<?php echo $filterCatName;?>" class="modalFooter_btn modalFooter_btn_cancel"
                                        >Cancel</a>
                                </div>
                                <div class="col-6 pl-0">
                                    <!--  <a href="" class="modalFooter_btn modalFooter_btn_proceed  check_otp" data-dismiss="modal">Proceed</a> -->

                                    <p style="cursor: pointer"
                                        class="mb-0 modalFooter_btn modalFooter_btn_proceed check_otp">Proceed</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('inc.v2.footer2')
        <script src="<?php echo url('/');?>/public/js/customer/owlcarousel/owl.carousel.min.js"></script>
        <script>

            $('.carousel-main').owlCarousel({
                loop:false,
                margin:20,
                nav:true,
                autoWidth:true,
                dots: false,
            })
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" defer></script>
        <script type="text/javascript">
            var url = "<?php echo url('/vod'); ?>";
            var url2 = "<?php echo url('/vodCategory'); ?>";

            //filter by country
            $(".category_filter").on('change', function (e) {
                e.preventDefault();
                jQuery.noConflict();
                var category = $(this).val();
                var type = $(".category_filter option:selected").attr("attr-type");
                if(type == '') type = 'category';
                if (category == 'restricted') {
                    $('#basicModal').modal({
                        "show":true,backdrop: 'static', keyboard: false
                    });
                    return false;
                }
                if(category == ''){
                    location.href = url + '?page=1&category='+category;
                } else if(category == 'all') {
                    location.href = url + '?page=1';
                }else{
                    location.href = url2 + '?page=1&type='+type+'&category='+category;
                }
            });

            //search
            $('#searchKey').keypress(function (ev) {
                if (ev.which === 13)
                    $('.search_btn').click();
            });

            $(".search_btn").click(function (e) {
                e.preventDefault();
                var searchKey = $("#searchKey").val();
                var searchUrl = url + '?page=1&category=&search=' +searchKey;
                location.href = searchUrl;

            });

            $('.check_otp').click(function () {
                var otp_code = $.trim($('.otp_code').val());
                if (!otp_code) {
                    $('.otp_msg_no').show();
                } else {
                    $('.otp_msg_no').hide();
                    data2 = 'otp_code=' + otp_code;
                    $('.otp_msg').hide();
                    var url = '<?php echo url('/').'/check_otp';?>';
                    $.ajax({
                        type: "GET",
                        url: url,
                        data: {'otp_code' : otp_code },
                        success: function (data) {
                            if (data == 'success') {
                                location.href = '<?php echo url('/');?>/vodCategory?type=category&category=restricted';
                            } else {
                                $('.otp_msg').show();
                            }
                        }
                    });
                }
            });


        </script>
    </body>
</html>
