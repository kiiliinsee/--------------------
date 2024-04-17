<?php
/*adding sections for default layout options panel*/
$wp_customize->add_section( 'beauty-studio-front-page-sidebar-layout', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Front/Home Sidebar Layout', 'beauty-studio' ),
    'panel'          => 'beauty-studio-design-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-front-page-sidebar-layout]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-front-page-sidebar-layout'],
    'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_sidebar_layout();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-front-page-sidebar-layout]', array(
    'choices'  	        => $choices,
    'label'		        => esc_html__( 'Front/Home Sidebar Layout', 'beauty-studio' ),
    'section'           => 'beauty-studio-front-page-sidebar-layout',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-front-page-sidebar-layout]',
    'type'	  	        => 'select'
) );