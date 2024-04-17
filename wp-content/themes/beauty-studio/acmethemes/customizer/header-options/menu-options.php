<?php
/*check for beauty-studio-menu-right-button-options*/
if ( !function_exists('beauty_studio_menu_right_button_if_not_disable') ) :
	function beauty_studio_menu_right_button_if_not_disable() {
		$beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
		if( 'disable' != $beauty_studio_customizer_all_values['beauty-studio-menu-right-button-options'] ){
			return true;
		}
		return false;
	}
endif;

if ( !function_exists('beauty_studio_menu_right_button_if_booking') ) :
	function beauty_studio_menu_right_button_if_booking() {
		$beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
		if( 'booking' == $beauty_studio_customizer_all_values['beauty-studio-menu-right-button-options'] ){
			return true;
		}
		return false;
	}
endif;

if ( !function_exists('beauty_studio_menu_right_button_if_link') ) :
	function beauty_studio_menu_right_button_if_link() {
		$beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
		if( 'link' == $beauty_studio_customizer_all_values['beauty-studio-menu-right-button-options'] ){
			return true;
		}
		return false;
	}
endif;

/*Menu Section*/
$wp_customize->add_section( 'beauty-studio-menu-options', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Menu Options', 'beauty-studio' ),
    'panel'          => 'beauty-studio-header-panel'
) );

/*enable transparent*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-enable-transparent]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-enable-transparent'],
	'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );

$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-enable-transparent]', array(
	'label'		    => esc_html__( 'Enable Transparent Menu', 'beauty-studio' ),
	'description'   => esc_html__( 'Enabling Transparent Menu automatically enable Sticky Menu', 'beauty-studio' ),
	'section'       => 'beauty-studio-menu-options',
	'settings'      => 'beauty_studio_theme_options[beauty-studio-enable-transparent]',
	'type'	  	    => 'checkbox'
) );


/*enable sticky*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-enable-sticky]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-enable-sticky'],
    'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
) );

$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-enable-sticky]', array(
    'label'		=> esc_html__( 'Enable Sticky Menu', 'beauty-studio' ),
    'section'   => 'beauty-studio-menu-options',
    'settings'  => 'beauty_studio_theme_options[beauty-studio-enable-sticky]',
    'type'	  	=> 'checkbox'
) );

if( beauty_studio_is_woocommerce_active() ){
	/*enable cart*/
	$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-enable-cart-icon]', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['beauty-studio-enable-cart-icon'],
		'sanitize_callback' => 'beauty_studio_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-enable-cart-icon]', array(
		'label'		=> esc_html__( 'Enable Cart', 'beauty-studio' ),
		'section'   => 'beauty-studio-menu-options',
		'settings'  => 'beauty_studio_theme_options[beauty-studio-enable-cart-icon]',
		'type'	  	=> 'checkbox'
	) );
}

/*Button Right Message*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-menu-right-button-message]', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback' => 'wp_kses_post'
));

$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-menu-right-button-message]',
		array(
			'section'       => 'beauty-studio-menu-options',
			'description'   => "<hr /><h2>".esc_html__('Special Button On Menu Right','beauty-studio')."</h2>",
			'settings'      => 'beauty_studio_theme_options[beauty-studio-menu-right-button-message]',
			'type'	  	    => 'message'
		)
	)
);

/*Button Link Options*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-menu-right-button-options]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-menu-right-button-options'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_menu_right_button_link_options();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-menu-right-button-options]', array(
	'choices'  	    => $choices,
	'label'		    => esc_html__( 'Button Options', 'beauty-studio' ),
	'section'       => 'beauty-studio-menu-options',
	'settings'      => 'beauty_studio_theme_options[beauty-studio-menu-right-button-options]',
	'type'	  	    => 'select'
) );

/*Button title*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-menu-right-button-title]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-menu-right-button-title'],
	'sanitize_callback' => 'sanitize_text_field'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-menu-right-button-title]', array(
	'label'		        => esc_html__( 'Button Title', 'beauty-studio' ),
	'section'           => 'beauty-studio-menu-options',
	'settings'          => 'beauty_studio_theme_options[beauty-studio-menu-right-button-title]',
	'type'	  	        => 'text',
	'active_callback'   => 'beauty_studio_menu_right_button_if_not_disable'
) );

/*Button Right booking Message*/
$wp_customize->add_setting('beauty_studio_theme_options[beauty-studio-menu-right-button-booking-message]', array(
	'capability'		=> 'edit_theme_options',
	'sanitize_callback' => 'wp_kses_post'
));
$description = sprintf( esc_html__( '%1$sAdd Popup Widget from here%2$s ', 'beauty-studio' ), '<a class="at-customizer" data-section="sidebar-widgets-popup-widget-area" style="cursor: pointer">','</a>' );
$wp_customize->add_control(
	new Beauty_Studio_Customize_Message_Control(
		$wp_customize,
		'beauty_studio_theme_options[beauty-studio-menu-right-button-booking-message]',
		array(
			'section'           => 'beauty-studio-menu-options',
			'description'       => $description,
			'settings'          => 'beauty_studio_theme_options[beauty-studio-menu-right-button-booking-message]',
			'type'	  	        => 'message',
			'active_callback'   => 'beauty_studio_menu_right_button_if_booking',
            'priority'	  	    => 100
        )
	)
);

/*Button link*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-menu-right-button-link]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-menu-right-button-link'],
	'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-menu-right-button-link]', array(
	'label'		        => esc_html__( 'Button Link', 'beauty-studio' ),
	'section'           => 'beauty-studio-menu-options',
	'settings'          => 'beauty_studio_theme_options[beauty-studio-menu-right-button-link]',
	'type'	  	        => 'url',
	'active_callback'   => 'beauty_studio_menu_right_button_if_link'
) );