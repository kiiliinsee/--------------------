<?php
/**
 * Setting global variables for all theme options saved values
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return void
 *
 */
if ( ! function_exists( 'beauty_studio_set_global' ) ) :
    function beauty_studio_set_global() {
        /*Getting saved values start*/
        $beauty_studio_saved_theme_options = beauty_studio_get_theme_options();
        $GLOBALS['beauty_studio_customizer_all_values'] = $beauty_studio_saved_theme_options;
        /*Getting saved values end*/
    }
endif;
add_action( 'beauty_studio_action_before_head', 'beauty_studio_set_global', 0 );

/**
 * Doctype Declaration
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return void
 *
 */
if ( ! function_exists( 'beauty_studio_doctype' ) ) :
    function beauty_studio_doctype() {
        ?><!DOCTYPE html><html <?php language_attributes(); ?>>
        <?php
    }
endif;
add_action( 'beauty_studio_action_before_head', 'beauty_studio_doctype', 10 );

/**
 * Code inside head tage but before wp_head funtion
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return void
 *
 */
if ( ! function_exists( 'beauty_studio_before_wp_head' ) ) :

    function beauty_studio_before_wp_head() {
        ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="//gmpg.org/xfn/11">
        <?php
    }
endif;
add_action( 'beauty_studio_action_before_wp_head', 'beauty_studio_before_wp_head', 10 );

/**
 * Add body class
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'beauty_studio_body_class' ) ) :

    function beauty_studio_body_class( $beauty_studio_body_classes ) {

        global $beauty_studio_customizer_all_values;
        $beauty_studio_enable_animation = $beauty_studio_customizer_all_values['beauty-studio-enable-animation'];
        $beauty_studio_enable_transparent = $beauty_studio_customizer_all_values['beauty-studio-enable-transparent'];
        $beauty_studio_feature_info_display_options = $beauty_studio_customizer_all_values['beauty-studio-feature-info-display-options'];
        $beauty_studio_enable_feature = $beauty_studio_customizer_all_values['beauty-studio-enable-feature'];
        /*wow animation*/
        if( 1 != $beauty_studio_enable_animation ){
            $beauty_studio_body_classes[] = 'acme-animate';
        }
        $beauty_studio_body_classes[] = esc_attr( beauty_studio_sidebar_selection() );

        if( 'hide' != $beauty_studio_feature_info_display_options ){
	        $beauty_studio_body_classes[] = esc_attr( $beauty_studio_feature_info_display_options );

        }
         if( 1 == $beauty_studio_enable_transparent  ){
	         $beauty_studio_body_classes[] = 'header-transparent';
              $beauty_studio_enable_header_top = $beauty_studio_customizer_all_values['beauty-studio-enable-header-top'];
              if( 1 == $beauty_studio_enable_header_top  ){
                    $beauty_studio_body_classes[] = 'header-enable-top';
              }
         }

         if ( 1 != $beauty_studio_enable_feature && is_front_page()){
            $beauty_studio_body_classes[] = 'at-front-no-feature';
         }

        return $beauty_studio_body_classes;
    }
endif;
add_action( 'body_class', 'beauty_studio_body_class', 10, 1 );

/**
 * Start site div
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'beauty_studio_site_start' ) ) :

    function beauty_studio_site_start() {
        ?>
        <div class="site" id="page">
        <?php
    }
endif;
add_action( 'beauty_studio_action_before', 'beauty_studio_site_start', 20 );

/**
 * Skip to content
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'beauty_studio_skip_to_content' ) ) :

    function beauty_studio_skip_to_content() {
        ?>
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'beauty-studio' ); ?></a>
        <?php
    }
endif;
add_action( 'beauty_studio_action_before_header', 'beauty_studio_skip_to_content', 10 );

/**
 * Main header
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'beauty_studio_header' ) ) :
    function beauty_studio_header() {
        global $beauty_studio_customizer_all_values;
        $beauty_studio_enable_header_top = $beauty_studio_customizer_all_values['beauty-studio-enable-header-top'];
	    $beauty_studio_nav_class = '';
	    $beauty_studio_enable_sticky = $beauty_studio_customizer_all_values['beauty-studio-enable-sticky'];
        $beauty_studio_enable_transparent = $beauty_studio_customizer_all_values['beauty-studio-enable-transparent'];
	    if( 1 == $beauty_studio_enable_sticky || 1 == $beauty_studio_enable_transparent  ){
		    $beauty_studio_nav_class .= ' beauty-studio-sticky';
	    }
        if( 1 == $beauty_studio_enable_header_top ){
            ?>
            <div class="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <?php
                                $beauty_studio_header_top_menu_display_selection = $beauty_studio_customizer_all_values['beauty-studio-header-top-menu-display-selection'];
                                $beauty_studio_header_top_news_display_selection = $beauty_studio_customizer_all_values['beauty-studio-header-top-news-display-selection'];
                                $beauty_studio_header_top_social_display_selection = $beauty_studio_customizer_all_values['beauty-studio-header-top-social-display-selection'];

                                if( 'left' == $beauty_studio_header_top_menu_display_selection ){
                                    do_action('beauty_studio_action_top_menu');
                                }
                                if( 'left' == $beauty_studio_header_top_social_display_selection ){
                                    do_action('beauty_studio_action_social_links');
                                }
                                if( 'left' == $beauty_studio_header_top_news_display_selection ){
                                    do_action('beauty_studio_action_newsnotice');
                                }
                            ?>
                        </div>
                        <div class="col-sm-6 text-right">
                            <?php
                                if( 'right' == $beauty_studio_header_top_menu_display_selection ){
                                    do_action('beauty_studio_action_top_menu');
                                }
                                if( 'right' == $beauty_studio_header_top_social_display_selection ){
                                    do_action('beauty_studio_action_social_links');
                                }
                                if( 'right' == $beauty_studio_header_top_news_display_selection ){
                                    do_action('beauty_studio_action_newsnotice');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="navbar at-navbar <?php echo $beauty_studio_nav_class; ?>" id="navbar" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></button>
                    <?php

                    $beauty_studio_display_site_logo = $beauty_studio_customizer_all_values['beauty-studio-display-site-logo'];
	                $beauty_studio_display_site_title = $beauty_studio_customizer_all_values['beauty-studio-display-site-title'];
	                $beauty_studio_display_site_tagline = $beauty_studio_customizer_all_values['beauty-studio-display-site-tagline'];
	                
                    if( 1== $beauty_studio_display_site_logo || 1 == $beauty_studio_display_site_title || 1 == $beauty_studio_display_site_tagline ):
                        if ( 1 == $beauty_studio_display_site_logo && function_exists( 'the_custom_logo' ) ):
                            the_custom_logo();
                        endif;
                        if ( 1== $beauty_studio_display_site_title  ):
                            if ( is_front_page() && is_home() ) : ?>
                                <h1 class="site-title">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                                </h1>
                            <?php else : ?>
                                <p class="site-title">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                                </p>
                            <?php endif;
                        endif;
                        if ( 1== $beauty_studio_display_site_tagline  ):
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) : ?>
                                <p class="site-description"><?php echo esc_html( $description ); ?></p>
                            <?php endif;
                        endif;
                    endif;
                    ?>
                </div>
                <div class="at-beside-navbar-header">
	                <?php
	                beauty_studio_primary_menu();
	                ?>
                </div>
                <!--.at-beside-navbar-header-->
            </div>

        </div>
        <?php
    }
endif;
add_action( 'beauty_studio_action_header', 'beauty_studio_header', 10 );