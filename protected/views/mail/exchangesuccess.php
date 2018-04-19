<?php require_once 'emailheader.php';//$this->renderPartial('emailheader',array('siteSettings'=>$siteSettings)); ?>
<table cellpadding="0" cellspacing="0" border="0" align="center"
	width="100%" style="font-family: Georgia, serif; background: #fff;"
	bgcolor="#ffffff">
	<tr>
		<td width="14" style="font-size: 0px;" bgcolor="#ffffff">&nbsp;</td>
		<td width="100%" valign="top" align="left" bgcolor="#ffffff"
			style="font-family: Georgia, serif; background: #fff;">
			<table cellpadding="0" cellspacing="0" border="0"
				style="color: #333333; font: normal 13px Arial; margin: 0; padding: 0;"
				width="100%" class="content">
				<!-- <tr>
							<td style="padding: 25px 0 5px; border-bottom: 2px solid #d2b49b;font-family: Georgia, serif; "  valign="top" align="center">
								<h3 style="color:#767676; font-weight: normal; margin: 0; padding: 0; font-style: italic; line-height: 13px; font-size: 13px;">~ <currentmonthname> <currentday>, <currentyear> ~</h3>
							</td>
						</tr> -->
				<tr>
					<td style="padding: 18px 0 0;" align="left">
						<h2
							style="font-weight: normal; margin: 0; padding: 0 0 12px; font-style: inherit; line-height: 30px; font-size: 25px; font-family: Trebuchet MS; border-bottom: 1px solid #333333;">
							
							<?php echo $r_username.' '; ?><?php echo Yii::t('app','Now Successed the Request to Exchange on your product'); ?>
							.
						</h2>
					</td>
				</tr>

				<tr>
					<td style="padding: 15px 0;" valign="top">
						<p style='margin-bottom: 10px'>
							<?php echo Yii::t('app','Hi');?>
							<?php echo $c_username; ?>
							,
						</p>
						<p style='margin-bottom: 10px'><?php echo Yii::t('app','The Request to your product for Exchange was Successed!'); ?></p>
						<p style='margin-bottom: 10px'><?php echo Yii::t('app','There is an alot of products and friends waiting for you and your products. Most of the People are there to Buy and Exchange you Products.'); ?></p>
						
<!-- 						<a href="<?php echo $productURL; ?>" title="product url">
							<?php echo $productURL; ?>
						</a> -->
						
<!-- 						<p style='margin-bottom: 10px'>
							Offer Rate: 
							<?php echo $currency.' '.$offerRate; ?>
							<br> Date:
							<?php echo date('j-M-Y'); ?>
						</p> -->
						<!-- <p style='margin-bottom: 10px'>
						
						<table width="100%" class='order-details-table'
							style='border-spacing: 0; border-collapse: collapse; border: none;'>
							<tr>
								<th
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12);'>Name</th>
								<th
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12);'>Email</th>
								<th
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12);'>Phone</th>
								<th
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12);'>Message</th>
							</tr>
							<tr>

								<td
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12);'><?php echo $name; ?>
								</td>
								<td
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12); text-align: center;'><?php echo $email; ?>
								</td>
								<td
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12); text-align: center;'><?php echo $phone; ?>
								</td>
								<td
									style='padding: 6px 10px; border: 1px solid rgba(0, 0, 0, 0.12); text-align: center;'><?php echo $message; ?>
								</td>
							</tr>
						</table>
						</p> -->
						
						
						<!-- <p style='margin-bottom: 10px'>You have options to follow back. </p> -->
						<p style='margin-bottom: 10px'><?php echo Yii::t('app','Happy selling !!!'); ?></p>
					</td>
				</tr>

				<tr>
					<td style="padding: 15px 0" valign="top">
						<p
							style="color: #333333; font-weight: normal; margin: 0; padding: 0; line-height: 20px; font-size: 14px; font-family: Arial;">
							<?php echo Yii::t('app','Regards,'); ?> <br /> <b><?php echo $siteSettings->sitename.' Team'; ?>.</b>
						</p> <br>
					</td>
				</tr>
			</table>
		</td>
		<td width="16" bgcolor="#ffffff"
			style="font-size: 0px; font-family: Georgia, serif; background: #fff;">&nbsp;</td>
	</tr>
</table>
<!-- body -->
	<?php require_once 'emailfooter.php';//$this->renderPartial('emailfooter',array('siteSettings'=>$siteSettings)); ?>
</td>
</tr>
</table>
</body>
</html>
