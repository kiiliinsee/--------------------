<?php
/**
 * Plugin generic functions file
 *
 * @package WP Featured Content and Slider
 * @since 1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to get unique value number
 * 
 * @package WP Featured Content and Slider
 * @since 1.4
 */
function wpfcas_get_unique() {
	static $unique = 0;
	$unique++;

	//For Elementor & Beaver Builder
	if( ( defined('ELEMENTOR_PLUGIN_BASE') && isset( $_POST['action'] ) && $_POST['action'] == 'elementor_ajax' )
	|| ( class_exists('FLBuilderModel') && ! empty( $_POST['fl_builder_data']['action'] ) )
	|| ( function_exists('vc_is_inline') && vc_is_inline() ) ) {
		$unique = current_time('timestamp') . '-' . rand();
	}

	return $unique;
}

/**
 * Function to get post excerpt
 * 
 * @package WP Featured Content and Slider
 * @since 1.4
 */
function wpfcas_get_post_excerpt( $post_id = null, $content = '', $word_length = '55', $more = '...' ) {

	$word_length = !empty($word_length) ? $word_length : '55';

	// If post id is passed
	if( ! empty( $post_id ) ) {
		if ( has_excerpt( $post_id ) ) {
			$content = get_the_excerpt();
		} else {
			$content = !empty($content) ? $content : get_the_content();
		}
	}

	if( ! empty( $content ) ) {
		$content = strip_shortcodes( $content ); // Strip shortcodes
		$content = wp_trim_words( $content, $word_length, $more );
	}

	return $content;
}

/**
 * Function to get featured content column
 * 
 * @package WP Featured Content and Slider
 * @since 1.4
 */
function wpfcas_column( $row = '' ) {
	if($row == 2) {
		$per_row = 6;
	} else if($row == 3) {
		$per_row = 4;	
	} else if($row == 4) {
		$per_row = 3;
	} else if($row == 1) {
		$per_row = 12;
	} else{
		$per_row = 12;
	}

	return $per_row;
}

/**
 * Sanitize Multiple HTML class
 * 
 * @package WP Featured Content and Slider
 * @since 1.4
 */
function wpfcas_sanitize_html_classes($classes, $sep = " ") {
	$return = "";

	if( $classes && ! is_array( $classes ) ) {
		$classes = explode($sep, $classes);
	}

	if( ! empty( $classes ) ) {
		foreach($classes as $class){
			$return .= sanitize_html_class($class) . " ";
		}
		$return = trim( $return );
	}

	return $return;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @since 2.3
 */
function wpfcas_clean( $var ) {

	if ( is_array( $var ) ) {
		return array_map( 'wpfcas_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

/**
 * Sanitize URL
 * 
 * @since 1.0
 */
function wpfcas_clean_url( $url ) {
	return esc_url_raw( trim( $url ) );
}

/**
 * Function to get template design
 * 
 * @package WP Featured Content and Slider
 * @since 1.4
 */
function wpfcas_designs() {
	$design_arr = array(
		'design-1'	=> __( 'Design 1', 'wp-featured-content-and-slider' ),
		'design-2'	=> __( 'Design 2', 'wp-featured-content-and-slider' ),
		'design-3'	=> __( 'Design 3', 'wp-featured-content-and-slider' ),
		'design-4'	=> __( 'Design 4', 'wp-featured-content-and-slider' ),
		);
	return apply_filters('wpfcas_designs', $design_arr );
}