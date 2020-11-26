<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Customer View</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style type="text/css">
        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
        }
        .address_p p{
            margin:0;
            padding-left:10px;
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <i class="fas fa-angle-left"></i>
                    <li class="breadcrumb-item f16"><a href="{{ url('/').'/customers' }}" class="f16">Customer</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Customer Details</li>
                </ol>
            </nav>

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">CUSTOMER DETAILS</h5>
            <div class="row">
                <div class="col-md-6">

                </div>
            </div>
            <div class="clearfix ">
                <div class="row">
                    <div class="col-lg-8 col-xl-7 col-sm-12 col-12">
                        <div class="f14 black_txt py-3">
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Email</div>
                                <div class="col-sm-7 col-xl-8">: {{ $customerInfo->email }}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Name</div>
                                <div class="col-sm-7 col-xl-8">: {{ ucwords($customerInfo->first_name) }}{{ ucwords($customerInfo->last_name) }}</div>
                            </div>
                            <!-- <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Gender</div>
                                <div class="col-sm-7 col-xl-8">: {{ ($customerInfo->gender =='') ? '-' : ucwords($customerInfo->gender)  }}</div>
                            </div> -->

                            <!-- <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Martial Status</div>
                                <div class="col-sm-7 col-xl-8">: {{ ($customerInfo->married_status == '') ? '-' : ucwords($customerInfo->married_status) }} </div>
                            </div> -->
                            <div class="row pb-3">
                                <div class="col-md-12 f18 font-bold">Address Information</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Address Line 1</div>
                                <div class="col-sm-7 col-xl-8"><span class="float-left">:</span> {{ ($customerInfo->address == '') ? '-' : $customerInfo->address }} </div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Address Line 2</div>
                                <div class="col-sm-7 col-xl-8"><span class="float-left">:</span> {{ ($customerInfo->address2 == '') ? '-' : $customerInfo->address2 }}  </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Zip Code</div>
                            <div class="col-md-7 col-xl-8">: {{ ($customerInfo->zipcode == 0) ? '-' : $customerInfo->zipcode }}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Country</div>
                                <div class="col-sm-7 col-xl-8">: {{ (empty($country)) ? '-' : $country->country_name }}</div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Mobile No</div>
                                <div class="col-sm-7 col-xl-8">: {{ ($customerInfo->telephone == '') ? '-' : $customerInfo->telephone }}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md-12 f18 font-bold">Shipping Information</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Shipping Address </div>
                                <div class="col-sm-7 col-xl-8 address_p"><span class="float-left">:</span><?php echo ($customerInfo->shipping_address == '') ? '-' : $customerInfo->shipping_address; ?> </div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Shipping Country</div>
                                <div class="col-sm-7 col-xl-8">: {{ (empty($shipping_country)) ? '-' : $shipping_country->country_name }}</div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Mobile No</div>
                                <div class="col-sm-7 col-xl-8">: {{ ($customerInfo->shipping_user_mobile_no == '') ? '-' : $customerInfo->shipping_user_mobile_no }}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">BestBox Package</div>
                                <div class="col-sm-7 col-xl-8">: {{ !empty($packData) ? $packData->package_name : '-' }}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">Activation Period</div>
                                <div class="col-sm-7 col-xl-8">: {{ !empty($packData) ? date('d/m/Y',strtotime($packData->subscription_date)).' - '.date('d/m/Y',strtotime($packData->expiry_date)) : '-' }} </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-5 col-xl-4">status</div>
                                <div class="col-sm-7 col-xl-8">: {{ (empty($packData) ? 'Not Activated' : ($packData->id == 11 ? 'Active' : ($packData->expiry_date < NOW() ? 'Expired' : 'Active'))) }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

</body>
</html>
