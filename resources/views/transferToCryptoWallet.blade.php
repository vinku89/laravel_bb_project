<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Transfer To Crypto Wallet</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style type="text/css">
        .withdraw_input_wrap .currency_wrp {
             top: 29px;
        }
        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
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
                <i class="fas fa-angle-left"></i>
                <li class="breadcrumb-item"><a href="<?php echo url('/transactions');?>">Transactions</a></li>
                <li class="breadcrumb-item active">Transfer To Crypto Wallet</li>
            </ol>
            <div class="col-lg-5 col-md-7 pl-0">
                <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/saveWithdrawal';?>">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="form-group ">

                        <div class="grid__spans-25">
                        <label for="inputEmail4" class="d-block font-bold">Crpto Wallet</label>
                        <input type="hidden" name="walletType" id="walletType">
                        <input type="hidden" name="walletName" id="walletName">
                            <select id="withdraw_type" name="withdraw_type" class="test">

                            </select>
                            <div class="f12" style="color:red" id="walletErr"></div>
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

   <!-- Confirmation  -->
   <div class="modal fade" id="proceedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal"
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
                    <strong><span id="wd_amt"></span> USD</strong> will be transfer to <span id="selected_wal"></span>
                    </div>
                </div>

                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="proceed">ok</button>
                    <!-- <button type="button" class="btn inline-buttons-right create-btn" style="width:100%;"><strong>CLOSE</strong></button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Confirmation end -->
</body>

</html>

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


<script type="text/javascript">
	$('#resellerOrAgentName').select2();

     $('#withdraw_type').ddslick({
        data: <?php echo $ddData; ?>,
        width: 300,
        imagePosition: "left",
        selectText: "Select your wallet",
        onSelected: function (selectedData) {
            var val = selectedData.selectedData.value;
			$("#walletType").val(selectedData.selectedData.value);
            $("#walletName").val(selectedData.selectedData.text);
        }
    });

     $("#proceed_btn").click(function(e){
        e.preventDefault();
        $("#withdraw_amt").blur();
        var walletName = $("#walletName").val();
        var withdraw_amt = $("#withdraw_amt").val();
        if(!walletName){
             $("#walletErr").html("Please setup your Crypto Wallet Address");
            return false;
        }
        if(withdraw_amt < 1){
            $("#amountErr").html("Transfer amount should be greater than or equal 1 USD");
            return false;
        }
        $("#wd_amt").html(withdraw_amt);
        $("#selected_wal").html(walletName);
        setTimeout(function(){
            swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4FC550',
                cancelButtonColor: '#D0D0D0',
                confirmButtonText: 'Yes, proceed it!',
                closeOnConfirm: false,
                html: withdraw_amt+" USD will be transfer to <b>"+walletName+"</b>."
            }).then(function (result) {
                 if (result.value) {
                    $("#create_form").submit();
                }
            }).catch(swal.noop);
        },100);
    });
</script>
