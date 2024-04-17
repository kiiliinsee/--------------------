<?php
/*check if enable header top*/
if ( !function_exists('beauty_studio_is_enable_header_top') ) :
	function beauty_studio_is_enable_header_top() {
		$beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
		if( 1 == $beauty_studio_customizer_all_values['beauty-studio-enable-header-top'] ){
			return true;
		}
		return false;
	}
endif;

/*adding sections for header options*/
$wp_customize->add_section( 'beauty-studio-header-top-option', array(
    'priority'                  => 10,
    'capability'                => 'edit_theme_options',
    'title'                     => esc_html__( 'Header Top', 'beauty-studio' ),
    'panel'                     => 'beauty-studio-header-panel',
) );

/*header top enable*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-enable-header-top]', array(
    'capability'		        => 'edit_theme_options',
    'default'			        => $defaults['beauty-studio-enable-header-top'],
    'sanitize_callback'         => 'beauty_studio_sanitize_checkbox',
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-enable-header-top]', array(
    'label'		                => esc_html__( 'Enable Header Top Options', 'beauty-studio' ),
    'section'                   => 'beauty-studio-header-top-option',
    'settings'                  => 'beauty_studio_theme_options[beauty-studio-enable-header-top]',
    'type'	  	                => 'checkbox'
) );

/*header top message*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-header-top-message]', array(
	'capability'		        => 'edit_theme_options',
	'sanitize_callback'         => 'wp_kses_post'
));

$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-header-top-message]',
		array(
			'section'           => 'beauty-studio-header-top-option',
			'description'       => "<hr /><h2>".esc_html__('Display Different Element on Top Right or Left','beauty-studio')."</h2>",
			'settings'          => 'beauty_studio_theme_options[beauty-studio-header-top-message]',
			'type'	  	        => 'message',
			'active_callback'   => 'beauty_studio_is_enable_header_top'
		)
	)
);

/*Top Menu Display*/
$choices = beauty_studio_header_top_display_selection();
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-header-top-menu-display-selection]', array(
	'capability'		        => 'edit_theme_options',
	'default'			        => $defaults['beauty-studio-header-top-menu-display-selection'],
	'sanitize_callback'         => 'beauty_studio_sanitize_select'
) );
$description = sprintf( esc_html__( 'Add/Edit Menu Items from %1$s here%2$s and select Menu Location : Top Menu ( Support First Level Only ) ', 'beauty-studio' ), '<a class="at-customizer button button-primary" data-panel="nav_menus" style="cursor: pointer">','</a>' );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-header-top-menu-display-selection]', array(
	'choices'  	                => $choices,
	'label'		                => esc_html__( 'Top Menu Display', 'beauty-studio' ),
	'description'		        => $description,
	'section'                   => 'beauty-studio-header-top-option',
	'settings'                  => 'beauty_studio_theme_options[beauty-studio-header-top-menu-display-selection]',
	'type'	  	                => 'select',
	'active_callback'           => 'beauty_studio_is_enable_header_top'
) );

/*News/Notice display*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-header-top-news-display-selection]', array(
	'capability'		        => 'edit_theme_options',
	'default'			        => $defaults['beauty-studio-header-top-news-display-selection'],
	'sanitize_callback'         => 'beauty_studio_sanitize_select'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-header-top-news-display-selection]', array(
	'choices'  	                => $choices,
	'label'		                => esc_html__( 'News/Notice Display', 'beauty-studio' ),
	'section'                   => 'beauty-studio-header-top-option',
	'settings'                  => 'beauty_studio_theme_options[beauty-studio-header-top-news-display-selection]',
	'type'	  	                => 'select',
	'active_callback'           => 'beauty_studio_is_enable_header_top'
) );

/*Social Display*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-header-top-social-display-selection]', array(
	'capability'		        => 'edit_theme_options',
	'default'			        => $defaults['beauty-studio-header-top-social-display-selection'],
	'sanitize_callback'         => 'beauty_studio_sanitize_select'
) );
$description = sprintf( esc_html__( 'Add/Edit Social Items from %1$s here%2$s ', 'beauty-studio' ), '<a class="at-customizer button button-primary" data-section="beauty-studio-social-options" style="cursor: pointer">','</a>' );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-header-top-social-display-selection]', array(
	'choices'  	                => $choices,
	'label'		                => esc_html__( 'Social Display', 'beauty-studio' ),
	'description'               => $description,
	'section'                   => 'beauty-studio-header-top-option',
	'settings'                  => 'beauty_studio_theme_options[beauty-studio-header-top-social-display-selection]',
	'type'	  	                => 'select',
	'active_callback'           => 'beauty_studio_is_enable_header_top'
) );

/*header top message*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-header-top-newsnotice-message]', array(
	'capability'		        => 'edit_theme_options',
	'sanitize_callback'         => 'wp_kses_post'
));

$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-header-top-newsnotice-message]',
		array(
			'section'           => 'beauty-studio-header-top-option',
			'description'       => "<hr />",
			'settings'          => 'beauty_studio_theme_options[beauty-studio-header-top-newsnotice-message]',
			'type'	  	        => 'message',
			'active_callback'   => 'beauty_studio_is_enable_header_top'
		)
	)
);

/*News title*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-newsnotice-title]', array(
    'capability'		        => 'edit_theme_options',
    'default'			        => $defaults['beauty-studio-newsnotice-title'],
    'sanitize_callback'         => 'sanitize_text_field'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-newsnotice-title]', array(
    'label'		                => esc_html__( 'News/Notice/Announcement Title', 'beauty-studio' ),
    'section'                   => 'beauty-studio-header-top-option',
    'settings'                  => 'beauty_studio_theme_options[beauty-studio-newsnotice-title]',
    'type'	  	                => 'text',
    'active_callback'           => 'beauty_studio_is_enable_header_top'
) );

/* News cat selection */
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-newsnotice-cat]', array(
    'capability'		        => 'edit_theme_options',
    'default'			        => $defaults['beauty-studio-newsnotice-cat'],
    'sanitize_callback'         => 'beauty_studio_sanitize_number'
) );

$wp_customize->add_control(
    new Beauty_Studio_Customize_Category_Dropdown_Control(
        $wp_customize,
        'beauty_studio_theme_options[beauty-studio-newsnotice-cat]',
        array(
            'label'		        => esc_html__( 'Select Category News/Notice/Announcement', 'beauty-studio' ),
            'section'           => 'beauty-studio-header-top-option',
            'settings'          => 'beauty_studio_theme_options[beauty-studio-newsnotice-cat]',
            'type'	  	        => 'category_dropdown',
            'active_callback'   => 'beauty_studio_is_enable_header_top'
        )
    )
);