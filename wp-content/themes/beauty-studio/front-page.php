<?php
/**
 * The front-page template file.
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 * @since Beauty Studio 1.0.0
 */
get_header();

/**
 * beauty_studio_action_front_page hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked beauty_studio_featured_slider -  10
 * @hooked beauty_studio_front_page -  20
 */
do_action( 'beauty_studio_action_front_page' );

get_footer();