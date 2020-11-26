<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Multibox</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- Styles -->
    <link href="<?php echo url('/');?>/public/css/customer/app.css" rel="stylesheet">
    <link href="<?php echo url('/');?>/public/css/customer/bsnav.css" rel="stylesheet">
    <!-- All old styles include -->
    @include("customer.inc.v2.all-styles")
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
    <!-- for tracking -->
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
    @include('inc.v2.sidenav')

    <div class="main-wrap w-100">
        <div class="container-fluid">
            @include('inc.v2.headernav')

            <!-- border -->
            <hr class="grey-dark">

            <div class="row">
                <section class="main_body_section scroll_div">

            <h5 class="font20 font-bold text-uppercase black_txt pt-4 mb-5">Add New Box</h5>

            <h6 class="font18 purple_txt font-bold">Please choose below package to create your new subscription.</h6>

            <div class="clearfix ">
                <div class="row">
                    <div class="col-lg-7 col-xl-5 col-md-10">
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/saveRenewal';?>">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" value="{{ $rec_id }}" id="renewal_id" name="renewal_id">
                        <input type="hidden" id="subscription_type" name="subscription_type" value="New">

                        <h3 class="font16 font-bold text-uppercase black_txt pt-4 mb-4">BestBOX Package</h3>

                        <div class="form-group">
                            <div class="select-test">
                                <input type="hidden" name="package" id="package" value="">
                                <input type="hidden" name="package_amount" id="package_amount" value="">
                                <button class="select_package_drop">
                                    <span>Select</span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="f16 package_list">
                                    <li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">
                                        Select Package
                                    </li>
                                    @foreach ($package_data as $val)
                                        <li value="{{ $val->id }}" data-name="{{ $val->package_name }}" data-desc="{{ $val->description }}" data-package="{{ $val->id }}" data-amt="{{ $val->effective_amount }}" class="text-left border-top-purple" style="display: table; width: 100%;">
                                            <div class="border-right-purple p-3" style="display: table-cell; width: 70%;">
                                                <div class="" style="font-weight: 700;">{{ $val->package_name }}</div>
                                            <div> {{ $val->description }}</div>
                                            </div>
                                            <div class="p-3 font-bold" style="display: table-cell; width: 30%;">${{ $val->effective_amount }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="f12" style="color:red" id="packageErr"></div>

                            </div>
                        </div>

                        <!-- Pre Buy -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <div class="f16 font-bold color-black p-2">
                                        <div class="mb-2">Activation Period</div>
                                        <div class="mb-2">{{ date("d/m/Y") }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <div class="f16 font-bold purple-bordered">
                                        <div class="color-black mb-2">Wallet Balance</div>
                                        <div class="purple_txt mb-2">${{ number_format($wallet_balance->amount,2) }}</div>
                                        <input type="hidden" value="{{ $wallet_balance->amount }}" id="user_wallet_amt" name="user_wallet_amt">
                                    </div>
                                </div>
                            </div>

                           </div>

                            <div class="col-12 mt-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="pay" id="pay" class="form-check-input" style=" width: inherit;" disabled>
                                    <label class="form-check-label payfor_friend" for="exampleCheck1">Proceed payment from my BestBOX wallet</label>
                                </div>
                            </div>

                        <div id="subsErr" class="error"></div>
                        <input type="hidden" name="chkboxvalue" id="chkboxvalue" value="new">

                        <!-- Post Buy -->
                        <div class="row d-none">
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <div class="f16 color-black p-2">
                                        <div class="font-bold mb-2">Activation Period</div>
                                        <div class="mb-2">5/4/2019 - 5/7/2019</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <div class="f16 font-bold grey-bordered">
                                        <div class="color-black mb-3">Status</div>
                                        <div class="label_active mx-auto mb-2">Active</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Auto complete -->
                        <div class="d-none">
                            <div class="autocomplete-drop-down mt-4">
                                <div class="countries-input-container">
                                <input class="countries-input" placeholder="Enter Name" type="text">
                                <div class="input-underline"></div>
                                <span class="input-arrow">&#9662;</div>
                            </div>

                            <div class="countries-list-container">
                                <ul class="countries-list">
                                    <li>&nbsp;</li>
                                </ul>
                            </div>
                        </div>

                        <div class="my-4">
                            <div class="display_inline">
                                <a href="<?php echo url('/transactions');?>" class="btn_cancel">
                                    CANCEL
                                </a>
                            </div>

                            <div class="display_inline">
                                 <button class="btn btn_primary btn_cancel d-block w-100 mt-4" id="proceed_btn" >PROCEED</button>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </section>
            </div>
        </div>
    </div>

     @include('inc.v2.footer')
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

    $('.menucheck').on('change', function() {
        $("#chkboxvalue").val($(this).attr('id'));
        if ($(this).is(":checked")) {
            $('.menucheck').not(this).prop('checked', false);
        }
        else{
            $('.menucheck').not(this).prop('checked', true);
        }
    });

        $(function () {

            var select = $(".select-test");
            select.select({
                selected: 0,
                //animate: "slide"
            });
        });

        $("#proceed_btn").click(function(e){
            e.preventDefault();
            var package = $("#package").val();
            if (package == '') {
                $("#packageErr").html('Package is Required');
                return false;
            } else {
                $("#packageErr").html('');
            }

            swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4FC550',
                cancelButtonColor: '#D0D0D0',
                confirmButtonText: 'Yes, proceed it!',
                closeOnConfirm: false,
                html: "New subscription with new account creation."
            }).then(function (result) {
                 if (result.value) {
                    $("#create_form").submit();
                }
            }).catch(swal.noop);
        });


        /* select box*/
        $(document).ready(function()
        {
            $('ul.package_list li').click(function(e)
            {
                $('#pay').attr('checked', true);
                var amount = $(this).attr('data-amt');
                var user_wallet_amt = $("#user_wallet_amt").val();
                if(parseFloat(amount) > parseFloat(user_wallet_amt)){
                        swal(
                            'Failure',
                            'Insufficient Balance In Your Wallet',
                            'error'
                        )
                        setTimeout(function() {
                            $(".select-test span:first").html('<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>');
                        }, 50);
                    }
                    else{
                        var package_id = $(this).attr('data-package');
                        if(package_id == ""){
                            setTimeout(function() {
                                $(".select-test span:first").html('<li value="" data-package="" data-amt="" class="text-left" style="display: table; width: 100%;">Select Package</li>');
                            }, 50);
                        }else{
                            $("#package").val(package_id);
                            $("#package_amount").val(amount);
                            var package_name = $(this).attr('data-name');
                            var package_desc = $(this).attr('data-desc');
                            setTimeout(function() {
                                $(".select-test span:first").html('<div class="p-1" style="width: 100%;background-color:#fff;"><div class="float-left" style="width:75%"><div style="font-weight: 700;">'+package_name+'</div><div>'+package_desc+'</div></div><div class="float-right font-bold pr-2 pt-3">$'+amount+'</div></div>');
                            }, 50);
                        }
                    }
            });
        });
</script>
</body>

</html>
