<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Role Permissions</title>
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
        <section class="main_body_section scroll_div container-fluid p-0">
            <div class="px-3 border-bottom"><h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Roles and Permissions</h5></div>
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

            <div class="row mx-0 border-bottom bg-white" style="min-height: calc(100vh - 130px);">
                <div class="col-12 col-md-8 m-0 px-0 order-2 order-md-1">
                    <div class="feature_heading border-bottom py-2 px-3">
                        <div class="w65 d-inline-block">Roles</div>
                        <div class="w20 d-inline-block text-center">Members</div>
                        <div class="w10 d-inline-block text-center">&nbsp</div>
                    </div>

                    <?php
                        foreach ($user_roles as $ur) {
                    ?>
                        <div class="feature_body py-2 px-3 border-bottom">
                            <div class="w65 d-inline-block">
                                <div class="d-block f16 font-bold"><?php echo $ur['role_name'];?></div>
                                <div class="d-block f13"><?php echo $ur['description'];?></div>
                            </div>
                            <div class="w20 d-inline-block text-center"><?php echo $ucount[$ur['id']];?></div>
                            <div class="w10 d-inline-block text-center">
                                <?php if($ur['id'] != 1){?>
                                <form action="/editRole/<?php echo encrypt($ur['id']);?>" method="post">
                                  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                  <button type="submit" style="border:0px;background: none"> <img src="<?php echo url('/');?>/public/images/detail_icon.png" class="" style="max-width: 30px;"/></button>
                                </form>
                            <?php }?>
                             </div>
                        </div>
                    <?php
                        }
                    ?>


                </div>
                <div class="col-md-4 m-0 px-0 order-1 order-md-2" style="border-left: 1px solid #E2E2E2; ">
                    <div class="feature_heading border-bottom py-2 px-3">
                        <div class="w100 font-bold f16">
                            CREATE NEW ROLES
                        </div>
                    </div>


                    <div class="feature_body py-2 px-3">
                        <div class="d-inline-block text-left">
                            <p>Predefine roles and permissions from the scratch.</p>
                            <div>
                                <a href="<?php echo url('/');?>/addRole" class="btn btn_primary">Create New Role</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
</body>
</html>
