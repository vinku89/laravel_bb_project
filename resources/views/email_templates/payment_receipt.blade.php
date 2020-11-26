<style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap');
    table{
        font-family: 'Roboto', sans-serif;
        color: #2d3138;
    }
    </style>
    
    
    <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
    <tbody>
       
        <tr>
            <td  align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="700">
                    <tbody>
                            <tr >
                                    <td style="background-color: #F4F4F4; padding:30px 0" align="center" valign="middile">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-image: linear-gradient(0deg, #540481 0%, #C40072 69%, #EB772F 100%);background-color: #A02C72;">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="padding:50px 0px 30px;"><img src="<?php echo url('/');?>/public/images/BestBOX-whitelogo.png"></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#fff; font-size:25px; text-align: center; letter-spacing: .8px;">
                                                        Thank You For Your Purchase
                                                    </td>
                                                </tr>
                                                <tr><td style="height:50px">&nbsp;</td></tr>
                                                <tr>
                                                        <td>
                                                          <table border="0" cellpadding="0" cellspacing="0" style=" padding:0 50px;" >
                                                              <tbody>
                                                                    <tr>
                                                                        <td style="color:#fff; font-size:25px;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif; ">
                                                                            Hi <?php echo ucwords($payment_det['name']); ?>!
                                                                        </td>
                                                                    </tr>
                                                                    <tr><td style="height:30px">&nbsp;</td></tr>
                                                                    <tr>
                                                                        <td style="color:#fff; font-size:16px; font-weight:normal; line-height:25px;font-family: 'Century Gothic', sans-serif; ">
                                                                                Thank you for your purchase and we have received your payment.
                                                                        </td>
                                                                    </tr>
                                                                    <tr><td style="height:20px">&nbsp;</td></tr>
                                                                    <tr>
                                                                        <td style="color:#fff; font-size:16px; font-weight:normal; line-height:25px;font-family: 'Century Gothic', sans-serif; ">
                                                                             Attached invoice for your reference. If you need any support, live chat with us on our website: <a href="<?php echo url('/');?>" style="color:#ffffff;">https://bestbox.net/</a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr><td style="height:220px">&nbsp;</td></tr>
                                                                   <tr>
                                                                       <td style="font-size:22px; text-align: center; color: #fff; padding-bottom: 25px;font-family: 'Century Gothic', sans-serif; ">
                                                                           <a href="<?php echo url('/');?>" style="color:#ffffff;text-decoration: none;">https://bestbox.net/</a>
                                                                       </td>
                                                                   </tr>
                                                                   <tr>
                                                                        <td style="font-size:13px; text-align: center; color: #fff; padding-bottom: 10px;font-family: 'Century Gothic', sans-serif; ">
                                                                            <a href="<?php echo url('/');?>/privacy_policy" target="_blank" style="color:#fff; text-decoration: none;">Privacy Policy </a> | 
                                                                            <a href="<?php echo url('/');?>/terms_of_use" target="_blank"  style="color:#fff; text-decoration: none;">Terms & Conditions</a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                            <td style="font-size:13px; text-align: center; color: #fff;font-family: 'Century Gothic', sans-serif; ">Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.</td>
                                                                        </tr>
                                                                        <tr><td style="height:50px">&nbsp;</td></tr>
                                                          </table>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                        <tr>
                            <td style="padding: 20px 0;">
                                   <img src="<?php echo url('/');?>/public/images/logo.png" alt="BestBOX" width="200">
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border-top: solid 1px #979797; border-bottom: solid 1px #979797; font-size: 20px;font-family: 'Century Gothic', sans-serif; ">
                                BestBOX Payment Receipt
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:15px 0;font-family: 'Century Gothic', sans-serif; ">
                               <?php echo \App\Http\Controllers\home\ReportController::convertTimezone($payment_det['purchased_date']);?>GMT+08:00 <br>
                               Transaction ID: <?php echo $payment_det['transaction_id']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 20px 0;font-family: 'Century Gothic', sans-serif; ">
                                Hello <?php echo ucwords($payment_det['name']); ?>,
                            </td>
                        </tr>

                        <tr>
                            <td style="line-height: 26px;padding-bottom: 40px;font-family: 'Century Gothic', sans-serif; ">
                                You sent a payment of $<?php echo $payment_det['package_amount']; ?> USD to Bestbox subscription package.
Charge will appear in your BestBOX wallet or credit card statement as "BestBOX Subscription".
It may take a few moments for this transaction to appear in your account.
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 40px">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: bold;font-family: 'Century Gothic', sans-serif; ">Marchant</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: 'Century Gothic', sans-serif; ">BestBOX</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: 'Century Gothic', sans-serif; ">service@bestbox.com</td>
                                        </tr>
                                        <tr>
                                            <td style="font-family: 'Century Gothic', sans-serif; ">+60 361516133 x291</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                       
                        <tr>
                            <td style="padding-bottom:40px;">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td style=" font-weight:bold; padding-bottom: 10px;font-family: 'Century Gothic', sans-serif; ">Shipping address - </td>
                                            <td style="color: #38B586; font-weight:bold; padding-bottom: 10px;font-family: 'Century Gothic', sans-serif; ">Confirmed</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-family: 'Century Gothic', sans-serif; ">
                                                <?php 
                                                    if(!empty($payment_det['shipping_address'])){
                                                        echo $payment_det['shipping_address']; 
                                                    }else{
                                                        echo "No shipping address required"; 
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;font-family: 'Century Gothic', sans-serif; ">Shipping Details</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 25px;font-family: 'Century Gothic', sans-serif; ">
                                <?php 
                                    if(!empty($payment_det['shipping_address'])){
                                        echo "The seller hasn’t provided any shipping details yet."; 
                                    }else{
                                        echo "No shipping details required"; 
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td style="border-top:solid 1px #979797; padding-top:15px; padding-bottom:15px; font-weight: bold;font-family: 'Century Gothic', sans-serif; ">Description</td>
                                            <td style="border-top:solid 1px #979797; padding-top:15px; padding-bottom:15px; font-weight: bold;font-family: 'Century Gothic', sans-serif; ">Unit Price</td>
                                            <td style="border-top:solid 1px #979797; padding-top:15px; padding-bottom:15px; font-weight: bold;font-family: 'Century Gothic', sans-serif; ">Qty</td>
                                            <td style="border-top:solid 1px #979797; padding-top:15px; padding-bottom:15px; font-weight: bold; text-align: right;font-family: 'Century Gothic', sans-serif; ">Amount</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top:solid 1px #979797; border-bottom:solid 1px #979797; padding-top:15px; padding-bottom:20px;font-family: 'Century Gothic', sans-serif; "><?php echo $payment_det['package_name']; ?></td>
                                            <td style="border-top:solid 1px #979797; border-bottom:solid 1px #979797; padding-top:15px; padding-bottom:20px;font-family: 'Century Gothic', sans-serif; ">$<?php echo $payment_det['package_amount']; ?> USD</td>
                                            <td style="border-top:solid 1px #979797; border-bottom:solid 1px #979797; padding-top:15px; padding-bottom:20px;font-family: 'Century Gothic', sans-serif; ">1</td>
                                            <td style="border-top:solid 1px #979797; border-bottom:solid 1px #979797; padding-top:15px; padding-bottom:20px;font-family: 'Century Gothic', sans-serif;  text-align: right;">$<?php echo $payment_det['package_amount']; ?> USD</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td style="font-weight:bold; padding-top:15px;font-family: 'Century Gothic', sans-serif; ">Subtotal</td>
                                            <td style=" padding-top:15px; text-align: right;font-family: 'Century Gothic', sans-serif; ">$<?php echo $payment_det['package_amount']; ?> USD</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td style="font-weight:bold; padding-top:15px;font-family: 'Century Gothic', sans-serif; ">Total</td>
                                            <td style=" padding-top:15px; text-align: right;font-family: 'Century Gothic', sans-serif; ">$<?php echo $payment_det['package_amount']; ?> USD</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td style="font-weight:bold; padding-top:15px;font-family: 'Century Gothic', sans-serif; ">Payment</td>
                                            <td style=" padding-top:15px; text-align: right;font-family: 'Century Gothic', sans-serif; ">$<?php echo $payment_det['package_amount']; ?> USD</td>
                                        </tr>
                                        <tr><td style="height:50px; border-bottom:solid 1px #979797;font-family: 'Century Gothic', sans-serif; " colspan="4">&nbsp;</td></tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;padding-bottom:15px; padding-top:15px; font-size:14px;font-family: 'Century Gothic', sans-serif; ">Issues with this transaction.</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:15px; font-size:14px;font-family: 'Century Gothic', sans-serif; ">You have 90 days from the date of the transaction to open a dispute in the Resolution Center. </td>
                        </tr>
                        <!-- <tr>
                            <td style="padding-bottom:15px; font-size:14px;font-family: 'Century Gothic', sans-serif; ">Questions? Go to the Help Center at www.bestbox.net/help.</td>
                        </tr> -->
                        <tr>
                            <td style=" font-size:14px;font-family: 'Century Gothic', sans-serif; ">
                                If you need assistance, please log in to your BestBOX account and reach out to us through the Chatbox application located in the bottom right corner of any BestBOX webpage.
                            </td>
                        </tr>
                        <tr>
                            <td style="height:60px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style=" font-size:14px;font-family: 'Century Gothic', sans-serif; ">Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.</td>
                        </tr>
                        <tr>
                            <td style="height:60px;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
    </table>