
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>BestBOX</title>
		<link rel="shortcut icon" href="{{ url('/').'/public/favicon.png' }}" type="image/png" sizes="32x32" />
		<!-- All styles include -->
		@include("inc.styles.all-styles")

		<style>
			.searchicon{
				margin-bottom:5px;
			}
			.searchicon img{
				margin-top:9px;
			}
		</style>
	</head>

	<body>
		<!-- Side bar include -->
		@include("inc.sidebar.sidebar")
		<div class="main-content">
			<!-- Header Section Start Here -->
			@include("inc.header.header")
			<!-- Header Section End Here -->
			<section class="main_body_section scroll_div">

				<!-- Page Title Section 1 Mobile fixed -->
				<h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left">AGENTS</h5>
				<!-- Page Title Section 1 Mobile End -->

				 <!-- Section 2 Search Mobile fixed -->
				<div class="row">
					<div class="col-sm-6 order-2 order-sm-1">
						<div class="input-group mb-1 search_wrap">
							<div class="input-group-prepend">
								<span class="searchicon searchbyEmail" id="basic-addon1"><img src="{{  url('/').'/public/images/search.png' }}"></span>
							</div>
							<input type="text" class="form-control searchbar" placeholder="Agent Name or Email ID" id="searchKey" name="searchKey" value="{{ $searchKey }}"
								aria-label="Username" aria-describedby="basic-addon1">
						</div>
					</div>

					<div class="col-sm-6 text-right order-1 order-sm-2 mb-2">
						<div class="d-sm-block d-none">
							<div class="d-inline-block">
								<a href="{{  url('/').'/agent-new' }}" class="big_blue_btn">
									New Agent
								</a>
							</div>
						</div>

						<div class="d-sm-none d-block">
							<div class="d-block">
								<a href="{{  url('/').'/agent-new' }}" class="big_blue_btn w-100 text-left">
									New Agent
								</a>
							</div>
						</div>

						<!-- <div class="clearfix d-inline-block">
							<a href="" class="print_btn">
								Print
								<i class="fas fa-print"></i> </a>
						</div> -->
					</div>
				</div>
				 <!-- Section 2 Mobile End -->

			<?php 
				if($userInfo->user_role == 1){
					$w1 = "w25";$w2= "w25"; $w3 = "w15"; $w4="w12";$w5="w13"; $w6="w10";
				}else{
					
					$w1 = "w25";$w2= "w30"; $w3 = "w15"; $w4="w15";$w5=""; $w6="w15";
				}	
			?>

        <!-- Table Heading fixed -->
        <div class="grid_wrp d-none d-lg-block">
                <div class="grid_body clearfix">
                    <div class="grid_row clearfix">
                        <div class="<?php echo $w1; ?> float-left font16 font-bold blue_txt">Name</div>
                        <div class="<?php echo $w2; ?> float-left font16 font-bold blue_txt">Email</div>
                        <div class="<?php echo $w3; ?> float-left font16 font-bold blue_txt">Mobile Number</div>
                        <div class="<?php echo $w4; ?> float-left font16 font-bold blue_txt text-right">Commission %</div>
						<?php if($userInfo->user_role == 1){ ?>
						<div class="<?php echo $w5; ?> float-left font16 font-bold blue_txt text-center">Status</div>
						<?php } ?>
                        <div class="<?php echo $w6; ?> float-left font16 font-bold blue_txt text-right">Actions</div>
                    </div>
                </div> 
            </div>

            <div class="middle_box clearfix d-none d-lg-block">
	            <div class="grid_wrp">
	                <div class="grid_body clearfix">
	                @if($resellers_data->count()>0)
	                    @foreach($resellers_data as $val) 
	                    <div class="grid_row clearfix">
	                        <div class="<?php echo $w1; ?> float-left font16 dark-grey_txt word-break-all">
	                            {{  ucwords($val->first_name.' '.$val->last_name) }}
	                        </div>
	                        <div class="<?php echo $w2; ?> float-left font16 dark-grey_txt word-break-all">{{  $val->email }}</div>
	                        <div class="<?php echo $w3; ?> float-left font16 dark-grey_txt">{{  $val->telephone }} </div>
	                        <div class="<?php echo $w4; ?> float-left font16 dark-grey_txt text-right">{{  (!empty($val->commission_perc) ? $val->commission_perc : '0') }} %</div>
							@If($userInfo->user_role == 1)
							<div class="<?php echo $w5; ?> float-left font16 dark-grey_txt pl-2">
								<select class="form-control inactiveAgent">
									<option value="1" data-id="{{  $val->rec_id }}" <?php if($val->status == 1){echo "selected";}else{echo "";} ?> >Active</option>
									<option value="0" data-id="{{  $val->rec_id }}" <?php if($val->status == 0){echo "selected";}else{echo "";} ?> >In-Active</option>
								</select>
							</div>
							@endIf
	                        <div class="<?php echo $w6; ?> float-left font16 dark-grey_txt">
								<div class="float-right">
											<a class="circle_btn d-inline-block mr-auto editAgent" href="{{  url('/').'/agent-edit/'.base64_encode($val->rec_id) }}" data-id="{{  $val->rec_id }}">
												<i class="fas fa-pencil-alt"></i>
											</a>
										<!--  @If($userInfo->user_role == 1)
											<a class=" circle_btn delete d-inline-block mr-auto deleteAgent" href="#" data-name="{{  ucwords($val->first_name.' '.$val->last_name) }}" data-id="{{  $val->rec_id }}">
												<i class="far fa-trash-alt"></i>
											</a>
											@endIf -->
											<a class="circle_btn view d-inline-block mr-auto" href="{{  url('/').'/agentView/'.base64_encode($val->rec_id) }}">
												<i class="far fa-eye"></i>
											</a>
										</div>
								</div>

							</div>
							@endforeach
						@else
							<div class="grid_row clearfix norecord_txt">No Records Found</div>
						@endIf 
						</div>

	            </div>
                
            </div>
            <!-- Table details Mobile view fixed -->
				<div class="accordion-container d-lg-none mt-2">
					@if($resellers_data->count()>0)
	                    @foreach($resellers_data as $val) 
					<div class="set">
						<a href="#">
							<div class="row">
								<div class="col-6">
									<div class="set_user f12">{{  ucwords($val->first_name.' '.$val->last_name) }}</div>
								</div>
								<div class="col-6 text-right pr-5"><span href="#" class="comission_green d-inline-block f12 mt-2 py-1">{{  (!empty($val->commission_perc) ? $val->commission_perc : '0') }} %</span></div>
							</div> 
							<i class="fa fa-angle-down"></i>
						</a>
						<div class="content p-3">
							<div class="row my-1">
								<div class="col-4 text-blue f12 font-bold">Email</div>
								<div class="col-1">:</div>
								<div class="col-6 f12"> {{  $val->email }} </div>
							</div>

							<div class="row my-1">
								<div class="col-4 text-blue f12 font-bold">Mobile No</div>
								<div class="col-1">:</div>
								<div class="col-6 f12"> {{  $val->telephone }}</div>
							</div>

							<div class="row my-1">
								<div class="col-4 text-blue f12 font-bold">Commission %</div>
								<div class="col-1">:</div>
								<div class="col-6 f12">{{  (!empty($val->commission_perc) ? $val->commission_perc : '0') }} %</div>
							</div>
							 @If($userInfo->user_role == 1)
							<div class="row my-1">
								<div class="col-4 text-blue f12 font-bold">Status</div>
								<div class="col-1">:</div>
								<div class="col-6 f12"> 
									<select class="form-control inactiveAgent f12">
										<option value="1" data-id="{{  $val->rec_id }}" <?php if($val->status == 1){echo "selected";}else{echo "";} ?> >Active</option>
										<option value="0" data-id="{{  $val->rec_id }}" <?php if($val->status == 0){echo "selected";}else{echo "";} ?> >In-Active</option>
									</select>
								</div>
							</div>
							@endIf
							<div class="row mt-3">
								<div class="col-12 text-right">
									<div class="d-inline-block">
										<a class="circle_btn d-inline-block editAgent" href="{{  url('/').'/agent-edit/'.base64_encode($val->rec_id) }}" data-id="{{  $val->rec_id }}" >
											<i class="fas fa-pencil-alt"></i>
										</a>
										
										<a class="circle_btn view d-inline-block" href="{{  url('/').'/agentView/'.base64_encode($val->rec_id) }}">
											<i class="fas fa-eye"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					@else
						<div class="grid_row clearfix norecord_txt">No Records Found</div>
					@endIf 
					
				</div>
				<!-- Table details Mobile view End -->
            @if($resellers_data->total()>0)
                {{  $resellers_data->appends(['searchKey' =>''])->links() }}
            @endIf
        </section>
    </div>
	
		  <!-- Success Model -->
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
	
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
   
     <script type="text/javascript">
     var url = "{{ url('/').'/agents' }}";
        $(document).ready(function(){
           $(".deleteAgent").click(function(){
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                swal({
	                title: 'Are you sure you want to delete this Agent?',
	                type: 'warning',
	                showCancelButton: true,
	                confirmButtonColor: '#4FC550',
	                cancelButtonColor: '#D0D0D0',
	                confirmButtonText: 'Yes, proceed it!',
	                closeOnConfirm: true,
	                html: "Username "+name
	            }).then(function (result) {
	                 if (result.value) {
	                 	var csrf_Value= "{{  csrf_token()  }}";
		                $.ajax({
		                    url: "{{  url('/').'/deleteResellerData' }}",
		                    method: 'POST',
		                    dataType: "json",
		                    data: {'id': id,"_token": csrf_Value},
		                    success: function(data){
								swal(
					                'Success',
					                'Agent deleted successfully',
					                'success'
					            )
		                    }
		                });
		            }
	            }).catch(swal.noop);


            });

        });

        $("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey;
            }
        });
		
		// deleteResellerAgentStatus
		$(".inactiveAgent").on('change', function(e) {
			e.preventDefault();
			var token = "<?php echo csrf_token() ?>";
			var statusID = $(this).val();
			var rec_id = $(this).find(':selected').attr('data-id');
			if(statusID != ""){
				$.ajax({
					url: "<?php echo url('/');?>/deleteResellerAgentStatus",
					method: 'POST',
					dataType: "json",
					data: {'rec_id': rec_id,'status': statusID,'action': 'inactiveAgent',"_token": token},
					beforeSend: function(){
						$(".loaderIcon").show();
					},
					complete: function(){
						$(".loaderIcon").hide();
					},
					success: function (data) { 
					   if(data.status=='Success'){
							$('#successModel').modal('show');
							$('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>'); 
							//window.location.reload();
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
				alert("something went wrong");
			}
			
		});
		
		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) { 
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
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