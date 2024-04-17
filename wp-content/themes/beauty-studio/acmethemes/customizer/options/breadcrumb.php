<?php
/*adding sections for breadcrumb */
$wp_customize->add_section( 'beauty-studio-breadcrumb-options', array(
    'priority'          => 20,
    'capability'        => 'edit_theme_options',
    'title'             => esc_html__( 'Breadcrumb Options', 'beauty-studio' ),
    'panel'             => 'beauty-studio-options'
) );

/*show breadcrumb*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-show-breadcrumb]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-show-breadcrumb'],
    'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );

$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-show-breadcrumb]', array(
    'label'		        => esc_html__( 'Enable Breadcrumb', 'beauty-studio' ),
    'section'           => 'beauty-studio-breadcrumb-options',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-show-breadcrumb]',
    'type'	  	        => 'checkbox'
) );