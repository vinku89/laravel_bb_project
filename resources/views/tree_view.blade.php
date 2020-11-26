<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
	<title>BestBOX - Tree View</title>
	<!-- All styles include -->
	@include("inc.styles.all-styles")
	<style type="text/css">
		.highcharts-credits {
			display: none !important;
		}
		.dk-selected {
			height: 44px !important;
			line-height: 44px !important;
		}
		.dk-option {
			height: 35px !important;
			line-height: 35px !important;
		}

		 .searchicon{
            margin-bottom:5px;
        }
        .searchicon img{
            margin-top:9px;
        }

	</style>
	<link rel="stylesheet" href="<?php echo url('/');?>/public/css/treeview.css?q=<?php echo rand();?>" rel="stylesheet">
	</head>
	<body>
	<!-- Side bar include -->
	@include("inc.sidebar.sidebar")
	<div class="main-content">
		<!-- Header Section Start Here -->
		@include("inc.header.header")
		<!-- Header Section End Here -->
		<section class="main_body_section scroll_div">
			<h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Tree Structure</h5>

			<!-- Filter section -->
			<div class="filter_wrp col-12 pb-3">
	                <div class="row">
	                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12 px-0">
	                        <div class="input-group ">
								<input type="text" class="form-control bbcustinput" placeholder="User ID/Email ID" aria-label="Username" aria-describedby="basic-addon1" id="searchKey" value="{{ $searchKey }}">
								<div class="input-group-append">
									<button class="btn btn-outline-primary px-2" type="button" id="searchBtn">
										<img src="<?php echo url('/');?>/public/images/search.png?q=<?php echo rand();?>" class=" mt-0">
									</button>
								</div>
	                        </div>
	                    </div>
	                </div>
	            </div>
			<div class="middle_box clearfix">

				<div id="container" class="brick-tree">
					@If(!empty($userInfo))
					<ul>
						<li class="main_user">
							<div class="my_tree">
								<?php
									if($userInfo['image']!=""){
								?>
									<img src="<?php echo url('/');?>/public/profileImages/<?php echo $userInfo['image'];?>">
								<?php
									}else{
								?>
									<img src="<?php echo url('/');?>/public/profileImages/avatar.png">
								<?php
									}
								?>
								</div>
							<div class="treemain_div"  id="txt_1">
								<div class="tree-title">
									<h3 class="package-username"><?php echo $userInfo['first_name']." ".$userInfo['last_name']." [".$userInfo['user_id']."]";?></h3>
									<div class="usertree_info  float-left"> <h5 style="margin-right: 2px;"><?php echo $userInfo['email'];?></h5>
									<h5>( <span class="packages" style="margin-left: 0px;"><?php
										if($userInfo['user_role']==1){
											echo "Super Admin";
										}else if($userInfo['user_role']==2){
											echo "Reseller";
										}else if($userInfo['user_role']==3){
											echo "Agent";
										}else{
											echo "Customer";
										}
									?></span> )</h5></div>
									</div>
							</div>
						</li>


						<?php
							foreach ($treeview as $val) {
								$downuser=\App\User::where("rec_id",$val['down_id'])->where('status',1)->first();
								if($downuser!==null){

									$users_count = \App\Unilevel_tree::join('users', 'users.rec_id', '=', 'unilevel_tree.down_id')->where('unilevel_tree.upliner_id',$downuser['rec_id'])->where('unilevel_tree.level',1)->where('users.status',1)->count();
									$display="none";
									$no_display="block";
									if($users_count>0){
										$display="block";
										$no_display="none";
									}
							?>

							<li>
								<div class="tree-main">
									<div class="tree-title">
										<h3 class="package-username"><?php echo $downuser['first_name']." ".$downuser['last_name']." [".$downuser['user_id']."]";?></h3>
										<div class="usertree_info  float-left"> <h5 style="margin-right: 2px;"><?php echo $downuser['email'];?></h5>
										<h5>( <span class="packages" style="margin-left: 0px;"><?php
											if($downuser['user_role']==1){
												echo "Super Admin";
											}else if($downuser['user_role']==2){
												echo "Reseller";
											}else if($downuser['user_role']==3){
												echo "Agent";
											}else{
												echo "Customer";
											}
										?></span> )</h5></div>
									</div>
								</div>
								<div class="romvebtn remove tree-icon opened" data-userid="<?php echo $downuser['rec_id'];?>" style="display: <?php echo $display;?>"></div>
								<div class="ul-appending opend tree-icon closed expand1" data-userid="<?php echo $downuser['rec_id'];?>" style="display: <?php echo $display;?>"></div>
								<div class="tree-icon nochild noc" data-userid="" style="display: <?php echo $no_display;?>"></div>
							</li>
							<?php
								}
							}
						?>

					</ul>
					@else
						<div class="grid_row norecord_txt">No Records Found</div>
					@endIf
				</div>


			</div>
		</section>
	</div>
	<!-- All scripts include -->
	@include("inc.scripts.all-scripts")
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js">
	</script>
	<script type="text/javascript">

		var nd=1;

		$('body').on('click', '.ul-appending', function(e) {
			var user_id = $(this).attr('data-userid');
			$(this).prev('div.romvebtn').show();

			$(this).hide();
			var val = $(this);

			var csrf_Value= "<?php echo csrf_token(); ?>";
			$.ajax({
				url: "<?php echo url('/');?>/getunilevelData",
				method: 'POST',
				dataType: "json",
				data: {'user_id':user_id,'_token':csrf_Value},
				success: function (data) {
					//console.log(data);
					var idd = e.target.id;
					$.each( data, function( key, result ) {
						addRow(idd, val, result);
					});
				}
			});



		});
		$('body').on('click','.remove',function(){
					$(this).parent('li').children('ul').remove();
					$(this).next('div').show();
					$(this).hide();
			});
		function addRow(idd,val, result){

			//console.log(user_id);
			$(val).parent().append(
				$('<ul>').addClass('newul').append(
					$('<li>').append($('<div class="tree-main"><div class="tree-title"><h3 class="package-username">'+result.name+'['+result.user_id+']'+'</h3><div class="usertree_info  float-left"> <h5 style="margin-right: 2px;">'+result.email+'</h5><h5>( <span class="packages" style="margin-left: 0px;">'+result.user_role+'</span> )</h5></div></div></div><div class="romvebtn remove tree-icon opened" data-userid="'+result.down_user_id+'" style="display: '+result.level_display+'"></div><div class="ul-appending opend tree-icon closed expand1" data-userid="'+result.down_user_id+'" style="display: '+result.level_display+'"></div><div class="tree-icon nochild noc" data-userid="" style="display: '+result.no_child+'"></div>'
						))
						));
			}

		window.onload = function () {
			$(".menu_wrp_scroll").mCustomScrollbar({
			theme:"dark",
			mouseWheelPixels: 80,
			scrollInertia: 0
			});
		}
	</script>
	<script type="text/javascript">
        var url = "<?php echo url('/tree_view'); ?>";

        $("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                var searchKey = $("#searchKey").val().trim();
                location.href = url+'?searchKey='+searchKey+'&page=0';
            }
        });

        $("#searchBtn").on('click',function(event){

            var searchKey = $("#searchKey").val().trim();
            location.href = url+'?searchKey='+searchKey+'&page=0';

        });
    </script>
	</body>
</html>
