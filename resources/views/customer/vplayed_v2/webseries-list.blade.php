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
                                    <a class="w-100 d-block" href="<?php echo url('/');?>/webseriesDetailsList/<?php echo $slug;?>">
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
    </div>
    @include('inc.v2.footer')
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" defer></script>
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
                            if(response.webSeriesCnt < 15){
                                $('#show-more-div').hide();
                            }else{
                                $('#show-more-div').hide();
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
