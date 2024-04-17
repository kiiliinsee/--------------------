<?php
/*Title*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-popup-widget-title]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-popup-widget-title'],
	'sanitize_callback' => 'sanitize_text_field'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-popup-widget-title]', array(
	'label'		        => esc_html__( 'Popup Main Title', 'beauty-studio' ),
	'section'           => 'beauty-studio-menu-options',
	'settings'          => 'beauty_studio_theme_options[beauty-studio-popup-widget-title]',
	'type'	  	        => 'text',
) );