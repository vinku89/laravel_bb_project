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
        .rwd-table th, .rwd-table td {
            
            padding: 1em .5em !important;
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
                <h5 class="font16 font-bold text-uppercase black_txt px-3 py-4">RESELLERS</h5>
                <div class="row mb-3 mb-md-0 px-3">
                    <div class="col-sm-6">
                        <div class="input-group mb-3 search_wrap">
                            <div class="input-group-prepend">
                                <span class="searchicon searchbyEmail" id="basic-addon1"><img src="<?php echo url('/');?>/public/images/search.png"></span>
                            </div>
                            <input type="text" class="form-control searchbar" placeholder="Reseller Name or Email ID"
                                aria-label="Username" aria-describedby="basic-addon1" id="searchKey" value="{{ $searchKey }}">
                        </div>
                    </div>

                    <div class="col-sm-6 text-right">
                        <div class="d-inline-block">
                            <a href="{{ url('/').'/reseller-new' }}" class="big_blue_btn">
                                New Reseller
                            </a>
                        </div>

                        <!-- <div class="clearfix d-inline-block">
                            <a href="" class="print_btn">
                                Print
                                <i class="fas fa-print"></i> </a>
                        </div> -->
                    </div>
                </div>

                <div class="middle_box clearfix d-lg-block d-none">
                    <div class="row">
                        <div class="col-12">
                            <div class="px-3">
                                <table class="rwd-table px-3">
                                    <tr class="font16 grey_txt font-bold">
                                        <th class="font16 grey_txt font-bold">Name</th>
                                        <th class="font16 grey_txt font-bold">Email</th>
                                        <th class="font16 grey_txt font-bold text-md-center">Mobile Number</th>
                                        <th class="font16 grey_txt font-bold text-md-center">Commission %</th>
                                        <?php 
                                            if($userInfo->user_role == 1){
                                        ?>
                                        <th class="font16 grey_txt font-bold text-md-center">Status</th>
                                        <?php } ?>
                                        <th class="font16 grey_txt font-bold text-right">Actions</th>
                                    </tr>
                                    @if($resellers_data->count())
                                        @foreach($resellers_data as $val) 
                                            <tr class="font16 dark-grey_txt my-sm-2" id="test">
                                                <td class="font16 dark-grey_txt" data-th="Name">{{ ucwords($val->first_name.' '.$val->last_name) }}</td>
                                                <td data-th="Email">{{ $val->email }}</td>
                                                <td data-th="Mobile Number" class="text-md-center">{{ $val->telephone }}</td>
                                                <td class="text-md-center" data-th="Commission">
                                                    <div class="comission_green font16 font-bold inline-block">{{ (!empty($val->commission_perc) ? $val->commission_perc : '0') }} %</div>
                                                </td>
                                                <?php 
                                                    if($userInfo->user_role == 1){
                                                ?>
                                                <td data-th="Mobile Number" class="text-md-center">
                                                    <select class="form-control inactiveReseller">
                                                        <option value="1" data-id="{{  $val->rec_id }}" <?php if($val->status == 1){echo "selected";}else{echo "";} ?> >Active</option>
                                                        <option value="0" data-id="{{  $val->rec_id }}" <?php if($val->status == 0){echo "selected";}else{echo "";} ?> >In-Active</option>
                                                    </select>
                                                </td>
                                                <?php } ?>
                                                <td clas="text-right" data-th="Actions">
                                                    <div class="float-right">
                                                        <a class="circle_btn d-inline-block mr-auto editReseller" href="<?php echo url('/').'/reseller-edit/'.base64_encode($val->rec_id);?>">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                            <!-- @If($userInfo->user_role == 1)
                                                        <a class=" circle_btn delete d-inline-block mr-auto deleteReseller" href="#" data-name="{{  ucwords($val->first_name.' '.$val->last_name) }}" data-id="<?php echo $val->rec_id; ?>">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                        @endIf -->
                                                        <a class=" circle_btn view d-inline-block mr-auto resellerData" href="<?php echo url('/').'/resellerView/'.base64_encode($val->rec_id);?>">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="">
                                            <td class="norecord_txt" colspan="5">No Records Found</td>
                                        </tr>
                                    @endIf
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="accordion" class="d-lg-none d-block my-3">

                @if($resellers_data->count())
                    @foreach($resellers_data as $val) 
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6 col-5">
                                    {{ ucwords($val->first_name.' '.$val->last_name) }}
                                </div>

                                <div class="col-sm-4 col-5 text-right">
                                    
                                </div>

                                <div class="col-2 text-right">
                                    <a class="card-link" data-toggle="collapse" href="#collapse{{ $loop->iteration }}">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                        <div id="collapse{{ $loop->iteration }}" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                
                                <div class="row my-2">
                                    <div class="col-5 text-blue">Email</div>
                                    <div class="col-1">:</div>
                                    <div class="col-5">{{ $val->email }}</div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-5 text-blue">Mobile Number</div>
                                    <div class="col-1">:</div>
                                    <div class="col-5">{{ $val->telephone }}</div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-5 text-blue">Commission %</div>
                                    <div class="col-1">:</div>
                                    <div class="col-5"><div class="comission_green font16 font-bold inline-block">{{ (!empty($val->commission_perc) ? $val->commission_perc : '0') }} %</div></div>
                                </div>
                                @If($userInfo->user_role == 1)
                                <div class="row my-2">
                                    <div class="col-5 text-blue">Status</div>
                                    <div class="col-1">:</div>
                                    <div class="col-5">
                                        
                                        <select class="form-control inactiveReseller f12">
                                            <option value="1" data-id="{{  $val->rec_id }}" <?php if($val->status == 1){echo "selected";}else{echo "";} ?> >Active</option>
                                            <option value="0" data-id="{{  $val->rec_id }}" <?php if($val->status == 0){echo "selected";}else{echo "";} ?> >In-Active</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                @endIf
                                <div class="text-right mt-4">
                                    <div class="d-inline-block">
                                        <a class="circle_btn d-inline-block mr-auto editReseller" href="https://dev.bestbox.net/reseller-edit/MTIyNA==">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                            <!--                                                         <a class=" circle_btn delete d-inline-block mr-auto deleteReseller" href="#" data-name="Dsfdsf Fdsf" data-id="1224">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                            -->
                                        <a class=" circle_btn view d-inline-block mr-auto resellerData" href="https://dev.bestbox.net/resellerView/MTIyNA==">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <tr class="">
                            <td class="norecord_txt" colspan="5">No Records Found</td>
                        </tr>
                    @endIf
                </div>
            @if($resellers_data->total()>0)
                {{ $resellers_data->appends(['searchKey' =>''])->links() }}
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

        <script>
            $(document).ready(function() {
                $("#show_hide_password a").on('click', function(event) {
                    event.preventDefault();
                    if($('#show_hide_password input').attr("type") == "text"){
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass( "fa-eye-slash" );
                        $('#show_hide_password i').removeClass( "fa-eye" );
                    }else if($('#show_hide_password input').attr("type") == "password"){
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass( "fa-eye-slash" );
                        $('#show_hide_password i').addClass( "fa-eye" );
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function(){
                var url = "<?php echo url('/').'/resellers';?>";
                $(".deleteReseller").click(function(){
                    var id = $(this).attr('data-id');
                    var name = $(this).attr('data-name');
                    swal({
                        title: 'Are you sure you want to delete this Reseller?',
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
                                        'Reseller deleted successfully',
                                        'success'
                                    )
                                }
                            });
                        }
                    }).catch(swal.noop);

                });

                $("#searchKey").keypress(function(event){
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if(keycode == '13'){
                        var searchKey = $("#searchKey").val();
                        location.href = url+'?searchKey='+searchKey;
                    }
                });
            });
            // deleteResellerAgentStatus
            $(".inactiveReseller").on('change', function(e) {
                e.preventDefault();
                var token = "<?php echo csrf_token() ?>";
                var statusID = $(this).val();
                var rec_id = $(this).find(':selected').attr('data-id');
                if(statusID != ""){
                    $.ajax({
                        url: "<?php echo url('/');?>/deleteResellerAgentStatus",
                        method: 'POST',
                        dataType: "json",
                        data: {'rec_id': rec_id,'status': statusID,'action': 'inactiveReseller',"_token": token},
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
    </body>

</html>