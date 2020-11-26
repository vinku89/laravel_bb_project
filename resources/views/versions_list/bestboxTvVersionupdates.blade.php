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
		.tw-50{width:50%;float:left;}
		.tw-30{width:30%;float:left;}
		.tw-20{width:20%;float:left;}
		.tw-10{width:10%;float:left;}
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
          <h5 class="font16 black_txt font-bold text-uppercase1 pt-4 pb-3">APP Usage Details</h5>

          <div class=""> 
			  <div class="col-12">
					@include("versions_list.commonTabs")
			  </div>
               
		  		
				
		</div>		
		


        <div class="col-12">
            <div class="middle_box clearfix">
				<div class="col-sm-6 bonus_form"> 
					<div class="form-group">
						<div class="input-group mb-3">
							<input type="text" id="android_app_code" name="android_app_code" class="form-control border-bottom-only with_addon_icon" placeholder="Android App Code" value="<?php echo ($version_info->android_app_code)?$version_info->android_app_code:""; ?>" />
							<div class="text-right f14 w-100 pt-2">
								<span id="android_codeerror" class="text-left error"></span>
								<span class="text-danger">*</span>
								<span id="emailHelp" class="text-muted f14 black_txt">Android Version</span>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="input-group mb-3">
							<input type="text" id="android_version" name="android_version" class="form-control border-bottom-only with_addon_icon" placeholder="Android Version" value="<?php echo ($version_info->android_app_version)?$version_info->android_app_version:""; ?>" />
							<div class="text-right f14 w-100 pt-2">
								<span id="android_versionerror" class="text-left error"></span>
								<span class="text-danger">*</span>
								<span id="emailHelp" class="text-muted f14 black_txt">Android App Code</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group mb-3">
							<input type="text" id="ios_version" name="ios_version" class="form-control border-bottom-only with_addon_icon" placeholder="IOS Version" value="<?php echo ($version_info->ios_app_version)?$version_info->ios_app_version:""; ?>"  />
							<div class="text-right f14 w-100 pt-2">
								<span id="ios_versionerror" class="text-left error"></span>
								<span class="text-danger">*</span>
								<span id="emailHelp" class="text-muted f14 black_txt">IOS Version</span>
							</div>
						</div>
					</div>
					
					<div class="col-12 text-center my-5">
						<button type="button" class="form_button " id="saveIPTVBtn" style="border:none;">Save</button>
					</div>
					
					
				</div>
			</div>
        </div>
			
        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
	    <!-- Add New User end -->
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
	
	<script type="text/javascript" nonce="32432jlkfsdaf">
		
		
		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) { 
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
		});
		
	</script>
  
    <script type="text/javascript">
    
        $(document).ready(function(){
					// Add package 
			$('#saveIPTVBtn').on('click', function(e)  { 
				
				e.preventDefault();
				
				var error = false;
				var android_app_code = $('#android_app_code').val();
				var android_version = $('#android_version').val();
				var ios_version = $('#ios_version').val();
				
				if (android_app_code == "") {
					$('#android_codeerror').html("Please Enter Android  Version");
					error = true;
				}else {
					$('#android_codeerror').html("");
				}
				
				if (android_version == "") {
					$('#android_versionerror').html("Please Enter Android app code");
					error = true;
				}else {
					$('#android_versionerror').html("");
				}
				
				if (ios_version == "") {
					$('#ios_versionerror').html("Please Enter IOS Version");
					error = true;
				}else {
					$('#ios_versionerror').html("");
				}
				
				
				
				if(!error){
					var token = "<?php echo csrf_token() ?>";
					$.ajax({
						url: "<?php echo url('/');?>/updateMobileAppVersions",
						method: 'POST',
						dataType: "json",
						data: {'android_app_code': android_app_code,'android_app_version': android_version,'ios_app_version': ios_version,'action': "updateVersion","_token": token},
						beforeSend: function(){
							$(".loaderIcon").show();
						},
						complete: function(){
							$(".loaderIcon").hide();
						},
						success: function (data) { 
						   if(data.status=='Success'){
								$("#successModel").modal('show');
								//window.location.reload();
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
					
				}else{
				
				}
				
		
			});
        }); 
        
        
	
		
    </script>
	

</body>
</html>