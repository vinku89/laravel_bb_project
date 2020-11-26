<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Pending Shipment</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style>
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
        /* .form-control{
            font-weight:bold;
        } */
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

        .data_tableInfo_col{
            word-break: break-all;
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
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left"> Pending shipment</h5>

            <div class="col-12 mb-5 pending_shipment_section px-0">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Pending Shipment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Shipment Details</a>
                        </li>

                    </ul>
                    <?php
                        if($userinfo['admin_login'] == 1){
                            $w1 = 'w6';$w2 = 'w12';$w3 = 'w12';$w4 = 'w20';$w5 = 'w15';$w6 = 'w20';$w7 = 'w15';
                        }else{
                            $w1 = 'w6';$w2 = 'w17';$w3 = 'w17';$w4 = 'w25';$w5 = 'w15';$w6 = 'w20';$w7 = '';
                        }
                    ?>
                <div class="tab-content" id="pills-tabContent">
                    <div class="col-12 data_table clearfix px-0 tab-pane fade show active"  id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        @if($customers_data->count())
                        <div class="data_table_titles clearfix">
                            <div class="{{ $w1 }} title_col">No</div>
                            <div class="{{ $w2 }} title_col">Order Date</div>
                            <div class="{{ $w3 }} title_col">Order No</div>
                            <div class="{{ $w4 }} title_col">Email ID</div>
                            <div class="{{ $w5 }} title_col">Package</div>
                            <div class="{{ $w6 }} title_col">Delivery Address</div>
                            @If($userinfo['admin_login'] == 1)
                            <div class="{{ $w7 }} title_col">Tracking Numbers</div>
                            @endIf
                        </div>
                        @foreach ($customers_data as $key => $value)
                        <div class="data_table_info clearfix">
                            <div class="{{ $w1 }} data_tableInfo_col dataCol_w1 small_dataCol_w1 py-1 row_border_bottom">
                                <div class="mobview_data_table_titles">No</div>
                                <p>{{ $loop->iteration }}</p>
                            </div>
                            <div class="{{ $w2 }} data_tableInfo_col dataCol_w2 small_dataCol_w2 py-1 row_border_bottom">
                                <div class="mobview_data_table_titles">Order Date</div>
                                <p>
                                    @php
                                        $pdate = \App\Http\Controllers\home\ReportController::convertTimezoneDate($value->purchased_date);
                                    @endphp
                                    {{ $pdate }}
                                </p>

                            </div>
                            <div class="{{ $w3 }} data_tableInfo_col dataCol_w3 small_dataCol_w3 py-1 row_border_bottom">
                                <div class="mobview_data_table_titles">Order No</div>
                                <p class="orange_txt font-weight-bold wordBreak-all">{{ $value->order_id }}</p>
                            </div>
                            <div class="{{ $w4 }} data_tableInfo_col dataCol_w4 small_dataCol_w4 py-1 row_border_bottom">
                                <div class="mobview_data_table_titles">Email ID</div>
                                <p class="wordBreak-all">{{ $value->email }}</p>
                            </div>
                            <div class="{{ $w5 }} data_tableInfo_col dataCol_w5 small_dataCol_w5 py-1 row_border_bottom767">
                                <div class="mobview_data_table_titles">Package</div>
                                <p class="redium_blue_txt font-weight-bold">{{ $value->package_name }}</p>
                            </div>
                            <div class="{{ $w6 }} data_tableInfo_col dataCol_w6 small_dataCol_w6 py-1 address_text row_border_bottom567">
                                <div class="mobview_data_table_titles">Delivery Address</div>
                                {!! $value->shipping_address !!}
                            </div>
                            @If($userinfo['admin_login'] == 1)
                            <div class="{{ $w7 }} data_tableInfo_col dataCol_w7 small_dataCol_w7 py-1">
                                <div class="mobview_data_table_titles mb-1"> Tracking Numbers</div>
                                <input class="form-control" type="text" name="tracking_no" id="tracking_no{{ $value->rec_id }}">
                                <div id="err_msg{{ $value->rec_id }}" class="error"></div>
                                <a href="#" id="{{ $value->rec_id }}" data-pdate="{{ $pdate }}" data-package="{{ $value->package_name }}" data-orderno="{{ $value->order_id }}" data-email="{{ $value->email }}" class="table_btn update_tracking">update</a>
                            </div>
                            @endIf
                        </div>
                        @endforeach
                    @else
                        <div class="w100 norecord_txt">No Records Found</div>
                    @endif
                    </div>
                    <div class="col-12 data_table clearfix tab-pane px-0 fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        @if($shipment_details->count())
                    <div class="data_table_titles clearfix">
                        <div class="w6 title_col">No</div>
                        <div class="w12 title_col">Order Date</div>
                        <div class="w12 title_col">Order No</div>
                        <div class="w20 title_col">Email ID</div>
                        <div class="w15 title_col">Package</div>
                        <div class="w20 title_col">Delivery Address</div>
                        <div class="w15 title_col">Tracking Numbers</div>
                    </div>
                        @foreach ($shipment_details as $key => $value)
                    <div class="data_table_info clearfix">
                        <div class="w6 data_tableInfo_col dataCol_w1 small_dataCol_w1 py-1 row_border_bottom">
                            <div class="mobview_data_table_titles">No</div>
                            <p>{{ $loop->iteration }}</p>
                        </div>
                        <div class="w12 data_tableInfo_col dataCol_w2 small_dataCol_w2 py-1 row_border_bottom">
                            <div class="mobview_data_table_titles">Order Date</div>
                            <p>
                                @php
                                    $pdate = \App\Http\Controllers\home\ReportController::convertTimezone($value->purchased_date);
                                @endphp
                                {{ $pdate }}
                            </p>

                        </div>
                        <div class="w12 data_tableInfo_col dataCol_w3 small_dataCol_w3 py-1 row_border_bottom">
                            <div class="mobview_data_table_titles">Order No</div>
                            <p class="orange_txt font-weight-bold wordBreak-all">{{ $value->order_id }}</p>
                        </div>
                        <div class="w20 data_tableInfo_col dataCol_w4 small_dataCol_w4 py-1 row_border_bottom">
                            <div class="mobview_data_table_titles">Email ID</div>
                            <p class="wordBreak-all">{{ $value->email }}</p>
                        </div>
                        <div class="w15 data_tableInfo_col dataCol_w5 small_dataCol_w5 py-1 row_border_bottom767">
                            <div class="mobview_data_table_titles">Package</div>
                            <p class="redium_blue_txt font-weight-bold">{{ $value->package_name }}</p>
                        </div>
                        <div class="w20 data_tableInfo_col dataCol_w6 small_dataCol_w6 py-1 address_text row_border_bottom567">
                            <div class="mobview_data_table_titles">Delivery Address</div>
                            {!! $value->shipping_address !!}
                        </div>

                        <div class="w15 data_tableInfo_col dataCol_w7 small_dataCol_w7 py-1">
                            <div class="mobview_data_table_titles mb-1"> Tracking Numbers</div>
                            <input class="form-control" type="text" value="{{ $value->tracking_number }}" name="tracking_no" id="tracking_no{{ $value->rec_id }}" {{ ($userinfo['admin_login'] != 1 ? 'readonly' : '') }}>
                            <div id="err_msg{{ $value->rec_id }}" class="error"></div>
                            @If($userinfo['admin_login'] == 1)
                            <a href="#" id="{{ $value->rec_id }}" data-pdate="{{ $pdate }}" data-package="{{ $value->package_name }}" data-orderno="{{ $value->order_id }}" data-email="{{ $value->email }}" class="table_btn update_tracking">Edit</a>
                            @endIf
                        </div>

                    </div>
                    @endforeach
                @else
                    <div class="w100 norecord_txt">No Records Found</div>
                @endif
                </div>
                </div>
            </div>

        </section>
    </div>

    <!-- Single Update Modal popup -->
<div class="modal fade" id="singleUpdate" tabindex="-1" role="dialog" aria-labelledby="singleUpdate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content data_modal">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="singleUpdate">Tracking Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-5">
                <div class="mb-4 titleBg">
                    <h6 class="font-weight-bold black_txt">Tracking Number</h6>
                    <h3 class="font-weight-bold green_txt" id="sh_trackingno"></h3>
                </div>
                <ul class="modal_data_wrap">
                    <li>Date</li>
                    <li>: <span id="sh_date"></span></li>
                    <li>Order No</li>
                    <li>: <span class="orange_txt font-weight-bold" id="sh_orderno"></span></li>
                    <li>Email ID</li>
                    <li>: <span id="sh_email"></span></li>
                    <li>Package</li>
                    <li>: <span class="redium_blue_txt font-weight-bold" id="sh_package"></span></li>
                </ul>
            </div>
            <form method="post" action="<?php echo url('/').'/sendTrakingDetailsToCustomer';?>">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="purchased_rec_id" id="purchased_rec_id">
                <input type="hidden" name="tracking_number" id="tracking_number">
                <div class="modal-footer border-top-0 p-0">
                    <button type="submit" class="btn modal_btn">ok</button>
                </div>
            </form>
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
    <script type="text/javascript">

        $(".update_tracking").click(function(e){
            e.preventDefault();
            var  error = false;
            var rec_id = $(this).attr('id');
            var trackingId = $.trim($("#tracking_no"+rec_id).val());
            if(trackingId == ''){
                $("#tracking_no"+rec_id).focus();
                $("#err_msg"+rec_id).html("Tracking number is required");
                error = true;
            }else{
                $("#err_msg"+rec_id).html("");
            }
            if(!error){
                var purchased_date = $(this).attr('data-pdate');
                var package_name = $(this).attr('data-package');
                var orderno = $(this).attr('data-orderno');
                var email = $(this).attr('data-email');
                $("#sh_date").html(purchased_date);
                $("#sh_trackingno").html(trackingId);
                $("#sh_package").html(package_name);
                $("#sh_orderno").html(orderno);
                $("#sh_email").html(email);
                $('#singleUpdate').modal('show');
                $("#purchased_rec_id").val(rec_id);
                $("#tracking_number").val(trackingId);
            }
        });
    </script>
</body>
</html>
