<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Customer Bonus</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
	<style>
	 .error{
		color:red;font-size:12px;
	 }
	 .addon_icon {
		position: absolute;
		right: 22px;
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
        <section class="main_body_section scroll_div text-center">
            <h5 class="font16 font-bold text-uppercase black_txt p-3 pt-4">Customer Bonus</h5>
            <div class="middle_box clearfix ">
                <div class="col-sm-6 bonus_form">
                              <!--  Commission Percentage addCustomerBonus -->
                        <div class="form-group">
                            <div class="input-group mb-3 text-center">
                                <input type="number" id="customerBonus" name="customerBonus" class="form-control border-bottom-only with_addon_icon text-green" placeholder="00" aria-label="Reseller Commission Percentage" aria-describedby="basic-addon2">
                                <!-- <span class="input-group-text no-border no-bg text-success addon_icon">%</span> -->
                                <div class="text-right f14 w-100 pt-2">
									<span id="cberror" class="text-left error"></span>
									<span class="text-danger">*</span>
									<span id="emailHelp" class="text-muted f14 black_txt">Customer Referral Bonus</span>
								</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control border-bottom-only resize_none" name="description" id="description" cols="30" rows="3" placeholder="Text here"></textarea>
                            <div class="text-right f14 w-100 pt-2">
								<span id="descriptionerror" class="text-left error"></span>
								<span class="text-danger">*</span>
								<span id="emailHelp" class="text-muted f14 black_txt">Bonus Description</span>
							</div>
                        </div>

                        <div class="col-12 text-center my-5">
                            <!-- <a href="javascript:void(0)" class="form_button " id="addBonusBtn">Save</a> -->
							<button class="form_button " id="addBonusBtn" style="border:none;">Save</button>
                        </div>
                </div>
            </div>
           <div class="grid_wrp">
				<div class="grid_header clearfix pt-3 pb-3">
					<div class="w40 float-left font16 font-bold grey_txt">Customer Referral Bonus</div>
					<div class="w40 float-left font16 font-bold grey_txt">Description</div>

				</div>
				<div class="grid_body clearfix">
					<?php
					   if(!empty($bonusList)){
							foreach($bonusList as $res){
					?>
					<div class="grid_row clearfix border-top ">

						<div class="w40 float-left font16 dark-grey_txt">
							<?php echo $res->customer_bonus; ?>
						</div>
						<div class="w40 float-left font16 dark-grey_txt">
							<?php echo $res->bonus_description; ?>
						</div>
					</div>
					   <?php } } ?>

				</div>
			</div>
        </section>
    </div>


    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

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

    <script>
        $(document).ready(function() {
            // Add Customer Bonus
			$('#addBonusBtn').on('click', function(e)  {

				e.preventDefault();

				var error = false;
				var token = "<?php echo csrf_token() ?>";
				var reg_url  = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;

				var customerBonus = $('#customerBonus').val();

				var description = $('#description').val();

				if (customerBonus == "") {
					$('#cberror').html("Please Enter Customer Bonus");
					error = true;
				}else {
					$('#cberror').html("");
				}

				if (description == "") {
					$('#descriptionerror').html("Please Enter Description");
					error = true;
				}else {
					$('#descriptionerror').html("");
				}

				if(!error){

					$.ajax({
						url: "<?php echo url('/');?>/addCustomerBonus",
						method: 'POST',
						dataType: "json",
						data: {'customerBonus': customerBonus,'description': description,'action': 'addBonus',"_token": token},

						beforeSend: function(){
							$(".loaderIcon").show();
						},
						complete: function(){
							$(".loaderIcon").hide();
						},
						success: function (data) {
						   if(data.status=='Success'){
								//$("#addNewUser").modal('hide');
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


				}else{

				}


			});

			// Ok Btn msg
			$(".OkBtnNew").on('click', function(e) {
				e.preventDefault();
				$('#successModel').modal('hide');
				window.location.reload();
			});

        });
    </script>


</body>

</html>
