<div class="sln-account__header">
<h3 class="text sln-account__title">
	<?php
	echo __('Welcome back ', 'salon-booking-system') . '<strong>' . $data['user_name'] . '</strong>';
	?>
</h3>
<?php if ($data['customer_fidelity_score_enabled']): ?>
	<span class="sln-account__score">
	    <?php echo $data['customer_fidelity_score'] ?>
	    <span class="sr-only"><?php _e('Current Score', 'salon-booking-system') ?></span>
	</span>
<?php endif ?>
</div>
<!-- Nav tabs -->
<div class="sln-account__nav__wrapper">
	<nav id="sln-account__nav" class="sln-account__nav__inner">
		<ul class="sln-account__nav" role="tablist">
			<li class="sln-account__nav__item sln-account__nav__appointments active" role="presentation"><a data-target="#sln-account__appointments__content" aria-controls="sln-account__appointments__content" role="tab" data-toggle="tab"><span><?php _e('Appointments', 'salon-booking-system')?></span></a></li>
			<?php do_action('sln.my_account.nav'); ?>
			<li class="sln-account__nav__item sln-account__nav__profile" role="presentation"><a data-target="#sln-account__profile__content" aria-controls="sln-account__profile__content" role="tab" data-toggle="tab"><span><?php _e('Profile', 'salon-booking-system')?></span></a></li>
		</ul>
	</nav>
</div>
<!-- Tab panes -->
<div class="tab-content sln-salon-my-account-tab-content--">
	<div role="tabpanel" class="tab-pane sln-account__tabpanel sln-account__tabpanel--bookings active" id="sln-account__appointments__content">
		<?php if ($data['cancelled']): ?>
			<p class="hint"><?php _e('The booking has been cancelled', 'salon-booking-system');?></p>
		<?php endif?>
		<?php if (!empty($data['new']['items'])): ?>
			<?php
$data['table_data'] = $data['new'];
$data['table_data']['mode'] = 'new';

include '_salon_my_account_details_table_rows.php';

unset($data['table_data']);
?>
		<?php else: ?>
			<p class="hint"><?php _e('You don\'t have upcoming reservations, do you want to re-schedule your last appointment with us?', 'salon-booking-system');?></p>
			<?php
if (!empty($data['history']['items'])) {
	$historySuccesfulItems = $data['history_successful']['items'];

	$data['table_data'] = array(
		'items' => $historySuccesfulItems,
		'mode' => 'history',
	);

	include '_salon_my_account_details_table_rows.php';
	unset($data['table_data']);
}
?>
		<?php endif;?>
  <a class="sln-account__history__trigger collapsed" data-toggle="collapse" href="#sln-account__history" role="button" aria-expanded="false" aria-controls="sln-account__history">
  	<h3><?php _e('Display past reservations', 'salon-booking-system');?></h3>
  	<span class="sln-switch">
  		<span class="sr-only"><?php _e('Reservations history', 'salon-booking-system')?></span>
  	</span>
  </a>
<div class="collapse sln-account__history" id="sln-account__history">
  <div class="card card-body">
		<?php if (!empty($data['history']['items'])): ?>
			<div id="sln-salon-my-account-history-content--">
				<?php
$data['table_data'] = $data['history'];
$data['table_data']['mode'] = 'history';

include '_salon_my_account_details_table_rows.php';
unset($data['table_data']);
?>
				<div class="row">
					<div class="col-xs-12 salon-scroll-down--note sln-account__history__scrollformore">
						<p><?php _e('Scroll down to load past reservations', 'salon-booking-system'); ?></p>
					</div>
				</div>
			</div>

		<?php else: ?>
			<p class="hint"><?php _e('No bookings', 'salon-booking-system');?></p>
		<?php endif;?>	
  </div>
</div>
<div class="sln-account__tabpanel__actions">
	<div class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--fullwidth">
		<a href="<?php echo $data['booking_url'] ?>"><?php _e('Make a new reservation', 'salon-booking-system')?></a>
	</div>
</div>
</div>
	<?php do_action('sln.my_account.content', array_merge($data['history']['items'], $data['new']['items'])); ?>
	<div role="tabpanel" class="tab-pane sln-account__tabpanel sln-account__tabpanel--profile" id="sln-account__profile__content">
		<?php include '_salon_my_account_profile.php';?>
	</div>
	<div id="ratingModal" class="modal fade" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div id="step1">
						<p><?php _e('Hi', 'salon-booking-system');?> <?php echo $data['user_name'] ?>!</p>
						<p><?php _e('How was your experience with us this time? (required)', 'salon-booking-system');?></p>
						<p><textarea id="" placeholder="<?php _e('please, drop us some lines to understand if your experience has been  in line  with your expectations', 'salon-booking-system');?>"></textarea></p>
						<p>
						<div class="rating" id="<?php echo $item['id']; ?>"></div>
						<span><?php _e('Rate our service (required)', 'salon-booking-system');?></span>
						</p>
						<p>
							<button type="button" class="btn btn-primary" onclick="sln_myAccount.sendRate();"><?php _e('Send your review', 'salon-booking-system');?></button>
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel', 'salon-booking-system');?></button>
						</p>
					</div>
					<div id="step2">
						<p><?php _e('Thank you for your review. It will help us improving our services.', 'salon-booking-system');?></p>
						<p><?php _e('We hope to see you again at', 'salon-booking-system');?> <?php echo $data['gen_name']; ?></p>
					</div>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
</div>
