<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 */

/**
 * beauty_studio_action_after_content hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked null
 */
do_action( 'beauty_studio_action_after_content' );

/**
 * beauty_studio_action_before_footer hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked null
 */
do_action( 'beauty_studio_action_before_footer' );

/**
 * beauty_studio_action_footer hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked beauty_studio_footer - 10
 */
do_action( 'beauty_studio_action_footer' );

/**
 * beauty_studio_action_after_footer hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked null
 */
do_action( 'beauty_studio_action_after_footer' );

/**
 * beauty_studio_action_after hook
 * @since Beauty Studio 1.0.0
 *
 * @hooked beauty_studio_page_end - 10
 */
do_action( 'beauty_studio_action_after' );

wp_footer();
?>
</body>
</html>