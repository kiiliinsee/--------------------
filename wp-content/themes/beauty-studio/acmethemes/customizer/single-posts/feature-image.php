<?php
/*adding sections for feature image selection*/
$wp_customize->add_section( 'beauty-studio-single-feature-image', array(
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Feature Image Option', 'beauty-studio' ),
    'panel'          => 'beauty-studio-single-post'
) );

/*single image size*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-single-img-size]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-single-img-size'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_get_image_sizes_options(1);
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-single-img-size]', array(
	'choices'  	=> $choices,
	'label'		=> esc_html__( 'Image Size', 'beauty-studio' ),
	'section'   => 'beauty-studio-single-feature-image',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-single-img-size]',
	'type'	  	=> 'select'
) );