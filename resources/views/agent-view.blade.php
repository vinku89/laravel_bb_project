<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Agent View</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style>
        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
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
                <li class="breadcrumb-item f16"><a href="{{ url('/').'/agents' }}" class="f16">Agents</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">View Agent</li>
                </ol>
            </nav>

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">View Agent</h5>
            <div class="row">
                <div class="col-md-6">

                </div>
            </div>
            <div class="clearfix ">
                <div class="row">
                    <div class="col-lg-6 col-xl-5 col-md-8 col-12">
                        <div class="f14 black_txt py-3">
                            <div class="row pb-3">
                                <div class="col-md-5">Email</div>
                                <div class="col-md-7">: {{ $agentInfo->email }}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md-5">Name</div>
                                <div class="col-md-7">: {{ ucwords($agentInfo->first_name.' '.$agentInfo->last_name) }}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md-5">Gender</div>
                                <div class="col-md-7">: {{ ($agentInfo->gender =='') ? '-' : ucwords($agentInfo->gender)  }}</div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-md-5">Address</div>
                                <div class="col-md-7">: <?php echo ($agentInfo->shipping_address == '') ? '-' : $agentInfo->shipping_address; ?> </div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-md-5">Country</div>
                                <div class="col-md-7">: {{ $country->country_name }}</div>
                            </div>

                            <div class="row pb-3">
                                <div class="col-md-5">Mobile No</div>
                                <div class="col-md-7">: {{ $agentInfo->telephone}}</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md-5">Agent Commission Percent</div>
                                <div class="col-md-7">: {{ $agentInfo->commission_perc }} %</div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-md-5">Referral ID</div>
                                <div class="col-md-7">: {{ ($agentInfo->refferallink_text == '') ? '-' : $agentInfo->refferallink_text }} </div>
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
