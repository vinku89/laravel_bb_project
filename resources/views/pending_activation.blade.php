<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Pending Activation</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
   <style type="text/css">
       #loading-div {
           width: 100%;
           height: 100%;
           top: 0;
           left: 0;
           position: fixed;
           display: block;
           opacity: 0.7;
           background-color: #fff;
           z-index: 99;
           text-align: center;
        }

        #loading-image {
          position: absolute;
          top: 100px;
          z-index: 9999;
          left: 40%;
        }
   </style>
</head>
<body>
    <div id="loading-div" class="loader" style="display: none;">
        <img id="loading-image" src="/public/images/spinner.gif" />
    </div>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content">
        <!-- Header Section Start Here -->
        @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left"> Pending Activation</h5>
            <?php
                if($userinfo['admin_login'] == 1){
                    $w1 = 'w4';$w2 = 'w12';$w3 = 'w31';$w4 = 'w11';$w5 = 'w23';$w6 = 'w10';$w7 = 'w14';$w8 = 'w9';
                }else{
                    $w1 = 'w4';$w2 = 'w12';$w3 = 'w30';$w4 = 'w11';$w5 = 'w33';$w6 = 'w10';$w7 = '';$w8 = '';
                }
            ?>
            <div class="pending_actTable_wrp">
                <?php
                    $arr = array();
                    foreach($request_list as $item){
                        if($item['setupbox_status'] == 1 && $item['is_shipped'] == 0){
                                continue;
                            }
                        array_push($arr, $item);
                    }
                ?>
                @if(count($arr) > 0)
                <div class="tableGrid_title clearfix">
                    <div class="{{ $w1 }} title_col">No</div>
                    <div class="{{ $w2 }} title_col">Date</div>
                    <div class="{{ $w3 }} title_col">Name</div>
                    <div class="{{ $w4 }} title_col">Order No</div>
                    <div class="{{ $w5 }} title_col">Email ID</div>
                    <div class="{{ $w6 }} title_col">User ID</div>
                    @If($userinfo['admin_login'] == 1)
                    <!-- <div class="{{ $w7 }} title_col">Password</div> -->
                    <div class="{{ $w8 }} title_col text-center">Action</div>
                    @endIf
                </div>
                <?php $i = 1; ?>

                    @foreach($arr as $item)
                        <?php
                            if($item['setupbox_status'] == 1 && $item['is_shipped'] == 0){
                                continue;
                            }
                            ?>
                <div class="pending_actTable_info clearfix">
                    <div class="{{ $w1 }} pending_actTable_infoCol small_tableCol1 xs_tableCol1 xxs_tableCol1 row_border_bottom991">
                    <div class="mobile_view_titles">No</div>
                        {{ $i }}
                    </div>
                    <div class="{{ $w2 }} pending_actTable_infoCol  small_tableCol2 xs_tableCol2 xxs_tableCol2 row_border_bottom991">
                    <div class="mobile_view_titles">Date</div>
                    @php
                        $pdate = \App\Http\Controllers\home\ReportController::convertTimezoneDate($item['purchased_date']);
                    @endphp
                    {{ $pdate }}
                    </div>
                    <div class="{{ $w3 }} pending_actTable_infoCol wordBreak-word xs_tableCol3 xxs_tableCol3 small_tableCol3 row_border_bottom991">
                    <div class="mobile_view_titles">Name</div>
                    {{ $item['first_name']." ".$item['last_name'] }}
                    </div>
                    <div class="{{ $w4 }} pending_actTable_infoCol wordBreak-all xs_tableCol4 xxs_tableCol3 small_tableCol4 row_border_bottom991">
                    <div class="mobile_view_titles">Order No</div>
                    {{ $item['order_id'] }}
                    </div>
                    <div class="{{ $w5 }} pending_actTable_infoCol wordBreak-all xs_tableCol5 xxs_tableCol5 small_tableCol5 row_border_bottom767">
                    <div class="mobile_view_titles">Email ID</div>
                    {{ $item['email'] }}
                    </div>
                    <div class="{{ $w6 }} pending_actTable_infoCol small_tableCol6 xs_tableCol6 xxs_tableCol6 row_border_bottom576">
                    <div class="mobile_view_titles">User ID</div>
                    <span class="orange_txt font-weight-bold">{{ $item['user_id'] }}</span>
                    </div>
                    @If($userinfo['admin_login'] == 1)
                    <!-- <div class="{{ $w7 }} pending_actTable_infoCol small_tableCol7 xs_tableCol7 xxs_tableCol7">
                    <div class="mobile_view_titles">Password</div>
                        <input class="form-control" type="text" name="cms_password" id="cms_password{{ $item['rec_id'] }}">
                        <div id="err_msg{{ $item['rec_id'] }}" class="error"></div>
                    </div> -->
                    <div class="{{ $w8 }} pending_actTable_infoCol small_tableCol8 xs_tableCol8 xxs_tableCol8 text-center">
                    <div class="mobile_view_titles text-center">Action</div>
                        <a href="{{ url('/saveSubscribePackage').'/'.$item['rec_id'] }}" id="{{ $item['rec_id'] }}" data-pdate="{{ $pdate }}" data-package="{{ $item['package_name'] }}" data-orderno="{{ $item['order_id'] }}" data-email="{{ $item['email'] }}" data-userid="{{ $item['user_id'] }}" data-name="{{ $item['first_name'].''.$item['last_name'] }}" class="activenow_btn activate_now1">Active Now</a>
                    </div>
                    @endIf

                </div>
                <?php $i++; ?>
                @endforeach
            @else
                <div class="w100 norecord_txt">No Records Found</div>
            @endIf

            </div>
        </section>
    </div>
<!-- Single Update Modal popup -->
<div class="modal fade" id="activationModal" tabindex="-1" role="dialog" aria-labelledby="activation" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content data_modal">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="activation">Pending Activation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-4">
                <div class="mb-4 titleBg">
                    <h5 class="font-weight-bold black_txt">Activation Period    </h5>
                    <h3 class="font-weight-bold green_txt">
                        <span id="start_period">18/06/2019</span> - <span id="end_period">18/08/2019</span>
                    </h3>
                </div>
                <ul class="modal_data_wrap">
                    <li>Date</li>
                    <li>: <span id="sh_date"></span></li>
                    <li>Name</li>
                    <li>: <span class="font-weight-bold" id="sh_name"></span></li>
                    <li>User ID</li>
                    <li>: <span class="blue_txt font-weight-bold" id="sh_userid"></span></li>
                    <li>Order No</li>
                    <li>: <span id="sh_orderno"></span></li>
                    <li>Email ID</li>
                    <li>: <span id="sh_email"></span></li>
                    <li>Package</li>
                    <li>: <span class="blue_txt font-weight-bold" id="sh_package"></span></li>
                </ul>
            </div>
            <form method="post" id="save_activation_form" action="<?php echo url('/').'/saveSubscribePackage';?>">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="purchased_rec_id" id="purchased_rec_id">
                <input type="hidden" name="cms_password" id="sh_cms_password">
                <input type="hidden" name="cms_start_date" id="cms_start_date">
                <input type="hidden" name="cms_expiry_date" id="cms_expiry_date">
            </form>
            <div class="col-12 ">
                <div class="row">
                    <div class="col-6 cancel_modal_btn"><a href="#" class="decoration_none" style=" color: #4A4A4A;" data-dismiss="modal">Cancel</a> </div>
                    <div class="col-6 modal_btn"><a href="" class="decoration_none white_txt" id="save_active_now">Activate Now</a> </div>
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

        $(".activate_now").click(function(e){
            e.preventDefault();
            var  error = false;
            var this_act=$(this);
            var rec_id = $(this).attr('id');
            var cms_password = $.trim($("#cms_password"+rec_id).val());
            if(cms_password == ''){
                $("#cms_password"+rec_id).focus();
                $("#err_msg"+rec_id).html("CMS Password is required");
                error = true;
            }else{
                $("#err_msg"+rec_id).html("");
            }
            if(!error){
                var csrf_Value= "<?php echo csrf_token(); ?>";
                var user_id = $(this).attr('data-userid');
                $.ajax({
                    url: "<?php echo url('/');?>/validatePortalCredentials",
                    method: "POST",
                    dataType: "json",
                    data: {
                            "purchased_id":rec_id,"username" : user_id,"password" : cms_password,"_token":csrf_Value,
                    },
                    beforeSend: function() {
                      $("#loading-div").show();
                    },
                    success: function (data) {
                        //alert(data);
                        $("#loading-div").hide();
                        if(data=="fail"){
                            //alert("f");
                            $("#cms_password"+rec_id).focus();
                            $("#err_msg"+rec_id).html("Something wrong with portal");
                            error = true;
                            //return false;
                        }else if(data==""){
                            //alert("p");
                            $("#cms_password"+rec_id).focus();
                            $("#err_msg"+rec_id).html("CMS Password is invalid");
                            error = true;
                            //return false;
                        }else{
                            //alert();
                            $("#cms_start_date").val(data.startdate);
                            $("#cms_expiry_date").val(data.expirydate);
                            $("#start_period").html(data.format_startdate);
                            $("#end_period").html(data.format_expirydate);

                            if(!error){
                                //alert("e");
                                var purchased_date = this_act.attr('data-pdate');
                                var package_name = this_act.attr('data-package');
                                var orderno = this_act.attr('data-orderno');
                                var email = this_act.attr('data-email');

                                var name = this_act.attr('data-name');

                                //alert(purchased_date);

                                $("#sh_date").html(purchased_date);
                                //$("#sh_trackingno").html(trackingId);
                                $("#sh_package").html(package_name);
                                $("#sh_orderno").html(orderno);
                                $("#sh_email").html(email);
                                $("#sh_userid").html(user_id);
                                $("#sh_name").html(name);
                                $("#purchased_rec_id").val(rec_id);
                                $("#sh_cms_password").val(cms_password);

                                $('#activationModal').modal('show');
                            }
                        }

                    },
                    error: function(error){
                        $("#loading-div").hide();
                        $("#cms_password"+rec_id).focus();
                        $("#err_msg"+rec_id).html("CMS Password is invalid");
                        error = true;
                    }
                });
            }

        });
        $("#save_active_now").click(function(e){
            e.preventDefault();
            $("#save_activation_form").submit();
        });

    </script>
</body>
</html>
