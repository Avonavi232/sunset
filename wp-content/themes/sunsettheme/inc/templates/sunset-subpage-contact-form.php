<?php
/**
 * Created by PhpStorm.
 * User: ALEX
 * Date: 12.11.2017
 * Time: 18:57
 */
?>
<h1>Sunset Contact Form</h1>
<?php settings_errors();?>

<?php
//$profile_pic = esc_attr(get_option('profile_picture'));
?>

<form action="options.php" method="post">
	<?php
	settings_fields('sunset_group_contact_form');
	do_settings_sections('avonavi_sunset_theme_contact');
	submit_button('Save Changes', 'primary', 'btnSubmit');
	?>
</form>
