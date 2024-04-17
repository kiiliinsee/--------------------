<?php
/**
 * Sanitize choices
 * @since Beauty Studio 1.0.0
 * @param null
 * @return string $beauty_studio_about_column_number
 *
 */
if ( ! function_exists( 'beauty_studio_sanitize_choice_options' ) ) :
	function beauty_studio_sanitize_choice_options( $value, $choices, $default ) {
		$input = wp_kses_post( $value );
		$output = array_key_exists( $input, $choices ) ? $input : $default;
		return $output;
	}
endif;

/**
 * Common functions for widgets
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 *
 * @return array $beauty_studio_about_column_number
 *
 */
if ( ! function_exists( 'beauty_studio_background_options' ) ) :
	function beauty_studio_background_options() {
		$beauty_studio_about_column_number = array(
			'default'   => esc_html__( 'Default', 'beauty-studio' ),
			'gray'      => esc_html__( 'Gray', 'beauty-studio' )
		);

		return apply_filters( 'beauty_studio_background_options', $beauty_studio_about_column_number );
	}
endif;

/**
 * Column Number
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 *
 * @return array $beauty_studio_about_column_number
 *
 */
if ( ! function_exists( 'beauty_studio_widget_column_number' ) ) :
	function beauty_studio_widget_column_number() {
		$beauty_studio_about_column_number = array(
			1 => esc_html__( '1', 'beauty-studio' ),
			2 => esc_html__( '2', 'beauty-studio' ),
			3 => esc_html__( '3', 'beauty-studio' ),
			4 => esc_html__( '4', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_widget_column_number', $beauty_studio_about_column_number );
	}
endif;

/**
 * Widget Image Popup Type
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_gallery_image_popup
 *
 */
if ( !function_exists('beauty_studio_gallery_image_popup') ) :
	function beauty_studio_gallery_image_popup() {
		$beauty_studio_gallery_image_popup =  array(
			'gallery'   => esc_html__( 'Gallery', 'beauty-studio' ),
			'single'    => esc_html__( 'Single', 'beauty-studio' ),
			'disable'   => esc_html__( 'Disable', 'beauty-studio' ),
		);
		return apply_filters( 'beauty_studio_gallery_image_popup', $beauty_studio_gallery_image_popup );
	}
endif;

/**
 * Content From
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 *
 * @return array $beauty_studio_content_from
 *
 */
if ( ! function_exists( 'beauty_studio_content_from' ) ) :
	function beauty_studio_content_from() {
		$beauty_studio_about_column_number = array(
			'excerpt' => esc_html__( 'Excerpt', 'beauty-studio' ),
			'content' => esc_html__( 'Content', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_content_from', $beauty_studio_about_column_number );
	}
endif;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function beauty_studio_widgets_init() {
	register_sidebar( array(
        'name'          => esc_html__( 'Right Sidebar', 'beauty-studio' ),
        'id'            => 'beauty-studio-sidebar',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    if ( is_customize_preview() ) {
        $beauty_studio_home_description = sprintf( esc_html__( 'Displays widgets on home page main content area.%1$s Note : Please go to %2$s "Static Front Page"%3$s setting, Select "A static page" then "Front page" and "Posts page" to show added widgets', 'beauty-studio' ), '<br />','<b><a class="at-customizer" data-section="static_front_page" style="cursor: pointer">','</a></b>' );
    }
    else{
        $beauty_studio_home_description = esc_html__( 'Displays widgets on Front/Home page. Note : Please go to Setting => Reading, Select "A static page" then "Front page" and "Posts page" to show added widgets', 'beauty-studio' );
    }
    register_sidebar(array(
        'name'          => esc_html__('Home Main Content Area', 'beauty-studio'),
        'id'            => 'beauty-studio-home',
        'description'	=> $beauty_studio_home_description,
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title init-animate zoomIn"><span>',
        'after_title'   => '</span></h2>',
    ));

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'beauty-studio' ),
		'id'            => 'beauty-studio-sidebar-left',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar(array(
        'name'          => esc_html__('Footer Column One', 'beauty-studio'),
        'id'            => 'footer-col-one',
        'description'   => esc_html__('Displays items on top footer section.', 'beauty-studio'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Column Two', 'beauty-studio'),
        'id'            => 'footer-col-two',
        'description'   => esc_html__('Displays items on top footer section.', 'beauty-studio'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Column Three', 'beauty-studio'),
        'id'            => 'footer-col-three',
        'description'   => esc_html__('Displays items on top footer section.', 'beauty-studio'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer Column Four', 'beauty-studio'),
        'id'            => 'footer-col-four',
        'description'   => esc_html__('Displays items on top footer section.', 'beauty-studio'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>',
    ));

	register_sidebar(array(
		'name'          => esc_html__('Popup Widget Area', 'beauty-studio'),
		'id'            => 'popup-widget-area',
		'description'   => esc_html__('Displays items on Pop up', 'beauty-studio'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

    /*Widgets*/
	register_widget( 'Beauty_Studio_Accordion' );
	register_widget( 'Beauty_Studio_Posts_Col' );
	register_widget( 'Beauty_Studio_Contact' );
	register_widget( 'Beauty_Studio_Service' );
	register_widget( 'Beauty_Studio_Gallery' );
	register_widget( 'Beauty_Studio_Social' );
	register_widget( 'Beauty_Studio_Team' );
	register_widget( 'Beauty_Studio_Testimonial' );
	register_widget( 'Beauty_Studio_Feature' );
}
add_action( 'widgets_init', 'beauty_studio_widgets_init' );

/* ajax callback for get_edit_post_link*/
add_action( 'wp_ajax_at_get_edit_post_link', 'beauty_studio_get_edit_post_link' );
function beauty_studio_get_edit_post_link(){
    if( isset( $_GET['id'] ) ){
	    $id = absint( $_GET['id'] );
	    if( get_edit_post_link( $id ) ){
		    ?>
            <a class="button button-link at-postid alignright" target="_blank" href="<?php echo esc_url( get_edit_post_link( $id ) ); ?>">
			    <?php esc_html_e('Full Edit','beauty-studio');?>
            </a>
		    <?php
	    }
	    else{
		    echo 0;
	    }
	    exit;
    }
}