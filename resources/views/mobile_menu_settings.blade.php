	<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>BestBOX - Mobile Menu Settings</title>
	<link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
	<!-- All styles include -->
		@include("inc.styles.all-styles")
		<style>
		.error{
		color:red;font-size:12px;
		}
		.normal_select_new{

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
		<section class="main_body_section mobile_menu_section scroll_div">
			<h5 class="font16 font-bold text-uppercase black_txt p-3 pt-4">Mobile Menu</h5>
			<div class="middle_box clearfix ">
				<div class="col-sm-6 bonus_form">
					<!--  Commission Percentage -->
					<form id="addmenu" name="addmenu" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<div class="input-group mb-3">
								<input type="text" id="menuName" name="menuName" class="form-control border-bottom-only with_addon_icon"
									placeholder="Name" aria-label="Menu Name" aria-describedby="basic-addon2">
								<div class="text-right f14 w-100 pt-2">
									<span id="menuerror" class="text-left error"></span>
									<span class="text-danger">*</span>
									<span id="emailHelp" class="text-muted f14 black_txt">Menu Name</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<input type="text" id="menuLink" name="menuLink" class="form-control border-bottom-only with_addon_icon"
									placeholder="Menu Link" aria-label="Menu Name" aria-describedby="basic-addon2">
								<div class="text-right f14 w-100 pt-2">
									<span id="menulinkerror" class="text-left error"></span>
									<span class="text-danger">*</span>
									<span id="emailHelp1" class="text-muted f14 black_txt">Menu Link</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="btn btn-dark position-relative">
								<input type="file" class="file-upload" id="uploads" name="uploads" name="menu icon" accept="image/*">
								Upload Icon
							</div>
						</div>
						<div class="form-group">
							<select id="parent_menu" name="parent_menu" class="form-control">
								<option value="0">Please Select</option>
								<?php
								if(!empty($parent_menus)){
									$i=1;
									foreach($parent_menus as $res){

								?>
								<option value="<?php echo $res->id;?>"><?php echo $res->menu_name; ?></option>
								<?php } }?>
							</select>
							<span id="menuloc_error" class="text-left error"></span>
						</div>
						<div class="form-group">
							<select id="normal_select" name="normal_select">
								<option value="">Display Menu</option>
								<option value="3">Dashboard</option>
								<option value="2">Left Menu</option>
								<option value="1">Both</option>
							</select>
							<span id="menuloc_error" class="text-left error"></span>
						</div>


						<div class="col-12 text-center my-5">
							<!-- <a href="" class="form_button ">Save</a> -->
							<button type="button" class="form_button " id="addMenuBtn" style="border:none;">Save</button>
						</div>
					</form>
				</div>

				<div class="mb-4 text-center">
					<button type="button" class="form_button " id="SaveallMenus" style="border:none;">Save Permissions</button>
					<button type="button" class="form_button " id="SaveallOrders" style="border:none;">Save Orders</button>
				</div>

				<div class="grid_wrp d-none d-lg-block">

					<div class="grid_header clearfix pt-3 pb-3">
						<div class="w5 float-left font16 font-bold grey_txt">Icon</div>
						<div class="w20 float-left font16 font-bold grey_txt">Menu Name</div>
						<div class="w10 float-left font16 font-bold grey_txt">Order</div>
						<div class="w15 float-left font16 font-bold grey_txt text-center">Reseller</div>
						<div class="w15 float-left font16 font-bold grey_txt">Agent</div>
						<!-- <div class="w10 float-left font16 font-bold grey_txt">Customer</div> -->
						<div class="w15 float-left font16 font-bold grey_txt pr-2">Display Menu</div>
						<div class="w10 float-left font16 font-bold grey_txt pr-2">Display At</div>
						<div class="w10 float-left font16 font-bold grey_txt">Actions</div>
					</div>

					<div class="grid_body clearfix">
						<?php
							if(!empty($menusList)){
								$i=1;
								foreach($menusList as $res){
								$id = $res->id;
								$sub_menu_q = \App\MobileLeftMenu::where('parent_menu_id', $id)->orderBy("menu_order", "ASC")->get();
								$total_childs_menus = count($sub_menu_q);

								$displayLocation = $res->display_location;
								$display_dashboard_at = $res->display_dashboard_at;
								$reseller = $res->reseller;
								if($reseller == 1){
									$reseller_status = "checked";
								}else{
									$reseller_status = "";
								}
								$agent = $res->agent;
								if($agent == 1){
									$agent_staus = "checked";
								}else{
									$agent_staus = "";
								}
								$customer = $res->customer;
								if($customer == 1){
									$customer_staus = "checked";
								}else{
									$customer_staus = "";
								}

								$mainMenuStatus = $res->status;
						?>
						<div class="grid_row clearfix border-top ">
							<div class="w5 float-left font16 dark-grey_txt">
								<img src="<?php echo url('/').'/public/mobile_menu_icons/'.$res->menu_icon; ?>" width="30px" height="30px"/>
							</div>
							<div class="w20 float-left font16 dark-grey_txt">
								<?php echo $res->menu_name; ?>
							</div>
							<div class="w10 float-left font16 dark-grey_txt">
								<input type="number" width="20" class="menuOrder form-control" name="menu_order[]" id="menu_order" value="<?php echo $res->menu_order; ?>" data-id="<?php echo $id; ?>"/>

							</div>
							<div class="w15 float-left font16 blue_txt text-center">
							<div class="checkbox switcher">
								<label for="abcr<?php echo $id;?>">
									<input type="checkbox" class="resellers" id="abcr<?php echo $id;?>" value="<?php echo $id;?>" <?php echo $reseller_status; ?> >
									<span><small></small></span>
								</label>
								</div>
							</div>
							<div class="w15 float-left font16">
							<div class="checkbox switcher">
								<label for="abca<?php echo $id;?>">
									<input type="checkbox" class="agentsList" id="abca<?php echo $id;?>" value="<?php echo $id;?>" <?php echo $agent_staus; ?>>
									<span><small></small></span>
								</label>
								</div>
							</div>
							<!-- <div class="w10 float-left font16 dark-grey_txt">
							<div class="checkbox switcher">
								<label for="abcc<?php echo $id;?>">
									<input type="checkbox" class="customersList" id="abcc<?php echo $id;?>" value="<?php echo $id;?>" <?php echo $customer_staus; ?>>
									<span><small></small></span>
								</label>
								</div>
							</div> -->
							<?php

								if($displayLocation == 1){
									$loc = "Both";
								}else if($displayLocation == 2){
									$loc = "Left Menu";
								}else if($displayLocation == 3){
									$loc = "Dashboard";
								}else{
									$loc = "";
								}
							?>
							<div class="w15 float-left ">
								<!-- <h5 class="font16 dark-grey_txt"><?php //echo $loc; ?></h5> -->
								<select class="form-control changeMenuLocation" name="changeMenuLocation">
									<option value="3" data-id="<?php echo $id;?>" <?php if($displayLocation == 3){echo "selected";}else{echo "";}?>>Dashboard</option>
									<option value="2" data-id="<?php echo $id;?>" <?php if($displayLocation == 2){echo "selected";}else{echo "";}?>>Left Menu</option>
									<option value="1" data-id="<?php echo $id;?>" <?php if($displayLocation == 1){echo "selected";}else{echo "";}?>>Both</option>
								</select>
							</div>
							<?php
								if($displayLocation == 3){
							?>
							<div class="w10 float-left ">
								<select class="form-control changeDisplayAt" name="changeDisplayAt">
									<option value="1" data-id="<?php echo $id;?>" <?php if($display_dashboard_at == 1){echo "selected";}else{echo "";}?>>Top</option>
									<option value="0" data-id="<?php echo $id;?>" <?php if($display_dashboard_at == 0){echo "selected";}else{echo "";}?>>Bottom</option>
								</select>
							</div>
							<?php }else{ ?>
							<div class="w10 float-left ">
								<div class="text-center">---</div>
							</div>
							<?php } ?>
							<div class="w10 float-left ">
								<div class="display_inline">
									<!-- <a class=" circle_btn editMenuInfo" href="#" data-id="<?php //echo $id;?>">
										<i class="fas fa-pencil-alt"></i>
									</a>
									<a class="circle_btn delete inactiveMenu" href="#" data-id="<?php //echo $id;?>">
										<i class="far fa-trash-alt"></i>
									</a>-->
									<select class="form-control inactiveMenu1" name="inactiveMenu1">
										<option value="1" data-id="<?php echo $id;?>" <?php if($mainMenuStatus == 1){echo "selected";}else{echo "";}?>>Active</option>
										<option value="0" data-id="<?php echo $id;?>" <?php if($mainMenuStatus == 0){echo "selected";}else{echo "";}?>>Inactive</option>
									</select>
								</div>
							</div>
						</div>
						<!-- submenu -->
						<?php
							if( $total_childs_menus > 0 ){
								foreach ($sub_menu_q as $sub_data) {
									$sub_menu_id = $sub_data->id;
									$sub_menu_name = $sub_data->menu_name;
									$sub_menu_icon = $sub_data->menu_icon;
									$sub_menu_status = $sub_data->status;

									$sub_displayLocation = $sub_data->display_location;
									$sub_display_dashboard_at = $sub_data->display_dashboard_at;
									$subreseller = $sub_data->reseller;
									if($subreseller == 1){
										$sub_reseller_status = "checked";
									}else{
										$sub_reseller_status = "";
									}
									$sub_agent = $sub_data->agent;
									if($sub_agent == 1){
										$sub_agent = "checked";
									}else{
										$sub_agent = "";
									}
									$sub_customer = $sub_data->customer;
									if($sub_customer == 1){
										$sub_customer = "checked";
									}else{
										$sub_customer = "";
									}



						?>
						<div class="grid_row clearfix border-top submenu" style="background-color:#ddd;">
							<div class="w5 float-left font16 dark-grey_txt">
								<img src="<?php echo url('/').'/public/mobile_menu_icons/'.$sub_menu_icon; ?>" width="30px" height="30px"/>
							</div>
							<div class="w20 float-left font16 dark-grey_txt">
								<?php echo $sub_menu_name; ?>
							</div>
							<div class="w10 float-left font16 dark-grey_txt">
								<input type="number" width="20" class="menuOrder form-control" name="menu_order[]" id="menu_order" value="<?php echo $sub_data->menu_order; ?>" data-id="<?php echo $sub_menu_id; ?>"/>

							</div>
							<div class="w15 float-left font16 blue_txt text-center">
								<div class="checkbox switcher">
									<label for="submr<?php echo $sub_menu_id;?>">
										<input type="checkbox" class="resellers" id="submr<?php echo $sub_menu_id;?>" value="<?php echo $sub_menu_id;?>" <?php echo $sub_reseller_status; ?> >
										<span><small></small></span>
									</label>
									</div>
							</div>
							<div class="w15 float-left font16">
								<div class="checkbox switcher">
									<label for="suba<?php echo $sub_menu_id;?>">
										<input type="checkbox" class="agentsList" id="suba<?php echo $sub_menu_id;?>" value="<?php echo $sub_menu_id;?>" <?php echo $sub_agent; ?>>
										<span><small></small></span>
									</label>
								</div>
							</div>
							<!-- <div class="w10 float-left font16 dark-grey_txt">
								<div class="checkbox switcher">
									<label for="submc<?php echo $sub_menu_id;?>">
										<input type="checkbox" class="customersList" id="submc<?php echo $sub_menu_id;?>" value="<?php echo $sub_menu_id;?>" <?php echo $sub_customer; ?>>
										<span><small></small></span>
									</label>
									</div>
							</div> -->
							<div class="w15 float-left ">
								<!-- <h5 class="font16 dark-grey_txt"><?php //echo $loc; ?></h5> -->
								<select class="form-control changeMenuLocation" name="changeMenuLocation">
									<option value="3" data-id="<?php echo $sub_menu_id;?>" <?php if($sub_displayLocation == 3){echo "selected";}else{echo "";}?>>Dashboard</option>
									<option value="2" data-id="<?php echo $sub_menu_id;?>" <?php if($sub_displayLocation == 2){echo "selected";}else{echo "";}?>>Left Menu</option>
									<option value="1" data-id="<?php echo $sub_menu_id;?>" <?php if($sub_displayLocation == 1){echo "selected";}else{echo "";}?>>Both</option>
								</select>
							</div>
							<?php
								if($sub_displayLocation == 3){
							?>
							<div class="w10 float-left ">
								<select class="form-control changeDisplayAt" name="changeDisplayAt">
									<option value="1" data-id="<?php echo $sub_menu_id;?>" <?php if($sub_display_dashboard_at == 1){echo "selected";}else{echo "";}?>>Top</option>
									<option value="0" data-id="<?php echo $sub_menu_id;?>" <?php if($sub_display_dashboard_at == 0){echo "selected";}else{echo "";}?>>Bottom</option>
								</select>
							</div>
							<?php }else{ ?>
							<div class="w10 float-left ">
								<div class="text-center">---</div>
							</div>
							<?php } ?>
							<div class="w10 float-left ">
								<div class="display_inline">
									<!-- <a class=" circle_btn editMenuInfo" href="#" data-id="<?php //echo $id;?>">
										<i class="fas fa-pencil-alt"></i>
									</a>
									<a class="circle_btn delete inactiveMenu" href="#" data-id="<?php //echo $sub_menu_id;?>">
										<i class="far fa-trash-alt"></i>
									</a>-->

									<select class="form-control inactiveMenu1" name="inactiveMenu1">
										<option value="1" data-id="<?php echo $sub_menu_id;?>" <?php if($sub_menu_status == 1){echo "selected";}else{echo "";}?>>Active</option>
										<option value="0" data-id="<?php echo $sub_menu_id;?>" <?php if($sub_menu_status == 0){echo "selected";}else{echo "";}?>>Inactive</option>
									</select>

								</div>
							</div>

						</div>
							<?php } } ?>
						<!-- end submenu -->
						<?php $i++; } ?>
						<div class="grid_row clearfix border-top ">
							<div class="w20 float-left font16 dark-grey_txt">
								<?php echo $menusList->render(); ?>
							</div>
						</div>
						<?php	}else{ ?>
						<div class="grid_row clearfix border-top ">
							<div class="w20 float-left font16 dark-grey_txt">
								No Menus Found
							</div>
						</div>
						<?php } ?>


					</div>
				</div>


			</div>

			<div id="accordion" class="d-lg-none d-block my-3">

					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-6 col-5">
									<img src="<?php echo url('/').'/public/mobile_menu_icons/live-tv.png"'?>" width="30px" height="30px"/><span class="pl-3 pt-1">Live TV</span>
								</div>

								<div class="col-sm-4 col-5 text-right">
									<a href="#" class="f12 attachment_btn">
										<img src="<?php echo url('/');?>/public/customer/images/attachment.png" class="img-fluid">
									</a>
								</div>

								<div class="col-2 text-right">
									<a class="card-link" data-toggle="collapse" href="#collapseOne">
										<i class="fa fa-angle-down"></i>
									</a>
								</div>
							</div>

						</div>
						<div id="collapseOne" class="collapse" data-parent="#accordion">
							<div class="card-body">
								<div class="row my-1">
									<div class="col-5 text-blue">Order</div>
									<div class="col-1">:</div>
									<div class="col-5"><input type="number" width="20" class="menuOrder form-control" name="menu_order[]" id="menu_order" value="0" data-id="31"></div>
								</div>

								<div class="row my-1">
									<div class="col-5 text-blue">Reseller</div>
									<div class="col-1">:</div>
									<div class="col-5">
										<div class="checkbox switcher">
											<label for="abcr31">
												<input type="checkbox" class="resellers" id="abcr31" value="31">
												<span><small></small></span>
											</label>
										</div>

									</div>
								</div>

								<div class="row my-1">
									<div class="col-5 text-blue">Agent</div>
									<div class="col-1">:</div>
									<div class="col-5">
										<div class="checkbox switcher">
											<label for="abcr31">
												<input type="checkbox" class="resellers" id="abcr31" value="31">
												<span><small></small></span>
											</label>
										</div>

									</div>
								</div>


								<div class="row my-1">
									<div class="col-5 text-blue">Customer</div>
									<div class="col-1">:</div>
									<div class="col-5">
										<div class="checkbox switcher">
											<label for="abcr31">
												<input type="checkbox" class="resellers" id="abcr31" value="31">
												<span><small></small></span>
											</label>
										</div>

									</div>
								</div>

								<div class="row my-1">
									<div class="col-5 text-blue">Display Menu</div>
									<div class="col-1">:</div>
									<div class="col-5">
										<select class="form-control changeMenuLocation" name="changeMenuLocation">
											<option value="3" data-id="31">Dashboard</option>
											<option value="2" data-id="31" selected="">Left Menu</option>
											<option value="1" data-id="31">Both</option>
										</select>

									</div>
								</div>

								<div class="row my-1">
									<div class="col-5 text-blue">Display At</div>
									<div class="col-1">:</div>
									<div class="col-5">
										<select class="form-control changeMenuLocation" name="changeMenuLocation">
											<option value="3" data-id="">Top</option>
											<option value="2" data-id="" selected="">Bottom</option>
											<option value="1" data-id="">Both</option>
										</select>

									</div>
								</div>

								<div class="row my-1">
									<div class="col-5 text-blue">Actions</div>
									<div class="col-1">:</div>
									<div class="col-5">
										<select class="form-control changeMenuLocation" name="changeMenuLocation">
											<option value="3" data-id="31">Dashboard</option>
											<option value="2" data-id="31" selected="">Left Menu</option>
											<option value="1" data-id="31">Both</option>
										</select>

									</div>
								</div>


							</div>
						</div>
					</div>

				</div>
		</section>
	</div>
	<!-- Delete Menu Model -->
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
						Are you sure you want to delete this Menu item?
					</div>
					<div id="pkgErrorMsg"></div>
				</div>
				<!-- footer buttons -->
				<div class="inline-buttons">
					<button type="button" class="btn inline-buttons-left cancel-btn"
						data-dismiss="modal">Cancel</button>
					<button type="button" class="btn inline-buttons-right create-btn" id="deleteMenuItem">Confirm</button>
				</div>
			</div>
		</div>
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
			$(document).ready(function() {
			// Add New Menu
			$('#addMenuBtn').on('click', function(e)  {

				e.preventDefault();

				var error = false;
				var token = "<?php echo csrf_token() ?>";
				var reg_url  = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;


				var menuName = $('#menuName').val();
				var menuLink = $('#menuLink').val();
				var normal_select = $('#normal_select').val();


				if (menuName == "") {
					$('#menuerror').html("Please Enter Menu Name");
					error = true;
				}else {
					$('#menuerror').html("");
				}
				/*if (menuLink == "") {
					$('#menulinkerror').html("Please Enter Menu Link");
					error = true;
				}else {
					$('#menulinkerror').html("");
				}*/
				if (normal_select == "") {
					$('#menuloc_error').html("Please Select Display Menu");
					error = true;
				}else {
					$('#menuloc_error').html("");
				}

				if(!error){
					var saveMenuform = new FormData($("#addmenu")[0]);
					saveMenuform.append('action', 'add');
					saveMenuform.append('_token', token);
					$.ajax({
						url: "<?php echo url('/');?>/addNewMobileMenu",
						method: 'POST',
						dataType: "json",
						data:saveMenuform,
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

			// onchange location
			$(".changeMenuLocation").on('change', function(e) {
				e.preventDefault();
				var token = "<?php echo csrf_token() ?>";
				var locationID = $(this).val();
				var rec_id = $(this).find(':selected').attr('data-id');
				if(locationID != ""){
					$.ajax({
						url: "<?php echo url('/');?>/changeMenuLocation",
						method: 'POST',
						dataType: "json",
						data: {'rec_id': rec_id,'locationID': locationID,'action': 'changelocation',"_token": token},
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
								//window.location.reload();
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
					alert("something went wrong");
				}

			});

			// Display dashboard at
			$(".changeDisplayAt").on('change', function(e) {
				e.preventDefault();
				var token = "<?php echo csrf_token() ?>";
				var locationID = $(this).val();
				var rec_id = $(this).find(':selected').attr('data-id');
				if(locationID != ""){
					$.ajax({
						url: "<?php echo url('/');?>/displayDashboardAt",
						method: 'POST',
						dataType: "json",
						data: {'rec_id': rec_id,'locationID': locationID,'action': 'displayAtlocation',"_token": token},
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
								//window.location.reload();
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
					alert("something went wrong");
				}

			});

			// Display dashboard at
			$(".inactiveMenu1").on('change', function(e) {
				e.preventDefault();
				var token = "<?php echo csrf_token() ?>";
				var statusID = $(this).val();
				var rec_id = $(this).find(':selected').attr('data-id');
				if(statusID != ""){
					$.ajax({
						url: "<?php echo url('/');?>/deleteMenuStatus",
						method: 'POST',
						dataType: "json",
						data: {'rec_id': rec_id,'status': statusID,'action': 'inactiveMenu',"_token": token},
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
								//window.location.reload();
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
					alert("something went wrong");
				}

			});




			// Alert Inactive Package
			$(".inactiveMenu").on('click', function(e) {
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

			$("#deleteMenuItem").on('click', function(e) {
				e.preventDefault();
				var token = "<?php echo csrf_token() ?>";
				var currentRecId = $("#currentRecId").text();

				if(currentRecId != ""){
					$.ajax({
						url: "<?php echo url('/');?>/deleteMenuStatus",
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



			// Ok Btn msg
			$(".OkBtnNew").on('click', function(e) {
				e.preventDefault();
				$('#successModel').modal('hide');
				window.location.reload();
			});

		});
	</script>

	<script type="text/javascript" nonce="jfsdjlfu907ssss3">
		$('#SaveallMenus' ).click(function() {

			var columnName1 = "reseller";
			var chkArray = [];
			$(".resellers:checked").each(function() {
				chkArray.push($(this).val());
			});

			var resellersList;
			resellersList = chkArray.join(',');

			var columnName2 = "agent";
			var chkArray1 = [];
			$(".agentsList:checked").each(function() {
				chkArray1.push($(this).val());
			});

			var agentsList;
			agentsList = chkArray1.join(',') ;

			var columnName3 = "customer";
			var chkArray2 = [];
			$(".customersList:checked").each(function() {
				chkArray2.push($(this).val());
			});

			/* we join the array separated by the comma */
			var customersList;
			customersList = chkArray2.join(',') ;



			getValueUsingClassNew(resellersList,agentsList,customersList,columnName1,columnName2,columnName3);
		});


		function getValueUsingClassNew(resellersList,agentsList,customersList,columnName1,columnName2,columnName3)
		{

			var token = "<?php echo csrf_token() ?>";
			/* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
			/*if(walletsselected.length > 0){*/
				$.ajax({
					url: "<?php echo url('/');?>/updateMenuPermissions",
					method: 'POST',
					dataType: "json",
					data: {'resellersList': resellersList,'agentsList': agentsList,'customersList': customersList,'columnName1': columnName1,'columnName2': columnName2,'columnName3': columnName3,'action': 'updateMenustatus',"_token": token},
					beforeSend: function(){
						$("#loader-modal").modal('show');
					},
					complete: function(){
						$("#loader-modal").modal('hide');
					},
					success: function(data){
						console.log(data);
						if(data.status=='Success'){
							$('#successModel').modal('show');
							$('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>');
							return true;
						}else {
							alert(data.Result);
							return false;
						}
					},
					error: function(error){
						alert(error);
					}
				});


			/*}else{
				//alert("Please at least check one of the checkbox");
				$('#settings-modal').modal('show');
				$("#usersetting-header").html('<h4 class="errorAlert"><span class="ti-alert"></span></h4>');
				$('#settingsmsg').html("Please check at least one of the checkbox");
				return false;
			}*/
		}

		$('#SaveallOrders' ).click(function() {

			//var columnName1 = "reseller";
			var chkArray = [];
			$("input[name='menu_order[]']").each(function() {
				var id = $(this).attr('data-id');
				chkArray.push({'id':id, 'value' : $(this).val()});
				//chkArray.push($(this).val());
			});

			//var ordersList;
			//ordersList = chkArray.join(',');
			console.log(chkArray);
			//alert(chkArray);
			//return false;

			updateMenuOrders(chkArray);
		});

		function updateMenuOrders(chkArray)
		{

			var token = "<?php echo csrf_token() ?>";

				$.ajax({
					url: "<?php echo url('/');?>/updateMenuOrders",
					method: 'POST',
					dataType: "json",
					data: {'ordersList': chkArray,'action': 'updateMenuOrders',"_token": token},
					beforeSend: function(){
						$("#loader-modal").modal('show');
					},
					complete: function(){
						$("#loader-modal").modal('hide');
					},
					success: function(data){
						console.log(data);
						if(data.status=='Success'){
							$('#successModel').modal('show');
							$('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>');
							return true;
						}else {
							alert(data.Result);
							return false;
						}
					},
					error: function(error){
						alert(error);
					}
				});

		}

	</script>


	</body>
	</html>
