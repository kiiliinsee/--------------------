<?php
/*adding sections for sidebar options */
$wp_customize->add_section( 'beauty-studio-wc-shop-archive-option', array(
	'priority'       => 20,
	'capability'     => 'edit_theme_options',
	'title'          => esc_html__( 'Shop Archive Sidebar Layout', 'beauty-studio' ),
	'panel'          => 'beauty-studio-wc-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-wc-shop-archive-sidebar-layout]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-wc-shop-archive-sidebar-layout'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_sidebar_layout();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-wc-shop-archive-sidebar-layout]', array(
	'choices'  	=> $choices,
	'label'		=> esc_html__( 'Shop Archive Sidebar Layout', 'beauty-studio' ),
	'section'   => 'beauty-studio-wc-shop-archive-option',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-wc-shop-archive-sidebar-layout]',
	'type'	  	=> 'select'
) );

/*wc-product-column-number*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-wc-product-column-number]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-wc-product-column-number'],
	'sanitize_callback' => 'absint'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-wc-product-column-number]', array(
	'label'		=> esc_html__( 'Products Per Row', 'beauty-studio' ),
	'section'   => 'beauty-studio-wc-shop-archive-option',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-wc-product-column-number]',
	'type'	  	=> 'number'
) );

/*wc-shop-archive-total-product*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-wc-shop-archive-total-product]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-wc-shop-archive-total-product'],
	'sanitize_callback' => 'absint'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-wc-shop-archive-total-product]', array(
	'label'		=> esc_html__( 'Total Products Per Page', 'beauty-studio' ),
	'section'   => 'beauty-studio-wc-shop-archive-option',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-wc-shop-archive-total-product]',
	'type'	  	=> 'number'
) );