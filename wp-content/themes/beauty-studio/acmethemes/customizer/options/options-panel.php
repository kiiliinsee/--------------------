<?php
/*adding theme options panel*/
$wp_customize->add_panel( 'beauty-studio-options', array(
    'priority'       => 90,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Theme Options', 'beauty-studio' ),
    'description'    => esc_html__( 'Customize your awesome site with theme options ', 'beauty-studio' )
) );

/*
* file for header breadcrumb options
*/
require beauty_studio_file_directory('acmethemes/customizer/options/breadcrumb.php');

/*
* file for header search options
*/
require beauty_studio_file_directory('acmethemes/customizer/options/search.php');

/*
* file for social options
*/
require beauty_studio_file_directory('acmethemes/customizer/options/social-options.php');