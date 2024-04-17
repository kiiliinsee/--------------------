<?php
/*adding sections for category section in front page*/
$wp_customize->add_section( 'beauty-studio-feature-page', array(
	'priority'       => 10,
	'capability'     => 'edit_theme_options',
	'title'          => esc_html__( 'Feature Slider Selection', 'beauty-studio' ),
	'panel'          => 'beauty-studio-feature-panel'
) );

/* feature parent all-slides selection */
$slider_pages = array();
$slider_pages_obj = get_pages();
$slider_pages[''] = esc_html__('Select Slider Page','beauty-studio');
foreach ($slider_pages_obj as $page) {
	$slider_pages[$page->ID] = $page->post_title;
}
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-slides-data]', array(
	'sanitize_callback' => 'beauty_studio_sanitize_slider_data',
	'default'           => $defaults['beauty-studio-slides-data']
) );
$wp_customize->add_control(
	new Beauty_Studio_Repeater_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-slides-data]',
		array(
			'label'                         => esc_html__('Slider Selection','beauty-studio'),
			'description'                   => esc_html__('Select Page For Slider','beauty-studio'),
			'section'                       => 'beauty-studio-feature-page',
			'settings'                      => 'beauty_studio_theme_options[beauty-studio-slides-data]',
			'repeater_main_label'           => esc_html__('Select Slide of Slider','beauty-studio'),
			'repeater_add_control_field'    => esc_html__('Add New Slide','beauty-studio')
		),
		array(
			'selectpage' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Select Page For Slide', 'beauty-studio' ),
				'options'     => $slider_pages
			),
			'button_1_text' => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Button One Text', 'beauty-studio' ),
			),
			'button_1_link' => array(
				'type'        => 'url',
				'label'       => esc_html__( 'Button One Link', 'beauty-studio' ),
			),
			'button_2_text' => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Button Two Text', 'beauty-studio' ),
			),
			'button_2_link' => array(
				'type'        => 'url',
				'label'       => esc_html__( 'Button Two Link', 'beauty-studio' ),
			)
		)
	)
);

/*enable animation*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-feature-slider-enable-animation]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-feature-slider-enable-animation'],
	'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-feature-slider-enable-animation]', array(
	'label'		        => esc_html__( 'Enable Animation', 'beauty-studio' ),
	'section'           => 'beauty-studio-feature-page',
	'settings'          => 'beauty_studio_theme_options[beauty-studio-feature-slider-enable-animation]',
	'type'	  	        => 'checkbox'
) );

/*display-title*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-feature-slider-display-title]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-feature-slider-display-title'],
	'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-feature-slider-display-title]', array(
	'label'		            => esc_html__( 'Display Title', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-page',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-feature-slider-display-title]',
	'type'	  	            => 'checkbox'
) );

/*display-excerpt*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-feature-slider-display-excerpt]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-feature-slider-display-excerpt'],
	'sanitize_callback'     => 'beauty_studio_sanitize_checkbox'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-feature-slider-display-excerpt]', array(
	'label'		            => esc_html__( 'Display Excerpt', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-page',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-feature-slider-display-excerpt]',
	'type'	  	            => 'checkbox'
) );

/*Image Display Behavior*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-fs-image-display-options]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-fs-image-display-options'],
	'sanitize_callback'     => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_fs_image_display_options();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-fs-image-display-options]', array(
	'choices'  	            => $choices,
	'label'		            => esc_html__( 'Feature Slider Image Display Options', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-page',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-fs-image-display-options]',
	'type'	  	            => 'radio'
) );

/*Slider Selection Text Align*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-feature-slider-text-align]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-feature-slider-text-align'],
	'sanitize_callback'     => 'beauty_studio_sanitize_select',
) );
$choices = beauty_studio_slider_text_align();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-feature-slider-text-align]', array(
	'choices'  	            => $choices,
	'label'		            => esc_html__( 'Slider Text Align', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-page',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-feature-slider-text-align]',
	'type'	  	            => 'select'
) );