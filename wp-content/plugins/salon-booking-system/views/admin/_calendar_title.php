<?php
/** @var SLN_Wrapper_Booking $booking */
$format = SLN_Plugin::getInstance()->format();
$customer = empty($customer) ? $booking->getCustomer() : new SLN_Wrapper_Customer($customer, false);
$booking_phone = esc_html($booking->getPhone());
?><strong>
    <?php 
    echo '<div class=\'sln-tooltip-header\' >' .
            '<div class=\'left-sln-tooltip-header\'>'.
                '<div class=\'sln-booking-id-tooltip\'>ID '. esc_attr($booking->getId()) .'</div>' .
                ($booking_phone? '<div class=\'sln-booking-id-phone\' style=\'margin-left:0.7rem; margin-top:0.5rem;\'>
                    <a style=\'text-decoration:none;\'target=\'_blanck\' href=\'https://wa.me/' . $booking_phone. '\'>Tel. '. 
                    (mb_strlen($booking_phone) > 10 ? mb_substr($booking_phone, 0, 10) . '...' : $booking_phone) 
                .'</a></div>': '') .
            '</div>' .
            '<div class=\'right-sln-tooltip-header\' style=\'margin-right:0.5rem;\'></div>'.
        '</div>' .
        '<div class=\'sln-value-tooltip sln-booking-status-tooltip\' style=\'margin-top:0.5rem; margin-left:0.7rem;\'>
			<div class=\'head-info-tooltip\'>'. \SLN_Enum_BookingStatus::getLabel($booking->getStatus()) .'</div>
			<div class=\'title-info-tooltip\'>Status</div>
		</div>'.
        (defined('SLN_VERSION_PAY') && SLN_VERSION_PAY && $plugin->getSettings()->get('enable_customer_fidelity_score') ? 
        '<div class=\'sln-value-tooltip sln-booking-status-tooltip\' style=\'margin-top:0.5rem; margin-left:0.7rem;\'>
            <div class=\'head-info-tooltip-cs\'>'. $customer->getFidelityScore() .'</div>
            <div class=\'title-info-tooltip-cs\'>Customer score</div>
        </div>' : '')
        .
        ($plugin->getSettings()->get('enable_discount_system') ? 
        '<div id=\'data-disc-sys\' data-disc-sys=\'true\' style=\'display:none;\'></div>' : '')
        .
        '<div class=\'sln-name-tooltip\' >'.
                esc_attr($booking->getDisplayName()) 
        .'</div></strong>' .
        ($booking_phone? "<div class='sln-name-tooltip'>
            <a class='sln-booking-title-phone' target='_blanck' href='https://wa.me/{$booking_phone}'>
                Tel. ". (mb_strlen($booking_phone) > 10 ? mb_substr($booking_phone, 0, 10) . '...' : $booking_phone) . 
            " </a>
        </div>": '') . 
        '<div class=\'sln-name-tooltip\' >' . $format->time($booking->getStartsAt()) . '&#8594;' . 
            $format->time($booking->getEndsAt()) 
        .'</div>' ?>
    <?php $comments = get_comments("post_id=" . $booking->getId() . "&type=sln_review"); echo (isset($comments[0]) ? $comments[0]->comment_content : ''); ?></strong>


<div class='sln-services-tooltip'>
<?php foreach($booking->getBookingServices()->getItems() as $bookingService): ?>
    <br>
    <?php
    echo esc_attr($bookingService->getService()->getName()) .'<br /><span>'.
         (($attendant = $bookingService->getAttendant()) ?
            (!is_array($attendant) ?
                esc_attr($attendant->getName()) :
                SLN_Wrapper_Attendant::implodeArrayAttendantsName(' ', $attendant))
            .'&nbsp;' :
            '').
         $format->time($bookingService->getStartsAt()) . ' &#8594; ' .
         $format->time($bookingService->getEndsAt()).'<br /></span>';


    ?>
<?php endforeach ?>
</div>

<?php if ($booking->getNote()): ?>
<br/>
<?php echo esc_attr($booking->getNote()) ?>
<?php endif ?>

<?php if ($booking->getAdminNote()): ?>
<br/>
<?php echo esc_attr($booking->getAdminNote()) ?>
<?php endif ?>