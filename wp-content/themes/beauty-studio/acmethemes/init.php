<?php
/**
 * Main include functions ( to support child theme ) that child theme can override file too
 *
 * @since Beauty Studio 1.0.0
 *
 * @param string $file_path, path from the theme
 * @return string full path of file inside theme
 *
 */
if( !function_exists('beauty_studio_file_directory') ){

    function beauty_studio_file_directory( $file_path ){
        if( file_exists( trailingslashit( get_stylesheet_directory() ) . $file_path) ) {
            return trailingslashit( get_stylesheet_directory() ) . $file_path;
        }
        else{
            return trailingslashit( get_template_directory() ) . $file_path;
        }
    }
}

/**
 * Check empty or null
 *
 * @since Beauty Studio 1.0.0
 *
 * @param string $str, string
 * @return boolean
 *
 */
if( !function_exists('beauty_studio_is_null_or_empty') ){
    function beauty_studio_is_null_or_empty( $str ){
        return ( !isset($str) || trim($str)==='' );
    }
}

/*file for library*/
require beauty_studio_file_directory('acmethemes/library/tgm/class-tgm-plugin-activation.php');

/*
* file for customizer theme options
*/
require beauty_studio_file_directory('acmethemes/customizer/customizer.php');

/*
* file for additional functions files
*/
require beauty_studio_file_directory('acmethemes/functions.php');

require beauty_studio_file_directory('acmethemes/functions/sidebar-selection.php');

require beauty_studio_file_directory('acmethemes/functions/primary-menu.php');

/*woocommerce*/
require beauty_studio_file_directory('acmethemes/woocommerce/functions-woocommerce.php');

require beauty_studio_file_directory('acmethemes/woocommerce/class-woocommerce.php');

/*
* files for hooks
*/
require beauty_studio_file_directory('acmethemes/hooks/tgm.php');

require beauty_studio_file_directory('acmethemes/hooks/front-page.php');

require beauty_studio_file_directory('acmethemes/hooks/slider-selection.php');

require beauty_studio_file_directory('acmethemes/hooks/feature-info.php');

require beauty_studio_file_directory('acmethemes/hooks/header.php');

require beauty_studio_file_directory('acmethemes/hooks/header-helper.php');

require beauty_studio_file_directory('acmethemes/hooks/dynamic-css.php');

require beauty_studio_file_directory('acmethemes/hooks/footer.php');

require beauty_studio_file_directory('acmethemes/hooks/comment-forms.php');

require beauty_studio_file_directory('acmethemes/hooks/excerpts.php');

require beauty_studio_file_directory('acmethemes/hooks/siteorigin-panels.php');

require beauty_studio_file_directory('acmethemes/hooks/acme-demo-setup.php');

require beauty_studio_file_directory('acmethemes/hooks/template.php');

/*
* file for sidebar and widgets
*/
require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-service.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-contact.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-gallery.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-accordion.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-col-posts.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-team.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-testimonial.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-social.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/acme-parallax.php');

require beauty_studio_file_directory('acmethemes/sidebar-widget/sidebar.php');

/*file for metaboxes*/
require beauty_studio_file_directory('acmethemes/metabox/meta-icons.php');

require beauty_studio_file_directory('acmethemes/metabox/metabox-defaults.php');

/*
* file for core functions imported from functions.php while downloading Underscores
*/
require beauty_studio_file_directory('acmethemes/core.php');
require beauty_studio_file_directory('acmethemes/gutenberg/gutenberg-init.php');

/*themes info*/
if ( is_admin() ) {
    require beauty_studio_file_directory('acmethemes/at-theme-info/class-at-theme-info.php');
    require beauty_studio_file_directory('acmethemes/admin-notice/class-admin-notice-handler.php');
}