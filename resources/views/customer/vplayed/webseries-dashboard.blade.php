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
		 .showmore{
			display:block;
		}
        .hideShowmore{
			display:none;
		}	
	</style>
    <script src="<?php echo url('/');?>/public/vplayed/js/play.js"></script> 
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
		<!-- Header Section End Here -->
        <section class="dark_bg scroll_div">

            <!-- Filter -->
            <div class="row filter_wrap mt-4 mb-2">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="filter_wrap_select">
                        <div class="input-group mb-3 filter_wrap_search">
                            <input type="text" id="searchmovie" class="form-control vodBtnsearch"  placeholder="Search Web Series" aria-label="Search Web Series" aria-describedby="button-addon2" value="<?php echo ($searchKey)?$searchKey:""; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary vodBtn" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php if(empty($searchKey)){?>
			<!-- new series start -->
			<div class="movie_list">
			<div class="movie_list_wrap">
                    <div class="clearfix">
						<?php 
							if(!empty($webseries)){	
								if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
									$current_page = $webseries["response"]["new"]["current_page"];
									$totalWebSeries = @count($webseries["response"]["new"]["data"]);
									if(@count($webseries["response"]["new"]["data"]) > 0){ 
									$episodes_data = $webseries["response"]["new"]['episodes'];
									$category_name = $webseries["response"]["new"]['category_name'];

										
						?>
						<div class="movie_list_title">
							 <?php echo $category_name;	?>
						</div>	
						<div class="row-flex vodmore_list">
						<?php 
							foreach($webseries["response"]["new"]["data"] as $res){
								$webseries_title = $res["title"];
								$webseries_slug = $res["slug"];
								$episode_count = 0;
								if(!empty($episodes_data) && @count($episodes_data)){
									foreach($episodes_data as $item) {
										if($item['slug'] == $res["slug"]) $episode_count = $item['episode_count'];
									}
								}
								if(!empty($res["thumbnail_image"])){
									$thumbnail_img = $res["thumbnail_image"];
								}else{
									$thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
								}
											
						?>
						  
							<div class="mb-5 movie_list_wrap_filter ">
								<div class="movie_list_wrap_filter_wrap">
									<a href="<?php echo url('/');?>/webseriesDetailsList/<?php echo $webseries_slug; ?>" class="movie_list_wrap_item">
										<img src="<?php echo $thumbnail_img; ?>" class="img-fluid">
									</a>
									<div class="movie_list_wrap_item_title_wrap w-100">
										<div class="text-center movie_list_wrap_item_title mt-0"><?php echo $webseries_title; ?></div>
										<div class="text-center f12 color-white mt-1"><?php echo $episode_count;?> Episode<?php echo ($episode_count>1) ? 's': '';?></div>
									</div>
								</div>
							</div>
						<?php 
										
							} 
										
						?>
						</div>		
							
							<?php }else{ ?>

										<div class="col-12">
											<div class="no-record-wrp1">
												<div class="no-record-wrp2">
													<h1>Not Found New Web Series</h2>
												</div>
											</div>
										</div>
									<?php 
										}
									} 
								} 
							?>

                    </div>
                </div>
            </div>
			<!-- new series ends -->

			<!-- popular series list starts -->
			<!--<div class="movie_list">
			<div class="movie_list_wrap">
                    <div class="clearfix">
						<?php 
							if(!empty($webseries)){	
								if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
									$current_page = $webseries["response"]["popular"]["current_page"];
									$totalWebSeries = @count($webseries["response"]["popular"]["data"]);
									if(@count($webseries["response"]["popular"]["data"]) > 0){ 
									$category_name = $webseries["response"]["popular"]['category_name'];
									
						?>
						<div class="movie_list_title">
							 <?php echo $category_name;	?>
						</div>	
						<div class="row-flex vodmore_list">
						<?php 
							foreach($webseries["response"]["popular"]["data"] as $res){
								$webseries_title = $res["title"];
								$webseries_slug = $res["slug"];
								$episode_count = 0;
								
								if(!empty($res["thumbnail_image"])){
									$thumbnail_img = $res["thumbnail_image"];
								}else{
									$thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
								}
											
						?>
						  
							<div class="mb-5 movie_list_wrap_filter ">
								<div class="movie_list_wrap_filter_wrap">
									<a href="<?php echo url('/');?>/webseriesEpisodeView/<?php echo $webseries_slug; ?>" class="movie_list_wrap_item">
										<img src="<?php echo $thumbnail_img; ?>" class="img-fluid">
									</a>
									<div class="movie_list_wrap_item_title_wrap w-100">
										<div class="text-center movie_list_wrap_item_title mt-0"><?php echo $webseries_title; ?></div>
										
									</div>
								</div>
							</div>
						<?php 
										
							} 
										
						?>
						</div>		
							
							<?php }else{ ?>

										<div class="col-12">
											<div class="no-record-wrp1">
												<div class="no-record-wrp2">
													<h1>Not Found Popular Web Series</h2>
												</div>
											</div>
										</div>
									<?php 
										}
									} 
								} 
							?>

                    </div>
                </div>
            </div>-->
			<!-- popular series list ends -->
			<?php }?>
            <div class="movie_list">

                <div class="movie_list_wrap">
                    <div class="clearfix">
						<?php 
							if(!empty($webseries)){	
								if($webseries["statusCode"]== 200 && $webseries["status"] =="success"){
									$current_page = $webseries["response"]["web_series_detail"]["current_page"];
									$totalWebSeries = @count($webseries["response"]["web_series_detail"]["data"]);
									if(@count($webseries["response"]["web_series_detail"]["data"]) > 0){ 
									$episodes_data = $webseries["response"]["web_series_detail"]['episodes'];
									$category_name = $webseries["response"]["web_series_detail"]['category_name'];
									
										
						?>
						<div class="movie_list_title">
							 <?php 
							 if(!empty($searchKey)) {
							 	echo 'Search Key:'.$searchKey;
							 }else{
							 	echo $category_name;
							 }
							 ?>
						</div>	
						<div class="row-flex vodmore_list">
						<?php 
							foreach($webseries["response"]["web_series_detail"]["data"] as $res){
								$webseries_title = $res["title"];
								$webseries_slug = $res["slug"];
								$episode_count = 0;
								if(!empty($episodes_data) && @count($episodes_data)){
									foreach($episodes_data as $item) {
										if($item['slug'] == $res["slug"]) $episode_count = $item['episode_count'];
									}
								}
								if(!empty($res["thumbnail_image"])){
									$thumbnail_img = $res["thumbnail_image"];
								}else{
									$thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
								}
											
						?>
						  
							<div class="mb-5 movie_list_wrap_filter ">
								<div class="movie_list_wrap_filter_wrap">
									<a href="<?php echo url('/');?>/webseriesDetailsList/<?php echo $webseries_slug; ?>" class="movie_list_wrap_item">
										<img src="<?php echo $thumbnail_img; ?>" class="img-fluid">
									</a>
									<div class="movie_list_wrap_item_title_wrap w-100">
										<div class="text-center movie_list_wrap_item_title mt-0"><?php echo $webseries_title; ?></div>
										<div class="text-center f12 color-white mt-1"><?php echo $episode_count;?> Episode<?php echo ($episode_count>1) ? 's': '';?></div>
									</div>
								</div>
							</div>
						<?php 
										
							} 
										
						?>
						</div>		
							<?php 									
								if($totalWebSeries >0){
									
									$pageno = $current_page+1;
								}else{
									
									$page_no = $current_page-1;
									if($page_no == 0){
										$pageno = 1;
									}else{
										$pageno = $page_no;
									}
								}	
	
							?>
									
									<div class="divider mb-5 <?php if($totalWebSeries >=15){echo "showmore";}else{echo "hideShowmore"; } ?>" id="show-more-div"> 
										<div class="more_movies center_align">
											<input type="hidden" id="page" value="<?php echo $pageno;?>">
											<a href='javascript:void(0);' class="show-more" >Show more</a>
										</div>
									</div>
							<?php }else{ ?>

										<div class="col-12">
											<div class="no-record-wrp1">
												<div class="no-record-wrp2">
													<h1>Not Found Web Series</h2>
												</div>
											</div>
										</div>
									<?php 
										}
									} 
								} 
							?>

                    </div>
                </div>

            </div>
		
        </section>
    </div>



    <!-- All scripts include -->
    @include('inc.scripts.all-scripts')
    <script src="<?php echo url('/');?>/public/vplayed/js/jquery.ddslick.min.js"></script> 
	<script src="<?php echo url('/');?>/public/vplayed/js/dropkick.js" type=""></script> 
    <script type="text/javascript">
		 var url = "<?php echo url('/webserieslist'); ?>";

		 $('.vodBtnsearch').keypress(function(ev){
		    if (ev.which === 13)
		        $('.vodBtn').click();
		});
		 
		 $(".vodBtn").click(function(e){
            e.preventDefault();
            //alert("test");
           
            var searchKey = $(".vodBtnsearch").val().trim();
            
            //var searchUrl = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
			if(searchKey == ""){
				alert('Please Enter Web Series Name');
				return false;
			}else{
				var searchUrl = url+'?searchKey='+searchKey; 
				location.href=searchUrl;
			}
            
            
        });	
	</script>
	    <script type="text/javascript">
    
    $(document).ready(function(){
		// Load more data
		$('.show-more').click(function(){
			var page = Number($('#page').val());
			
			var csrf_Value= "<?php echo csrf_token(); ?>";
			$.ajax({
				url: "<?php echo url('/');?>/webserieslistLoadMore",
				method: 'POST',
				dataType: "json",
				data: {'page': page, "_token": csrf_Value},
				beforeSend:function(){
					$(".show-more").text("Loading...");
				},
				success: function(response){
					setTimeout(function() {
						$('.show-more').text("Show more");
						if(response.status == 'Success'){
							// appending posts after last post with class="post"
							$(".vodmore_list").append(response.result).show().fadeIn("slow");
							$('#page').val(response.page);
							if(response.webSeriesCnt < 15){
								$('#show-more-div').hide();
							}else{
								$('#show-more-div').show();
							}
						}else{
							$(".vodmore_list").append(response.result).show().fadeIn("slow");
							$('#page').val(response.page);
							$('#show-more-div').hide();
						}
						
					}, 1000);
				}
			});
		});
	});
        
        
    </script>
</body>
</html>