<?php
/*active callback function for excerpt*/
if ( !function_exists('beauty_studio_active_callback_content_from_excerpt') ) :
	function beauty_studio_active_callback_content_from_excerpt() {
		$beauty_studio_customizer_all_values = beauty_studio_get_theme_options();
		if( 'excerpt' == $beauty_studio_customizer_all_values['beauty-studio-blog-archive-content-from'] ){
			return true;
		}
		return false;
	}
endif;

/*adding sections for blog layout options*/
$wp_customize->add_section( 'beauty-studio-design-blog-layout-option', array(
    'priority'       => 30,
    'capability'     => 'edit_theme_options',
    'title'          => esc_html__( 'Default Blog/Archive Layout', 'beauty-studio' ),
    'panel'          => 'beauty-studio-design-panel'
) );

/*blog layout*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-blog-archive-img-size]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-blog-archive-img-size'],
    'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_get_image_sizes_options(1);
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-blog-archive-img-size]', array(
    'choices'  	    => $choices,
    'label'		    => esc_html__( 'Blog/Archive Feature Image Size', 'beauty-studio' ),
    'section'       => 'beauty-studio-design-blog-layout-option',
    'settings'      => 'beauty_studio_theme_options[beauty-studio-blog-archive-img-size]',
    'type'	  	    => 'select'
) );

/*blog content from*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-blog-archive-content-from]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-blog-archive-content-from'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_blog_archive_content_from();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-blog-archive-content-from]', array(
	'choices'  	    => $choices,
	'label'		    => esc_html__( 'Blog/Archive Content From', 'beauty-studio' ),
	'section'       => 'beauty-studio-design-blog-layout-option',
	'settings'      => 'beauty_studio_theme_options[beauty-studio-blog-archive-content-from]',
	'type'	  	    => 'select'
) );

/*Excerpt Length*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-blog-archive-excerpt-length]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-blog-archive-excerpt-length'],
	'sanitize_callback' => 'absint'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-blog-archive-excerpt-length]', array(
	'label'		        => esc_html__( 'Except Length', 'beauty-studio' ),
	'section'           => 'beauty-studio-design-blog-layout-option',
	'settings'          => 'beauty_studio_theme_options[beauty-studio-blog-archive-excerpt-length]',
	'type'	  	        => 'number',
	'active_callback'   => 'beauty_studio_active_callback_content_from_excerpt'
) );

/*Read More Text*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-blog-archive-more-text]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['beauty-studio-blog-archive-more-text'],
    'sanitize_callback' => 'sanitize_text_field'
) );
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-blog-archive-more-text]', array(
    'label'		=> esc_html__( 'Read More Text', 'beauty-studio' ),
    'section'   => 'beauty-studio-design-blog-layout-option',
    'settings'  => 'beauty_studio_theme_options[beauty-studio-blog-archive-more-text]',
    'type'	  	=> 'text'
) );

/*Pagination Options*/
$wp_customize->add_setting( 'beauty_studio_theme_options[beauty-studio-pagination-option]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['beauty-studio-pagination-option'],
	'sanitize_callback' => 'beauty_studio_sanitize_select'
) );
$choices = beauty_studio_pagination_options();
$wp_customize->add_control( 'beauty_studio_theme_options[beauty-studio-pagination-option]', array(
	'choices'  	    => $choices,
	'label'		    => esc_html__( 'Pagination Options', 'beauty-studio' ),
	'description'   => esc_html__( 'Blog and Archive Pages Pagination', 'beauty-studio' ),
	'section'       => 'beauty-studio-design-blog-layout-option',
	'settings'      => 'beauty_studio_theme_options[beauty-studio-pagination-option]',
	'type'	  	    => 'select'
) );