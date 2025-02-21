<?php 
 if ( ! defined( 'ABSPATH' ) ) exit;
add_action('plugins_loaded', 'wpsm_servicebox_tr');
function wpsm_servicebox_tr() {
	load_plugin_textdomain( wpshopmart_service_box_text_domain, FALSE, dirname( plugin_basename(__FILE__)).'/languages/' );
}
function wpsm_servicebox_front_script() {
	wp_enqueue_style('wpsm_servicebox-font-awesome-front', wpshopmart_service_box_directory_url.'assets/css/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('wpsm_servicebox_bootstrap-front', wpshopmart_service_box_directory_url.'assets/css/bootstrap-front.css');

	wp_enqueue_style('wpsm_servicebox_owl-carousel-css', wpshopmart_service_box_directory_url.'assets/css/owl.carousel.min.css');

	//JS
	wp_enqueue_script( 'wpsm_servicebox_owl.carousel.min.js', wpshopmart_service_box_directory_url.'assets/js/owl.carousel.min.js',array('jquery'),true);
}

add_action( 'wp_enqueue_scripts', 'wpsm_servicebox_front_script' );
add_filter( 'widget_text', 'do_shortcode');

add_action( 'admin_notices', 'wpsm_service_b_review' );
function wpsm_service_b_review() {

	// Verify that we can do a check for reviews.
	$review = get_option( 'wpsm_service_b_review' );
	$time	= time();
	$load	= false;
	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		add_option('wpsm_service_b_review', $review);
		//$load = true;
	} else {
		// Check if it has been dismissed or not.
		if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + (DAY_IN_SECONDS * 2)) <= $time)) ) {
			$load = true;
		}
	}
	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// welcome message display and rating massage
	?>
	<div class="notice notice-info is-dismissible wpsm-service-b-review-notice">
		<div style="float:left;margin-right:10px;margin-bottom:5px;">
			<img style="width:100%;width: 150px;height: auto;" src="<?php echo esc_url(wpshopmart_service_box_directory_url.'assets/images/icon-show.png'); ?>" />
		</div>
		<h1><?php esc_html_e('Leave A Review!',wpshopmart_service_box_text_domain); ?></h1>
		<p style="font-size:17px;"><?php esc_html_e('Hi! We saw you have been using ',wpshopmart_service_box_text_domain); ?><strong><?php esc_html_e('Service Box Plugin',wpshopmart_service_box_text_domain); ?></strong><?php esc_html_e(' for a few days and wanted to ask for your help to ',wpshopmart_service_box_text_domain); ?><strong><?php esc_html_e('make the plugin better',wpshopmart_service_box_text_domain); ?></strong><?php esc_html_e('.We just need a minute of your time to rate the plugin. Thank you!',wpshopmart_service_box_text_domain); ?> <strong><?php _e( '~ wpshopmart', '' ); ?></strong></p>
		<p style="font-size:17px;"> 
			<a style="color: #fff;background: #27d63c;padding: 5px 7px 4px 6px;border-radius: 4px;text-decoration:none" href="https://wordpress.org/support/plugin/service-box/reviews/?filter=5#new-post" class="wpsm-service-b-dismiss-review-notice wpsm-service-b-review-out" target="_blank" rel="noopener"><?php esc_html_e("Sure! I'd love to!",wpshopmart_service_box_text_domain); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #31a3dd;padding: 5px 7px 4px 6px;border-radius: 4px;text-decoration:none" href="#" class="wpsm-service-b-dismiss-review-notice wpsm-rated" target="_self" rel="noopener"><?php _e( 'I already did', '' ); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #040404;padding: 5px 7px 4px 6px;border-radius: 4px;text-decoration:none" href="#"  class="wpsm-service-b-dismiss-review-notice wpsm-rate-later" target="_self" rel="noopener"><?php _e( 'Nope, maybe later', '' ); ?></a>
			
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.wpsm-service-b-dismiss-review-notice, .wpsm-service-b-dismiss-notice .notice-dismiss', function( event ) {
				if ( $(this).hasClass('wpsm-service-b-review-out') ) {
					var wpsm_rate_data_val = "1";
				}
				if ( $(this).hasClass('wpsm-rate-later') ) {
					var wpsm_rate_data_val =  "2";
					event.preventDefault();
				}
				if ( $(this).hasClass('wpsm-rated') ) {
					var wpsm_rate_data_val =  "3";
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'wpsm_service_b_dismiss_review',
					wpsm_rate_data_service_b : wpsm_rate_data_val
				});
				
				$('.wpsm-service-b-review-notice').hide();
				//location.reload();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_wpsm_service_b_dismiss_review', 'wpsm_service_b_dismiss_review' );
function wpsm_service_b_dismiss_review() {
	if ( ! $review ) {
		$review = array();
	}
	
	if($_POST['wpsm_rate_data_service_b']=="1"){
		
		
	}
	if($_POST['wpsm_rate_data_service_b']=="2"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		update_option( 'wpsm_service_b_review', $review );		
	}
	if($_POST['wpsm_rate_data_service_b']=="3"){
		$review['time'] 	 = time();
		$review['dismissed'] = true;
		update_option( 'wpsm_service_b_review', $review );		
	}	
	die;
}

function wpsm_service_r_header_info() {
 	if(get_post_type()=="wpsm_servicebox_r") {
		?>
		<style>
		@media screen and (max-width: 760px){
			.wpsm_ac_h_i{
				display:none;
				
			}
		}
		.wpsm_ac_h_i{
			    background-color: #4916d7;
				background: -webkit-linear-gradient(60deg, #4916d7, #be94f8);
				background: linear-gradient(60deg, #4916d7, #be94f8);
				-webkit-box-shadow: 0px 13px 21px -10px rgba(128,128,128,1);
				-moz-box-shadow: 0px 13px 21px -10px rgba(128,128,128,1);
				box-shadow: 0px 13px 21px -10px rgba(128,128,128,1);			
				margin-left: -20px;
				
				padding-top:20px;
			    overflow: HIDDEN;
				text-align: center;
		}
		.wpsm_ac_h_i .wpsm_ac_h_b{
			color: white;
			font-size: 30px;
			font-weight: bolder;
			padding: 0 0 0px 0;
		}
		.wpsm_ac_h_i .wpsm_ac_h_b .dashicons{
			font-size: 40px;
			position: absolute;
			margin-left: -45px;
			margin-top: -10px;
		}
		 .wpsm_ac_h_small{
			font-weight: bolder;
			color: white;
			font-size: 18px;
			padding: 0 0 15px 15px;
		}
		.wpsm_ac_h_i a{
			text-decoration: none;
		}
		@media screen and ( max-width: 600px ) {
			.wpsm_ac_h_i{ padding-top: 60px; margin-bottom: -50px; }
			.wpsm_ac_h_i .WlTSmall { display: none; }
		}
		.texture-layer {
			background: rgba(0,0,0,0);
			padding-top: 0px;
			padding: 0;
		}
		.wpsm_ac_h_i  ul{
			padding:0px 0px 0px 0px;
		}
		.wpsm_ac_h_i  li {
			text-align:left;
			color:#fff;
			font-size: 16px;
			line-height: 26px;
			font-weight: 600;
			
		}
		.wpsm_ac_h_i  li i{
			margin-right:6px ;
			margin-bottom:10px;	
			font-size: 12px;			
		}
		 
		.wpsm_ac_h_i .btn-danger{
			font-size: 29px;
			background-color: #000000;
			border-radius:1px;
			margin-right:10px;
			margin-top: 0px;
			border-color:#000;
			 
		}
		.wpsm_ac_h_i .btn-success{
			font-size: 28px;
			border-radius:1px;
			background-color: #ffffff;
			border-color: #ffffff;
			color:#000;
		}
		.btn-danger {
			color: #fff;
			background-color: #01c698 !important;
    border-color: #01c698 !important;
		}
		.pad-o{
			padding:0px;
			
		}

		</style>
			<div class="wpsm_ac_h_i ">
				<div class="row texture-layer">
					<div class="col-md-3">
						<img style="width:100%;height:auto;padding:0 15px;" src="<?php echo esc_url(wpshopmart_service_box_directory_url.'assets/images/banner.png'); ?>"  class="img-responsive"/>
					
					</div>
				
					
					
						<div class="row col-md-9">
							<div class="wpsm_ac_h_b col-md-6" style="text-align:left">
								<a class="btn btn-danger btn-lg "  href="https://wpshopmart.com/plugins/service-showcase-pro-plugin-wordpress/" target="_blank"><?php esc_html_e('Buy Pro Version',wpshopmart_service_box_text_domain); ?></a><a class="btn btn-success btn-lg " href="http://demo.wpshopmart.com/service-showcase-pro-demo-for-wordpress/" target="_blank"><?php esc_html_e('Try Demo Before Buy',wpshopmart_service_box_text_domain); ?></a>
							</div>								
							<div class="col-md-6" style="text-align:left">							
								<h1 style="color: #fff;
							    font-size: 45px;
							    font-weight: 800;
							    margin-top: 6px;"><?php esc_html_e('Service Box Pro Features',wpshopmart_service_box_text_domain); ?></h1>							
							</div>					
							<a href="https://wpshopmart.com/plugins/service-showcase-pro-plugin-wordpress/" target="_blank">
							<div class="row col-md-12" style="padding-bottom:20px;">
								
									<div class="col-md-3">
							<ul>
								<li> <i class="fa fa-check"></i><?php esc_html_e('55+ Design Templates',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Carousel/Slider Layout',wpshopmart_service_box_text_domain); ?>  </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Individual Color Scheme',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Section Background image',wpshopmart_service_box_text_domain); ?>  </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('500+ Google Fonts',wpshopmart_service_box_text_domain); ?> </li>
							</ul>
						</div>
						<div class="col-md-3">
							<ul>
								<li> <i class="fa fa-check"></i><?php esc_html_e('10+ Column Layout',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Custom Image icon',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Hover Animation',wpshopmart_service_box_text_domain); ?>  </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Widget Option',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('500+ Glyphicon Icons Support',wpshopmart_service_box_text_domain); ?> </li>
							</ul>
						</div>
						<div class="col-md-3">
							<ul>
								<li> <i class="fa fa-check"></i><?php esc_html_e('500+ Dashicons Icon Support',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('1000+ Font Awesome Icon Support',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Set Auto Height',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Unlimited Shortcode',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Drag And Drop Builder',wpshopmart_service_box_text_domain); ?> </li>
								
							</ul>
						</div>
						<div class="col-md-3">
							<ul>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Transparent Animation',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Border Color Customization',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('Unlimited Color Scheme',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('High Priority Support',wpshopmart_service_box_text_domain); ?> </li>
								<li> <i class="fa fa-check"></i><?php esc_html_e('All Browser Compatible',wpshopmart_service_box_text_domain); ?> </li>
							</ul>
						</div>
								
							</div>
							</a>				
						</div>	
							
				</div>
			
			</div>
		<?php  
	}
}
add_action('in_admin_header','wpsm_service_r_header_info'); 
?>