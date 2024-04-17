<?php
/**
 * Beauty Studio Theme Customizer.
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 */

/*
* file for upgrade to pro
*/
require beauty_studio_file_directory('acmethemes/customizer/customizer-pro/class-customize.php');

/*
* file for customizer core functions
*/
require beauty_studio_file_directory('acmethemes/customizer/customizer-core.php');

/*
* file for customizer sanitization functions
*/
require beauty_studio_file_directory('acmethemes/customizer/sanitize-functions.php');

/**
 * Adding different options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function beauty_studio_customize_register( $wp_customize ) {

    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    /*saved options*/
    $options  = beauty_studio_get_theme_options();

    /*defaults options*/
    $defaults = beauty_studio_get_default_theme_options();

    /*custom controls*/
    require beauty_studio_file_directory('acmethemes/customizer/custom-controls.php');
	require beauty_studio_file_directory('acmethemes/customizer/customizer-repeater/customizer-control-repeater.php');

    /*
     * file for feature panel of home page
     */
    require beauty_studio_file_directory('acmethemes/customizer/feature-section/feature-panel.php');

    /*
    * file for header panel
    */
    require beauty_studio_file_directory('acmethemes/customizer/header-options/header-panel.php');

    /*
    * file for customizer footer section
    */
    require beauty_studio_file_directory('acmethemes/customizer/footer-options/footer-panel.php');

    /*
    * file for design/layout panel
    */
    require beauty_studio_file_directory('acmethemes/customizer/design-options/design-panel.php');

	/*
   * file for single panel
   */
	require beauty_studio_file_directory('acmethemes/customizer/single-posts/single-post-panel.php');

    /*
     * file for options panel
     */
    require beauty_studio_file_directory('acmethemes/customizer/options/options-panel.php');

	/*woocommerce options*/
	if ( beauty_studio_is_woocommerce_active() ) :
		require_once beauty_studio_file_directory('acmethemes/customizer/wc-options/wc-panel.php');
	endif;

    /*sorting core and widget for ease of theme use*/
    $wp_customize->get_section( 'static_front_page' )->priority = 10;
    
    $beauty_studio_home_section = $wp_customize->get_section( 'sidebar-widgets-beauty-studio-home' );
    if ( ! empty( $beauty_studio_home_section ) ) {
        $beauty_studio_home_section->panel         = '';
        $beauty_studio_home_section->title         = esc_html__( 'Home Main Content Area ', 'beauty-studio' );
        $beauty_studio_home_section->priority      = 80;
    }
    /*customizing default colors section and adding new controls-setting too*/
    $wp_customize->get_section( 'colors' )->panel = 'beauty-studio-design-panel';
    $wp_customize->get_section( 'colors' )->title = esc_html__( 'Basic Color', 'beauty-studio' );
    $wp_customize->get_section( 'background_image' )->priority = 100;

    /*Background Image*/
    $wp_customize->get_section( 'background_image' )->panel = 'beauty-studio-design-panel';
    $wp_customize->get_section( 'background_image' )->priority = 60;

    /*adding header image inside this panel*/
    $wp_customize->get_section( 'header_image' )->panel = 'beauty-studio-header-panel';
    $wp_customize->get_section( 'header_image' )->description = esc_html__( 'Applied to header image of inner pages.', 'beauty-studio' );

    /*WordPress 5.8 TODO*/
    /*$beauty_studio_popup_widget_area = $wp_customize->get_section( 'sidebar-widgets-popup-widget-area' );
    if ( ! empty( $beauty_studio_popup_widget_area ) ) {
        $beauty_studio_popup_widget_area->panel = 'beauty-studio-header-panel';
        $beauty_studio_popup_widget_area->title = esc_html__( 'Popup Widgets', 'beauty-studio' );
        $beauty_studio_popup_widget_area->priority = 999;

        $beauty_studio_popup_widget_title = $wp_customize->get_control( 'beauty_studio_theme_options[beauty-studio-popup-widget-title]' );
        if ( ! empty( $beauty_studio_popup_widget_title ) ) {
            $beauty_studio_popup_widget_title->section  = 'sidebar-widgets-popup-widget-area';
            $beauty_studio_popup_widget_title->priority = -1;
        }
    }*/
}
add_action( 'customize_register', 'beauty_studio_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function beauty_studio_customize_preview_js() {
    wp_enqueue_script( 'beauty-studio-customizer', get_template_directory_uri() . '/acmethemes/core/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'beauty_studio_customize_preview_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function beauty_studio_customize_controls_scripts() {
    wp_enqueue_script( 'beauty-studio-customizer-controls', get_template_directory_uri() . '/acmethemes/core/js/customizer-controls.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'beauty_studio_customize_controls_scripts' );