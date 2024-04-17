<?php
/*adding sections for sidebar options */
$wp_customize->add_section( 'beauty-studio-design-sidebar-layout-option', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Default Page/Post Sidebar Layout', 'beauty-studio' ),
    'panel'          => 'beauty-studio-design-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-single-sidebar-layout]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-single-sidebar-layout'],
    'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_sidebar_layout();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-single-sidebar-layout]', array(
    'choices'  	        => $choices,
    'label'		        => esc_html__( 'Default Page/Post Sidebar Layout', 'beauty-studio' ),
    'description'       => esc_html__( 'Single Page/Post Sidebar', 'beauty-studio' ),
    'section'           => 'beauty-studio-design-sidebar-layout-option',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-single-sidebar-layout]',
    'type'	  	        => 'select'
) );