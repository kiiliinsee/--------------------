<?php
/*adding theme options panel*/
$wp_customize->add_panel( 'beauty-studio-wc-panel', array(
	'priority'       => 100,
	'capability'     => 'edit_theme_options',
	'title'          => esc_html__( 'WooCommerce Options', 'beauty-studio' )
) );

/*
* file for shop archive
*/
require_once beauty_studio_file_directory('acmethemes/customizer/wc-options/shop-archive.php');

/*
* file for single product
*/
require_once beauty_studio_file_directory('acmethemes/customizer/wc-options/single-product.php');