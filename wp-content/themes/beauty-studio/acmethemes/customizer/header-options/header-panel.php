<?php
/*adding header options panel*/
$wp_customize->add_panel( 'beauty-studio-header-panel', array(
    'priority'       => 30,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Header Options', 'beauty-studio' ),
    'description'    => esc_html__( 'Customize your awesome site header ', 'beauty-studio' )
) );

/*
* file for header top options
*/
require beauty_studio_file_directory('acmethemes/customizer/header-options/header-top.php');

/*
* file for header logo options
*/
require beauty_studio_file_directory('acmethemes/customizer/header-options/header-logo.php');

/*
 * file for menu options
*/
require beauty_studio_file_directory('acmethemes/customizer/header-options/menu-options.php');

/*
* file for booking form
*/
require beauty_studio_file_directory('acmethemes/customizer/header-options/popup-widgets.php');

/* feature section height*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-header-height]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-header-height'],
    'sanitize_callback' => 'beauty_studio_sanitize_number'
) );

$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-header-height]', array(
    'type'              => 'range',
    'priority'          => 100,
    'section'           => 'header_image',
    'label'		        => esc_html__( 'Inner Page Header Section Height', 'beauty-studio' ),
    'description'       => esc_html__( 'Control the height of Header section. The minimum height is 100px and maximium height is 500px', 'beauty-studio' ),
    'input_attrs'       => array(
        'min'           => 100,
        'max'           => 500,
        'step'          => 1,
        'class'         => 'beauty-studio-header-height',
        'style'         => 'color: #0a0',
    ),
    'active_callback'   => 'beauty_studio_if_header_bg_image'
) );

/*Header Image Display*/
$choices = beauty_studio_header_image_display();
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-header-image-display]', array(
	'capability'		        => 'edit_theme_options',
	'default'			        => $defaults['beauty-studio-header-image-display'],
	'sanitize_callback'         => 'beauty_studio_sanitize_select'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-header-image-display]', array(
	'choices'  	                => $choices,
	'priority'                  => 1,
	'label'		                => esc_html__( 'Header Image Display', 'beauty-studio' ),
	'section'                   => 'header_image',
	'settings'                  => 'beauty_studio_theme_options[beauty-studio-header-image-display]',
	'type'	  	                => 'select'
) );

/*check if header bg*/
if ( !function_exists('beauty_studio_if_header_bg_image') ) :
	function beauty_studio_if_header_bg_image() {
		$beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
		if( 'bg-image' == $beauty_studio_customizer_all_values['beauty-studio-header-image-display'] ){
			return true;
		}
		return false;
	}
endif;