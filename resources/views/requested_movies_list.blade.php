<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Request Movie List</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")

     <style>
	 .w5-md {
		width: 5%;
	}
	.w20-md{
		width: 20%;
	}
        input:focus,
        textarea:focus {
        border: 2px solid #999;
        outline: none;
      }

      textarea {
        min-height: 100px;
      }

      .message {
        position: absolute;
        z-index: 9;
        display: none;
        width: 92%;
        padding: 10px;
        margin-top: -4px;
        background: #D9585C;
        color: #fff;
        text-align: center;
      }
      .message:after {
        content: '';
        position: absolute;
        top: -10px;
        left: 50%;
        display: block;
        margin-left: -10px;
        border: solid;
        border-color: #D9585C transparent #D9585C;
        border-width: 0 10px 10px;
      }

      .is-valid {
        border-color: #AAD661 !important;
        transition: 0;
      }

      .not-valid {
        border-color: #D7595F;
        transition: 0;
      }
      .not-valid + .message {
        display: block !important;
      }

      .submit {
        transition: .3s;
      }
	  .sendFCM{
		border: 0px;

		background: #005aa9;
		color: #fff;
		padding: 5px 10px;
	  }
		.green{color:green;}
		.red{color:red;}
     </style>
</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content sales_transaction">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Requested Movies List</h5>
			<div class="row">
				<div class="col-sm-6 order-2 order-sm-1">
					<div class="input-group mb-1 search_wrap">
						<div class="input-group-prepend">
							<span class="searchicon searchbyEmail" id="basic-addon1"><img src="<?php echo url('/');?>/public/images/search.png"></span>
						</div>
						<input type="text" class="form-control searchbar" placeholder="Movie Name" id="searchKey" name="searchKey" value="<?php echo ($searchKey)?$searchKey:""; ?>" aria-label="Movie Name" aria-describedby="basic-addon1" style="margin-bottom:0px !important;">
					</div>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-sm-6 order-2 order-sm-1">
					<button type="submit" class="sendFCM"  id="sendFCMToAll">Send FCM TO All</button>
				</div>
			</div> -->
          <div class="middle_box clearfix">
            <div class="grid_wrp add-user-grid">
              <div class="grid_header clearfix pt-3 pb-3 d-lg-block d-none">
				<!-- <div class="w5 float-left font16 font-bold blue_txt pl-2"><input type="checkbox" id="select_all" class="checkall" style="height:20px;"/>All</div> -->
				<div class="w15 float-left font16 font-bold blue_txt pl-2">Requested Date</div>
                <div class="w25 float-left font16 font-bold blue_txt pl-2">User Name</div>
                <div class="w25 float-left font16 font-bold blue_txt pl-2">Email</div>
                <div class="w15 float-left font16 font-bold blue_txt pl-2 text-lg-center">Movie Name</div>
                <div class="w20 float-left font16 font-bold blue_txt pl-2 text-lg-center">Status</div>
                <!-- <div class="w10 float-left font16 font-bold blue_txt pl-2 text-lg-center">Action</div> -->
              </div>
              <div class="grid_body clearfix">
                <!--Row 1-->
                <?php
                $i=1;
				if(!empty($movieslist)){
                  foreach($movieslist as $au){

                ?>
                <div class="grid_row clearfix border-top">
					<!-- <div class="w5-md grid_td_info ">
						<span class="mob_title blue_txt d-block d-lg-none">&nbsp;</span>
                       <input type="checkbox" id="" class="chkbox" value="<?php echo $au['rec_id']; ?>" style="height:20px;"/>
                    </div> -->
                    <div class="w15-md grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">Date</span>
                        <?php echo date("d-m-Y H:i",strtotime($au['requested_date']));?>
                    </div>
                    <div class="w25-md grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">User Name</span>
                        <?php echo $au['first_name']." ".$au['last_name'];?>
                    </div>
                    <div class="w25-md grid_td_info word-break-all">
                      <span class="mob_title blue_txt d-block d-lg-none">Email</span>
                        <?php echo $au['email'];?>
                    </div>
                    <div class="w15-md grid_td_info text-lg-center">
                    <span class="mob_title blue_txt d-block d-lg-none">Movie Name</span>
                        <?php echo $au['requested_movies'];?>
                    </div>
                    <div class="w20-md grid_td_info text-lg-center">
						<select class="form-control sendFCM1" name="sendFCM1">
							<option value="1"  data-id="<?php echo $au['rec_id'];?>" <?php if($au['status'] == 1){echo "selected";}else{echo "";}?>>Uploaded</option>
							<option value="0"  data-id="<?php echo $au['rec_id'];?>" <?php if($au['status'] == 0){echo "selected";}else{echo "";}?>>Pending</option>

						</select>

                    </div>
                    <!-- <div class="w10-md grid_td_info text-lg-center">
                        <span class="mob_title blue_txt d-block d-lg-none">Action</span>
						<button type="submit" class="sendFCM"  data-id="<?php //echo $au['rec_id']; ?>" >Send FCM</button>


                    </div> -->
                </div>
                <?php
                $i++;
                  }
				}else{
                ?>
				<div class="grid_row clearfix border-top">
				 <h2>No Records Found</h2>
				 </div>
				<?php } ?>

              </div>
            </div>
          </div>
        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

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
	<script type="text/javascript">
		$(document).ready(function(){
			$("#select_all").change(function(){
				$(".chkbox").prop('checked', $(this).prop("checked"));
			});

			$('.chkbox').change(function(){

				if(false == $(this).prop("checked")){
					$("#select_all").prop('checked', false);
				}
				//check "select all" if all checkbox items are checked
				if ($('.chkbox:checked').length == $('.chkbox').length ){
					$("#select_all").prop('checked', true);
				}
			});

			$('#sendFCMToAll' ).click(function() {
				var chkArray = [];
				$(".chkbox:checked").each(function() {
					chkArray.push($(this).val());
				});

				var moviesselected;
				moviesselected = chkArray.join(',');
				//alert(moviesselected);
				//return false;
				if(moviesselected.length > 0){

					var action = "multipleuser";
					sendAnnouncementFCM(moviesselected,action);

				}else{
					alert("Please select atleast one checkbox");
					return false;
				}


			});
        });
	</script>
	<script type="text/javascript" nonce="32432jlkfsdaf">
		$('body').on('change', '.sendFCM1', function(){
			//var id = $(this).attr("data-id");
			var id = $(this).find(':selected').attr('data-id');
			var value = $(this).val();

			if(value == 1){
				var action = "singleuser";
				sendAnnouncementFCM(id,action);
			}else{
				var action = "pending";
				sendAnnouncementFCM(id,action);
			}


		});
		function sendAnnouncementFCM(id,action){
			var currentRecId = id;
			var token = "<?php echo csrf_token() ?>";
			$.ajax({
				url: "<?php echo url('/');?>/sendFCMUploadedMovie",
				method: 'POST',
				dataType: "json",
				data: {'rec_ids': currentRecId,'action': action,"_token": token},
				beforeSend: function(){
					$(".loaderIcon").show();
				},
				complete: function(){
					$(".loaderIcon").hide();
				},
				success: function (data) {
				   if(data.status=='Success'){
						$("#successModel").modal('show');
						//window.location.reload();
						$('#sucessMsg').html('<p class="text-color">'+data.Result+'</p>');
						return true;
					}else{
						alert(data.Result);
						return false;

					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
			});
		}

		// Ok Btn msg
		$(".OkBtnNew").on('click', function(e) {
			e.preventDefault();
			$('#successModel').modal('hide');
			window.location.reload();
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


        var url = "<?php echo url('/requestedMovies'); ?>";


        $("#searchKey").on('keypress',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                var searchKey = $("#searchKey").val();
                location.href = url+'?searchKey='+searchKey;
            }
        });


         /* filter data */
       /* $("#filter_data").click(function(e){
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
        });*/

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

</body>
</html>
