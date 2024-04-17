<?php
/*adding footer options panel*/
$wp_customize->add_panel( 'beauty-studio-footer-panel', array(
    'priority'       => 80,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Footer Options', 'beauty-studio' ),
    'description'    => esc_html__( 'Customize your awesome site footer ', 'beauty-studio' )
) );

/*
* file for background image
*/
require beauty_studio_file_directory('acmethemes/customizer/footer-options/footer-bg-img.php');

/*
* file for footer logo options
*/
require beauty_studio_file_directory('acmethemes/customizer/footer-options/footer-copyright.php');