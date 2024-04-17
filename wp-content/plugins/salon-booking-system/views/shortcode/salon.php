<?php
/**
 * @var string               $content
 * @var SLN_Shortcode_Salon $salon
 */

$style = $salon->getStyleShortcode();
$cce = !$plugin->getSettings()->isCustomColorsEnabled();
$class = SLN_Enum_ShortcodeStyle::getClass($style);
?>
<div id="sln-salon" class="sln-bootstrap container-fluid <?php
            echo $class;
            if(!$cce) {
              echo ' sln-customcolors';
            }
            echo ' sln-step-' . $salon->getCurrentStep(); ?>">
<div id="sln-salon__content" class="sln-bootstrap container-fluid <?php
            echo $class . '__content';
            echo ' sln-salon__content-step-' . $salon->getCurrentStep(); ?>">
    <?php

    $args = array(
        'key'          => 'Book an appointment',
        'label'        => __('Book an appointment', 'salon-booking-system'),
        'tag'          => 'h2',
        'textClasses'  => 'sln-salon-title',
        'inputClasses' => '',
        'tagClasses'   => 'sln-salon-title',
    );
    echo $plugin->loadView('shortcode/_editable_snippet', $args);
    do_action('sln.booking.salon.before_content', $salon, $content);

    $step = $salon->getStepObject($salon->getCurrentStep());
    $additional_errors = !empty($additional_errors)? $additional_errors : $step->getAddtitionalErrors();
    $errors = !empty($errors) ? $errors : $step->getErrors();
    include '_errors.php';
    include '_additional_errors.php';
    include '_mixpanel_track.php';
    echo apply_filters('sln.booking.salon.'.$step->getStep().'-step.add-params-html', '');
    $args = array(
        'key'          => $step->getTitleKey(),
        'label'        => $step->getTitleLabel(),
        'tag'          => 'h2',
        'textClasses'  => 'salon-step-title',
        'inputClasses' => '',
        'tagClasses'   => 'salon-step-title',
    ); 
    echo $plugin->loadView('shortcode/_editable_snippet', $args);?>
        <div class="sln-progbar__wrapper">
            <?php 
                //$stepstotal =count($salon->getSteps());
                $steps = $salon->getSteps();
                if (($key = array_search('fbphone', $steps)) !== false) {
                    unset($steps[$key]);
                }
                $stepstotal =count($steps);
            ?>
            <div class="sln-progbar__text">
            <?php
                _e('Step','salon-booking-system');
                $sommaA = 1;
                foreach($steps as $step) {
                    echo ' <span>';
                    if ($step == $salon->getCurrentStep()) {
                        echo $sommaA . '/' . $stepstotal;
                    }
                    echo '</span>';
                    $sommaA++;
                }
            ?>
            </div>
            <div class="sln-progbar">
             <?php
                //print_r($salon->getSteps());
                //print_r($salon->getCurrentStep());
                //echo $stepstotal;
                $revsteps = array_reverse($steps);
                $sommaB = 1;
                foreach($revsteps as $step) {
                    echo '<div class="sln-progbar__item ';
                    if ($step == $salon->getCurrentStep()) {
                        echo 'sln-progbar__item--current';
                    }
                    echo ' sln-progbar__item--' . $step . '" data-zindex="' . $sommaB .'"><span class="sr-only">' . $step . '</span></div>';
                    $sommaB++;
                }
            ?>
            </div>
        </div>
    <?php
    echo $content;
    ?>
<div id="sln-notifications"></div> 
<div id="sln-salon__follower"></div>
</div>
<!-- .sln-salon__wrapper // END -->
</div>
<?php if(defined('SLN_SPECIAL_EDITION') && SLN_SPECIAL_EDITION && !isset($_POST['sln'])): ?>
<div id="sln-plugin-credits" class="sln-credits <?php
            echo $class . '-credits'; ?>"><?php _e('Proudly powered by', 'salon-booking-system') ?> <a target="_blanck" href="https://www.salonbookingsystem.com/plugin-pricing/#utm_source=plugin-credits&utm_medium=booking-form&utm_campaign=booking-form&utm_id=plugin-credits"><?php _e('Salon Booking System', 'salon-booking-system'); ?></a></div>
<?php endif; ?>