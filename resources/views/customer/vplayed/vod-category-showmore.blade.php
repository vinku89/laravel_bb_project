<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include('customer.inc.all-styles')
	 <link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vdplay.css">

	<link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/vod.css">
	<link rel="stylesheet" href="<?php echo url('/');?>/public/vplayed/css/player.css">
    <style>
        .movie_list_wrap_item_title {
			
			font-size: 12px !important;
			
		}
		.movie_list_wrap_it{display:block !important;} 
        .showmore{
			display:block;
		}
        .hideShowmore{
			display:none;
		}
    </style>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
         <!-- Header Section End Here -->
        <section class="dark_bg scroll_div">

          <!-- Filter -->
		 <div class="row filter_wrap mt-4 mb-2">
		 	<div class="col-md-2">
            </div> 
			<div class="col-md-10">
				<div class="row filter_wrap_select">
					<div class="col-md-4">
            		</div> 
					<div class="col-md-4 ">
                            <div class="filter_wrap_select_category float-right">
                                <select class="filter_wrap_select_category_now vod_cat_filter" name="state">
                                   <option value="">All</option> 
                                   <?php 
											if(!empty($vod_categories_new)){
												foreach($vod_categories_new as $res){
												$cat_title = $res->title;
												$cat_slug = $res->slug;
													if($cat_title != "Web Series"){?>
														<option value="<?php echo $cat_slug; ?>" attr-type="<?php echo $res->type; ?>" <?php if($category == $cat_slug) echo 'selected';?>><?php echo $cat_title; ?></option>
											<?php 	} 
												
											} 
										} ?>
                                   
                                </select>
                            </div> 
                        </div>
					<div class="col-md-4 text-right">
						<div class="input-group mb-3 filter_wrap_search">
							<input type="text" class="form-control vodBtnsearch" id="searchKey" placeholder="Search Movie" aria-label="Search Movie" aria-describedby="button-addon2" value="<?php echo ($searchKey)?$searchKey:""; ?>">
							<div class="input-group-append">
								<button class="btn btn-outline-secondary vodBtn" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
								<input type="hidden" id="search" value="<?php echo $searchKey;?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



                        <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      	<div class="text-center w-100">
      		<img src="https://bestbox.net/public/website/assets/images/bestbox_logo_nav.png" class="img-fluid">
      	</div>
      </div>
      <div class="modal-body">
       <p class="modalTitle">Enter your password</p>
       <div class="pl-3 pr-3">
       		<input type="" name="otp_code"  class="form-control otp_code">
       		<div class="f-12 text-red pt-2 otp_msg" style="display: none">Wrong Password</div>
       		<div class="f-12 text-red pt-2 otp_msg_no" style="display: none">Wrong Password</div>
       </div>
       
      </div>
      <div class="modal-footer border-top-0 p-0 mt-4">
      	<div class="col-12 pl-0 pr-0">
		<div class="row">
            <div class="col-6 pr-0">
                <a href="" class="modalFooter_btn modalFooter_btn_cancel" data-dismiss="modal">Cancel</a>
            </div>
            <div class="col-6 pl-0">
            	<!--  <a href="" class="modalFooter_btn modalFooter_btn_proceed  check_otp" data-dismiss="modal">Proceed</a> -->

                  <p style="cursor: pointer" class="mb-0 modalFooter_btn modalFooter_btn_proceed check_otp">Proceed</p>
            </div>
        </div>
     </div>

      </div>
    </div>
  </div>
</div>


            <!-- India  Movie List -->
            <div class="movie_list" id="india">
            	<div class="movie_list_title">
					<?php 
						if($vod_cat_more["statusCode"]== 200 && $vod_cat_more["status"] =="success"){
							echo $vod_cat_more["response"]["more_category_videos"]["title"];
						}	
					?>
				</div>
				<?php 
					
					if($vod_cat_more["statusCode"]== 200 && $vod_cat_more["status"] =="success"){
						
				?>
               			
                <div class="movie_list_wrap clearfix row-flex vodmore_list">
                    
					<?php 
						$cate_name = $vod_cat_more["response"]["more_category_videos"]["title"];
						$current_page = $vod_cat_more["response"]["more_category_videos"]["video_list"]["current_page"];
						$totalCount = @count($vod_cat_more["response"]["more_category_videos"]["video_list"]["data"]);
						$total_records = $vod_cat_more["response"]["more_category_videos"]["video_list"]['total'];
						$page = $vod_cat_more["response"]["more_category_videos"]["video_list"]['current_page'];
						$perpage = $vod_cat_more["response"]["more_category_videos"]["video_list"]['to'];
						$records = $perpage*$page;
						if($totalCount > 0){
							
							foreach($vod_cat_more["response"]["more_category_videos"]["video_list"]["data"] as $res){
							
							$short_name = $res["slug"];
							if(!empty($res["thumbnail_image"])){
								$thumbnail_img = $res["thumbnail_image"];
							}else{
								$thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
							}
					?>
                        <div class="movie_list_wrap_it">
                            <a href="<?php echo url('/');?>/vodDetailView/<?php echo $short_name;?>" class="movie_list_wrap_item">
                                <img src="<?php echo $thumbnail_img; ?>" class="img-fluid">
                            </a>
                            <div class="text-center movie_list_wrap_item_title"><?php echo $res["title"]; ?></div>
                        </div>
						<?php } }else{ ?>
							<div class="no-record-wrp1">
								<div class="no-record-wrp2">
									<h1>No Movies Found</h2>
								</div>
							</div>
						<?php } ?>
                     
                </div>
				<?php 
					if($totalCount >0){
						$showmoreBtntext="Show more";
						$pageno = $current_page+1;
					}else{
						$showmoreBtntext="Back";
						$page_no = $current_page-1;
						if($page_no == 0){
							$pageno = 1;
						}else{
							$pageno = $page_no;
						}
					}	
					
				?>

				<div class="divider mt50 mb-5 <?php echo ($records < $total_records) ? '': 'd-none';?>" id="show-more-div">
					<div class="more_movies center_align float-right" >
						<a href='javascript:void(0);' class="show-more">Show more</a>
					</div>
				</div>
				<input type="hidden" id="type" value="<?php echo $type;?>">
				<input type="hidden" id="page" value="<?php echo $pageno;?>">
				<input type="hidden" id="category" value="<?php echo $category;?>">

				<?php } ?>
            </div>

          

        </section>
    </div>


    <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
	<script src="<?php echo url('/');?>/public/vplayed/js/jquery.ddslick.min.js"></script> 
	<script src="<?php echo url('/');?>/public/vplayed/js/dropkick.js" type=""></script> 
     <script type="text/javascript">
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.filter_wrap_select_country_now').select2();
            $('.filter_wrap_select_category_now').select2();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
           /* movie_list = $(".movie_list_wrap_it").length;
            movie_list = $("#china .movie_list_wrap_it").length;
            console.log(movie_list);
            x = 8;
            $('.movie_list_wrap_it:lt('+x+')').show();
            $('#china .movie_list_wrap_it:lt('+x+')').show();
			*/
        });
    </script>
    <script type="text/javascript">
    
    $(document).ready(function(){
    	//$('#show-more-div').hide();
		// Load more data
		$('.show-more').click(function(){
			var page = Number($('#page').val());
			var category = $('#category').val();
			var type = $('#type').val();
			var csrf_Value= "<?php echo csrf_token(); ?>";
			$.ajax({
				url: "<?php echo url('/');?>/vodCategoryShowmoreAjax",
				method: 'POST',
				dataType: "json",
				data: {'page': page,'type': type,'category': category, "_token": csrf_Value},
				beforeSend:function(){
					$(".show-more").text("Loading...");
					$("#show-more-div").children().prop('disabled',true);
				},
				success: function(response){
					setTimeout(function() {
						$('.show-more').text("Show more");
						if(response.status == 'Success'){
							// appending posts after last post with class="post"
							$(".vodmore_list").append(response.result).show().fadeIn("slow");
							if(response.class == 'd-none'){
								$('#show-more-div').hide();
							}
							$('#page').val(response.page);	
						}else{
							$(".vodmore_list").append(response.result).show().fadeIn("slow");
							$('#page').val(response.page);
							$('#show-more-div').hide();
						}
						
					}, 1000);
				}
			});
		});

		$('#searchKey').keypress(function(ev){
		    if (ev.which === 13)
		        $('.vodBtn').click();
		});

		$(".vodBtn").click(function(e){
            e.preventDefault();
            $('#show-more-div').show();
            var searchKey = $("#searchKey").val().trim();
            if(searchKey == ""){
				alert('Please Enter Search key');
				return false;
			}else{
				$('#page').val(1);
				var page = Number($('#page').val());
				var category = $('#category').val();
				var type = $('#type').val();
				var csrf_Value= "<?php echo csrf_token(); ?>";
				$.ajax({
					url: "<?php echo url('/');?>/vodCategoryShowmoreAjax",
					method: 'POST',
					dataType: "json",
					data: {'page': page,'type': type,'category': category, 'search' : searchKey, "_token": csrf_Value},
					beforeSend:function(){
						$('#show-more-div').hide();
						$(".vodmore_list").html('');
						//$(".show-more").text("Loading...");
						$("#show-more-div").children().prop('disabled',true);
					},
					success: function(response){
						setTimeout(function() {
							$('.show-more').text("Show more");
							if(response.status == 'Success'){
								// appending posts after last post with class="post"
								$(".vodmore_list").html(response.result).show().fadeIn("slow");
								if(response.class == 'd-none'){
									$('#show-more-div').hide();
								}else{
									$('#show-more-div').show();
								}
								$('#page').val(response.page);	
							}else{
								$(".vodmore_list").html(response.result).show().fadeIn("slow");
								$('#page').val(response.page);
								$('#show-more-div').hide();
							}
							
						}, 1000);
					}
				});
			}
            
            
        });
	});
        
     $(".vod_cat_filter").on('change', function(e) {
		e.preventDefault();
		var category_slug = $(this).val();
		var type = $(".vod_cat_filter option:selected").attr("attr-type");
		if(category_slug == 'restricted'){
			$('#basicModal').modal({
            show: true
    		}); 
			return false;
		}
		var category = $('#category').val();
		if(category_slug == ""){
			location.href= '<?php echo url('/');?>/vodlist';
		}else{
			location.href= '<?php echo url('/');?>/vodCategoryShowmore/'+type+'/'+category_slug;
		}
	});   
    </script>
    
    <script>
            $(document).ready(function() {
                $(".set > a").on("click", function() {
                    if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                    $(this)
                        .siblings(".content")
                        .slideUp(200);
                    $(".set > a i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    } else {
                    $(".set > a i")
                        .removeClass("fa-angle-up")
                        .addClass("fa-angle-down");
                    $(this)
                        .find("i")
                        .removeClass("fa-angle-down")
                        .addClass("fa-angle-up");
                    $(".set > a").removeClass("active");
                    $(this).addClass("active");
                    $(".content").slideUp(200);
                    $(this)
                        .siblings(".content")
                        .slideDown(200);
                    }
                });
            });


            $('.check_otp').click(function(){
				var otp_code =$.trim($('.otp_code').val());
				if(!otp_code){

					$('.otp_msg_no').show();
				}else{
					$('.otp_msg_no').hide();
					 data2 = 'otp_code='+ otp_code

					 $('.otp_msg').hide();
					var url = '<?php echo url('/').'/check_otp';?>';
				         $.ajax({
				        type: "GET",
				        url: url,
				        data: data2, 
				        success: function (data) {
				          if (data == 'success') {
				          	location.href= '<?php echo url('/');?>/vodCategoryShowmore/category/restricted';
						  } else {
				          	$('.otp_msg').show();
				          }
				        }
				      });
				}
				});


        </script>

  
</body>
</html>