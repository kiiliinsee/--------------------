<?php
if ( ! function_exists( 'beauty_studio_posts_navigation' ) ) :
	/**
	 * Post navigation
	 *
	 * @since Beauty Studio 1.0.0
	 *
	 * @return void
	 */
	function beauty_studio_posts_navigation() {
		global $beauty_studio_customizer_all_values;
		$beauty_studio_pagination_option = $beauty_studio_customizer_all_values['beauty-studio-pagination-option'];
		if( 'default' == $beauty_studio_pagination_option ){
			// Previous/next page navigation.
			the_posts_navigation();
		}
		else {
			// Previous/next page navigation.
			the_posts_pagination();
		}
	}
endif;
add_action( 'beauty_studio_action_posts_navigation', 'beauty_studio_posts_navigation' );

/**
 * Feature Options
 *
 * @since Medical Circle 1.0.0
 *
 * @param null
 * @return string
 *
 */
if ( !function_exists('beauty_studio_featured_image_display') ) :
	function beauty_studio_featured_image_display(  ) {
		global $beauty_studio_customizer_all_values;
		$beauty_studio_single_image_layout = $beauty_studio_customizer_all_values['beauty-studio-single-img-size'];

		return $beauty_studio_single_image_layout;
	}
endif;