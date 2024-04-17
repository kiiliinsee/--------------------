<?php
/*adding sections for design options panel*/
$wp_customize->add_section( 'beauty-studio-animation', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Animation', 'beauty-studio' ),
    'panel'          => 'beauty-studio-design-panel'
) );

/*enable disable animation*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-enable-animation]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-enable-animation'],
    'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-enable-animation]', array(
    'label'		        => esc_html__( 'Disable animation', 'beauty-studio' ),
    'description'       => esc_html__( 'Check this to disable overall site animation effect provided by theme', 'beauty-studio' ),
    'section'           => 'beauty-studio-animation',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-enable-animation]',
    'type'	  	        => 'checkbox'
) );