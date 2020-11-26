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
		.tw-40{width:40%;float:left;}
		.tw-30{width:30%;float:left;}
		.tw-20{width:20%;float:left;}
		.tw-10{width:10%;float:left;}
		.display-none{display:none;}
		.twofaloader3 {
			position: fixed;
			left: calc(50% - 15px);
			top: calc(50% - 15px);
			z-index: 9;
			width: 100px;
			height: 100px;
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
		<img class="twofaloader3 display-none" src="<?php echo url('/'); ?>/public/images/loader.gif"/>	
          <h5 class="font16 black_txt font-bold text-uppercase1 pt-4 pb-3">APP Usage Details</h5>

          <div class=""> 
			  <div class="col-12">
					@include("versions_list.commonTabs")
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
		
		<div class="row">
				<div class="col-sm-6 order-2 order-sm-1">
					<button type="submit" class="sendFCM form_button"  id="sendFCMToAll">Proceed Force Logout</button>	
				</div>
		</div> 

          <div class="col-12">
            <div class="clearfix row">
                <div class="trail_table">
                    <div class="trail_table_titles clearfix">
						<div class="tw-10 pl-1"><input type="checkbox" id="select_all" class="checkall" style="height:20px;"/></div>
						<div class="tw-20 pl-1">User Details</div>
						<div class="tw-10 pl-1">Platform</div>
						<div class="tw-20 pl-1">Version</div>
						<div class="tw-20 pl-1">IP Address</div>
						<div class="tw-10 pl-1">Force Logout Status</div> 
						<div class="tw-10 pl-1">Online Status</div> 
					</div>
						<?php
							$i=1;
							if(@count($versions_info) >0 ){
							  foreach($versions_info as $res){
								$rec_id = $res['rec_id'];
								$user_id = $res['user_id'];
								$fullName = $res['first_name']." ".$res['last_name'];
								$email = $res['email'];
								$platform = $res['mbl_platform'];
								$vodrexMobileTVversion = $res['user_mobile_app_version'];
								$vodrexuser_mobile_versionname = $res['user_mobile_versionname'];
								$isOnlineStatus = $res['is_online'];
								/*if(!empty($vodrexuser_mobile_versionname)){
									$vodrexVersionName = " / ".$vodrexuser_mobile_versionname;	
								}else{
									$vodrexVersionName = "";
								}*/
								
								$bestBoxTVversion = $res['user_tv_version'];
								$is_force_logout = $res['is_force_logout'];
								if($is_force_logout == 1){
									$disbaleMsg = "disabled";
									$stausMsg = "Yes";
									$className="chkboxdisbaled";
								}else{
									$disbaleMsg = "";
									$stausMsg = "";
									$className="chkbox";
								}
								
								if(!empty($user_id)){
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
									
									//vodrex mobile
									$ipAddressInfo = \App\Visitor::select('*')->where('user_id','=',$rec_id)->where('req_from','=',$platform)->where('application_name','=',"VODREX")->where('device_type','=',0)->orderBy("id", "DESC")->first();
									if(!empty($ipAddressInfo)){
										$ipaddress = $ipAddressInfo->ip_address;
										$application_name = $ipAddressInfo->application_name;
										$visit_device_type = $ipAddressInfo->device_type;
										$device_type = "";
										if($visit_device_type == 0){
											$device_type = "Mobile";
										}else if($visit_device_type == 1){
											$device_type = "Tab/TV";
										}
										$ipaddr_appname = ucfirst(strtolower($application_name))." ".$device_type." : ".$ipaddress;
									}else{
										$ipaddress = "";
										$application_name="";
										$ipaddr_appname = "";
										$device_type = "";
									}
									//vodrex TV
									$ipAddressInfo_tv = \App\Visitor::select('*')->where('user_id','=',$rec_id)->where('req_from','=',$platform)->where('application_name','=',"VODREX")->where('device_type','=',1)->orderBy("id", "DESC")->first();
									if(!empty($ipAddressInfo_tv)){
										$ipaddress_tv = $ipAddressInfo_tv->ip_address;
										$application_name_tv = $ipAddressInfo_tv->application_name;
										$visit_device_type_tv = $ipAddressInfo_tv->device_type;
										$device_type = "";
										if($visit_device_type_tv == 0){
											$device_type_tv = "Mobile";
										}else if($visit_device_type_tv == 1){
											$device_type_tv = "Tab/TV";
										}
										$ipaddr_appname_tv = ucfirst(strtolower($application_name_tv))." ".$device_type_tv." : ".$ipaddress_tv;
									}else{
										$ipaddress_tv = "";
										$ipaddr_appname_tv="";
										$visit_device_type_tv = "";
										$device_type_tv = "";
									}
									//bestbox-tv
									$ipAddressInfoBestBox = \App\Visitor::select('*')->where('user_id','=',$rec_id)->where('req_from','=',$platform)->where('application_name','=',"BESTBOX")->orderBy("id", "DESC")->first();
									if(!empty($ipAddressInfoBestBox)){
										$ipaddress_bb = $ipAddressInfoBestBox->ip_address;
										$application_name_bb = $ipAddressInfoBestBox->application_name;
										$visit_device_type_bb = $ipAddressInfoBestBox->device_type;
										$device_type_bb = "";
										if($visit_device_type_bb == 0){
											$device_type_bb = "Mobile";
										}else if($visit_device_type_bb == 1){
											$device_type_bb = "TV";
										}
										$ipaddr_appname_bb = ucfirst(strtolower($application_name_bb))." ".$device_type_bb." : ".$ipaddress_bb;
									}else{
										$ipaddress_bb = "";
										$application_name_bb="";
										$ipaddr_appname_bb = "";
										$device_type_bb = "";
									}
									
									//bestbox-web 
									$ipAddressInfoBestBox_web = \App\Visitor::select('*')->where('user_id','=',$rec_id)->where('req_from','=',"Web")->orderBy("id", "DESC")->first();
									if(!empty($ipAddressInfoBestBox_web)){
										$ipaddress_bb_web = $ipAddressInfoBestBox_web->ip_address;
										$application_req_from = $ipAddressInfoBestBox_web->req_from;
										
										$ipaddr_appname_bb_web = "Bestbox ".$application_req_from." : ".$ipaddress_bb_web;
									}else{
										
										$ipaddr_appname_bb_web = "---";
									}
									
									
									
									
									
								}
							

						?>

							<!-- ROW --1 -->
							<div class="trail_table_row clearfix">
								<div class="tw-10 pl-1 trial_brbtm">
									<input type="checkbox" id="" class="<?php echo $className; ?>" value="<?php echo $rec_id; ?>" style="height:20px;" <?php echo $disbaleMsg; ?> />
								</div>
								<div class="tw-20 pl-1 font-weight-bold" >
									<span class="m_title">User Details</span>    
									<span>User ID : <?php echo $user_id; ?></span><br/>
									<span>Name : <?php echo ucfirst($fullName); ?></span><br/>
									
								</div> 
								<div class="tw-10 pl-1 trial_brbtm">
									<span class="m_title">Platform</span>
									<?php echo $platform; ?>
								</div>
								<div class="tw-20 pl-1 trial_brbtm">
									<span class="m_title">Version</span>
									
									<?php if(!empty($bestBoxTVversion)){?>
									<span>BestBOX- TV : <?php echo $bestBoxTVversion; ?></span><br/>
									<?php }?>
									<?php if(!empty($vodrexuser_mobile_versionname)) {?>
									<span>Vodrex - Mobile/Tab/TV : <?php echo $vodrexuser_mobile_versionname; ?></span>
									<?php }else{?>
									<span>----</span>
									<?php }?>
								</div>
								<div class="tw-20 pl-1 green_txt1 font-weight-bold trial_brbtm-767">
									<div class="m_title">IP Address</div>
									<div><?php echo $ipaddr_appname;?></div>
									<div><?php echo $ipaddr_appname_tv;?></div>
									<div><?php echo $ipaddr_appname_bb;?></div>
									<div><?php echo $ipaddr_appname_bb_web;?></div>
								</div> 
								<div class="tw-10 pl-1 green_txt font-weight-bold trial_brbtm-767">
									<span class="m_title">Status</span>
									<?php echo $stausMsg;?>
								</div> 
								
								<div class="tw-10 pl-1 green_txt font-weight-bold trial_brbtm-767">
									<span class="m_title">Online Status</span>
									<?php 
									if($isOnlineStatus == 1){
										$online_status_msg = "Online";
									}else{
										$online_status_msg = "Offline";
									}	
									echo $online_status_msg;
									?>
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
				
				 <?php if(@count($versions_info) >0 ){ ?>
					<div class="pagi">
						<?php echo $versions_info->links();?>
					</div>	
				  <?php } ?>
				
            </div>
            </div>
			
        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
	
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
	
	<script type="text/javascript">
		$(document).ready(function(){
			$("#select_all").change(function(){  
				
				$(".chkbox").prop('checked', $(this).prop("checked")); 
			});
			
			$('.chkbox').change(function(){ 
				
				if(false == $(this).prop("checked")){ 
					$("#select_all").prop('checked', false); 
				}
				//check "select all" if all checkbox items are checked
				if ($('.chkbox:checked').length == $('.chkbox').length ){
					$("#select_all").prop('checked', true);
				}
			});
			
			$('#sendFCMToAll' ).click(function() {
				var chkArray = [];
				$(".chkbox:checked").each(function() {
					chkArray.push($(this).val());
				});
				
				var moviesselected;
				moviesselected = chkArray.join(',');
				//alert(moviesselected);
				//return false;
				if(moviesselected.length > 0){
					
					var action = "multipleuser";
					sendAnnouncementFCM(moviesselected,action);
					
				}else{
					alert("Please select atleast one checkbox");
					return false;
				}
				
				
			});
        }); 
	</script>
	
	<script type="text/javascript" nonce="32432jlkfsdaf">
		$('body').on('change', '.sendFCM1', function(){
			//var id = $(this).attr("data-id"); 
			var id = $(this).find(':selected').attr('data-id');
			var value = $(this).val();
			
			if(value == 1){
				var action = "singleuser";
				sendAnnouncementFCM(id,action);
			}else{
				var action = "pending";
				sendAnnouncementFCM(id,action);
			}
			
			
		});
		
		function sendAnnouncementFCM(id,action){
			var currentRecId = id;
			var token = "<?php echo csrf_token() ?>";
			$.ajax({
				url: "<?php echo url('/');?>/sendFCMForceLogout",
				method: 'POST',
				dataType: "json",
				data: {'rec_ids': currentRecId,'action': action,"_token": token},
				beforeSend: function(){
					$(".twofaloader3").show();
				},
				complete: function(){
					$(".twofaloader3").hide();
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
		}
		
		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) { 
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
		});
		
	</script>
	
	
	<script type="text/javascript">
		var url = "<?php echo url('/forceLogout'); ?>";

     
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