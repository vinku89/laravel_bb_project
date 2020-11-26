<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <!-- START HEADER/BANNER -->
    <tbody>
            <tr>
                    <td height="50">&nbsp;</td>
                </tr>
        <tr>
            <td align="center">
                <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td align="center" valign="top"
                                style="background-image: linear-gradient(0deg, #540481 0%, #C40072 69%, #EB772F 100%); background-color: #A02C72;">
                                <table class="col-600" width="600" border="0" align="center" cellpadding="0"
                                    cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td height="90">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" cellpadding="0" cellspacing="0" border="0" style="padding-bottom: 40px;" >
                                                <img src="<?php echo url('/');?>/public/images/white-logo.png" width="200">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="font-family: 'Century Gothic', sans-serif; font-size:20px;color:#ffffff;text-transform:uppercase; line-height:24px; font-weight: 700;">
                                                Account Verify
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="50">&nbsp;</td>
                                        </tr>
                                        <tr>
                                                <td>
                                                  <table border="0" cellpadding="0" cellspacing="0" align="center" >
                                                    <tr>
                                                      <td style="width:50px">&nbsp;</td>
                                                      <td>
                                                          <table  width="500" border="0" cellpadding="0" cellspacing="0" align="center" >
                                                             <tbody>
                                                                 <tr>
                                                                     <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:20px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                          Hi <?php echo ucwords($useremail['name']); ?>,
                                                                  </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td cellpadding="0" cellspacing="0" height="30">
                                                                          &nbsp;
                                                                     </td>
                                                                 </tr>

                                                                 <tr>
                                                                      <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">

                                                                              Welcome to BestBOX, Please be informed that your <?php echo $useremail['type'];?> account has been created. Please click on the  below link to verify your account.
                                                                   </td>
                                                                   </tr>

                                                                   <tr>
                                                                      <td cellpadding="0" cellspacing="0" height="30">
                                                                          &nbsp;
                                                                     </td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            Please find below user details.
                                                                    </td>
                                                                 </tr>
                                                                  <tr>
                                                                      <td cellpadding="0" cellspacing="0" height="10">
                                                                          &nbsp;
                                                                     </td>
                                                                 </tr>
                                                                   <?php
                                                                    $web_login = url('/');
                                                                    if($useremail['type'] == "Customer"){
                                                                      $web_login = url('/').'/customerLogin';
                                                                      ?>
                                                                     <tr>
                                                                        <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                                Web Link : <a href="<?php echo url('/');?>/customerLogin" style="color:#fff !important;text-decoration: none;"><?php echo url('/');?>/customerLogin</a>
                                                                        </td>
                                                                     </tr>
                                                                   <?php }else if($useremail['type'] == "Admin User"){
                                                                        $web_login = url('/').'/Admin';
                                                                    ?>
                                                                    <tr>
                                                                        <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                                Web Link : <a href="<?php echo url('/');?>/Admin" style="color:#fff !important;text-decoration: none;"><?php echo url('/');?>/Admin</a>
                                                                        </td>
                                                                     </tr>
                                                                   <?php }else{
                                                                          $web_login = url('/').'/login';
                                                                    ?>
                                                                    <tr>
                                                                        <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                                Web Link : <a href="<?php echo url('/');?>/login" style="color:#fff !important;text-decoration: none;"><?php echo url('/');?>/login</a>
                                                                        </td>
                                                                     </tr>
                                                                   <?php }?>
                                                                <?php if($useremail['type'] == "Customer"){?>
                                                                <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            User Id / Email Id : <span style="color:#ffffff !important;text-decoration: none;font-weight: 400;">
                                                                              <span style="color:#ffffff !important;font-weight: bold;"><?php echo $useremail['customer_id']; ?></span> /
                                                                              <a href="mailto:<?php echo $useremail['email']; ?>" style="color:#ffffff !important;text-decoration: none;font-weight: bold;" target="_blank"><?php echo $useremail['email']; ?></a>
                                                                              </span>
                                                                    </td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            Password : <strong><?php echo $useremail['password']; ?></strong>
                                                                    </td>
                                                                 </tr>
                                                                 <?php }else{?>
                                                                    <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            Username : <span style="color:#ffffff !important;text-decoration: none;font-weight: 400;">
                                                                              <a href="mailto:<?php echo $useremail['email']; ?>" style="color:#ffffff !important;text-decoration: none;font-weight: bold;" target="_blank"><?php echo $useremail['email']; ?></a>
                                                                              </span>
                                                                    </td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            Password : <strong><?php echo $useremail['password']; ?></strong>
                                                                    </td>
                                                                 </tr>
                                                                  <?php }?>

                                                                 <?php if(!empty($useremail['application_id'])){ ?>
                                                                 <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            Client Id : <strong><?php echo $useremail['application_id']; ?></strong>
                                                                    </td>
                                                                 </tr>
                                                               <?php } ?>
                                                                   <tr>
                                                                          <td cellpadding="0" cellspacing="0" height="50">
                                                                              &nbsp;
                                                                         </td>
                                                                     </tr>
                                                                     <!--<tr>
                                                                          <td cellpadding="0" cellspacing="0" align="center" >
                                                                                  <a href="<?php echo url('/');?>/verifyEmail/<?php echo encrypt($useremail['user_id'])."/".encrypt($useremail['referral_link']);?>" ><img src="<?php echo url('/');?>/public/images/email-activate_btn.png" width="234" height="48"></a>
                                                                         </td>
                                                                     </tr>-->
                                                                     <tr>
                                                                        <td cellpadding="0" cellspacing="0" align="center" >
                                                                            <?php
                                                                            // if(!isset($useremail['user_role']) && !empty($useremail['user_role'])){
                                                                            //     if($useremail['user_role'] == 1){
                                                                            //     $loginPath = 'customerLogin';
                                                                            //     }if($useremail['user_role'] == 2 || $useremail['user_role'] == 3) {
                                                                            //         $loginPath = 'login';
                                                                            //     }else if($useremail['user_role'] == 4){
                                                                            //         $loginPath = 'customerLogin';
                                                                            //     }
                                                                            // }else{
                                                                            //     $loginPath = '';
                                                                            // }
                                                                            ?>
                                                                            <a href="<?php echo $web_login;?>" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff !important;line-height:24px; font-weight: 400;">Click here to Login</a>
                                                                       </td>
                                                                   </tr>
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" height="90">
                                                                              &nbsp;
                                                                         </td>
                                                                     </tr>
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" align="center" style="font-weight:bold;font-family: 'Century Gothic', sans-serif; font-size:25px;color:#ffffff;line-height:60px; font-weight: 400;">
                                                                              <a href="<?php echo url('/');?>" style="color:#ffffff;text-decoration: none;">https://bestbox.net/</a>
                                                                         </td>
                                                                     </tr>
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" align="center" style="font-weight:bold;font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff; font-weight: 400; line-height: 35px;">
                                                                                  <a href="<?php echo url('/');?>/privacy_policy" target="_blank" style="color: #ffffff; text-decoration:none;">Privacy Policy |</a>  <a href="<?php echo url('/');?>/terms_of_use" target="_blank" style="color: #ffffff; text-decoration:none;">Terms & Conditions</a>
                                                                         </td>
                                                                     </tr>
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" align="center" style="font-weight:bold;font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff; font-weight: 400;">
                                                                                  Copyright &copy <?php echo date('Y');?> BestBOX. All rights reserved.
                                                                         </td>
                                                                     </tr>
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" height="70">
                                                                              &nbsp;
                                                                         </td>
                                                                     </tr>
                                                             </tbody>
                                                         </table>
                                                      </td>
                                                      <td style="width:50px">&nbsp;</td>
                                                    </tr>
                                                  </table>


                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <!-- END HEADER/BANNER -->
    </tbody>
</table>
