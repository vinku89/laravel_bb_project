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
	 .w5-md {
		width: 5%;
	}
	.w20-md{
		width: 20%;
	}
	.w50-md{
		width: 50%;
	}
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
	  .sendFCM{
		border: 0px;
 
		background: #005aa9;
		color: #fff;
		padding: 5px 10px;
	  }
		.green{color:green;}
		.red{color:red;}
		.pswview-icon {
			position: absolute;
			z-index: 2;
			right: 0;
			top: -10px;
			cursor: pointer;
			font-size: 15px;
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
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Free Trials CMS Accounts List</h5>
			<div class="row">
				<div class="col-sm-6">
					<div class="input-group mb-1 search_wrap">
						<div class="input-group-prepend">
							<span class="searchicon searchbyEmail" id="basic-addon1"><img src="<?php echo url('/');?>/public/images/search.png"></span>
						</div>
						<input type="text" class="form-control searchbar" placeholder="User Name" id="searchKey" name="searchKey" value="<?php echo ($searchKey)?$searchKey:""; ?>" aria-label="Movie Name" aria-describedby="basic-addon1" style="margin-bottom:0px !important;">
					</div>
				</div>
				<div class="col-sm-6 text-right">
					<div class="d-inline-block">
						<a href="#" class="big_blue_btn" data-toggle="modal" data-target="#addNewUser">Add New CMS Account</a>
					</div>

                </div>
			</div>
		
          <div class="middle_box clearfix">
            <div class="grid_wrp add-user-grid">
              <div class="grid_header clearfix pt-3 pb-3 d-lg-block d-none">
				<div class="w20 float-left font16 font-bold blue_txt pl-2">Channel No</div>
                <div class="w50 float-left font16 font-bold blue_txt pl-2">CMS User Name</div>
                <div class="w15 float-left font16 font-bold blue_txt pl-2 text-lg-center">Status</div>
                <div class="w15 float-left font16 font-bold blue_txt pl-2 text-lg-center">Action</div> 
              </div>
              <div class="grid_body clearfix">
                <!--Row 1-->
                <?php
                $i=1;
				if(!empty($cms_info)){
                  foreach($cms_info as $res){

                ?>
                <div class="grid_row clearfix border-top">
					
                    <div class="w20-md grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">Channel No</span>
                        <?php echo $res['channel'];?>
                    </div>
                    <div class="w50-md grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">User Name</span>
                        <?php 
							$decrypted_username = safe_decrypt($res['cms_username'],config('constants.encrypt_key'));
							echo $decrypted_username;
						?>
                    </div>
                   
                    <div class="w15-md grid_td_info text-lg-center">
						<select class="form-control disableCMSAct" name="disableCMSAct"> 
							<option value="1"  data-id="<?php echo $res['rec_id'];?>" <?php if($res['status'] == 1){echo "selected";}else{echo "";}?>>Active</option>
							<option value="0"  data-id="<?php echo $res['rec_id'];?>" <?php if($res['status'] == 0){echo "selected";}else{echo "";}?>>In-Active</option>
							
						</select>
                        
                    </div> 
                    <div class="w15-md grid_td_info text-lg-center">
						<div class="circle_btn editcmsBtn" data-id="<?php echo $res['rec_id'];?>"><i class="fas fa-edit"></i></div>
						<div class="circle_btn deleteBtn" data-id="<?php echo $res['rec_id'];?>"><i class="fa fa-trash" aria-hidden="true"></i></div>
					</div>
                </div>
                <?php
                $i++;
                  }
				}else{
                ?>
				<div class="grid_row clearfix border-top">
				 <h2>No Records Found</h2>  
				 </div>
				<?php } ?>
                  
              </div>
            </div>
          </div>
        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
	
		 <!-- Add New CMS USER -->
    <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Add New CMS Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-4">
                    <form id="addcms" name="addcms" method="post" enctype="multipart/form-data">
                       
                        <div class="form-group">
                            <input type="text" name="cms_username" class="form-control border-bottom-only" id="cms_username"
                                aria-describedby="emailHelp" placeholder="CMS UserName">
                            <div class="text-right f14">
							<span id="userNameerror" class="text-left error"></span>
							<span class="text-danger text-right">*</span>
							<span id="" class="text-muted f14 black_txt text-right">CMS UserName</span>
							</div>
                        </div>
						
						<div class="form-group" style="position:relative;">
							<input type="password" class="form-control border-bottom-only body_bg" id="cms_password" name="cms_password" aria-describedby="emailHelp" placeholder="CMS Password">
							<div class="text-right f14">
								<span id="cmspwderror" class="text-left error"></span>
								<span class="text-danger text-right">*</span>
								<span id="emailHelp" class="text-muted f14 black_txt">Password</span>
							</div>
							<span class="icon validation small" style="color:black;">
									<i class="fa fa-fw pswview-icon toggle-password1 fa-eye-slash" toggle="#cms_password"></i>
							</span>
						</div>
						
						
						
                    </form>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="addCMSAcc">Add</button>
                </div>
            </div>
        </div>
    </div>
	
	<!-- Edit CMS USER -->
    <div class="modal fade" id="editCMSModel" tabindex="-1" role="dialog" aria-labelledby="editCMSModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Edit CMS Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-4">
                    <form id="addcms" name="addcms" method="post" enctype="multipart/form-data">
                       
                        <div class="form-group">
                            <input type="text" name="edit_cms_username" class="form-control border-bottom-only" id="edit_cms_username"
                                aria-describedby="emailHelp" placeholder="CMS UserName" value="" readonly />
                            <div class="text-right f14">
							<span id="edituserNameerror" class="text-left error"></span>
							<span class="text-danger text-right">*</span>
							<span id="" class="text-muted f14 black_txt text-right">CMS UserName</span>
							</div>
                        </div>
						
						<div class="form-group" style="position:relative;">
							<input type="password" class="form-control border-bottom-only body_bg" id="edit_cms_password" name="edit_cms_password" aria-describedby="emailHelp" placeholder="CMS Password">
							<div class="text-right f14">
								<span id="editcmspwderror" class="text-left error"></span>
								<span class="text-danger text-right">*</span>
								<span id="emailHelp" class="text-muted f14 black_txt">Password</span>
							</div>
							<span class="icon validation small" style="color:black;">
									<i class="fa fa-fw pswview-icon toggle-password2 fa-eye-slash" toggle="#edit_cms_password"></i>
							</span>
						</div>
						
						<input type="hidden" name="edit_rec_id" id="edit_rec_id" value=""/>
						
                    </form>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="updateCMSAcc">Update</button>
                </div>
            </div>
        </div>
    </div>
	
	
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
		$('body').on('change', '.disableCMSAct', function(){
			var value = $(this).val(); 
			var currentRecId = $(this).find(':selected').attr('data-id');
			var action = "";
			
			var token = "<?php echo csrf_token() ?>";
			$.ajax({
				url: "<?php echo url('/');?>/disableTrailCMSAccount",
				method: 'POST',
				dataType: "json",
				data: {'rec_id': currentRecId,'value': value,'action': action,"_token": token},
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
			
			
		});
		
		// Edit CMS Account
		$('body').on('click', '.editcmsBtn', function(){
			var rec_id = $(this).attr("data-id");
			var token = "<?php echo csrf_token() ?>";
			$.ajax({
				url: "<?php echo url('/');?>/editCMSAccount",
				method: 'POST',
				dataType: "json",
				data: {'rec_id': rec_id,"_token": token},
				beforeSend: function(){
					$(".loaderIcon").show();
				},
				complete: function(){
					$(".loaderIcon").hide();
				},
				success: function (data) { 
				   if(data.status=='Success'){
						$("#editCMSModel").modal('show');
						$("#edit_rec_id").val(data.Result.rec_id);
						$("#edit_cms_username").val(data.Result.cms_username);
						$("#edit_cms_password").val(data.Result.cms_password);
						
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
			
			
		});
		
		
		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) { 
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
		});
		
		
		// delete user 
	
	  $(".deleteBtn").click(function(e){
            e.preventDefault();
            var rec_id = $(this).attr("data-id");
			//alert(rec_id);return false;
			var csrf_Value = "<?php echo csrf_token() ?>";
            setTimeout(function(){
                    swal({
                        title: 'Are you sure you want delete ?',
                        //text: "Your withdrawal <b>"+transfer_amount+" USD</b> will be transafer to user <b>"+user_name+"</b> wallet.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4FC550',
                        cancelButtonColor: '#D0D0D0',
                        confirmButtonText: 'Yes, proceed it!',
                        closeOnConfirm: false,
                        //html: transfer_amount+" USD</b> transfer to user </br><b>"+user_name+"</b> wallet."
                    }).then(function (result) {
                        if (result.value) {
                            
							
							$.ajax({
								url: "<?php echo url('/');?>/deleteTrailCMSAccount",
								method: 'POST',
								dataType: "json",
								data: {'rec_id': rec_id,"_token": csrf_Value},
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
							
							
                        }
                    }).catch(swal.noop);
            },100);
            
        });
		
		// Add CMS Account
		$('#addCMSAcc').on('click', function(e)  { 
			
			e.preventDefault();
			
			var error = false;
			var token = "<?php echo csrf_token() ?>";
			var reg_url  = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;
			
			var currentDivID = $(this).attr('data-id');
			
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
		
		
		// Update CMS Account
		$('#updateCMSAcc').on('click', function(e)  { 
			
			e.preventDefault();
			
			var error = false;
			var token = "<?php echo csrf_token() ?>";
			
			var rec_id = $('#edit_rec_id').val();
			var cms_username = $('#edit_cms_username').val();
			var cms_password = $('#edit_cms_password').val();
			
			
			if (cms_username == "") {
				$('#edituserNameerror').html("Please Enter CMS UserName");
				error = true;
			}else {
				$('#edituserNameerror').html("");
			}
			
			if (cms_password == "") {
				$('#editcmspwderror').html("Please Enter CMS Password");
				error = true;
			}else {
				$('#editcmspwderror').html("");
			}
			
			
			if(!error){
				
				$.ajax({
					url: "<?php echo url('/');?>/updateCMSAccount",
					method: 'POST',
					dataType: "json",
					data: {'rec_id': rec_id,'cms_username': cms_username,'cms_password': cms_password,"_token": token},
					 
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) { 
					   if(data.status=='Success'){
							$("#editCMSModel").modal('hide');
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
		
		
	</script>
  
    <script type="text/javascript">
    
        $(document).ready(function(){
            $("#fromDate").datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                endDate: "today"
            });

            $("#toDate").datepicker({
                autoclose: true, 
                todayHighlight: true,
                endDate: "today"
            });
			
			$(".toggle-password1").click(function() { 
				
			  $(this).toggleClass("fa-eye fa-eye-slash");
			  var input = $($(this).attr("toggle"));
			  if (input.attr("type") == "password") {
				input.attr("type", "text");
			  } else {
				input.attr("type", "password");
			  }
			});
			
			//edit password
			$(".toggle-password2").click(function() { 
				
			  $(this).toggleClass("fa-eye fa-eye-slash");
			  var input = $($(this).attr("toggle"));
			  if (input.attr("type") == "password") {
				input.attr("type", "text");
			  } else {
				input.attr("type", "password");
			  }
			});
			
			
        }); 
        
        
        var url = "<?php echo url('/freeTrailCmsAccounts'); ?>";

     
        $("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey;
            }
        });

        
         /* filter data */
       /* $("#filter_data").click(function(e){
            e.preventDefault();
            
            var from_date = $("#from_date").val().trim();
            var to_date = $("#to_date").val().trim();
            var searchKey = $("#searchKey").val().trim();
            //alert(searchKey);return false;
            if( (searchKey == '') && (from_date == '' || to_date == '') ) {
                alert('Please select atleast one filter');
                return false;
            }else if(to_date < from_date ) {
				alert('To date should be grater than From Date');
				return false;
			}else{
                var searchUrl = url+'?searchKey='+searchKey+'&from_date='+from_date+'&to_date='+to_date; 
                location.href=searchUrl;
            }
        });*/

        /* clear filter data */
        $("#clear_filter_data").click(function(e){
            e.preventDefault();
            //alert("test");
            $("#from_date").val('');
            $("#to_date").val('');
            var searchKey = $("#searchKey").val().trim();
            
            //var searchUrl = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
            location.href="<?php echo url('/getReferralsList'); ?>";
            
        });
        
        
    </script>

</body>
</html>