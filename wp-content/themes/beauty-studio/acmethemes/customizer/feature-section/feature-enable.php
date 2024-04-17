<?php
/*adding sections for enabling feature section in front page*/
$wp_customize->add_section( 'beauty-studio-enable-feature', array(
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Enable Feature Section', 'beauty-studio' ),
    'panel'          => 'beauty-studio-feature-panel'
) );

/*enable feature section*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-enable-feature]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-enable-feature'],
    'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );

$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-enable-feature]', array(
    'label'		        => esc_html__( 'Enable Feature Section', 'beauty-studio' ),
    'description'	    => sprintf( esc_html__( 'Feature section will display on front/home page. Feature Section includes Feature Slider and Feature Column.%1$s Note : Please go to %2$s "Static Front Page"%3$s setting, Select "A static page" then "Front page" and "Posts page" to enable it', 'beauty-studio' ), '<br />','<b><a class="at-customizer" data-section="static_front_page"> ','</a></b>' ),
    'section'           => 'beauty-studio-enable-feature',
    'settings'          => 'beauty_studio_theme_options[beauty-studio-enable-feature]',
    'type'	  	        => 'checkbox'
) );