<?php
/**
 * Template design-4
 *
 * @package WP Featured Content and Slider
 * @since 1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="<?php echo esc_attr($css_class) ?>">
	<div class="featured-content-position">
		<div class="featured-content-image-bg"> 
			<img src="<?php echo esc_url($feat_image); ?>"alt="<?php the_title_attribute(); ?>" />
		</div>
		<div class="featured-content-overlay">
			<div class="featured-content-overlay-inner">
				<div class="featured-content-image <?php echo esc_attr($image_style); ?>">
					<?php if( $sliderurl != '' ) { ?>
						<a href="<?php echo esc_url($sliderurl); ?>" >
							<?php if($wpfcasIcon != '') { 
								echo '<i style="color:'.esc_attr($fa_icon_color).'" class="'.esc_attr($wpfcasIcon).'"></i>';
							} ?>
						</a>
					<?php } else {
						if($wpfcasIcon != '') {
							echo '<i style="color:'.esc_attr($fa_icon_color).'" class="'.esc_attr($wpfcasIcon).'"></i>';
						}
					} ?>
				</div>
				<h3 class="entry-title">
					<?php if($sliderurl != '') { ?>
						<a href="<?php echo esc_url($sliderurl); ?>" >
							<?php echo get_the_title(); ?>
						</a>
					<?php } else {
						echo get_the_title();
					} ?>
				</h3>

				<?php if( $show_content == "true" && !empty( $fcontent ) ) { ?>
					<div class="featured_short_content">
						<div class="sub-content"><?php echo wp_kses_post($fcontent); ?></div>
					</div>
				<?php }

				if($display_read_more == 'true' && $sliderurl != '') { ?>
					<div class="featured-read-more">
						<a href="<?php echo esc_url($sliderurl); ?>" >
							<?php esc_html_e( 'Read More', 'wp-featured-content-and-slider' ); ?>
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>