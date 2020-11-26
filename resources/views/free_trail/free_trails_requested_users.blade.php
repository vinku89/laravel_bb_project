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
		.yellow{color:yellow;}
		.btnSubmit{
			border: 0px;
			background: #005aa9;
			color: #fff;
			padding: 5px 10px;
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
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Free Trial Requested Users</h5>
			<!-- <div class="row">
				<div class="col-sm-6 order-2 order-sm-1">
					<div class="input-group mb-1 search_wrap">
						<div class="input-group-prepend">
							<span class="searchicon searchbyEmail" id="basic-addon1"><img src="<?php echo url('/');?>/public/images/search.png"></span>
						</div>
						<input type="text" class="form-control searchbar" placeholder="Movie Name" id="searchKey" name="searchKey" value="<?php //echo ($searchKey)?$searchKey:""; ?>" aria-label="Movie Name" aria-describedby="basic-addon1" style="margin-bottom:0px !important;">
					</div>
				</div>
			</div> -->
			
          <div class="middle_box clearfix">
            <div class="grid_wrp add-user-grid">
              <div class="grid_header clearfix pt-3 pb-3 d-lg-block d-none">
				<div class="w25 float-left font16 font-bold blue_txt pl-2">User Info</div>
                <div class="w15 float-left font16 font-bold blue_txt pl-2">Trial Requested Date</div>
                <div class="w15 float-left font16 font-bold blue_txt pl-2">Trial Start Time</div>
                <div class="w15 float-left font16 font-bold blue_txt pl-2">Trial End Time</div>
                <div class="w10 float-left font16 font-bold blue_txt pl-2 text-lg-center">Status</div>
                <div class="w20 float-left font16 font-bold blue_txt pl-2 text-lg-center">Is Extend</div> 
              </div>
              <div class="grid_body clearfix">
                <!--Row 1-->
                <?php
                $i=1;
				if(!empty($freetrail_info)){
                  foreach($freetrail_info as $res){
					$user_id = $res['user_id'];
					$userinfo = \App\User::where('rec_id', $user_id)->first();
					
					$email ="";$userID="";$registration_date="";
					if(!empty($userinfo)){
						$email = $userinfo->email;
						$userID = $userinfo->user_id;
						$registration_date = $userinfo->registration_date;
					}
					
					if($res['is_pending'] == 1){
						$status_msg = "Activation Pending";
						$status_msg_cls = "yellow";
					}else if($res['status'] == 2){
						$status_msg = "Expired";
						$status_msg_cls = "red";
					}else if($res['status'] == 1){
						$status_msg = "Going On";
						$status_msg_cls = "green";
					}else{
						$status_msg = "";
						$status_msg_cls = "";
					}
					
					if($res['extend'] == 1){
						$extend_msg = "Yes";
						$extend_msg_cls = "green";
					}else if($res['extend'] == 2){
						$extend_msg = "Admin Extended";
						$extend_msg_cls = "green";
					}else{
						$extend_msg = "No";
						$extend_msg_cls = "";
					}

                ?>
                <div class="grid_row clearfix border-top">
					
                    <div class="w25-md grid_td_info word-break">
                       <span >Registered Date : <?php echo date("d-m-Y",strtotime($registration_date));?> </span><br/>
					   <span>User ID :  <?php echo $userID; ?></span><br/>
					   <span>E-mail :  <?php echo $email; ?></span>
                    </div>
					<div class="w15-md grid_td_info word-break">
                        <?php echo date("d-m-Y H:i:s",strtotime($res['trail_requested_time']));?>
                    </div>
                    <div class="w15-md grid_td_info word-break">
                       <?php 
						   if(!empty($res['trail_start_time'])){
							    echo date("d-m-Y H:i:s",strtotime($res['trail_start_time']));
							}else{
								echo "---";
							}		
						  
					   ?>
                    </div>
                    <div class="w15-md grid_td_info word-break-all">
                      <?php 
						   if(!empty($res['trail_end_time'])){
							    echo date("d-m-Y H:i:s",strtotime($res['trail_end_time']));
							}else{
								echo "---";
							}		
						  
					   ?>
                    </div>
                   
                    <div class="w10-md grid_td_info text-lg-center <?php echo $status_msg_cls; ?>">
						<?php echo $status_msg; ?>
                        
                    </div> 
                    <div class="w20-md grid_td_info text-lg-center"> 
                        <span class="<?php echo $extend_msg_cls; ?>"> <?php echo $extend_msg; ?> </span>
						<strong class="approveBtn"><?php if($extend_msg == "Yes"){echo "Approve";}else{echo ""; }?></strong>
						<span id="approvetxtbox" class="hide">
							<!-- <input type="text" name="extendhours" id="extendhours<?php echo $res['rec_id']; ?>" class="form-control" placeholder="Extend Hours"/> -->
							<select class="form-control" name="extendhours" id="extendhours<?php echo $res['rec_id']; ?>">
								<option value="">Select Hours</option>
								<option value="1">1 Hour</option>
								<option value="2">2 Hours</option>
								<option value="3">3 Hours</option>
								
							</select>
							<button class="btnSubmit" data-id="<?php echo $res['rec_id']; ?>" >Go</button>	
						</span>
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
		
		$(".approveBtn").on('click', function(e) {  
			e.preventDefault();
			$("#approvetxtbox").show();
			
		});
		
		
		$('body').on('click', '.btnSubmit', function(){
			var rec_id = $(this).attr("data-id");
			var extend_hours = $("#extendhours"+rec_id).val();
			
			var token = "<?php echo csrf_token() ?>";
			if(extend_hours == ""){
				alert("Please select Extend Hours");
				return false;
			}else{
				
				$.ajax({
					url: "<?php echo url('/');?>/extendFreetrailHours",
					method: 'POST',
					dataType: "json",
					data: {'rec_id': rec_id,'extend_hours': extend_hours,"_token": token},
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) { 
					   if(data.status=='Success'){
							$("#successModel").modal('show');
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
			
		});
		
		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) { 
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
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
        }); 
        
        
        var url = "<?php echo url('/requestedMovies'); ?>";

     
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