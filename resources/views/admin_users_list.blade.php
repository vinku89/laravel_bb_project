<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Admin Users List</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")

     <style>
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

      .dk-option {
        padding: 5px 0.5em;
        border-bottom: solid 1px #E3ECFB;
        font-size: 16px;
    }
    .select2-container--default .select2-selection--single{
            background-color:transparent !important;
            border:none !important;
            border-bottom: solid 3px #7f868b !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single{
            height:33px !important;
        }
        .select2-selection__rendered[title="Select Country"]{
            font-size:14px !important;
            color: #737a82 !important;
        }

        .select2-container[dir="ltr"]{
            width:100% !important;
        }
        ul{
        text-align: left;
        line-height: 25px;
        font-size: 16px;
        text-decoration: none;
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
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3 mb-0">Admin Users List</h5>

          <div class="my-2 text-right">
            <button type="button" class="big_blue_btn" data-toggle="modal" data-target="#addUser">
              Add User
            </button>
          </div>

          <div class="middle_box clearfix">
            <div class="grid_wrp add-user-grid">
              @if(count($admin_users) > 0)
              <div class="grid_header clearfix pt-3 pb-3 d-lg-block d-none">
                <div class="w10 float-left font16 font-bold blue_txt">S.No</div>
                <div class="w25 float-left font16 font-bold blue_txt pl-2">User Name</div>
                <div class="w30 float-left font16 font-bold blue_txt pl-2">Email</div>
                <div class="w15 float-left font16 font-bold blue_txt pl-2">Role</div>
                <div class="w10 float-left font16 font-bold blue_txt pl-2 text-lg-center">Status</div>
                <!-- <div class="w10 float-left font16 font-bold blue_txt pl-2 text-lg-center">Action</div> -->
              </div>
              <div class="grid_body clearfix">
                <!--Row 1-->

                <?php
                $i=1;
                  foreach($admin_users as $au){

                ?>
                <div class="grid_row clearfix border-top">
                    <div class="w10-md grid_td_info">
                        <span class="mob_title blue_txt d-block d-lg-none">S.No</span>
                        <?php echo $i;?>
                    </div>
                    <div class="w25-md grid_td_info word-break">
                        <span class="mob_title blue_txt d-block d-lg-none">User Name</span>
                        <?php echo $au['first_name']." ".$au['last_name'];?>
                    </div>
                    <div class="w30-md grid_td_info word-break-all">
                      <span class="mob_title blue_txt d-block d-lg-none">Email</span>
                        <?php echo $au['email'];?>
                    </div>
                    <div class="w15-md grid_td_info">
                    <span class="mob_title blue_txt d-block d-lg-none">Role</span>
                        <?php echo isset($au['role_name']) ? $au['role_name'] : '-';?>
                    </div>
                    <div class="w10-md grid_td_info text-lg-center">
                        <span class="mob_title blue_txt d-block d-lg-none">Status</span>
                        <select class="mb-2 f12 userstatus" name="userstatus" id="userstatus" >
                          <option value="1"  <?php if($au['status']==1) echo 'selected';?> data-id="<?php echo $au['rec_id'];?>">ACTIVE</option>
                          <option value="0"  <?php if($au['status']==0) echo 'selected';?> data-id="<?php echo $au['rec_id'];?>">INACTIVE</option>
                        </select>
                        <?php
                          // if($au['status']==1){
                          //   echo "Active";
                          // }else{
                          //   echo "Inactive";
                          // }
                        ?>
                    </div>
                    <!--<div class="w10-md grid_td_info text-lg-center">
                        <span class="mob_title blue_txt d-block d-lg-none">Action</span>
                        <span class="editUserData" data-recid="<?php echo $au['rec_id'];?>"> <i class="fas fa-edit"></i></span>
                    </div>-->
                </div>
                <?php
                $i++;
                  }
                ?>
                <!--Row 2-->
              </div>
              @else
                   <div class="w100 norecord_txt">No Records Found</div>
              @endif
            </div>
          </div>
        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <div class="modal fade" id="addUser" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add User</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="post" id="create_user" name="create_user" action="<?php echo url('/').'/createUser';?>"
                class="needs-validation" novalidate>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                <!-- Email -->
                <div class="form-group">
                    <input type="email" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})"
                      class="form-control border-bottom-only" id="email" name="email" aria-describedby="email"
                      placeholder="Email" value="" required>
                    <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                        class="text-muted f14 black_txt">Email</span></div>
                    <div class="invalid-feedback">
                      Please Provide Valid Email Id.
                    </div>
                    <span class="f14" id="emailErr"></span>
                  </div>

                <!-- First Name -->
                <div class="form-group">
                  <input type="text" class="form-control border-bottom-only " id="first_name" name="first_name"
                    aria-describedby="first_name" placeholder="First Name" value="" minlength="3" maxlength="255" required>
                  <div class="text-right f14"><span class="text-danger">*</span><span id="first_name"
                      class="text-muted f14 black_txt">First Name</span></div>
                  <div class="invalid-feedback">
                    First Name required with atleast 3 characters.
                  </div>
                </div>

                <!-- Last Name -->
                <div class="form-group">
                  <input type="text" class="form-control border-bottom-only " id="last_name" name="last_name"
                    aria-describedby="last_name" placeholder="Last Name" value="" minlength="3" maxlength="255" required>
                  <div class="text-right f14"><span class="text-danger">*</span><span id="last_name"
                      class="text-muted f14 black_txt">Last Name</span></div>
                  <div class="invalid-feedback">
                    Last Name required with atleast 3 characters.
                  </div>
                </div>

                <!-- Country -->
                <div class="mobile_menu_section  form-group">
                  <select id="select_country" name="country" required>
                    <option value="">Select Country</option>
                    <?php
                            foreach ($country_data as $val) {
                                echo "<option value='".$val->countryid."' data-id='".$val->currencycode."'>".$val->country_name."</option>";
                            }
                        ?>
                  </select>
                  <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                      class="text-muted f14 black_txt">Country</span></div>
                  <div id="country_err" class="f14 red_txt"></div>
                </div>

                <!-- Mobile Number -->
                <div class="form-group row">
                  <div class="col-3">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control border-bottom-only " placeholder="Code"
                        aria-label="Mobile number" aria-describedby="basic-addon2" value="" name="country_code"
                        id="country_code" readOnly>
                    </div>
                  </div>
                  <div class="col-9">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control border-bottom-only  " placeholder="Mobile Number"
                        aria-label="Mobile number" aria-describedby="basic-addon2" id="mobile" name="mobile" value=""
                        pattern="[0-9]{8,14}" required>
                      <div class="invalid-feedback">
                        Please Provide Correct Mobile Number.
                      </div>
                      <div class="text-right f14 w-100 pt-2">
                        <span id="telErrorMsg" class="f14 error_txt"></span>
                        <span class="text-danger">*</span><span id="emailHelp" class="text-muted f14 black_txt">Mobile
                          number</span>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="my-2">
                  <div class="display_inline">
                    <button type="submit" class="btn btn_primary  d-block w-100 mt-1">CREATE</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
     <!-- The Modal -->


  <script type="text/javascript">
     $('#select_country').select2();
    $("#select_country").change(function (e) {
      var country_code = $('option:selected', this).attr('data-id');
      $("#country_code").val('+' + country_code);
    });
    $("#email").blur(function () {
      var email = $(this).val();
      var csrf_Value = "<?php echo csrf_token(); ?>";
      $.ajax({
        url: "<?php echo url('/');?>/checkEmailExist",
        method: 'POST',
        dataType: "json",
        data: {
          'email': email,
          "_token": csrf_Value
        },
        success: function (data) {

          if (data.status == "Not valid") {
            $("#emailErr").html("");
          } else if (data.status == "Success") {
            $("#emailErr").html(data.Result);
            $("#emailErr").addClass("green_txt").removeClass("red_txt");
          } else {
            $("#emailErr").html(data.Result);
            $("#email").val("");
            $("#emailErr").addClass("red_txt").removeClass("green_txt");
          }

        }
      });
    });

    $("#mobile").on("keypress keyup blur", function (event) {
      $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
      }
    });

    (function() {
        window.addEventListener('load', function() {
          var forms = document.getElementsByClassName('needs-validation');

          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              //console.log(form.checkValidity());
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }

              form.classList.add('was-validated');
              var country = $("#select_country").val();
               if(country == ""){
                $("#country_err").html("Please select country");
              }else{
                $("#country_err").html("");
              }
              $('#emailErr').html("");

            }, false);

          });

        }, false);
      })();

    $(document).ready(function () {
      var deletedUsers = [];
      var usersList = [];
      $(".deleteUser").click(function () {
        //console.log('hi');
        var val = $(this).attr('attr-data');
        deletedUsers.push(val);
        $("#delUser"+val).css('display', 'none');
      });


    $("#create_user").submit(function (e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var flag = false;
      var form = $(this);
      var url = form.attr('action');

      var email = $.trim($("#email").val());
      var first_name = $.trim($("#first_name").val());
      var last_name = $.trim($("#last_name").val());
      var country = $.trim($("#select_country").val());
      var country_code = $.trim($("#country_code").val());
      var mobile = $.trim($("#mobile").val());
      if(email == '')  flag = true;
      if(first_name == '')  flag = true;
      if(last_name == '')  flag = true;
      if(country == '')  flag = true;
      if(country_code == '')  flag = true;
      if(mobile == '')  flag = true;
      if(flag) return false;
      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        dataType: "json",
        success: function (data) {
          if (data.status == 'Success') {
            var result = data.Result;

            $("#addUser").modal('hide');
            $('#create_user')[0].reset();
            setTimeout(function() {
                swal({
                    title: "Success",
                    html: data.Result,
                    type: "success"
                }).then((result) => {
                  location.reload();
                });
            }, 50);
            //location.reload();
          } else {
            $("#addUser").modal('hide');
            setTimeout(function() {
                swal({
                    title: "Error",
                    html: data.Result,
                    type: "error"
                });
            }, 50);
            $('#create_user')[0].reset();
          }
        }
      });
    });

    $(".editUserData").click(function(e){
      e.preventDefault();
      $("#statusErrMsg").html('');
      var rec_id = $(this).attr('data-recid');
      var csrf_Value = "<?php echo csrf_token(); ?>";
      $.ajax({
        type: "POST",
        url: "<?php echo url('/').'/getUserData';?>",
        data: { 'rec_id' : rec_id ,"_token": csrf_Value }, // serializes the form's elements.
        dataType: "json",
        success: function (data) {
          if (data.status == 'Success') {
            var result = data.Result;
            $("#username").val(result.first_name+' '+result.last_name);
            $("#useremail").val(result.email);
            $("#editUserId").val(result.rec_id);
            console.log(result.status);
            $('#userstatus option[value="'+result.status+'"]').attr("selected", "selected");
            $("#editUser").modal('show');
          } else {
            $("#editUser").modal('hide');
            alert('User Not added');
            $('#edit_user')[0].reset();
          }
        }
      });
    });

    $(".userstatus").on('change',function(e){
      e.preventDefault();
      //$("#statusErrMsg").html('');
      var rec_id = $('option:selected', this).attr('data-id');
      var status = $('option:selected', this).val();
      if(status == '') {
        alert('Please select status');
        return false;
      }
      var csrf_Value = "<?php echo csrf_token(); ?>";
      $.ajax({
        type: "POST",
        url: "<?php echo url('/').'/updateUserStatus';?>",
        data: { 'rec_id' : rec_id ,'status' : status, "_token": csrf_Value }, // serializes the form's elements.
        dataType: "json",
        success: function (data) {
          if (data.status == 'Success') {
            //$("#editUser").modal('hide');
            location.reload();
          } else {
            //$("#editUser").modal('hide');
            alert('User Not Updated');
            location.reload();
            $('#edit_user')[0].reset();
          }
        }
      });
    });
  });
  </script>
</body>
</html>
