<?php
/*Primary color*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-primary-color]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-primary-color'],
    'sanitize_callback' => 'sanitize_hex_color'
) );

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'beauty_studio_theme_options[beauty-studio-primary-color]',
        array(
            'label'		=> esc_html__( 'Primary Color', 'beauty-studio' ),
            'section'   => 'colors',
            'settings'  => 'beauty_studio_theme_options[beauty-studio-primary-color]',
            'type'	  	=> 'color'
        ) )
);

/*Header TOP color*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-header-top-bg-color]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-header-top-bg-color'],
    'sanitize_callback' => 'sanitize_hex_color'
) );

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'beauty_studio_theme_options[beauty-studio-header-top-bg-color]',
        array(
            'label'		=> esc_html__( 'Header Top Background Color', 'beauty-studio' ),
            'description'=> esc_html__( 'Also used as secondary color', 'beauty-studio' ),
            'section'   => 'colors',
            'settings'  => 'beauty_studio_theme_options[beauty-studio-header-top-bg-color]',
            'type'	  	=> 'color'
        )
    )
);

/* Footer Background Color*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-footer-bg-color]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-footer-bg-color'],
    'sanitize_callback' => 'sanitize_hex_color'
) );

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'beauty_studio_theme_options[beauty-studio-footer-bg-color]',
        array(
            'label'		=> esc_html__( 'Footer Background Color', 'beauty-studio' ),
            'section'   => 'colors',
            'settings'  => 'beauty_studio_theme_options[beauty-studio-footer-bg-color]',
            'type'	  	=> 'color'
        )
    )
);

/*Footer Bottom Background Color*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-footer-bottom-bg-color]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-footer-bottom-bg-color'],
    'sanitize_callback' => 'sanitize_hex_color'
) );

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'beauty_studio_theme_options[beauty-studio-footer-bottom-bg-color]',
        array(
            'label'		=> esc_html__( 'Footer Bottom Background Color', 'beauty-studio' ),
            'section'   => 'colors',
            'settings'  => 'beauty_studio_theme_options[beauty-studio-footer-bottom-bg-color]',
            'type'	  	=> 'color'
        )
    )
);

/*Link color*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-link-color]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-link-color'],
	'sanitize_callback' => 'sanitize_hex_color'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-link-color]', array(
	'label'		=> esc_html__( 'Link Color', 'beauty-studio' ),
	'section'   => 'colors',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-link-color]',
	'type'	  	=> 'color'
) );

/*Link Hover color*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-link-hover-color]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-link-hover-color'],
	'sanitize_callback' => 'sanitize_hex_color'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-link-hover-color]', array(
	'label'		=> esc_html__( 'Link Hover Color', 'beauty-studio' ),
	'section'   => 'colors',
	'settings'  => 'beauty_studio_theme_options[beauty-studio-link-hover-color]',
	'type'	  	=> 'color'
) );