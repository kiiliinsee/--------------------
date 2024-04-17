<?php
/*adding sections for footer background image*/
$wp_customize->add_section( 'beauty-studio-footer-bg-img', array(
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => esc_html__( 'Footer Background Image', 'beauty-studio' ),
    'panel'          => 'beauty-studio-footer-panel',
) );

/*footer background image*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-footer-bg-img]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-footer-bg-img'],
    'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
        'beauty_studio_theme_options[beauty-studio-footer-bg-img]',
        array(
            'label'		=> esc_html__( 'Footer Background Image', 'beauty-studio' ),
            'section'   => 'beauty-studio-footer-bg-img',
            'settings'  => 'beauty_studio_theme_options[beauty-studio-footer-bg-img]',
            'type'	  	=> 'image'
        )
    )
);