<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <title>BestBOX - CatchUp List</title>
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css?q=<?php echo rand();?>" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css?q=<?php echo rand();?>" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/customer-style.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/global.css?q=<?php echo rand();?>">
    <link rel="stylesheet" href="<?php echo url('/');?>/public/css/share.css?q=<?php echo rand();?>">
    <!-- Mobile Responsive styles -->
    <link rel="stylesheet" href="<?php echo url('/');?>/public/customer/css/customer_resoponsive.css?q=<?php echo rand();?>">
    
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

    <style>
    .catchup-wrap{
        background-color: #303030;
        padding: 20px;
        height: calc(100vh - 70px);
        width: 100%;
        overflow-y: scroll;
        position: fixed;
        width: 18%;
        top: 66px;
    }

    .catchup-search{
        position: relative;
        background-color: #303030;
        padding-top: 10px;
        top:0px;
        width: 100%;
    }

    .catchup-search .catchupinput::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        font-size: 12px;
    }

    .catchup-search .catchupinput:-ms-input-placeholder { /* Internet Explorer 10-11 */
        font-size: 12px;
    }

    .catchup-search .catchupinput:-ms-input-placeholder { /* Microsoft Edge */
        font-size: 12px;
    }

    .catchup-right{
        padding-left: 20%;
    }

    .catchup-wrap ul{
        padding-top: 0px;
        padding-left: 0;
        list-style: none;
    }

    .catchup-wrap li{
        margin: 10px auto;
        color: #fff;
        display: block;
        padding: 0px 15px;
        border-radius: 20px;
        min-width: 150px;
        cursor: pointer;
    }

    .catchup-wrap li.active{
        background: #A02C72;
    }

    @media (min-width: 991.99px) and (max-width: 1199.99px){
        .catchup-wrap{
            width: 20%;
        }

        .catchup-right{
        padding-left: 24%;
    }
    }

    @media (min-width: 767.99px) and (max-width: 992px){
        .catchup-wrap{
            width: 24%;
        }
        .catchup-right{
            padding-left: 26%;
        }
    }

    @media (max-width: 767.99px){
        
    }    

    @media(max-width: 767.99px){
        .catchup-wrap li{
            display: block;
        }

        .catchup-wrap{
            height: 240px;
            z-index: 999;
            top: 67px;
            width: 93%;
        }

        .catchup-search{
           width: 100%;
        }

        .catchup-right{
            padding-top: 250px;
            padding-left: 0;
        }
    }
    </style>
    <!-- for tracking -->
    

</head>

<body>
    @include('inc.v2.sidenav')
    @include('inc.v2.loader')
    <div class="main-wrap w-100">
        <div class="container-fluid ">
            @include('inc.v2.headernav')
            
            <div class="catchup-wrap">
                <div class="catchup-search">
                    <div class="input-group mb-3">
                    <input type="text" class="form-control catchupinput" placeholder="Search" aria-label="Channel Name" aria-describedby="button-addon2" id="search_channel">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary fa fa-search" type="button" id="button-addon2"></button>
                    </div>
                    </div>
                </div>
                <ul id="channel">
                    <?php 
                    if(!empty($catchupChannelList)) {
                        $channel_active_flag = 1;
                        foreach($catchupChannelList['result'] as $item) {?>
                            <li channel_name="<?php echo $item;?>" class="channel_class <?php echo ($channel_active_flag == 1) ? 'active' : '';?>" ><?php echo $item;?></li>
                        <?php 
                        $channel_active_flag = 0;
                        }
                    }?>
                </ul>
            </div>
            <div class="catchup-right">
                <div class="table_div clearfix">
                    <div class="table_div_head" style="height: 30px; margin-top: 15px;">
                        <div class="font16 purple_txt font-bold w15 table_div_cell">Date</div>
                        <div class="font16 purple_txt font-bold w15 table_div_cell">Time</div>
                        <div class="font16 purple_txt font-bold w60 table_div_cell">Programs</div>
                        <div class="font16 purple_txt font-bold text-md-right w10 table_div_cell">Play</div>
                    </div>
                        
                    <div class="grid_wrp">
                        <div class="grid_body clearfix" id="channel_data">
                            <?php 
                            if(!empty($channelData)) {
                                foreach($channelData['result'] as $key => $channel) {
                                    $url = url('/').'/CatchupView/'.$channel['channel_name'].'/'.$channel['p2p_id'];
                                    ?>
                                    <a href="<?php echo $url;?>">
                                        <div class="grid_row clearfix agent_row new_cell">
                                            <div class="w15 float-left f14 px-2">
                                                <?php echo date('d/m/Y', strtotime($channel['start']));?>
                                            </div>
                                            <div class="w15 float-left f14 px-2">
                                                <?php echo date('h:i A', strtotime($channel['start']));?>
                                            </div>
                                            <div class="w60 float-left px-2 word-break-all">
                                                <h5 class="f16"><?php echo $channel['title'];?></h5>
                                                <div class="f12"><?php echo $channel['description'];?></div>
                                            </div>
                                            <div class="w10 float-left f14 green_txt text-right px-2">
                                                <img src="<?php echo url('/');?>/public/images/play.png" style="width: 30px; height: auto;">
                                            </div>
                                        </div>
                                    </a>
                            <?php }
                            }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     @include('inc.v2.footer2')
    <script>
        $(document).on('click', '#channel li', function(){
        //$("#channel li").click(function(){
            //console.log('hi');
            $("#channel li").removeClass('active');
            $(this).addClass('active');
            var channel_name  = $(this).attr('channel_name');
            var token = "<?php echo csrf_token() ?>";
            
            $.ajax({
                url: "<?php echo url('/');?>/catchupChannelData",
                method: 'POST',
                dataType: "json",
                data: {
                    "channel_name": channel_name,
                    "_token": token
                },
                beforeSend: function () {
                    $(".sk-circle").show();
                },
                success: function (data) {
                    $(".sk-circle").hide();
                    if (data.status == 'Success') {
                        $("#channel_data").html(data.result);
                    }else{
                        $("#channel_data").html('');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        }); 
        $('#search_channel').keyup(function(e){
            
            var channel_name = $("#search_channel").val();
            //console.log('channel'+channel_name);
            var token = "<?php echo csrf_token() ?>";
            $.ajax({
                url: "<?php echo url('/');?>/getAjaxchannelList",
                method: 'POST',
                dataType: "json",
                data: {
                    "channel_name": channel_name,
                    "_token": token
                },
                beforeSend: function () {
                    //$(".sk-circle").show();
                },
                success: function (data) {
                    //$(".sk-circle").hide();
                    if (data.status == 'Success') {
                        $("#channel").html(data.result);
                    }else{
                        $("#channel").html('');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
               
        
    </script>
    
</body>

</html>
