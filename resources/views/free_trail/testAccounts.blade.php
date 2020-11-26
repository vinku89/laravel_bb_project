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

          <div class="col-xl-11 col-lg-12">
                <div class="row clearfix">
                    <a href="<?php echo url('/');?>/prospectsList" ><button class="btn tab_btn">Prospects (<?php echo ($prospects_count)?$prospects_count:0; ?>)</button></a>
                    <!-- <a href="<?php echo url('/');?>/testAccountStatusList"><button class="btn tab_btn">Trial Account Status </button></a> -->
                    <a href="<?php echo url('/');?>/requestTrialsList"><button class="btn tab_btn">Trial Requests (<?php echo ($requested_count)?$requested_count:0; ?>)</button></a>
                    <!-- <a href="<?php echo url('/');?>/testCMSAccounts"><button class="btn tab_btn_active">Trial Account setup (<?php //echo ($test_accounts_count)?$test_accounts_count:0; ?>)</button></a>  -->
                </div>
				
          </div>

        <div class="mid_row_bg">
			
            <form class="form-inline">
                <div class="form-group mb-2">
                    <label class="f16 black_txt font-weight-bold">Supplier User ID</label>
                </div>
                <div class="form-group mx-sm-3 mb-2 pt-1 position-relative">
                    <input type="text" class="form-control" id="cms_username" name="cms_username" placeholder="Enter ID" style="height:50px;">
					          <span class="error errorText_position" id="userNameerror"></span>
                </div>
                <div class="form-group mb-2">
                    <label class="f16 black_txt font-weight-bold">Supplier Password</label>
                </div>
                <div class="form-group mx-sm-3 mb-2 pt-1 position-relative">
                    <input type="password" class="form-control" id="cms_password" name="cms_password" placeholder="Enter Password" style="height:50px;">
					<span class="error errorText_position" id="cmspwderror"></span>
                </div>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" id="test_acc_create">Create test account</button>
            </form> 
			 <span class="error errorText_position23 " id="CMSDetailserror" ></span>
        </div>


          <div class="col-12">
			
			<div class="col-12 col-sm-6 col-md-3 col-xl-3 pl-0 mt-3">
				<div class="input-group">
					<input type="text" class="form-control bbcustinput" placeholder="Supplier User ID" id="searchKey" value="<?php echo ($searchKey)?$searchKey:""; ?>" aria-label="Username" aria-describedby="basic-addon1">
					<div class="input-group-append">
						<button class="btn btn-outline-primary px-2 serchBtn1" type="button" id="button-addon1">
							<img src="/public/images/search.png" class=" mt-0">
						</button>
					</div>
				</div>
            </div>
            <div class="clearfix row">
                <div class="trail_testtable">
                    <div class="trail_testtable_titles clearfix">
                            <div class="tw-10 pl-1">Sl No</div>
                            <div class="tw-20 pl-1">Supplier User ID</div>
                            <div class="tw-50 pl-1">Supplier Password</div>
                            <div class="tw2-20 pl-1">Expiry Date</div>
                        </div>
						<?php
							$i=1;
							if(@count($test_accounts_info) >0 ){
								//echo "<pre>";print_r($cms_info);exit;
							  foreach($test_accounts_info as $res){
								
								$cms_username=safe_decrypt($res->cms_username,config('constants.encrypt_key'));
                                $cms_password=safe_decrypt($res->cms_password,config('constants.encrypt_key'));
								$is_available = $res->is_available;
								
								if(!empty($res->cms_expiry_date)){
									$expiry_date = date('d/m/Y',strtotime($res->cms_expiry_date));
									
									if($res->cms_expiry_date < NOW()){
										$stsmsg = "Expired";
									}else{
										$stsmsg = "Active";
									}
									
								}else{
									$expiry_date = "---";
									$stsmsg = "";
								}

						?>
						
                        <!-- ROW --1 -->
                        <div class="trail_testtable_row clearfix">
                            <div class="tw-10 pl-1"><?php echo $i;?></div>
                            <div class="tw-20 pl-1"><?php echo $cms_username; ?></div>
                            <div class="tw-50 pl-1 f18 font-weight-bold black_txt"><?php echo $cms_password; ?></div>
                            <div class="tw-20 pl-1 f18 font-weight-bold orange_txt">
								<?php echo $expiry_date; ?>	
							</div>
                        </div>
                        <?php
							$i++;
							  }
							}else{
						?>
						 <div class="trail_testtable_row clearfix"> 
							 <h2>No Records Found</h2>  
						</div>
						<?php } ?>
						
						
                        
                </div>
				<?php if(@count($test_accounts_info) >0 ){ ?>
					<div class="pagi">
						<?php echo $test_accounts_info->links();?>
					</div>	
				  <?php } ?>
				
            </div>
            </div>
			<!-- The Modal -->
<div class="modal fade" id="test_acc_modal">
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
          <p class="f16 black_txt">To Create <span class="font-weight-bold">Test Acounts.</span></p>

          <div class="modal_md_bg">
                <div class="col-12">
                    <div class="row">
                            <div class="col-4 f16 black_txt px-0 py-2">Supplier User ID</div>
                            <div class="col-8 py-2">: <span class="f16 orange_txt font-weight-bold" id="cmsusername"></span> </div>
                            <div class="col-4 f16 black_txt px-0 py-2">Supplier Password</div>
                            <div class="col-8 py-2">: <span class="f16 orange_txt font-weight-bold" id="cmspwd"></span> </div>
                    </div>
                </div>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer border-top-0 text-center custom_modal_footer">
          <button type="button" class=" modal_cancel_btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="modal_proceed_btn" id="saveCMSAcc" data-dismiss="modal">Yes, Proceed</button>
        </div>
        <br>
      </div>
    </div>
  </div>
        </section>
        
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
	<script type="text/javascript">
		var url = "<?php echo url('/testCMSAccounts'); ?>";

     
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
		$("#test_acc_create").click(function(e){
            e.preventDefault();
			
			var token = "<?php echo csrf_token() ?>";
            var cms_username = $("#cms_username").val();
			var cms_password = $("#cms_password").val();
			var error = false;
			if (cms_username == "") {
				$('#userNameerror').html("Please Enter Supplier User ID");
				error = true;
			}else {
				$('#userNameerror').html("");
			}
			
			if (cms_password == "") {
				$('#cmspwderror').html("Please Enter Supplier Password");
				error = true;
			}else {
				$('#cmspwderror').html("");
			}
			
			if(!error){
				
				$.ajax({
					url: "<?php echo url('/');?>/checkCMSAccountExist",
					method: 'POST',
					dataType: "json",
					data: {'cms_username': cms_username,'cms_password': cms_password,"_token": token},
					 
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) { 
					   if(data.status=='Success'){
							$('#userNameerror').html("");
							$("#test_acc_modal").modal("show");
							$("#cmsusername").text(cms_username);
							$("#cmspwd").text(cms_password);
							
						}else{
							//alert(data.Result);
							//return false;
							$('#userNameerror').html("CMS User account already exist");
							error = true;
						}  
					},
					error:function (xhr, ajaxOptions, thrownError){
						alert(thrownError);
					}
				});
				
				
			}
			
			
			
        });
		
		// Add CMS Account
		$('#saveCMSAcc').on('click', function(e)  { 
			
			e.preventDefault();
			
			var error = false;
			var token = "<?php echo csrf_token() ?>";
			
			var cms_username = $('#cms_username').val();
			var cms_password = $('#cms_password').val();
			
			
			if (cms_username == "") {
				$('#userNameerror').html("Please Enter CMS UserName");
				error = true;
			}else {
				$('#userNameerror').html("");
			}
			
			if (cms_password == "") {
				$('#cmspwderror').html("Please Enter CMS Password");
				error = true;
			}else {
				$('#cmspwderror').html("");
			}
			
			
			if(!error){
				
				$.ajax({
					url: "<?php echo url('/');?>/addNewCMSAccount",
					method: 'POST',
					dataType: "json",
					data: {'cms_username': cms_username,'cms_password': cms_password,"_token": token},
					 
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) { 
					   if(data.status=='Success'){
							window.location.reload();
							return true;
							
						}else{
							//alert(data.Result);
							$('#CMSDetailserror').html(data.Result);
							return false;
						}  
					},
					error:function (xhr, ajaxOptions, thrownError){
						alert(thrownError);
					}
				});
				
				
			}else{
				alert("something wrong")
				return false;
			}
			
	
		});
		
	</script>

</body>
</html>