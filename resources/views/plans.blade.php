<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Plans</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")
	 <style>
	 .error{
		color:red;font-size:12px;
	 }
	 .hideImg{display:none;}
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
            <h5 class="font16 font-bold text-uppercase black_txt p-3 pt-4">Plans</h5>
            <div class="clearfix text-right mb-3">
                <div class="display_inline">
                    <a href="#" class="big_blue_btn" data-toggle="modal" data-target="#addNewUser">
                        New Package
                    </a>
                </div>
            </div>
            <div class="middle_box clearfix d-lg-block d-none">
                <div class="grid_wrp">
                    <div class="grid_header clearfix pt-3 pb-3">
                        <div class="w20 float-left font16 font-bold blue_txt">Package Name</div>
                        <div class="w20 float-left font16 font-bold blue_txt  text-right">Package Value<br>(USD)</div>
                        <div class="w20 float-left font16 font-bold blue_txt text-right">Discount<br>Amount (USD)</div>
                        <div class="w30 float-left font16 font-bold blue_txt pl-3">Description</div>
                        <div class="w10 float-left font16 font-bold blue_txt text-right">Action</div>
                    </div>
                    <div class="grid_body clearfix ">
                        @if($packages->count())
                            @foreach($packages as $pkg)
                        <div class="grid_row clearfix border-top ">
                            <div class="w20 float-left font16 dark-grey_txt">
                                {{ $pkg->package_name }}
                            </div>
                            <div class="w20 float-left font16 blue_txt text-right">{{ number_format($pkg->effective_amount,2) }}</div>
                            <div class="w20 float-left font16 green_txt  text-right">{{ number_format($pkg->discount,2) }}</div>
                            <div class="w30 float-left font16 dark-grey_txt pl-3">
                                {{ substr($pkg->description,0,50) }}...
                            </div>
                            <div class="w10 float-left text-right">
                                <div class="display_inline">
                                    <a class=" circle_btn editPackageInfo" href="#"  data-id="{{ $pkg->id }}" >
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="circle_btn delete inactivePackage" href="#"  data-id="{{ $pkg->id }}" >
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
							<!-- Pagination -->
							<div class="grid_row clearfix border-top ">
							   	<div class="w100 float-left font16 dark-grey_txt">
                                    {{ $packages->render() }}
							   	</div>
						    </div>
						@else
						    <div class="grid_row clearfix border-top ">
							   <div class="w100 norecord_txt">No Packages Found</div>
							</div>
						@endIf

					</div>
                </div>
			</div>

			<div id="accordion" class="d-lg-none d-block my-3">

                @if($packages->count())
                    @foreach($packages as $pkg)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 col-5">
								{{ $pkg->package_name }}
                            </div>

                            <div class="col-sm-4 col-5 text-right">
								{{ number_format($pkg->effective_amount,2) }}
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
                                <div class="col-5 text-blue">Discount Amount (USD)</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ number_format($pkg->discount,2) }}</div>
                            </div>

                            <div class="row my-1">
                                <div class="col-5 text-blue">Description</div>
                                <div class="col-1">:</div>
                                <div class="col-6">{{ substr($pkg->description,0,50) }}...</div>
                            </div>

                            <div class="row my-1 pt-3">
                                <div class="col-12 text-blue text-right">
									<div class="display_inline">
										<a class=" circle_btn editPackageInfo" href="#"  data-id="{{ $pkg->id }}" >
											<i class="fas fa-pencil-alt"></i>
										</a>
										<a class="circle_btn delete inactivePackage" href="#"  data-id="{{ $pkg->id }}" >
											<i class="far fa-trash-alt"></i>
										</a>
									</div>
								</div>

                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="grid_row clearfix border-top ">
                       <div class="w100 norecord_txt">No Packages Found</div>
                    </div>
                @endIf

            </div>
        </section>
    </div>
    <!-- All scripts include -->
     @include("inc.scripts.all-scripts")
    <!-- Add New Package -->
    <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Add New Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-4">
                    <form id="addPackage" name="addPackage" method="post" enctype="multipart/form-data">
                        <!-- Package Name -->
                        <div class="form-group">
                            <input type="text" name="packageName" class="form-control border-bottom-only" id="packageName"
                                aria-describedby="emailHelp" placeholder="Name">
                            <div class="text-right f14">
							<span id="packageNameerror" class="text-left error"></span>
							<span class="text-danger text-right">*</span>
							<span id="" class="text-muted f14 black_txt text-right">Package Name</span>
							</div>
                        </div>

						<!-- Package Image -->
                        <div class="form-group ">
							<!-- <input type="file" name="uploads" class="form-control border-bottom-only" id="uploads" aria-describedby="emailHelp" placeholder="Name"> -->
							<div class="file-upload">
								<div class="file-select">
									<div class="file-select-button" id="fileName">Choose File</div>
									<div class="file-select-name" id="noFile">No file chosen...</div>
									<input type="file" name="uploads" id="uploads">
								</div>
							</div>
                            <div class="text-right f14">
								<span class="text-danger"></span>
								<span id="" class="text-muted f14 black_txt">Package Image</span>
							</div>
                        </div>

						<!-- Actual Package Value -->
                        <div class="form-group">
                            <input type="number" name="amount" class="form-control border-bottom-only font-bold onkeyEffectiveAmt" id="amount"
                                aria-describedby="emailHelp" placeholder="00.00"  />
                            <div class="text-right f14">
							<span id="amounterror" class="text-left error"></span>
							<span class="text-danger">*</span>
							<span id="" class="text-muted f14 black_txt">Actual Package Value</span>
							</div>
                        </div>


						 <!-- subscription_fee -->
                        <div class="form-group">
                            <input type="number" name="subscription_fee" class="form-control border-bottom-only font-bold onkeyEffectiveAmt" id="subscription_fee"
                                aria-describedby="emailHelp" placeholder="00.00" />
                            <div class="text-right f14">
							<span id="subscriptionerror" class="text-left error"></span>
							<span class="text-danger"></span>
							<span id="" class="text-muted f14 black_txt">Software Cost</span>
							</div>
                        </div>
						 <!-- setupbox_fee -->
                        <div class="form-group">
                            <input type="number" name="setupbox_fee" class="form-control border-bottom-only font-bold onkeyEffectiveAmt" id="setupbox_fee"
                                aria-describedby="emailHelp" placeholder="00.00" />
                            <div class="text-right f14">
							<span id="setupboxerror" class="text-left error"></span>
							<span class="text-danger"></span>
							<span id="" class="text-muted f14 black_txt">Hardware Cost</span>
							</div>
                        </div>



                        <!-- Package Discount -->
                        <div class="form-group discount_input">
                            <div class="input-group mb-3">
                                <input type="number" name="discount" id="discount" class="form-control border-bottom-only with_addon_icon text-green onkeyEffectiveAmt2"
                                    placeholder="00.00" aria-label="Package Discount"
                                    aria-describedby="basic-addon2" readonly />
                                <!-- <span class="input-group-text no-border no-bg text-success addon_icon">%</span> -->

                                <div class="text-right f14 w-100 pt-2"><span class="text-danger"></span><span
                                        id="emailHelp" class="text-muted f14 black_txt">Discount Amount <strong id="pgkdiscountAmt"></strong> USD</span>
								</div>
                            </div>
                        </div>
						 <!-- Effective Package Amount -->
                        <div class="form-group discount_input">
                            <div class="input-group mb-3">
                                <input type="number" id="effective_amount" name="effective_amount" class="form-control border-bottom-only with_addon_icon text-green"
                                    placeholder="00.00" aria-label="Package Discount"
                                    aria-describedby="basic-addon2" readonly />
                                <!-- <span class="input-group-text no-border no-bg text-success addon_icon">%</span> -->

                                <div class="text-right f14 w-100 pt-2"><span class="text-danger"></span><span
                                        id="emailHelp" class="text-muted f14 black_txt">Effective Package Amount (USD)</span>
								</div>
                            </div>
                        </div>
						 <!-- Duration -->
                        <div class="form-group discount_input">
                            <div class="input-group mb-3">
                                <input type="text" id="duration" name="duration" class="form-control border-bottom-only with_addon_icon text-green"
                                    placeholder="Duration" aria-label="duration"
                                    aria-describedby="basic-addon2"  />


                                <div class="text-right f14 w-100 pt-2">
									<span id="emailHelp22" class="text-muted f14 black_txt">Duration</span>
								</div>
                            </div>
                        </div>
                        <!-- Description-->
                        <div class="form-group">
                                <textarea name="description" id="description" cols="30" rows="3" class="form-control border-bottom-only resize_none" placeholder="Description"></textarea>
                            <div class="text-right f14">
							<span id="descriptionerror" class="text-left error"></span>
							<span class="text-danger">*</span>
                            <span class="text-muted f14 black_txt">Package Description</span></div>
                        </div>
                    </form>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="addPackageBtn">Create</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add New User end -->
    <!-- Edit User -->
    <div class="modal fade" id="editPackageModel" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Edit Package
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_edit_user pb-4">
                <form id="updatePackage" name="updatePackage" method="post" enctype="multipart/form-data">
                        <!-- Package Name -->
                        <div class="form-group">
                            <input name="editpackageName" type="text" class="form-control border-bottom-only" id="editpackageName"
                                aria-describedby="emailHelp" placeholder="Name" value="">
                            <div class="text-right f14">
							<span id="editpackageNameerror" class="text-left error"></span>
							<span class="text-danger">*</span>
							<span id="" class="text-muted f14 black_txt">Package Name</span></div>
                        </div>
						<!-- Package Image -->
						 <div class="form-group">
                           <div class="hidepkgimg"><img src="" class="packgeImage" style="width:100px;height:auto;" /><span class="pkgImageDelete">Delete</span></div>
						   <input type="file" class="form-control hideImg" id="uploads_edit" name="uploads_edit" />
						   <input type="hidden" class="form-control" id="packgeImage_not_edit" name="packgeImage_not_edit"     />
                        </div>
                       <!-- <div class="form-group">
                            <input type="file" name="edituploads" class="form-control border-bottom-only" id="edituploads"
                                aria-describedby="emailHelp" placeholder="Name">
                            <div class="text-right f14"><span class="text-danger"></span><span id=""
                                    class="text-muted f14 black_txt">Package Image</span>
							</div>
							<div id="">
								<img class="" src="" />
							</div>

							 <td class="hidecryptoimg"><img src="" class="cryptoImage" style="width:200px;height:auto;" /><span class="cryptoImageDelete">Delete</span></td>
							<td><input type="file" class="form-control hide" id="cryptologo_edit" name="logo_edit" /></td>
							 <td><input type="hidden" class="form-control" id="cryptologo_not_edit" name="cryptologo_not_edit"     /></td>

                        </div> -->

						 <!-- Actual Package Value -->
                        <div class="form-group">
                            <input type="text" name="editamount" class="form-control border-bottom-only font-bold editonkeyEffectiveAmt" id="editamount"
                                aria-describedby="emailHelp" placeholder="00.00" value=""  >
                            <div class="text-right f14">
								<span id="editamounterror" class="text-left error"></span>
								<span class="text-danger">*</span>
								<span id="" class="text-muted f14 black_txt">Actual Package Value</span>
							</div>
                        </div>

						 <!-- subscription_fee -->
                        <div class="form-group">
                            <input type="number" name="editsubscription_fee" class="form-control border-bottom-only font-bold editonkeyEffectiveAmt " id="editsubscription_fee"
                                aria-describedby="emailHelp" placeholder="00.00" />
                            <div class="text-right f14">
							<span id="edisubscriptionerror" class="text-left error"></span>
							<span class="text-danger"></span>
							<span id="" class="text-muted f14 black_txt">Software Cost</span>
							</div>
                        </div>
						 <!-- setupbox_fee -->
                        <div class="form-group">
                            <input type="number" name="editsetupbox_fee" class="form-control border-bottom-only font-bold editonkeyEffectiveAmt" id="editsetupbox_fee"
                                aria-describedby="emailHelp" placeholder="00.00" />
                            <div class="text-right f14">
							<span id="editsetupboxerror" class="text-left error"></span>
							<span class="text-danger"></span>
							<span id="" class="text-muted f14 black_txt">Hardware Cost</span>
							</div>
                        </div>



                        <!-- Package Discount -->
                        <div class="form-group discount_input">
                            <div class="input-group mb-3">
                                <input type="number" id="editdiscount" name="editdiscount" class="form-control border-bottom-only with_addon_icon text-green " placeholder="00"  aria-label="Package Discount"
                                    aria-describedby="basic-addon2" value="" readonly>
                                <!-- <span class="input-group-text no-border no-bg text-success addon_icon">%</span> -->

                                <div class="text-right f14 w-100 pt-2"><span class="text-danger">*</span><span
                                        id="emailHelp" class="text-muted f14 black_txt">Discount Amount <strong id="editpkgdiscountAmt"></strong> USD</span></div>
                            </div>
                        </div>
						 <!-- Effective Package Amount -->
                        <div class="form-group discount_input">
                            <div class="input-group mb-3">
                                <input type="number" id="edieffective_amount" name="edieffective_amount" class="form-control border-bottom-only with_addon_icon text-green"
                                    placeholder="00.00" aria-label="Package Discount"
                                    aria-describedby="basic-addon2" readonly />
                                <!-- <span class="input-group-text no-border no-bg text-success addon_icon">%</span> -->

                                <div class="text-right f14 w-100 pt-2"><span class="text-danger"></span><span
                                        id="emailHelp" class="text-muted f14 black_txt">Effective Package Amount (USD)</span>
								</div>
                            </div>
                        </div>
						<!-- Duration -->
                        <div class="form-group discount_input">
                            <div class="input-group mb-3">
                                <input type="text" id="editduration" name="editduration" class="form-control border-bottom-only with_addon_icon text-green"
                                    placeholder="Duration" aria-label="Duration"
                                    aria-describedby="basic-addon2"  />
                                <!-- <span class="input-group-text no-border no-bg text-success addon_icon">%</span> -->

                                <div class="text-right f14 w-100 pt-2"><span class="text-danger"></span><span
                                        id="emailHelp32" class="text-muted f14 black_txt">Duration</span>
								</div>
                            </div>
                        </div>
                        <!-- Description-->
                        <div class="form-group">
                                <textarea name="editdescription" id="editdescription" cols="30" rows="3" class="form-control border-bottom-only resize_none" placeholder="Description" ></textarea>
                            <div class="text-right f14">
								<span id="editdescriptionerror" class="text-left error"></span>
								<span class="text-danger">*</span>
								<span class="text-muted f14 black_txt">Package Description</span>
							</div>
                        </div>
						<input type="hidden" name="edit_rec_id" id="edit_rec_id" value=""/>
                    </form>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="updatePackageBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit User end -->
    <!-- Delete User -->
    <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">
                        Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
				<div id="currentRecId" style="display:none;"></div>
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-center f20 black_txt py-5 mb-5">
                        Are you sure you want to delete this item?
                    </div>
					<div id="pkgErrorMsg"></div>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="deletePackage">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete User end -->


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
    <!-- Delete User end -->



	<!-- Java scripts -->

	<script type="text/javascript">
	$(document).ready(function () {
		// Calculate Effective Amount

		/*$(".onkeyEffectiveAmt1").keyup(function()
		{
			var amount = $("#amount").val();
			var subscription_fee = $("#subscription_fee").val();
			var setupbox_fee = $("#setupbox_fee").val();
			if(setupbox_fee == ""){
				var seupboxFee = 0;
			}else{
				var seupboxFee = setupbox_fee;
			}
			//var pkgValue = subscription_fee + setupbox_fee;
			var pkgValue = parseFloat(subscription_fee) + parseFloat(seupboxFee);
				console.log(pkgValue);
			$("#amount").val(pkgValue);

			var discount=$("#discount").val();
			var discount_per = parseFloat(pkgValue*(discount/100));
			$("#pgkdiscountAmt").text(discount_per.toFixed(2))
			var effectiveAmt = pkgValue - discount_per;
			$("#effective_amount").val(effectiveAmt.toFixed(2));

		});*/

		$(".onkeyEffectiveAmt").keyup(function()
		{
			var amount=$("#amount").val();
			//var discount=$("#discount").val();
			var subscription_fee = $("#subscription_fee").val();
			var setupbox_fee = $("#setupbox_fee").val();

			if(subscription_fee == ""){
				var subscription_fee1 = 0;
			}else{
				var subscription_fee1 = subscription_fee;
			}

			if(setupbox_fee == ""){
				var seupboxFee = 0;
			}else{
				var seupboxFee = setupbox_fee;
			}
			var total_discount = amount-subscription_fee1-seupboxFee;
			$("#discount").val(total_discount.toFixed(2));

			console.log("subscription_fee1 "+subscription_fee1);

			var effAmt = parseFloat(subscription_fee1)+parseFloat(seupboxFee);
			console.log("eff_amt "+effAmt);
			$("#effective_amount").val(parseFloat(effAmt).toFixed(2));



		});


		/*$(".editonkeyEffectiveAmt1").keyup(function()
		{
			var subscription_fee = $("#editsubscription_fee").val();
			var setupbox_fee = $("#editsetupbox_fee").val();

			if(setupbox_fee == ""){
				var seupboxFee = 0;
			}else{
				var seupboxFee = setupbox_fee;
			}
			//var pkgValue = subscription_fee + setupbox_fee;
			var pkgValue = parseFloat(subscription_fee) + parseFloat(seupboxFee);
				console.log(pkgValue);
			$("#editamount").val(pkgValue);

			var discount=$("#editdiscount").val();
			var discount_per = parseFloat(pkgValue*(discount/100));
			$("#editpkgdiscountAmt").text(discount_per.toFixed(2))
			var effectiveAmt = pkgValue - discount_per;
			$("#edieffective_amount").val(effectiveAmt.toFixed(2));

		});*/


		$(".editonkeyEffectiveAmt").keyup(function()
		{
			var amount=$("#editamount").val();
			var subscription_fee = $("#editsubscription_fee").val();
			if(subscription_fee == ""){
				var subscription_fee1 = 0;
			}else{
				var subscription_fee1 = subscription_fee;
			}
			var setupbox_fee = $("#editsetupbox_fee").val();
			if(setupbox_fee == ""){
				var seupboxFee = 0;
			}else{
				var seupboxFee = setupbox_fee;
			}

			var total_discount = amount-subscription_fee1-seupboxFee;
			$("#editdiscount").val(total_discount.toFixed(2));

			console.log("editsubscription_fee1 "+subscription_fee1);

			var effAmt = parseFloat(subscription_fee1)+parseFloat(seupboxFee);
			console.log("edit_eff_amt "+effAmt);
			$("#edieffective_amount").val(parseFloat(effAmt).toFixed(2));

			/*if(isNaN(amount)){
				var effectiveAmt = 0.00;
				$("#editdiscount").val(effectiveAmt);
				$("#edieffective_amount").val(effectiveAmt.toFixed(2));
			}else{
				var discount_per = parseFloat(amount*(discount/100));
				$("#editpkgdiscountAmt").text(discount_per.toFixed(2))
				var effectiveAmt = amount - discount_per;
				$("#edieffective_amount").val(effectiveAmt.toFixed(2));
			}*/



		});

		// Add package
		$('#addPackageBtn').on('click', function(e)  {

			e.preventDefault();

			var error = false;
			var token = "<?php echo csrf_token() ?>";
			var reg_url  = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;

			var currentDivID = $(this).attr('data-id');

			var packageName = $('#packageName').val();
			var amount = $('#amount').val();
			var discount = $('#discount').val();
			var effective_amount = $('#effective_amount').val();
			var description = $('#description').val();
			var subscription_fee = $('#subscription_fee').val();
			var setupbox_fee = $('#setupbox_fee').val();
			var pgkdiscountAmt = $('#pgkdiscountAmt').text();
			var duration = $('#duration').val();
			if (packageName == "") {
				$('#packageNameerror').html("Please Enter Package Name");
				error = true;
			}else {
				$('#packageNameerror').html("");
			}
			if (amount == "") {
				$('#amounterror').html("Please Enter Amount");
				error = true;
			}else {
				$('#amounterror').html("");
			}
			if (description == "") {
				$('#descriptionerror').html("Please Enter Description");
				error = true;
			}else {
				$('#descriptionerror').html("");
			}

			if(!error){
				var savePackageform = new FormData($("#addPackage")[0]);
				savePackageform.append('pgkdiscountAmt', pgkdiscountAmt);
				savePackageform.append('action', 'add');
				savePackageform.append('_token', token);
				$.ajax({
					url: "<?php echo url('/');?>/addNewPackageInfo",
					method: 'POST',
					dataType: "json",
					data:savePackageform,
					contentType: false,
					cache: false,
					processData:false,
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) {
					   if(data.status=='Success'){
							$("#addNewUser").modal('hide');
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


		// Edit Package Info
		$(".editPackageInfo").on('click', function(e) {
			e.preventDefault();
			var token = "<?php echo csrf_token() ?>";
			var currentRecId = $(this).attr('data-id');
			if(currentRecId !=""){
				$.ajax({
					url: "<?php echo url('/');?>/getEditPackageInfo",
					method: 'POST',
					dataType: "json",
					data: {'rec_id': currentRecId,'action': 'getEditPackageInfo',"_token": token},
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) {
					   if(data.status=='Success'){
							$("#editPackageModel").modal('show');
							//$("#pkgErrorMsg").html(data.Result);
							$("#edit_rec_id").val(data.Result.id);
							$("#editpackageName").val(data.Result.package_name);
							$("#editsubscription_fee").val(data.Result.subscription_fee);
							$("#editsetupbox_fee").val(data.Result.setupbox_fee);
							$("#editamount").val(data.Result.package_value);
							$("#editdiscount").val(data.Result.discount);
							$("#edieffective_amount").val(data.Result.effective_amount);
							$("#editdescription").val(data.Result.description);
							$("#editduration").val(data.Result.duration);
							$("#editpkgdiscountAmt").text(data.Result.discount_by_amt);
							$("#packgeImage_not_edit").val(data.Result.package_image);

							$('.packgeImage').attr("src","/public/packages/"+data.Result.package_image);


						}else{

						}
					},
					error:function (xhr, ajaxOptions, thrownError){
						alert(thrownError);
					}
				});



			}else{
				alert("currentDivID is missing");
			}
		});

		// update Package Info

		$('#updatePackageBtn').on('click', function(e)  {

			e.preventDefault();

			var error = false;
			var token = "<?php echo csrf_token() ?>";
			var reg_url  = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;

			var currentDivID = $(this).attr('data-id');

			var packageName = $('#editpackageName').val();
			var amount = $('#editamount').val();
			var description = $('#editdescription').val();
			var editpkgdiscountAmt = $('#editpkgdiscountAmt').text();

			if (packageName == "") {
				$('#editpackageNameerror').html("Please Enter Package Name");
				error = true;
			}else {
				$('#editpackageNameerror').html("");
			}
			if (amount == "") {
				$('#editamounterror').html("Please Enter Amount");
				error = true;
			}else {
				$('#editamounterror').html("");
			}
			if (description == "") {
				$('#editdescriptionerror').html("Please Enter Description");
				error = true;
			}else {
				$('#editdescriptionerror').html("");
			}

			if(!error){
				var updatePackageform = new FormData($("#updatePackage")[0]);
				updatePackageform.append('editpkgdiscountAmt', editpkgdiscountAmt);
				updatePackageform.append('action', 'add');
				updatePackageform.append('_token', token);
				$.ajax({
					url: "<?php echo url('/');?>/updatePackageInfo",
					method: 'POST',
					dataType: "json",
					data:updatePackageform,
					contentType: false,
					cache: false,
					processData:false,
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) {
					   if(data.status=='Success'){
							$("#editPackageModel").modal('hide');
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


		$('body').on('click', '.pkgImageDelete', function(){
			var id = $("#edit_rec_id").val();
			var token = "<?php echo csrf_token() ?>";
			$.ajax({
				url: "<?php echo url('/');?>/deletePackageImage",
				method: 'POST',
				dataType: "json",
				data: {'delete_id':id, 'action':"deleteImg","_token": token},
				success: function(data){
					console.log(data.res);
					if(data.status == 'Success'){
						$(".hidepkgimg").addClass("hideImg");
						$(".packgeImage").addClass("hideImg");
						$("#uploads_edit").removeClass("hideImg");
						$("#packgeImage_not_edit").val("");
					}else {
						alert("Something went wrong");
						return false;
					}
				},
				error: function(error){
					alert(error);
				}
			});

		});


		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) {
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
		});



		// Alert Inactive Package
		$(".inactivePackage").on('click', function(e) {
			e.preventDefault();
			var currentDivID = $(this).attr('data-id');
			if(currentDivID !=""){
				$("#deleteUser").modal('show');
				$("#currentRecId").text(currentDivID);
			}else{
				alert("currentDivID is missing");
			}
		});

		// Delete Package Confirm button

		$("#deletePackage").on('click', function(e) {
			e.preventDefault();
			var token = "<?php echo csrf_token() ?>";
			var currentRecId = $("#currentRecId").text();

			if(currentRecId != ""){
				$.ajax({
					url: "<?php echo url('/');?>/deletePackageStatus",
					method: 'POST',
					dataType: "json",
					data: {'rec_id': currentRecId,'action': 'deletePackageStatus',"_token": token},
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) {
					   if(data.status=='Success'){
							$("#deleteUser").modal('hide');
							window.location.reload();
						}else{
							$("#deleteUser").modal('show');
							$("#pkgErrorMsg").html(data.Result)
						}
					},
					error:function (xhr, ajaxOptions, thrownError){
						alert(thrownError);
					}
				});
			}else{
				alert("something went wrong");
			}

		});

        $('#uploads').bind('change', function () {
            var filename = $("#uploads").val();
            if (/^\s*$/.test(filename)) {
              $("#noFile").text("Nofds file chosen...");
            }
            else {
              $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            }

          });
	});
	</script>


</body>
</html>
