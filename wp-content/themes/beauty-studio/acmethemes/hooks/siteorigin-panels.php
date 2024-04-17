<?php
/**
 * Adds Beauty Studio Theme Widgets in SiteOrigin Pagebuilder Tabs
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return null
 *
 */
function beauty_studio_siteorigin_widgets($widgets) {
    $theme_widgets = array(
        'Beauty_Studio_Accordion',
        'Beauty_Studio_Posts_Col',
        'Beauty_Studio_Contact',
        'Beauty_Studio_Service',
        'Beauty_Studio_Gallery',
        'Beauty_Studio_Social',
        'Beauty_Studio_Team',
        'Beauty_Studio_Testimonial',
        'Beauty_Studio_Feature',
    );
    foreach($theme_widgets as $theme_widget) {
        if( isset( $widgets[$theme_widget] ) ) {
            $widgets[$theme_widget]['groups'] = array('beauty-studio');
            $widgets[$theme_widget]['icon']   = 'dashicons dashicons-screenoptions';
        }
    }
    return $widgets;
}
add_filter('siteorigin_panels_widgets', 'beauty_studio_siteorigin_widgets');

/**
 * Add a tab for the theme widgets in the page builder
 *
 * @since Beauty Studio 1.0.0
 *
 * @param null
 * @return null
 *
 */
function beauty_studio_siteorigin_widgets_tab($tabs){
    $tabs[] = array(
        'title'  => esc_html__('AT Beauty Studio Widgets', 'beauty-studio'),
        'filter' => array(
            'groups' => array('beauty-studio')
        )
    );
    return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'beauty_studio_siteorigin_widgets_tab', 20 );