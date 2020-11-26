<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Payment Success</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @if($userInfo['user_role'] == 4)
       @include("customer.inc.all-styles")
    @else
        @include("inc.styles.all-styles")
    @endIf
    <style type="text/css">
        .cust_name{
            float: left;
        }
        .cust_status{
            float: right;
        }
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

        .cust_status_active {
            float: right;
            background-color: #38B586;
            color: #fff;
            padding: 2px 10px;
            border-radius:2px;
        }
        .cust_status_expiry {
            float: right;
            background-color: #D0021B;
            color: #fff;
            padding: 2px 10px;
            border-radius:2px;
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
        .select_package_drop:focus{
            outline:none;
            box-shadow:none;
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
            <h5 class="font20 font-bold text-uppercase black_txt pt-4 mb-5"><?php echo ($result['status'] == 1) ? 'Payment Successful': 'Payment Failed';?> </h5>

            <div class="clearfix ">
                <div class="row">
                    <div class="col-lg-7 col-xl-5 col-md-10">
                        <div class="row py-2">
                            <div class="col-12">
                            <?php if($result['status'] == 1){?>
                                <img src="<?php echo url('/').'/public/images/success.png';?>" width="50" height="50"/></div>
                                <div class="col-7 font-weight-bold">Thank You!</div>
                            <?php }else if($result['status'] == 0){?>
                                <img src="<?php echo url('/').'/public/images/failure.png';?>" width="50" height="50"/></div>
                                <div class="col-7 font-weight-bold">Sorry!</div>
                            <?php }else if($result['status'] == 2){?>
                                <img src="<?php echo url('/').'/public/images/waiting.png';?>" width="50" height="50"/></div>
                                <div class="col-7 font-weight-bold">Waiting!</div>
                            <?php }?>
                        </div>
                        <div class="row py-2">
                            <div class="col-12">
                                @php
                                if($result['status'] == 1)
                                echo  'Your payment transfer is successful for:-';
                                else if($result['status'] == 0)
                                echo 'Your payment transfer is failed for:-';
                                else 'Your payment transfer is waiting for:-';
                                @endphp
                            </div>
                        </div>

                        <ul class="user_purchase_info">
                            <li>Date</li>
                            <li class="font-weight-bold">:
                                @php
                                    echo \App\Http\Controllers\home\ReportController::convertTimezone($result['date']);
                                @endphp
                            </li>
                            <li>Package</li>
                            <li class="font-weight-bold">: {{ $result['package'] }} </li>
                            @If($result['duration'] != 0)
                            <li>Duration</li>
                            <li class="font-weight-bold">: {{ $result['duration'] }}
                            </li>
                            @endIf
                            <li>Payment Method</li>
                            <li class="font-weight-bold">: {{ $result['payment_method'] }}</li>
                            <li>Payment ID</li>
                            <li class="font-weight-bold">: {{ $result['payment_reference'] }}</li>

                            <div class="div_wrp col-xl-7 mt-5">
                                <p class="m-0">Amount Paid</p>
                                <p class="font-weight-bold f24 m-0">
                                    @If(!empty($result['amount_in_crypto']) && $result['amount_in_crypto']!=0)
                                    {{ "$".$result['amount_in_usd'] }} USD <br/>{{ $result['amount_in_crypto'] }} {{ $result['payment_mode'] }}
                                    @else
                                        {{ "$".$result['amount_in_usd']." USD" }}
                                    @endIf
                                </p>
                            </div>
                        </ul>

                        <div class="my-4">
                            <div class="display_inline">
                                <button class="btn btn_primary btn_cancel d-block w-100 mt-4 white_txt" ><a href="<?php echo url('/').'/transactions'; ?>" class="white_txt">VIEW TRANSACTIONS</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
			swal(
				'Success',
				'<?php echo Session::get('message');?>',
				'success'
			)
		</script>
	<?php
		}
	?>

</body>
</html>
