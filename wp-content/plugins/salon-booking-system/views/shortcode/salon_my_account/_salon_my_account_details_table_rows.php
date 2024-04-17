<?php foreach ($data['table_data']['items'] as $item): ?>
        <article id="sln-account__booking--<?php echo $item['id'] ?>" class="sln-account__booking sln-account__card sln-account__list__item">
        <header class="sln-account__card__header">
            <h4 class="sln-account__card__header__el">
                <?php echo $item['id'] ?>
                <small><?php _e('Booking ID', 'salon-booking-system');?></small>
            </h4>
            <h4 class="sln-account__card__header__el">
                <?php echo $item['status']; ?>
                <small><?php _e('Status', 'salon-booking-system');?></small>
            </h4>
        </header>
        <h3 class="sln-account__card__title sln-account__booking__date">
            <span class="sln-booking-date"><?php echo $item['date'] ?></span> @ <span class="sln-booking-time"><?php echo $item['time'] ?></span>
        </h3>
        <section class="sln-account__card__body">
            <ul class="sln-account__services__list">
                <?php foreach($item['services'] as $service): ?>
                <li class="sln-account__service">
                    <span class="sln-account__service__name">
                        <?php echo $service['name'] ?>
                    </span>
                    <?php if(isset($service['attendant'])): ?>
                        <span class="sln-account__service__assistant">(<?php echo $service['attendant']; ?>)</span>
                    <?php endif; ?>
                    <?php if (!$data['hide_prices']): ?>
                        <span class="sln-account__service__price" data-th="<?php _e('Price', 'salon-booking-system');?>">
                            <?php echo $service['price']; ?>
                        </span>
                    <?php endif;?>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="sln-account__card__total">
            <h5 class="sln-account__card__total__amount"><?php _e('Total amount', 'salon-booking-sysstem')?>: <strong><?php echo $item['total'] ?></strong></h5>
        </section>
        <footer class="sln-account__card__footer sln-account__card__actions sln-account__booking__actions">
            <?php if($data['table_data']['mode'] == 'new'): 
                    if($plugin->getSettings()->get('cancellation_enabled')): ?>
                        <div class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--borderonly sln-cancel-booking--button sln-account__btn--cancel">
                            <button onclick="sln_myAccount.cancelBooking(<?php echo $item['id']; ?>);" data-message="<?php _e('Booking cancelled', 'salon-booking-system');?>"><?php _e('Cancel', 'salon-booking-system');?></button>
                        </div>
                    <?php endif;
                    $booking = $plugin->createBooking($item['id']);
                    if(($item['status_code'] == SLN_Enum_BookingStatus::PENDING_PAYMENT || ($item['status_code'] == SLN_Enum_BookingStatus::PAID && ($deposit = $booking->getDeposit()))) && $data['pay_enabled']): 
                        $price_to_pay = $item['status_code'] == SLN_Enum_BookingStatus::PENDING_PAYMENT ? $booking->getToPayAmount(false) : $deposit; ?>
                        <div class="sln-btn sln-btn--emphasis sln-btn--medium sln-account__btn--pay">
                            <a href="<?php echo $booking->getPayUrl(); ?>"><?php echo __('Pay', 'salon-booking-system') . ' '. $plugin->format()->moneyFormatted($price_to_pay); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if(!$plugin->getSettings()->get('rescheduling_disabled') && ($booking->getStartsAt()->getTimestamp() - time()) >= ($plugin->getSettings()->get('display_before_rescheduling') * 24 * 3600) && in_array($item['status_code'], array(SLN_Enum_BookingStatus::CONFIRMED, SLN_Enum_BookingStatus::PAY_LATER, SLN_Enum_BookingStatus::PAID,))):
                        $date = $plugin->getSettings()->isDisplaySlotsCustomerTimezone() && $data['customer_timezone']
                            ? $booking->getStartsAt()->setTimezone(new DateTimezone($data['customer_timezone']))
                            : $booking->getStartsAt(); ?> 
                        <div class="sln-btn sln-btn--emphasis sln-btn--medium sln-reschedule-booking--button sln-account__btn--reschedule" data-message="<?php _e('Booking rescheduled', 'salon-booking-system');?>">
                            <?php _e('Reschedule', 'salon-booking-system'); ?>
                        </div>

                        <?php ob_start(); ?>
                        <?php SLN_Form::fieldJSDate('_sln_booking_date', $date, array('inline' => true)) ?>
                        <input name="_sln_booking_date" type="hidden" value="<?php echo $plugin->format()->date($date) ?>">
                        <?php $datepicker = ob_get_clean();
                        
                        ob_start(); ?>
                        <?php SLN_Form::fieldJSTime('_sln_booking_time', $date, array('inline' => true, 'interval' => $plugin->getSettings()->get('interval'),)); ?>
                        <input name="_sln_booking_time" type="hidden" value="<?php echo $plugin->format()->time($date); ?>">
                        <?php $timepicker = ob_get_clean(); ?>
                        
                        <form class="sln-reschedule-form hide">
                            <?php do_action('sln.salon_my_accout.reschedule-form', $booking);
                            SLN_Form::fieldText('_sln_booking_id', $item['id'], array('type'=> 'hidden'));
                            SLN_Form::fieldText('customer_timezone', $data['customer_timezone'], array('type' => 'hidden')); ?>
                            <input class="sln_booking_default_date" type="hidden" value="<?php echo $plugin->format()->date($date); ?>">
                            <input class="sln_booking_default_time" type="hidden" value="<?php echo $plugin->format()->time($date); ?>">
                            <?php
                            foreach($booking->getBookingServices()->getItems() as $bookingService){
                                $serviceId = $bookingService->getService()->getId();
                                SLN_Form::fieldText(
                                    "_sln_booking[services][$serviceId]",
                                    $bookingService->getAttendant() 
                                        ? (
                                            is_array($bookingService->getAttendant())
                                                ? SLN_Wrapper_Attendant::getArrayAttendantsValue('getId', $bookingService->getAttendant()) 
                                                : $bookingService->getAttendant()->getId()
                                        ) 
                                        : 0,
                                    array('type' => 'hidden', array('multiple' => ''))
                                );
                            } ?>
                            <div class="sln-box--main sln-account__reschedule">
                                <div class="sln-account__reschedule__header">
                                    <h3><?php _e('Reschedule', 'salon-booking-system'); ?></h3>
                                </div>
                                        <div class="sln-input sln-input--datepicker sln-input--datepicker--date">
                                            <?php echo $datepicker; ?>
                                        </div>
                                        <div class="sln-input sln-input--datepicker sln-input--datepicker--time">
                                            <?php echo $timepicker; ?>
                                        </div>
                                        <div class="sln-notifications"></div>
                                        <div class="sln-reschedule-form__btnwrp">
                                            <div class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--borderonly sln-reschedule-form--cancel-button">
                                                <?php _e('Cancel', 'salon-booking-system'); ?>
                                            </div>
                                            <div class="sln-btn sln-btn--emphasis sln-btn--medium sln-reschedule-form--save-button">
                                                <?php _e('Confirm', 'salon-booking-system'); ?>
                                            </div>
                                        </div>
                                    </div>
                        </form>
                    <?php endif ?>
            <?php elseif($data['table_data']['mode'] == 'history'): ?>
                    <?php if(empty($item['rating'])): ?>
                        <div class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--borderonly">
                            <button onclick="sln_myAccount.showRateForm(<?php echo $item['id']; ?>);" data-message="<?php _e('Feedback submitted', 'salon-booking-system');?>">
                                <?php _e('Leave a feedback', 'salon-booking-system'); ?>
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="sln-accout__feedback">
                            <div class="feedback sln-accout__feedback__text"><?php echo $item['feedback'] ?></div>
                            <input type="hidden" name="sln-rating" value="<?php echo $item['rating']; ?>">
                            <div class="rating sln-accout__feedback__rating" id="<?php echo $item['id']; ?>" style="display: none;"></div>
                        </dev>
                    <?php endif; ?>
            <?php endif; ?>
        </footer>
        <div id="sln-account__card__action_notification_<?php echo $item['id']?>" class="sln-account__card__action_notification sln-account__card__action_notification--hide">
            <div class="sln-account__notification_action__text">
                <span class="sln-account__notification_action_name"></span>
            </div>
            <div class="sln_account__notification_action__icon"></div>
            <!-- <div class="sln_account__notification_action__close"></div> -->
        </div>
    </article>
    
<?php endforeach;?>
