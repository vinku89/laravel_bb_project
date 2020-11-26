<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Application Settings</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style type="text/css">
        .org-txt {
            color: #FA6400;
        }
    </style>

</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content">
        <!-- Header Section Start Here -->
        @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <i class="fas fa-angle-left"></i>
                    <li class="breadcrumb-item f16"><a href="{{ url('/').'/customers' }}" class="f16">Customers</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Add New Customer</li>
                </ol>
            </nav> -->
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left">Application Settings</h5>

            <!-- <div class="pending_renewal_wrp">

            </div> -->

            <div class="blue_bg p-3 mb-3">
                <h5 class="f22 font-bold text-uppercase black_txt py-2 text-center text-sm-left">Proxy Settings</h5>
                <form class="py-2" action="/save_proxy_settings" method="post" id="save_proxy_settings">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group app-set row px-3">
                        <span class="px-lg-3 col-lg-3 col-xl-2"><label for="client_code" class="col-form-label">Client Code</label></span>
                        <div class="col-lg-4 col-sm-4 col-12 px-lg-3">
                            <input type="text" name="client_code"  required class="form-control" id="client_code" placeholder="" value="<?php if(!empty($proxySettings['client_id'])){ echo $proxySettings['client_id'];} ?>">
                        </div>
                    </div>

                    <div class="my-4 app-set">
                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-lg-3">
                                <label for="proxy_line_streaming">Proxy Line Streaming Link</label>
                                <input type="text" name="proxy_line_streaming" class="form-control" id="proxy_line_streaming" placeholder="" value="<?php if(!empty($proxySettings['proxy_streaming'])){ echo $proxySettings['proxy_streaming'];} ?>" required>
                            </div>
                            <div class="col-md-6 mb-3 px-lg-3">
                                <label for="proxy_vod">Proxy VOD Link</label>
                                <input type="text" name="proxy_vod" class="form-control" id="proxy_vod" placeholder="" value="<?php if(!empty($proxySettings['proxy_vod'])){ echo $proxySettings['proxy_vod'];} ?>" required>
                            </div>
                            <div class="col-md-6 mb-3 px-lg-3">
                                <label for="proxy_catchup">Proxy Catch Up Link</label>
                                <input type="text" name="proxy_catchup" class="form-control" id="proxy_catchup" placeholder="" value="<?php if(!empty($proxySettings['proxy_catchup'])){ echo $proxySettings['proxy_catchup'];} ?>" required>
                            </div>
                            <div class="col-md-6 mb-3 px-lg-3">
                                <label for="live_streaming">Live Stream Link</label>
                                <input type="text" name="live_streaming" class="form-control" id="live_streaming" placeholder="" value="<?php if(!empty($proxySettings['iptv_live'])){ echo $proxySettings['iptv_live'];} ?>" required>
                            </div>
                            <div class="col-md-6 mb-3 px-lg-3">
                                <label for="vod_link">Vod Link</label>
                                <input type="text" name="vod_link" class="form-control" id="vod_link" placeholder="" value="<?php if(!empty($proxySettings['iptv_vod'])){ echo $proxySettings['iptv_vod'];} ?>" required>
                            </div>
                            <div class="col-md-6 mb-3 px-lg-3">
                                <label for="catchup_link">Catch Up Link</label>
                                <input type="text" name="catchup_link" class="form-control" id="catchup_link" placeholder="" value="<?php if(!empty($proxySettings['iptv_catchup'])){ echo $proxySettings['iptv_catchup'];} ?>" required>
                            </div>
                            <div class="col-md-6 mb-3 px-lg-3">
                                <label for="player_link">Player Link</label>
                                <input type="text" name="player_link" class="form-control" id="player_link" placeholder="" value="<?php if(!empty($proxySettings['iptv_player'])){ echo $proxySettings['iptv_player'];} ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="my-4 px-lg-3">
                        <button type="button" id="save_update_proxy" class="btn btn-blue">SAVE / UPDATE</button>
                    </div>
                </form>
            </div>


            <div class="blue_bg p-3 mb-3">
                <h5 class="f22 font-bold text-uppercase black_txt py-2 text-center text-sm-left">Trial & Earning Notifications</h5>
                <form class="py-2" method="post" id="trail_earning_form">
                    <div class="my-4 app-set">
                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <div>
                                    Trial Account Duration
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3 text-center">
                                <div class="form-group app-set row px-3">

                                    <div class="col-lg-6 col-sm-6 col-12 px-lg-3">
                                        <input type="text" name="trail_duration" class="form-control" id="trail_duration" placeholder="" value="<?php if(!empty($trail_earnings['trail_duration'])){ echo $trail_earnings['trail_duration']; } ?>">
                                    </div>
                                    <span class="px-lg-6 col-lg-6 col-xl-2"><label for="inputEmail3" class="col-form-label">Hours</label></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>Activated duration is for 24 hours free trial access </p>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    Daily Earning Notification
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="daily_earning" class="btn btn-sm btn-toggle btn-switch <?php if(!empty($trail_earnings['dailyearning'])){ echo 'active'; } ?>" data-toggle="button" aria-pressed="false" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>Announce for daily earnings notification.</p>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    Monthly Earning Notification
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="monthly_earning" class="btn btn-sm btn-toggle btn-switch <?php if(!empty($trail_earnings['monthlyearning'])){ echo 'active'; } ?>" data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>Announce for monthly earnings notification.</p>
                            </div>
                        </div>

                    </div>

                    <div class="my-4 px-lg-3">
                        <button type="button" class="btn btn-blue" id="trail_earning_save_btn">SAVE / UPDATE</button>
                    </div>
                </form>
            </div>

            <div class="blue_bg p-3 mb-3">
                <h5 class="f22 font-bold text-uppercase black_txt py-2 text-center text-sm-left">CONTENT UPDATE</h5>
                <form class="py-2" method="post" id="trail_earning_form">
                    <div class="my-4 app-set">
                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    VOD/Movies
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="is_vod_update_flag" class="btn btn-sm btn-toggle btn-switch" data-toggle="button" aria-pressed="false" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>VOD/Movies API refresh alert to Web & Mobile.</p>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    Live TV
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="is_livetv_update_flag" class="btn btn-sm btn-toggle btn-switch " data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>Live TV API refresh alert to Web & Mobile.</p>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    Series
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="is_series_update_flag" class="btn btn-sm btn-toggle btn-switch" data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>Series  API refresh alert to Web & Mobile.</p>
                            </div>
                        </div>

                    </div>

                    <div class="my-4 px-lg-3">
                        <button type="button" class="btn btn-blue" id="vplayedUpdate_save_btn">SAVE / UPDATE</button>
                    </div>
                </form>
            </div>

            <div class="blue_bg p-3 mb-3">
                <h5 class="f22 font-bold text-uppercase black_txt py-2 text-center text-sm-left">Maintanance Mode (Web/Mobile)</h5>
                <form class="py-2" method="post" id="trail_earning_form">
                    <div class="my-4 app-set">
                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    VOD/Movies
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="is_vod_maintanance_flag" class="btn btn-sm btn-toggle btn-switch" data-toggle="button" aria-pressed="false" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>VOD/Movies Maintanance alert to Web & Mobile.</p>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    Live TV
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="is_livetv_maintanance_flag" class="btn btn-sm btn-toggle btn-switch " data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>Live TV Maintanance alert to Web & Mobile.</p>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <p>
                                    Series
                                </p>
                            </div>
                            <div class="col-md-4 col-lg-3 mb-3 px-lg-3">
                                <button type="button" id="is_series_maintanance_flag" class="btn btn-sm btn-toggle btn-switch" data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                            <div class="col-md-4 col-lg-4 mb-3 px-lg-3">
                                <p>Series Maintanance alert to Web & Mobile.</p>
                            </div>
                        </div>

                    </div>

                    <div class="my-4 px-lg-3">
                        <button type="button" class="btn btn-blue" id="bestbox_maintanance_save">SAVE / UPDATE</button>
                    </div>
                </form>
            </div>

        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="proxyModal" tabindex="-1" role="dialog" aria-labelledby="proxyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <img src="<?php echo url('/'); ?>/public/images/alert_image.png" class="img-fluid mx-auto mt-4" alt="alert">
                </div>
                <div class="modal-body no-border">
                    <div class="f30 font-bold text-center">Are you sure?</div>

                    <div class="f20 py-3 text-center black_txt">To save and update <strong>Proxy Settings</strong>.</div>
                    <div class="row bg-light">
                        <div class="f20 py-3 text-center w-100">
                            <span class="black_txt">Client Code :</span><span id="client_code_popup_text" class="org-txt"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-border pt-0 pb-5">

                    <div class="col-md-6 text-center text-lg-right">
                        <button type="button" class="btn btn-cancel-modal text-center w80" id="cancel_proxy">Cancel</button>
                    </div>
                    <div class="col-md-6 text-center text-lg-left pr-0">
                        <button type="button" id="yes_proceed_proxy" class="btn btn-proceed-modal text-center w80" data-dismiss="modal">Yes Proceed it</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="trailEarningModal" tabindex="-1" role="dialog" aria-labelledby="trailEarningModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <img src="<?php echo url('/'); ?>/public/images/alert_image.png" class="img-fluid mx-auto mt-4" alt="alert">
                </div>
                <div class="modal-body no-border">
                    <div class="f30 font-bold text-center">Are you sure?</div>

                    <div class="f20 py-3 text-center black_txt">To save and update <strong>Trail & Earnings Notifications</strong>.</div>
                </div>
                <div class="modal-footer no-border pt-0 pb-5">
                    <div class="col-md-6 text-center text-lg-right pr-0">
                        <button type="button" id="yes_proceed_trail_earning" class="btn btn-proceed-modal text-center w80" data-dismiss="modal">Yes Proceed it</button>
                    </div>
                    <div class="col-md-6 text-center text-lg-left">
                        <button type="button" class="btn btn-cancel-modal text-center w80" id="cancel_trail_earning">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vplayedUpdateModal" tabindex="-1" role="dialog" aria-labelledby="vplayedUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <img src="<?php echo url('/'); ?>/public/images/alert_image.png" class="img-fluid mx-auto mt-4" alt="alert">
                </div>
                <div class="modal-body no-border">
                    <div class="f30 font-bold text-center">Are you sure?</div>

                    <div class="f20 py-3 text-center black_txt">To save and update <strong>vplayed Update Notifications</strong>.</div>
                </div>
                <div class="modal-footer no-border pt-0 pb-5">
                    <div class="col-md-6 text-center text-lg-right pr-0">
                        <button type="button" id="yes_proceed_vplayed_update" class="btn btn-proceed-modal text-center w80" data-dismiss="modal">Yes Proceed it</button>
                    </div>
                    <div class="col-md-6 text-center text-lg-left">
                        <button type="button" class="btn btn-cancel-modal text-center w80" id="cancel_vplayed_update">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <div class="modal fade" id="multiAccDiscModal" tabindex="-1" role="dialog" aria-labelledby="multiAccDiscModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <img src="<?php echo url('/'); ?>/public/images/alert_image.png" class="img-fluid mx-auto mt-4" alt="alert">
                </div>
                <div class="modal-body no-border">
                    <div class="f30 font-bold text-center">Are you sure?</div>

                    <div class="f20 py-3 text-center black_txt">To save and update <strong>Multiple Account Discount</strong>.</div>
                </div>
                <div class="modal-footer no-border pt-0 pb-5">
                    <div class="col-md-6 text-center text-lg-right pr-0">
                        <button type="button" id="yes_proceed_multi_acc" class="btn btn-proceed-modal text-center w80" data-dismiss="modal">Yes Proceed it</button>
                    </div>
                    <div class="col-md-6 text-center text-lg-left">
                        <button type="button" class="btn btn-cancel-modal text-center w80" id="cancel_multi_acc">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <?php
        if(Session::has('alert') && Session::get('alert') == 'Failure'){
    ?>
        <script type="text/javascript">
            swal(
                'Failure',
                '<?php echo Session::get('error');?>',
                'error'
            )
        </script>
    <?php
        }
    ?>

    <?php
        if(Session::has('alert') && Session::get('alert') == 'Success'){
    ?>
        <script type="text/javascript">
            swal(
                'Success',
                '<?php echo Session::get('message');?>',
                'success'
            )
        </script>
    <?php
        }
    ?>
    <script type="text/javascript">
        $("#save_update_proxy").click(function(){
            var client_code=$("#client_code").val();
            var proxy_line_streaming=$("#proxy_line_streaming").val();
            var proxy_vod=$("#proxy_vod").val();
            var proxy_catchup=$("#proxy_catchup").val();
            var live_streaming=$("#live_streaming").val();
            var vod_link=$("#vod_link").val();
            var catchup_link=$("#catchup_link").val();
            var player_link=$("#player_link").val();
            if(client_code==""){
                swal(
                    'Failure',
                    'Please enter client code',
                    'error'
                )
            }else if(proxy_line_streaming==""){
                swal(
                    'Failure',
                    'Please enter proxy line streaming link',
                    'error'
                )
            }else if(proxy_vod==""){
                swal(
                    'Failure',
                    'Please enter proxy VOD link',
                    'error'
                )
            }else if(proxy_catchup==""){
                swal(
                    'Failure',
                    'Please enter proxy catchup link',
                    'error'
                )
            }else if(live_streaming==""){
                swal(
                    'Failure',
                    'Please enter live streaming link',
                    'error'
                )
            }else if(vod_link==""){
                swal(
                    'Failure',
                    'Please enter VOD link',
                    'error'
                )
            }else if(catchup_link==""){
                swal(
                    'Failure',
                    'Please enter catch up link',
                    'error'
                )
            }else if(player_link==""){
                swal(
                    'Failure',
                    'Please enter player link',
                    'error'
                )
            }else{
                $("#client_code_popup_text").html(client_code);
                $("#proxyModal").modal('show');
            }
        });
        $("#cancel_proxy").click(function(){
            location.reload();
        });
        $("#cancel_trail_earning").click(function(){
            location.reload();
        });
        $("#cancel_vplayed_update").click(function(){
            location.reload();
        });
        $("#yes_proceed_proxy").click(function(){
            $("#save_proxy_settings").submit();
        });

        $("#trail_earning_save_btn").click(function(){
            var trail_duration=$("#trail_duration").val();
            if(trail_duration==""){
                swal(
                    'Failure',
                    'Please enter Trail account duration',
                    'error'
                )
            }else{

                $("#trailEarningModal").modal('show');
            }

        });

        $("#yes_proceed_trail_earning").click(function(){
            var trail_duration=$("#trail_duration").val();
            var dailyearning=0;
            if($("#daily_earning").hasClass('active')){
                dailyearning=1;
            }
            var monthlyearning=0;
            if($("#monthly_earning").hasClass('active')){
                monthlyearning=1;
            }
            var token = "<?php echo csrf_token() ?>";
            //console.log('_token '+ token+' trail_duration '+trail_duration+' dailyearning '+dailyearning+' monthlyearning '+monthlyearning);
            $.ajax({
                    url:'<?php echo url('/');?>/save_trail_earning',
                    data:{'_token': token,'trail_duration':trail_duration,'dailyearning':dailyearning,'monthlyearning':monthlyearning},
                    type:'POST',
                    success: function (data) {
                        //console.log(data);
                        //alert(data);
                        swal(
                            'Success',
                            data,
                            'success'
                        )
                    },
                    error:function(error){
                        //console.log(error.responseText);
                        swal(
                            'Failure',
                            error.responseText,
                            'error'
                        )
                    }
                });
        });

        $("#yes_proceed_vplayed_update").click(function(){
            var is_vod_update_flag=0;
            if($("#is_vod_update_flag").hasClass('active')){
                is_vod_update_flag=1;
            }
            var is_livetv_update_flag=0;
            if($("#is_livetv_update_flag").hasClass('active')){
                is_livetv_update_flag=1;
            }
            var is_series_update_flag=0;
            if($("#is_series_update_flag").hasClass('active')){
                is_series_update_flag=1;
            }

            var token = "<?php echo csrf_token() ?>";

            $.ajax({
                    url:'<?php echo url('/');?>/save_vplayed_data_update',
                    data:{'_token': token,'is_vod_update_flag':is_vod_update_flag,'is_livetv_update_flag':is_livetv_update_flag,'is_series_update_flag':is_series_update_flag},
                    type:'POST',
                    success: function (data) {
                        //console.log(data);
                        //alert(data);
                        swal(
                            'Success',
                            data,
                            'success'
                        )
                    },
                    error:function(error){
                        //console.log(error.responseText);
                        swal(
                            'Failure',
                            error.responseText,
                            'error'
                        )
                    }
                });
        });

        $("#bestbox_maintanance_save").click(function(){
            var is_vod_maintanance_flag=0;
            if($("#is_vod_maintanance_flag").hasClass('active')){
                is_vod_maintanance_flag=1;
            }
            var is_livetv_maintanance_flag=0;
            if($("#is_livetv_maintanance_flag").hasClass('active')){
                is_livetv_maintanance_flag=1;
            }
            var is_series_maintanance_flag=0;
            if($("#is_series_maintanance_flag").hasClass('active')){
                is_series_maintanance_flag=1;
            }

            var token = "<?php echo csrf_token() ?>";

            $.ajax({
                    url:'<?php echo url('/');?>/save_maintanance_update',
                    data:{'_token': token,'is_vod_maintanance_flag':is_vod_maintanance_flag,'is_livetv_maintanance_flag':is_livetv_maintanance_flag,'is_series_maintanance_flag':is_series_maintanance_flag},
                    type:'POST',
                    success: function (data) {
                        //console.log(data);
                        //alert(data);
                        swal(
                            'Success',
                            data,
                            'success'
                        )
                    },
                    error:function(error){
                        //console.log(error.responseText);
                        swal(
                            'Failure',
                            error.responseText,
                            'error'
                        )
                    }
                });
        });

        $("#vplayedUpdate_save_btn").click(function(){
            $("#vplayedUpdateModal").modal('show');
        });

        $("#multi_acc_save_btn").click(function(){
            var second_acc=$("#second_acc").val();
            var third_acc=$("#third_acc").val();
            if(second_acc==""){
                swal(
                    'Failure',
                    'Please enter second account',
                    'error'
                )
            }else if(third_acc==""){
                swal(
                    'Failure',
                    'Please enter third account',
                    'error'
                )
            }else{

                $("#multiAccDiscModal").modal('show');
            }
        });
        $("#yes_proceed_multi_acc").click(function(){
            var second_acc=$("#second_acc").val();
            var third_acc=$("#third_acc").val();
            var token = "<?php echo csrf_token() ?>";
            //console.log('_token '+ token+' second_acc '+second_acc+' third_acc '+third_acc);
            $.ajax({
                url:'<?php echo url('/');?>/save_multi_acc_discount',
                data:{'_token': token,'second_acc':second_acc,'third_acc':third_acc},
                type:'POST',
                success: function (data) {
                    swal(
                        'Success',
                        data,
                        'success'
                    )
                },
                error:function(error){
                    swal(
                        'Failure',
                        error.responseText,
                        'error'
                    )
                }
            });
        });
    </script>
    <script>
    $(document).ready(function(){
        var is_vod_maintanance_flag = <?php echo $maintanance_mode['is_vod_maintanance_flag'];?>;
        var is_livetv_maintanance_flag = <?php echo $maintanance_mode['is_livetv_maintanance_flag'];?>;
        var is_series_maintanance_flag = <?php echo $maintanance_mode['is_series_maintanance_flag'];?>;
        if(is_vod_maintanance_flag){
            $("#is_vod_maintanance_flag").addClass('active');
            $("#is_vod_maintanance_flag").attr('aria-pressed',true);
        }
        if(is_livetv_maintanance_flag){
            $("#is_livetv_maintanance_flag").addClass('active');
            $("#is_livetv_maintanance_flag").attr('aria-pressed',true);
        }
        if(is_series_maintanance_flag){
            $("#is_series_maintanance_flag").addClass('active');
            $("#is_series_maintanance_flag").attr('aria-pressed',true);
        }
    });
    </script>
    
    
</body>
</html>
