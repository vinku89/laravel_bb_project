<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Pending Renewal</title>
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
            <!-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <i class="fas fa-angle-left"></i>
                    <li class="breadcrumb-item f16"><a href="{{ url('/').'/customers' }}" class="f16">Customers</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Add New Customer</li>
                </ol>
            </nav> -->
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left">Pending Renewal Activation</h5>
            <?php
                if($userinfo['admin_login'] == 1){
                    $w1 = 'w4';$w2 = 'w12';$w3 = 'w13';$w4 = 'w29';$w5 = 'w9';$w6 = '';$w7 = 'w15';$w8 = 'w10';$w9 = 'w8';
                }else{
                    $w1 = 'w4';$w2 = 'w12';$w3 = 'w13';$w4 = 'w25';$w5 = 'w9';$w6 = '';$w7 = 'w25';$w8 = 'w12';$w9 = '';
                }
            ?>
            <div class="pending_renewal_wrp">
                @if($request_list->count())
                <div class="tableGrid_title clearfix">
                    <div class="{{ $w1 }} title_col">No</div>
                    <div class="{{ $w2 }} title_col">Date</div>
                    <div class="{{ $w3 }} title_col">Order No</div>
                    <div class="{{ $w4 }} title_col">Email ID</div>
                    <div class="{{ $w5 }} title_col">User ID</div>
                    @If($userinfo['admin_login'] == 1)
                    <!-- <div class="{{ $w6 }} title_col">Supplier<br>Password</div> -->
                    @endIf
                    <div class="{{ $w7 }} title_col">Package</div>
                    <div class="{{ $w8 }} title_col text-right">Amount(USD)</div>
                    @If($userinfo['admin_login'] == 1)
                    <div class="{{ $w9 }} title_col text-center">Action</div>
                    @endIf
                </div>
                    @foreach($request_list as $item)
                <div class="pending_renewal_info clearfix">
                    <div class="{{ $w1 }} pending_renewal_infoCol md-datacol1 row_border_bottom1199 sm-datacol1 xs-datacol1">
                        <div class="sm_view_titles">No</div>
                        {{ $loop->iteration }}
                    </div>
                    <div class="{{ $w2 }} pending_renewal_infoCol md-datacol2 row_border_bottom1199 sm-datacol2 xs-datacol2">
                        <div class="sm_view_titles">Date</div>
                        @php
                            $pdate = \App\Http\Controllers\home\ReportController::convertTimezoneDate($item['purchased_date']);
                        @endphp
                        {{ $pdate }}
                    </div>

                    <div class="{{ $w3 }} pending_renewal_infoCol md-datacol4 wordBreak-all row_border_bottom1199 sm-datacol4 xs-datacol4">
                        <div class="sm_view_titles">Order No</div>
                        {{ $item['order_id'] }}
                    </div>
                    <div class="{{ $w4 }} pending_renewal_infoCol md-datacol5 wordBreak-all row_border_bottom1199 sm-datacol5 xs-datacol5">
                        <div class="sm_view_titles">Email ID</div>
                        {{ $item['email'] }}
                    </div>
                    <div class="{{ $w5 }} pending_renewal_infoCol md-datacol6 wordBreak-word row_border_bottom1199  sm-datacol6 xs-datacol6">
                        <div class="sm_view_titles">User ID</div>
                        <span class="orange_txt font-weight-bold">{{ $item['user_id'] }}</span>
                    </div>
                    @If($userinfo['admin_login'] == 1)
                    <!-- <div class="{{ $w6 }} pending_renewal_infoCol md-datacol3 sm-datacol3 xs-datacol3 row_border_bottom767">
                        <div class="sm_view_titles">Supplier Password</div>
                        <input class="form-control font-weight-bold" id="cms_password{{ $item['rec_id'] }}" type="text" name="" style="margin-bottom: 4px !important;" >
                        <div id="err_msg{{ $item['rec_id'] }}" class="error"></div>
                    </div> -->
                    @endIf
                    <div class="{{ $w7 }} pending_renewal_infoCol wordBreak-word md-datacol7 sm-datacol7 xs-datacol7 row_border_bottom767 row_border_bottom576">
                        <div class="sm_view_titles">Package</div>
                        <span class="redium_blue_txt font-weight-bold">{{ $item['package_name'] }}</span>
                    </div>
                    <div class="{{ $w8 }} text-right pending_renewal_infoCol md-datacol8 sm-datacol8 xs-datacol8">
                        <div class="sm_view_titles">Amount(USD)</div>
                        <span class="green_txt font-weight-bold">{{ $item['effective_amount'] }}</span>
                    </div>
                    @If($userinfo['admin_login'] == 1)
                    <div class="{{ $w9 }} text-center pending_renewal_infoCol md-datacol9 sm-datacol9 xs-datacol9">
                        <div class="sm_view_titles">Action</div>
                        <a href="{{ url('/saveRenewPackage').'/'.$item['rec_id'] }}" id="{{ $item['rec_id'] }}" data-pdate="{{ $pdate }}" data-package="{{ $item['package_name'] }}" data-orderno="{{ $item['order_id'] }}" data-email="{{ $item['email'] }}" data-userid="{{ $item['user_id'] }}" data-name="{{ $item['first_name'].''.$item['last_name'] }}" data-effective_amount="{{ $item['effective_amount'] }}" class="activenow_btn renew_now1">Renew Now</a>

                    </div>
                    @endIf
                </div>
                    @endforeach
                @else
                    <div class="w100 norecord_txt">No Records Found</div>
                @endIf
            </div>


        </section>
    </div>



<!-- Single Update Modal popup -->
<div class="modal fade" id="renewal" tabindex="-1" role="dialog" aria-labelledby="renewal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content data_modal">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="activation">Pending Renewal Activation</h5>
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
                    <li>: <span class="font-weight-bold f18" id="sh_name"></span></li>
                    <li>User ID</li>
                    <li>: <span class="orange_txt font-weight-bold f18" id="sh_userid"></span></li>
                    <li>Order No</li>
                    <li>: <span id="sh_orderno"></span></li>
                    <li>Email ID</li>
                    <li>: <span id="sh_email"></span></li>
                    <li>Package</li>
                    <li>: <span class="redium_blue_txt font-weight-bold f18" id="sh_package"></span></li>
                    <li>Amount</li>
                    <li>: <span class="green_txt font-weight-bold f18" id="sh_effective_amt">$34.99</span> <span class="green_txt font-weight-bold f18">USD</span></li>
                </ul>
            </div>
            <form method="post" id="save_renew_form" action="<?php echo url('/').'/saveRenewPackage';?>">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="purchased_rec_id" id="purchased_rec_id">
                <input type="hidden" name="cms_password" id="sh_cms_password">
                <input type="hidden" name="cms_start_date" id="cms_start_date">
                <input type="hidden" name="cms_expiry_date" id="cms_expiry_date">
            </form>
            <div class="col-12 ">
                <div class="row">
                    <div class="col-6 cancel_modal_btn"><a href="#" class="decoration_none" style=" color: #4A4A4A;" data-dismiss="modal">Cancel</a> </div>
                    <div class="col-6 modal_btn"><a href="#" class="decoration_none white_txt" id="save_renew_now">Renew Now</a> </div>
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
        $(".renew_now").click(function(e){
            e.preventDefault();
            var  error = false;
            var this_renew=$(this);
            var rec_id = $(this).attr('id');
            var cms_password = $.trim($("#cms_password"+rec_id).val());
            if(cms_password == ''){
                $("#cms_password"+rec_id).focus();
                $("#err_msg"+rec_id).html("Supplier Password is required");
                error = true;
            }else{
                $("#err_msg"+rec_id).html("");
            }
            if(!error){
                var csrf_Value= "<?php echo csrf_token(); ?>";
                var user_id = $(this).attr('data-userid');
                $.ajax({
                    url: "<?php echo url('/');?>/validatePortalCredentialsForRenew",
                    method: "POST",
                    dataType: "json",
                    data: {
                            "purchased_id":rec_id,"username" : user_id,"password" : cms_password,"_token":csrf_Value,
                    },
                    beforeSend: function() {
                      $("#loading-div").show();
                    },
                    success: function (response) {
                        ////alert();
                        $("#loading-div").hide();
                        //alert(data);
                        //console.log(response);
                        if(response=="fail"){
                            //alert("f");
                            $("#cms_password"+rec_id).focus();
                            $("#err_msg"+rec_id).html("Something wrong with portal");
                            error = true;
                            //return false;
                        }else if(response==""){
                            //alert("p");
                            $("#cms_password"+rec_id).focus();
                            $("#err_msg"+rec_id).html("Supplier Password is invalid");
                            error = true;
                            //return false;
                        }else if(response=="renew supplier"){
                            //alert("p");
                            $("#cms_password"+rec_id).focus();
                            $("#err_msg"+rec_id).html("Please renew Supplier account.");
                            error = true;
                            //return false;
                        }else{
                            //alert();
                            //console.log(response);
                            $("#cms_start_date").val(response.startdate);
                            $("#cms_expiry_date").val(response.expirydate);
                            $("#start_period").html(response.format_startdate);
                            $("#end_period").html(response.format_expirydate);

                            if(!error){
                                //alert("e");
                                var purchased_date = this_renew.attr('data-pdate');
                                var package_name = this_renew.attr('data-package');
                                var orderno = this_renew.attr('data-orderno');
                                var email = this_renew.attr('data-email');

                                var name = this_renew.attr('data-name');
                                var sh_effective_amt=this_renew.attr('data-effective_amount');
                                //alert(purchased_date);

                                $("#sh_date").html(purchased_date);
                                //$("#sh_trackingno").html(trackingId);
                                $("#sh_package").html(package_name);
                                $("#sh_orderno").html(orderno);
                                $("#sh_email").html(email);
                                $("#sh_userid").html(user_id);
                                $("#sh_name").html(name);
                                $("#sh_effective_amt").html(sh_effective_amt);
                                $("#purchased_rec_id").val(rec_id);
                                $("#sh_cms_password").val(cms_password);

                                $('#renewal').modal('show');
                            }
                        }

                    },
                    error: function(error){
                        $("#loading-div").hide();
                        console.log(error);
                        if(error.responseText=="fail"){
                            $("#cms_password"+rec_id).focus();
                            swal(
                                'Failure',
                                'Something wrong with portal',
                                'error'
                            )
                            error = true;

                        }else if(error.responseText==""){
                            $("#cms_password"+rec_id).focus();
                            error = true;
                            swal(
                                'Failure',
                                'Supplier CMS Password is invalid',
                                'error'
                            )

                        }else if(error.responseText=="renew supplier"){
                            $("#cms_password"+rec_id).focus();
                            error = true;
                            swal(
                                'Failure',
                                'Please renew this account in Supplier CMS.',
                                'error'
                            )

                        }

                    }
                });
            }

        });
        $("#save_renew_now").click(function(e){
            e.preventDefault();
            $("#save_renew_form").submit();
        });
    </script>
</body>
</html>
