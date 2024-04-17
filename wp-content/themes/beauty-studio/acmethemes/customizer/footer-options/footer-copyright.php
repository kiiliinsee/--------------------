<?php
/*adding sections for footer options*/
$wp_customize->add_section( 'beauty-studio-footer-copyright-option', array(
    'priority'              => 20,
    'capability'            => 'edit_theme_options',
    'title'                 => esc_html__( 'Bottom Copyright Section', 'beauty-studio' ),
    'panel'                 => 'beauty-studio-footer-panel',
) );

/*copyright*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-footer-copyright]', array(
    'capability'		    => 'edit_theme_options',
    'default'			    => $defaults['beauty-studio-footer-copyright'],
    'sanitize_callback'     => 'wp_kses_post'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-footer-copyright]', array(
    'label'		            => esc_html__( 'Copyright Text', 'beauty-studio' ),
    'section'               => 'beauty-studio-footer-copyright-option',
    'settings'              => 'beauty_studio_theme_options[beauty-studio-footer-copyright]',
    'type'	  	            => 'text'
) );

/*footer copyright beside*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-footer-copyright-beside-option]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-footer-copyright-beside-option'],
	'sanitize_callback'     => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_footer_copyright_beside_option();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-footer-copyright-beside-option]', array(
	'choices'  	            => $choices,
	'label'		            => esc_html__( 'Footer Copyright Beside Option', 'beauty-studio' ),
	'section'               => 'beauty-studio-footer-copyright-option',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-footer-copyright-beside-option]',
	'type'	  	            => 'select'
) );