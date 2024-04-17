<?php
/**
 * Select sidebar according to the options saved
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return string
 *
 */
if ( !function_exists('beauty_studio_sidebar_selection') ) :
	function beauty_studio_sidebar_selection( ) {
		wp_reset_postdata();
		$beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
		global $post;
		if(
			isset( $beauty_studio_customizer_all_values['beauty-studio-single-sidebar-layout'] ) &&
			(
				'left-sidebar' == $beauty_studio_customizer_all_values['beauty-studio-single-sidebar-layout'] ||
				'both-sidebar' == $beauty_studio_customizer_all_values['beauty-studio-single-sidebar-layout'] ||
				'middle-col' == $beauty_studio_customizer_all_values['beauty-studio-single-sidebar-layout'] ||
				'no-sidebar' == $beauty_studio_customizer_all_values['beauty-studio-single-sidebar-layout']
			)
		){
			$beauty_studio_body_global_class = $beauty_studio_customizer_all_values['beauty-studio-single-sidebar-layout'];
		}
		else{
			$beauty_studio_body_global_class= 'right-sidebar';
		}

		if ( beauty_studio_is_woocommerce_active() && ( is_product() || is_shop() || is_product_taxonomy() )) {
			if( is_product() ){
				$post_class = get_post_meta( $post->ID, 'beauty_studio_sidebar_layout', true );
				$beauty_studio_wc_single_product_sidebar_layout = $beauty_studio_customizer_all_values['beauty-studio-wc-single-product-sidebar-layout'];

				if ( 'default-sidebar' != $post_class ){
					if ( $post_class ) {
						$beauty_studio_body_classes = $post_class;
					} else {
						$beauty_studio_body_classes = $beauty_studio_wc_single_product_sidebar_layout;
					}
				}
				else{
					$beauty_studio_body_classes = $beauty_studio_wc_single_product_sidebar_layout;

				}
			}
			else{
				if( isset( $beauty_studio_customizer_all_values['beauty-studio-wc-shop-archive-sidebar-layout'] ) ){
					$beauty_studio_archive_sidebar_layout = $beauty_studio_customizer_all_values['beauty-studio-wc-shop-archive-sidebar-layout'];
					if(
						'right-sidebar' == $beauty_studio_archive_sidebar_layout ||
						'left-sidebar' == $beauty_studio_archive_sidebar_layout ||
						'both-sidebar' == $beauty_studio_archive_sidebar_layout ||
						'middle-col' == $beauty_studio_archive_sidebar_layout ||
						'no-sidebar' == $beauty_studio_archive_sidebar_layout
					){
						$beauty_studio_body_classes = $beauty_studio_archive_sidebar_layout;
					}
					else{
						$beauty_studio_body_classes = $beauty_studio_body_global_class;
					}
				}
				else{
					$beauty_studio_body_classes= $beauty_studio_body_global_class;
				}
			}
		}
		elseif( is_front_page() ){
			if( isset( $beauty_studio_customizer_all_values['beauty-studio-front-page-sidebar-layout'] ) ){
				if(
					'right-sidebar' == $beauty_studio_customizer_all_values['beauty-studio-front-page-sidebar-layout'] ||
					'left-sidebar' == $beauty_studio_customizer_all_values['beauty-studio-front-page-sidebar-layout'] ||
					'both-sidebar' == $beauty_studio_customizer_all_values['beauty-studio-front-page-sidebar-layout'] ||
					'middle-col' == $beauty_studio_customizer_all_values['beauty-studio-front-page-sidebar-layout'] ||
					'no-sidebar' == $beauty_studio_customizer_all_values['beauty-studio-front-page-sidebar-layout']
				){
					$beauty_studio_body_classes = $beauty_studio_customizer_all_values['beauty-studio-front-page-sidebar-layout'];
				}
				else{
					$beauty_studio_body_classes = $beauty_studio_body_global_class;
				}
			}
			else{
				$beauty_studio_body_classes= $beauty_studio_body_global_class;
			}
		}

		elseif ( is_singular() && isset( $post->ID ) ) {
			$post_class = get_post_meta( $post->ID, 'beauty_studio_sidebar_layout', true );
			if ( 'default-sidebar' != $post_class ){
				if ( $post_class ) {
					$beauty_studio_body_classes = $post_class;
				} else {
					$beauty_studio_body_classes = $beauty_studio_body_global_class;
				}
			}
			else{
				$beauty_studio_body_classes = $beauty_studio_body_global_class;
			}

		}
		elseif ( is_archive() ) {
			if( isset( $beauty_studio_customizer_all_values['beauty-studio-archive-sidebar-layout'] ) ){
				$beauty_studio_archive_sidebar_layout = $beauty_studio_customizer_all_values['beauty-studio-archive-sidebar-layout'];
				if(
					'right-sidebar' == $beauty_studio_archive_sidebar_layout ||
					'left-sidebar' == $beauty_studio_archive_sidebar_layout ||
					'both-sidebar' == $beauty_studio_archive_sidebar_layout ||
					'middle-col' == $beauty_studio_archive_sidebar_layout ||
					'no-sidebar' == $beauty_studio_archive_sidebar_layout
				){
					$beauty_studio_body_classes = $beauty_studio_archive_sidebar_layout;
				}
				else{
					$beauty_studio_body_classes = $beauty_studio_body_global_class;
				}
			}
			else{
				$beauty_studio_body_classes= $beauty_studio_body_global_class;
			}
		}
		else {
			$beauty_studio_body_classes = $beauty_studio_body_global_class;
		}
		return $beauty_studio_body_classes;
	}
endif;