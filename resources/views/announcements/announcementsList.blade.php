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
        .w5-md {
            width: 5%;
        }

        .w50-md {
            width: 50%;
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

        .not-valid+.message {
            display: block !important;
        }

        .submit {
            transition: .3s;
        }

        .sendFCM {
            border: 0px;

            background: #005aa9;
            color: #fff;
            padding: 5px 10px;
        }

        .green {
            color: green;
        }

        .red {
            color: red;
        }

        .yellow {
            color: yellow;
        }

        .btnSubmit {
            border: 0px;
            background: #005aa9;
            color: #fff;
            padding: 5px 10px;
        }

        .btnSubmit:hover {
            color: #fff;
        }

        .editcmsBtn a {
            color: #fff;
        }

        .display-none {
            display: none;
        }

        .deleteBtn {
            cursor: pointer;
        }

        .sendFCMBtn {
            cursor: pointer;
            width: 63%;
        }

        .twofaloader3 {
            position: fixed;
            left: calc(50% - 15px);
            top: calc(50% - 15px);
            z-index: 9;
            width: 100px;
            height: 100px;
        }

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
            <img class="twofaloader3 display-none" src="<?php echo url('/'); ?>/public/images/loader.gif" />
            <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Announcements</h5>
            <div class="row mb-3 mb-md-2 px-3">
              <div class="col-sm-6">
                  <!--<div class="input-group mb-3 search_wrap">
                          <div class="input-group-prepend">
                              <span class="searchicon searchbyEmail" id="basic-addon1"><img src="https://dev.bestbox.net/public/images/search.png"></span>
                          </div>
                          <input type="text" class="form-control searchbar" placeholder="Reseller Name or email" aria-label="Username" aria-describedby="basic-addon1" id="searchKey" value="">
                      </div>-->
              </div>

              <div class="col-sm-6 text-right pb-3">
                <div class="d-inline-block">
                    <a href="<?php echo url('/');?>/addNewAnnouncment" class="big_blue_btn">
                        New Announcement
                    </a>
                </div>
              </div>
            </div>

            <div class="middle_box clearfix">
                <div class="grid_wrp add-user-grid">
                    <div class="grid_header clearfix pt-3 pb-3 d-lg-block d-none">
                        <div class="w15 float-left font16 font-bold blue_txt pl-2 md-100">Created Date</div>
                        <div class="w15 float-left font16 font-bold blue_txt pl-2 md-100">Expiry Date</div>
                        <div class="w25 float-left font16 font-bold blue_txt pl-2 md-100">Title</div>
                        <div class="w35 float-left font16 font-bold blue_txt pl-2 md-100">Description</div>
                        <div class="w10 float-left font16 font-bold blue_txt pl-2 md-100 text-lg-right">Action</div>
                    </div>
                    <div class="grid_body clearfix">
                        <?php
                            $i=1;
                            if(@count($announcements_info) >0 ){
                                foreach($announcements_info as $res){
                                $id = $res['id'];
                                if($res['popup'] == 1){
                                    $popupstatus = "Yes";
                                }
                                else{
                                    $popupstatus = "No";
                                }
                                $created_date = date("d-m-Y H:i:s",strtotime($res['created_at']));
                                $expiry_date = $res['expiry_date'];
                                
                                $platform_type = $res['platform_type'];
                                $title=$res['title'];
                                $description= $res['description'];
                        ?>
                        <div class="grid_row clearfix border-top">

                            <div class="w15 grid_td_info word-break md-100">
                                <?php echo $created_date;?>
                            </div>
                            <div class="w15 grid_td_info word-break md-100">
                                <?php echo ($expiry_date) ? $expiry_date : '-';?>
                            </div>
                            <!-- <div class="w15-md grid_td_info word-break">
                                <?php echo $platform_type;?>
                            </div> -->
                            <div class="w25 grid_td_info word-break md-100">
                                <?php echo $title;?>
                            </div>

                            <div class="w35 grid_td_info word-break md-100">
                                <?php echo strlen($description) > 50 ? substr($description,0,50)."..." : $description; ?>
                            </div>
                            <!--<div class="w10-md grid_td_info text-lg-center"> 
                                <?php //echo $popupstatus; ?>
                            </div> -->
                            <!-- <div class="w10-md grid_td_info text-lg-center"> -->
                            <!-- <button class="btnSubmit sendFCMBtn" data-id="<?php echo $res['id']; ?>" ><i class="fas fa-paper-plane"></i>FCM</button> -->
                            <?php //if($res['announcement_type'] != 2) {?>
                            <!-- <div class="circle_btn sendFCMBtn" data-id="<?php echo $res['id']; ?>"><i style="padding-right:5px;"class="fas fa-paper-plane"></i>FCM</div>  -->
                            <?php //}?>
                            <!--</div>  -->
                            <?php $flag = 0;
                            if(!empty($expiry_date)){
                                if(strtotime(date('Y-m-d')) < strtotime($expiry_date)){
                                    $flag = 1;
                                } 
                            }
                            ?>
                            <div class="w10-md grid_td_info text-lg-right md-100">
                                <?php if($flag == 1 || $expiry_date == ''){?>
                                    <div class="circle_btn d-inline-block resendBtn" data-rec-id="<?php echo $res['id'];?>" ><i class="fa fa-redo"></i></div>
                                <?php }?>
                                <div class="circle_btn d-inline-block deleteBtn" data-id="<?php echo $res['id']; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                </div>
                            </div>

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

            <?php if(@count($announcements_info) >0 ){ ?>
            <div class="pagi">
                <?php echo $announcements_info->links();?>
            </div>
            <?php } ?>
        </section>
        <!-- All scripts include -->
        @include("inc.scripts.all-scripts")

        <div class="modal fade" id="successModel" tabindex="-1" role="dialog" aria-labelledby="deleteUser"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header w-100 text-center">
                        <h5 class="modal-title font-bold black_txt text-uppercase f20 w-100" id="exampleModalLongTitle">
                            Confirmation</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>

                    <div class="modal-body add_edit_user pb-4">
                        <div class="text-center f20 black_txt py-5 mb-5 " id="sucessMsg"></div>
                    </div>
                    <!-- footer buttons -->
                    <div class="inline-buttons">
                        <button type="button" class="btn inline-buttons-left cancel-btn d-none"
                            data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn inline-buttons-right create-btn OkBtnNew w-100"
                            id="OkBtn">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" nonce="32432jlkfsdaf">
            $(".approveBtn").on('click', function (e) {
                e.preventDefault();
                $("#approvetxtbox").show();

            });


            /*$('body').on('click', '.sendFCMBtn', function () {
                var rec_id = $(this).attr("data-id");

                var token = "<?php echo csrf_token() ?>";
                if (rec_id == "") {
                    alert("Rec id is missing");
                    return false;
                } else {

                    $.ajax({
                        url: "<?php echo url('/');?>/sendAnnouncmentsToAll",
                        method: 'POST',
                        dataType: "json",
                        data: {
                            'rec_id': rec_id,
                            'action': 'sendAnnouncementFCM',
                            "_token": token
                        },
                        beforeSend: function () {
                            $(".twofaloader3").show();
                        },
                        complete: function () {
                            $(".twofaloader3").hide();
                        },
                        success: function (data) {
                            if (data.status == 'Success') {
                                $("#successModel").modal('show');
                                $('#sucessMsg').html('<p class="text-color">' + data.Result +
                                    '</p>');
                                return true;
                            } else {
                                alert(data.Result);
                                return false;

                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });


                }

            });*/

            $('body').on('click', '.resendBtn', function () {
                var rec_id = $(this).attr("data-rec-id");

                var token = "<?php echo csrf_token() ?>";
                if (rec_id == "") {
                    alert("Record id is missing");
                    return false;
                } else {

                    $.ajax({
                        url: "<?php echo url('/');?>/resendGeneralAnnouncement",
                        method: 'POST',
                        dataType: "json",
                        data: {
                            'rec_id': rec_id,
                            'action': 'sendGeneralAnnouncement',
                            "_token": token
                        },
                        beforeSend: function () {
                            $(".twofaloader3").show();
                        },
                        complete: function () {
                            $(".twofaloader3").hide();
                        },
                        success: function (data) {
                            if (data.status == 'Success') {
                                $("#successModel").modal('show');
                                $('#sucessMsg').html('<p class="text-color">' + data.Result +
                                    '</p>');
                                return true;
                            } else {
                                alert(data.Result);
                                return false;

                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });


                }

            });

            // Ok Btn msg
            $(".OkBtnNew").on('click', function (e) {
                e.preventDefault();
                $('#successModel').modal('hide');
                window.location.reload();
            });

            // delete user 

            $(".deleteBtn").click(function (e) {
                e.preventDefault();
                var rec_id = $(this).attr("data-id");
                //alert(rec_id);return false;
                var token = "<?php echo csrf_token() ?>";
                setTimeout(function () {
                    swal({
                        title: 'Are you sure you want delete ?',
                        //text: "Your withdrawal <b>"+transfer_amount+" USD</b> will be transafer to user <b>"+user_name+"</b> wallet.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4FC550',
                        cancelButtonColor: '#D0D0D0',
                        confirmButtonText: 'Yes, proceed it!',
                        closeOnConfirm: false,
                        //html: transfer_amount+" USD</b> transfer to user </br><b>"+user_name+"</b> wallet."
                    }).then(function (result) {
                        if (result.value) {
                            //alert("Teste");

                            $.ajax({
                                url: "<?php echo url('/');?>/deleteAnnouncment",
                                method: 'POST',
                                dataType: "json",
                                data: {
                                    'rec_id': rec_id,
                                    "_token": token
                                },
                                beforeSend: function () {
                                    $(".loaderIcon").show();
                                },
                                complete: function () {
                                    $(".loaderIcon").hide();
                                },
                                success: function (data) {
                                    if (data.status == 'Success') {
                                        $('#successModel').modal('show');
                                        $('#sucessMsg').html(
                                            '<p class="text-color">' + data
                                            .Result + '</p>');
                                        return true;

                                    } else {
                                        alert(data.Result);
                                        return false;
                                    }
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError);
                                }
                            });


                        } else {
                            //alert("testing");
                        }
                    }).catch(swal.noop);
                }, 100);

            });

        </script>



</body>

</html>
