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
		.showmore{
			display:block !important;
		}
        .hideShowmore{
			display:none !important;
		}
    </style>
</head>

<body style="overflow-x: hidden">
    <!-- <div class="overlay-bg"></div> -->
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content commission_report_details">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
        <section class="dark_bg scroll_div">

            <!-- Filter -->
            <div class="row filter_wrap mt-4 mb-2">
                <div class="col-md-2">
                    <div class="filter_wrap_country_label">
                        <div>All Channels</div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row filter_wrap_select">
                        <div class="col-md-4">
                            
                        </div>
                        <div class="col-md-4">
                            <div class="filter_wrap_select_country">
                                <select class="filter_wrap_select_country_now" name="state">
                                    <option value="" disabled selected>Select Country</option>
									<option value="">All Countries</option>
									<?php 
										if(!empty($livetv_countryList)){
										if($livetv_countryList["statusCode"]== 200 && $livetv_countryList["status"] =="success"){
											foreach($livetv_countryList["response"]["country_list"]["data"] as $res){
											$country_name = $res["name"];
											$country_code = $res["code"];
									?>
                                    <option value="<?php echo $country_code; ?>"><?php echo $country_name; ?></option>
									<?php } 
										} 
									} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3 filter_wrap_search">
                                <input type="text" class="form-control" placeholder="Search Channel" aria-label="Search Movie" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- India  Movie List -->
            <div class="movie_list" id="india">
				<?php 
					$totalCount=0;
					if($livetv_videos["statusCode"]== 200 && $livetv_videos["status"] =="success"){
						
				?>
                <div class="movie_list_title">
                    <?php 
						echo "INDIA";	
					?>
                </div>

                <div class="movie_list_wrap">
                    <div class="row">
						<?php 
						if(!empty($livetv_videos["response"]["current_live_videos"]["data"])){
							$totalCount = @count($vod_banners_info["response"]["new"]["data"]);
							foreach($livetv_videos["response"]["current_live_videos"]["data"] as $res){?>
							
							<div class="col-12 col-sm-4 col-lg-8r mb-5">
								<a href="<?php echo url('/');?>/livetvChannelView/<?php echo $res['slug'];?>" class="movie_list_wrap_item">
									<img src="<?php echo $res['thumbnail_image'];?>" class="img-fluid">
								</a>
								<div class="text-center movie_list_wrap_item_title"><?php echo $res['title'];?></div>
							</div>
							<?php 
							
							}
						}else{ ?>
							<div class="col movie_list_wrap_it">
								<h1>No Live Tv Channels found</h1>	
							</div>
						<?php } ?>

                        
                        
                    </div>
                </div>
				<div class="row my-1 <?php echo ($totalCount >8) ? 'showmore' : 'hideShowmore' ?>">
                    <div class="divider col-xl-10 col-md-9"></div>
                    <div class="col-xl-2 col-md-3 ">
                        <div class="more_movies float-right">
                            <a href='<?php echo url("/"); ?>/livetvAllChannels/105/'>Show more</a>
                        </div>
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
            movie_list = $(".movie_list_wrap_it").length;
            movie_list = $("#china .movie_list_wrap_it").length;
            console.log(movie_list);
            x = 8;
            $('.movie_list_wrap_it:lt('+x+')').show();
            $('#china .movie_list_wrap_it:lt('+x+')').show();
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
        
        
        var url = "<?php echo url('/getReferralsList'); ?>";

        /*$("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                $("#from_date").val('');
                $("#to_date").val('');
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey+'&from_date=&to_date=&page=0';
            }
        });*/
        
        
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