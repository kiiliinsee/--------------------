<?php
/*Site Logo*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-display-site-logo]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-display-site-logo'],
	'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-display-site-logo]', array(
	'label'		=> esc_html__( 'Display Logo', 'beauty-studio' ),
	'section'   => 'title_tagline',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-display-site-logo]',
	'type'	  	=> 'checkbox'
) );

/*Site Title*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-display-site-title]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-display-site-title'],
	'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-display-site-title]', array(
	'label'		=> esc_html__( 'Display Site Title', 'beauty-studio' ),
	'section'   => 'title_tagline',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-display-site-title]',
	'type'	  	=> 'checkbox'
) );

/*Site Tagline*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-display-site-tagline]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-display-site-tagline'],
	'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-display-site-tagline]', array(
	'label'		=> esc_html__( 'Display Site Tagline', 'beauty-studio' ),
	'section'   => 'title_tagline',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-display-site-tagline]',
	'type'	  	=> 'checkbox'
) );