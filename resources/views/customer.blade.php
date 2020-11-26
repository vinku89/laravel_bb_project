    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>BestBOX - Customers</title>
        <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
        <!-- All styles include -->
        @include("inc.styles.all-styles")
    </head>
    <body>
        <!-- Side bar include -->
        @include("inc.sidebar.sidebar")
        <div class="main-content">
            <!-- Header Section Start Here -->
            @include("inc.header.header")
            <!-- Header Section End Here -->
            <section class="main_body_section scroll_div">
                <h5 class="font16 font-bold text-uppercase black_txt p-3 pt-4">Customer</h5>
                <div class="row px-3">
                    <div class="col-md-6">
                        <div class="d-sm-inline-block d-block">
                            <a href="<?php echo url('/').'/customer-new';?>" class="big_blue_btn w-100">
                                New Customer
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                    </div>
                </div>

                <div class="row mt-2 mt-md-4 px-3">
                    <!-- Filter section -->
                    <div class="filter_wrp col-12">
                        <div class="row">
                            <div class="col-12 col-md-7 d-none d-md-block">
                                <div class="row">
                                    <div class="col-12 col-md-4 px-2">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                                style="line-height: 36px;">From</label>
                                            <div class="col-sm-9 pl-0">
                                                <div id="fromDate" class="input-group date  m-0"
                                                    data-date-format="mm-dd-yyyy">
                                                    <input class="form-control datepicker_input" type="text" readonly  id="from_date" value="{{ $from_date }}"/>
                                                    <span class="input-group-addon calender_icon"><i
                                                            class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 px-2">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label font16 dark-grey_txt small_resolution"
                                                style="line-height: 36px;">To</label>
                                            <div class="col-sm-9 pl-0">
                                                <div id="toDate" class="input-group date  m-0"
                                                    data-date-format="mm-dd-yyyy">
                                                    <input class="form-control datepicker_input" type="text" readonly  id="to_date" value="{{ $to_date }}"/>
                                                    <span class="input-group-addon calender_icon"><i
                                                            class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2 px-2 ">
                                        <a href="javascript::void(0);" class="print_btn" id="filter_data">
                                            Filter
                                        </a>
                                    </div>

                                    <div class="col-2 px-2">
                                        <a href="<?php echo url('/customers');?>" class="print_btn" id="clear_filter_data">
                                            Clear
                                        </a>
                                    </div>



                                </div>
                            </div>

                            <div class="col-12 col-md-5 text-left">
                                <div class="row">
                                    <div class="col-sm-6 my-2 my-md-0 order-2 order-md-1">
                                        <select id="normal_select" class="status form-control h50">
                                            <option value="" {{ ($status == 0) ? 'selected' : '' }}>Select Status</option>
                                            <option value="1" {{ ($status == 1) ?  'selected' : '' }}>Active</option>
                                            <option value="2" {{ ($status == 2) ? 'selected' : '' }}>Expired</option>
                                        </select>
                                    </div>

                                    <!-- <a href="" class="print_btn">Print
                                    <i class="fas fa-print"></i>
                                    </a> -->
                                    <div class="col-sm-6 my-2 my-md-0 order-1 order-md-2">
                                        <div class="mb-md-3 position-relative">
                                            <input type="text" class="form-control h50 pl-5" placeholder="Email Id/User Id/Name " aria-label="Username" aria-describedby="basic-addon1" id="searchKey" value="{{ $searchKey }}">
                                            <span class="addon-icon"><img src="<?php echo url('/');?>/public/images/search.png"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Filter section End-->
                </div>
                <div class="clearfix ">
                    <div class="row">
                        <div class="col-12">
                            <table class="rwd-table body_bg">
                                <?php
                                    if($userInfo->admin_login == 1){
                                        $w1 = "w10";$w2= "w15"; $w3 = "w15"; $w4="w10";$w5="w10"; $w6="w10";$w7="w10";$w8="w10";$w9="w10";
                                    }else{
                                        $w1 = "w10";$w2= "w20"; $w3 = "w20"; $w4="w10";$w5="w10"; $w6="w10";$w7="w10";$w8="";$w9="w10";
                                    }
                                ?>
                            </table>
                            <div class="grid_wrp d-none d-lg-block">
                                <div class="grid_header clearfix pt-3 pb-3">
                                    <div class="font12 blue_txt font-bold <?php echo $w1; ?> table_div_cell">Date</div>
                                    <div class="font12 blue_txt font-bold <?php echo $w2; ?> table_div_cell">Customer Name<br> (User ID) <br> Email Id</div>
                                    <div class="font12 blue_txt font-bold <?php echo $w3; ?> table_div_cell">Referred by</div>
                                    <div class="font12 blue_txt font-bold <?php echo $w4; ?> table_div_cell">Package Name</div>
                                    <div class="font12 blue_txt font-bold text-md-right p-0 <?php echo $w5; ?> table_div_cell">TTL Package <br> (USD)</div>
                                    <div class="font12 blue_txt font-bold <?php echo $w6; ?> table_div_cell">Pkg Status</div>
                                    <div class="font12 blue_txt font-bold text-md-center <?php echo $w7; ?> table_div_cell">Renew Package</div>
                                    <?php if($userInfo->admin_login == 1){ ?>
                                    <div class="font12 blue_txt font-bold <?php echo $w8; ?> table_div_cell">Status</div>
                                    <?php } ?>
                                    <div class="font12 blue_txt font-bold <?php echo $w9; ?> table_div_cell text-right">Actions</div>
                                </div>
                            </div>

                            <div class="middle_box d-none d-lg-block">
                                <?php $package_total_value = 0;?>
                                @if($customers->count())
                                @foreach($customers as $customer)
                                <?php $package_total_value += $customer['effective_amount'];?>
                                <div class="grid_wrp">
                                    <div class="grid_body clearfix">
                                        <!-- Row 1 -->
                                        <?php
                                                $ref_user = \App\User::select('users.first_name as referal_firstname','users.last_name as referal_lastname','users.email as referal_email','users.user_id as referal_userid')->where('rec_id', $customer['referral_userid'])->first();
                                                $qs = \App\Purchase_order_details::where('user_id',$customer['rec_id'])->orderBy('rec_id','DESC')->first();
                                                $ordDet = \App\Purchase_order_details::where('user_id',$customer['rec_id'])->orderBy('rec_id','DESC')->get();
                                                $pkgdata = \App\Package_purchase_list::where('user_id',$customer['rec_id'])->where('active_package',1)->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();
                                            ?>
                                        <div class="grid_row clearfix border-top agent_row">
                                            <div class="<?php echo $w1; ?> float-left font12 dark-grey_txt px-2">
                                            @php
                                                echo $registration_date = \App\Http\Controllers\home\ReportController::convertTimezoneDate($customer['registration_date']);
                                            @endphp
                                            <br/>
                                            @php
                                                echo $registration_date = \App\Http\Controllers\home\ReportController::convertTimezoneTime($customer['registration_date']);
                                            @endphp

                                            </div>
                                            <!-- <div class="<?php echo $w2; ?> float-left font14 dark-grey_txt px-2">{{ $customer['user_id'] }}</div> -->
                                            <div class="<?php echo $w2; ?> float-left font12  px-2 word-break-all">{{ ucwords($customer['first_name'].' '.$customer['last_name']) }}<br>User Id( {{ $customer['user_id'] }} ) <br>Ref Id( {{ $customer['refferallink_text'] }} ) <br> {{ $customer['email'] }}</div>
                                            <div class="<?php echo $w3; ?> float-left font12  px-2 word-break-all">{{ ucwords($ref_user['referal_firstname'].' '.$ref_user['referal_lastname']) }}<br>Ref Id( {{ $ref_user['referal_userid'] }} ) <br> {{ $ref_user['referal_email'] }}</div>
                                            <div class="<?php echo $w4; ?> float-left font12  px-2">{{ ($customer['package_name']!='') ? $customer['package_name'] : '-' }}</div>
                                            <div class="<?php echo $w5; ?> float-left font12 blue_txt text-right px-2">
                                            {{ number_format($customer['effective_amount'],2) }}
                                            </div>
                                            <div class="<?php echo $w6; ?> float-left font12 text-center px-2">
                                            @if($customer['id'] != 11)
                                                @if(!empty($pkgdata) && $pkgdata->expiry_date != '')
                                                    <div class="font14 inline-block {{ $pkgdata->expiry_date < NOW() ? 'label_expired' : 'label_active' }}"></div>
                                                    <div class="text-left">Expiry : {{ date('d/m/Y',strtotime($pkgdata->expiry_date)) }}</div>
                                                @else
                                                    <div class="font14 inline-block">-</div>
                                                @endIf
                                            @else
                                                <?php echo '-';?>
                                            @endIf
                                            </div>

                                            <div class="<?php echo $w7; ?> float-left font12 text-center px-2">
                                                @if($customer['expiry_date'] != '' && $customer['id'] != 11)
                                                    <a href="<?php echo url('/renewalSubscription').'/'.encrypt($customer['rec_id']);?>" class="{{ ($customer['expiry_date'] < NOW() && $customer->status == 1) ? 'btn_renew_on' : 'btn_renew_off' }} d-inline-block">Renew</a>
                                                @elseIf($customer['id'] == 11 && $customer->status == 1)
                                                    <a href="<?php echo url('/renewalSubscription').'/'.encrypt($customer['rec_id']);?>" class="btn_renew_on d-inline-block">Renew</a>
                                                @else
                                                    @If(empty($customer['id']))
                                                    <p href="#" class="d-inline-block">Subscritpion Pending</p>
                                                    @elseIf(!empty($qs) && $qs->status == 1)
                                                    <p href="#" class="d-inline-block" style="color: #007bff">Activation Pending</p>
                                                    @elseIf(@count($ordDet) == 1 && $qs->status == 3)
                                                    <p href="#" class="d-inline-block" style="color: #ff5722">Order Canceled</p>
                                                    @endIf
                                                @endIf

                                            </div>

                                            @If($userInfo->admin_login == 1)
                                            <div class="<?php echo $w8; ?> float-left font12 pl-2">
                                                <select class="form-control inactiveCustomer f12 p-0 pl-2">
                                                    <option value="1" data-id="{{  $customer->rec_id }}" <?php if($customer->status == 1){echo "selected";}else{echo "";} ?> >Active</option>
                                                    <option value="0" data-id="{{  $customer->rec_id }}" <?php if($customer->status == 0){echo "selected";}else{echo "";} ?> >In-Active</option>
                                                </select>
                                            </div>
                                            @endIf
                                            <div class="<?php echo $w9; ?> float-left font12 px-1 text-right">
                                                <div class="d-inline-block">
                                                    <!-- <a class="circle_btn view d-inline-block" href="#" id="view_package_det" data-toggle="modal" data-target="#subscriptionModal" >
                                                        <i class="fas fa-eye"></i>
                                                    </a> -->
                                                    <a class="circle_btn d-inline-block " href="<?php echo url('/').'/customer-edit/'.base64_encode($customer['rec_id']);?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <!--  @If($userInfo->user_role == 1)
                                                    <a class="circle_btn delete d-inline-block deleteCustomer" href="#" data-id="<?php echo $customer['rec_id'];?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                    @endIf -->
                                                    <a class="circle_btn view d-inline-block" href="<?php echo url('/').'/customerView/'.base64_encode($customer['rec_id']);?>">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="grid_wrp">
                                    <div class="grid_body clearfix">
                                        <div class="grid_row clearfix border-top agent_row">
                                            <div class="w100 norecord_txt">No Records Found</div>
                                        </div>
                                    </div>
                                </div>
                                    @endif

                                <!-- Footer -->
                                @if($customers->count()>0)
                                <div class="grid_wrp body_bg">
                                    <div class="grid_body clearfix">
                                        <!-- Row 1 -->
                                        <div class="grid_row clearfix border-top agent_row">
                                            <div class="<?php echo $w1; ?> float-left font16 dark-grey_txt px-2">
                                                &nbsp
                                            </div>
                                            <div class="<?php echo $w2; ?> float-left font16 dark-grey_txt px-2">
                                                &nbsp
                                            </div>

                                            <div class="<?php echo $w3; ?> font-bold float-left font16 black_txt px-2">
                                                TOTAL
                                            </div>
                                            <div class="<?php echo $w4; ?> font-bold float-left font16 blue_txt text-right px-2">
                                                {{ $package_total_value }}
                                            </div>
                                            <div class="<?php echo $w5; ?> font-bold float-left font16 black_txt px-2">
                                                &nbsp
                                            </div>
                                            <div class="<?php echo $w6; ?> float-left font16 text-right px-2">
                                                &nbsp
                                            </div>
                                            <div class="<?php echo $w7; ?> float-left font16 text-center px-2">
                                                &nbsp
                                            </div>
                                            <div class="<?php echo $w8; ?> float-left font16 text-center px-2">
                                                &nbsp
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endIf
                            </div>

                            <div class="accordion-container d-lg-none">
                                <?php $package_total_value = 0;?>
                                @if($customers->count())
                                @foreach($customers as $customer)
                                <?php $package_total_value += $customer['effective_amount'];?>
                                <div class="set">
                                    <div class="row px-3 py-2">
                                        <div class="col-5 col-sm-6">
                                            <div class="set_user f12 pt-1">
                                                {{ ucwords($customer['first_name'].' '.$customer['last_name']) }}

                                            </div>
                                        </div>
                                            <?php
                                                $qs = \App\Purchase_order_details::where('user_id',$customer['rec_id'])->orderBy('rec_id','DESC')->first();
                                                $ordDet = \App\Purchase_order_details::where('user_id',$customer['rec_id'])->orderBy('rec_id','DESC')->get();
                                                $pkgdata = \App\Package_purchase_list::where('user_id',$customer['rec_id'])->where('active_package',1)->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();
                                            ?>
                                        <div class="col-5 text-right pr-5 f12">
                                            <!-- <span href="" class="btn_renew_off d-inline-block">Activation Pending</span> -->
                                            @if($customer['expiry_date'] != '' && $customer['id'] != 11)
                                                <a href="<?php echo url('/renewalSubscription').'/'.encrypt($customer['rec_id']);?>" class="{{ $customer['expiry_date'] < NOW() ? 'btn_renew_on' : 'btn_renew_off' }} d-inline-block">Renew</a>
                                            @elseIf($customer['id'] == 11)
                                                    <a href="<?php echo url('/renewalSubscription').'/'.encrypt($customer['rec_id']);?>" class="btn_renew_on d-inline-block">Renew</a>
                                            @else

                                                @If(!empty($qs) && $qs->status == 1)
                                                <a href="#" class="d-inline-block">Activation Pending</a>
                                                @elseIf(@count($ordDet) == 1 && $qs->status == 3)
                                                    <p href="#" class="d-inline-block" style="color: #ff5722">Order Canceled</p>
                                                @else
                                                <a href="#" class="d-inline-block">Subscription Pending</a>
                                                @endIf
                                            @endIf
                                        </div>

                                        <div class="col-2 col-sm-1 text-right show_moree">
                                            <i class="fa fa-angle-down mt-3"></i>
                                        </div>
                                    </div>
                                    <div class="content p-3">
                                    <div class="row my-1">
                                        <div class="col-4 f12 font-bold text-blue">Date</div>
                                        <div class="col-1">:</div>
                                        <div class="col-7 f12">
                                        @php
                                            echo \App\Http\Controllers\home\ReportController::convertTimezone($customer['registration_date']);
                                        @endphp
                                        </div>
                                    </div>

                                    <div class="row my-1">
                                        <div class="col-4 f12 font-bold text-blue">User ID</div>
                                        <div class="col-1">:</div>
                                        <div class="col-7 f12">{{ $customer['user_id'] }}</div>
                                    </div>

                                    <div class="row my-1">
                                        <div class="col-4 f12 font-bold text-blue">Email ID</div>
                                        <div class="col-1">:</div>
                                        <div class="col-7 f12">{{ $customer['email'] }}</div>
                                    </div>

                                    <div class="row my-1">
                                        <div class="col-4 f12 font-bold text-blue">Package Name</div>
                                        <div class="col-1">:</div>
                                        <div class="col-7 f12">{{ ($customer['package_name']!='') ? $customer['package_name'] : '-' }}</div>
                                    </div>

                                    <div class="row my-1">
                                        <div class="col-4 f12 font-bold text-blue">TTL Package (USD)</div>
                                        <div class="col-1">:</div>
                                        <div class="col-7 f12">{{ number_format($customer['effective_amount'],2) }}</div>
                                    </div>

                                    <div class="row my-1">
                                        <div class="col-4 f12 font-bold text-blue">Pkg Status</div>
                                        <div class="col-1">:</div>
                                        <div class="col-7 f12">
                                            @if($customer['id'] != 11)
                                                @if(!empty($pkgdata) && $pkgdata->expiry_date != '')
                                                    <div class="font16 inline-block {{ $pkgdata->expiry_date < NOW() ? 'label_expired' : 'label_active' }}"></div>
                                                    <div class="text-left">Expiry : {{ date('d/m/Y',strtotime($pkgdata->expiry_date)) }}</div>
                                                @else
                                                    <div class="font16 inline-block">-</div>
                                                @endIf
                                            @else
                                                <?php echo '-';?>
                                            @endIf
                                        </div>
                                    </div>

                                    <div class="row my-1">
                                        <div class="col-4 f12 font-bold text-blue">Status</div>
                                        <div class="col-1">:</div>
                                        <div class="col-7 f12">
                                            <?php
                                                if($userInfo->admin_login == 1){
                                            ?>
                                                <select class="form-control inactiveCustomer f14 p-0 pl-2">
                                                    <option value="1" data-id="{{  $customer->rec_id }}" <?php if($customer->status == 1){echo "selected";}else{echo "";} ?> >Active</option>
                                                    <option value="0" data-id="{{  $customer->rec_id }}" <?php if($customer->status == 0){echo "selected";}else{echo "";} ?> >In-Active</option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <div class="d-inline-block">
                                            <a class="circle_btn d-inline-block " href="<?php echo url('/').'/customer-edit/'.base64_encode($customer['rec_id']);?>">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <!--  @If($userInfo->user_role == 1)
                                            <a class="circle_btn delete d-inline-block deleteCustomer" href="#" data-id="<?php echo $customer['rec_id'];?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            @endIf -->
                                            <a class="circle_btn view d-inline-block" href="<?php echo url('/').'/customerView/'.base64_encode($customer['rec_id']);?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                </div>

                                @endforeach
                                @else
                                <div class="grid_wrp">
                                    <div class="grid_body clearfix">
                                        <div class="grid_row clearfix border-top agent_row">
                                            <div class="w100 norecord_txt">No Records Found</div>
                                        </div>
                                    </div>
                                </div>
                                    @endif
                            </div>

                        </div>
                    </div>
                </div>

                @if($customers->total()>0)
                    <?php echo $customers->appends(['searchKey' => $searchKey, 'from_date' => $from_date, 'to_date' => $to_date ])->links();?>
                @endIf
            </section>
        </div>
        <!-- Delete User -->
        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
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
                            Are you sure you want to delete this item?
                        </div>
                    </div>
                    <input type="hidden" name="delete_user_id" id="delete_user_id">
                    <!-- footer buttons -->
                    <div class="inline-buttons">
                        <button type="button" class="btn inline-buttons-left cancel-btn" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn inline-buttons-right create-btn" id="delete_customer_data">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete User end -->
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
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
                            Insufficient Balance In Your Wallet.
                            You can reload your wallet and try to create customer or you can save data to click continue.
                        </div>
                    </div>
                    <input type="hidden" name="delete_user_id" id="delete_user_id">
                    <!-- footer buttons -->
                    <div class="inline-buttons">
                        <button type="button" class="btn inline-buttons-left cancel-btn" id="cls_modal">Cancel</button>
                        <button type="button" class="btn inline-buttons-right create-btn" data-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View subscription details -->
        <div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header no-border">
                        <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Subscription Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body add_edit_user pb-4">
                        <div class="text-center f20 black_txt py-5 mb-5">
                            Insufficient Balance In Your Wallet.
                            You can reload your wallet and try to create customer or you can save data to click continue.
                        </div>
                    </div>
                    <input type="hidden" name="delete_user_id" id="delete_user_id">
                    <!-- footer buttons -->
                    <div class="inline-buttons">
                        <button type="button" class="btn inline-buttons-left cancel-btn" id="cls_modal">Cancel</button>
                        <button type="button" class="btn inline-buttons-right create-btn" data-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Model -->
        <div class="modal fade" id="successModel" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header no-border">
                        <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">
                            Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body add_edit_user pb-4">
                        <div class="text-center f20 black_txt py-5 mb-5 " id="sucessMsg"></div>
                    </div>
                    <!-- footer buttons -->
                    <div class="inline-buttons">
                        <button type="button" class="btn inline-buttons-left cancel-btn"
                            data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn inline-buttons-right create-btn OkBtnNew" id="OkBtn">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script type="text/javascript">
        var url = "<?php echo url('/customers'); ?>";

        $("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                $("#from_date").val('');
                $("#to_date").val('');
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey+'&from_date=&to_date=&status=&page=0';
            }
        });

        /* filter data */
        $("#filter_data").click(function(e){
            e.preventDefault();
            var from_date = $("#from_date").val().trim();
            var to_date = $("#to_date").val().trim();
            var searchKey = $("#searchKey").val().trim();
            if(from_date == '' || to_date == '') {
                alert('Please select both from and to date');
                return false;
            }else if(from_date > to_date) {
				alert('To date should be grater than From Date');
				return false;
			}else{
                var searchUrl = url+'?searchKey='+searchKey+'&from_date='+from_date+'&to_date='+to_date+'&status='+status+'&page=0';
                location.href=searchUrl;
            }
        });

    /* clear filter data */
    // $("#clear_filter_data").click(function(e){
    //     e.preventDefault();
    //     $("#from_date").val('');
    //     $("#to_date").val('');
    //     var searchKey = $("#searchKey").val().trim();
    //     var searchUrl = url+'?searchKey='+searchKey+'&from_date=&to_date=status=&page=0';
    //     location.href=searchUrl;
    // });

    $(document).ready(function(){
        $("#fromDate").datepicker({
            minDate : 0,
            autoclose: true,
            todayHighlight: true,
            endDate: "today",
            onSelect: function(selected) {
             $("#toDate").datepicker("option","minDate", selected)
           }
        });

        $("#toDate").datepicker({
            minDate : 0,
            autoclose: true,
            todayHighlight: true,
            endDate: "today",
            onSelect: function(selected) {
              $("#fromDate").datepicker("option","maxDate", selected)
            }
        });
    });

    $("#delete_customer_data").click(function(){
        var id = $("#delete_user_id").val();
        var csrf_Value= "<?php echo csrf_token(); ?>";
        $.ajax({
            url: "<?php echo url('/');?>/deleteResellerData",
            method: 'POST',
            dataType: "json",
            data: {'id': id,"_token": csrf_Value},
            success: function(data){
                //$('#deleteUser').modal("hide");

                    if(data.status=='Success'){
                    $('#deleteUser').modal("hide");
                    window.location.reload();
                    return true;

                }else{
                    alert(data.Result);
                    return false;
                }

            }
        });
    });

    $(".deleteCustomer").click(function(){
        var id = $(this).attr('data-id');
        $("#delete_user_id").val(id);
        $('#deleteUser').modal("show");
    });

    $(".status").change(function(e){
        e.preventDefault();
        var status = $(this).val();
        var from_date = $("#from_date").val().trim();
        var to_date = $("#to_date").val().trim();
        var searchKey = $("#searchKey").val().trim();
        var searchUrl = url+'?searchKey='+searchKey+'&from_date='+from_date+'&to_date='+to_date+'&status='+status+'&page=0';
        location.href=searchUrl;
    });

    $(".inactiveCustomer").on('change', function(e) {
        e.preventDefault();
        var token = "<?php echo csrf_token() ?>";
        var statusID = $(this).val();
        var rec_id = $(this).find(':selected').attr('data-id');
        if(statusID != ""){
            $.ajax({
                url: "<?php echo url('/');?>/deleteResellerAgentStatus",
                method: 'POST',
                dataType: "json",
                data: {'rec_id': rec_id,'status': statusID,'action': 'inactiveReseller',"_token": token},
                beforeSend: function(){
                    $(".loaderIcon").show();
                },
                complete: function(){
                    $(".loaderIcon").hide();
                },
                success: function (data) {
                    if(data.status=='Success'){
                        $('#successModel').modal('show');
                        $('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>');
                        //window.location.reload();
                    }else{
                        alert(data.Result);
                        return false;
                    }
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
            });
        }else{
            alert("something went wrong");
        }

    });

    // Ok Btn msg
    $(".OkBtnNew").on('click', function(e) {
        e.preventDefault();
        $('#successModel').modal('hide');
        window.location.reload();
    });

    </script>

    <script>
            $(document).ready(function() {
                /*$(".show_moree").on("click", function() {
                    if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                    $(this)
                        .siblings(".content p3")
                        .slideUp(200);
                    $(".show_moree i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    } else {
                    $(".show_moree i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    $(this)
                        .find("i")
                        .removeClass("fa-angle-down")
                        .addClass("fa-angle-up");
                    $(".show_moree").removeClass("active");
                    $(this).addClass("active");
                    $(".content").slideUp(200);
                    $(this)
                        .siblings(".content p3")
                        .slideDown(200);
                    }
                });
				*/
				 $(".show_moree").on("click", function() {

					if ($(this).hasClass("active")) {
						$(this).removeClass("active");
						$(this)
							.siblings(".content p3")
							.slideUp(200);
						$(".show_moree i")
							.removeClass("fa-angle-up")
							.addClass("fa-angle-down");

						$(this).toggleClass(".content p3").parent().next().slideToggle();

                    }else{

						$(".show_moree i")
							.removeClass("fa-angle-up")
							.addClass("fa-angle-down");
						$(this)
							.find("i")
							.removeClass("fa-angle-down")
							.addClass("fa-angle-up");
						$(".show_moree").removeClass("active");
						$(this).addClass("active");
						$(this).toggleClass(".content p3").parent().next().slideToggle();

					}





					});

            });
        </script>

    </body>
    </html>
