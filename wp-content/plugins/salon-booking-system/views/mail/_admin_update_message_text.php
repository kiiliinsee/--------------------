<?php
    $updated_message = __('Reservation at [SALON NAME] has been modified', 'salon-booking-system');
    $updated_message = str_replace('[SALON NAME]', '<b style="color:#666666;">' . $plugin->getSettings()->getSalonName() . '</b>', $updated_message);
?>
<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:30px;color:#505050;font-size:20px"><?php echo  $updated_message ?></p>