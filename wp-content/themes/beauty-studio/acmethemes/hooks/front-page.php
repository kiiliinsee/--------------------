<?php
/**
 * Front page hook for all WordPress Conditions
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return void
 *
 */
if ( ! function_exists( 'beauty_studio_featured_slider' ) ) :

    function beauty_studio_featured_slider() {
        global $beauty_studio_customizer_all_values;

        $beauty_studio_enable_feature = $beauty_studio_customizer_all_values['beauty-studio-enable-feature'];
        if( is_front_page() && 1 == $beauty_studio_enable_feature && !is_home() ) :
	        $beauty_studio_feature_info_display_options = $beauty_studio_customizer_all_values['beauty-studio-feature-info-display-options'];
	        do_action( 'beauty_studio_action_feature_slider' );
	        if( 'below' == $beauty_studio_feature_info_display_options ){
		        echo "<div class='container primary-bg'>";
		        do_action( 'beauty_studio_action_feature_info' );
		        echo "</div>";
	        }
        endif;
    }
endif;
add_action( 'beauty_studio_action_front_page', 'beauty_studio_featured_slider', 10 );

if ( ! function_exists( 'beauty_studio_front_page' ) ) :

    function beauty_studio_front_page() {
        global $beauty_studio_customizer_all_values;

        $beauty_studio_hide_front_page_content = $beauty_studio_customizer_all_values['beauty-studio-hide-front-page-content'];

        /*show widget in front page, now user are not force to use front page*/
        if( is_active_sidebar( 'beauty-studio-home' ) && !is_home() ){
            dynamic_sidebar( 'beauty-studio-home' );
        }
        if ( 'posts' == get_option( 'show_on_front' ) ) {
            include( get_home_template() );
        }
        else {
            if( 1 != $beauty_studio_hide_front_page_content ){
                include( get_page_template() );
            }
        }
    }
endif;
add_action( 'beauty_studio_action_front_page', 'beauty_studio_front_page', 20 );