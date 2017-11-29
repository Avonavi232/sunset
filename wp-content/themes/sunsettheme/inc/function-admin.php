<?php
/**
 * @package sunsettheme
 * ===================
 * ADMIN PAGE
 * ===================
 */


/**
 * Add pages and subpages to admin:
 *  Sunset
 *    Sidebar
 *    Theme Options
 *    Contact Form
 */
function sunset_add_admin_page() {

	//Generate Sunset Admin Page
	add_menu_page('Sunset Theme Options', 'Sunset', 'manage_options', 'avonavi_sunset', 'sunset_page_sidebar', get_template_directory_uri() . '/public/img/sunset-icon.png' , 110);

	//Generate Sunset Admin Sub Pages
	add_submenu_page('avonavi_sunset', 'Sunset Sidebar Options', 'Sidebar', 'manage_options', 'avonavi_sunset', 'sunset_page_sidebar' );

	add_submenu_page('avonavi_sunset', 'Sunset Theme Options', 'Theme Options', 'manage_options', 'avonavi_sunset_theme', 'sunset_subpage_theme' );

	add_submenu_page('avonavi_sunset', 'Sunset Contact Form Options', 'Contact Form', 'manage_options', 'avonavi_sunset_theme_contact', 'sunset_subpage_contact_form' );

	add_submenu_page('avonavi_sunset', 'Sunset Custom CSS Options', 'Custom CSS', 'manage_options', 'avonavi_sunset_theme_custom_css', 'sunset_subpage_custom_css' );


	//Activation custom settings
	add_action('admin_init', 'sunset_settings_sidebar');
	add_action('admin_init', 'sunset_settings_theme');
	add_action('admin_init', 'sunset_settings_contact_form');
	add_action('admin_init', 'sunset_settings_custom_css');
}
add_action('admin_menu', 'sunset_add_admin_page');



/**
 * Settings pages and subpages FRONTEND:
 *  sidebar options : sunset-page-sidebar.php
 *  theme options : sunset-subpage-theme.php
 *  contact form options :
 * */

/*sidebar options*/
function sunset_page_sidebar() {
	//generation of out admin page
	require_once(get_template_directory() . '/inc/templates/sunset-page-sidebar.php');
}

/*theme options*/
function sunset_subpage_theme() {
	//generation of out admin page
	require_once(get_template_directory() . '/inc/templates/sunset-subpage-theme.php');
}

/*contact form options*/
function sunset_subpage_contact_form() {
	require_once(get_template_directory() . '/inc/templates/sunset-subpage-contact-form.php');
}

/*Custom CSS options*/
function sunset_subpage_custom_css() {
	require_once(get_template_directory() . '/inc/templates/sunset-subpage-custom-css.php');
}



/**
 * REGISTER settings, add settings field & section for:
 *  sidebar options
 *  theme options
 *  contact form options
 * */

/*Sidebar settings*/
function sunset_settings_sidebar() {
	add_settings_section('sunset-sidebar-options', 'Sidebar Option', 'sunset_callback_section_sidebar', 'avonavi_sunset');

	register_setting('sunset-settings-group', 'profile_picture');
	register_setting('sunset-settings-group', 'first_name');
	register_setting('sunset-settings-group', 'last_name');
	register_setting('sunset-settings-group', 'twitter_handler', 'sunset_sanitize_sidebar_twitter');
	register_setting('sunset-settings-group', 'facebook_handler');
	register_setting('sunset-settings-group', 'gplus_handler');
	register_setting('sunset-settings-group', 'user_description');


	add_settings_field('sidebar-profile-picture', 'Profile Picture', 'sunset_callback_sidebar_profile_picture', 'avonavi_sunset', 'sunset-sidebar-options');
	add_settings_field('sidebar-name', 'Your Name', 'sunset_callback_sidebar_name', 'avonavi_sunset', 'sunset-sidebar-options');
	add_settings_field('sidebar-description', 'Description', 'sunset_callback_sidebar_description', 'avonavi_sunset', 'sunset-sidebar-options');
	add_settings_field('sidebar-twitter', 'Twitter handler', 'sunset_callback_sidebar_twitter', 'avonavi_sunset', 'sunset-sidebar-options');
	add_settings_field('sidebar-facebook', 'Facebook handler', 'sunset_callback_sidebar_facebook', 'avonavi_sunset', 'sunset-sidebar-options');
	add_settings_field('sidebar-gplus', 'GPlus handler', 'sunset_callback_sidebar_gplus', 'avonavi_sunset', 'sunset-sidebar-options');
}

/*Theme settings*/
function sunset_settings_theme() {
	add_settings_section('sunset-theme-option', 'Theme Options', 'sunset_callback_section_theme', 'avonavi_sunset_theme');

	register_setting('sunset-theme-support', 'post_formats');
	register_setting('sunset-theme-support', 'custom_header');
	register_setting('sunset-theme-support', 'custom_background');

	add_settings_field('post-formats', 'Post Formats', 'sunset_callback_theme_post_formats', 'avonavi_sunset_theme', 'sunset-theme-option');
	add_settings_field('custom-header', 'Custom Header', 'sunset_callback_theme_custom_header', 'avonavi_sunset_theme', 'sunset-theme-option');
	add_settings_field('custom-background', 'Custom Background', 'sunset_callback_theme_custom_background', 'avonavi_sunset_theme', 'sunset-theme-option');
}

/*Contact form settings*/
function sunset_settings_contact_form() {
	add_settings_section('sunset-contact-section', 'Contact Form', 'sunset_callback_section_contact_form', 'avonavi_sunset_theme_contact');

	register_setting('sunset_group_contact_form', 'activate');

	add_settings_field('activate-form', 'Activate Contact Form', 'sunset_callback_contact_form_activation', 'avonavi_sunset_theme_contact', 'sunset-contact-section');
}

/*Custom CSS settings*/
function sunset_settings_custom_css() {
	add_settings_section('sunset-custom-css-section', 'Custom CSS', 'sunset_callback_section_custom_css', 'avonavi_sunset_theme_custom_css');

	register_setting('sunset_group_custom_css', 'sunset_option_name_custom_css', 'sunset_sanitize_custom_css');

	add_settings_field('sunset-custom-css-section', 'Insert your own Custom CSS', 'sunset_callback_custom_css', 'avonavi_sunset_theme_custom_css', 'sunset-custom-css-section');
}



/**
 * OPTION callbacks:
 *  sidebar options
 *  theme options
 *  contact form options
 * */

/*sidebar options*/
function sunset_callback_sidebar_profile_picture() {
	$picture = esc_attr(get_option('profile_picture'));
	if ( empty($picture) ) {
		echo '<input class="button button-secondary" type="button" value="Upload pic" id="upload-button">';
		echo '<input id="profile-picture" type="hidden" name="profile_picture" value="">';
	} else {
		echo '<input class="button button-secondary" type="button" value="Replace Profile Picture" id="upload-button">';
		echo '<input id="profile-picture" type="hidden" name="profile_picture" value="'.$picture.'">';
		echo '<input type="button" class="button button-secondary" value="Remove" id="remove-picture">';
	}

}

function sunset_callback_sidebar_name() {
	$firstName = esc_attr(get_option('first_name'));
	$lastName = esc_attr(get_option('last_name'));
	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name">';
	echo '<input type="text" name="last_name" value="'.$lastName.'" placeholder="Last Name">';
}

function sunset_callback_sidebar_description() {
	$description = esc_attr(get_option('user_description'));
	echo '<input type="text" name="user_description" value="'.$description.'" placeholder="user_description"><p>Write something smart</p>';
}

function sunset_callback_sidebar_twitter() {
	$twitter = esc_attr(get_option('twitter_handler'));
	echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter handler">';
	echo '<p class="description">Input your twitter username without "@" character</p>';
}

function sunset_callback_sidebar_facebook() {
	$facebook = esc_attr(get_option('facebook_handler'));
	echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook handler">';
}

function sunset_callback_sidebar_gplus() {
	$gplus = esc_attr(get_option('gplus_handler'));
	echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="GPlus handler">';
}


/*theme options*/
function sunset_callback_theme_post_formats() {
	$options = get_option('post_formats');
	$formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat');
	$output = '';
	foreach ($formats as $format) {
		$checked = ( @$options[$format] == 1 ? 'checked' : '');
		$output .= '<lable><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '. $checked .'>' . $format . '</lable><br>';
	}
	echo $output;
}

function sunset_callback_theme_custom_header() {
	$options = get_option('custom_header');

	$checked = ( @$options == 1 ? 'checked' : '');
	echo '<lable><input type="checkbox" id="custom_header" name="custom_header" value="1" '. $checked .'>Activate Custom Header</lable><br>';

}

function sunset_callback_theme_custom_background() {
	$options = get_option('custom_background');

	$checked = ( @$options == 1 ? 'checked' : '');
	echo '<lable><input type="checkbox" id="custom_background" name="custom_background" value="1" '. $checked .'>Activate Custom Background</lable><br>';

}


/*contact form options*/
function sunset_callback_contact_form_activation() {
	$options = get_option('activate');

	$checked = ( @$options == 1 ? 'checked' : '');
	echo '<lable><input type="checkbox" id="activate" name="activate" value="1" '. $checked .'></lable><br>';
}


/*Custom CSS options*/
function sunset_callback_custom_css() {
	$css = get_option('sunset_option_name_custom_css');

	$css = ( empty($css) ? '/*Sunset Theme Custom CSS*/' : $css);

	?>
	<div id="customCss"><?php echo $css ?></div>
    <textarea name="sunset_option_name_custom_css" id="sunset_option_name_custom_css" hidden><?php echo $css ?></textarea>
	<?php
}



/**
 * SECTION CALLBACKS:
 *  sidebar options
 *  theme options
 *  contact form options
 * */
/*Sidebar settings section*/
function sunset_callback_section_sidebar() {
	echo 'Customize your Sidebar Information';
}

/*Theme settings section*/
function sunset_callback_section_theme() {
	echo 'Activate/deactivate specific Theme Support Options';
}

/*Contact form setting section*/
function sunset_callback_section_contact_form() {
	echo 'Contact Form settings';
}

/*Custom CSS setting section*/
function sunset_callback_section_custom_css() {
	echo 'Customize your theme with your own CSS';
}



/**
 * SANITIZE callbacks:
 *  sidebar options
 *  theme options
 *  contact form options
 * */

/*Sidebar twitter sanitization*/
function sunset_sanitize_sidebar_twitter($input) {
	$output = sanitize_text_field($input);
	return str_replace('@', '', $output);
}

/*Custom CSS sanitization*/
function sunset_sanitize_custom_css($input) {
	$output = esc_textarea($input);
	return str_replace('@', '', $output);
}



























