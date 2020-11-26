<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Withdraw</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style type="text/css">
        .withdraw_input_wrap .currency_wrp {
             top: 29px;
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
            <!-- <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Commission Report Details</h5> -->
            <ol class="breadcrumb pl-0">
                <i class="fas fa-chevron-left"></i>
                <li class="breadcrumb-item"><a href="<?php echo url('/transactions');?>">Transactions</a></li>
                <li class="breadcrumb-item active">Withdrawal</li>
            </ol>

            <div id="err_msg" class="f16" style="color:red"></div>
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Withdrawal</h5>
            <div class="col-lg-5 col-md-7 pl-0">
                <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/saveWithdrawal';?>">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                     <input type="hidden" name="walletType" id="walletType" value="5">
                     <input type="hidden" name="selected_wal" id="selected_wal">

                    <div class="form-group" id="rsoag">
                        <div class="grid__spans-25" >
                        <label for="inputEmail4" class="d-block font-bold">User Name</label>
                            <select id="username" name="username" style="width:100%;">
                                <option value="">Select Name</option>
                                <?php
                                    foreach ($customers_data as $key => $value) {
                                    ?>
                                        <option value='<?php echo $value->rec_id;?>' data-name="<?php echo $value->first_name.' '.$value->last_name?>"><?php echo $value->first_name." ".$value->last_name." (".$value->user_id.")";?></option>";
                                <?php    }
                                ?>
                            </select>
                            <div class="f12" style="color:red" id="customerErr"></div>
                        </div>
                    </div>

                    <div class="withdraw_input_wrap">
                        <label for="inputEmail4" class="d-block font-bold">Amount</label>
                        <input type="number" class="form-control withdraw_input" name="withdraw_amt" id="withdraw_amt" placeholder="0.00" required="required">
                        <div class="currency_wrp">
                            usd
                        </div>
                        <div class="wallet_balance_show_div">
                            <h6 class="font-bold dark-grey_txt">Wallet Balance</h6>
                            <h1 class="font-bold blue_txt">{{ number_format($wallet_balance->amount,2) }} USD</h1>
                        </div>
                        <div class="f12" style="color:red" id="amountErr"></div>
                    </div>

                    <div class="mt-5">
                        <a href="<?php echo url('/transactions');?>" class="btn btn_cancel mr-3">CANCEL</a>
                        <button class="btn btn_primary" data-toggle="modal" id="proceed_btn">PROCEED</button>
                    </div>
                </form>
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
<script type="text/javascript">
	$('#username').select2();

    $("#username").change(function(){
        var name = $(this).children("option:selected").attr('data-name');
        $("#selected_wal").html(name);
    });

    $("#proceed_btn").click(function(e){
        e.preventDefault();
        $("#withdraw_amt").blur();
        var walletType = $("#walletType").val();
        var withdraw_amt = $("#withdraw_amt").val();
        var customer_id = $("#username").val();
        var user_name = $("#selected_wal").val();

        if (customer_id == '') {
            $("#customerErr").html('User Name Required');
            return false;
        } else {
            $("#customerErr").html('');
        }
        if(withdraw_amt < 1){
            $("#amountErr").html("Withdraw amount should be greater than or equal 1 USD");
            return false;
        }
        setTimeout(function(){
            swal({
                    title: 'Are you sure?',
                    //text: "Your withdrawal <b>"+withdraw_amt+" USD</b> will be transafer to user <b>"+user_name+"</b> wallet.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4FC550',
                    cancelButtonColor: '#D0D0D0',
                    confirmButtonText: 'Yes, proceed it!',
                    closeOnConfirm: false,
                    html: "Your withdrawal <b>"+withdraw_amt+" USD</b> will be transfer to user </br><b>"+user_name+"</b> wallet."
                }).then(function (result) {
                     if (result.value) {
                        $("#create_form").submit();
                    }
                }).catch(swal.noop);
         },100);
    });

	 // Ok Btn msg
	$(".OkBtnNew").on('click', function(e) {
		e.preventDefault();
		$('#successModel').modal('hide');
		window.location.reload();
	});
</script>
