<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX</title>
    <link rel="shortcut icon" href="{{ url('/').'/public/favicon.png' }}" type="image/png" sizes="32x32" />
	<link rel="stylesheet" href="https://www.jquery-az.com/boots/css/bootstrap-multiselect/bootstrap-multiselect.css" type="text/css">
	<!-- <link rel="stylesheet" href="https://www.jquery-az.com/boots/css/bootstrap-multiselect/bootstrap-multiselect.css" type="text/css"> -->
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet"> -->
	<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- All styles include -->
    @include("inc.styles.all-styles")
	
    <style>
         .select2-container--default .select2-selection--single{
            background-color:transparent !important;
            border:none !important;
            border-bottom: solid 3px #7f868b !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single{
            height:33px !important;
        }
        .select2-selection__rendered[title="Select Country"]{
            font-size:14px !important;
            color: #737a82 !important;
        }
        .fa-angle-left{
            font-size: 20px;
            line-height: 25px;
            margin-right: 5px;
            color: #0091d6;
        }
		.error{color:red;}
		.new-width{
			width:700px !important;
		}
		.custchk{float: left;width: 232px;}
		.custrdi{float: left;width: 330px;}
		#cke_10{display:none !important;}
		#cke_15{display:none !important;}
		#cke_18{display:none !important;}

		.multiselect-container{
			padding: 0 !important;
		}

		.multiselect-container .active{
			background-color: #fff !important;
		}

        .multiselect-container.dropdown-menu.show {
            transform: translate3d(0px, 0, 0px) !important;
            width: 370px;
        }

        .multiselect-container.dropdown-menu.show>li>a>label {
            display: flex;
            padding: 10px;
            align-items: center;
            font-size: 14px;
            line-height: 40px;
            height: 40px;
        }

        .multiselect-container.dropdown-menu.show>li>a {
            display: block;
            text-decoration: none;
        }

        .multiselect-container.dropdown-menu.show li a label input {
            margin-right: 20px;
            width: 20px;
        }

        .multiselect-native-select .btn-group {
            border-radius: .25em !important;
            border: 1px solid #0096DA;
			background-color: #e9ecef;
			width: 100% !important;
        }

        .multiselect.dropdown-toggle::after {
            display: none !important;
        }

        .multiselect {
            width: 100% !important;
		}
		
		.btn.btn-default.multiselect-clear-filter{
			display: none;
		}

		.multiselect-search{margin: 0 10px 0 10px !important;}

		.multiselect-container.dropdown-menu.show{
			width: 100% !important;
			max-height: 400px;
			overflow-y: scroll;
			overflow-x: hidden;
		}

		.multiselect-selected-text{
			float: left;
		}
		
		.multiselect-container > li > a > label > input[type="checkbox"] {
			margin-bottom: -5px !important;
		}

		.multiselect.dropdown-toggle.btn.btn-default{
			width: 100%;
			word-break: break-all;
			overflow: hidden;
		}

		.multiselect-selected-text{
			width: 100%;
			word-break: break-all;
			overflow: hidden;
			float: left;
			text-align: left;
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
        <section class="main_body_section scroll_div">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <i class="fas fa-angle-left"></i>
                <li class="breadcrumb-item f16"><a href="{{ url('/').'/getAnnouncementsList' }}" class="f16">Announcements</a></li>
                    <li class="breadcrumb-item active f16" aria-current="page" class="f16">Add New Announcement</li>
                </ol>
            </nav>

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">Add New Announcement</h5>
            <div class="row">
                <div class="col-md-6">
                    
                </div>
            </div>
           
            <div class="clearfix row">
                <div class="col-12">
                    <div class="form-width new-width">
                        <!-- <table class="rwd-table body_bg">
                            
                        </table> -->
						<form method="post" id="create_form" name="create_form">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							<!-- Agent Email -->
							<!--<div class="form-group"> 
							<div class="custom-control custom-checkbox mb-3 custchk">
							<input type="checkbox" class="custom-control-input platformtype" name="platformtype" id="customCheck1" value="web" >
							<label class="custom-control-label" for="customCheck1">Web</label>
							</div>
							
							<div class="custom-control custom-checkbox mb-3 custchk">
								<input type="checkbox" class="custom-control-input platformtype" name="platformtype" id="customCheck2" value="android" >
							<label class="custom-control-label" for="customCheck2">Android</label>
							</div> -->

							<!-- <div class="custom-control custom-checkbox mb-3 custchk">
							<input type="checkbox" class="custom-control-input platformtype" name="platformtype" id="customCheck3" value="ios" >
							<label class="custom-control-label" for="customCheck3">IOS</label>
							</div> -->


							<!-- <div class="text-right f14">
								<span id="platformtypeerror" class="text-left error"></span>
								<span class="text-danger text-right">*</span>
								<span id="" class="text-muted f14 black_txt text-right">Platform Type</span>
							</div> -->

							<!--</div>-->

							<div class="row">
								<div class="col-md-7">
									<div class="mobile_menu_section body_bg form-group">
										<select id="boot-multiselect-demo" multiple="multiple" class="w-100">
											<?php if(!empty($userList)){
											foreach($userList as $list){?>
											<option value="<?php echo $list['rec_id'];?>">
												<?php echo $list['first_name'].' '.$list['last_name'].' ('.$list['user_id'].')';?>
											</option>
											<?php }
										}?>
										</select>

										<div class="text-right f12">
											<span class="text-danger f12">*</span>
											<span id="emailHelp" class="text-muted f14 black_txt">Users List</span>
											<span id="users_list_err" class="f11 red_txt" style="float: left;"></span>
										</div>
										
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<div class="col-sm-12">
											<div id="expiryDate" class="input-group date  m-0" data-date-format="mm/dd/yyyy">
												<input class="form-control datepicker_input" type="text" readonly
													id="expiry_date" value="" />
												<span class="input-group-addon calender_icon"><i
														class="far fa-calendar-alt"></i></span>
											</div>
											
											<div class="text-right">
												<span id="expiry_date_err" class="f11 red_txt" style="float: left;"></span>
												<span class="text-danger f12"></span>
												<span id="first_name" class="text-muted f12 black_txt">Expirty Date</span>
											</div>
											
										</div>
										
									</div>
								</div>
							</div>
						
							<!-- First Name -->
							<div class="form-group">
								<input type="text" class="form-control border-bottom-only body_bg" id="title"
									name="title" aria-describedby="title" placeholder="Title" value="" />
								<div class="text-right f12">
									<span id="titleerror" class="text-left error f11 red_txt" style="float: left;"></span>
									<span class="text-danger">*</span>
									<span id="first_name" class="text-muted f12 black_txt">Title</span>
									<!-- <span id="titleerror" class="text-left f11 error" style="float: left;"></span> -->
								</div>

							</div>

							<!-- Last Name -->
							<div class="form-group">
								<textarea id="editor1" name="editor1" class="editor1 w-100 " maxlength="10"> </textarea>

								<div class="text-right f12">
									<span id="descriptionerror" class="text-left error limichars f11 red_txt" style="float: left;"></span>
									<span class="text-danger text-right">*</span>
									<span id="" class="text-muted f12 black_txt text-right">Description</span>
								</div>
								<span id="remain" style="color:red;" class="f11 red_txt"></span>
							</div>

							<!-- Gender -->
								<!-- <div class="mobile_menu_section body_bg form-group">
								<select class="normal_select" name="announcement_type" id="announcement_type">
									<option value="" class="dk_placeholder">Select Announcement type</option>
									<option value="1">FCM Announcement</option>
									<option value="2">popup Announcement</option>
								</select>
								<div class="text-right f14"><span id="emailHelp" class="text-muted f14 black_txt">Announcement type</span></div>
								<div id="announcement_type_err" class="f14 red_txt"></div>
							</div> -->

							<!--  
								<div class="form-group">
								
								<div class="custom-control custom-radio custrdi">
								<input type="radio" name="popupstatus" class="custom-control-input popupstatus" id="customRadio1" value="1">
								<label class="custom-control-label" for="customRadio1">Yes</label>
								</div>
								
								<div class="custom-control custom-radio custrdi">
								<input type="radio" name="popupstatus" class="custom-control-input popupstatus" id="customRadio2" value="0">
								<label class="custom-control-label" for="customRadio2">No</label>
								</div>
								
							
								<div class="text-right f14">
									<span id="popupstatuserror" class="text-left error"></span>
									<span class="text-danger text-right"></span>
									<span id="" class="text-muted f14 black_txt text-right">Popup Status</span>
								</div>
							</div> -->

							<div class="my-4">
								<div class="display_inline">
									<button type="button" id="saveinfo"
										class="btn btn_primary d-block w-100 mt-4 ">Send</button>
								</div>
							</div>

						</form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
	<div class="modal fade" id="successModel" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20 w-100 d-block" id="exampleModalLongTitle">
                        Confirmation</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
				
                <div class="modal-body add_edit_user pb-4">
                    <div class="text-center f20 black_txt py-5 mb-5 " id="sucessMsg"></div>
				</div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <!-- <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button> -->
                    <button type="button" class="btn inline-buttons-right create-btn OkBtnNew w-100" id="OkBtn">Ok</button>
                </div>
            </div>
        </div>
    </div>
	<script type="text/javascript" src="<?php echo url('/');?>/public/ckeditor/ckeditor.js"></script>
	


  	<script type="text/javascript" nonce="32432jlkfsdaf">
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
		CKEDITOR.replace( 'editor1',
		{
			extraAllowedContent: 'style;*[id,rel](*){*}',
			filebrowserBrowseUrl : '<?php echo url('/');?>/public/ckeditor/ckfinder/ckfinder.html',
			filebrowserImageBrowseUrl : '<?php echo url('/');?>/public/ckeditor/ckfinder/ckfinder.html?type=Images',
			filebrowserFlashBrowseUrl : '<?php echo url('/');?>/public/ckeditor/ckfinder/ckfinder.html?type=Flash', 
			filebrowserUploadUrl : '<?php echo url('/');?>/public/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files', 
			
			filebrowserImageUploadUrl : '<?php echo url('/');?>/public/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			//filebrowserImageUploadUrl : '<?php echo url('/');?>/public/ckeditor/upload/upload.php',
			filebrowserFlashUploadUrl : '<?php echo url('/');?>/public/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
			filebrowserWindowWidth : '1000',
			filebrowserWindowHeight : '700'
		});
	</script>	
	<script type="text/javascript" nonce="32432jlkfsdaf">
		
		CKEDITOR.instances.editor1.on( 'key', function() {
			var str = CKEDITOR.instances.editor1.getData();
			var text = $(str).text();
			//console.log(text);
			console.log(text.length);
			//var maxchars = 10;
			//remain = maxchars - parseInt(text.length); 
			if (text.length > 500) {
				//CKEDITOR.instances.editor1.setData(str.substring(0, 10));
				//alert("minimum characters reached");
				$('#remain').text("maximum 500 characters reached");
				CKEDITOR.instances.editor1.setData(str.substring(0, 500));
				return false;
			}else{
				$('#remain').text("");
				console.log("not reached");
			}
		});
		
		$('body').on('click', '#saveinfo', function(e){ 
			e.preventDefault();
			var error = false;
			
			var token = "<?php echo csrf_token() ?>";
			// var chkArray2 = [];
			// 	$(".platformtype:checked").each(function() {
			// 		chkArray2.push($(this).val());
			// 	});
				
				/* we join the array separated by the comma */
				// var platformtypeList;
				// platformtypeList = chkArray2.join(',') ;
				
				var str = CKEDITOR.instances.editor1.getData();
				var text = $(str).text();
				
				if (text.length > 500) { 
					//$('.limichars').text("Maximum 500 Characters only");
					//alert("Maximum 500 Characters only");
					$('#remain').text("maximum 500 characters reached");
					CKEDITOR.instances.editor1.setData(str.substring(0, 500));
					return false;
					//error = true;
				}else{
					$('.limichars').text("");
					$('#remain').text("");
				}

				var description = CKEDITOR.instances['editor1'].getData().length;
				var popupstatus = 0; //$("input[name='popupstatus']:checked").val();
				var title = $("#title").val();
				//alert(description);
				var announcement_type = $("#announcement_type").val();
				
				if(title == ""){ 
					$('#titleerror').html("Please Enter title");
					error = true;
				}else {
					$('#titleerror').html("");
				}
				if(description == ""){ 
					$('#descriptionerror').html("Please Enter Description");
					error = true;
				}else {
					$('#descriptionerror').html("");
				}
				
				// if(platformtypeList.length == 0){
				// 	$('#platformtypeerror').html("Please select platform type");
				// 	error = true;
				// }else{
				// 	$('#platformtypeerror').html("");
				// }

				// if(announcement_type == ""){ 
				// 	$('#announcement_type_err').html("Please Select Announcement Type");
				// 	error = true;
				// }else {
				// 	$('#announcement_type_err').html("");
				// }

				//if(announcement_type == 2){
					var expiry_date = $("#expiry_date").val();
					// if(expiry_date == ""){ 
					// 	$('#expiry_date_err').html("Please Enter Expiry Date");
					// 	error = true;
					// }else {
					// 	$('#expiry_date_err').html("");
					// }
				// }else{
				// 	var expiry_date = '';
				// 	$('#expiry_date_err').html("");
				// }
				
				var select1 = document.getElementById("boot-multiselect-demo");
				var selected1 = [];
				for (var i = 0; i < select1.length; i++) {
					if (select1.options[i].selected) selected1.push(select1.options[i].value);
				}
				if(selected1.length == 0){
					$('#users_list_err').html("Please select Users");
					error = true;
				}else{
					$('#users_list_err').html("");
				}
								
				if(!error){
					var description1 = CKEDITOR.instances['editor1'].getData(); //$("#editor1").val();
					$.ajax({
						url: "<?php echo url('/');?>/saveAnnouncmentData",
						method: 'POST',
						dataType: "json",
						data: {'title':title,'description':description1,'expiry_date':expiry_date,'users_list' : selected1,'action':"save","_token": token},
						beforeSend: function(){
							$(".loaderIcon").show();
						},
						complete: function(){
							$(".loaderIcon").hide();
						},
						success: function (data) { 
							
						   if(data.status=='Success'){
								$("#title").val('');
								$("#expiry_date").val('');
								$("#successModel").modal('show');
								$('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>'); 
								return true;
							}else{
							 
								alert(data.Result);
								return false;
								
							}  
						},
						error:function (xhr, ajaxOptions, thrownError){
							alert("failure234") ;
							alert(thrownError);
						}
					});
			
				
				}else{
					//alert("Something went wrong");
					return false;
				}
			
		});
		
		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) { 
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.href="<?php echo url('/').'/getAnnouncementsList';?>";
		});

		
			$(function () {
				$("#expiryDate").datepicker({ 
					minDate: '0', 
					autoclose: true,
					todayHighlight: true
				});
			});
            
		

		// $("#announcement_type").change(function(){
		// 	var type=$(this).val();
		// 	if(type == 2){
		// 		$("#expiry_div").show();
		// 	}
		// })
		
	</script>	
	<!-- <script type="" src="https://www.jquery-az.com/boots/js/bootstrap-multiselect/bootstrap-multiselect.js"></script> -->
	<script type="" src="<?php echo url('/').'/public/js/customer/bootstrap-multiselect1.js';?>"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('#boot-multiselect-demo').multiselect({
            includeSelectAllOption: true,
            buttonWidth: 250,
            enableFiltering: true
        });
        });
    </script>

</body>
</html>