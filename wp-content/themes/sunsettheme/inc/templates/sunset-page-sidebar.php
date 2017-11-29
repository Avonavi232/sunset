<?php
/**
 * Created by PhpStorm.
 * User: ALEX
 * Date: 12.11.2017
 * Time: 18:57
 */
?>
<h1>Sunset Sidebar Options</h1>
<?php settings_errors();?>

<?php
$profile_pic = esc_attr(get_option('profile_picture'));
$firstname = esc_attr(get_option('first_name'));
$lastname = esc_attr(get_option('last_name'));
$descr = esc_attr(get_option('user_description'));
$fullName = $firstname . ' ' . $lastname;
?>

<div class="sunset-sidebar-preview">
    <div class="sunset-sidebar">
        <div class="image-container">
            <div class="profile-picture">
                <img src="<?php echo $profile_pic?>" alt="">
            </div>
        </div>
        <h1 class="sunset-username"><?php echo $fullName ?></h1>
        <h2 class="sunset-description"><?php echo $descr?></h2>
        <div class="icons-wrapper">

        </div>
    </div>
</div>

<form class="sunset-general-form" action="options.php" method="post">
	<?php
	settings_fields('sunset-settings-group');
	do_settings_sections('avonavi_sunset');
	submit_button('Save Changes', 'primary', 'btnSubmit');
	?>
</form>
