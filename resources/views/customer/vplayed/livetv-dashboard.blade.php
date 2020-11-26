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
		.movie_list_wrap_it{
			display:block !important;
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
                	<?php if(!empty($country_name)){?>
	                    <div class="filter_wrap_country_label">
	                        <div><?php echo $country_name;?></div>
	                    </div>
                	<?php }?>
                </div>
                <div class="col-md-10">
                    <div class="row filter_wrap_select">
                        <div class="col-md-4">
                            
                        </div>
                        <div class="col-md-4">
                            <div class="filter_wrap_select_country float-right">
                                <select class="filter_wrap_select_country_now country_filter" name="state" >
                                    <option value="">All Channels</option>
                                    <?php 
										if(!empty($livetv_countryList_new)){
											foreach ($livetv_countryList_new as $key => $value) {
											?>

											 <option
											  value="<?php echo $value->country_id . '@' .  $value->country_name; ?>" <?php if($country_id == $value->country_id) echo 'selected';?>><?php echo $value->country_name; ?>(<?php echo $value->counts; ?>)</option>



<?php
					}					} ?>
                                </select>
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

<input type="hidden" name="new_id" value="" class="new_id">

                       <!-- 		<div class="col-md-4 ">
                            <div class="filter_wrap_select_country">
                                <select class="filter_wrap_select_country_now country_filter" name="state" >
                                    <option value="">Select Country</option>
                                    <?php 
										if(!empty($livetv_countryList)){
										if($livetv_countryList["statusCode"]== 200 && $livetv_countryList["status"] =="success"){
											foreach($livetv_countryList["response"]["country_list"] as $res){
											$country_name = $res["name"];
											$country_code = $res["id"];
									?>
                                    <option value="<?php echo $country_code; ?>" <?php if($country_id == $country_code) echo 'selected';?>><?php echo $country_name; ?></option>
									<?php } 
										} 
									} ?>
                                </select>
                            </div>
                        </div>	  -->

                        <div class="col-md-4">
                            <div class="input-group mb-3 filter_wrap_search">
                                <input type="text" class="form-control Btnsearch" id="searchKey" placeholder="Search Channel" aria-label="Search Movie" aria-describedby="button-addon2" value="<?php echo (isset($searchKey))?$searchKey:""; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary search_btn" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>						

            <!-- India  Movie List -->
            <div class="movie_list mb-5" id="india">
                
				<div class="movie_list_wrap clearfix row-flex channel_list">
                    
					<?php 
						if(!empty($livetv_videos)){
							foreach($livetv_videos as $res){
								if(!empty($res["thumbnail_image"])){
									$thumbnail_img = $res["thumbnail_image"];
								}else{
									$thumbnail_img = url('/')."/public/vplayed/images/default-thumbnail.png";
								}
									?>
								<div class="movie_list_wrap_it">
									<a href="<?php echo url('/');?>/livetvChannelView/<?php echo $res['slug'];?>" class="movie_list_wrap_item">
										<img src="<?php echo $thumbnail_img;?>" class="img-fluid">
									</a>
									<div class="text-center movie_list_wrap_item_title"><?php echo $res['title'];?></div>
								</div>
					<?php	}
							
						 }else{ ?>
							<div class="no-record-wrp1">
								<div class="no-record-wrp2">
								<h1>No Channels Found</h2>
								</div>
							</div>
						<?php }?>
					
                </div>
				
          		<div class="divider mt50 mb-5 <?php echo ($total_records < 27) ? 'd-none': '';?>" id="show-more-div">
					<div class="more_movies center_align float-right" >
						<a href='javascript:void(0);' class="show-more">Show more</a>
					</div>
				</div>
               <input type="hidden" id="searchKey" value="<?php echo $searchKey;?>">
				<input type="hidden" id="page" value="<?php echo $page;?>">
				<input type="hidden" id="country_id" value="<?php echo $country_id;?>">
				
            </div>

        </section>
    </div>
    <!-- All scripts include -->
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
	    url = "<?php echo url('/livetvlist'); ?>";
        /*$(document).ready(function () {
            movie_list = $(".movie_list_wrap_it").length;
            movie_list = $("#china .movie_list_wrap_it").length;
            console.log(movie_list);
            x = 8;
            $('.movie_list_wrap_it:lt('+x+')').show();
            $('#china .movie_list_wrap_it:lt('+x+')').show();
        });*/
		
		$(".country_filter").on('change', function(e) {
			e.preventDefault();
			
			var country_id = $(this).val();
			// var mode = $(this).attr('mode');
			console.log(country_id);
			var a = country_id.split('@');
			// console.log(a[0]);
			// console.log(a[1]);
			// return false;



							if(a[1]== 'For Adults'){
					$('.new_id').val(a[0]);
					 $('#basicModal').modal({
        show: true
    }); 

						return false;

				}



			location.href = url+'/1/'+a[0]; 
			
			
		});
    </script>
	
	<script>
	$(document).ready(function(){
		// Load more data
		$('.show-more').click(function(){
			var page = Number($('#page').val());
			var country_id = Number($('#country_id').val());
			var searchKey = $('#searchKey').val();
			var csrf_Value= "<?php echo csrf_token(); ?>";
			$.ajax({
				url: "<?php echo url('/');?>/livetvChannelsLoadmore",
				method: 'POST',
				dataType: "json",
				data: {'page': page, 'country_id' : country_id, 'category_id' : '', 'searchKey' : searchKey, "_token": csrf_Value},
				beforeSend:function(){
					$(".show-more").text("Loading...");
					$("#show-more-div").children().prop('disabled',true);
				},
				success: function(response){
					$("#show-more-div").children().prop('disabled',false);
					setTimeout(function() {
						$('.show-more').text("Show more");
						if(response.status == 'Success'){
							$(".channel_list").append(response.result).show().fadeIn("slow");
							$('#page').val(response.page);	
							if(response.class == 'd-none'){
								$('#show-more-div').hide();
							}
						}else{
							$('#show-more-div').hide();
						}
						
					}, 1000);
				}
			});
		});
	});

	$('#searchKey').keypress(function(ev){
		if (ev.which === 13)
		    $('.search_btn').click();
		});
	
	$(".search_btn").click(function(e){
		e.preventDefault();
		var searchKey = $("#searchKey").val();
		var country_id = Number($('#country_id').val());
		
		var searchUrl = url+'/1/'+country_id+'/'+searchKey; 
		location.href=searchUrl;
		
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
          	var url = "<?php echo url('/vodlist'); ?>";
// var searchUrl = url+'?filterCatName=adult-1'; 
// 				location.href=searchUrl;
	    url = "<?php echo url('/livetvlist'); ?>";
	    var a = $('.new_id').val();
			location.href = url+'/1/' + a; 

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