<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BestBOX - Add Role</title>
  <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
  <!-- All styles include -->
  @include("inc.styles.all-styles")
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
                    CREATE NEW ROLES & PERMISSIONS
                 </a>
        </li>
        </ol>
    </nav>


      <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fas fa-chevron-left"></i>
                        <a href="#">Home</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
            </nav> -->

      <div class="middle_box">
        <form action="/createRole" method="post" class="needs-validation" novalidate>
          <div class="row">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="col-lg-7 col-md-12 border-right pr-0 py-3 box-padding">
              <div class="px-3 row">
                <div class="col-lg-9">
                  <div class="form-group">
                    <input type="text" class="form-control" name="roleTitle" id="roleTitle" placeholder="Role Title"
                      required="" style="height:44px;">
                    <div class="invalid-feedback">
                      Please Provide Role Title.
                    </div>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                  </div>
                  <div class="form-group">
                    <textarea class="form-control resize-none" name="roleDesc" id="roleDesc" cols="30" rows="5"
                      placeholder="Role Description" value="Super Admin Role Have all menus accesss"
                      required=""></textarea>
                    <div class="invalid-feedback">
                      Please Provide Role Description.
                    </div>
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                  </div>
                </div>
              </div>

            </div>
            <!-- Add User section -->
            <div class="col-lg-5 col-md-12 box-pdleft">
              <!-- <h5 class="font16 black_txt font-bold text-uppercase py-3">User</h5> -->

              <!--<button type="button" class="big_blue_btn" data-toggle="modal" data-target="#addUser">
                Add User
              </button>-->
              <div id="addedUsersList"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-7 col-md-12 border-right py-3 box-padding">
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
                        <input type="checkbox" name="menuname[]" <?php if($m['id'] == 1) echo 'checked disabled';?>
                          class="menucheck <?php if($m['level']=='parent'){ echo 'parent';}?> child<?php echo $m['parent_id'];?>"
                          id="menu_<?php echo $m['parent_id'].'_'.$m['id'];?>"
                          value="<?php if($m['level']=='parent'){ echo 'parent_'.$m['id']; }else{ echo 'child_'.$m['id'];}?>">
                        <span class="slider round"></span>
                      </label>
                    </div>

                  </div>
                </div>
                <?php
                      }
                    ?>
              </div>
              <!-- Permission section End -->

            </div>
            <!-- Save section -->
            <div class="col-12 pb-5">
              <div class="col-12 border-top text-center pt-4">
                <input type="hidden" name="users" id="users" value="" />
                <button type="submit" class="btn btn_primary">SAVE</button>
              </div>

            </div>

          </div>
        </form>
      </div>
    </section>
  </div>

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
            <!-- First Name -->
            <div class="form-group">
              <input type="text" class="form-control border-bottom-only body_bg" id="first_name" name="first_name"
                aria-describedby="first_name" placeholder="First Name" value="" minlength="3" maxlength="255" required>
              <div class="text-right f14"><span class="text-danger">*</span><span id="first_name"
                  class="text-muted f14 black_txt">First Name</span></div>
              <div class="invalid-feedback">
                First Name required with atleast 3 characters.
              </div>
            </div>

            <!-- Last Name -->
            <div class="form-group">
              <input type="text" class="form-control border-bottom-only body_bg" id="last_name" name="last_name"
                aria-describedby="last_name" placeholder="Last Name" value="" minlength="3" maxlength="255" required>
              <div class="text-right f14"><span class="text-danger">*</span><span id="last_name"
                  class="text-muted f14 black_txt">Last Name</span></div>
              <div class="invalid-feedback">
                Last Name required with atleast 3 characters.
              </div>
            </div>

            <!-- Email -->
            <div class="form-group">
              <input type="email" pattern="[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})"
                class="form-control border-bottom-only body_bg" id="email" name="email" aria-describedby="email"
                placeholder="Email" value="" required>
              <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                  class="text-muted f14 black_txt">Email</span></div>
              <div class="invalid-feedback">
                Please Provide Valid Email Id.
              </div>
              <span class="f14" id="emailErr"></span>
            </div>

            <!-- Country -->
            <div class="mobile_menu_section body_bg form-group">
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
                  <input type="text" class="form-control border-bottom-only body_bg" placeholder="Code"
                    aria-label="Mobile number" aria-describedby="basic-addon2" value="" name="country_code"
                    id="country_code" readOnly>
                </div>
              </div>
              <div class="col-9">
                <div class="input-group mb-3">
                  <input type="text" class="form-control border-bottom-only  body_bg" placeholder="Mobile Number"
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
            <div class="my-4">
              <div class="display_inline">
                <button type="submit" class="btn btn_primary  d-block w-100 mt-4 ">CREATE</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
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

  <script type="text/javascript">
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

    $(document).ready(function () {
      var deletedUsers = [];
      var usersList = [];
      $(".deleteUser").click(function () {
        //console.log('hi');
        var val = $(this).attr('attr-data');
        deletedUsers.push(val);
        $("#delUser" + val).css('display', 'none');
      });


      $("#create_user").submit(function (e) {0
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(), // serializes the form's elements.
          dataType: "json",
          success: function (data) {
            if (data.status == 'Success') {
              var result = data.Result;
              var data = '<div class="w-100 clearfix py-2 border-bottom" id="delUser' + result.rec_id +
                '">';
              data += '<div class="col-lg-12 pl-0">' + result.email;
              data += '<span class="deleteUser float-right" attr-data="' + result.rec_id +
                '"><i class="fa fa-trash" aria-hidden="true"></i></span>';
              data += '<br/><span class="f13">' + result.name + '</span>';
              data += '</div>';
              data += '</div>';

              $("#addedUsersList").append(data);
              usersList.push(result.rec_id);
              $("#users").val(usersList);
              $("#addUser").modal('hide');
              $('#create_user')[0].reset();
            } else {
              $("#addUser").modal('hide');
              alert('User Not added');
              $('#create_user')[0].reset();
            }
          }
        });
      });
    });
  </script>
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
        /*if(mlength==classlength-1 && nclength==1){
          if($(this).is(":checked")){
            $(".child"+mtemp[1]).prop( "checked", true );
          }
        }*/
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
