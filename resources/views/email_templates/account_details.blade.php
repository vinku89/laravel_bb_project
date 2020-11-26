<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

<style type="text/css">
  .ii a[href] {
    color: #ffffff !important;
}

</style>
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
                                                Account Details
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
                                                                            Now you can login with below user details.
                                                                    </td>
                                                                 </tr>
                                                                  <tr>
                                                                      <td cellpadding="0" cellspacing="0" height="30">
                                                                          &nbsp;
                                                                     </td>
                                                                 </tr>
                                                                   <?php if($useremail['type'] == "Customer"){?>
                                                                     <tr>
                                                                        <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                                Web Link : <a href="<?php echo url('/');?>/customerLogin" style="color:#fff !important;text-decoration: none;"><?php echo url('/');?>/customerLogin</a>
                                                                        </td>
                                                                     </tr>
                                                                   <?php }else{?>
                                                                    <tr>
                                                                        <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                                Web Link : <a href="<?php echo url('/');?>/login" style="color:#fff !important;text-decoration: none;"><?php echo url('/');?>/login</a>
                                                                        </td>
                                                                     </tr>
                                                                   <?php }?>
                                                                   <tr>
                                                                        <td cellpadding="0" cellspacing="0" height="30">
                                                                            &nbsp;
                                                                       </td>
                                                                   </tr>

                                                                <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            Username : <span style="color:#ffffff !important;text-decoration: none;font-weight: 400;">
                                                                              <a href="mailto:<?php echo $useremail['email']; ?>" style="color:#ffffff !important;text-decoration: none;font-weight: bold;" target="_blank"><?php echo $useremail['email']; ?></a>
                                                                              </span>
                                                                    </td>
                                                                 </tr>
                                                               
                                                               <tr>
                                                                      <td cellpadding="0" cellspacing="0" height="30">
                                                                          &nbsp;
                                                                     </td>
                                                                 </tr>
                                                                 <tr>
                                                                    <td cellpadding="0" cellspacing="0" align="left" style="font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff;line-height:24px; font-weight: 400;">
                                                                            Password : <strong><?php echo $useremail['password']; ?></strong>
                                                                    </td>
                                                                 </tr>
                                                                 <tr>
                                                                      <td cellpadding="0" cellspacing="0" height="30">
                                                                          &nbsp;
                                                                     </td>
                                                                 </tr>
                                                                 
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" align="center" style="font-weight:bold;font-family: 'Century Gothic', sans-serif; font-size:25px;color:#ffffff;line-height:60px; font-weight: 400;">
                                                                              <a href="https://bestbox.net/" style="color:#ffffff;text-decoration: none;">bestbox.net</a>
                                                                         </td>
                                                                     </tr>
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" align="center" style="font-weight:bold;font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff; font-weight: 400; line-height: 35px;">
                                                                                  <a href="<?php echo url('/');?>/privacy_policy" target="_blank" style="color: #ffffff; text-decoration:none;">Privacy Policy |</a>  <a href="<?php echo url('/');?>/terms_of_use" target="_blank" style="color: #ffffff; text-decoration:none;">Terms & Conditions</a>
                                                                         </td>
                                                                     </tr>
                                                                     <tr>
                                                                          <td cellpadding="0" cellspacing="0" align="center" style="font-weight:bold;font-family: 'Century Gothic', sans-serif; font-size:16px;color:#ffffff; font-weight: 400;">
                                                                                  Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.
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