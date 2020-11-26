<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Update Order</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include('inc.styles.all-styles')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> --}}
    <style>
        .swal2-content ul{
                margin: 0 50px;
        }

        .swal2-content ul li{
            text-align: left;
            line-height: 35px;
        }
        .mw-450 {
            max-width: 450px;
        }
        label[for="file-upload"] {
            padding: 0.5em;
            display: inline-block;
            cursor: pointer;
            max-width: 120px;
            text-align: center;
            background: #7B7B7B;
            border: 1px solid #979797;
            border-radius: 5px;
            color: #fff;
            vertical-align: middle;
            line-height: 0;
            margin-right: 20px;
        }
        #filename {
            padding: 0.5em;
            float: none;
            max-width: 305px;
            white-space: nowrap;
            overflow: hidden;
            background: #fff;
            margin-left: 20px;
            background: #FFFFFF;
            border: 1px solid #979797;
            border-radius: 5px;
        }
        .order-upload {
            position: absolute;
            left: -9999px;
        }
        .select2-container .select2-selection--single {
            height: 44px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px;
        }
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
        .orderBtn {
            position: absolute;
            left: 500px;
            top: 12px;
        }
        .top{
            top:-11px !important;
        }
        .package_list{
            overflow:hidden;
            overflow-y:auto;
            height:300px;
        }
        .caret{
            top: 24px !important;
            right: 15px;
        }

        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
        }
         .body_bg .dk-select-options {
            color: #495057;
            font-size: 13px;
            min-height: 100px;
            max-height: 300px;
            overflow-y: auto;
        }
        .dk-option {
            padding: 5px 0.5em;
            border-bottom: solid 1px #E3ECFB;
            font-size: 16px;
        }
        .select-x ul li{
            border-bottom: solid 1px #0096da;
        }
        .select-x ul li:last-child{
            border-bottom: none;
        }
        .select-x ul.open{
            margin-bottom:50px;
        }

        .package_selection{
            min-height:50px;
            max-height:100px;
        }

        ul{
            text-align: left;
            line-height: 25px;
            font-size: 16px;
            text-decoration: none;
        }
        .form_bg5{
            background-color:#B8D0E9;
            padding: 25px 20px;
        }
        .form_bg6{
            background-color:#ffffff;
            padding:10px;
            border:solid 1px #0096DA;
            border-radius:5px;
        }
        .select-x button{
            border:solid 1px #0096DA !important;
            border-radius:5px;
        }
    </style>
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <div class="position-relative">
            <h3 class="font22 font-bold black_txt py-3 black_txt">Update Order</h3>
            <a href="{{ url('/updatedOrdersList') }}" class="btn_primary orderBtn d-md-block d-none">Order History</a>
                <p class="py-4 black_txt f16">
                    Please update your payment order to process your activation.
                </p>
                <form class="form-width2" id="updateOrderDetailsForm" name="updateOrderDetailsForm" method="post"
                    enctype="multipart/form-data" action="<?php echo url('/').'/updateCustomerOrderFromAdmin';?>">
                    @csrf
                    <input type="hidden" name="type" id="type" value="{{ $type }}">
                    <input type="hidden" name="selected_wal" id="selected_wal">
                    <div class="form-group mb-4" id="rsoag">
                        <div class="grid__spans-25">
                            <label for="inputEmail4" class="d-block font-bold">Customer Name</label>
                            <select id="username" name="username" style="width:100%;">
                                <option value="">Select Name</option>
                                <?php
                                    foreach ($customers_data as $key => $value) {
                                    ?>
                                <option value='<?php echo $value->rec_id;?>'>
                                    <?php echo $value->first_name." ".$value->last_name." (".$value->user_id.")";?>
                                </option>
                                <?php
                                        }
                                ?>
                            </select>
                            <div class="f12" style="color:red" id="customerErr"></div>
                        </div>
                    </div>
                    <div class="col-12 subcribe_wrp mb-3" id="subscribe_options" style="display: none;">
                        <div class="col-12">
                            <div class="row border-bottom-blue py-2">
                                <div class="col-9 orange_txt font-weight-bold">
                                        New Subscription
                                    </div>
                                    <div class="col-3 text-right">
                                        <label class="switch">
                                            <input type="checkbox" name="subscription_type" class="menucheck" id="new" value="New">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                            </div>

                        </div>
                        <div class="col-12">
                        <div class=" row py-2">
                                <div class="col-9 orange_txt font-weight-bold">
                                    Renewal Subscription
                                </div>
                                <div class="col-3 text-right">
                                    <label class="switch">
                                        <input type="checkbox" name="subscription_type" class="menucheck" id="renew" value="Renewal">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                        </div>
                        </div>
                    </div>
                    <div id="subsErr" class="error"></div>
                    <input type="hidden" name="chkboxvalue" id="chkboxvalue">
                    <div class="form_bg5">
                        <div class="form-group">
                           <div class="select-test">
                               <label for="exampleInputEmail1" class="font-bold black_txt">BestBOX Package</label>
                               <input type="hidden" name="package" id="package" value="">
                               <input type="hidden" name="package_amount" id="package_amount" value="">
                               <input type="hidden" name="check_setupbox_status" id="check_setupbox_status" value="">
                               <button class="package_selection" disabled>
                                   <span>Select</span>
                                   <span class="caret"></span>
                               </button>
                               <ul class="f16 package_list">
                                   <li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">
                                       Select Package
                                   </li>
                                </ul>
                           </div>
                           <div class="f12" style="color:red" id="packageErr"></div>
                       </div>
                       <!-- Pre Buy -->
                       <div class="form_bg6">
                        <label for="exampleInputEmail1" class="font-bold black_txt">Payment Method</label>
                             <div class="col-12 mt-4 pl-0" >
                                <div class="form-group form-check">
                                    <input type="radio" name="pay" id="exampleCheck1" data-value='aliexpress' value="Ali Express" class="payment form-check-input" style=" width: inherit;">
                                    <label class="form-check-label payfor_friend" for="exampleCheck1">VISA / MASTERCARD (ALI EXPRESS)
                                    <span class="pl-3"><img src="{{ url('/') }}/public/customer/images/cards.png?q=<?php echo rand();?>" style="width:100px;"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 mt-4 pl-0" >
                                <div class="form-group form-check">
                                    <input type="radio" name="pay" id="exampleCheck2" data-value='bankpayment' value="BANK PAYMENT" class="payment form-check-input" style=" width: inherit;">
                                    <label class="form-check-label payfor_friend" for="exampleCheck2">Nigeria or Ghana based bank payments</label>
                                </div>
                            </div>
                            <div class="col-12 mt-4 pl-0" >
                                <div class="form-group form-check">
                                    <input type="radio" name="pay" id="exampleCheck3" data-value='bitpay' value="BITPAY" class="payment form-check-input" style=" width: inherit;">
                                    <label class="form-check-label payfor_friend" for="exampleCheck3">Crypto Currency Payment</label>
                                </div>
                            </div>
                            <div class="f12" style="color:red" id="paymethodErr"></div>
                    </div>                
                    </div>
                                        
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="font-bold black_txt">* Enter Payment ID /
                            Reference</label>
                        <input type="text" class="form-control border-bottom-only body_bg mt-3" id="order_id"
                            name="order_id" aria-describedby="Payment ID" placeholder="Payment ID / Reference"
                            value="">
                        <div class="f12" style="color:red" id="paymentIdErr"></div>
                    </div>
                    <div class="font-bold black_txt mt-5">Upload attachment</div>
                    <div class=" d-table w-100 my-3">
                        <label for="file-upload" class="d-table-cell w30">Choose file<input type="file" id="file-upload"
                                name="invoice_attachment" accept="image/*,application/pdf"
                                class="order-upload "></label>
                        <div class="d-table-cell w5"></div>
                        <span id="filename" class="d-table-cell w65">No file choosen</span><div>&nbsp;</div>

                    </div>
                    <div class="f12" style="color:red" id="attachmentErr"></div>
                    <div class="text-center f12 black_txt mt-3">Allowed file type : jpg, jpeg, png and PDF. maximum file
                        size : 2MB</div>
                    <!-- <div class="form-group">
                        <label for="exampleInputEmail1" class="font-bold black_txt">Ali express Email ID</label>
                        <input type="text" class="form-control border-bottom-only body_bg mt-3" id="ali_express_email"
                            name="ali_express_email" aria-describedby="Ali express Email ID" placeholder="Ali express Email ID"
                            value="">
                        <div class="f12" style="color:red" id="aliexpressemailIdErr"></div>
                    </div> -->
                    <div id="shipping_addr" style="display: none;">
                            <div class="text-center my-2 f14 font-bold color-black">Shipping Address</div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="font-bold black_txt">* Address</label>
                                <textarea id="shipping_address" name="shipping_address" rows="10" data-sample-short></textarea>
                                <div class="f12 mt-3 red_txt" id="shipAddrErr"></div>
                            </div>

                            <!-- Country -->
                            <div class="mobile_menu_section body_bg form-group">
                                <select id="select_country3" name="shipping_country">
                                    <option value="" class="font14">Select Country</option>
                                    <?php
                                        foreach ($country_data as $val) {
                                            echo "<option value='".$val->countryid."' data-id='".$val->currencycode."'>".$val->country_name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                                <div id="country_err" class="f14 red_txt"></div>
                            </div>

                            <!-- Mobile Number -->
                            <div class="form-group row">
                                <div class="col-3">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only  body_bg"
                                            placeholder="code" aria-label="Mobile number"
                                            aria-describedby="basic-addon2" value="{{ old('shipping_country_code') }}" name="shipping_country_code" id="shipping_country_code" readonly>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only  body_bg" placeholder="Mobile Number" aria-label="Mobile number"  aria-describedby="basic-addon2" id="shipping_user_mobile_no" name="shipping_user_mobile_no" value="{{ old('shipping_user_mobile_no') }}" maxlength="14" pattern="[0-9]{8,14}">
                                        <div class="text-right f14 w-100 pt-2">
                                            <span id="telErrorMsg" class="f14 error_txt"></span>
                                            <span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Mobile number</span>
                                        </div>
                                        <div class="invalid-feedback">
                                             Please Provide Correct Mobile Number.
                                        </div>
                                    </div>
                                    <div id="mobile_no_err" class="f14 red_txt"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="subs_type" name="subs_type">

                    <div class="my-5">
                        <div class="display_inline mr-2">
                            <a href="{{ url('/customerActivation') }}" class="btn_cancel">
                                CANCEL
                            </a>
                        </div>
                        <div class="display_inline">
                            <button type="submit" class="btn_primary d-block w-100 mt-4 "
                                id="proceed_btn">SAVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

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
            swal(
                'Success',
                '<?php echo Session::get('message');?>',
                'success'
            )
        </script>
    <?php
        }
    ?>
    <script>
        /* select box*/
    var html = '';var html2 ='';
    $(document).ready(function()
        {
            html += '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>';
            html2 += '<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>';
            <?php foreach ($package_data as $val) {?>
                var id = '<?php echo $val->id;?>';
                var setupbox_status = '<?php echo $val->setupbox_status;?>';
                var amount = '<?php echo $val->effective_amount;?>';
                var package_name = '<?php echo $val->package_name;?>';
                var description = '<?php echo $val->description;?>';
                html += '<li value="'+id+'" data-box="'+setupbox_status+'" data-package="'+id+'" data-amt="'+amount+'" data-name="'+package_name+'" data-desc="'+description+'" class="text-left" style="display: table; width: 100%;">';
                    html += '<div class="border-right-blue p-3" style="display: table-cell; width: 70%;">';
                        html += '<div class="" style="font-weight: 700;">'+package_name+'</div>';
                        html += '<div>'+description+'</div>';
                    html += '</div>';
                    html += '<div class="p-3 font-bold" style="display: table-cell; width: 30%;">'+amount+' USD</div>';
                html += '</li>';
            <?php }?>
            <?php foreach ($package_data as $val) {?>
                var id = '<?php echo $val->id;?>';
                var setupbox_status = '<?php echo $val->setupbox_status;?>';
                var amount = '<?php echo $val->effective_amount;?>';
                var package_name = '<?php echo $val->package_name;?>';
                var description = '<?php echo $val->description;?>';
                <?php if($val->setupbox_status == 2) {?>
                    html2 += '<li value="'+id+'" data-box="'+setupbox_status+'" data-package="'+id+'" data-amt="'+amount+'" data-name="'+package_name+'" data-desc="'+description+'" class="text-left" style="display: table; width: 100%;">';
                            html2 += '<div class="border-right-blue p-3" style="display: table-cell; width: 70%;">';
                                    html2 += '<div class="" style="font-weight: 700;">'+package_name+'</div>';
                                    html2 += '<div>'+description+'</div>';
                            html2 += '</div>';
                            html2 += '<div class="p-3 font-bold" style="display: table-cell; width: 30%;">'+amount+' USD</div>';
                    html2 += '</li>';
                <?php }
            }?>
        });
        $('body').on('click', 'ul.package_list li', function(){
            $('#pay').attr("disabled", false);
            $('#pay').attr('checked', true);
            var amount = $(this).attr('data-amt');
            var setupbox_status = $(this).attr('data-box');
            console.log(setupbox_status);
            $("#check_setupbox_status").val(setupbox_status);
            if(setupbox_status == 1){
                $("#shipping_user_mobile_no").prop('required',true);
                $("#shipping_addr").css('display','block');
            }else{
                $("#shipping_user_mobile_no").prop('required',false);
                $("#shipping_addr").css('display','none');
            }

            $(".select_package_drop").addClass('sel_pack');
            var package_id = $(this).attr('data-package');
            $("#package").val(package_id);
            $("#package_amount").val(amount);
            var package_name = $(this).attr('data-name');
            var package_desc = $(this).attr('data-desc');
            setTimeout(function() {
                $(".select-test span:first").html("<div class='p-1 clearfix' style='width: 100%;background-color:#fff;'><div class='float-left' style='width:75%'><div style='font-weight: 700;'>"+package_name+"</div><div>"+package_desc+"</div></div><div class='float-right font-bold pr-4 pt-2'>$ "+amount+"</div></div>");
            }, 50);

        });

    </script>

    <script>

        $(document).ready(function()  {
            var select = $(".select-test");
            select.select({
                selected: 0,
                //animate: "slide"
            });
        });

    $('.menucheck').on('change', function() {
        $("#chkboxvalue").val($(this).attr('id'));

        if ($(this).is(":checked")) {

            $(".package_selection").prop("disabled", false);
            var subscription_type = $(this).attr('id');
            $('.menucheck').not(this).prop('checked', false);
            console.log(subscription_type);
            if(subscription_type == 'new') {
                $(".package_list").html(html);
            }else{
                $(".package_list").html(html2);
            }
        }
        else{
            $('.menucheck').not(this).prop('checked', true);
        }
        $(".select-test span:first").html("<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>");
    });

        $("#file-upload").change(function () {
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'pdf'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $("#attachmentErr").html('Please Upload only JPEG,JPG,PNG or PDF formats only');
                return false;
            } else if (this.files[0].size > 2097152) {
                $("#attachmentErr").html('File size is larger than 2MB!');
                return false;
            }
        });
        $("#proceed_btn").on("click", function (e) {
            e.preventDefault();
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            //var formData = new FormData(this);
            var order_id = $("#order_id").val().trim();
            var customer_name = $("#username").val().trim();
            var user_name = $("#selected_wal").val();
            var package = $("#package").val();
            var payment_method = $("input[name='pay']:checked").val();
            var aliexpress_email = $.trim($("#ali_express_email").val());
            var shipping_address = $.trim(CKEDITOR.instances['shipping_address'].getData());
            var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var error = false;
            if (customer_name == '') {
                $("#customerErr").html('Customer Name Required');
                error = true;
            } else {
                $("#customerErr").html('');
            }
            if (package == '') {
                $("#packageErr").html('Select Package');
                error = true;
            } else {
                $("#packageErr").html('');
            }
            var subs_type = $("#subs_type").val();
           if(subs_type == 2){
	            if ($('.menucheck').is(":checked")) {
	                $("#subsErr").html('');
	            }
	            else{
	                $("#subsErr").html('Select subscription type');
	                error = true;
	            }
	            var chkboxvalue = $("#chkboxvalue").val();
	            if(chkboxvalue == 'new'){
	            	var html = "New subscription with sub user creation for customer (<b>"+user_name+"</b>)";
	            }else{
	            	var html = "Renewal subscription for customer (<b>"+user_name+"</b>)";
	            }
	        }else{
	        	var html = "New subscription for customer (<b>"+user_name+"</b>)";
            }
            if (order_id == '') {
                $("#paymentIdErr").html('Payment ID Required');
                error = true;
            } else {

                var csrf_Value = "<?php echo csrf_token(); ?>";
                $.ajax({
                    type: 'POST',
                    url: "<?php echo url('/');?>/checkOrderIdExistsOrNot",
                    data: {'_token':csrf_Value,'order_id':order_id},
                    dataType: "json",
                    success: function (data) {
                        if(data.status == 'Success'){
                            $("#paymentIdErr").html('');
                        }else{
                            $("#paymentIdErr").html(data.Result);
                            error = true;
                            console.log(error);
                        }
                    }
                });
            }

            var fileName = $("#file-upload").val();
            if(fileName!='') {
                var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
                if ($.inArray(fileName.split('.').pop().toLowerCase(), fileExtension) == -1) {
                    $("#attachmentErr").html('Please Upload only JPEG,JPG,PNG or PDF formats only');
                    error = true;
                } else {
                    $("#attachmentErr").html('');
                }
            }

            if($("#check_setupbox_status").val() == 1){
                if (shipping_address == '') {
                    $("#shipAddrErr").html('Shipping Address Required');
                    error = true;
                } else {
                    $("#shipAddrErr").html('');
                }
                var country = $("#select_country3").val();
                if(country == ""){
                    $("#country_err").html("Please select country");
                    error = true;
                }else{
                    $("#country_err").html("");
                }
                var shipping_user_mobile_no = $("#shipping_user_mobile_no").val();
                if(shipping_user_mobile_no == ""){
                    $("#mobile_no_err").html("Please select Mobile No");
                    error = true;
                }else if(/^\d{8,14}$/.test(shipping_user_mobile_no) == false){
                    $("#mobile_no_err").html("Please enter valid mobile number");
                    error = true;
                }else{
                    $("#mobile_no_err").html("");
                }
            }
            
            if (!$("input[name='pay']:checked").val()) {
                $("#paymethodErr").html('Select payment method');
                error = true;
            }else{
                $("#paymethodErr").html("");
            }

            var subs_type = $("#subs_type").val();
            if(subs_type == 2){
                if ($('.menucheck').is(":checked")) {
                    $("#subsErr").html('');
                } else {
                    $("#subsErr").html('Select subscription type');
                    error = true;
                }
                var chkboxvalue = $("#chkboxvalue").val();
                if(chkboxvalue == 'new'){
                    var html = "New subscription with sub user creation for customer (<b>"+user_name+"</b>)";
                }else{
                    var html = "Renewal subscription for customer (<b>"+user_name+"</b>)";
                }
            }else{
                var html = "New subscription for customer (<b>"+user_name+"</b>)";
            }
            setTimeout(function(){
                if (!error) {
                    swal({
                        title: 'Are you sure?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4FC550',
                        cancelButtonColor: '#D0D0D0',
                        confirmButtonText: 'Yes, proceed!',
                        closeOnConfirm: false,
                        html: html
                    }).then(function (result) {
                        if (result.value) {
                            $("#updateOrderDetailsForm").submit();
                        }
                    }).catch(swal.noop);
                }
            },500);
        });
        $('#username').select2();
        $("#cls_modal").click(function () {
            location.href = "<?php echo url('/customerActivation');?>";
        });

        $("#username").change(function(){
            var name = $(this).children("option:selected").text();
            $("#selected_wal").val(name);

            var id = $(this).val();
            var csrf_Value = "<?php echo csrf_token(); ?>";
            $.ajax({
                    type: 'POST',
                    url: "<?php echo url('/');?>/checkPackagePurchase",
                    data: {'_token':csrf_Value,'id':id},
                    dataType: "json",
                    success: function (data) {
                        if(data.status == 'Success'){
                            $("#subs_type").val('2');
                        }else{
                            $("#subs_type").val('1');
                        }
                        if(data.sub_user == 1){
                            $("#new").attr("disabled", true);
                            $("#renew").attr("disabled", true);
                            $("#renew").prop('checked', true);
                            $("#new").prop('checked', false);
                            $("#subscribe_options").css('display','block');
                            $(".package_selection").prop("disabled", false);
                            $(".package_list").html(html2);
                            $(".select-test span:first").html("<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>");
                        }else{
                            $("#new").removeAttr("disabled");
                            $("#renew").removeAttr("disabled");
                            $("#subscribe_options").css('display','block');
                            $(".package_selection").prop("disabled", false);
                            $(".package_list").html(html2);
                            $(".select-test span:first").html("<li value='' data-package='' data-amt='' class='text-left' style='display: table; width: 100%;'>Select Package</li>");
                        }
                    }
                });

        });
    </script>
    <script>
        $('#file-upload').change(function () {
            var filepath = this.value;
            var m = filepath.match(/([^\/\\]+)$/);
            var filename = m[1];
            $('#filename').html(filename);
        });
    </script>
    <script>

        CKEDITOR.replace('shipping_address', {
            height: 150
        });
    </script>
    <script>
    $('input[name="prev_addr"]').change(function () {
        var csrf_Value = "<?php echo csrf_token(); ?>";
        var customer_name = $("#username").val().trim();
        if (this.checked) {
            $.ajax({
            type: 'POST',
            url: "<?php echo url('/');?>/getShippingAddress",
            data: { 'rec_id' : customer_name ,"_token": csrf_Value },
            dataType: "json",
            success: function (data) {
                CKEDITOR.instances['shipping_address'].setData(data.result);
            }
            });
        }else{
            CKEDITOR.instances['shipping_address'].setData('');
        }
    });

    $('#select_country3').select2();

    $("#select_country3").change(function(e) {
        var country_code =  $('option:selected', this).attr('data-id');
        $("#shipping_country_code").val('+'+country_code);
    });
    $("#shipping_user_mobile_no").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    </script>
</body>
</html>
