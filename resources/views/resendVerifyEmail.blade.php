<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Resend Verify Email</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")

    <style>
    .table_div{
        padding:0 !important;
    }
	.resendBtn,.deleteBtn{
		cursor: pointer;
	}
    @media (max-width:1350px){
        .table_div .font16{
            font-size:14px !important;
        }
        .circle_btn{
            margin-left:5px !important;
        }
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
            <h5 class="font16 font-bold text-uppercase black_txt p-3 pt-4">Resend Verify E-mails</h5>


            <div class="row mt-4">
                <!-- Filter section -->
                <div class="filter_wrp col-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            <div class="row">

								<div class="col-md-12 col-lg-4 px-2">
                                    <div class="mb-3 position-relative">
                                        <input type="text" class="form-control h50 " placeholder="User ID / E-mail" aria-label="Username" aria-describedby="basic-addon1" id="searchKey" value="<?php echo ($searchKey)?$searchKey:""; ?>">
                                      <!--   <span class="addon-icon"><img src="<?php echo url('/');?>/public/images/search.png"></span> -->
                                    </div>
                                </div>
                                <div class="col-md-2 col-6 px-2 ">
                                    <a href="javascript::void(0);" class="print_btn" id="filter_data">
                                        Filter
                                    </a>
                                </div>
                                <div class="col-md-2 col-6 px-2">
                                    <a href="javascript::void(0);" class="print_btn" id="clear_filter_data">
                                        Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-5 text-left">
                            <div class="row">
                            <div class="col-6" style="display:none;">
                                    <div class="mb-3 position-relative">
                                        <input type="text" class="form-control h50 pl-5" placeholder="User ID or Name" aria-label="Username" aria-describedby="basic-addon1" id="searchKey" value="">
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
                        <!-- <table class="rwd-table body_bg">

                        </table> -->
                        <div class="table_div clearfix d-none d-lg-block">
                            <div class="font16 blue_txt font-bold body_bg table_div_head clearfix mb-3">
                                <div class="font16 blue_txt font-bold w10 table_div_cell">Date</div>
                                <div class="font16 blue_txt font-bold w13 table_div_cell">User ID</div>
                                <div class="font16 blue_txt font-bold w17 table_div_cell">Name</div>
                                <div class="font16 blue_txt font-bold w25 table_div_cell">E-mail</div>
                                <div class="font16 blue_txt font-bold w10 table_div_cell">Type</div>
                                <div class="font16 blue_txt font-bold w15 table_div_cell text-center">E-mail Status</div>
                                <div class="font16 blue_txt font-bold w10 table_div_cell text-center">Actions</div>
                            </div>

                            <div class="middle_box">

                                @if($resendEmailsList->count())
                                @foreach($resendEmailsList as $res)

                                <div class="grid_wrp">
                                    <div class="grid_body clearfix">
                                        <!-- Row 1 -->
                                        <div class="grid_row clearfix border-top agent_row">
                                            <div class="w10 float-left font16 dark-grey_txt px-2">
                                                @php
                                                    echo \App\Http\Controllers\home\ReportController::convertTimezone($res['registration_date']);
                                                @endphp
                                            </div>
                                            <div class="w13 float-left font16 dark-grey_txt px-2 word-break-all">{{ $res['user_id'] }}</div>
											<?php
												$fullName = ucwords($res['first_name'].' '.$res['last_name']);
												if(!empty($fullName)){
													$name =  $fullName;
												}else{
													$name = "&nbsp;";
												}
												?>
                                            <div class="w17 float-left font16  px-2 word-break"><?php echo $name; ?></div>
                                            <div class="w25 float-left font16 px-2 word-break-all">{{ $res['email'] }}</div>
                                            <?php
												$res1 = \App\RolesPermissions::where('id', $res['user_role'])->first();
												if(!empty($res1)){
													$type = $res1->role_name;
												}else{
													 $type = "----";
												}

                                                ?>
                                            <div class="w10 float-left font16  px-2"><?php echo $type; ?></div>
                                            <div class="w15 float-left font16 blue_txt text-center px-2">
                                                <span style="color:red;">Not Verify</span>
                                            </div>
                                            <div class="w10 float-left font16 text-center px-2">
                                                <div class="circle_btn resendBtn" data-id="<?php echo $res['rec_id']; ?>"><i class="fa fa-envelope" aria-hidden="true"></i></div>
												<div class="circle_btn deleteBtn" data-id="<?php echo $res['rec_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></div>
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

                        <div id="accordion" class="d-lg-none d-block my-3">
                            @if($resendEmailsList->count())
                                @foreach($resendEmailsList as $res)
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm-6 col-5">
                                            {{ ucwords($res['first_name'].' '.$res['last_name']) }}
                                        </div>

                                        <div class="col-sm-4 col-5 text-right">
                                            <a href="#" class="f12">
                                                <div class="circle_btn resendBtn" data-id="<?php echo $res['rec_id']; ?>"><i class="fa fa-envelope" aria-hidden="true"></i></div>
												<div class="circle_btn deleteBtn" data-id="<?php echo $res['rec_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                            </a>
                                        </div>

                                        <div class="col-2 text-right">
                                            <a class="card-link" data-toggle="collapse" href="#collapse{{ $loop->iteration }}">
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <div id="collapse{{ $loop->iteration }}" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row my-1">
                                            <div class="col-5 text-blue">Date</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6">
                                                @php
                                                    echo \App\Http\Controllers\home\ReportController::convertTimezone($res['registration_date']);
                                                @endphp
                                            </div>
                                        </div>

                                        <div class="row my-1">
                                            <div class="col-5 text-blue">User ID</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6">{{ $res['user_id'] }}</div>
                                        </div>

                                        <div class="row my-1">
                                            <div class="col-5 text-blue">Email</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6">{{ $res['email'] }}</div>
                                        </div>
                                         <?php
												$res = \App\RolesPermissions::where('id', $res['user_role'])->first();
												if(!empty($res)){
													$type = $res->role_name;
												}else{
													 $type = "----";
												}

                                                ?>
                                        <div class="row my-1">
                                            <div class="col-5 text-blue">Type</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6"><?php echo $type; ?></div>
                                        </div>

                                        <div class="row my-1">
                                            <div class="col-5 text-blue">E-mail Status</div>
                                            <div class="col-1">:</div>
                                            <div class="col-6">Not Verify</div>
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

			@if($resendEmailsList->total()>0)
				<?php echo $resendEmailsList->appends(['searchKey' =>'', 'from_date' => '', 'to_date' => '' ])->links();?>
            @endIf
        </section>
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
    var url = "<?php echo url('/resendVerifyEmail'); ?>";

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
        //var from_date = $("#from_date").val().trim();
        //var to_date = $("#to_date").val().trim();
        var searchKey = $("#searchKey").val().trim();
        if(searchKey == '' ) {
            alert('Please Enter E-mail / User ID');
            return false;
        }else{
            var searchUrl = url+'?searchKey='+searchKey;
            location.href=searchUrl;
        }
    });

    /* clear filter data */
    $("#clear_filter_data").click(function(e){
        e.preventDefault();
        //$("#from_date").val('');
        //$("#to_date").val('');
        //var searchKey = $("#searchKey").val().trim();
        //var searchUrl = url+'?searchKey='+searchKey+'&from_date=&to_date=status=&page=0';
        //location.href=searchUrl;

		var searchKey = $("#searchKey").val('');
		location.href="<?php echo url('/resendVerifyEmail'); ?>";

    });

    $(document).ready(function(){
        $("#fromDate").datepicker({
            autoclose: true,
            todayHighlight: true
        });

        $("#toDate").datepicker({
            autoclose: true,
            todayHighlight: true
        });
    });

    $(".resendBtn").click(function(){
        var rec_id = $(this).attr("data-id");
		//alert(rec_id);return false;
        var csrf_Value= "<?php echo csrf_token(); ?>";
        $.ajax({
            url: "<?php echo url('/');?>/resendVerifyEmailToUser",
            method: 'POST',
            dataType: "json",
            data: {'rec_id': rec_id,"_token": csrf_Value},
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
					return true;

				}else{
					alert(data.Result);
					return false;
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
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

		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) {
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
		});



	// delete user

	  $(".deleteBtn").click(function(e){
            e.preventDefault();
            var rec_id = $(this).attr("data-id");
			//alert(rec_id);return false;
			var csrf_Value= "<?php echo csrf_token(); ?>";
            setTimeout(function(){
                    swal({
                        title: 'Are you sure you want delete ?',
                        //text: "Your withdrawal <b>"+transfer_amount+" USD</b> will be transafer to user <b>"+user_name+"</b> wallet.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4FC550',
                        cancelButtonColor: '#D0D0D0',
                        confirmButtonText: 'Yes, proceed it!',
                        closeOnConfirm: false,
                        //html: transfer_amount+" USD</b> transfer to user </br><b>"+user_name+"</b> wallet."
                    }).then(function (result) {
                        if (result.value) {


							$.ajax({
								url: "<?php echo url('/');?>/deleteInvalidEmail",
								method: 'POST',
								dataType: "json",
								data: {'rec_id': rec_id,"_token": csrf_Value},
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
										return true;

									}else{
										alert(data.Result);
										return false;
									}
								},
								error:function (xhr, ajaxOptions, thrownError){
									alert(thrownError);
								}
							});


                        }
                    }).catch(swal.noop);
            },100);

        });


    </script>

</body>
</html>
