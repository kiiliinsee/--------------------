<?php
/**
 * Function to sanitize number
 *
 * @since Beauty Studio 1.0.0
 *
 * @param $beauty_studio_input
 * @param $beauty_studio_setting
 * @return int || float || numeric value
 *
 */
if ( ! function_exists( 'beauty_studio_sanitize_number' ) ) :
	function beauty_studio_sanitize_number ( $beauty_studio_input, $beauty_studio_setting ) {
		$beauty_studio_sanitize_text = sanitize_text_field( $beauty_studio_input );

		// If the input is an number, return it; otherwise, return the default
		return ( is_numeric( $beauty_studio_sanitize_text ) ? $beauty_studio_sanitize_text : $beauty_studio_setting->default );
	}
endif;

/**
 * Sanitizing the checkbox
 *
 * @since Beauty Studio 1.0.0
 *
 * @param $checked
 * @return Boolean
 *
 */
if ( !function_exists('beauty_studio_sanitize_checkbox') ) :
	function beauty_studio_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
endif;

/**
 * Sanitizing the page/post
 *
 * @since Beauty Studio 1.0.0
 *
 * @param $input
 * @return int
 *
 */
if ( !function_exists('beauty_studio_sanitize_page') ) :
	function beauty_studio_sanitize_page( $input ) {
		// Ensure $input is an absolute integer.
		$page_id = absint( $input );
		// If $page_id is an ID of a published page, return it; otherwise, return false
		return ( 'publish' == get_post_status( $page_id ) ? $page_id : false );
	}
endif;

/**
 * Sanitizing the select callback example
 *
 * @since Beauty Studio 1.0.0
 *
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param $input
 * @param $setting
 * @return string
 *
 */
if ( !function_exists('beauty_studio_sanitize_select') ) :
	function beauty_studio_sanitize_select( $input, $setting ) {

		$input = sanitize_text_field( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
endif;

/**
 * Allowed HTML
 *
 * @param $input
 * @return string
 *
 */
if ( !function_exists('beauty_studio_sanitize_allowed_html') ) :
	function beauty_studio_sanitize_allowed_html ( $input ) {
		$allowed_html = wp_kses_allowed_html();
		$output = wp_kses( $input, $allowed_html );
		return $output;
	}
endif;