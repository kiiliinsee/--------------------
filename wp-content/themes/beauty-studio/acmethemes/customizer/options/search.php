<?php
/*adding sections for Search Placeholder*/
$wp_customize->add_section( 'beauty-studio-search', array(
    'priority'          => 20,
    'capability'        => 'edit_theme_options',
    'title'             => esc_html__( 'Search', 'beauty-studio' ),
    'panel'             => 'beauty-studio-options'
) );

/*Search Placeholder*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-search-placeholder]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-search-placeholder'],
    'sanitize_callback' => 'sanitize_text_field'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-search-placeholder]', array(
    'label'		        => esc_html__( 'Search Placeholder', 'beauty-studio' ),
    'section'           => 'beauty-studio-search',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-search-placeholder]',
    'type'	  	        => 'text'
) );