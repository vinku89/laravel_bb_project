<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Commission Report</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    @include("inc.styles.all-styles")
     <style>
        .searchicon{
            margin-bottom:5px;
        }
        .searchicon img{
            margin-top:9px;
        }
        .viewBtn{
            display: inline-block;
            background-color: #fd9322;
            color: #fff;
            padding: 0 15px;
            border-radius: 3px;
            text-decoration:none !important;
        }
        .viewBtn:hover{
            color:#fff;
        }
    </style>
</head>

<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content commission_report">
        <!-- Header Section Start Here -->
        @include("inc.header.header")
        <!-- Header Section End Here -->
        <?php
            $loggedUserData = Session::get('userData');
            $loggedUserData = \App\User::where(array('user_id' => $loggedUserData['user_id']))->first();
            if($loggedUserData['user_role']==1) { $level1User = 'Reseller';$level2User = 'Agent';}
            else if($loggedUserData['user_role']==2) { $level1User = 'Agent';$level2User = 'Customer';}
            else if($loggedUserData['user_role']==3) { $level1User = 'Customer';$level2User = '';}
            else if($loggedUserData['user_role']==4) { $level1User = '';$level2User = '';}
            else {$level1User = '';$level2User = '';}
        ?>
        <section class="main_body_section scroll_div">
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Commission Report</h5>
            <!-- Filter section -->
            <div class="filter_wrp col-12 pb-3">
                <div class="row">
                    <div class="col-3 pl-0">
                        <div class="input-group search_wrap">
                            <div class="input-group-prepend">
                                <span class="searchicon" id="basic-addon1"><img src="<?php echo url('/');?>/public/images/search.png"></span>
                            </div>
                            <input type="text" class="form-control searchbar" placeholder="{{ $level1User }} Name or ID"
                                aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <!-- <div class="col-3 ml-auto">
                        <a href="" class="print_btn float-right">Print
                            <i class="fas fa-print"></i>
                        </a>
                    </div> -->
                </div>
            </div>
            <!-- Filter section End-->
            <div class="middle_box clearfix">
                <div class="grid_wrp">
                    <div class="grid_header clearfix pt-3 pb-3">
                        <div class="w20 float-left font16 font-bold black_txt">{{ $level1User }} Name</div>
                        <div class="w15 float-left font16 font-bold black_txt pl-2">{{ $level1User }} ID</div>
                        <div class="w25 float-left font16 font-bold black_txt text-right">Total Sales Amount (USD)</div>
                        <div class="w25 float-left font16 font-bold black_txt text-right ">Total Commission Amount (USD)</div>
                        <div class="w15 float-left font16 font-bold black_txt text-right ">Action</div>
                    </div>
                    <?php $total_sales_amount = 0;
                        $total_commision_amount = 0;?>
                    <div class="accordion" id="accordionExample">
                        @if($commissionReports->count())
                            @foreach($commissionReports as $item)
                            <?php
                                $total_sales_amount += $item->sales_amount;
                                $total_commision_amount += $item->commission;
                            ?>
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <button class="btn btn-link w-100 p-0" type="button" data-toggle="collapse" data-target="#agentDetail{{ $item->user_id }}" onclick="loadUsersData({{ $item->rec_id }}, {{ $item->user_role }})" aria-expanded="false" aria-controls="collapseOne">
                                        <div class="grid_body clearfix">
                                            <!-- Row 1 -->
                                            <div class="grid_row clearfix border-top agent_row">
                                                <div class="w20 float-left font16 dark-grey_txt text-left">{{ ucwords($item->first_name." ".$item->last_name) }}</div>
                                                <div class="w15 float-left font16 dark-grey_txt pl-2 text-left">{{ $item->user_id }}</div>
                                                <div class="w25 float-left font16 blue_txt  text-right">{{ number_format($item->sales_amount,2) }}</div>
                                                <div class="w25 float-left font16 text-right">{{ number_format($item->commission,2) }}</div>
                                                <div class="w15 float-left font16 text-right">
                                                    <a href="{{ url('/').'/commissionReportDetails/'.$item->rec_id.'/'.$item->referenceId }}" class="viewBtn">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </div>

                                <div id="agentDetail{{ $item->user_id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body px-4">
                                        <div class="grid_wrp">
                                            <div class="grid_header body_bg clearfix pt-3 pb-3">
                                                <div class="w20 float-left font16 font-bold grey_txt">{{ $level2User }} Name</div>
                                                <div class="w15 float-left font16 font-bold grey_txt pl-2">{{ $level2User }} ID</div>
                                                <div class="w25 float-left font16 font-bold grey_txt text-right">Total Sales Amount (USD)</div>
                                                <div class="w25 float-left font16 font-bold grey_txt text-right ">Total Commission Amount (USD)</div>
                                                <div class="w15 float-left font16 font-bold grey_txt text-right ">Action</div>
                                            </div>
                                            <div class="grid_body clearfix" id="agentDetails{{ $item->rec_id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="norecord_txt">No Records Found</div>
                        @endIf
                    </div>
                </div>

            </div>
            <div class="total_calc_wrp clearfix">
                <div class="w20 float-left">&nbsp;</div>
                <div class="w15 float-left">&nbsp;</div>
                <div class="w25 blue_txt font-bold text-right font16 float-left">{{ number_format($total_sales_amount,2) }}</div>
                <div class="w25 float-left green_txt font-bold text-right font16">{{ number_format($total_commision_amount,2) }}</div>
                <div class="w15">&nbsp;</div>
            </div>
            @if($commissionReports->total()>0)
                {{  $commissionReports->appends(['searchKey' =>''])->links() }}
            @endIf

        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script>
    function loadUsersData(user_id, user_role) {
        var csrf_Value= "<?php echo csrf_token(); ?>";
        $.ajax({
            url: "<?php echo url('/');?>/loadCommissionReportsById",
            method: 'POST',
            dataType: "json",
            data: {'rec_id': user_id,'user_role': user_role, "_token": csrf_Value},
            success: function(data){
                console.log(data);
                if(data.status == 'Success'){
                    $("#agentDetails"+user_id).html(data.Result);
                }
            }
        });
    }
    </script>
</body>

</html>
