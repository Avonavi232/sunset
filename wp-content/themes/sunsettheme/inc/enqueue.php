<?php
/**
 * @package sunsettheme
 * ===================
 * ADMIN ENQUEUE FUNCTIONS
 * ===================
 */

function sunset_load_admin_scripts( $hook ) {
	if ( $hook == 'toplevel_page_avonavi_sunset' ) {

		wp_register_style('admin-scripts', get_template_directory_uri().'/public/css/admin.css', array(), '1.0.0', 'all');
		wp_enqueue_style('admin-scripts');

		wp_enqueue_media();

		wp_register_script('sunset-admin-script', get_template_directory_uri().'/public/js/admin.js', array('jquery'), '', true);
		wp_enqueue_script('sunset-admin-script');

	} else if ( $hook == 'sunset_page_avonavi_sunset_theme_custom_css' ) {
		wp_enqueue_style('ace_style', get_template_directory_uri().'/public/css/admin_ace.css', array(), '', 'all');
		wp_enqueue_script('ace_script', get_template_directory_uri().'/bower_components/ace-builds-master/src-min-noconflict/ace.js', array('jquery'), '', true);
		wp_enqueue_script('sunset_custom_css_script', get_template_directory_uri().'/public/js/admin_custom_css.js', array('jquery'), '', true);

	}


}
add_action('admin_enqueue_scripts', 'sunset_load_admin_scripts');

