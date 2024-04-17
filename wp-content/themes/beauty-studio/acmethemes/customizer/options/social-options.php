<?php
/*adding sections for header social options */
$wp_customize->add_section( 'beauty-studio-social-options', array(
    'priority'              => 20,
    'capability'            => 'edit_theme_options',
    'title'                 => esc_html__( 'Social Options', 'beauty-studio' ),
    'panel'                 => 'beauty-studio-options'
) );

/*repeater social data*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-social-data]', array(
	'sanitize_callback'     => 'beauty_studio_sanitize_social_data',
	'default'               => $defaults['beauty-studio-social-data']
) );
$wp_customize->add_control(
	new Beauty_Studio_Repeater_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-social-data]',
		array(
			'label'                         => esc_html__('Social Options Selection','beauty-studio'),
			'description'                   => esc_html__('Select Social Icons and enter link','beauty-studio'),
			'section'                       => 'beauty-studio-social-options',
			'settings'                      => 'beauty_studio_theme_options[beauty-studio-social-data]',
			'repeater_main_label'           => esc_html__('Social Icon','beauty-studio'),
			'repeater_add_control_field'    => esc_html__('Add New Icon','beauty-studio')
		),
		array(
			'icon' => array(
				'type'        => 'icons',
				'label'       => esc_html__( 'Select Icon', 'beauty-studio' ),
			),
			'link' => array(
				'type'        => 'url',
				'label'       => esc_html__( 'Enter Link', 'beauty-studio' ),
			),
			'checkbox' => array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Open in New Window', 'beauty-studio' ),
			)
		)
	)
);