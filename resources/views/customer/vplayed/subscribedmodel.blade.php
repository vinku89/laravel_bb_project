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
        .pkgmodel{
			padding:100px 0px;
			background:white;
			border:1px solid #ccc;
			width:100%;
			min-height:500px;
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

            <div class="row filter_wrap mt-4 mb-2">
				<div class="pkgmodel text-center">
					<h2><?php echo $package_msg; ?></h2><br/>
					<div class="amount_wrp px-2 py-0">
						<a href="<?php echo url('/'); ?>/dashboard" class="btn payFrnd_btn">Go to Dashboard</a>
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