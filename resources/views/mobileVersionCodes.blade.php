<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Mobile Version Codes</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")

     <style>
	 .w5-md {
		width: 5%;
	}
	.w20-md {
		width: 20%;
	}
	.w35-md{width: 35%;}
        input:focus,
        textarea:focus {
        border: 2px solid #999;
        outline: none;
      }

      textarea {
        min-height: 100px;
      }

      .message {
        position: absolute;
        z-index: 9;
        display: none;
        width: 92%;
        padding: 10px;
        margin-top: -4px;
        background: #D9585C;
        color: #fff;
        text-align: center;
      }
      .message:after {
        content: '';
        position: absolute;
        top: -10px;
        left: 50%;
        display: block;
        margin-left: -10px;
        border: solid;
        border-color: #D9585C transparent #D9585C;
        border-width: 0 10px 10px;
      }

      .is-valid {
        border-color: #AAD661 !important;
        transition: 0;
      }

      .not-valid {
        border-color: #D7595F;
        transition: 0;
      }
      .not-valid + .message {
        display: block !important;
      }

      .submit {
        transition: .3s;
      }
	  .delImage{
		border: 0px;

		background: #005aa9;
		color: #fff;
		padding: 5px 10px;
	  }

		.green{color:green;}
		.red{color:red;}
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
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Version Upgrade</h5>


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
