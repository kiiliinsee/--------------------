<?php
/*adding sections for sidebar options */
$wp_customize->add_section( 'beauty-studio-wc-single-product-options', array(
	'priority'       => 20,
	'capability'     => 'edit_theme_options',
	'title'          => esc_html__( 'Single Product', 'beauty-studio' ),
	'panel'          => 'beauty-studio-wc-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-wc-single-product-sidebar-layout]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-wc-single-product-sidebar-layout'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_sidebar_layout();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-wc-single-product-sidebar-layout]', array(
	'choices'  	=> $choices,
	'label'		=> esc_html__( 'Single Product Sidebar Layout', 'beauty-studio' ),
	'section'   => 'beauty-studio-wc-single-product-options',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-wc-single-product-sidebar-layout]',
	'type'	  	=> 'select'
) );