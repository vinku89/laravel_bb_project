<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - IPTV Configure URLS</title>
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
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Streaming Links</h5>


          <div class="middle_box clearfix">
            <div class="col-sm-6 bonus_form">

				<div class="form-group">
					<div class="input-group mb-3">
						<input type="text" id="iptv_live" name="iptv_live" class="form-control border-bottom-only with_addon_icon" placeholder="IPTV Live" value="<?php echo ($iptv_info->iptv_live)?$iptv_info->iptv_live:""; ?>" />
						<div class="text-right f14 w-100 pt-2">
							<span id="iptv_liveerror" class="text-left error"></span>
							<span class="text-danger">*</span>
							<span id="emailHelp" class="text-muted f14 black_txt">IPTV Live URL</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group mb-3">
						<input type="text" id="iptv_player" name="iptv_player" class="form-control border-bottom-only with_addon_icon" placeholder="IPTV Player" value="<?php echo ($iptv_info->iptv_player)?$iptv_info->iptv_player:""; ?>"  />
						<div class="text-right f14 w-100 pt-2">
							<span id="iptv_playererror" class="text-left error"></span>
							<span class="text-danger">*</span>
							<span id="emailHelp" class="text-muted f14 black_txt">IPTV Player</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group mb-3">
						<input type="text" id="iptv_vod" name="iptv_vod" class="form-control border-bottom-only with_addon_icon" placeholder="IPTV VOD" value="<?php echo ($iptv_info->iptv_vod)?$iptv_info->iptv_vod:""; ?>" />
						<div class="text-right f14 w-100 pt-2">
							<span id="iptv_voderror" class="text-left error"></span>
							<span class="text-danger">*</span>
							<span id="emailHelp" class="text-muted f14 black_txt">IPTV VOD</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group mb-3">
						<input type="text" id="iptv_catchup" name="iptv_catchup" class="form-control border-bottom-only with_addon_icon" placeholder="IPTV Catchup" value="<?php echo ($iptv_info->iptv_catchup)?$iptv_info->iptv_catchup:""; ?>"/>
						<div class="text-right f14 w-100 pt-2">
							<span id="iptv_catchuperror" class="text-left error"></span>
							<span class="text-danger">*</span>
							<span id="emailHelp" class="text-muted f14 black_txt">IPTV Catchup</span>
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

				var iptv_live = $('#iptv_live').val();
				var iptv_player = $('#iptv_player').val();
				var iptv_vod = $('#iptv_vod').val();
				var iptv_catchup = $('#iptv_catchup').val();

				if (iptv_live == "") {
					$('#iptv_liveerror').html("Please Enter IPTV Live URL");
					error = true;
				}else {
					$('#iptv_liveerror').html("");
				}

				if (iptv_player == "") {
					$('#iptv_playererror').html("Please Enter IPTV Player URL");
					error = true;
				}else {
					$('#iptv_playererror').html("");
				}

				if (iptv_vod == "") {
					$('#iptv_voderror').html("Please Enter IPTV VOD URL");
					error = true;
				}else {
					$('#iptv_voderror').html("");
				}

				if (iptv_catchup == "") {
					$('#iptv_catchuperror').html("Please Enter IPTV Catchup URL");
					error = true;
				}else {
					$('#iptv_catchuperror').html("");
				}


				if(!error){
					var token = "<?php echo csrf_token() ?>";
					$.ajax({
						url: "<?php echo url('/');?>/updateIPTVStreamingInfo",
						method: 'POST',
						dataType: "json",
						data: {'iptv_live': iptv_live,'iptv_player': iptv_player,'iptv_vod': iptv_vod,'iptv_catchup': iptv_catchup,'action': "updateIPTV","_token": token},
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
