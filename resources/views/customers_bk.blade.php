<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
</head>

<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content customer">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <h5 class="font16 black_txt font-bold text-uppercase pt-4">Customer</h5>

            <!-- Filter section -->
            <div class="col-md-6">
                <div class="d-inline-block">
                    <a href="#" class="big_blue_btn" data-toggle="modal" data-target="#addNewUser">
                        New Customer
                    </a>
                </div>
            </div>
            <div class="filter_wrp col-12">
                <div class="row">
                    <div class="col-3 pl-0">
                        <div class="input-group search_wrap">
                            <div class="input-group-prepend">
                                <span class="searchicon" id="basic-addon1"><img src="<?php echo url('/');?>/public/images/search.png"></span>
                            </div>
                            <input type="text" class="form-control searchbar" placeholder="User ID Name or Email"
                                aria-label="Username" aria-describedby="basic-addon1" id="searchKey">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label font16 dark-grey_txt small_resolution"
                                style="line-height: 36px;">from</label>
                            <div class="col-sm-10 pl-0">
                                <div id="datepicker" class="input-group date  m-0" data-date-format="mm-dd-yyyy">
                                    <input class="form-control datepicker_input" type="text" readonly  id="from_date"/>
                                    <span class="input-group-addon calender_icon"><i
                                            class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label font16 dark-grey_txt"
                                style="line-height: 36px;">To</label>
                            <div class="col-sm-10 pl-0">
                                <div id="datepicker" class="input-group date  m-0" data-date-format="mm-dd-yyyy">
                                    <input class="form-control datepicker_input" type="text" readonly id="to_date"/>
                                    <span class="input-group-addon calender_icon"><i
                                            class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <a href="javascript::void(0);" class="print_btn" id="filter_data">
                            Filter
                        </a>
                        <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                            Clear
                        </a>
                        <!-- <a href="" class="print_btn">Print
                            <i class="fas fa-print"></i>
                        </a> -->

                    </div>
                </div>
            </div>
            <!-- Filter section End-->
            <div class="middle_box clearfix">
                <div class="grid_wrp">
                    <div class="grid_header clearfix pt-3 pb-3">
                        <div class="w15 float-left font16 font-bold grey_txt">Date</div>
                        <div class="w10 float-left font16 font-bold grey_txt pl-2">User ID</div>
                        <div class="w20 float-left font16 font-bold grey_txt ">Name</div>
                        <div class="w25 float-left font16 font-bold grey_txt ">Email</div>
                        <div class="w15 float-left font16 font-bold grey_txt text-right pr-3">Total Package</br>(USD)
                        </div>
                        <div class="w15 float-left font16 font-bold grey_txt ">Status</div>
                    </div>
					<?php $package_total_value = 0;?>
                    <div class="grid_body clearfix">
						@if($customers->count())
							@foreach($customers as $customer)
                        <!-- Active -->
						<?php $package_total_value += $customer['package_value'];?>
                        <div class="grid_row clearfix border-top">
                            <div class="w15 float-left font16 dark-grey_txt">
								<?php echo date("d/m/Y", strtotime($customer['registration_date']));?>,
                                </br><?php echo date("h:i a", strtotime($customer['registration_date']));?>
                            </div>
                            <div class="w10 float-left font16 dark-grey_txt pl-2"><?php echo $customer['user_id'];?></div>
                            <div class="w20 float-left font16 dark-grey_txt "><?php echo $customer['first_name'];?></div>
                            <div class="w25 float-left font16 dark-grey_txt "><?php echo $customer['email'];?></div>
                            <div class="w15 float-left font16 blue_txt text-right pr-3"><?php echo number_format($customer['package_value'],2);?></div>
                            <div class="w15 float-left font16 dark-grey_txt {{ $customer['package_value'] == 0 ? 'd-none' : '' }}">
                                <span class="status_btns {{ $customer['expiry_date'] < NOW() ? 'expaired_btn' : 'active_btn' }}">{{ $customer['expiry_date'] < NOW() ? 'Expired' : 'Active' }}</span></br>
                                Expiry : <?php echo date('d/m/Y',strtotime($customer['expiry_date']));?>
                            </div>
                            <div class="w15 float-left font16 dark-grey_txt text-center {{ $customer['package_value'] == 0 ? '' : 'd-none' }}">-</div>
                            <div class="w15 float-left font16 dark-grey_txt">
                                <a class="circle_btn d-inline-block mr-auto editCustomer" href="#" data-id="<?php echo $customer['rec_id']; ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class=" circle_btn delete d-inline-block mr-auto deleteCustomer" href="#" data-id="<?php echo $customer['rec_id']; ?>">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <a class=" circle_btn view d-inline-block mr-auto resellerData" href="#" data-id="<?php echo $customer['rec_id']; ?>">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                        </div>
							@endforeach
						@else
							<div class="w100 float-left font16 dark-grey_txt">No Records Found</div>
						@endif

                    </div>

                </div>
            </div>
            @if($customers->count()>0)
			<div class="total_calc_wrp clearfix">
                <div class="w15 float-left">&nbsp;</div>
                <div class="w10 float-left">&nbsp;</div>
                <div class="w20 float-left">&nbsp;</div>
                <div class="w25 float-left">&nbsp;</div>
                <div class="w15 float-left font16 blue_txt text-right pr-3"><?php echo number_format($package_total_value,2);?></div>
                <div class="w15 float-left">&nbsp;</div>
            </div>
            @endIf
			@if($customers->total()>0)
				<?php echo $customers->appends(['searchKey' =>'', 'from_date' => '', 'to_date' => '' ])->links();?>
            @endIf
        </section>
    </div>
    <!-- All scripts include -->
     @include("inc.scripts.all-scripts")

     <!-- Add New User -->
    <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUser"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Add New Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-4">
                    <form method="post" id="create_form" name="create_form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <!--  Email -->
                        <div class="form-group">
                            <input type="email" class="form-control border-bottom-only" id="email" name="email" aria-describedby="emailHelp" placeholder="Email">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Email</span></div>
                        </div>

                        <!-- Customer Name -->
                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only" id="first_name" name="first_name" aria-describedby="emailHelp" placeholder="First Name">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">First Name</span></div>
                        </div>

                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only" id="last_name" name="last_name" aria-describedby="emailHelp" placeholder="Last Name">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Last Name</span></div>
                        </div>

                        <div class="form-group">
                            <select class="form-control border-bottom-only" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Gender</span></div>
                        </div>

                        <div class="form-group">
                            <select class="form-control border-bottom-only" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">married</option>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Status</span></div>
                        </div>

                        <!-- Customer Address -->
                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only" id="addressline1" name="addressline1" aria-describedby="emailHelp" placeholder="Address Line 1">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Address Line 1</span></div>
                        </div>

                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only" id="addressline2" name="addressline2" aria-describedby="emailHelp" placeholder="Address Line 2">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Address Line 2</span></div>
                        </div>

                        <!-- Customer Country -->
                        <div class="form-group">
                            <select class="form-control border-bottom-only" id="country" name="country">
                                <option value="">Select Country</option>
                                <?php
                                    foreach ($country_data as $val) {
                                        echo "<option value='$val->countryid' data-id='$val->currencycode'>".$val->country_name."</option>";
                                    }
                                ?>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                        </div>

                        <!-- Customer Mobile number -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only" id="country_code" name="country_code" aria-describedby="emailHelp" placeholder="Country Code" readonly="readonly">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country Code</span></div>
                        </div>

                        <!-- Customer Mobile number -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only" id="mobile" name="mobile" aria-describedby="emailHelp" placeholder="Mobile Number">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Customer Mobile number</span></div>
                        </div>

                        <!-- Packages List -->
                        <div class="form-group">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">BestBOX Package</span></div>
                            <select class="form-control border-bottom-only" id="package" name="package">
                                <option value="">Choose BestBOX Package</option>
                                <?php
                                    foreach ($package_data as $val) {
                                        echo "<option value='$val->id' data-amt = '$val->effective_amount'>".$val->package_name." ".$val->effective_amount." USD"."</option>";
                                    }
                                ?>
                            </select>
                            <div class="f14">Activation Period : {{ date('d/m/Y') }}</div>
                            <div class="f14"> <input type="checkbox" name="pay" id="pay" style="width: 20px;">Pay for my friend</div>
                            <div class="f14">Wallet Balance : {{ number_format($wallet_balance->amount,2) }} USD</div>
                            <input type="hidden" value="{{ $wallet_balance->amount }}" id="user_wallet_amt" name="user_wallet_amt">
                        </div>

                    </form>
                </div>
                <div class="form-group" id="disp_msg"></div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="create_customer">Create</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New User end -->

    <!-- View User -->
    <div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="f14 black_txt py-3">
                        <div class="row pb-3">
                            <div class="col-md-3">Customer ID</div>:
                            <div class="col-md-8" id="sh_reseller_userid"> BBA14</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Email</div>:
                            <div class="col-md-8" id="sh_reseller_email"> robert.james@gmail.com</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Name</div>:
                            <div class="col-md-8" id="sh_reseller_name"> Robert James</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Gender</div>:
                            <div class="col-md-8" id="sh_reseller_gender"> Robert James</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Status</div>:
                            <div class="col-md-8" id="sh_reseller_status"> Robert James</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Shipping Address</div>:
                            <div class="col-md-8" id="sh_reseller_addr"> Rue Perdtemps 3, 1260 Nyon, Switzerland </div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Country</div>:
                            <div class="col-md-8" id="sh_reseller_country"> +11928273639</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Mobile No</div>:
                            <div class="col-md-8" id="sh_reseller_mobile"> +11928273639</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Raferal ID</div>:
                            <div class="col-md-8" id="sh_reseller_ref_id"> Ref8787bestbox12</div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">BestBOX Package</div>:
                            <div class="col-md-8" id="sh_reseller_ref_id"> </div>
                        </div>

                        <div class="row pb-3">
                            <div class="col-md-3">Activation Period</div>:
                            <div class="col-md-8" id="sh_reseller_ref_id"> </div>
                        </div>
                    </div>
                </div>

                <!-- footer buttons -->
                <div class="block-buttons">
                    <button type="button" class="btn close-btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View User end -->

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

    <!-- Edit User -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="editUser"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                    <form method="post" id="update_form" name="update_form">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="ed_customer_rec_id" id="ed_customer_rec_id">

                        <!-- Customer Email -->
                        <div class="form-group">
                            <input type="email" class="form-control border-bottom-only" id="ed_customer_email" name="email" aria-describedby="emailHelp" placeholder="Email" value="robert.james@gmail.com" readonly="readonly">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Email</span></div>
                        </div>

                        <!-- Customer Name -->
                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only" id="ed_customer_first_name" name="first_name" aria-describedby="emailHelp" placeholder="First Name" value="Robert JAmes">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">First Name</span></div>
                        </div>

                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only" id="ed_customer_last_name" name="last_name" aria-describedby="emailHelp" placeholder="Last Name" value="Robert JAmes">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Last Name</span></div>
                        </div>

                         <div class="form-group">
                            <select class="form-control border-bottom-only" id="ed_customer_gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Gender</span></div>
                        </div>

                        <div class="form-group">
                            <select class="form-control border-bottom-only" id="ed_customer_status" name="status">
                                <option value="">Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">married</option>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Status</span></div>
                        </div>

                        <!-- Customer Address -->
                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only" id="ed_customer_address_line1" name="address" aria-describedby="emailHelp" placeholder="Address" value="Rue Perdtemps 3, 1260 Nyon, Switzerland ">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Address Line 1</span></div>
                        </div>

                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only" id="ed_customer_address_line2" name="address2" aria-describedby="emailHelp" placeholder="Address" value="Rue Perdtemps 3, 1260 Nyon, Switzerland ">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Address Line 2</span></div>
                        </div>

                         <!-- Customer country -->
                        <div class="form-group">
                            <select class="form-control border-bottom-only" id="ed_customer_country" name="country">
                                <option value="">Select Country</option>
                                <?php
                                    foreach ($country_data as $val) {
                                        echo "<option value='$val->countryid' data-id='$val->currencycode'>".$val->country_name."</option>";
                                    }
                                ?>
                            </select>
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                        </div>

                        <!-- Customer Mobile number -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only" id="ed_customer_country_code" name="country_code" aria-describedby="emailHelp" placeholder="Country Code" readonly="readonly">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Country Code</span></div>
                        </div>

                        <!-- Customer Mobile number -->
                        <div class="form-group">
                            <input type="text" class="form-control border-bottom-only" id="ed_customer_mobile" name="mobile" aria-describedby="emailHelp" placeholder="Mobile Number">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Customer Mobile number</span></div>
                        </div>

                        <!-- customer Refferal ID -->
                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only" id="ed_customer_ref_id" name="ed_customer_ref_id" aria-describedby="emailHelp" placeholder="Refferal ID" value="Ref8787bestbox12" readonly="readonly">
                            <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Customer Refferal ID</span></div>
                        </div>
                    </form>
                </div>
                <div class="form-group" id="ed_disp_msg"></div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="update_customer_data">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit User end -->

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

	 <script type="text/javascript">
	 var url = "<?php echo url('/customers');?>";

	 /* filter data */
	 $("#filter_data").click(function(e){
		e.preventDefault();
		var searchKey = $("#searchKey").val().trim();
		var from_date = $("#from_date").val().trim();
		var to_date = $("#to_date").val().trim();
		var searchUrl = url+'?searchKey='+searchKey+'&from_date='+from_date+'&to_date='+to_date+'&page=0';
		location.href=searchUrl;
	});

	/* clear filter data */
	$("#clear_filter_data").click(function(e){
		e.preventDefault();
		$("#searchKey").val('');
		$("#from_date").val('');
		$("#to_date").val('');
		var searchUrl = url+'?searchKey=&from_date=&to_date=&page=0';
		location.href=searchUrl;
	});

    $(document).ready(function(){
        $("#create_customer").click(function(){
            var frm = $('#create_form');
            $.ajax({
                url: "<?php echo url('/');?>/createCustomer",
                method: 'POST',
                dataType: "json",
                data: frm.serialize(),
                success: function(data){
                    if(data.status == 'Success'){
                        $("#disp_msg").html(data.message);
                        setTimeout(function(){
                            location.reload(true);
                        }, 2000);
                    }else if(data.status == 'Failure'){
                        $("#disp_msg").html(data.message);
                    }
                }
            });
        });

        $("#country").change(function(e){
            var country_code =  $('option:selected', this).attr('data-id');
            $("#country_code").val('+'+country_code);
        });

        $("#ed_customer_country").change(function(e){
            var country_code =  $('option:selected', this).attr('data-id');
            $("#ed_customer_country_code").val('+'+country_code);
        });

        $(".resellerData").click(function(){
                var id = $(this).attr('data-id');
                var csrf_Value= "<?php echo csrf_token(); ?>";
                $.ajax({
                    url: "<?php echo url('/');?>/getResellerData",
                    method: 'POST',
                    dataType: "json",
                    data: {'id': id,"_token": csrf_Value},
                    success: function(data){
                        if(data.status == 'Success'){
                            $("#sh_reseller_userid").html(data.message[0].user_id);
                            $("#sh_reseller_rec_id").html(data.message[0].rec_id);
                            $("#sh_reseller_email").html(data.message[0].email);
                            $("#sh_reseller_country").html(data.country);
                            $("#sh_reseller_mobile").html(data.message[0].telephone);
                            $("#sh_reseller_addr").html(data.message[0].address);
                            $("#sh_reseller_gender").html(data.message[0].gender);
                            $("#sh_reseller_status").html(data.message[0].married_status);
                            $("#sh_reseller_name").html(data.message[0].first_name+' '+data.message[0].last_name);
                            $("#sh_reseller_ref_id").html(data.message[0].refferallink_text);
                            $('#viewUser').modal("show");
                        }
                    }
                });
            });

        $(".editCustomer").click(function(){
                var id = $(this).attr('data-id');
                var csrf_Value= "<?php echo csrf_token(); ?>";
                $.ajax({
                    url: "<?php echo url('/');?>/getResellerData",
                    method: 'POST',
                    dataType: "json",
                    data: {'id': id,"_token": csrf_Value},
                    success: function(data){
                        if(data.status == 'Success'){
                            //$("#ed_reseller_id").val(data.message[0].user_id);
                            $("#ed_customer_rec_id").val(data.message[0].rec_id);
                            $("#ed_customer_email").val(data.message[0].email);
                            $("#ed_customer_country").val(data.message[0].country_id);
                            var result = data.message[0].telephone.split('-');
                            $("#ed_customer_country_code").val(result[0]);
                            $("#ed_customer_mobile").val(result[1]);
                            $("#ed_customer_address_line1").val(data.message[0].address);
                            $("#ed_customer_address_line2").val(data.message[0].address2);
                            $("#ed_customer_first_name").val(data.message[0].first_name);
                            $("#ed_customer_last_name").val(data.message[0].last_name);
                            $("#ed_customer_gender").val(data.message[0].gender);
                            $("#ed_customer_status").val(data.message[0].married_status);
                            $("#ed_customer_ref_id").val(data.message[0].refferallink_text);
                            $('#editUser').modal("show");
                        }
                    }
                });
            });

        $("#update_customer_data").click(function(){
                var frm = $('#update_form');
                $.ajax({
                    url: "<?php echo url('/');?>/updateCustomerData",
                    method: 'POST',
                    dataType: "json",
                    data: frm.serialize(),
                    success: function(data){
                        //$('#editUser').modal("hide");
                        if(data.status == 'Success'){
                            $("#ed_disp_msg").html(data.message);
                            setTimeout(function(){
                                location.reload(true);
                            }, 2000);
                        }else if(data.status == 'Failure'){
                            $("#ed_disp_msg").html(data.message);
                        }
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
                        $('#deleteUser').modal("hide");
                    }
                });
            });

        $(".deleteCustomer").click(function(){
                var id = $(this).attr('data-id');
                $("#delete_user_id").val(id);
                $('#deleteUser').modal("show");
            });

        $("#package").change(function(){
        	$('#pay').attr('checked', true);
        	var package_value = $('option:selected', this).attr('data-amt');
        	var user_wallet_amt = $("#user_wallet_amt").val();
        	if(parseFloat(package_value) > parseFloat(user_wallet_amt)){
        		$("#alertModal").modal("show");
        	}
        });

        $("#cls_modal").click(function(){
        	$("#alertModal").modal("hide");
        	$("#addNewUser").modal("hide");
        });

    });
	</script>
</body>

</html>
