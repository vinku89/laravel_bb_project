<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap');
table{
    font-family: 'Roboto', sans-serif;
    color: #2d3138;
}

@media screen only(max-width:670px){
 .col{
  width:100% !important;
  text-align: center;
 }
   .template_width[width="700"]{
      width:500px !important;
   }
}
</style>


<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
<tbody>
    <tr>
        <td  align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="700" class="template_width" style="background-color: #fbfbfb; padding:20px; border:solid 3px #e6e6e6">
                <tbody>
                    <tr>
                        <td>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom: solid 2px #a0a0a0; padding-bottom:20px;">
                                    <tbody>
                                        <tr>
                                                <td class="col"><img src="<?php echo url('/');?>/public/images/email_logo.png" width="220"></td>
                                                <td align="right" class="col">
                                                  <table border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style=" padding-top:8px;">
                                                                    <table border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="right" width="80" style="padding-right:10px; padding-bottom:8px;">Website:</td>
                                                                                <td style=" padding-bottom:8px; text-align: right"><a href="<?php echo url('/');?>" target="_blank" style="color: cornflowerblue;">www.bestbox.net</a></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="right" width="80" style="padding-right:10px;">Email:</td>
                                                                                <td><a href="mailto:sales@bestbox.net" style="color: cornflowerblue;text-align: right">sales@bestbox.net</a></td>
                                                                            </tr>
                                                                        </tbody>
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
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr><td>&nbsp;</td></tr>
                                   
                                    <tr>
                                            <td style="padding-bottom: 30px;padding-top: 30px;">Date: <span><?php echo date('d/m/Y');?></span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 20px;">Dear Sir/Madam</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 10px;">This is an e-mail notification to inform you that your order <span style="font-weight: bold;"><?php echo $useremail['order_no']; ?></span> has been verified
                                                on <?php echo $useremail['activated_date']; ?>. </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                Here is your subscription account detail: 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                <span style="font-weight: bold;">Client ID:</span> <?php echo $useremail['application_id']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                <span style="font-weight: bold;">User ID:</span> <?php echo $useremail['customer_id']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                        if(!empty($useremail['password'])){
                                    ?>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                <span style="font-weight: bold;">Password:</span> <?php echo $useremail['password']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                <span style="font-weight: bold;">Package Name:</span> <?php echo $useremail['package_name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                <span style="font-weight: bold;">Subscription Amount:</span> $<?php echo $useremail['package_amount']; ?>
                                        </td>
                                    </tr>
                                    <?php
                                        if(!empty($useremail['expiry_date'])){
                                     ?>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                <span style="font-weight: bold;">Expiry Date:</span> <?php echo $useremail['expiry_date']; ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td style="padding-bottom: 20px;">
                                                <span style="font-weight: bold;">Password for adult folder:</span> 201901
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 20px;">We're here to assist you.</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 40px;">
                                                Check out our FAQ for answers to some of our most commonly asked questions. You can also
                                                email our customer support team
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 20px;">Sincerely,</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; padding-bottom: 40px;">BestBOX</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top:solid 2px #333; padding-top:30px;">
                                <tbody>
                                    <tr>
                                        <td align="center">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                                <td align="center" style="padding-bottom: 10px;"><a href="<?php echo url('/');?>/privacy_policy" target="_blank" style="color: cornflowerblue; text-decoration: none">Privacy Policy</a> &nbsp; |&nbsp; </td>
                                                                <td align="center" style="padding-bottom: 10px;"><a href="<?php echo url('/');?>/terms_of_use" target="_blank" style="color: cornflowerblue; text-decoration: none">Terms of Use</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </td>
                                       
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center" style="font-size: 13px;">Copyright © 2019 BestBOX. All rights reserved</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>