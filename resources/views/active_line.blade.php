<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Active Line</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
	<style>
		.activeBtnDays{background-color:orange;}
		.activeBtn {
			position: absolute;
			width: 100%;
			height: 100%;
			background: #ed1c24;
			transition: background 150ms linear;
			border-radius: 15px;
            cursor: pointer;
		}
		.green{
			 background: #00a651;
			 color:#fff !important;
		}
		.red{
			background: #ed1c24;
			color:#fff !important;
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
            <div class="container-fluid">
                <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left"> Active Line</h5>

                <div class="bb_new_filter">
                    <div class="row">
                        <div class="col-xl-9 col-md-12 mb-2" >
                            <div class="row days_btn">
                                <div class="col-xl-2 col-md-2 col-sm-6 col-6">
                                    <button class="btn bb-new-btn btn-all">All</button>
                                </div>


                                <div class="col-xl-2 col-md-2 col-sm-6 col-6">
                                    <label class='toggle-label'>
                                        <input type='checkbox' />
                                        <span class=''>
                                            <span class="toggle"></span>
                                            <span class="label on <?php echo ($status==1 ? 'activeBtn green' : ''); ?>" data-id="1"  >Active</span>
                                            <span class="label off <?php echo ($status==2 ? 'activeBtn red' : ''); ?>" data-id="2"  >Expired</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-6 col-4">
                                    <button class="btn bb-new-btn btn-7 btn7 <?php echo ($days==7) ? 'activeBtnDays' : ''?>" data-id="7" >7 Days</button>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-6 col-4">
                                    <button class="btn bb-new-btn btn-3 btn3 <?php echo ($days==3) ? 'activeBtnDays' : ''?>" data-id="3" >3 Days</button>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-6 col-4">
                                    <button class="btn bb-new-btn btn-2 btn2 <?php echo ($days==2) ? 'activeBtnDays' : ''?>" data-id="2">2 Days</button>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-6 col-4">
                                    <button class="btn bb-new-btn btn-1 btn1 <?php echo ($days==1) ? 'activeBtnDays' : ''?>" data-id="1">1 Day</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-12" >
                        <div class="input-group search_div">
                            <div class="input-group-prepend" style="margin-bottom:5px;">
                                <span class="searchicon searchbyEmail" id=""><img src="<?php echo url('/');?>/public/images/search.png?q=<?php echo rand();?>" class=" mt-2"></span>
                            </div>
                            <input type="text" class="form-control searchbar" placeholder="BestBOX User ID" aria-label="Username" aria-describedby="basic-addon1" id="searchKey" value="{{ $searchKey }}">
                        </div>
                        </div>
                    </div>
                </div>
                <?php //echo safe_decrypt('yslyOSd6GM4Cf1PDAy/C4g==',config('constants.encrypt_key'));?>
                <div class="bb_new_table">
                    @If($customers->count())
                    <table role="table"class="w-100">
                        <thead role="rowgroup">
                            <tr role="row">
                            <th role="columnheader">No</th>
                            <th role="columnheader">Status</th>
                            <th role="columnheader">Date</th>
                            <th role="columnheader" class="text-center">BestBOX<br>User ID</th>
                            @If($userInfo['admin_login'] == 1)
                            <th role="columnheader" class="text-center">BestBOX<br>Password </th>
                            <th role="columnheader" class="text-center">Supplier<br>User ID</th>
                            <th role="columnheader" class="text-center">Supplier<br>Password</th>
                            @endIf
                            <th role="columnheader">Package</th>
                            <th role="columnheader">Expiry</th>
                            @If($userInfo['admin_login'] == 1)
                            <th role="columnheader">Set Reminder</th>
                            @endIf
                            </tr>
                        </thead>
                        <tbody role="rowgroup">
						 <?php
							 $package_total_value = 0;
							 $i=1;

								foreach($customers as $customer){
                                    $package_total_value += $customer['effective_amount'];
                                    $decrypted_username = safe_decrypt($customer['cms_username'],config('constants.encrypt_key'));
                                    $decrypted_cmspwd = safe_decrypt($customer['cms_password'],config('constants.encrypt_key'));

                                    $qs = \App\Purchase_order_details::where('user_id',$customer['rec_id'])->orderBy('rec_id','DESC')->first();
                                    $ordDet = \App\Purchase_order_details::where('user_id',$customer['rec_id'])->orderBy('rec_id','DESC')->get();
									$pkgdata = \App\Package_purchase_list::where('user_id',$customer['rec_id'])->where('active_package',1)->where('package_id','!=',11)->orderBy('rec_id','DESC')->first();

									if($customer['id'] != 11){
										if(!empty($pkgdata) && $pkgdata->expiry_date != ''){
											//$pkg_status = $pkgdata->expiry_date < NOW() ? 'Expired' : 'Active';
                                            $pkg_expiry_date = date('Y-m-d',strtotime($pkgdata->expiry_date));
                                            $currentDate = date('Y-m-d');
                                            $daysLeft = strtotime($pkgdata->expiry_date) - strtotime($currentDate);
                                            $noOfdays = $daysLeft/(60 * 60 * 24)+1;
                                            //$noOfdays = $daysLeft/(60 * 60 * 24);
                                            //echo $customer['user_id'].'--'.$noOfdays;
                                            if($pkgdata->expiry_date < NOW()){
												$pkg_status = "Expired";
												$status_class = "inactive_lab";
											}else{
												$pkg_status = "Active";
												$status_class = "active_lab";
											}
										}else{
											$pkg_status = "---";
											$status_class ="";
                                            $pkg_expiry_date = "";
                                            $noOfdays = 0;
										}
									}else{
										$pkg_status = "---";
										$status_class ="";
                                        $pkg_expiry_date = "";
                                        $noOfdays = 0;
                                    }

                                    $bestbox_password= ($customer['plain_password']!='') ? safe_decrypt($customer['plain_password'],config('constants.encrypt_key')) : '---';

                                ?>
                                    <tr role="row" class="seven_days">
                                    <td role="cell"><?php echo $i;?></td>
                                        <td role="cell text-right">
                                        <span class="<?php echo $status_class; ?>"><?php echo $pkg_status; ?></span>
                                        </td>
                                        <td role="cell">
                                           @php
                                                echo \App\Http\Controllers\home\ReportController::convertTimezoneDate($customer['registration_date']);
                                            @endphp
                                        </td>
                                        <td role="cell" class="black_txt font-weight-bold rowBG1 text-center">{{ $customer['user_id'] }}</td>
                                        @If($userInfo['admin_login'] == 1)
                                        <td role="cell" class="black_txt font-weight-bold rowBG1 text-center">{{ $bestbox_password }}</td>
                                        <td role="cell" class="black_txt font-weight-bold rowBG2 text-center">
										<?php if(!empty($decrypted_username)){echo $decrypted_username;}else{echo "---";}?>
										</td>
                                        <td role="cell" class="black_txt font-weight-bold rowBG2 text-center">
										<?php if(!empty($decrypted_cmspwd)){echo $decrypted_cmspwd;}else{echo "---";}?>
										</td>
                                        @endIf
                                        <td role="cell" class="blue_txt font-weight-bold">
                                           {{ ($customer['package_name']!='') ? $customer['package_name'] : '-' }}
                                        </td>
                                        <td role="cell" class="green_txt font-weight-bold">
                                            <?php echo date('d/m/Y', strtotime($pkg_expiry_date)); ?>
                                        </td>
                                        @If($userInfo['admin_login'] == 1)
                                        <td role="cell">
                                        @if(floor($noOfdays) <= 7)
                                            <a href="" class="btn-reminder" data-toggle="modal" data-target="#myModal" data-userid="<?php echo $customer['user_id'];?>" data-recid="<?php echo $customer['rec_id'];?>" data-name="<?php echo $customer['first_name']." ".$customer['last_name']; ?>" data-days="<?php echo floor($noOfdays);?>">Reminder</a>
                                        @endIf
                                            <!-- <span><a href="" class=""><img src="<?php //echo url('public/images/whatsapp.png')?>"/></a></span> -->
                                        </td>
                                        @endIf
                                    </tr>
							<?php
										$i++;
							   }
							?>
                        </tbody>
                    </table>
                     @else
                        <div class="w100 norecord_txt">No Records Found</div>
                    @endIf

                   <?php
					if($customers->total()>0){
					?>
                        <div>
                           <?php echo $customers->appends(['searchKey' =>'', 'from_date' => '', 'to_date' => '' ])->links();?>
                        </div>
				   <?php } ?>
                </div>
            </div>
        </section>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog active_line_modal">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <div class="modal-title">SEND REMINDER</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body text-center">
                    <div class="f25 my-3">Would you like to send the</div>
                    <div class="f50 my-3">Expiry Reminder</div>
                    <div class="f25 my-3">to</div>
                    <div class="f25 my-3" id="remainder_content"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer p-0">
                    <button type="button" class="btn btn-bb-modal-footer w-100" data-dismiss="modal" id="send_remainder" data-userid="" data-days="" data-name="">SEND NOW</button>
                </div>

            </div>
        </div>
    </div>

    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <?php
        if(Session::has('result')){
    ?>
        <script type="text/javascript">

            setTimeout(function() {
                swal({
                    title: "Success",
                    text: "<?php echo Session::get('result');?>",
                    type: "success"
                });
            }, 50);
        </script>
    <?php
        }
    ?>
    <script>
        $(".btn-reminder").click(function(e){
            e.preventDefault();var html = '';
            var username = $(this).attr('data-name');
            var user_id = $(this).attr('data-userid');
            var rec_id = $(this).attr('data-recid');
            var days = $(this).attr('data-days');
            $("#send_remainder").attr('data-userid',rec_id);
            $("#send_remainder").attr('data-name',username);
            $("#send_remainder").attr('data-days',days);
            html += 'Name :<strong>'+username+'</strong><br/>';
            html += 'UserId :<strong>'+user_id+'</strong><br/>';
            $('#remainder_content').html(html);
        });
        //send expire package remainder mail to customer
        $("#send_remainder").click(function(e){
            var csrf_Value = "<?php echo csrf_token(); ?>";
            var days = $(this).attr('data-days');
            var username = $(this).attr('data-name');
            var user_id = $(this).attr('data-userid');
            $.ajax({
                type: "POST",
                url: "<?php echo url('/').'/sendRenewalRemainder';?>",
                data: { 'days' : days, "name" : username, "user_id" : user_id,"_token": csrf_Value }, // serializes the form's elements.
                dataType: "json",
                success: function (data) {
                    if (data.status == 'Success') {
                        setTimeout(function() {
                            swal({
                                title: "Success",
                                text: data.Result,
                                type: "success"
                            });
                        }, 50);
                    }
                }
            });
        });


		var url = "<?php echo url('/activeLine'); ?>";

        $("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                $("#from_date").val('');
                $("#to_date").val('');
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey+'&from_date=&to_date=&status=&page=0';
            }
        });


		$(".btn7,.btn3,.btn2,.btn1").on('click',function(event){
            //var keycode = (event.keyCode ? event.keyCode : event.which);

			var days = $(this).attr("data-id");
			//var status = $('.activeBtn').attr("data-id");

            if(days != ""){
                location.href = url+'?days='+days+'&page=0';
				//location.href = url+'?days='+days+'&status='+status+'&page=0';
            }else{
				alert("Test");
			}
        });
		$(".on, .off").on('click',function(event){

			var status = $(this).attr("data-id");
            location.href = url+'?status='+status+'&page=0';
        });
		// $(".off").on('click',function(event){

		// 	var status = $(this).attr("data-id");
        //     location.href = url+'?status='+status+'&page=0';
        // });

		$(".btn-all").on('click',function(event){
            location.href = url;
        });
    </script>
</body>

</html>
