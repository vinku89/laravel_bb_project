
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
    <script src="<?php echo url('/');?>/public/vplayed/js/play.js"></script> 
</head>
<body>
    <!-- Side bar include -->
    @include('inc.sidebar.sidebar')
    <div class="main-content customer_pannel">
        <!-- Header Section Start Here -->
        @include('inc.header.header')
        <!-- Header Section End Here -->
		<section class="vod_main_body_section scroll_div">
			
        <!-- VOD Banner Section Here web series details234 -->
		<?php 
			
			if(!empty($webseriesdetails)){	
				if($webseriesdetails["statusCode"]== 200 && $webseriesdetails["status"] =="success"){
					
					if(!empty($webseriesdetails["response"]["webseries_info"])){ 
						
						$webseriesTitle = $webseriesdetails["response"]["webseries_info"]["webseries_detail"]["title"];
						$webseries_slug = $webseriesdetails["response"]["webseries_info"]["webseries_detail"]["slug"];
						$webseries_thumbnail_image = $webseriesdetails["response"]["webseries_info"]["webseries_detail"]["thumbnail_image"];
						$webseries_poster_image = $webseriesdetails["response"]["webseries_info"]["webseries_detail"]["poster_image"];
						if(!empty($webseries_poster_image)){
							$poster_image = $webseries_poster_image;
						}else{
							$poster_image = '';//url('/')."/public/vplayed/images/vod-banner.jpg";
						}
						
						$webseries_description = $webseriesdetails["response"]["webseries_info"]["webseries_detail"]["description"];
						$totalEpisodes = $webseriesdetails["response"]["webseries_info"]["total_episodes"];
						
						//$totalEpisodes = $webseriesdetails["response"]["related"]["total"];
						if(!empty($webseriesdetails["response"]["related"]["data"][0])){
							$season_title = $webseriesdetails["response"]["related"]["data"][0]['season_name'];
							$director =  $webseriesdetails["response"]["related"]["data"][0]["director"];
				            $imdb_rating =  $webseriesdetails["response"]["related"]["data"][0]["imdb_rating"];
				            $releaseYear =  $webseriesdetails["response"]["related"]["data"][0]["releaseYear"];
				            $presenter =  $webseriesdetails["response"]["related"]["data"][0]["presenter"];
						}
						
		?>
            <div class="vod_banerWrp">
            	 <?php if($poster_image !=''){?>
            	 	<img src="<?php echo $poster_image; ?>" class="img-fluid">
            	 <?php }?>
				 
               <div class="vod_bannerContent_wrp">
                    <div class="vod_bannerinner_Content_wrp">
                        <div class="info_wrapper">
                            <div class="movie_info">
                                <h1><?php echo $webseriesTitle; ?></h1>
                                <div class="movie_rating">
                                    <!-- <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i> -->
                                    <ul> 
                                      <li><?php echo $totalEpisodes; ?> Episode<?php echo ($totalEpisodes>1) ? 's': '';?></li>
                                    </ul>
                                    <!-- <span class="hd_tag">HD</span> -->
                                </div>
                            <p class="movie_intro"><?php echo $webseries_description; ?></p>
                            <?php if(!empty($presenter)){?>
			                  <p class="movie_intro">
			                  Starring : <?php echo $presenter; ?>
			                  </p>
			                <?php }?>
			                <?php if(!empty($director)){?>
			                  <p class="movie_intro">
			                  Director : <?php echo $director; ?>
			                  </p>
			                <?php }?>
			                <?php if(!empty($releaseYear)){?>
			                  <p class="movie_intro">
			                  Release Year : <?php echo $releaseYear; ?>
			                  </p>
			                <?php }?>
			                <?php if(!empty($imdb_rating)){?>
			                  <p class="movie_intro">
			                  IMDB Rating : <?php echo $imdb_rating; ?>/10
			                  </p>
			                <?php }?>
                           <!--  <a href="" class="trailer_btn" data-toggle="modal" data-target="#movieTrailer">
                            <i class="fas fa-play-circle"></i>
                            Play Trailer
                            </a> -->
                            </div>
                            <div class="col-md-6 div_margin">
                              <div class="filter_wrap_select_country">
                                <select class="filter_wrap_select_country_now season_filter" name="season" >
                                  <?php 
                                    if(!empty($webseriesdetails["response"]['seasons'])){
                                      foreach ($webseriesdetails["response"]['seasons'] as $season) {?>
                                        <option value="<?php echo $season['id']; ?>" <?php if($season['id'] == $season_id) echo 'selected';?>><?php echo $season['title']. ' ('.$season['season_count'];?>
                                        	<?php echo ($season['season_count']>1) ? 'Episodes': 'Episode';?>)
                                        </option>
                                      <?php
                                      }					
                                    } ?>
                                </select>
                              </div>
                            </div>
                        </div>
                        <!-- VOD Player Section Here -->
			 
                <div class="web_series_section">
                   
					<div class="movie_list">

						<div class="movie_list_wrap">
							<div class="row-flex">
							<?php 
								if(!empty($webseriesdetails["response"]["related"])){
									$current_page = $webseriesdetails["response"]["related"]["current_page"];
									if(!empty($webseriesdetails["response"]["related"]["data"])){
										foreach($webseriesdetails["response"]["related"]["data"] as $res){
											$title = $res["title"];
											$slug = $res["slug"];
											$poster_image = $res["poster_image"];
											
											if(!empty($res["thumbnail_image"])){
												$thumbnail_img = $res["thumbnail_image"];
											}else{
												$thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
											}
											$episode_order = $res["episode_order"];
											$web_description = $res["description"];
											$episode_order = $res["episode_order"];
							?>
								<div class="mb-5 movie_list_wrap_filter">
									<div class="movie_list_wrap_filter_wrap">
										<a href="<?php echo url('/');?>/webseriesEpisodeView/<?php echo $slug; ?>" class="movie_list_wrap_item">
											<img src="<?php echo $thumbnail_img; ?>" class="img-fluid">
										</a>
										<div class="movie_list_wrap_item_title_wrap w-100">
											<div class="text-center movie_list_wrap_item_title mt-0"><?php echo $title;?></div>
											<!--<div class="text-center f12 color-white mt-1"><?php echo $episode_order; ?> Episode</div>--> 
										</div>
									</div>
								</div>
								
							<?php 
										}
									}else{
										echo '<div class="no-record-wrp1">
												<div class="no-record-wrp2">
													<h1>No Episodes Found</h2>
												</div>
											</div>';
									}
								}
								
							?>	

							</div>
						</div>

					</div>
                </div>
                    </div>
               </div>
            </div>
             <!-- END VOD Banner Section  -->

             
			<?php 
				}else{
					echo '<div class="no-record-wrp1">
							<div class="no-record-wrp2">
								<h1>Oops... Something went wrong</h2>
							</div>
						</div>';
				} 
			}else{
				echo '<div class="no-record-wrp1">
							<div class="no-record-wrp2">
								<h1>Oops... Something went wrong</h2>
							</div>
						</div>';
			}
		}else{
			echo '<div class="no-record-wrp1">
							<div class="no-record-wrp2">
								<h1>Oops... Something went wrong</h2>
							</div>
						</div>';
		}
	?>

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
    });

    url = "<?php echo url('/webseriesDetailsList').'/'.$video_slug; ?>";

    $(".season_filter").on('change', function(e) {
			e.preventDefault();
			var season_id = $(this).val();
			location.href = url+'/'+season_id; 
		});
</script>
</body>
</html>