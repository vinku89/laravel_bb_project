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
						<a href="<?php echo url('/');?>/prospectsList" ><button class="btn tab_btn_active ">Prospects (<?php echo ($prospects_count)?$prospects_count:0; ?>)</button></a>
						<!-- <a href="<?php echo url('/');?>/testAccountStatusList"><button class="btn tab_btn">Trial Account Status </button></a> -->
						<a href="<?php echo url('/');?>/requestTrialsList"><button class="btn tab_btn ">Trial Requests <!--(<?php echo ($requested_count)?$requested_count:0; ?>)--></button></a>
						<!-- <a href="<?php echo url('/');?>/testCMSAccounts"><button class="btn tab_btn">Trial Account setup(<?php //echo ($test_accounts_count)?$test_accounts_count:0; ?>)</button> </a> -->
                        <a href="<?php echo url('/');?>/addFreetrail"><button class="btn tab_btn">Add Trail Period</button> </a>
                    </div>
			  </div>



				<div class="col-12 col-sm-6 col-md-3 col-xl-3 pl-0 mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control bbcustinput" placeholder="User ID or Email ID" id="searchKey" value="<?php echo ($searchKey)?$searchKey:""; ?>" aria-label="Username" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary px-2 serchBtn1" type="button" id="button-addon1">
                                <img src="/public/images/search.png" class=" mt-0">
                            </button>
                        </div>
                    </div>
                </div>
		</div>



          <div class="col-12">
            <div class="clearfix row">
                <div class="trail_table">
                    <div class="trail_table_titles clearfix">
						<div class="tw-8 pl-1">Si.No</div>
						<div class="tw4-10 pl-1">User ID</div>
						<div class="tw-22 pl-1">Email ID</div>
						<div class="tw-17 pl-1">Name</div>
						<div class="tw-10 pl-1">Mobile No</div>
						<div class="tw2-10 pl-1">Test Date</div>
						<div class="tw3-13 pl-1">Trial Status</div>

						<div class="tw5-10 pl-1">Sale Contextual<br>Yes (Y) / No (N)</div>
                    </div>
						<?php
							$i=1;
							if(@count($prospects_info) >0 ){
							  foreach($prospects_info as $res){
								$user_id = $res['user_id'];
								$status = $res['status'];

								if($status == 2){
									$status_msg = "Completed";
								}else{
									$status_msg = "";
								}

								$userinfo = \App\User::where('rec_id', $user_id)->first();

								$email ="";$fullName="";$telephone="";$userID="";$sale_status = "";
								if(!empty($userinfo)){
									$fullName = $userinfo->first_name." ".$userinfo->last_name;
									$email = $userinfo->email;
									$userID = $userinfo->user_id;
									$telephone = $userinfo->telephone;

									$packagesInfo = \App\Package_purchase_list::select('*')->where('user_id','=',$user_id)->where('active_package','=',1)->orderBy("rec_id", "DESC")->first();

									if(!empty($packagesInfo)){

										if($packagesInfo->expiry_date == NULL){
											$sale_status = "N";
										}else{
											$sale_status = "Y";
										}

									}else{
										$sale_status = "N";
									}


								}


						?>

							<!-- ROW --1 -->
							<div class="trail_table_row clearfix">
								<div class="tw-8 pl-1 trial_brbtm">
									<span class="m_title">Si.No</span>
									<?php echo $i; ?>
								</div>
								<div class="tw4-10 pl-1 trial_brbtm font-weight-bold" >
									<span class="m_title">User ID</span>
										<?php echo $userID; ?>
								</div>
								<div class="tw-22 pl-1 trial_brbtm">
									<span class="m_title">Email ID</span>
									<?php echo $email; ?>
								</div>
								<div class="tw-17 pl-1 trial_brbtm">
									<span class="m_title">Name</span>
									<?php echo ucfirst($fullName); ?>
								</div>
								<div class="tw-10 pl-1 trial_brbtm">
									<span class="m_title">Mobile No</span>
									<?php echo ($telephone)?$telephone:"----"; ?>
								</div>
								<div class="tw2-10 pl-1 green_txt font-weight-bold trial_brbtm-767 f12">
									<span class="m_title">Test Date</span>
									<?php echo date("d-m-Y H:i A",strtotime($res['trail_start_time']));?>
								</div>
								<div class="tw3-13 pl-1">
									<span class="m_title">Trial Status</span>
									<div class="completed_lable f14">
											<?php echo $status_msg; ?>
									</div>
								</div>

								<div class="tw5-10 pl-1 green_txt font-weight-bold text-center">
									<span class="m_title">Sale Contextual<br>Yes (Y) / No (N)</span>
									<?php echo $sale_status; ?>
								</div>
							</div>
						<?php
							$i++;
							  }
							}else{
						?>
						 <div class="trail_table_row clearfix">
							 <h2>No Records Found</h2>
						</div>
						<?php } ?>

                </div>

				 <?php if(@count($prospects_info) >0 ){ ?>
					<div class="pagi">
						<?php echo $prospects_info->links();?>
					</div>
				  <?php } ?>

            </div>
            </div>

        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

	<script type="text/javascript">
		var url = "<?php echo url('/prospectsList'); ?>";


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

</body>
</html>
