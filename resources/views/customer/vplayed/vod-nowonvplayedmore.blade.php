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

            <!-- India  Movie List -->
            <div class="movie_list" id="india">
				<?php 
					
					if($vod_banners_info["statusCode"]== 200 && $vod_banners_info["status"] =="success"){
						
				?>
                <div class="movie_list_title">
                    <?php 
						echo $vod_banners_info["response"]["new"]["category_name"];	
					?>
                </div>
				
                <div class="movie_list_wrap clearfix row-flex vodmore_list">
                    
					<?php 
						$current_page = $vod_banners_info["response"]["new"]["current_page"];
						$totalCount = @count($vod_banners_info["response"]["new"]["data"]);
						if($totalCount > 0 ){
							
							foreach($vod_banners_info["response"]["new"]["data"] as $res){
							
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
						<?php } }else{  ?>
							
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

				<div class="divider mb-5 <?php if($totalCount >15){echo "showmore";}else{echo "hideShowmore"; } ?>" id="show-more-div"> 
					<div class="more_movies center_align">
						  <!-- <a class="loadShowMore" href="<?php //echo url('/');?>/vodOnVplayedMore/<?php //echo $pageno;?>"><?php //echo $showmoreBtntext; ?></a> -->
						  <a href='javascript:void(0);' class="show-more" >Show more</a>
						  <input type="hidden" id="page" value="<?php echo $pageno;?>">
					</div>
				</div>
				
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
            x = 15;
            $('.movie_list_wrap_it:lt('+x+')').show();
            $('#china .movie_list_wrap_it:lt('+x+')').show(); 
			*/
        });
    </script>
    <script type="text/javascript">
    
     $(document).ready(function(){
		// Load more data
		$('.show-more').click(function(){
			var page = Number($('#page').val());
			var country_id = Number($('#country_id').val());
			var csrf_Value= "<?php echo csrf_token(); ?>";
			 
			$.ajax({
				url: "<?php echo url('/');?>/vodOnVplayedShowMoreAjax",
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
        </script>

  
</body>
</html>