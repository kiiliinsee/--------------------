<table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
	<tr>
		<td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:270px">
			<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#F7F8FA" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-color:#f7f8fa;border-radius:10px" role="presentation">
				<tr>
					<td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:25px;padding-right:25px">
						<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:lato, 'helvetica neue', helvetica, arial, sans-serif;line-height:20px;color:#a2b2ce;font-size:13px"><?php
						_e('CUSTOMER DETAILS', 'salon-booking-system') ?></p>
					</td>
				</tr>
				<tr>
					<td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:25px;padding-right:25px">
						<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'source sans pro', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#525252;font-size:16px"><?php
						echo implode(' ', array_filter(array(
							SLN_Enum_CheckoutFields::getField('firstname')->isHidden() ? '' : $booking->getFirstname(),
							SLN_Enum_CheckoutFields::getField('lastname')->isHidden() ? '' : $booking->getLastname(),
						))); ?></p>
						<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'source sans pro', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#525252;font-size:16px">
							<a href="mailto:<?php echo $booking->getEmail() ?>" target="_blank" style="text-decoration:none;Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'source sans pro', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#525252;font-size:16px">
							<?php echo $booking->getEmail() ?>
							</a>
						</p>
						<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'source sans pro', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#525252;font-size:16px">
							<a href="tel:<?php echo $booking->getPhone() ?>" target="_blank" style="text-decoration:none;Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'source sans pro', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#525252;font-size:16px">
							<?php echo $booking->getPhone() ?>
							</a>
						</p>
						<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'source sans pro', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#525252;font-size:16px"><?php echo $booking->getAddress() ?></p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>