<?php
/*adding feature options panel*/
$wp_customize->add_panel( 'beauty-studio-feature-panel', array(
    'priority'       => 40,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Featured Section Options', 'beauty-studio' ),
    'description'    => esc_html__( 'Customize your awesome site feature section ', 'beauty-studio' )
) );

/*
* file for feature section enable
*/
require beauty_studio_file_directory('acmethemes/customizer/feature-section/feature-enable.php');

/*
* file for feature slider category
*/
require beauty_studio_file_directory('acmethemes/customizer/feature-section/feature-slider.php');

/*
* file for feature info
*/
require beauty_studio_file_directory('acmethemes/customizer/feature-section/feature-info.php');