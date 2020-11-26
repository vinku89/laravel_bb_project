<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")
	<style>
		.tab_btn_active a{color:#fff;text-decoration:none;}

	</style>

</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content sales_transaction">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div container-fluid">
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Trial Accounts </h5>

            <div class="row">
                <div class="col-12">
                    <div class="clearfix">
                        <a href="<?php echo url('/');?>/prospectsList" ><button class="btn tab_btn">Prospects </button></a>
                        <a href="<?php echo url('/');?>/requestTrialsList"><button class="btn tab_btn ">Trial Requests </button></a>
                        <a href="<?php echo url('/');?>/addFreetrail"><button class="btn tab_btn_active">Add Trail Period</button> </a>
                    </div>
                </div>
            </div>

            <!-- add free trail -->
            <div class="form-group row bg-light my-0 py-3">
                <div class="col-3 align-self-center">
                    <label for="imageInput">Enter Email</label>
                </div>
                <div class="input-group col-5 align-self-center">
                    <input type="text" class="form-control bbcustinput" value="<?php echo (!empty($user_email)) ? $user_email : '';?>" placeholder="Email ID" id="user_id" value="" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="col-3 align-self-center">
                    <button type="button" id="getUserList" class="btn btn-blue">Submit</button>
                </div>
            </div>

            <?php if(!empty($user_data) && $user_email!=''){?>
            <div class="form-group row py-3 my-0 bg-light">
                <div class="col-3 align-self-center">
                    <label for="imageInput">Name</label>
                </div>
                <div class="input-group col-8 align-self-center">
                    <?php echo $user_data['name'];?>
                </div>
            </div>
            <?php if($user_data['pacakge']>0){?>
            <div class="form-group row py-3 my-0 bg-light">
                <div class="col-3 align-self-center">
                    <label for="imageInput">Package</label>
                </div>
                <div class="input-group col-8 align-self-center red_txt">
                    Already Package Subscribed
                </div>
            </div>
            <?php }else{?>
            <div class="form-group row py-3 my-0 bg-light ">
                <div class="col-3 align-self-center">
                    <label for="imageInput">Trail Expiry Date</label>
                </div>
                <div class="input-group col-8 align-self-center">
                    <?php
                    $class = 'green_txt';
                    if($user_data['expiry_date'] != ''){
                        if($user_data['expiry_date'] < NOW()) {
                            $class = 'red_txt';
                        }
                    }?>
                    <span class="<?php echo $class;?>"><?php echo ($user_data['expiry_date']!='') ? $user_data['expiry_date'] : '-';?></span>


                </div>
            </div>
            <div class="form-group row py-3 my-0 bg-light ">
                <div class="col-3 align-self-center">
                    <label for="imageInput">Trial Duration</label>
                </div>
                <div class="col-8 align-self-center">
                    <select class="form-control select_css" id="duration" name="duration" required>
                        <option value="">Select Trial Duration</option>
                        <option value="1">1 Day</option>
                        <option value="2">2 Days</option>
                        <option value="3">3 Days</option>
                        <option value="4">4 Days</option>
                        <option value="5">5 Days</option>
                        <option value="6">6 Days</option>
                        <option value="7">7 Days</option>
                    </select>
                </div>
                <div class="col-3 align-self-center">
                    <button type="button" id="saveTrailPeriod" class="btn btn-blue">Save</button>
                </div>
            </div>

            <?php }?>
            <?php }else if($user_email!=''){?>
            <div class="form-group row">
                <div class="col-12 align-self-center">
                    No User Found
                </div>
            </div>
            <?php } ?>

            <!-- add free trail -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3 col-xl-3 mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control bbcustinput" placeholder="User ID or Email ID" id="searchKey" value="<?php echo ($searchKey)?$searchKey:""; ?>" aria-label="Username" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary px-2 serchBtn1" type="button" id="button-addon1">
                                <img src="/public/images/search.png" class=" mt-0">
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="trail_table">
                        <div class="trail_table_titles clearfix">
                            <div class="tw-15 pl-1">Date of trail</div>
                            <div class="tw-15 pl-1">User ID</div>
                            <div class="tw-15 pl-1">Pasword</div>
                            <div class="tw-20 pl-1">Email ID</div>
                            <div class="tw-20 pl-1">Name</div>
                            <div class="tw-15 pl-1">Expiry Date</div>
                        </div>
                            <?php
                                $i=1;
                                if(@count($freetrail_info) >0 ){
                                foreach($freetrail_info as $res){
                                    $user_id = $res['user_id'];
                                    $status = $res['status'];

                                    if($status == 2){
                                        $status_msg = "Completed";
                                    }else{
                                        $status_msg = "";
                                    }

                                    $userinfo = \App\User::where('rec_id', $user_id)->first();

                                    $email ="";$fullName="";$telephone="";$userID="";$sale_status = "";
                                    if(!empty($userinfo)){
                                        $fullName = $userinfo->first_name." ".$userinfo->last_name;
                                        $email = $userinfo->email;
                                        $userID = $userinfo->user_id;

                                        $packagesInfo = \App\Package_purchase_list::select('*')->where('user_id','=',$user_id)->where('active_package','=',1)->orderBy("rec_id", "DESC")->first();

                                        if(!empty($packagesInfo)){

                                            if($packagesInfo->expiry_date == NULL){
                                                $sale_status = "N";
                                            }else{
                                                $sale_status = "Y";
                                            }

                                        }else{
                                            $sale_status = "N";
                                        }


                                    }


                            ?>

                                <!-- ROW --1 -->
                                <div class="trail_table_row clearfix">
                                    <div class="tw-15 pl-1 trial_brbtm">
                                        <span class="m_title">Date of trail</span>
                                        <?php echo date("d-m-Y H:i A",strtotime($res['trail_requested_time']));?>
                                    </div>
                                    <div class="tw-15 pl-1 font-weight-bold" >
                                        <span class="m_title">User ID</span>
                                            <?php echo $userID; ?>
                                    </div>
                                    <div class="tw-15 pl-1 trial_brbtm">
                                        <span class="m_title">Password</span>
                                        <?php echo (!empty($userinfo->plain_password)) ? safe_decrypt($userinfo->plain_password,config('constants.encrypt_key')) : '-';?>
                                    </div>
                                    <div class="tw-20 pl-1 trial_brbtm">
                                        <span class="m_title">Email ID</span>
                                        <?php echo $email; ?>
                                    </div>
                                    <div class="tw-20 pl-1 trial_brbtm">
                                        <span class="m_title">Name</span>
                                        <?php echo ucfirst($fullName); ?>
                                    </div>
                                    <?php
                                    $color_text = 'green_txt';
                                    if($res['trail_end_time'] != ''){
                                        if($res['trail_end_time'] < NOW()) {
                                            $color_text = 'red_txt';
                                        }
                                    }
                                    ?>
                                    <div class="tw-15 pl-1 <?php echo $color_text;?> font-weight-bold trial_brbtm-767">
                                        <span class="m_title">Expiry Date</span>
                                        <?php echo ($res['trail_requested_time']!='') ? date("d-m-Y H:i A",strtotime($res['trail_end_time'])) : '';?>
                                    </div>
                                </div>
                            <?php
                                $i++;
                                }
                                }else{
                            ?>
                            <div class="trail_table_row clearfix">
                                <h2>No Records Found</h2>
                            </div>
                            <?php } ?>

                    </div>

                    <?php if(@count($freetrail_info) >0 ){ ?>
                        <div class="pagi">
                            <?php echo $freetrail_info->links();?>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </section>
    </div>
        <!-- All scripts include -->
        @include("inc.scripts.all-scripts")

        <script type="text/javascript">
            var url = "<?php echo url('/addFreetrail'); ?>";
            var url2 = "<?php echo url('/saveFreetrail'); ?>";

            $("#searchKey").on('keypress',function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == 13){
                    var searchKey = $("#searchKey").val();
                    location.href = url+'?searchKey='+searchKey;
                }
            });
            $(".serchBtn1").on('click',function(e){
                e.preventDefault();
                var searchKey = $("#searchKey").val();
                if(searchKey != ""){
                    var searchKey = $("#searchKey").val();
                    location.href = url+'?searchKey='+searchKey;
                }else{
                    alert("Please enter E-mail or User ID");
                    return false;
                }
            });
            $("#getUserList").on('click',function(e){
                e.preventDefault();
                var user_id = $("#user_id").val();
                location.href=url+'?user_id='+user_id;
            });
            $("#saveTrailPeriod").on('click',function(e){
                e.preventDefault();
                var user_id = $("#user_id").val();
                var duration = $("#duration").val();
                if(user_id == '') {
                    alert("Please enter E-mail");
                    return false;
                }
                if(duration == '') {
                    alert("Please select duration");
                    return false;
                }
                if(user_id != '' && duration!= '') {
                    location.href=url2+'?user_id='+user_id+'&duration='+duration;
                }

            });

        </script>
        <?php
        if(Session::has('alert') && Session::get('alert') == 'Failure'){
        ?>
            <script type="text/javascript">
                swal(
                    'Failure',
                    '<?php echo Session::get('error');?>',
                    'error'
                )
            </script>
        <?php
            }
        ?>

        <?php
            if(Session::has('alert') && Session::get('alert') == 'Success'){
        ?>
            <script type="text/javascript">
                swal(
                    'Success',
                    '<?php echo Session::get('message');?>',
                    'success'
                )
            </script>
        <?php
            }
        ?>
</body>
</html>
