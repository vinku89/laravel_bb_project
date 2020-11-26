<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Live tv Dashboard</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />

    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css?q=<?php echo rand();?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vdplay.css?q=<?php echo rand();?>">

    <!-- select2 -->
    <link href="<?php echo url('/');?>/public/css/customer/select2.min.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/select2-bootstrap.css?q=<?php echo rand();?>" rel="stylesheet">

    <link href="<?php echo url('/');?>/public/css/customer/carousel.css?q=<?php echo rand();?>" rel="stylesheet">
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
</head>

<body>
    
    @include('inc.v2.sidenav')
    @include('inc.v2.loader')
    <div class="main-wrap">
        <div class="container-fluid">
            @include('inc.v2.headernav')
            <div class="row">
                <?php if($maintanance_mode['is_livetv_maintanance_flag']){?>
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
                                        placeholder="Search Channel" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent no-border-left border-rounded-right search_btn" id="basic-addon2">
                                            <img src="<?php echo url('/');?>/public/img/customer/search.png" class="img-fluid">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3 align-self-center my-2">

                                <!-- Select Country -->
                                <select class="form-control country_filter new_select" id="select2-single-box" name="select2-single-box"
                                    data-placeholder="Country(All)" data-tabindex="1">
                                    <option value="cntry_all">Country(All)</option>
                                    <?php
                                        if(!empty($livetv_countries)){
                                            foreach ($livetv_countries as $key => $value) {?>
                                                <option
                                                    value="<?php echo $value->country_id . '@' .  $value->country_name; ?>" <?php if($country_id == $value->country_id) echo 'selected';?>><?php echo $value->country_name; ?>(<?php echo $value->counts; ?>)</option>
                                    <?php   }
                                        }
                                        ?>
                                </select>
                                <!-- Country end -->

                            </div>
                            <div class="col-md-4 col-lg-3 align-self-center my-2">
                                <select class="form-control category_filter new_select" id="select2-single-box1" name="select2-single-box"
                                    data-placeholder="Category(All)" data-tabindex="1">
                                    <option value="cat_all">Category(All)</option>
                                    <?php
                                        if(!empty($livetv_categories)){
                                            foreach ($livetv_categories as $k => $val) {?>
                                                <option value="<?php echo $val['id'];?>" <?php if($category == $val['id']) echo 'selected';?>><?php echo $val['title'];?></option>
                                    <?php   }
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <!-- search movies -->
                        <?php
                            if(!empty($searchKey))  {
                                if(!empty($livetv_videos)){
                            $cj=1;
                            foreach($livetv_videos as $livetv){
                                if($country_id == 253 && $searchKey != '') {?>
                                    <!-- row title with line -->
                                    <div class="position-relative">
                                        <hr class="grey-dark with-title">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row-title d-inline-block pr-4">
                                                    <?php echo 'Search Key:'.$searchKey;?>
                                                </div>
                                            </div>
                                            <?php
                                                $viewmore_url = url('/').'/livetvDetails?page=1&country_id='.$country_id.'&category='.$livetv['id'].'&search='.$searchKey;
                                            ?>
                                            <div class="col-6 text-right">
                                                <div class="row-btn d-inline-block pl-4">
                                                    <a href="<?php echo $viewmore_url;?>" type="button"
                                                        class="btn btn-outline-secondary text-white border-rounded-full veewmore px-4">View more</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="height: 40vh;">
                                        <div class="col text-center align-self-center ">
                                            <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                                        </div>
                                    </div>
                                <?php }
                                if($country_id == 253 && $livetv['slug'] == '') continue;
                                if($livetv['slug'] == 'adult-1') {
                                    if($country_id == 253){

                                    } else {
                                        continue;
                                    }
                                }?>
                            <!-- row title with line -->
                            <div class="position-relative">
                                <hr class="grey-dark with-title">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row-title d-inline-block pr-4">
                                            <?php echo 'Search Key:'.$searchKey;?>
                                        </div>
                                    </div>
                                    <?php
                                        $viewmore_url = url('/').'/livetvDetails?page=1&country_id='.$country_id.'&category='.$livetv['id'].'&search='.$searchKey;
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
                            if(!empty($livetv['data']) && @count($livetv['data']))
                            { $i=0;?>
                            <div id="carousel<?php echo $cj;?>" class="my-4">
                                <ul class="owl-carousel carousel-main m-auto p-0">
                                    <?php foreach($livetv['data'] as $item2) {
                                        $title = (!empty($item2['title'])) ? $item2['title'] : '';
                                        $slug = (!empty($item2['slug'])) ? $item2['slug'] : '';
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
                                            $thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
                                        }
                                    ?>
                                    <li class="text-center d-inline-block">
                                        <a class="carousel-tile" href="<?php echo url('/');?>/livetvChannelView/<?php echo $slug;?>">
                                            <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                        </a>
                                        <div class="text-white"><?php echo $title;?></div>
                                    </li>
                                    <?php $i++;}?>
                                </ul>
                            </div>

                            <?php
                            }else{?>
                                <div class="row" style="height: 40vh;">
                                    <div class="col text-center align-self-center ">
                                        <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                                    </div>
                                </div>
                        <?php }
                            $cj++;
                            }
                        } else{
                        ?>
                        <div class="row" style="height: 40vh;">
                            <div class="col text-center align-self-center ">
                                <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                            </div>
                        </div>

                        <?php
                        }
                        }else{

                        if(!empty($livetv_videos)){
                            $cj=1;
                            foreach($livetv_videos as $livetv){
                                if(($country_id == 253 && $livetv['slug'] == '') || $livetv['title'] == 'ALL') continue;
                                if($livetv['slug'] == 'adult-1') {
                                    if($country_id == 253){

                                    } else{
                                        continue;
                                    }
                                }?>

                        <!-- row title with line -->
                        <div class="position-relative">
                            <hr class="grey-dark with-title">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row-title d-inline-block pr-4">
                                        <?php echo $livetv['title'];?>
                                    </div>
                                </div>
                                <?php
                                    $viewmore_url = url('/').'/livetvDetails?page=1&country_id='.$country_id.'&category='.$livetv['id'];
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
                            if(!empty($livetv['data']) && @count($livetv['data']))
                            { $i=0;?>
                            <div id="carousel<?php echo $cj;?>" class="my-4">
                                <ul class="owl-carousel carousel-main m-auto p-0">
                                    <?php foreach($livetv['data'] as $item2) {
                                        $title = (!empty($item2['title'])) ? $item2['title'] : '';
                                        $slug = (!empty($item2['slug'])) ? $item2['slug'] : '';
                                        if($item2['slug'] == 'adult-1') {
                                            continue;
                                        }
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
                                            $thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
                                        }
                                    ?>
                                    <li class="text-center d-inline-block">
                                        <a class="carousel-tile" href="<?php echo url('/');?>/livetvChannelView/<?php echo $item2['slug'];?>">
                                            <img src="<?php echo $thumbnail_img;?>" alt="" class="title img-fluid"/>
                                        </a>
                                        <div class="text-white"><?php echo $title;?></div>
                                    </li>
                                    <?php $i++;}?>
                                </ul>
                            </div>

                            <?php
                            }else{?>
                                <div class="row"  style="height: 40vh;">
                                    <div class="col text-center align-self-center ">
                                        <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                                    </div>
                                </div>
                            <?php }
                            $cj++;
                            }
                        }
                        else{?>
                            <div class="row"  style="height: 40vh;">
                                <div class="col text-center align-self-center ">
                                    <div class="text-white text-center f24 font-bold"><?php echo 'No Records found';?></div>
                                </div>
                            </div>
                        <?php }
                        }?>
                    </div>
                <?php }?>
            </div>
        </div>
        <!--adult modal popup -->
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
                                    <a href="<?php echo url('/').'/livetv?page=1&country_id='.$country_id.'&category='.$category;?>" class="modalFooter_btn modalFooter_btn_cancel"
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
    <input type="hidden" name="new_id" value="" class="new_id">
    <!--adult modal popup ends-->
    @include('inc.v2.footer2')

    <script src="<?php echo url('/');?>/public/js/customer/owlcarousel/owl.carousel.min.js"></script>
    <script>

        $('.carousel-main').owlCarousel({
            loop:false,
            margin:10,
            nav:true,
            autoWidth:true,
            dots: false,
        })
    </script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" defer></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script> -->
    <script type="text/javascript">
        var url = "<?php echo url('/livetv'); ?>";
        var url2 = "<?php echo url('/livetvDetails'); ?>";
        //filter by country
        $(".country_filter").change(function (e) {
            e.preventDefault();
            jQuery.noConflict();
            var country = '';
            var country_id = $(this).val();
            var category = '<?php echo $category;?>';
            if(country_id == 'cntry_all') {
                country ='';
                location.href = url + '?page=1&country_id=' + country+'&category='+category;
            }else{
                var a = country_id.split('@');
                if (a[1] == 'For Adults') {
                    console.log('hi');
                    $('.new_id').val(a[0]);
                    $('#basicModal').modal({"show":true,backdrop: 'static', keyboard: false});
                    return false;
                }
                if(country_id != ''){
                    var country = a[0];
                }

                location.href = url + '?page=1&country_id=' + country+'&category='+category;
            }
        });

        //filter by country
        $(".category_filter").change(function (e) {
            e.preventDefault();
            var category = $(this).val();
            var country = '<?php echo $country_id;?>';
            console.log(category);
            if(category == '' || category == 'cat_all'){
                category = '';
                location.href = url + '?page=1&country_id='+country+'&category=';
            }else if(category == 'cat_all'){
                location.href = url + '?page=1&country_id='+country+'&category=';
            }else{
                location.href = url2 + '?page=1&country_id='+country+'&category='+category;
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
            var country_id = '<?php echo $country_id;?>';
            var category = '<?php echo $category;?>';

            var searchUrl = url + '?page=1&country_id=' + country_id + '&category=' + category + '&search='+searchKey;
            location.href = searchUrl;

        });

        //$.fn.modal.Constructor.prototype.enforceFocus = function() {};

        //adult popup

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
                            //var url = "<?php echo url('/vodlist'); ?>";
                            var url = "<?php echo url('/livetv'); ?>";
                            var a = $('.new_id').val();
                            location.href = url + '?page=1&country_id=' + a;
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
