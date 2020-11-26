<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
        <title>BestBox - VOD Category</title>
        <!-- Styles -->
        <link href="<?php echo url('/');?>/public/css/customer/app.css?q=<?php echo rand();?>" rel="stylesheet">
        <link href="<?php echo url('/');?>/public/css/customer/bsnav.css?q=<?php echo rand();?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vdplay.css?q=<?php echo rand();?>">
        <!-- select2 -->
        <link href="<?php echo url('/');?>/public/css/customer/select2.min.css" rel="stylesheet">
        <link href="<?php echo url('/');?>/public/css/customer/select2-bootstrap.css" rel="stylesheet">
        <link href="<?php echo url('/');?>/public/css/customer/carousel_wv.css?q=<?php echo rand();?>" rel="stylesheet">
        <!-- <link href="<?php echo url('/');?>/public/css/customer/carousel.css?q=<?php echo rand();?>" rel="stylesheet"> -->
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
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
            .section_div{
                min-height: 85vh;
            }
        </style>
        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->
    </head>
    <body>
        @include('inc.v2.sidenav')
        @include('inc.v2.loader')
        <div class="main-wrap w-100">
            <div class="container-fluid">
                @include('inc.v2.headernav')
                <div class="row">
                <?php if($maintanance_mode['is_vod_maintanance_flag']){?>
                    <div class="section_div col-12 mb-0">
                        <img src="<?php echo url('/');?>/public/images/maintanance_mode.JPG" class="img-fluid">
                    </div>
                <?php }else{?>
                    <div class="section_div col-12">
                        <!-- border -->
                        <hr class="grey-dark">
                        <!-- Filter -->
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="input-group my-2">
                                    <input type="text"
                                        class="form-control bg-transparent no-border-right text-white border-rounded-left"
                                        id="searchKey" value="<?php echo (isset($searchKey)) ? $searchKey : ""; ?>"
                                        placeholder="Search Movies" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent no-border-left border-rounded-right search_btn"
                                            id="basic-addon2"><img src="<?php echo url('/');?>/public/img/customer/search.png"
                                                class="img-fluid"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 align-self-center my-2">
                                <select class="form-control category_filter new_select" id="select2-single-box" name="select2-single-box"
                                    data-placeholder="Category(All)" data-tabindex="1">
                                    <option value="all" attr-type="all">Category(All)</option>
                                    <option value="new" attr-type="new" <?php if($category == "new") echo 'selected';?> attr-type="new">New Movies</option>
                                    <option value="popular" attr-type="popular" <?php if($category == "popular") echo 'selected';?>  attr-type="popular">Popular Movies</option>
                                    <?php
                                        if(!empty($vod_categories)){
                                            foreach ($vod_categories as $k => $res) {
                                                $cat_title = $res['title'];
                                                $cat_slug = $res['slug'];
                                                if($cat_title != "Web Series"){?>
                                                <option value="<?php echo $cat_slug; ?>" attr-type="<?php echo $res['type']; ?>"
                                        <?php if($category == $cat_slug) echo 'selected';?>><?php echo $cat_title;?></option>
                                        <?php   }
                                            }
                                        }?>
                                </select>
                            </div>
                        </div>
                        <!--filters end-->
                        <?php
                        if(!empty($vod_cat)){
                        $total_records = $vod_cat["more_category_videos"]["video_list"]['total'];
                        $totalCount = @count($vod_cat["more_category_videos"]["video_list"]["data"]);
                        $page = $vod_cat["more_category_videos"]["video_list"]['current_page'];
                        $perpage = $vod_cat["more_category_videos"]["video_list"]['to'];
                        $records = $perpage*$page;
                        if($totalCount >0){
                            $pageno = $page+1;
                        }else{
                            $page_no = $page-1;
                            $pageno = ($page_no == 0) ? 1 : $page_no;
                        }
                        $cj = 1;
                        if(!empty($vod_cat["more_category_videos"])){
                            //$category_name = $res2->title;
                            ?>
                        <!-- row title with line -->
                        <div class="position-relative">
                            <hr class="grey-dark with-title">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row-title d-inline-block pr-4">
                                        <?php //echo $category_name; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if(!empty($vod_cat["more_category_videos"]["video_list"]["data"]) && @count($vod_cat["more_category_videos"]["video_list"]["data"])){ $i=0;?>
                        <div class="my-4">
                            <ul class="cards-portrait-wrapper cards-portrait-wrapper--mobile d-flex flex-wrap justify-content-start px-1 vodmore_list2" >
                                <?php foreach($vod_cat["more_category_videos"]["video_list"]["data"] as $item2) {
                                                $title = $item2["title"];
                                                $slug = $item2["slug"];

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
                                <li class="cards cards-portrait cards-portrait--grid cards-portrait--grid-large vod-grid">
                                    <a class="all-ite d-block" href="<?php echo url('/');?>/vodDetailView/<?php echo $slug;?>">
                                        <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid" />
                                    </a>
                                    <div class="text-white vodcat-title f12 pt-1"><?php echo $title;?></div>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                        <?php }else{?>
                        <div class="row" style="height: 40vh;">
                            <div class="col text-center align-self-center ">
                                <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                            </div>
                        </div>
                        <?php }
                        $cj++;
                        }else{?>
                        <div class="row" style="height: 40vh;">
                            <div class="col text-center align-self-center ">
                                <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                            </div>
                        </div>
                        <?php }
                            // ends-->
                        }?>
                        <!--show more -->
                        <div class="divider mt50 mb-5 <?php echo ($records < $total_records) ? '': 'd-none';?>" id="show-more-div">
                            <div class="more_movies center_align text-center">
                                <a href='javascript:void(0);' class="show-more btn btn-primary">Show more</a>
                            </div>
                        </div>
                        <input type="hidden" id="type" value="<?php echo $type;?>">
                        <input type="hidden" id="page" value="<?php echo $pageno;?>">
                        <input type="hidden" id="category" value="<?php echo $category;?>">
                        <!--show more -->
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
                                                    <a href="<?php echo url('/');?>/vodCategory?type=category&category=<?php echo $category;?>" class="modalFooter_btn modalFooter_btn_cancel"
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
                    </div>
                <?php }?>
                </div>
            </div>
        </div>
        @include('inc.v2.footer2')
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" defer></script> -->
        <!-- <script src="<?php echo url('/');?>/public/vplayed/js/jquery.ddslick.min.js"></script>
        <script src="<?php echo url('/');?>/public/vplayed/js/dropkick.js" type=""></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" defer></script>
        <script type="text/javascript">
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function () {
                $('.filter_wrap_select_country_now').select2();
                $('.filter_wrap_select_category_now').select2();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                // Load more data
                var type = "<?php echo $type;?>";
                $('.show-more').click(function () {
                    var page = Number($('#page').val());
                    var category = $('#category').val();
                    var type = $('#type').val();
                    var csrf_Value = "<?php echo csrf_token(); ?>";
                    $.ajax({
                        url: "<?php echo url('/');?>/vodCategoryShowmoreAjax",
                        method: 'POST',
                        dataType: "json",
                        data: {
                            'page': page,
                            'type': type,
                            'category': category,
                            "_token": csrf_Value
                        },
                        beforeSend: function () {
                            $(".show-more").text("Loading...");
                            $(".sk-circle").show();
                            $("#show-more-div").children().prop('disabled', true);
                        },
                        success: function (response) {
                            setTimeout(function () {
                                $('.show-more').text("Show more");
                                if (response.status == 'Success') {
                                    // appending posts after last post with class="post"
                                    $(".vodmore_list2").append(response.result).show().fadeIn("slow");
                                    if (response.class == 'd-none') {
                                        $('#show-more-div').hide();
                                    }
                                    $('#page').val(response.page);
                                    $(".sk-circle").hide();
                                } else {
                                    $(".vodmore_list2").append(response.result).show().fadeIn("slow");
                                    $('#page').val(response.page);
                                    $('#show-more-div').hide();
                                    $(".sk-circle").hide();
                                }
                            }, 1000);
                        }
                    });
                });
                var url = "<?php echo url('/vodCategory');?>";
                var url2 = "<?php echo url('/vod');?>";
                //search
                $('#searchKey').keypress(function (ev) {
                    if (ev.which === 13)
                        $('.search_btn').click();
                });
            $(".search_btn").click(function (e) {
                e.preventDefault();
                var searchKey = $("#searchKey").val();
                var category = '<?php echo $category;?>';
                var type = '<?php echo $type;?>';
                if(category == ''){
                    var searchUrl = url2 + '?page=1&category=' + category + '&search=' +searchKey;
                    }else{
                        var searchUrl = url + '?page=1&type='+type+'&category=' + category + '&search=' +searchKey;
                    }

                    location.href = searchUrl;
                });

            });
            $(".category_filter").on('change', function (e) {
                e.preventDefault();
                jQuery.noConflict();
                var category = $(this).val();
                var type = $(".category_filter option:selected").attr("attr-type");
                if (category == 'restricted') {
                    $('#basicModal').modal({
                        "show":true,backdrop: 'static', keyboard: false
                    });
                    return false;
                }
                if (category == "") {
                    location.href = '<?php echo url('/');?>/vod';
                } else if(category == 'all') {
                    location.href = '<?php echo url('/');?>/vod';
                }else {
                    location.href = '<?php echo url('/');?>/vodCategory?type='+type+'&category=' + category;
                }
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".set > a").on("click", function () {
                    if ($(this).hasClass("active")) {
                        $(this).removeClass("active");
                        $(this)
                            .siblings(".content")
                            .slideUp(200);
                        $(".set > a i")
                            .removeClass("fa-angle-up")
                            .addClass("fa-angle-down");
                    } else {
                        $(".set > a i")
                            .removeClass("fa-angle-up")
                            .addClass("fa-angle-down");
                        $(this)
                            .find("i")
                            .removeClass("fa-angle-down")
                            .addClass("fa-angle-up");
                        $(".set > a").removeClass("active");
                        $(this).addClass("active");
                        $(".content").slideUp(200);
                        $(this)
                            .siblings(".content")
                            .slideDown(200);
                    }
                });
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
