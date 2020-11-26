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
	  .banner-img{
		width:50%;
		height:50%;
		display:block;
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
          <h5 class="font16 black_txt font-bold text-uppercase1 pt-4 pb-3">APP Usage Details</h5>

          <div class=""> 
			  <div class="col-12">
					 @include("versions_list.commonTabs")
				
			  </div>
               
		  		
				
		</div>		
		


        <div class="col-12">
			<div class="row">
				<div class="col-sm-6 order-2 order-sm-1 ">
					
				</div>
				<div class="col-sm-6 order-2 order-sm-1 ">
					<div class="text-right">
							<a href="#" class="big_blue_btn" data-toggle="modal" data-target="#addNewUser">Add Image</a>
					</div>
						
				</div>
			</div>
             <div class="middle_box clearfix">
            <div class="grid_wrp add-user-grid">
              <div class="grid_header clearfix pt-3 pb-3 d-lg-block d-none">
				<!-- <div class="w5 float-left font16 font-bold blue_txt pl-2"><input type="checkbox" id="select_all" class="checkall" style="height:20px;"/>All</div> -->
				<div class="w25 float-left font16 font-bold blue_txt pl-2">Title</div>
                <div class="w30 float-left font16 font-bold blue_txt pl-2">Thumbnail</div>
                <div class="w35 float-left font16 font-bold blue_txt pl-2">Link</div>
                <div class="w10 float-left font16 font-bold blue_txt pl-2 text-lg-center">Action</div>
              </div>
              <div class="grid_body clearfix">
                <!--Row 1-->
                <?php
                $i=1;
				if(@count($moviesImages) >0 ){
                  foreach($moviesImages as $au){

                ?>
                <div class="grid_row clearfix border-top">
					<!-- <div class="w5 grid_td_info ">
						<span class="mob_title blue_txt d-block d-lg-none">&nbsp;</span>
                       <input type="checkbox" id="" class="chkbox" value="<?php //echo $au['rec_id']; ?>" style="height:20px;"/>
                    </div> -->
                    <div class="w25 grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">Title</span>
                        <?php echo $au['title'];?> 
                    </div>
                    <div class="w30 grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">Thumbnail</span>
						<?php 
							$image_path = url('/')."/public/recent_movies_images/".$au['movie_image'];	
						?>
						<img src="<?php echo $image_path;?>" alt="<?php echo $au['movie_image'];?>" class="banner-img" />
                        <!-- <div><?php //echo $au['movie_image'];?></div> -->
                    </div>
					
                    <div class="w35 grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">Movie Link</span>
                         <?php 
							if(!empty($au['movie_link'])){
								echo $au['movie_link'];
							}else{
								echo "---";
							}
							  
						?>
                    </div>
                   
                  
                    <div class="w10 grid_td_info text-lg-right"> 
                        <span class="mob_title blue_txt d-block d-lg-none">Action</span>
						<button type="submit" class="sendFCM delImage"  data-id="<?php echo $au['rec_id']; ?>" >Delete</button>
                       
                        
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
		  <?php if(@count($moviesImages) >0 ){ ?>
			<div class="pagi">
				<?php echo $moviesImages->links();?>
			</div>	
		  <?php } ?>
        </div>
			
        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
	    <!-- Add New User end -->
	
	 <!-- Add New Image -->
    <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-border">
                    <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">Add New Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-4">
                    <form id="addPackage" name="addPackage" method="post" enctype="multipart/form-data">
                        <!-- Image Name -->
                        <div class="form-group">
                            <input type="text" name="title" class="form-control border-bottom-only" id="title"
                                aria-describedby="emailHelp" placeholder="Name">
                            <div class="text-right f14">
							<span id="packageNameerror" class="text-left error"></span>
							<span class="text-danger text-right">*</span>
							<span id="" class="text-muted f14 black_txt text-right">Image Name</span>
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
								<span id="amounterror" class="text-left error"></span>
								<span class="text-danger">*</span>
								<span id="" class="text-muted f14 black_txt">Image</span>
							</div>
							 <div class="text-right f14">
								<select  class="form-control border-bottom-only font-bold onkeyEffectiveAmt"  id="cat_list" name="cat_list" class="cat_list">
									<option value="Live">Live</option>
									<option value="Movies">Movies</option>
									<option value="Series">Series</option>
								</select>
								<span class="text-danger">*</span>
								<span id="" class="text-muted f14 black_txt">Select Category</span>
							</div>
                        </div>
						
						<!-- Actual Package Value -->
                        <div class="form-group">
                            <input type="text" name="movie_link" class="form-control border-bottom-only font-bold onkeyEffectiveAmt" id="movie_link"
                                aria-describedby="emailHelp" placeholder="Link"  />
                            <div class="text-right f14">
							<span id="amounterror1" class="text-left error"></span>
							<span class="text-danger"></span>
							<span id="" class="text-muted f14 black_txt">Movie Link</span>
							</div>
                        </div>
						
						
						
                    </form>
                </div>
                <!-- footer buttons -->
                <div class="inline-buttons">
                    <button type="button" class="btn inline-buttons-left cancel-btn"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn inline-buttons-right create-btn" id="addPackageBtn">Add</button>
                </div>
            </div>
        </div>
    </div>
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
			
			$('#deleteToAll' ).click(function() {
				var chkArray = [];
				$(".chkbox:checked").each(function() {
					chkArray.push($(this).val());
				});
				
				var moviesselected;
				moviesselected = chkArray.join(',');
				//alert(moviesselected);
				//return false;
				if(moviesselected.length > 0){
					
					var action = "multipleImage";
					deleteMovieImages(moviesselected,action);
					
				}else{
					alert("Please select atleast one checkbox");
					return false;
				}
				
				
			});
        }); 
	</script>
	<script type="text/javascript" nonce="32432jlkfsdaf">
		$('body').on('click', '.sendFCM', function(){
			var id = $(this).attr("data-id");
			var action = "singleImage";
			deleteMovieImages(id,action);
		});
		function deleteMovieImages(id,action){
			var currentRecId = id;
			var token = "<?php echo csrf_token() ?>";
			$.ajax({
				url: "<?php echo url('/');?>/deleteMovieStatus",
				method: 'POST',
				dataType: "json",
				data: {'rec_ids': currentRecId,'action': action,"_token": token},
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
		}
		
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
        
        
			// Add package 
		$('#addPackageBtn').on('click', function(e)  { 
			
			e.preventDefault();
			
			var error = false;
			var token = "<?php echo csrf_token() ?>";
			var reg_url  = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/;
			
			var currentDivID = $(this).attr('data-id');
			
			var title = $('#title').val();
			var uploads = $('#uploads').val();
			var movie_link = $('#movie_link').val();
			var cat_list = $('.cat_list').val();
			
			if (title == "") {
				$('#packageNameerror').html("Please Enter Title");
				error = true;
			}else {
				$('#packageNameerror').html("");
			}
			if (uploads == "") {
				$('#amounterror').html("Please Upload Movie Image");
				error = true;
			}else {
				$('#amounterror').html("");
			}
			
			
			if(!error){
				var savePackageform = new FormData($("#addPackage")[0]);
				
				savePackageform.append('action', 'add');
				savePackageform.append('_token', token);
				$.ajax({
					url: "<?php echo url('/');?>/addNewMovieImage",
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
		
		
		
    </script>

</body>
</html>