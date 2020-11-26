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
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Trail Accounts </h5>

          <div class="col-xl-11 col-lg-12">
                <div class="row clearfix">
                    <a href="<?php echo url('/');?>/prospectsList" ><button class="btn tab_btn ">Prospects (<?php echo ($prospects_count)?$prospects_count:0; ?>)</button></a>
                    <!-- <a href="<?php echo url('/');?>/testAccountStatusList"><button class="btn tab_btn_active">Trial Account Status </button></a> -->
                    <a href="<?php echo url('/');?>/requestTrialsList"><button class="btn tab_btn ">Trial Requests (<?php echo ($requested_count)?$requested_count:0; ?>)</button></a>
                    <!-- <a href="<?php echo url('/');?>/testCMSAccounts"><button class="btn tab_btn">Trial Account setup (<?php //echo ($test_accounts_count)?$test_accounts_count:0; ?>)</button> </a>   -->
                    <a href="<?php echo url('/');?>/addFreetrail"><button class="btn tab_btn_active">Add Trail Period</button> </a>
                </div>
          </div>
          <div class="col-12">
            <div class="clearfix row">
                <div class="trail_statustable">
                    <div class="status_table_titles clearfix">
                            <div class="tw-8 pl-1">Sl No</div>
                            <div class="tw-10 pl-1">
								<dl class="dropdown">
									<dt><a><span>Status </span><i class="fas fa-chevron-down drop_arrow"></i></a> </dt>
										<dd>
											<ul>
												<li><a class="default">Status <i class="fas fa-chevron-down drop_arrow"></i></a> </li>
												<li><a>Busy</a></li>
												<li><a>Free</a></li>
											</ul>
										</dd>
								</dl>
                            </div>
                            <div class="tw-15 pl-1">Supplier User ID</div>
                            <div class="tw2-15 pl-1">Supplier Password</div>
                            <div class="tw-20 pl-1">Customer Email ID</div>
                            <div class="tw-14 pl-1">Start Time</div>
                            <div class="tw-14 pl-1">End Time</div>
                            <div class="tw-13 pr-1 text-right">Balance Duration<br>(H/M) </div>
                        </div>

						<?php
							$i=1;
							if(@count($cms_info) >0 ){
								//echo "<pre>";print_r($cms_info);exit;
							  foreach($cms_info as $res){
								//$cms_username = $res->cms_username;
								//$cms_password = $res->cms_password;
								$channel_id = $res->rec_id;
								$cms_username=safe_decrypt($res->cms_username,config('constants.encrypt_key'));
                                $cms_password=safe_decrypt($res->cms_password,config('constants.encrypt_key'));
								$is_available = $res->is_available;
								if($is_available == 1){
									$status_msg = "Free";
									$staus_cls = "free_lable";
								}else{
									$status_msg = "Busy";
									$staus_cls = "busy_lable";
								}

								$request_info = \App\Free_trail_requested_users::where("status","=",1)->where("channel_id","=",$channel_id)->first();

								$email ="";$fullName="";$telephone="";$userID="";
								if(!empty($request_info)){

									$user_id = $request_info->user_id;
									$trail_start_time = $request_info->trail_start_time;
									$trail_end_time = $request_info->trail_end_time;

									$userinfo = \App\User::where('rec_id', $user_id)->first();


									if(!empty($userinfo)){
										$fullName = $userinfo->first_name." ".$userinfo->last_name;
										$email = $userinfo->email;
										$userID = $userinfo->user_id;
										$telephone = $userinfo->telephone;
									}

								}else{
									$trail_start_time = "";
									$trail_end_time = "";
								}




						?>
                        <!-- ROW --1 -->
                        <div class="status_table_row clearfix">
                            <div class="tw-8 pl-1 ">
                               <?php echo $i; ?>
                            </div>
                            <div class="tw-10 pl-1 ">
                                <div class="<?php echo $staus_cls; ?>"><?php echo $status_msg; ?></div><br>

                            </div>
                            <div class="tw-15 pl-1 word-break">
                               <?php echo $cms_username; ?>
                            </div>
                            <div class="tw-15 pl-1 word-break font_resize">
                               <?php echo $cms_password; ?>
                            </div>
                            <div class="tw-20 pl-1 word-break">
                                <?php echo $email; ?>
                            </div>
                            <div class="tw-14 pl-1 green_txt font-weight-bold">
                                <?php
									if(!empty($trail_start_time)){
										echo date("d-m-Y H:i A",strtotime($trail_start_time));
									}else{
										echo "";
									}


								?>
                            </div>
                            <div class="tw-14 pl-1 red_txt font-weight-bold " >

							<?php
									if(!empty($trail_end_time)){
										echo date("d-m-Y H:i A",strtotime($trail_end_time));
									}else{
										echo "";
									}


								?>
                            </div>
                            <div class="tw-13 pr-1 orange_txt font-weight-bold  text-right">
                                <?php
								if(!empty($trail_start_time) && !empty($trail_end_time)){

									$current_date1 = date('Y-m-d H:i:s');
									$cur = strtotime($trail_end_time) - strtotime($current_date1);
									echo date("H:i",$cur);
									//$hourdiff = round((strtotime($trail_end_time) - strtotime($current_date1))/3600,2);
									//echo $hourdiff;



								}else{

									echo "";
								}


								?>
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

				 <?php if(@count($cms_info) >0 ){ ?>
					 <div class="pagi">
						<?php echo $cms_info->links();?>
					</div>
				  <?php } ?>

            </div>
            </div>

        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

<script>
var dropdowns = $(".dropdown");

// Onclick on a dropdown, toggle visibility
dropdowns.find("dt").click(function(){
	dropdowns.find("dd ul").hide();
	$(this).next().children().toggle();
});

// Clic handler for dropdown
dropdowns.find("dd ul li a").click(function(){
	var leSpan = $(this).parents(".dropdown").find("dt a span");

	// Remove selected class
	$(this).parents(".dropdown").find('dd a').each(function(){
    $(this).removeClass('selected');
  });

	// Update selected value
	var res = leSpan.html($(this).html());

	// If back to default, remove selected class else addclass on right element
	if($(this).hasClass('default')){
		leSpan.removeClass('selected')
	 }else{
		leSpan.addClass('selected');
		$(this).addClass('selected');
	}

	// Close dropdown
	$(this).parents("ul").hide();
});

// Close all dropdown onclick on another element
$(document).bind('click', function(e){
	if (! $(e.target).parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});
</script>

<script type="text/javascript">
	var url = "<?php echo url('/testAccountStatusList'); ?>";
	var dropdowns = $(".dropdown");

	dropdowns.find("dd ul li a").click(function(e){
		e.preventDefault();
		var searchKey = $(this).parents(".dropdown").find("dt a span").text();

		//var searchKey = $("#searchKey").val().trim();

		var searchUrl = url+'?searchKey='+searchKey;
		location.href = searchUrl;

	});
</script>

</body>
</html>
