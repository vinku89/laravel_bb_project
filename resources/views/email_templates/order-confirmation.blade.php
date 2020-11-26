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
				<table border="0" cellpadding="0" cellspacing="0" width="700" style="background-color: #fbfbfb; padding:20px; border:solid 3px #e6e6e6">
					<tbody>
						<tr>
							<td>
									<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom: solid 2px #a0a0a0; padding-bottom:20px;">
										<tbody>
											<tr>
													<td><img src="<?php echo url('/');?>/public/images/email_logo.png" width="220"></td>
													<td align="right">
													  <table border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;">
														<tbody>
															<tr>
																<td style=" padding-top:8px;">
																		<table border="0" cellpadding="0" cellspacing="0" style="font-size: 14px;">
																			<tbody>
																				<tr>
																					<td align="right" width="80" style="padding-right:10px; padding-bottom:8px;">Website:</td>
																					<td style=" padding-bottom:8px;"><a href="https://bestbox.net/" target="_blank" style="color: cornflowerblue;">www.bestbox.net</a></td>
																				</tr>
																				<tr>
																					<td align="right" width="80" style="padding-right:10px;">Email:</td>
																					<td><a href="mailto:sales@bestbox.net" style="color: cornflowerblue">sales@bestbox.net</a></td>
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
										   
											<td align="center" style="color: #000; font-size:24px; text-transform:uppercase; font-weight: bold;">Order Confirmation</td>
										</tr>
										<tr>
												<td style="padding-bottom: 30px;padding-top: 30px;">Date: <span><?php echo ucwords($useremail['date']); ?></span></td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;">Dear Sir/Madam</td>
										</tr>
										<tr>
											<td style="padding-bottom: 10px;">Your order has been placed. Thank you!</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;">
												Your order number is:  <span style="font-weight: bold;"><?php echo $useremail['order_id']; ?></span>
											</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;">
												Your order will ship within 1-2 business days. Upon receipt of your shipment, please contact
	support for activation of your subscription.
											</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;">
												If you have placed a renewal subscription, you will receive activation keys within 30 mins to 8
	hours.
											</td>
										</tr>
										<tr>
											<td>
												After we ship your order, you will receive an email with your tracking number.
											</td>
										</tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
										   
											<td style="color: #000; font-size:24px; text-transform:uppercase; font-weight: bold;">ORDER DETAILS:</td>
										</tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
											<td style="font-weight: bold;">Name:</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;"> <?php echo $useremail['name']; ?></td>
										</tr>
										<tr>
											<td style="font-weight: bold;padding-bottom: 10px;">Shipping Address:</td>
										</tr>
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
													<tbody>
														<tr>
															<td style="padding-bottom: 5px;"><?php echo $useremail['shipping_address']; ?></td>
														</tr>
														<!-- <tr>
															<td style="padding-bottom: 5px;">Dilamanta road. Byg Siscican</td>
														</tr>
														<tr>
															<td style="padding-bottom: 5px;">Purto Princessa, Palawan, Philippines</td>
														</tr>
														<tr>
															<td style="padding-bottom: 5px;">Zip Code: 53000</td>
														</tr>
														<tr>
															<td>Tel: +63- 9663676344</td>
														</tr> -->
													</tbody>
												</table>
											</td>
										</tr>
										<tr><td style="height: 50px;">&nbsp;</td></tr>
										<tr>
											<td>Shipping Method - <span style="font-weight: bold;">17TRACK</span></td>
										</tr>
										<tr><td style="height: 50px;">&nbsp;</td></tr>
										<!-- <tr>
											<td style="padding-bottom: 20px;">Payment Method</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;">
												Aliexpress Account: <span style="font-weight: bold;"><?php //echo $useremail['aliexpress_email']; ?></span>
											</td>
										</tr> -->
										<tr>
											<td style="padding-bottom: 20px;">We're here to assist you.</td>
										</tr>
										<tr>
											<td style="padding-bottom: 20px;">
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

