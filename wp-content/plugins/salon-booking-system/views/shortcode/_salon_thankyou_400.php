<div class="row sln-box--main sln-box--fixed_height">
    <div class="col-xs-12">
        <div class="sln-thankyou__content sln-list">
            <?php include '_salon_thankyou_okbox.php' ?>
            <?php include '_salon_thankyou_alert.php' ?>
            <?php if (in_array($booking->getStatus(), array(SLN_Enum_BookingStatus::PAID))): ?>
                <?php include '_salon_thankyou_alert_paid.php' ?>
            <?php endif; ?>
            <div class="col-xs-12-- sln-input--action sln-form-actions-- sln-payment-actions--">
                <p><?php echo sprintf(__('You\'ll be redirected in %s seconds', 'salon-booking-system'), '<span class="sln-go-to-thankyou-number"></span>') ?></p>
                <a id="sln-go-to-thankyou"  href="<?php echo $goToThankyou ?>" class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--fullwidth hide"></a>
            </div>
        </div>
    </div>
</div>
