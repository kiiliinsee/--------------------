<?php
/*adding sections for feature info options */
$wp_customize->add_section( 'beauty-studio-feature-info', array(
	'priority'       => 20,
	'capability'     => 'edit_theme_options',
	'title'          => esc_html__( 'Feature Info', 'beauty-studio' ),
	'panel'          => 'beauty-studio-feature-panel'
) );

/* basic info display options*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-feature-info-display-options]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-feature-info-display-options'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_feature_info_display_options();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-feature-info-display-options]', array(
	'choices'  	        => $choices,
	'label'		        => esc_html__( 'Basic Info Display Options', 'beauty-studio' ),
	'section'           => 'beauty-studio-feature-info',
	'settings'          => 'beauty_studio_theme_options[beauty-studio-feature-info-display-options]',
	'type'	  	        => 'select',
) );

/* basic info number*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-feature-info-number]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-feature-info-number'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_feature_info_number();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-feature-info-number]', array(
	'choices'  	        => $choices,
	'label'		        => esc_html__( 'Basic Info Number Display', 'beauty-studio' ),
	'section'           => 'beauty-studio-feature-info',
	'settings'          => 'beauty_studio_theme_options[beauty-studio-feature-info-number]',
	'type'	  	        => 'select',
) );

/*first info*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-first-info-message]', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback' => 'wp_kses_post'
));

$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-first-info-message]',
		array(
			'section'      => 'beauty-studio-feature-info',
			'description'  => "<hr /><h2>".esc_html__('First Info','beauty-studio')."</h2>",
			'settings'     => 'beauty_studio_theme_options[beauty-studio-first-info-message]',
			'type'	  	   => 'message',
		)
	)
);
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-first-info-icon]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-first-info-icon'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );

$wp_customize->add_control(
	new Beauty_Studio_Customize_Icons_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-first-info-icon]',
		array(
			'label'		    => esc_html__( 'Icon', 'beauty-studio' ),
			'section'       => 'beauty-studio-feature-info',
			'settings'      => 'beauty_studio_theme_options[beauty-studio-first-info-icon]',
			'type'	  	    => 'text'
		)
	)
);

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-first-info-title]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-first-info-title'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-first-info-title]', array(
	'label'		            => esc_html__( 'Title', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-first-info-title]',
	'type'	  	            => 'text'
) );

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-first-info-desc]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-first-info-desc'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-first-info-desc]', array(
	'label'		            => esc_html__( 'Very Short Description', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-first-info-desc]',
	'type'	  	            => 'text'
) );

/*Second Info*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-second-info-message]', array(
	'capability'		    => 'edit_theme_options',
	'sanitize_callback'     => 'wp_kses_post'
));

$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-second-info-message]',
		array(
			'section'       => 'beauty-studio-feature-info',
			'description'   => "<hr /><h2>".esc_html__('Second Info','beauty-studio')."</h2>",
			'settings'      => 'beauty_studio_theme_options[beauty-studio-second-info-message]',
			'type'	  	    => 'message',
		)
	)
);
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-second-info-icon]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-second-info-icon'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control(
	new Beauty_Studio_Customize_Icons_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-second-info-icon]',
		array(
			'label'		    => esc_html__( 'Icon', 'beauty-studio' ),
			'section'       => 'beauty-studio-feature-info',
			'settings'      => 'beauty_studio_theme_options[beauty-studio-second-info-icon]',
			'type'	  	    => 'text'
		)
	)
);

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-second-info-title]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-second-info-title'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-second-info-title]', array(
	'label'		            => esc_html__( 'Title', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-second-info-title]',
	'type'	  	            => 'text'
) );

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-second-info-desc]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-second-info-desc'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-second-info-desc]', array(
	'label'		            => esc_html__( 'Very Short Description', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-second-info-desc]',
	'type'	  	            => 'text'
) );

/*third info*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-third-info-message]', array(
	'capability'		    => 'edit_theme_options',
	'sanitize_callback'     => 'wp_kses_post'
));

$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-third-info-message]',
		array(
			'section'       => 'beauty-studio-feature-info',
			'description'   => "<hr /><h2>".esc_html__('Third Info','beauty-studio')."</h2>",
			'settings'      => 'beauty_studio_theme_options[beauty-studio-third-info-message]',
			'type'	  	    => 'message',
		)
	)
);
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-third-info-icon]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-third-info-icon'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control(
	new Beauty_Studio_Customize_Icons_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-third-info-icon]',
		array(
			'label'		    => esc_html__( 'Icon', 'beauty-studio' ),
			'section'       => 'beauty-studio-feature-info',
			'settings'      => 'beauty_studio_theme_options[beauty-studio-third-info-icon]',
			'type'	  	    => 'text'
		)
	)
);

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-third-info-title]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-third-info-title'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-third-info-title]', array(
	'label'		            => esc_html__( 'Title', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-third-info-title]',
	'type'	  	            => 'text'
) );

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-third-info-desc]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-third-info-desc'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-third-info-desc]', array(
	'label'		            => esc_html__( 'Very Short Description', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-third-info-desc]',
	'type'	  	            => 'text'
) );

/*forth info*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-forth-info-message]', array(
	'capability'		    => 'edit_theme_options',
	'sanitize_callback'     => 'wp_kses_post'
));

$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-forth-info-message]',
		array(
			'section'       => 'beauty-studio-feature-info',
			'description'   => "<hr /><h2>".esc_html__('Forth Info','beauty-studio')."</h2>",
			'settings'      => 'beauty_studio_theme_options[beauty-studio-forth-info-message]',
			'type'	  	    => 'message',
		)
	)
);
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-forth-info-icon]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-forth-info-icon'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control(
	new Beauty_Studio_Customize_Icons_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-forth-info-icon]',
		array(
			'label'		    => esc_html__( 'Icon', 'beauty-studio' ),
			'section'       => 'beauty-studio-feature-info',
			'settings'      => 'beauty_studio_theme_options[beauty-studio-forth-info-icon]',
			'type'	  	    => 'text'
		)
	)
);

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-forth-info-title]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-forth-info-title'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-forth-info-title]', array(
	'label'		            => esc_html__( 'Title', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-forth-info-title]',
	'type'	  	            => 'text'
) );

$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-forth-info-desc]', array(
	'capability'		    => 'edit_theme_options',
	'default'			    => $defaults['beauty-studio-forth-info-desc'],
	'sanitize_callback'     => 'beauty_studio_sanitize_allowed_html'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-forth-info-desc]', array(
	'label'		            => esc_html__( 'Very Short Description', 'beauty-studio' ),
	'section'               => 'beauty-studio-feature-info',
	'settings'              => 'beauty_studio_theme_options[beauty-studio-forth-info-desc]',
	'type'	  	            => 'text'
) );