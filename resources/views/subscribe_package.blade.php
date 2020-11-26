<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Subscribe Package</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <link rel="stylesheet" type="text/css" href="<?php echo url('/public/lightbox/css/lightbox.css')?>" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style>
        .purple-bordered {
            border: 1px solid #A02C72;
            border-radius: 5px;
            background-color: #fff;
            padding: 10px;
        }

        .mw-450 {
            max-width: 450px;
            width: 100%; }

        .mw-500 {
        max-width: 500px;
        width: 100%; }

        .select2-container--default .select2-selection--single{
            background-color:transparent !important;
            border:none !important;
            border-bottom: solid 3px #7f868b !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single{
            height:33px !important;
        }
        .select2-selection__rendered[title="Select Country"]{
            font-size:14px !important;
            color: #737a82 !important;
        }

        .select2-container[dir="ltr"]{
            width:100% !important;
        }
        ul{
        text-decoration: none;
        text-align: left;
        line-height: 25px;
        font-size: 16px;
    }
    .pswview-icon{
            position: absolute;
            z-index: 2;
            right: 0;
            top: -10px;
            cursor: pointer;
            font-size: 15px;
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

            <h5 class="font22 font-bold text-uppercase black_txt pt-4 mb-5">Subscribe Package</h5>
            <div class="row">
                <div class="col-md-6">
                </div>
            </div>
            <div class="clearfix ">
                <div class="">
                    <div class="mw-500">
                        <!-- <table class="rwd-table body_bg">

                        </table> -->
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/saveSubscribePackage';?>">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="purchase_id" id="purchase_id" value="{{ $purchase_id }}">
                        <input type="hidden" name="purchase_from" id="purchase_from" value="{{ $purchase_details['purchased_from'] }}">
                        <input type="hidden" name="type" id="type" value="{{ $type }}">
                        <input type="hidden" name="customer_userid" id="customer_userid" value="{{ $customer_info['user_id'] }}">
                        <input type="hidden" name="customer_rec_id" id="customer_rec_id" value="{{ $customer_info['rec_id'] }}">
                         <!-- Create Customer ID -->
                         <!-- Email -->
                        <div class="form-group">
                            <input type="email" class="form-control border-bottom-only body_bg readonly_input" id="email" name="email"
                                aria-describedby="email" placeholder="Email" value="{{ $customer_info['email'] }}" readonly="readonly">
                                <span class="f14" id="email_error"></span>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                                    class="text-muted f14 black_txt">Email</span></div>
                        </div>

                        <!-- First Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="firstName" name="first_name"
                                aria-describedby="firstName" placeholder="First Name" value="{{ $customer_info['first_name'] }}" required="required">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="firstName"
                                    class="text-muted f14 black_txt">First Name</span></div>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="lastName" name="last_name"
                                aria-describedby="lastName" placeholder="Last Name" value="{{ $customer_info['last_name'] }}" required="required">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="lastName"
                                    class="text-muted f14 black_txt">Last Name</span></div>
                        </div>

                        <!-- Gender -->
                        <!-- <div class="mobile_menu_section body_bg form-group">
                            <select id="subscribe_gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php //if($customer_info['gender'] == 'Male') {echo 'selected';} ;?>>Male</option>
                                <option value="Female" <?php //if($customer_info['gender'] == 'Female') {echo 'selected';} ;?>>Female</option>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                                    class="text-muted f14 black_txt">Gender</span></div>
                        </div> -->

                        <!-- Status -->
                        <!-- <div class="mobile_menu_section body_bg form-group">
                            <select id="normal_select1" name="married_status">
                                <option value="">Martial Status</option>
                                <option value="Married" <?php //if($customer_info['married_status'] == 'Married') {echo 'selected';} ;?>>Married</option>
                                <option value="Single" <?php //if($customer_info['married_status'] == 'Single') {echo 'selected';} ;?>>Single</option>
                            </select>
                            <div class="text-right f14"><span id="emailHelp"
                                    class="text-muted f14 black_txt">Status</span></div>
                        </div> -->

                        <!-- Shipping Address -->
                       <!--  <div class="text-center my-2 f14 font-bold color-black">Shipping Address</div> -->

                        <!-- <div class="form-group">
                            <label for="exampleInputEmail1" class="font-bold black_txt">* Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="10" data-sample-short>{{ $customer_info['shipping_address'] }}</textarea>
                            <div class="f12" style="color:red" id="shipAddrErr"></div>
                        </div> -->

                        <!-- Country -->
                        <!-- <div class="mobile_menu_section body_bg form-group">
                            <select id="shipping_country" name="shipping_country">
                                <option value="">Select Country</option>
                                <?php
                                    /*foreach ($country_data as $val) {
                                        ?>
                                        <option value='<?php echo $val->countryid;?>' data-id='<?php echo $val->currencycode;?>' <?php if($val->countryid == $customer_info['shipping_country']) {echo 'selected';} ;?>><?php echo $val->country_name;?></option>
                                 <?php   }*/
                                ?>
                            </select>
                            <div class="text-right f14"><span id="emailHelp"
                                    class="text-muted f14 black_txt">Country</span></div>
                        </div> -->

                        <!-- Mobile Number -->
                        <!-- Mobile Number -->
                        <?php
                            if(!empty($customer_info['shipping_user_mobile_no'])){
                                $arr = explode('-', $customer_info['shipping_user_mobile_no']);
                            }else{
                                $arr = array();
                            }
                        ?>
                        <!-- <div class="form-group row">
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                        placeholder="+0" aria-label="Mobile number"
                                        aria-describedby="basic-addon2" value="{{ !empty($arr[0]) ? $arr[0] : '' }}" name="shipping_country_code" id="shipping_country_code" readOnly>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                        placeholder="Mobile Number" aria-label="Mobile number"
                                        aria-describedby="basic-addon2" id="shipping_user_mobile_no" name="shipping_user_mobile_no" value="{{ !empty($arr[1]) ? $arr[1] : '' }}" >
                                    <div class="text-right f14 w-100 pt-2">
                                        <span id="telErrorMsg" class="f14 error_txt"></span>
                                        <span id="emailHelp"
                                            class="text-muted f14 black_txt">Mobile number</span>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- CMS Details -->
                        <div class="text-center my-2 f14 font-bold color-black">CMS Details</div>

                        <!-- Address Line 1 -->
                        <div class="form-group" style=" margin-bottom: 30px;">
                            <input type="name" class="form-control border-bottom-only body_bg" id="cms_username" name="cms_username" value="{{ $customer_info['user_id'] }}" aria-describedby="emailHelp" placeholder="CMS Username" readonly="readonly" required="required">
                            <div class="f14 clearfix">
                               <!--  <span style="position:relative">
                                <input type="checkbox" name="copy_det" id="copy_det" class="form-check-input" style=" width: inherit;margin-left: 0; z-index: 99;">
                                    <label class="form-check-label payfor_friend font-bold" for="exampleCheck1" id="emailHelp" style="padding-left: 15px; top:0;">Same as Bestbox</label>
                                </span> -->
                                    <span id="emailHelp" class="text-muted f14 black_txt float-right">Username</span>
                                </div>
                        </div>
                        <!-- <div class="col-12 pl-0 mb-4">
                            <div class="form-group form-check">
                                <input type="checkbox" name="copy_det" id="copy_det" class="form-check-input" style=" width: inherit;">
                                <label class="form-check-label payfor_friend font-bold" for="exampleCheck1" id="emailHelp">Same as Bestbox</label>
                            </div>
                        </div> -->

                        <!-- Address Line 2 -->
                        <div class="form-group" style="position:relative;">
                            <input type="password" class="form-control border-bottom-only body_bg" id="cms_password" name="cms_password" aria-describedby="emailHelp" placeholder="CMS Password" readonly="readonly" required="required">
                            <div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Password</span></div>
                            <span class="icon validation small" style="color:black;">
                                <i class="fa fa-fw pswview-icon toggle-password fa-eye-slash" toggle="#cms_password" ></i>
                            </span>
                        </div>

                        <!-- Package Details -->
                        <div class="text-center my-2 f14 font-bold color-black">Package Details</div>
                        @if($purchase_details['purchased_from'] == 'Ali Express')
                        <div class="form-group">
                            <div class="select-test">
                                <input type="hidden" name="package" id="package" value="">
                                <input type="hidden" name="package_amount" id="package_amount" value="">
                                <button class="h50">
                                    <span>Select</span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="f16 package_list">
                                    <li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">
                                        Select Package
                                    </li>
                                    @foreach ($package_data as $val)
                                        <li value="{{ $val->id }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" data-name="{{ $val->package_name }}" data-desc="{{ $val->description }}" class="text-left" style="display: table; width: 100%;">
                                            <div class="border-right-blue p-3" style="display: table-cell; width: 70%;">
                                                <div class="" style="font-weight: 700;">{{ $val->package_name }}</div>
                                            <div> {{ $val->description }}</div>
                                            </div>
                                            <div class="p-3 font-bold" style="display: table-cell; width: 30%;">{{ $val->effective_amount }} USD</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endIf
                        @if($purchase_details['purchased_from'] != 'Ali Express')
                            <div class="form-group">
                                <div class="select-test" >
                                    <input type="hidden" name="package_purchase_id" id="package_purchase_id" value="{{ $purchase_details->rec_id }}">
                                    <input type="hidden" name="package" id="package" value="{{ $purchase_details->package_id }}">
                                    <input type="hidden" name="package_amount" id="package_amount" value="">
                                    <button class="h50">
                                        <span>Select</span>
                                    </button>
                                    <ul class="f16 package_list">
                                        @foreach ($package_data as $val)
                                            @if($val->id == $purchase_details->package_id)
                                                <li value="{{ $val->id }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" data-name="{{ $val->package_name }}" data-desc="{{ $val->description }}"
                                                    <?php if($val->id == $purchase_details->package_id) echo 'selected';?> class="text-left" style="display: table; width: 100%;">
                                                    <div class="border-right-blue p-3" style="display: table-cell; width: 70%;">
                                                        <div class="" style="font-weight: 700;">BestBOX</div>
                                                        <div> {{ $val->package_name }}</div>
                                                    </div>
                                                    <div class="p-3 font-bold" style="display: table-cell; width: 30%;">{{ $val->effective_amount }} USD</div>
                                                </li>
                                            @endIf
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endIf

                        <!-- Pre Buy -->
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <div class="f16 font-bold color-black p-2">
                                        <div class="mb-2">Activation Period</div>
                                        <div class="mb-2">{{ date("d/m/Y") }}</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="text-center">
                                    <div class="f16 font-bold blue-bordered">
                                        <div class="color-black mb-2">Wallet Balance</div>
                                        <div class="blue_txt mb-2">{{ number_format($wallet_balance->amount,2) }} USD</div>
                                        <input type="hidden" value="{{ $wallet_balance->amount }}" id="user_wallet_amt" name="user_wallet_amt">
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-12 mt-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="pay" id="pay" class="form-check-input">
                                    <label class="form-check-label payfor_friend" for="exampleCheck1">Pay For My Friend</label>
                                </div>
                            </div> -->
                        </div>
                         @if($purchase_details['purchased_from'] == 'Ali Express')
                        <div class="row">
                            <div class="col purple-bordered my-3">
                                <div class="text-center h-100 w-100 d-table">
                                    <div class="f16 font-bold color-black p-2 d-table-cell align-middle">
                                        <div class="mb-2">Order No.</div>
                                        <div class="mb-2">{{ $purchase_details->order_id }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col purple-bordered ml-0 ml-lg-2 my-3">
                                <div class="text-center h-100 w-100 d-table">
                                    <div class="f16 font-bold color-black p-2 d-table-cell align-middle">
                                        <div class="mb-2">Reference</div>
                                        <div class="mb-2">
                                            @If(!empty($purchase_details->attachment))
                                            <a href="<?php echo url('/public/invoices').'/'.$purchase_details->attachment;?>" data-lightbox="invoice" data-title="Reference"><img src="<?php echo url('/public/invoices').'/'.$purchase_details->attachment;?>" class="img-fluid"></a>
                                            @else
                                            <p>No Attachment</p>
                                            @endIf
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="my-4">
                            <div class="display_inline">
                                <a href="#" id="cancel_order" class="btn_cancel">Cancel Order</a>
                            </div>
                            <div class="display_inline">
                                <button type="button" id="activate_alert" class="btn btn_primary d-block w-100 mt-4 " >Activate</button>
                            </div>
                        </div>
                    </form>
                    <form method="post" id="status_form" name="status_form" action="<?php echo url('/').'/updateOrderStatus';?>">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="purchase_id" id="purchase_id" value="{{ $purchase_id }}">
                    </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-center f20 black_txt py-5 mb-5">
                        Insufficient Balance In Your Wallet.
                        You can reload your wallet and try to create customer or you can save data to click continue.
                    </div>
                </div>
                <input type="hidden" name="delete_user_id" id="delete_user_id">
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn" id="cls_modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

    <?php
        if(Session::has('error')){
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
        if(Session::has('message')){
    ?>
        <script type="text/javascript">
            setTimeout(function() {
                swal({
                    title: "Success",
                    text: '<?php echo Session::get('message');?>',
                    type: "success"
                }).then(function() {
                    var type = <?php echo $type ?>;
                    if(type == 2){
                        window.location = '<?php echo url('renewalActivation');?>';
                    }else{
                        window.location = '<?php echo url('customerActivation');?>';
                    }
                });
            }, 1000);
        </script>
    <?php
        }
    ?>

    <script>
        $(function () {
            var select = $(".select-test");
            select.select({
                selected: 0,
                animate: "slide"
            });
        });
        /* select box*/
        $(document).ready(function()
        {
            /*$("#cms_username").focus(function(){
               this.removeAttribute('readonly');
            });*/
            $("#cms_password").focus(function(){
               this.removeAttribute('readonly');
            });

           /* $("#copy_det").click(function(){
                if($(this).prop("checked") == true){
                    var customer_userid = $("#customer_userid").val();
                    $("#cms_username").val(customer_userid);
                }
                else if($(this).prop("checked") == false){
                    $("#cms_username").val("");
                }
            });*/


            $('ul.package_list li').click(function(e)
            {
                $('#pay').attr('checked', true);
                var amount = $(this).attr('data-amt');
                var user_wallet_amt = $("#user_wallet_amt").val();
                if(parseFloat(amount) > parseFloat(user_wallet_amt)){
                        $("#alertModal").modal("show");
                    }
                var package_id = $(this).attr('data-package');
                $("#package").val(package_id);
                $("#package_amount").val(amount);
                var package_name = $(this).attr('data-name');
                var package_desc = $(this).attr('data-desc');
                setTimeout(function() {
                    $(".select-test span:first").html("<div class='p-1' style='width: 100%;background-color:#fff;'><div class='float-left' style='width:75%'><div style='font-weight: 700;'>"+package_name+"</div><div>"+package_desc+"</div></div><div class='float-right font-bold pr-2 pt-3'>"+amount+" USD</div></div>");

                }, 50);
            });

            $("#cms_password").keyup(function(){
                        $(".toggle-password").removeClass('showHide_icon');
                });
        });
        $("#shipping_country").change(function(e) {
            var country_code =  $('option:selected', this).attr('data-id');
            $("#shipping_country_code").val('+'+country_code);
        });
        $("#shipping_user_mobile_no").on("keypress keyup blur",function (event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $("#cls_modal").click(function(){
            $("#alertModal").modal("hide");
            location.reload();
        });

        $("#email").blur(function(){
            var email = $(this).val();
            var token = "<?php echo csrf_token(); ?>";
            $.ajax({
                    url: "<?php echo url('/');?>/checkReferralUser",
                    method: 'POST',
                    dataType: "json",
                    data: {'email':email,'_token':token},
                    success: function(data){
                       $("#firstName").val(data.first_name);
                       $("#lastName").val(data.last_name);
                       $("#email_error").html(data.message);
                       $("#form_type").val(data.form_type);
                    }
                });
        });
        $('#shipping_country').select2();

        $("#cancel_order").click(function(e){
            e.preventDefault();
            swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4FC550',
                cancelButtonColor: '#D0D0D0',
                confirmButtonText: 'Yes, cancel order!',
                closeOnConfirm: false
            }).then(function (result) {
                 if (result.value) {
                    $('#status_form').submit();
                }
            }).catch(swal.noop);
        });

        $("#activate_alert").click(function(e){
            e.preventDefault();
            var type = $("#type").val();
            if(type == 2){
                swal({
                    title: 'Are you sure?',
                    text: 'This user already subscribed the package, you want to activate again?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4FC550',
                    cancelButtonColor: '#D0D0D0',
                    confirmButtonText: 'Yes, Activate',
                    closeOnConfirm: false
                }).then(function (result) {
                     if (result.value) {
                        $('#create_form').submit();
                    }
                }).catch(swal.noop);
            }else{
                $('#create_form').submit();
            }
        });
    </script>
    <script>
        CKEDITOR.replace('shipping_address', {
            height: 150
        });
    </script>
<script src="<?php echo url('/public/lightbox/js/lightbox.js')?>" type=""></script>


</body>
</html>
