<?php
global $pagenow;
$helper->showNonce($postType);
?>
<div class="sln-box sln-box--main sln-box--haspanel sln-box--haspanel--open">
    <h2 class="sln-box-title sln-box__paneltitle sln-box__paneltitle--open"><?php _e('Service details', 'salon-booking-system');?></h2>
    <?php if('basic' == SLN_Plugin::getInstance()->getSettings()->get('availability_mode')):?>
                <div class="form-group sln-notice notice-warning">
                    <span class="sln-notice--icon"></span>
                    <span class="sln-notice--content"><?php _e('Switch to "ADVANCED / Availability method" to set custom duration', 'salon-booking-system'); ?></span>
                    <span class="sln-notice--action"><a href="admin.php?page=salon-settings&tab=booking#sln-availability_mode">Change now</a></span>
                </div>
    <?php endif; ?>
    <div class="collapse in sln-box__panelcollapse">
        <div class="row sln-service-price-time">
<!-- default settings -->
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 form-group sln-input--simple">
            <label><?php echo __('Price', 'salon-booking-system') . ' (' . $settings->getCurrencySymbol() . ')' ?></label>
            <?php SLN_Form::fieldText($helper->getFieldName($postType, 'price'), $service->getPrice());?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 form-group sln-select">
            <label><?php _e('Units per session', 'salon-booking-system');?></label>
            <?php SLN_Form::fieldNumeric($helper->getFieldName($postType, 'unit'), $service->getUnitPerHour(), array('max' => 100));?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 form-group sln-select">
            <label><?php _e('Duration', 'salon-booking-system');?></label>
            <?php SLN_Form::fieldTime($helper->getFieldName($postType, 'duration'), $pagenow === 'post-new.php' ? current(array_slice(SLN_Func::getMinutesIntervals(), 1)) : $service->getDuration()); ?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 form-group sln-checkbox sln-service-variable-duration <?php echo !defined("SLN_VERSION_PAY")  ? 'sln-service-variable-duration-disabled' : '' ?>">
        <span class="sln-booking-pro-feature-tooltip">
            <a href="https://www.salonbookingsystem.com/homepage/plugin-pricing/?utm_source=default_status&utm_medium=free-edition-back-end&utm_campaign=unlock_feature&utm_id=GOPRO" target="_blank">
                <?php echo __('Switch to PRO to unlock this feature', 'salon-booking-system') ?>
            </a>
        </span>
        <div class="sln-service-variable-duration--checkbox">
            <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'variable_duration'), $service->isVariableDuration())?>
            <label for="_sln_service_variable_duration"><?php _e('Variable duration', 'salon-booking-system');?></label>
            <p><?php _e('Select this if you want this service has variable duration', 'salon-booking-system');?></p>
        </div>
    </div>
    <div class="sln-clear"></div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4 form-group sln-checkbox">
        <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'secondary'), $service->isSecondary(), array('attrs' => array('data-action' => 'change-service-type', 'data-target' => '#secondary_details')))?>
        <label for="_sln_service_secondary"><?php _e('Secondary', 'salon-booking-system');?></label>
        <p><?php _e('Select this if you want this service considered as secondary level service', 'salon-booking-system');?></p>
    </div>
    <div id="exclusive_service" class="col-xs-12 col-sm-4 col-md-6 col-lg-4 form-group sln-checkbox <?php echo ($service->isSecondary() ? 'hide' : ''); ?>">
        <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'exclusive'), $service->isExclusive())?>
        <label for="_sln_service_exclusive"><?php _e('Exclusive service', 'salon-booking-system');?></label>
        <p><?php _e('If enabled, when a customer choose this service no other services can be booked during the same reservation', 'salon-booking-system');?></p>
    </div>
    <div id="exclusive_service" class="col-xs-12 col-sm-4 col-md-6 col-lg-4 form-group sln-checkbox">
        <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'hide_on_frontend'), $service->isHideOnFrontend())?>
        <label for="_sln_service_hide_on_frontend"><?php _e('Hide on front-end', 'salon-booking-system');?></label>
        <p><?php _e('If enabled this service will never be displayed on front-end', 'salon-booking-system');?></p>
    </div>

    <div id="secondary_details" class="<?php echo ($service->isSecondary() ? '' : 'hide'); ?>">
        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 form-group sln-select">
            <label><?php _e('Display if', 'salon-booking-system');?></label>
            <?php SLN_Form::fieldSelect(
	$helper->getFieldName($postType, 'secondary_display_mode'),
	array(
		'always' => __('always', 'salon-booking-system'),
		'category' => __('belong to the same category', 'salon-booking-system'),
		'service' => __('is child of selected service', 'salon-booking-system'),
	),
	$service->getMeta('secondary_display_mode'),
	array('attrs' => array('data-action' => 'change-secondary-service-mode', 'data-target' => '#secondary_parent_services')),
	true
);?>
        </div>
        <div id="secondary_parent_services" class="col-xs-12 form-group sln-select <?php echo ($service->getMeta('secondary_display_mode') === 'service' ? '' : 'hide'); ?>">
            <label><?php _e('Select parent services', 'salon-booking-system');?></label>
            <?php
/** @var SLN_Wrapper_Service[] $services */
$services = SLN_Plugin::getInstance()->getRepository(SLN_Plugin::POST_TYPE_SERVICE)->getAllPrimary();
$items = array();
foreach ($services as $s) {
	if ($service->getId() != $s->getId()) {
		$items[$s->getId()] = $s->getName();
	}
}
SLN_Form::fieldSelect(
	$helper->getFieldName($postType, 'secondary_parent_services[]'),
	$items,
	(array) $service->getMeta('secondary_parent_services'),
	array('attrs' => array('multiple' => true, 'placeholder' => __('select one or more services', 'salon-booking-system'), 'data-containerCssClass' => 'sln-select-wrapper-no-search')),
	true
);?>
        </div>
    </div>
    <div class="sln-clear"></div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-select">
        <label><?php _e('Execution Order', 'salon-booking-system');?></label>
        <?php SLN_Form::fieldNumeric($helper->getFieldName($postType, 'exec_order'), $service->getExecOrder(), array('min' => 1, 'max' => 10, 'attrs' => array()))?>
    </div>
    <div class="col-xs-12 col-sm-6 form-group sln-box-maininfo align-top">
        <p class="sln-input-help"><?php _e('Use a number to give this service an order of execution compared to the other services.', 'salon-booking-system');?></p>
        <p class="sln-input-help"><?php _e('Consider that this option will affect the availability of your staff members that you have associated with this service.', 'salon-booking-system');?></p>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-checkbox">
        <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'attendants'), !$service->isAttendantsEnabled())?>
        <label for="_sln_service_attendants"><?php _e('No assistant required', 'salon-booking-system');?></label>
        <p><?php _e('No assistant required', 'salon-booking-system');?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-checkbox">
		<?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'parallel_exec'), $service->isExecutionParalleled())?>
        <label for="_sln_service_parallel_exec"><?php _e('Parallel execution', 'salon-booking-system');?></label>
    </div>
    <div class="sln-clear"></div>
</div>
<div class="row">
        <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-checkbox <?php echo !defined("SLN_VERSION_PAY")  ? 'sln-service-variable-duration-disabled' : '' ?>">
            <span class="sln-booking-pro-feature-tooltip">
                <a href="https://www.salonbookingsystem.com/homepage/plugin-pricing/?utm_source=default_status&utm_medium=free-edition-back-end&utm_campaign=unlock_feature&utm_id=GOPRO" target="_blank">
                    <?php echo __('Switch to PRO to unlock this feature', 'salon-booking-system') ?>
                </a>
            </span>
            <div class="sln-service-multiple-attendants-for-service">
                <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'multiple_attendants_for_service'), $service->isMultipleAttendantsForServiceEnabled())?>
                <label for="_sln_service_multiple_attendants_for_service"><?php _e('Multiple attendats', 'salon-booking-system');?></label>
            </div>
        </div>
    <?php if(defined('SLN_VERSION_PAY') && SLN_VERSION_PAY): ?>
        <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-select sln-multiple-count-attendants <?php echo $service->isMultipleAttendantsForServiceEnabled() ? '' : 'hide'; ?>">
            <label><?php _e('Minimum amount', 'salon-booking-system');?></label>
            <?php
            SLN_Form::fieldNumeric(
                        $helper->getFieldName($postType, 'multiple_count_attendants'),
                        $service->getCountMultipleAttendants(),
                        array(
                            'max' => count($service->getAttendants())
                        )
                    );
            ?>
        </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-checkbox <?php echo !defined("SLN_VERSION_PAY") ? 'sln-service-variable-duration-disabled' : '' ?>">
        <span class="sln-booking-pro-feature-tooltip">
            <a href="https://www.salonbookingsystem.com/homepage/plugin-pricing/?utm_source=default_status&utm_medium=free-edition-back-end&utm_campaign=unlock_feature&utm_id=GOPRO" target="_blank">
                <?php echo __('Switch to PRO to unlock this feature', 'salon-booking-system') ?>
            </a>
        </span>
        <div class="sln-service-offset-for-service">
            <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'offset_for_service'), $service->isOffsetEnabled()) ?>
            <label for="_sln_service_offset_for_service"><?php _e('Service Offset', 'salon-booking-system'); ?></label>
            <p><?php _e('If enabled, create a block between two consecutive reservations for this service', 'salon-booking-system') ?></p>
        </div>
    </div>
    <?php if(defined('SLN_VERSION_PAY') && SLN_VERSION_PAY): ?>
        <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-select sln-service-offset-interval <?php echo $service->isOffsetEnabled() ? '' : 'hide' ?>">
            <label><?php _e('Offset Timing', 'salon-booking-system'); ?></label>
            <?php
            $offset_timing = array(
                '5' => '5 ' . __('minutes', 'salon-booking-system'),
                '15' => '15 ' . __('minutes', 'salon-booking-system'),
                '30' => '30 ' . __('minutes', 'salon-booking-system'),
                '45' => '45 ' . __('minutes', 'salon-booking-system'),
                '60' => '1 ' . __('hour', 'salon-booking-system'),
                '120' => '2 ' . __('hours', 'salon-booking-system'),
                '180' => '3 ' . __('hours', 'salon-booking-system'),
                '240' => '4 ' . __('hours', 'salon-booking-system'),
                '300' => '5 ' . __('hours', 'salon-booking-system'),
                '360' => '6 ' . __('hours', 'salon-booking-system'),
                '720' => '12 ' . __('hours', 'salon-booking-system'),
                '1440' => '24 ' . __('hours', 'salon-booking-system'),
                '2880' => '48 ' . __('hours', 'salon-booking-system'),
            );
            SLN_Form::fieldSelect(
                $helper->getFieldName($postType, 'offset_for_service_interval'),
                $offset_timing,
                $service->getOffsetInterval(),
                array(),
                true
            ) ?>
        </div>
    <?php endif ?>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-checkbox <?php echo !defined('SLN_VERSION_PAY') ? 'sln-service-variable-duration-disabled' : '' ?>">
        <span class="sln-booking-pro-feature-tooltip">
            <a href="https://www.salonbookingsystem.com/homepage/plugin-pricing/?utm_source=default_status&utm_medium=free-edition-back-end&utm_campaign=unlock_feature&utm_id=GOPRO" target="_blank">
                <?php echo __('Switch to PRO to unlock this feature', 'salon-booking-system') ?>
            </a>
        </span>
        <div class="sln-service-lock-for-service">
            <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'lock_for_service'), $service->isLockEnabled()); ?>
            <label for="_sln_service_lock_for_service"><?php _e('Service lock', 'salon-booking-system'); ?></label>
            <p><?php _e('If enabled, new bookings for this service are locked for the time range defined in the settings.', 'salon-booking-system'); ?></label>
        </div>
    </div>
    <?php if(defined('SLN_VERSION_PAY') && SLN_VERSION_PAY): ?>
        <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-select sln-service-lock-interval <?php echo $service->isOffsetEnabled() ? '' : 'hide' ?>">
            <label><?php _e('Lock Timing', 'salon-booking-system'); ?></label>
            <?php
            $offset_timing = array(
                '5' => '5 '. __('hours', 'salon-booking-system'),
                '10' => '10 '. __('hours', 'salon-booking-system'),
                '12' => '12 '. __('hours', 'salon-booking-system'),
                '20' => '20 '. __('hours', 'salon-booking-system'),
                '24' => '24 '. __('hours', 'salon-booking-system'),
                '48' => '48 '. __('hours', 'salon-booking-system'),
                '72' => '72 '. __('hours', 'salob-booking-system'),
            );
            SLN_Form::fieldSelect(
                $helper->getFieldName($postType, 'lock_for_service_interval'),
                $offset_timing,
                $service->getMeta('lock_for_service_interval'),
                array(),
                true
            );
            ?>
        </div>
    <?php endif ?>
</div>
<div class="row">
    <?php if ('highend' === $settings->getAvailabilityMode()): ?>
         <div class="col-xs-12 col-sm-6 col-lg-4 form-group sln-checkbox">
            <?php SLN_Form::fieldCheckbox($helper->getFieldName($postType, 'break_duration_enabled'), SLN_Func::getMinutesFromDuration($service->getBreakDuration()))?>
            <label for="_sln_service_break_duration_enabled"><?php _e('Enable service break', 'salon-booking-system');?></label>
            <p><?php _e('-', 'salon-booking-system');?></p>
        </div>
        <div class="clearfix"></div>
        <?php SLN_Action_InitScripts::enqueueServiceBreakSliderRange();?>
        <div class="col-xs-12 col-sm-8- form-group sln-select-- sln-slider-break-duration-wrapper <?php echo SLN_Func::getMinutesFromDuration($service->getBreakDuration()) ? '' : 'hide' ?>">
            <div class="row sln-slider sln-slider--break">
                <div class="col col-time">
                    <input type="text" name="<?php echo $helper->getFieldName($postType, 'break_duration_data') ?>[from]" id=""
                           value="<?php echo $service->getBreakDurationData()['from'] ?>"
                           class="sln-slider--break-time-input-from hidden">
                    <input type="text" name="<?php echo $helper->getFieldName($postType, 'break_duration_data') ?>[to]" id=""
                           value="<?php echo $service->getBreakDurationData()['to'] ?>"
                           class="sln-slider--break-time-input-to hidden">
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="sln-slider--break-length">
                        <label><?php _e('Break length', 'salon-booking-system');?></label>
                        <div class="sln-slider--break-length__actions">
                            <div class="sln-slider--break-length--minus"></div>
                            <?php $break_duration = SLN_Func::getMinutesFromDuration($service->getBreakDuration()); ?>
                            <input class="sln-slider--break-length--input" 
                                    type="text"
                                    id="<?php echo $helper->getFieldName($postType, 'break_duration')?>" 
                                    name="<?php echo $helper->getFieldName($postType, 'break_duration')?>" 
                                    value="<?php echo $break_duration ? $break_duration : $settings->getInterval()?>" 
                                    step="<?php echo $settings->getInterval() ?>" min="0" readonly="">
                        <div class="sln-slider--break-length--plus"></div>
                        </div>
                        <p class="sln-input-help"><?php _ex('The time minimum breke is', 'part of:The time minimum breke is 30\' with increase of 30\' each', 'salon-booking-system');
                        echo ' ', $settings->getInterval(), '\' ';
                        _ex('with increase of', 'part of: The time minimum breke is 30\' with increase of 30\' each', 'salon-booking-system');
                        echo ' '. $settings->getInterval(). '\' '. _x('each', 'part of: The time minimum breke is 30\' with increase of 30\' each', 'salon-booking-system');
                        ?></p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <div class="sln-slider--break-time">
                    <label><?php _e('Break position', 'salon-booking-system');?></label>
                    <div class="sln-slider--break__wrapper">
                    <div class="sliders_step1 col col-slider">
                        <div class="service-break-slider-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                            <div class="ui-slider-range ui-corner-all ui-widget-header" style="width: 0%; left: 0%;">
                                <div class="sln-slider--break-time-break"></div>
                            </div>
                            <span tabindex="0">
                                <div class="sln-slider--break-time-range-min sln-slider--break-time-range-value">
                                    <div class="sln-slider--break-time-from"><div class="sln-slider--break-time-from-value"><?php echo $service->getBreakDurationData()['from']?></div>'</div>
                                </div>
                            </span>
                            <span tabindex="0">
                                <div class="sln-slider--break-time-range-max sln-slider--break-time-range-value">
                                    <div class="sln-slider--break-time-to"><div class="sln-slider--break-time-to-value"><?php echo $service->getBreakDurationData()['to']?></div>'</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="sln-slider--break-time-limits">
                        <span class="sln-slider--break-time-min"><span class="sln-slider--break-time-min-value">0</span>'</span>
                        <span class="sln-slider--break-time-max"><span class="sln-slider--break-time-max-value"><?php echo SLN_Func::getMinutesFromDuration($service->getTotalDuration()) ?></span>'</span>
                    </div>
                    </div>
                    
                    <p class="sln-input-help"><?php _e('Drug the slider to set the break position', 'salon-booking-system') ?></p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
        </div>
    <?php endif;?>
</div>

    <!-- collapse END -->
    </div>
</div>

<?php echo $plugin->loadView(
	'settings/_tab_booking_rules',
	array(
		'availabilities' => $service->getMeta('availabilities'),
		'base' => '_sln_service_availabilities',
		'show_specific_dates' => true,
	)
); ?>
<div class="sln-clear"></div>
<?php if ($plugin->getSettings()->isFormStepsAltOrder()): ?>
<?php $directLink = add_query_arg(
	array(
		'sln_step_page' => 'services',
		'submit_services' => 'next',
		'sln' => array('services' => array($service->getId() => $service->getId())),
	),
	get_permalink(SLN_Plugin::getInstance()->getSettings()->get('pay'))
);
?>
<div class="sln-box sln-box--main sln-box--haspanel">
    <h2 class="sln-box-title sln-box__paneltitle"><?php _e('Direct link', 'salon-booking-system');?></h2>
    <div class="collapse sln-box__panelcollapse">
<div class="row">
    <div class="col-xs-12 form-group sln-select">
        <?php if (SLN_Plugin::getInstance()->getSettings()->get('pay') && get_permalink(SLN_Plugin::getInstance()->getSettings()->get('pay'))): ?>
<p><a href="<?php echo $directLink ?>"><?php echo $directLink ?></a></p>
        <p class="sln-input-help"><?php _e('Use this link to move the user directly to the booking page with the service already selected.', 'salon-booking-system');?></p>
        <?php else: ?>
        <p><?php echo sprintf(__('Please set the Booking page <a href="%s" target="_blank">Settings > General > Salon Booking System required pages</a>', 'salon-booking-system'), admin_url('admin.php?page=salon-settings#sln-salon_booking_system_required_pages'));?></p>
        <?php endif; ?>
    </div>
</div>
    <!-- collapse END -->
    </div>
</div>
<div class="sln-clear"></div>
<?php endif?>

<div class="sln-variable-price row">
    <div class="col-xs-12">
        <div class="sln-box sln-box--main sln-box--haspanel">
            <div class="row sln-variable-price--header">
                <div class="col-xs-6">
                    <div class="sln-box-title">
                        <?php _e('Variable price', 'salon-booking-system');?>
                    </div>
                </div>
                <div class="col-xs-6 <?php echo !defined("SLN_VERSION_PAY")  ? 'sln-variable-price--disabled' : '' ?>">
                    <span class="sln-booking-pro-feature-tooltip">
                        <a href="https://www.salonbookingsystem.com/homepage/plugin-pricing/?utm_source=default_status&utm_medium=free-edition-back-end&utm_campaign=unlock_feature&utm_id=GOPRO" target="_blank">
                            <?php echo __('Switch to PRO to unlock this feature', 'salon-booking-system') ?>
                        </a>
                    </span>
                    <div class="sln-box-title sln-box-title--switch">
                        <div class="sln-switch sln-switch--bare">
                            <?php SLN_Form::fieldCheckboxSwitch($helper->getFieldName($postType, 'variable_price_enabled'), $service->getVariablePriceEnabled(), __('Active', 'salon-booking-system'), __('Disabled', 'salon-booking-system')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sln-variable-price-attendants hide" id="panel-variable-price">
                <div class="row sln-variable-price-attendants--header">
                    <div class="col-xs-6">
                        <?php _e('Assistant', 'salon-booking-system') ?>
                    </div>
                    <div class="col-xs-6">
                        <?php _e('Price', 'salon-booking-system') ?> (<?php echo $settings->getCurrencySymbol() ?>)
                    </div>
                </div>
                <?php if ($service->getAttendants()): ?>
                    <?php foreach($service->getAttendants() as $attendant): ?>
                        <div class="row sln-variable-price-attendants--row">
                            <div class="col-xs-6 sln-variable-price-attendants--row--attendant-title">
                                <?php echo $attendant->getTitle() ?>
                            </div>
                            <div class="col-xs-4 sln-input--simple">
                                <?php SLN_Form::fieldText($helper->getFieldName($postType, 'variable_price['. $attendant->getId() .']'), $service->getVariablePrice($attendant->getId()));?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="row">
                        <div class="col-xs-12 sln-variable-price-attendants--row">
                            <?php _e('No assistants', 'salon-booking-system') ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php do_action('sln.template.service.metabox', $service);?>