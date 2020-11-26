<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")
	<style>
		.tab_btn_active a{color:#fff;text-decoration:none;}
        .swal2-content{
            display: block;
            background-color: #efefef;
            text-align: left !important;
            padding: 10px 20px !important;
            margin: 10px -20px !important;
            color:#000 !important;
        }
         .swal2-content b{
            margin-left:50px;
            color:#F67E51;
            font-weight:bold;
         }
		 .trail_requesttable .tw-5 {
			width: 5%;
			float: left;
		}
		.trail_requesttable .tw2-10 {
			width: 10%;
			float: left;
		}
		.activate_btn_disable {
			color: #ffffff;
			border-radius: 4px;
			text-transform: uppercase;
			text-align: center;
			display: inline-block;
			padding: 3px 10px;
			font-weight: bold;
			font-size: 15px;
			background-color: #54b164;
			border: none;
		}

	</style>

</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content sales_transaction">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Trial Accounts </h5>

          <div class="">
				<div class="col-12">
					<div class="row clearfix">
						 <a href="<?php echo url('/');?>/prospectsList" ><button class="btn tab_btn ">Prospects (<?php echo ($prospects_count)?$prospects_count:0; ?>)</button></a>
						<!-- <a href="<?php echo url('/');?>/testAccountStatusList"><button class="btn tab_btn">Trial Account Status </button></a> -->
						<a href="<?php echo url('/');?>/requestTrialsList"><button class="btn tab_btn_active ">Trial Requests (<?php echo ($requested_count)?$requested_count:0; ?>)</button></a>
					    <a href="<?php echo url('/');?>/addFreetrail"><button class="btn tab_btn">Add Trail Period</button> </a>

						<!-- <a href="<?php echo url('/');?>/testCMSAccounts"><button class="btn tab_btn">Trial Account setup (<?php //echo ($test_accounts_count)?$test_accounts_count:0; ?>)</button> </a> -->
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-3 col-xl-3 pl-0 mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control bbcustinput" placeholder="User ID or Email ID" id="searchKey" value="<?php echo ($searchKey)?$searchKey:""; ?>" aria-label="Username" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary px-2 serchBtn1" type="button" id="button-addon1 ">
                                <img src="/public/images/search.png" class=" mt-0">
                            </button>
                        </div>
                    </div>
                </div>
          </div>
          <div class="col-12">
            <div class="clearfix row">
                <div class="trail_requesttable">
                    <div class="request_table_titles clearfix">
                            <div class="tw-5 pl-1">Sl No</div>
                            <div class="tw-15 pl-1">Date</div>
							<div class="tw-10 pl-1">User ID</div>
                            <div class="tw-20 pl-1">Email ID</div>
                            <div class="tw-15 pl-1">Name</div>
                            <div class="tw2-10 pl-1">Mobile Number</div>
                            <div class="tw3-10 pr-1 ">Activate</div>
                            <div class="tw2-15 pl-1 text-right">Start-End Date</div>
                        </div>

						<?php
							$i=1;
							if(@count($requested_info) >0 ){
								//echo "<pre>";print_r($cms_info);exit;
							  foreach($requested_info as $res){

								$user_id = $res->user_id;
								$created_at = $res->created_at;

								$status = $res->status;

								$userinfo = \App\User::where('rec_id', $user_id)->first();

								$email ="";$fullName="";$telephone="";$userID="";
								if(!empty($userinfo)){
									$fullName = $userinfo->first_name." ".$userinfo->last_name;
									$email = $userinfo->email;
									$userID = $userinfo->user_id;
									$telephone = $userinfo->telephone;
								}


						?>

                        <div class="request_table_row clearfix">
                            <div class="tw-5 pl-1"><?php echo $i; ?></div>
                            <div class="tw-15 pl-1"><?php echo date("d/m/Y H:i A",strtotime($created_at)); ?></div>
							 <div class="tw-10 pl-1"><?php echo $userID; ?></div>
                            <div class="tw-20 pl-1"><?php echo $email;?></div>
                            <div class="tw-15 pl-1"><?php echo $fullName; ?></div>
                            <div class="tw2-10 pl-1"><?php echo ($telephone)?$telephone:"---"; ?></div>

                            <div class="tw3-10 pr-1 text-left">
								<?php
								if($status == 3){
								?>
								<button class="activate_btn_disable">Approved</button><br/>
								<span style="font-size:10px;">Waiting for Customer Activation</span>
								<?php }else{?>
									<button class="activate_btn_disable">-</button>
								<?php }
								/*else if($status == 2){
										$status_msg = "Expired";
										$status_msg_cls = "red";
									}else if($status == 1){
										$status_msg = "Going On";
										$status_msg_cls = "green";
									}else{
										$status_msg = "-";
										$status_msg_cls = "green";
									}*/
									?>
                                <!--<button class="<?php //echo $status_msg_cls; ?>"><?php //echo $status_msg;?></button>-->

                            </div>
                            <div class="tw3-15 pr-1 text-right">
                            	<?php
								if($status == 1){

									if(!empty($res['trail_start_time'])){
									    echo date("d-m-Y H:i:s",strtotime($res->trail_start_time));
									}else{
										echo "---";
									}
								echo '-<br/>';

									if(!empty($res['trail_end_time'])){
									    echo date("d-m-Y H:i:s",strtotime($res->trail_end_time));
									}else{
										echo "---";
									}
								}else{
									echo '-';
								}?>


                            </div>
                        </div>

						<?php
							$i++;
							  }
							}else{
						?>

						 <div class="status_table_row clearfix">
							 <h2>No Records Found</h2>
						</div>
						<?php } ?>



                </div>
				 <?php if(@count($requested_info) >0 ){ ?>
					 <div class="pagi">
						<?php echo $requested_info->links();?>
					</div>
				  <?php } ?>

            </div>
            </div>

        </section>

			<!-- The Modal -->
<div class="modal fade" id="test_active_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header border-bottom-0 pb-0">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body text-center">
          <img src="<?php echo url('/');?>/public/images/alert_icon.png" class="mb-4">
          <h3 class="black_txt font-weight-bold mb-3">Are you sure?</h3>
          <p class="f16 black_txt">To Activate <span class="font-weight-bold">Trial Acount</span></p>
		  <div id="recid" style="display:none;"></div>
          <div class="modal_md_bg">
                <div class="col-12">
                    <div class="row">
                            <div class="col-2 f16 black_txt">Name</div>
                            <div class="col-10">: <span class="f18 orange_txt font-weight-bold" id="username"></span> </div>
                            <div class="col-2 f16 black_txt">E-mail</div>
                            <div class="col-10">: <span class="f18 orange_txt font-weight-bold" id="useremail"></span> </div>
                    </div>
                </div>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer border-top-0 text-center custom_modal_footer">
          <button type="button" class=" modal_cancel_btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="modal_proceed_btn" id="saveActivateBtn" data-dismiss="modal">Yes, Proceed</button>
        </div>
        <br>
      </div>
    </div>
  </div>

    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

	<script type="text/javascript">
		var url = "<?php echo url('/requestTrialsList'); ?>";


        $("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey;
            }
        });


		$(".serchBtn1").on('click',function(e){
             e.preventDefault();
			var searchKey = $("#searchKey").val();
            if(searchKey != ""){
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey;
            }else{
				alert("Please enter E-mail or User ID");
				return false;
			}
        });

	</script>

	<script type="text/javascript">

		$(".activate_btn").click(function(e){
            e.preventDefault();
            var rec_id = $(this).attr("data-id");
			var name =$(this).attr("data-name");
			var email = $(this).attr("data-email");
			//alert(rec_id);return false;
			$("#test_active_modal").modal("show");
			$("#recid").text(rec_id);
			$("#username").text(name);
			$("#useremail").text(email);
        });


		$("#saveActivateBtn").click(function(e){
            e.preventDefault();
            var rec_id = $("#recid").text();
			var name =$("#username").text();
			var email = $("#useremail").text();
			//alert(rec_id);return false;
			var token = "<?php echo csrf_token() ?>";

			if(rec_id){

				$.ajax({
					url: "<?php echo url('/');?>/trialAccountActivated",
					method: 'POST',
					dataType: "json",
					data: {'rec_id': rec_id,"_token": token},
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) {
					   if(data.status=='Success'){
							//$('#successModel').modal('show');
							//$('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>');
							window.location.reload();
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

			}else{
				alert("rec id missing");
				return false;
			}

        });
	</script>


</body>
</html>
