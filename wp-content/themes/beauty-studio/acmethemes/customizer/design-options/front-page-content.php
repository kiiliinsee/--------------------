<?php
/*active callback function for front-page-header*/
if ( !function_exists('beauty_studio_active_callback_front_page_header') ) :
    function beauty_studio_active_callback_front_page_header() {
        $beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
        if( 1 != $beauty_studio_customizer_all_values['beauty-studio-hide-front-page-content'] ){
            return true;
        }
        return false;
    }
endif;

/*adding sections for front page content */
$wp_customize->add_section( 'beauty-studio-front-page-content', array(
    'priority'          => 10,
    'capability'        => 'edit_theme_options',
    'title'             => esc_html__( 'Front Page Content Options', 'beauty-studio' ),
    'panel'             => 'beauty-studio-design-panel'

) );

/*hide front page content*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-hide-front-page-content]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-hide-front-page-content'],
    'sanitize_callback' => 'beauty_studio_sanitize_checkbox',
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-hide-front-page-content]', array(
    'label'		        => esc_html__( 'Hide Front Page Content', 'beauty-studio' ),
    'description'       => esc_html__( 'You may want to hide front page content and want to show only Feature section and Home Widgets. Check this to hide front page content.', 'beauty-studio' ),
    'section'           => 'beauty-studio-front-page-content',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-hide-front-page-content]',
    'type'	  	        => 'checkbox'
) );

/*hide front page header*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-hide-front-page-header]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-hide-front-page-header'],
    'sanitize_callback' => 'beauty_studio_sanitize_checkbox',
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-hide-front-page-header]', array(
    'label'		        => esc_html__( 'Hide Front Page Header', 'beauty-studio' ),
    'description'       => esc_html__( 'You may want to hide front page header and want to show only Feature section and Home Widgets. Check this to hide front page Header.', 'beauty-studio' ),
    'section'           => 'beauty-studio-front-page-content',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-hide-front-page-header]',
    'type'	  	        => 'checkbox',
    'active_callback'   => 'beauty_studio_active_callback_front_page_header'
) );