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
                            <tr>
                                    <td style="background-color: #F4F4F4; padding:30px 0" align="center" valign="middile">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-image: linear-gradient(0deg, #540481 0%, #C40072 69%, #EB772F 100%);background-color: #A02C72;">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="padding:50px 0px 30px;"><img src="<?php echo url('/');?>/public/images/white-logo.png"></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#fff; font-size:25px; text-align: center; letter-spacing: .8px;">
														<?php echo $useremail['emailtitle'];?>
                                                    </td>
                                                </tr>
                                                <tr><td style="height:50px">&nbsp;</td></tr>
                                                <tr>
                                                        <td align="center">
                                                                <table border="0" cellpadding="0" cellspacing="0" style=" padding:0 20px;">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="height:30px">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td
                                                                                style="color:#fff; font-size:25px;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif; text-align:center ">
                                                                                HI <?php echo ucwords($useremail['username']); ?>,
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td
                                                                                style="color:#fff; font-size:25px;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif; text-align:center; font-weight:bold ">
                                                                                <?php echo ucwords($useremail['user_id']); ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td style="height:30px">&nbsp;</td>
                                                                            </tr>
                                                                        <tr>
                                                                            <?php if($useremail['days'] <= 0){?>
                                                                            <td
                                                                                style="color:#fff; font-size:16px;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif; text-align:center ">
                                                                                Your BestBOX Package has
                                                                            </td>
                                                                            <?php }else{?>
                                                                            <td
                                                                                style="color:#fff; font-size:16px;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif; text-align:center ">
                                                                                Your BestBOX Package will expire in
                                                                            </td>    
                                                                            <?php }?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table border="0" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr><td>&nbsp;</td></tr>
                                                                                        <tr>
                                                                                            <?php if($useremail['days'] <= 0){?>
                                                                                            <td style="color:#fff; font-size:75px; font-weight:bold;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif;">EXPIRED</td>
                                                                                            <?php }else{?>
                                                                                            <td style="color:#fff; font-size:75px; font-weight:bold;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif;"><?php echo $useremail['days'];?></td>
                                                                                            <td style="color:#fff;font-family: 'Century Gothic', sans-serif; font-size: 25px; padding-bottom: 12px; font-weight: bold;" valign="bottom">Days</td>   
                                                                                            <?php }?>
                                                                                        </tr>
                                                                                        <tr><td>&nbsp;</td></tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td
                                                                                style="color:#fff; font-size:16px;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif; text-align:center ">
                                                                                Renew your subscription to stay connected.
                                                                            </td>
                                                                        </tr>
                                                                        <td style="height:30px">&nbsp;</td>
                                                                        <tr><td style="color:#fff; font-size:16px;  letter-spacing: .8px;font-family: 'Century Gothic', sans-serif; text-align:center ">
                                                                            Go to <a href="{{ url('/') }}" target="_blank" style="color: #f5a623;text-decoration: none;">www.bestbox.net</a> or click below button for renewal your package.</td></tr>
                                                                            <td style="height:50px">&nbsp;</td>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <table border="0" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="background-color: #f5a623;
                                                                                            color: white;
                                                                                            padding: 10px 50px;
                                                                                            border-radius: 50px;
                                                                                            font-size: 20px;"><a href="{{ url('/renewal/'.encrypt($useremail['rec_id'])) }}" target="_blank" style="color:#fff; text-decoration: none;">RENEW</a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <td style="height:80px">&nbsp;</td>
                                                                        <tr>
                                                                                <td style="font-size:22px; text-align: center; color: #fff; padding-bottom: 25px;font-family: 'Century Gothic', sans-serif; ">bestbox.net</td>
                                                                            </tr>
                                                                            <tr>
                                                                                 <td style="font-size:13px; text-align: center; color: #fff; padding-bottom: 10px;font-family: 'Century Gothic', sans-serif; "><a href="{{ url('/') }}/privacy_policy" target="_blank" style="color:#fff; text-decoration: none;">Privacy Policy </a> | <a href="{{ url('/') }}/terms_of_use" target="_blank"  style="color:#fff; text-decoration: none;">Terms & Conditions</a></td>
                                                                             </tr>
                                                                             <tr>
                                                                                     <td style="font-size:13px; text-align: center; color: #fff;font-family: 'Century Gothic', sans-serif; ">Copyright © <?php echo date('Y');?> BestBOX. All rights reserved.</td>
                                                                                 </tr>
                                                                        <td style="height:40px">&nbsp;</td>
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
    </tbody>
    </table>