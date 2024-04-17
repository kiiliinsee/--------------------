<button
    <?php if($plugin->getSettings()->isAjaxEnabled()): ?>
        data-salon-data="<?php echo "sln_step_page=summary&submit_summary=next" ?>" data-salon-toggle="next"
    <?php endif?>
    id="sln-step-submit" type="submit" name="submit_summary" value="next">
    <?php echo __('Next step', 'salon-booking-system'); ?> <i class="glyphicon glyphicon-chevron-right"></i>
</button>