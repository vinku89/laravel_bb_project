<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Tracking Order</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style>

		.select2-container .select2-selection--single{
            height:44px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height:42px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top:10px !important;
            right:10px !important;
		}
        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
        }
		ul{
			text-align: left;
			line-height: 25px;
			font-size: 16px;
			text-decoration: none;
		}
    </style>

</head>

<body>
    <!-- <div class="overlay-bg"></div> -->
    <!-- Side bar include -->
     @include("inc.sidebar.sidebar")
    <div class="main-content commission_report_details">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <!-- <ol class="breadcrumb pl-0">
                <i class="fas fa-angle-left"></i>
                <li class="breadcrumb-item active f16" aria-current="page" class="f16">Tracking Order</li>
            </ol> -->
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Tracking Order</h5>
            <div class="col-lg-5 col-md-7 pl-0">
                <form method="post" id="tracking_order_form" name="tracking_order_form" action="<?php echo url('/').'/sendTrakingDetailsToCustomer';?>">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group" id="rsoag">
                        <div class="grid__spans-25">
                        <label for="inputEmail4" class="d-block font-bold">User Name</label>
                            <select id="username" name="username" class="test">
                                <option value="">Select Name</option>
                                <?php
                                    foreach ($customers_data as $key => $value) {
                                    ?>
                                        <option value='<?php echo $value->rec_id;?>' data-name="<?php echo $value->first_name.' '.$value->last_name?>" data-order-id="<?php echo $value->order_id;?>"><?php echo $value->first_name." ".$value->last_name." (".$value->user_id.")";?></option>";
                                <?php    }
                                ?>
                            </select>
                            <div id="err_msg_customer" class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail4" class="d-block font-bold">Order Number</label>
                        <div class="withdraw_input_wrap">
                            <input type="text" class="form-control readonly_input" id="order_number" name="order_number" id="order_number" placeholder="Tracking number" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail4" class="d-block font-bold">Tracking Number</label>
                        <div class="withdraw_input_wrap">
                            <input type="text" class="form-control tracking_id" name="trackingId" id="trackingId" placeholder="Tracking number">
                            <div id="err_msg_trackingId" class="error"></div>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" id="order_id">
                    <div class="mt-5">
                        <a href="<?php echo url('/transactions');?>" class="btn btn_cancel mr-3">CANCEL</a>
                        <button class="btn btn_primary" id="proceed_btn">PROCEED</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
     @include("inc.scripts.all-scripts")

     <?php
        if(Session::has('alert') && Session::get('alert') == 'Failure'){
    ?>
        <script type="text/javascript">
            swal(
                'Failure',
                '<?php echo Session::get('result');?>',
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
                '<?php echo Session::get('result');?>',
                'success'
            )
        </script>
    <?php
        }
    ?>

</body>

</html>
<script type="text/javascript">

    $('#username').select2({
          selectOnClose: true
        });

    $("#proceed_btn").click(function(e){
            e.preventDefault();
            var  error = false;
            $("#transfer_amount").blur();
            var trackingId = $.trim($("#trackingId").val());
            var customer_id = $.trim($("#username").val());
            var order_id = $.trim($("#order_id").val());

            if(customer_id == ""){
                $("#err_msg_customer").html("Please select user name");
                error = true;
            }else{
                $("#err_msg_customer").html("");
            }

            if(trackingId == ''){
                $("#err_msg_trackingId").html("Tracking number is required");
                error = true;
            }else{
                $("#err_msg_trackingId").html("");
            }
            if(!error){
                if(order_id == ''){
                    swal(
                        'Failure',
                        'Order id is required',
                        'error'
                    )
                    error = true;
                }
            }

            if(!error){
                $("#tracking_order_form").submit();
            }else{
                return false;
            }
        });

    $("#username").change(function(){
            var order_id = $(this).children("option:selected").attr('data-order-id');
			$("#order_number").val(order_id);
            $("#order_id").val(order_id);
        });
</script>
