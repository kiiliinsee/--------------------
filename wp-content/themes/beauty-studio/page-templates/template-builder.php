<?php
/**
 * Template Name: AT Builder Page
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package Acme Themes
 * @subpackage Beauty Studio
 */
get_header();
global $beauty_studio_customizer_all_values;

while ( have_posts() ) : the_post();

    the_content();

endwhile; // End of the loop.

get_footer();