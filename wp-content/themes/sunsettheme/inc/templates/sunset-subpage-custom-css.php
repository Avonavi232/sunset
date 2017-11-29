<?php
/**
 * Created by PhpStorm.
 * User: ALEX
 * Date: 12.11.2017
 * Time: 18:57
 */
?>
<h1>Sunset Custom CSS</h1>
<?php settings_errors();?>


<form id="save-custom-css-form" action="options.php" method="post">
	<?php
	settings_fields('sunset_group_custom_css');
	do_settings_sections('avonavi_sunset_theme_custom_css');
	submit_button('Save Changes', 'primary', 'btnSubmit');
	?>
</form>
