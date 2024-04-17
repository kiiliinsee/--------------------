<?php
/*adding sections for default layout options panel*/
$wp_customize->add_section( 'beauty-studio-archive-sidebar-layout', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Category/Archive Sidebar Layout', 'beauty-studio' ),
    'panel'          => 'beauty-studio-design-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-archive-sidebar-layout]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-archive-sidebar-layout'],
    'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_sidebar_layout();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-archive-sidebar-layout]', array(
    'choices'  	        => $choices,
    'label'		        => esc_html__( 'Category/Archive Sidebar Layout', 'beauty-studio' ),
    'description'       => esc_html__( 'Sidebar Layout for listing pages like category, author etc', 'beauty-studio' ),
    'section'           => 'beauty-studio-archive-sidebar-layout',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-archive-sidebar-layout]',
    'type'	  	        => 'select'
) );