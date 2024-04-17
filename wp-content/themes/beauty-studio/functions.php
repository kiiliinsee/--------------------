<?php
/**
 * Beauty Studio functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 */

/**
 * Require init.
 */

/**
 * Default Theme layout options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_theme_layout
 *
 */
if ( !function_exists('beauty_studio_get_default_theme_options') ) :
    function beauty_studio_get_default_theme_options() {

        $default_theme_options = array(

            /*logo and site title*/
            'beauty-studio-display-site-logo'      => '',
            'beauty-studio-display-site-title'     => 1,
            'beauty-studio-display-site-tagline'   => 1,

            /*header height*/
            'beauty-studio-header-height'          => 300,
            'beauty-studio-header-image-display'   => 'normal-image',

            /*header top*/
            'beauty-studio-enable-header-top'                      => '',
            'beauty-studio-header-top-menu-display-selection'      => 'right',
            'beauty-studio-header-top-news-display-selection'      => 'left',
            'beauty-studio-header-top-social-display-selection'    => 'right',
            'beauty-studio-newsnotice-title'       => esc_html__( 'News :', 'beauty-studio' ),
            'beauty-studio-newsnotice-cat'         => 0,

            /*menu options*/
            'beauty-studio-enable-transparent'             => 1,
            'beauty-studio-enable-sticky'                  => '',
            'beauty-studio-menu-right-button-options'      => 'disable',
            'beauty-studio-menu-right-button-title'        => esc_html__('Request a Quote','beauty-studio'),
            'beauty-studio-menu-right-button-link'         => '',
            'beauty-studio-enable-cart-icon'               => '',

            /*feature section options*/
            'beauty-studio-enable-feature'                         => '',
            'beauty-studio-slider-selection-from'                  => 'from-page',
            'beauty-studio-slides-data'                            => '',
            'beauty-studio-feature-slider-enable-animation'        => 1,
            'beauty-studio-feature-slider-display-title'           => 1,
            'beauty-studio-feature-slider-display-excerpt'         => 1,
            'beauty-studio-fs-image-display-options'               => 'full-screen-bg',
            'beauty-studio-feature-slider-text-align'              => 'text-left',

            /*basic info*/
            'beauty-studio-feature-info-display-options'           => 'hide',
            'beauty-studio-feature-info-number'    => 4,
            'beauty-studio-first-info-icon'        => 'fa-calendar',
            'beauty-studio-first-info-title'       => esc_html__('Send Us a Mail', 'beauty-studio'),
            'beauty-studio-first-info-desc'        => esc_html__('domain@example.com ', 'beauty-studio'),
            'beauty-studio-second-info-icon'       => 'fa-map-marker',
            'beauty-studio-second-info-title'      => esc_html__('Our Location', 'beauty-studio'),
            'beauty-studio-second-info-desc'       => esc_html__('Elmonte California', 'beauty-studio'),
            'beauty-studio-third-info-icon'        => 'fa-phone',
            'beauty-studio-third-info-title'       => esc_html__('Call Us', 'beauty-studio'),
            'beauty-studio-third-info-desc'        => esc_html__('01-23456789-10', 'beauty-studio'),
            'beauty-studio-forth-info-icon'        => 'fa-envelope-o',
            'beauty-studio-forth-info-title'       => esc_html__('Office Hours', 'beauty-studio'),
            'beauty-studio-forth-info-desc'        => esc_html__('8 hours per day', 'beauty-studio'),

            /*footer options*/
            'beauty-studio-footer-copyright'                       => esc_html__( '&copy; Dynamic Copyright Text', 'beauty-studio' ),
            'beauty-studio-footer-copyright-beside-option'         => 'footer-menu',
            'beauty-studio-footer-bg-img'                          => '',

            /*layout/design options*/
            'beauty-studio-pagination-option'      => 'numeric',

            'beauty-studio-enable-animation'       => '',

            'beauty-studio-single-sidebar-layout'              => 'right-sidebar',
            'beauty-studio-front-page-sidebar-layout'          => 'right-sidebar',
            'beauty-studio-archive-sidebar-layout'             => 'right-sidebar',

            'beauty-studio-blog-archive-img-size'              => 'full',
            'beauty-studio-blog-archive-content-from'          => 'excerpt',
            'beauty-studio-blog-archive-excerpt-length'        => 42,
            'beauty-studio-blog-archive-more-text'             => esc_html__( 'Read More', 'beauty-studio' ),

            'beauty-studio-primary-color'          => '#ec5598',
            'beauty-studio-header-top-bg-color'    => '#590d88',
            'beauty-studio-footer-bg-color'        => '#6a1b9a',
            'beauty-studio-footer-bottom-bg-color' => '#590d88',
            'beauty-studio-link-color'             => '#ec5598',
            'beauty-studio-link-hover-color'       => '#ed2d83',

            /*Front Page*/
            'beauty-studio-hide-front-page-content' => '',
            'beauty-studio-hide-front-page-header'  => '',

            /*woocommerce*/
            'beauty-studio-wc-shop-archive-sidebar-layout'     => 'no-sidebar',
            'beauty-studio-wc-product-column-number'           => 4,
            'beauty-studio-wc-shop-archive-total-product'      => 16,
            'beauty-studio-wc-single-product-sidebar-layout'   => 'no-sidebar',

            /*single post*/
            'beauty-studio-single-header-title'            => esc_html__( 'Blog', 'beauty-studio' ),
            'beauty-studio-single-img-size'                => 'full',

            /*theme options*/
            'beauty-studio-popup-widget-title'     => esc_html__( 'Request a Quote', 'beauty-studio' ),
            'beauty-studio-show-breadcrumb'        => 1,
            'beauty-studio-search-placeholder'     => esc_html__( 'Search', 'beauty-studio' ),
            'beauty-studio-social-data'            => ''
        );
        return apply_filters( 'beauty_studio_default_theme_options', $default_theme_options );
    }
endif;

/**
 * Get theme options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array beauty_studio_theme_options
 *
 */
if ( !function_exists('beauty_studio_get_theme_options') ) :
    function beauty_studio_get_theme_options() {

        $beauty_studio_default_theme_options = beauty_studio_get_default_theme_options();
        $beauty_studio_get_theme_options = get_theme_mod( 'beauty_studio_theme_options');
        if( is_array( $beauty_studio_get_theme_options )){
            return array_merge( $beauty_studio_default_theme_options ,$beauty_studio_get_theme_options );
        }
        else{
            return $beauty_studio_default_theme_options;
        }
    }
endif;

$beauty_studio_saved_theme_options = beauty_studio_get_theme_options();
$GLOBALS['beauty_studio_customizer_all_values'] = $beauty_studio_saved_theme_options;

require trailingslashit( get_template_directory() ).'acmethemes/init.php';