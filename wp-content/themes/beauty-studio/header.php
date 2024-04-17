<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 */

/**
 * beauty_studio_action_before_head hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked beauty_studio_set_global -  0
 * @hooked beauty_studio_doctype -  10
 */
do_action( 'beauty_studio_action_before_head' );?>
	<head>

		<?php
		/**
		 * beauty_studio_action_before_wp_head hook
		 * @since Beauty Studio 1.0.0
		 *
		 * @hooked beauty_studio_before_wp_head -  10
		 */
		do_action( 'beauty_studio_action_before_wp_head' );

		wp_head();
		?>

	</head>
<body <?php body_class();?>>

<?php
/**
 * WordPress Default Hook
 * Triggered after the opening <body> tag.
 * wp_body_open hook
 *
 * @since WordPress 5.2
 *
 */
do_action( 'wp_body_open' );
/**
 * beauty_studio_action_before hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked beauty_studio_site_start - 20
 */
do_action( 'beauty_studio_action_before' );

/**
 * beauty_studio_action_before_header hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked beauty_studio_skip_to_content - 10
 */
do_action( 'beauty_studio_action_before_header' );

/**
 * beauty_studio_action_header hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked beauty_studio_header - 10
 */
do_action( 'beauty_studio_action_header' );

/**
 * beauty_studio_action_after_header hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked null
 */
do_action( 'beauty_studio_action_after_header' );

/**
 * beauty_studio_action_before_content hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked null
 */
do_action( 'beauty_studio_action_before_content' );