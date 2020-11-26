<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Social Media</title>
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
          <h5 class="font16 black_txt font-bold text-uppercase pt-4 pb-3">Admin Users List</h5>
          <?php
             $sdata = Session::get('userData');
            ?>
          <div class="share_btn" style="cursor: pointer;" data-toggle="modal" data-target="#share_modal2"><span class="st-label" style="float: right">Share</span></div>
          <div class="modal fade share_modal" id="share_modal2" role="dialog" >
            <div class="modal-dialog modal-md">
                <div class="modal-content" style="background:#000">
                    <div class="modal-body referal-modal-body text-center" style=" padding-top: 45px; padding-bottom: 15px;" >

                        <div class="col-sm-8 col-md-10 col-xl-8 clearfix "  >
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?php echo url("/").'/customerSignup/'.$sdata['refferallink_text'];?>" data-a2a-title="BestBOX referral link" data-a2a-text="Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.">


                                <ul class="share_icons" >
                                    <li>
                                        <a class="a2a_button_facebook"><i class="reward_icons  share_icon fb">Facebook</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_twitter"><i class="reward_icons  share_icon tw">Twitter</i></a>
                                    </li>

                                    <!-- <li>
                                        <a class="a2a_button_pinterest"><i class="reward_icons share_icon pin">Pinterest</i></a>
                                    </li> -->
                                    <li>
                                        <a class="a2a_button_google_gmail">Gmail</a>
                                    </li>

                                    <!-- <li>
                                        <a class="a2a_button_google_plus"><i class="reward_icons share_icon gg"></i></a>
                                    </li> -->
                                    <li>
                                        <a class="a2a_button_whatsapp">Whatsapp<i class="reward_icons share_icon wtp"></i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_linkedin"><i class="reward_icons share_icon in">Linkedin</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_skype"><i class="reward_icons share_icon skp">Skype</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_email"><i class="reward_icons share_icon skp">Email</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_telegram"><i class="reward_icons share_icon skp">Telegram</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_tumblr"><i class="reward_icons share_icon skp">Tumblr</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_line"><i class="reward_icons share_icon skp">Line</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_outlook_com"><i class="reward_icons share_icon skp">Outlook</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_sms"><i class="reward_icons share_icon skp">SMS</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_slashdot"><i class="reward_icons share_icon skp">Slashdot</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_viber"><i class="reward_icons share_icon skp">Viber</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_yahoo_mail"><i class="reward_icons share_icon skp">Yahoo Mail</i></a>
                                    </li>
                                    <li>
                                        <a class="a2a_button_wechat"><i class="reward_icons share_icon skp">We Chat</i></a>
                                    </li>
                                    <!-- <li>
                                        <a class="a2a_button_facebook_messenger"><i class="reward_icons share_icon skp">Facebook Messenger</i></a>
                                    </li> -->
                                </ul>
                            </div>


                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                <!-- AddToAny END -->
                                <script type="text/javascript">
                                    var a2a_config = a2a_config || {};
                                    a2a_config.templates = a2a_config.templates || {};
                                    a2a_config.templates.email = {
                                        subject: "${title}",
                                        body: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",
                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                                    };
                                    a2a_config.templates.twitter = {
                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."

                                    };
                                    a2a_config.templates.whatsapp = {
                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                                    };
                                    a2a_config.templates.facebook = {
                                        quote: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                                    };
                                    a2a_config.templates.skype = {
                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                                    };
                                    a2a_config.templates.telegram = {
                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                                    };
                                    a2a_config.templates.tumblr = {

                                        content: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy."
                                    };
                                    a2a_config.templates.slashdot = {

                                        text: "${title}",
                                        introtext: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",
                                        response_url: " Here is your referral link: \n ${link}.\n\n "

                                    };
                                    a2a_config.templates.wechat = {


                                        body: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",


                                    };
                                    a2a_config.templates.viber = {


                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",


                                    };
                                    a2a_config.templates.sms = {


                                        body: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",


                                    };
                                    a2a_config.templates.line = {


                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Start your free trial from the dashboard. \n\n 3. After successful trial, order your preferred package \n\n As easy as that. \n\n Enjoy.",


                                    };
                                    /*a2a_config.templates.facebook_messenger = {

                                        text: " Here is your referral link: \n ${link}.\n\n 3 steps to getting your BestBOX \n\n 1. Open link above and create your account. \n\n 2. Activate your account from your auto-generated email you will receive. \n\n 3. Inside your dashboard, order your preferred package \n\n As easy as that. \n\n Enjoy."
                                    };*/

                                </script>




                        </div>
                    </div>
                    <div class="modal-footer referal-modal-footer" style="text-align: center !important; border-top:none;padding-top: 0;padding-bottom: 30px;" >
                        <button type="button" class="btn btn-buy referal-modal-btn" data-dismiss="modal" style="background-color: #2eb93f; color: #fff;">Close</button>
                    </div>
                </div>
            </div>
        </div>

        </section>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

<script>

  </script>
</body>
</html>
