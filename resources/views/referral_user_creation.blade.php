<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Referral User Creation</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
</head>
<body>

    <div class="main-content">

        <section class="main_body_section scroll_div">

            <h5 class="font16 font-bold text-uppercase black_txt pt-4 mb-5">Referral User</h5>
            <div class="row">
                <div class="col-md-6">

                </div>
            </div>
            <div class="text-center f14">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ strip_tags(str_replace("'",'',$errors->first())) }}
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <div class="error-wrapper badge-danger my-2">
                        <?php echo Session::get('message');?>
                        </div>
                    @endIf
                </div>
            <div class="clearfix ">
                <div class="row">
                    <div class="col-lg-6 col-xl-4 col-md-8">
                        <!-- <table class="rwd-table body_bg">

                        </table> -->
                        <form method="post" id="create_form" name="create_form" action="<?php echo url('/').'/saveReferralUser';?>">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <!-- Agent Email -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg" id="referralId" name="referralId"
                                    aria-describedby="email" value="{{ $referralId }}">
                                <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                                        class="text-muted f14 black_txt">Referral Id</span></div>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control border-bottom-only body_bg" id="email" name="email"
                                    aria-describedby="email" placeholder="Email" value="">
                                <div class="text-right f14"><span class="text-danger">*</span><span id="email"
                                        class="text-muted f14 black_txt">Customer Email</span></div>
                            </div>

                            <!-- First Name -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg" id="first_name"  name="first_name"
                                    aria-describedby="first_name" placeholder="First Name" value="">
                                <div class="text-right f14"><span class="text-danger">*</span><span id="first_name"
                                        class="text-muted f14 black_txt">First Name</span></div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg"  id="last_name"  name="last_name"
                                    aria-describedby="last_name" placeholder="Last Name" value="">
                                <div class="text-right f14"><span class="text-danger">*</span><span id="last_name"
                                        class="text-muted f14 black_txt">Last Name</span></div>
                            </div>

                            <div class="my-4">
                                <div class="display_inline">
                                    <button type="submit" class="btn button-primary btn_cancel d-block w-100 mt-4 " >Join</button>
                                </div>
                            </div>

                    </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script type="text/javascript">
    $("#select_country").change(function(e) {
        var country_code =  $('option:selected', this).attr('data-id');
        $("#country_code").val('+'+country_code);
    });
    </script>
</body>
</html>
