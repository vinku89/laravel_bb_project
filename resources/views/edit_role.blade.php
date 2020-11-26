<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BestBOX - Role Update</title>
  <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
  <!-- All styles include -->
  @include("inc.styles.all-styles")
  <style type="text/css">
    ul{
      text-align: left;
        line-height: 25px;
        font-size: 16px;
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

      <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item f16 active">
                <a href="<?php echo url('/rolesList');?>" class="f16 position-relative breadcrumb_pd">
                    <i class="fas fa-angle-left"></i>
                    Edit Role
                 </a>
        </li>
        </ol>
    </nav>

      <div class="middle_box">
        <form action="/updateRole" method="post" class="needs-validation" novalidate>
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <div class="row">
          <div class="col-lg-7 col-md-12 border-right pr-0 py-3 box-padding">

            <div class="col-lg-12">
              <div class="col-lg-9">
                <div class="form-group">
                  <input type="text" class="form-control" name="roleTitle" id="roleTitle" placeholder="Role Title"
                    value="<?php echo $user_role['role_name'];?>" required style="height:44px;">
                  <div class="invalid-feedback">
                    Please Provide Role Title.
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-control resize-none" name="roleDesc" id="roleDesc" cols="30" rows="5"
                    placeholder="Role Description" required><?php echo $user_role['description'];?></textarea>
                  <div class="invalid-feedback">
                    Please Provide Role Description.
                  </div>
                </div>
                <?php /*<div class="form-group col-sm-5 pl-0">
                  <select id="select_status" name="status" required class="form-control">
                    <option value="1" <?php if($user_role['status']==1){ echo "selected";} ?>>Active</option>
                    <option value="0" <?php if($user_role['status']==0){ echo "selected";} ?>>Inactive</option>
                  </select>
                </div> */ ?>
              </div>
            </div>
            <div class="col-lg-12">
              <h5 class="font16 black_txt font-bold text-uppercase py-3 pl-3">Permissions</h5>

              <!-- Permission section -->
              <div class="border-top pt-4">
                  <input type="hidden" name="menuname[]" value="parent_1">
                <?php
                      foreach ($menu_arr as $m) {
                    ?>
                <div class="feature_body py-3 px-3 border-bottom">
                  <div class="row">
                    <div class="col-9">
                      <div class="<?php if($m['level']=='parent'){ echo 'font-bold';}else{ echo "pl-3";} ?>">
                        <?php echo $m['name'];?></div>
                    </div>
                    <div class="col-3 text-right">
                      <label class="switch">

                        <?php
                      $parent_menus_arr=explode(",",$user_role['parent_menus']);
                      $child_menus_arr=explode(",",$user_role['child_menus']);
                      $all_menus_arr=array_merge($parent_menus_arr,$child_menus_arr);
                      if(in_array($m['id'], $all_menus_arr)){
                    ?>
                        <input type="checkbox" name="menuname[]" checked <?php if($m['id'] == 1) echo 'disabled';?>
                          class="menucheck <?php if($m['level']=='parent'){ echo 'parent';}?> child<?php echo $m['parent_id'];?>"
                          id="menu_<?php echo $m['parent_id'].'_'.$m['id'];?>"
                          value="<?php if($m['level']=='parent'){ echo 'parent_'.$m['id']; }else{ echo 'child_'.$m['id'];}?>">
                        <?php
                                  }else{
                                ?>
                        <input type="checkbox" name="menuname[]" <?php if($m['id'] == 1) echo 'checked disabled';?>
                          class="menucheck <?php if($m['level']=='parent'){ echo 'parent';}?> child<?php echo $m['parent_id'];?>"
                          id="menu_<?php echo $m['parent_id'].'_'.$m['id'];?>"
                          value="<?php if($m['level']=='parent'){ echo 'parent_'.$m['id']; }else{ echo 'child_'.$m['id'];}?>">
                        <?php
                                  }
                                ?>
                        <span class="slider round"></span>
                      </label>
                    </div>
                  </div>
                </div>
                <?php
                      }
                    ?>
              </div>
            </div>
            </div>
            <!--  User section -->
            <div class="col-lg-5 col-md-12 box-pdleft">
              <h5 class="font16 black_txt font-bold text-uppercase py-3">User</h5>
              <div class="form-group">
                <?php
                  foreach($usersList as $user) {?>
                <div class="w-100 clearfix py-2 border-bottom" id="delUser{{ $user->rec_id }}">
                  <div class="col-lg-12 pl-0">{{ $user->email }}
                    <span class="deleteUser float-right" attr-data="<?php echo $user->rec_id;?>"><i class="fa fa-trash"
                        aria-hidden="true"></i></span>
                    <br /><span class="f13">{{ $user->name }}</span>
                  </div>
                </div>
                <?php }?>
                <div id="addNewUsersList"></div>
                <input type="hidden" value="" id="deletedUsersList" name="deletedUsersList" />
                <input type="hidden" value="" id="addUsersList" name="addUsersList" />
              </div>
              <div>
                <div class="form-group">
                  <input type="text" class="form-control border-bottom-only" name="userEmail" id="userEmail"
                    placeholder="Email" value="" style="height:44px;">
                  <div id="emailErr" class="error"></div>
                  <span class="btn btn_primary" id="addUserEmail">Add</span>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix">


            <!-- Save section -->
            <div class="col-12 pb-5">
              <div class="col-12 border-top text-center pt-4 clearfix">
                <div class="display-inline">
                  <a href="{{ url('/').'/rolesList' }}" class="btn_cancel float-left mr-2">CANCEL</a>
                  <input type="hidden" name="role_id" value="{{ $role_id }}" />
                  <button type="submit" class="btn btn_primary float-left">UPDATE</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

    </section>
  </div>
  <!-- All scripts include -->
  @include("inc.scripts.all-scripts")
  <?php
        if(Session::has('alert') && Session::get('alert') == 'Success'){
    ?>
  <script type="text/javascript">
    setTimeout(function () {
      swal({
        title: "Success",
        text: "<?php echo Session::get('result');?>",
        type: "success"
      }).then((result) => {
        location.href="<?php echo url('/rolesList');?>";
      });
    }, 50);
  </script>
  <?php
        }
    ?>

    <?php
    if(Session::has('alert') && Session::get('alert') == 'Error'){
    ?>
      <script type="text/javascript">
        setTimeout(function () {
        swal({
        title: "Error",
        text: "<?php echo Session::get('result');?>",
        type: "error"
        });
        }, 50);
      </script>
    <?php
      }
    ?>
  <script>
    $(".menucheck").click(function () {
      var menuid = $(this).attr("id");
      var mtemp = menuid.split("_");
      if ($(this).hasClass("parent")) {
        if ($(this).is(":checked")) {
          $(".child" + mtemp[1]).prop("checked", true);
        } else if ($(this).is(":not(:checked)")) {
          $(".child" + mtemp[1]).prop("checked", false);
        }
      } else {
        var classlength = $(".child" + mtemp[1]).length;
        var mlength = 0;
        var nclength = 0;
        $("input.child" + mtemp[1] + ":checkbox").each(function () {
          mlength = $("input.child" + mtemp[1] + ":checkbox:checked").length;
          nclength = $("input.child" + mtemp[1] + ":checkbox:not(:checked)").length;
        });
        if (mlength == 1) {
          if ($(".parent.child" + mtemp[1]).is(":not(:checked)")) {
            $(".parent.child" + mtemp[1]).prop("checked", true);
          }
        }
        if (mlength == 1 && nclength == classlength - 1) {
          if ($(this).is(":not(:checked)") && $(".parent.child" + mtemp[1]).is(":checked")) {
            $(".child" + mtemp[1]).prop("checked", false);
          }
        }
      }
    });
    $(document).ready(function () {
      var deletedUsers = [];
      var usersList = [];
      $('body').on('click', '.deleteUser', function (e) {
        e.preventDefault();
        var val = $(this).attr('attr-data');
        deletedUsers.push(val);
        for (var i=0; i<usersList.length; i++) {
          if(usersList[i] == val){
            usersList.splice(i, 1);
            $("#addUsersList").val(usersList);
          }
        }
        $("#deletedUsersList").val(deletedUsers);
        $("#delUser" + val).css('display', 'none');
      });

      $('body').on('click', "#addUserEmail",function (e) {
        e.preventDefault();
        $("#emailErr").html('');
        var email = $("#userEmail").val();
        var user_role = "<?php echo $user_role['id'];?>";
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email) || email == '') {
          $("#emailErr").html('Enter valid Email Address');
          return false;
        } else {
          var csrf_Value = "<?php echo csrf_token(); ?>";
          $.ajax({
            url: "<?php echo url('/');?>/checkEmailForRoleAssign",
            method: 'POST',
            dataType: "json",
            data: {
              'email': email,
              'user_role': user_role,
              "_token": csrf_Value
            },
            success: function (data) {
              $("#emailErr").html("");
              $("#userEmail").val('');
              var result = data.Result;
              if (data.status == "Success") {
                var data = '<div class="w-100 clearfix py-2 border-bottom" id="delUser' + result.rec_id +
                  '">';
                data += '<div class="col-lg-12 pl-0">' + result.email;
                data += '<span class="deleteUser float-right" attr-data="' + result.rec_id +
                  '"><i class="fa fa-trash" aria-hidden="true"></i></span>';
                data += '<br/><span class="f13">' + result.first_name + ' ' + result.last_name +
                '</span>';
                data += '</div>';
                data += '</div>';
                if(jQuery.inArray(result.rec_id, usersList)){
                  $("#addNewUsersList").append(data);
                  usersList.push(result.rec_id);
                  $("#addUsersList").val(usersList);
                }
              } else {
                if (data.flag == 1) {
                  if (confirm("This email already assigned to " + data.rolename +
                      " role. Are you sure to change it?")) {

                    var data = '<div class="w-100 clearfix py-2 border-bottom" id="delUser' + result
                      .rec_id + '">';
                    data += '<div class="col-lg-12 pl-0">' + result.email;
                    data += '<span class="deleteUser float-right" attr-data="' + result.rec_id +
                      '"><i class="fa fa-trash" aria-hidden="true"></i></span>';
                    data += '<br/><span class="f13">' + result.first_name + ' ' + result.last_name +
                      '</span>';
                    data += '</div>';
                    data += '</div>';
                    if(jQuery.inArray(result.rec_id, usersList)){
                      $("#addNewUsersList").append(data);
                      usersList.push(result.rec_id);
                      $("#addUsersList").val(usersList);
                    }
                  }
                } else {
                  setTimeout(function () {
                    swal({
                      title: "Error",
                      text: data.Result,
                      type: "error"
                    });
                  }, 50);
                }
              }
            }
          });
        }
      });
    });
  </script>
  <script>
    (function () {
      window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
            var gender = $("#gender").val();
            if (gender == "") {
              $("#gender_err").html("Please select gender");
            } else {
              $("#gender_err").html("");
            }
            var country = $("#select_country").val();
            if (country == "") {
              $("#country_err").html("Please select country");
            } else {
              $("#country_err").html("");
            }
            var role = $("#select_role").val();
            if (role == "") {
              $("#role_err").html("Please select role");
            } else {
              $("#role_err").html("");
            }
            $('#emailErr').html("");
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>
