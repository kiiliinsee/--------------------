<?php
/*adding sections for header title*/
$wp_customize->add_section( 'beauty-studio-single-header-title', array(
	'priority'              => 20,
	'capability'            => 'edit_theme_options',
	'title'                 => esc_html__( 'Single Header Title', 'beauty-studio' ),
	'panel'                 => 'beauty-studio-single-post',
) );

/*header title*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-single-header-title]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-single-header-title'],
	'sanitize_callback'     => 'sanitize_text_field'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-single-header-title]', array(
	'label'		            => esc_html__( 'Header Title', 'beauty-studio' ),
	'section'               => 'beauty-studio-single-header-title',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-single-header-title]',
	'type'	  	            => 'text'
) );