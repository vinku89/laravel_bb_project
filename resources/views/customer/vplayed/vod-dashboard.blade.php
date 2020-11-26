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
		.lessthan8{
			display:block;	
		}
		.greaterthan8{
			display:none !important;
		} 
		.movie_list_wrap_it2 {
			display: inline-table;
			margin-bottom: 50px;
			width: 175px;
			height: auto;
			margin-right: 20px;
			/*float: left;*/
		}
		.movie_list_wrap_item img {
			border-radius: 5px;
			object-fit: fill;
		}
		.movie_list_wrap_it3 {
			display: block;
			margin-bottom: 50px;
			width: 175px;
			height: auto;
			margin-right: 20px;
			float: left;
		}
        .movie_list_wrap_item_title {
			
			font-size: 12px !important;
			
		}
		.showmore{
			display:block !important;
		}
        .hideShowmore{
			display:none !important;
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


                         <div class="col-md-4 ">
                            <div class="filter_wrap_select_category float-right">
                                <select class="filter_wrap_select_category_now vod_cat_filter" name="state">
                                   <option value="">All</option> 
                                   <?php 
									$selectedCategory = ($filterCatName)?$filterCatName:"";
										if(!empty($vod_categories_new)){
											
												foreach($vod_categories_new as $res){
												$cat_title = $res->title;
												$cat_slug = $res->slug;
													if($cat_title != "Web Series"){?>
														<option value="<?php echo $cat_slug; ?>" attr-type="<?php echo $res->type; ?>" <?php if($selectedCategory == $cat_slug) echo 'selected';?>><?php echo $cat_title; ?></option>
											<?php 	} 
												
											} 
										} ?>
                                   
                                </select>
                            </div> 
                        </div>


                        <div class="col-md-4 text-right">
                            <div class="input-group mb-3 filter_wrap_search">
                                <input type="text" class="form-control vodBtnsearch" id="searchKeyVod" placeholder="Search Movie" aria-label="Search Movie" aria-describedby="button-addon2" value="<?php echo ($searchKey)?$searchKey:""; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary vodBtn" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
									<input type="hidden" id="search" value="<?php echo $searchKey;?>">
									<input type="hidden" id="category" value="<?php echo $filterCatName;?>">
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			<?php 
				if(!empty($searchKey))	{?>
					<div class="movie_list filterCate" id="china2">
						<div class="movie_list_title">
							Search : <?php echo $searchKey;	?>
					   </div>
					<?php 
						
						if($vod_search["statusCode"]== 200 && $vod_search["status"] =="success"){
							$vod_count = @count($vod_search["response"]["data"]);
							if($vod_count == 0){?>
								<div class="no-record-wrp1">
									<div class="no-record-wrp2">
										<h1>No Movies Found</h2>
									</div>
								</div>
					<?php   }else{
								foreach($vod_search["response"]["data"] as $movieslist){
									$submovieTitle = $movieslist["title"];
									$submovieslug = $movieslist["slug"];
									if(!empty($movieslist["thumbnail_image"])){
										$substring = 'https://';
										$det_thumbnail_img = $movieslist["thumbnail_image"];
										if(strpos($det_thumbnail_img, $substring) === false){
										 	$url = url('/');
											if($url == 'https://bestbox.net' || $url == 'https://bb3778.com/') {
										 		$urlpath = 'https://prodstore.bb3778.com/bestbox/';
										 	}else if($url == 'https://staging.bestbox.net' || $url == 'https://staging.bb3778.com/') {
										 		$urlpath = 'https://stgstore.bb3778.com/bestbox/';
										 	}else{
										 		$urlpath = '';
										 	}
										   $det_thumbnail_img = $urlpath.$det_thumbnail_img;
										}
									}else{
										$det_thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
									}
									?>
									<div class="movie_list_wrap_it2" >
										<a href="<?php echo url('/');?>/vodDetailView/<?php echo $submovieslug;?>" class="movie_list_wrap_item">
											<img src="<?php echo $det_thumbnail_img; ?>" class="img-fluid">
										</a>
										<div class="text-center movie_list_wrap_item_title"><?php echo $submovieTitle; ?></div>
									</div>
								<?php 
								} 
							} 
						}?>
					</div>
				<?php 
			}else{?>
			<!-- China Movie List -->
				<div class="movie_list filterCate" id="china2" style="padding:0px;">
					<?php 
						
						if($vod_filter_category["statusCode"]== 200 && $vod_filter_category["status"] =="success"){
							$cate_count = @count($vod_filter_category["response"]["main"]);
							if($cate_count > 0){
								$k=1;
								// $vod_filter_category["response"]["main"]  = array();
								foreach($vod_filter_category["response"]["main"] as $catInfo){
									//echo $catInfo["title"];exit;
									$category_name = $catInfo["title"];
									$category_slug = $catInfo["id"];
									$type = $catInfo["type"];
									$category_total_movies = @count($catInfo["video_list"]["data"]);
	
									if($category_total_movies == 0) { 
										if($k==1){
									?>
										<div class="no-record-wrp1">
											<div class="no-record-wrp2">
											<h1>No Movies Found</h2>
											</div>
										</div>
									<?php
										}
										$k++;
									continue;
									}else{?>
							<div class="movie_list_title">
								 <?php echo $category_name;	?>
							</div>
									
							<div class="movie_list_wrap clearfix row-flex">
								
									<?php 
									 
									if($category_total_movies > 0){	 
										$m1=1;

										foreach($catInfo["video_list"]["data"] as $movieslist){
											if($movieslist["video_category_name"] == 'Restricted'){
												continue;
											}
											$submovieTitle = $movieslist["title"];
											$submovieslug = $movieslist["slug"];
											
											if(!empty($movieslist["thumbnail_image"])){
												$det_thumbnail_img = $movieslist["thumbnail_image"];
											}else{
												$det_thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
											}
									?>
									<div class="movie_list_wrap_it2 <?php echo ($m1 <= 8) ? 'd-block' : 'd-none' ?>" >
										<a href="<?php echo url('/');?>/vodDetailView/<?php echo $submovieslug;?>" class="movie_list_wrap_item">
											<img src="<?php echo $det_thumbnail_img; ?>" class="img-fluid">
										</a>
										<div class="text-center movie_list_wrap_item_title"><?php echo $submovieTitle; ?></div>
									</div>
									
									
									<?php 
										$m1++;
										} 
									}else{  
									?>
										<div class="no-record-wrp1">
											<div class="no-record-wrp2">
											<h1>No Movies Found</h2>
											</div>
										</div>
									<?php } ?>
								
							</div>
							
					
							<div class="divider mb-5"> 
								<div class="more_movies <?php if($category_total_movies >8){echo "showmore";}else{echo "hideShowmore"; } ?>">
									<a href="<?php echo url('/');?>/vodCategoryShowmore/<?php echo $type;?>/<?php echo $category_slug; ?>">Show more</a>
								</div>
							</div>
					
							<?php  }  }  } } ?>
					
				</div>
				
				
				<!-- category wise -->
				
				
            <div class="movie_list testeest" id="china3">
				<?php 
				if($vod_category_wise["statusCode"]== 200 && $vod_category_wise["status"] =="success"){
				 
					if(!empty($vod_category_wise["response"]["category_videos"])){

						foreach($vod_category_wise["response"]["category_videos"] as $res){
							$totalCount_movies = @count($res["video_list"]["data"]);
							if($res["title"] == 'Restricted' || $totalCount_movies == 0) {continue;} 
							$category_name = $res["title"];
							$category_slug = $res["slug"];
							$cateInfo = $res["video_list"]["data"];
							$type= 'category';	
								
					?>
                <div class="movie_list_title">
                     <?php echo $category_name;	?>
                </div>
								
						<div class="movie_list_wrap clearfix row-flex">
							
								<?php 
								if(@count($res["video_list"]["data"]) > 0){	
									$gm1=1;
									foreach($res["video_list"]["data"] as $movieslist){
										
										$submovieTitle = $movieslist["title"];
										$submovieslug = $movieslist["slug"];
										if(!empty($movieslist["thumbnail_image"])){
											$det_thumbnail_img = $movieslist["thumbnail_image"];
										}else{
											$det_thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
										}
								?>
								<div class="movie_list_wrap_it3 <?php echo ($gm1 <= 8) ? 'd-block' : 'd-none' ?>">
									<a href="<?php echo url('/');?>/vodDetailView/<?php echo $submovieslug;?>" class="movie_list_wrap_item">
										<img src="<?php echo $det_thumbnail_img; ?>" class="img-fluid">
									</a>
									<div class="text-center movie_list_wrap_item_title"><?php echo $submovieTitle; ?></div>
								</div>
								
								
								<?php 
									$gm1++;
									} 
								}else{  
								?>
									<div class="no-record-wrp1">
										<div class="no-record-wrp2">
										<h1>No Movies Found</h2>
										</div>
									</div>
								<?php }?>
							
						</div>
				
				
				<div class="divider mb-5"> 
					<div class="more_movies <?php if($totalCount_movies >8){echo "showmore";}else{echo "hideShowmore"; } ?>">
						<a href="<?php echo url('/');?>/vodCategoryShowmore/<?php echo $type;?>/<?php echo $category_slug; ?>">Show more</a>
					</div>
				</div>
				
				<?php 
						} 
					}
					
					if(!empty($vod_category_wise["response"]["genre_videos"])){
						foreach($vod_category_wise["response"]["genre_videos"] as $res2){
							$genre_videos_name = $res2["name"];
							$genre_videos_slug = $res2["slug"];
							$totalCount_movies2 = @count($res2["video_list"]["data"]);
							$type= 'genre';
							if($totalCount_movies2 == 0) {continue;} 
							
				?>
							<div class="movie_list_title">
								 <?php echo $genre_videos_name;	?>
							</div>
							<div class="movie_list_wrap clearfix row-flex">
								<?php 
								if(@count($res2["video_list"]["data"]) > 0){	
									$gm1 =1;	
									foreach($res2["video_list"]["data"] as $movieslist){
										$submovieTitle = $movieslist["title"];
										$submovieslug = $movieslist["slug"];
										if(!empty($movieslist["thumbnail_image"])){
											$det_thumbnail_img = $movieslist["thumbnail_image"];
										}else{
											$det_thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
										}
								?>
								<div class="movie_list_wrap_it3 <?php echo ($gm1 <= 8) ? 'd-block' : 'd-none' ?>">
									<a href="<?php echo url('/');?>/vodDetailView/<?php echo $submovieslug;?>" class="movie_list_wrap_item">
										<img src="<?php echo $det_thumbnail_img; ?>" class="img-fluid">
									</a>
									<div class="text-center movie_list_wrap_item_title"><?php echo $submovieTitle; ?></div>
								</div>
								
								<?php 
									$gm1++;
									} 
								}else{  
								?>
									<!-- <div class="no-record-wrp1"> 
										<div class="no-record-wrp2">
										<h1>No Movies Found</h2>
										</div>
									</div> -->
								<?php }?>
								
							</div>
								
							<div class="divider mb-5"> 
								<div class="more_movies <?php if($totalCount_movies2 >8){echo "showmore";}else{echo "hideShowmore"; } ?>">
									<a href="<?php echo url('/');?>/vodCategoryShowmore/<?php echo $type;?>/<?php echo $genre_videos_slug; ?>">Show more</a>
								</div>
							</div>
				<?php 
						} 
					} 
				}
				?>
				
			</div>
		<?php }?>
				
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
			var selectedCategory = "<?php echo $filterCatName; ?>";
			//$('.filter_wrap_select_category_now').select2().select2('val', selectedCategory)
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            movie_list = $(".movie_list_wrap_it").length;
            movie_list = $("#china .movie_list_wrap_it").length;
            console.log(movie_list);
            x = 8;
            $('.movie_list_wrap_it:lt('+x+')').show();
            $('#china .movie_list_wrap_it:lt('+x+')').show();
			
			
			movie_list2 = $(".movie_list_wrap_it2").length;
            movie_list2 = $("#china2 .movie_list_wrap_it2").length;
            
            y= 8;
            $('.movie_list_wrap_it2:lt('+y+')').show();
            $('#china2 .movie_list_wrap_it2:lt('+y+')').show();
			
			movie_list3 = $(".movie_list_wrap_it3").length;
            movie_list3 = $("#china3 .movie_list_wrap_it3").length;
            
            y= 8;
            $('.movie_list_wrap_it3:lt('+y+')').show();
            $('#china3 .movie_list_wrap_it3:lt('+y+')').show();
			
        });
    </script>
    <script type="text/javascript">
    	var url = "<?php echo url('/vodlist'); ?>";

     	 /* filter data */
        $("#filter_data").click(function(e){
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
        });

        $('#searchKeyVod').keypress(function(ev){
		    if (ev.which === 13)
		        $('.vodBtn').click();
		});

      
        $(".vodBtn").click(function(e){
            e.preventDefault();
            //alert("test");
            var filterCat = $("#category").val().trim();
            var searchKey = $("#searchKeyVod").val().trim();
            
            //var searchUrl = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
			
			var searchUrl = url+'?filterCatName='+filterCat+'&searchKey='+searchKey; 
			location.href=searchUrl;
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

	
			if(category_slug == ""){
				alert('Please select category');
				return false;
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
          	//var url = "<?php echo url('/vodlist'); ?>";
//var searchUrl = url+'?filterCatName=restricted'; 
location.href= '<?php echo url('/');?>/vodCategoryShowmore/category/restricted';
				//location.href=searchUrl;
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