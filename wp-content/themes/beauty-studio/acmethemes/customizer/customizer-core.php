<?php
/**
 * Menu and Logo Display Options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_header_image_display
 *
 */
if ( !function_exists('beauty_studio_header_image_display') ) :
	function beauty_studio_header_image_display() {
		$beauty_studio_header_image_display =  array(
			'hide'              => esc_html__( 'Hide', 'beauty-studio' ),
			'bg-image'          => esc_html__( 'Background Image', 'beauty-studio' ),
			'normal-image'      => esc_html__( 'Normal Image', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_header_image_display', $beauty_studio_header_image_display );
	}
endif;

/**
 * Menu Right Button Link Options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_menu_right_button_link_options
 *
 */
if ( !function_exists('beauty_studio_menu_right_button_link_options') ) :
	function beauty_studio_menu_right_button_link_options() {
		$beauty_studio_menu_right_button_link_options =  array(
			'disable'       => esc_html__( 'Disable', 'beauty-studio' ),
			'booking'       => esc_html__( 'Popup Widgets ( Booking Form )', 'beauty-studio' ),
			'link'          => esc_html__( 'One Link', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_menu_right_button_link_options', $beauty_studio_menu_right_button_link_options );
	}
endif;

/**
 * Header top display options of elements
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_header_top_display_selection
 *
 */
if ( !function_exists('beauty_studio_header_top_display_selection') ) :
	function beauty_studio_header_top_display_selection() {
		$beauty_studio_header_top_display_selection =  array(
			'hide'          => esc_html__( 'Hide', 'beauty-studio' ),
			'left'          => esc_html__( 'on Top Left', 'beauty-studio' ),
			'right'         => esc_html__( 'on Top Right', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_header_top_display_selection', $beauty_studio_header_top_display_selection );
	}
endif;


/**
 * Feature slider text align
 *
 * @since Mercantile 1.0.0
 *
 * @param null
 * @return array $beauty_studio_slider_text_align
 *
 */
if ( !function_exists('beauty_studio_slider_text_align') ) :
	function beauty_studio_slider_text_align() {
		$beauty_studio_slider_text_align =  array(
			'alternate'     => esc_html__( 'Alternate', 'beauty-studio' ),
			'text-left'     => esc_html__( 'Left', 'beauty-studio' ),
			'text-right'    => esc_html__( 'Right', 'beauty-studio' ),
			'text-center'   => esc_html__( 'Center', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_slider_text_align', $beauty_studio_slider_text_align );
	}
endif;

/**
 * Featured Slider Image Options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_fs_image_display_options
 *
 */
if ( !function_exists('beauty_studio_fs_image_display_options') ) :
	function beauty_studio_fs_image_display_options() {
		$beauty_studio_fs_image_display_options =  array(
			'full-screen-bg' => esc_html__( 'Full Screen Background', 'beauty-studio' ),
			'responsive-img' => esc_html__( 'Responsive Image', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_fs_image_display_options', $beauty_studio_fs_image_display_options );
	}
endif;

/**
 * Feature Info display Options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_feature_info_display_options
 *
 */
if ( !function_exists('beauty_studio_feature_info_display_options') ) :
	function beauty_studio_feature_info_display_options() {
		$beauty_studio_feature_info_display_options =  array(
			'hide'                  => esc_html__( 'Hide', 'beauty-studio' ),
			'below'                 => esc_html__( 'Below Feature Slider', 'beauty-studio' ),
			'absolute'              => esc_html__( 'Absolute Feature Slider', 'beauty-studio' ),
		);
		return apply_filters( 'beauty_studio_feature_info_display_options', $beauty_studio_feature_info_display_options );
	}
endif;

/**
 * Feature Info number
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_feature_info_number
 *
 */
if ( !function_exists('beauty_studio_feature_info_number') ) :
	function beauty_studio_feature_info_number() {
		$beauty_studio_feature_info_number =  array(
			1               => esc_html__( '1', 'beauty-studio' ),
			2               => esc_html__( '2', 'beauty-studio' ),
			3               => esc_html__( '3', 'beauty-studio' ),
			4               => esc_html__( '4', 'beauty-studio' ),
		);
		return apply_filters( 'beauty_studio_feature_info_number', $beauty_studio_feature_info_number );
	}
endif;

/**
 * Footer copyright beside options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_footer_copyright_beside_option
 *
 */
if ( !function_exists('beauty_studio_footer_copyright_beside_option') ) :
	function beauty_studio_footer_copyright_beside_option() {
		$beauty_studio_footer_copyright_beside_option =  array(
			'hide'          => esc_html__( 'Hide', 'beauty-studio' ),
			'social'        => esc_html__( 'Social Links', 'beauty-studio' ),
			'footer-menu'   => esc_html__( 'Footer Menu', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_footer_copyright_beside_option', $beauty_studio_footer_copyright_beside_option );
	}
endif;

/**
 * Sidebar layout options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_sidebar_layout
 *
 */
if ( !function_exists('beauty_studio_sidebar_layout') ) :
    function beauty_studio_sidebar_layout() {
        $beauty_studio_sidebar_layout =  array(
	        'right-sidebar' => esc_html__( 'Right Sidebar', 'beauty-studio' ),
	        'left-sidebar'  => esc_html__( 'Left Sidebar' , 'beauty-studio' ),
	        'both-sidebar'  => esc_html__( 'Both Sidebar' , 'beauty-studio' ),
	        'middle-col'    => esc_html__( 'Middle Column' , 'beauty-studio' ),
	        'no-sidebar'    => esc_html__( 'No Sidebar', 'beauty-studio' )
        );
        return apply_filters( 'beauty_studio_sidebar_layout', $beauty_studio_sidebar_layout );
    }
endif;

/**
 * Blog content from
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_blog_archive_content_from
 *
 */
if ( !function_exists('beauty_studio_blog_archive_content_from') ) :
	function beauty_studio_blog_archive_content_from() {
		$beauty_studio_blog_archive_content_from =  array(
			'excerpt'    => esc_html__( 'Excerpt', 'beauty-studio' ),
			'content'    => esc_html__( 'Content', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_blog_archive_content_from', $beauty_studio_blog_archive_content_from );
	}
endif;


/**
 * Image Size
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array $beauty_studio_get_image_sizes_options
 *
 */
if ( !function_exists('beauty_studio_get_image_sizes_options') ) :
	function beauty_studio_get_image_sizes_options( $add_disable = false ) {
		global $_wp_additional_image_sizes;
		$choices = array();
		if ( true == $add_disable ) {
			$choices['disable'] = esc_html__( 'No Image', 'beauty-studio' );
		}
		foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
			$choices[ $_size ] = $_size . ' ('. get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
		}
		$choices['full'] = esc_html__( 'full (original)', 'beauty-studio' );
		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {

			foreach ($_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key . ' ('. $size['width'] . 'x' . $size['height'] . ')';
			}
		}
		return apply_filters( 'beauty_studio_get_image_sizes_options', $choices );
	}
endif;

/**
 * Pagination Options
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return array beauty_studio_pagination_options
 *
 */
if ( !function_exists('beauty_studio_pagination_options') ) :
	function beauty_studio_pagination_options() {
		$beauty_studio_pagination_options =  array(
			'default'  => esc_html__( 'Default', 'beauty-studio' ),
			'numeric'  => esc_html__( 'Numeric', 'beauty-studio' )
		);
		return apply_filters( 'beauty_studio_pagination_options', $beauty_studio_pagination_options );
	}
endif;