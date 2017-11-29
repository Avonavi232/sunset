<?php
/**
 * Created by PhpStorm.
 * User: ALEX
 * Date: 19.11.2017
 * Time: 18:55
 */


$contact = get_option('activate');

if ( @$contact == 1 ) {
	add_action('init', 'sunset_cpt_contact');


	/*Динамический хук для создания новых или редактирования старых колонок на странице CPT в админке*/
	add_filter( 'manage_cfmessages_posts_columns', 'sunset_cpt_contacts_manage_columns' );
	function sunset_cpt_contacts_manage_columns( ) {
		$new_columns = array();
		$new_columns['title'] = 'Full Name';
		$new_columns['message'] = 'Message';
		$new_columns['email'] = 'Email';
		$new_columns['date'] = 'Date';
		return $new_columns;
	}


	/*Функция нужна для наполнения созданных колонок нужной нам инфой*/
	add_action( 'manage_cfmessages_posts_custom_column', 'sunset_cpt_contacts_manage_custom_column', 10, 2 );
	function sunset_cpt_contacts_manage_custom_column( $column, $post_id ) {
		switch ( $column ) {
			case 'message' :
				echo get_the_excerpt();
				break;
			case 'email' :
				$email = get_post_meta($post_id, 'contact_email', true);
				?>
				<a href="mailto:<?php echo $email ?>"><?php echo $email ?></a>
				<?php
				break;
			case 'title' :
				//title column
				break;
			case 'date' :
				//date column
				break;

		}
	}


	/*Добавляем метабокс*/
	add_action('add_meta_boxes', 'sunset_cpt_contacts_metabox');

	/*Хук для сохранения данных метабокса*/
	add_action( 'save_post', 'sunset_cpt_contacts_metabox_save' );

}

/*Contact CPT*/
function sunset_cpt_contact() {
	$labels = array(
		'name'            =>  'Messages',
		'singular_name'   =>  'Message',
		'menu_name'       =>  'Messages',
		'name_admin_bar'  =>  'Message'
	);
	$args = array(
		'labels'          =>  $labels,
		'show_ui'         =>  true,
		'show_in_menu'    =>  true,
		'capability_type' =>  'post',
		'hierarchical'    =>  false,
		'menu_position'   =>  26,
		'menu_icon'       =>  'dashicons-email-alt',
		'supports'        =>  array('title', 'editor', 'author')
	);

	register_post_type('cfmessages', $args);
}


/*Metaboxes for Contact CPT*/
function sunset_cpt_contacts_metabox() {
	add_meta_box('contact_email', 'User Email', 'sunset_cpt_contacts_metabox_render', 'cfmessages', 'side');
}

function sunset_cpt_contacts_metabox_render( $post ) {
	wp_nonce_field('sunset_cpt_contacts_metabox_save', 'sunset_contact_metabox_nonce');

	$value = get_post_meta($post->ID, 'contact_email', true);
	?>
	<label for="sunset_contact_email_field">User Email Address: </label>
	<input type="email" id="sunset_contact_email_field" name="sunset_contact_email_field" value="<?php echo esc_attr($value) ?>" size="25">
	<?php
}

function sunset_cpt_contacts_metabox_save( $post_id ) {
	if ( !isset( $_POST['sunset_contact_metabox_nonce'] ) ) {
		return;
	}
	if ( !wp_verify_nonce($_POST['sunset_contact_metabox_nonce'], 'sunset_cpt_contacts_metabox_save') ) {
		return;
	}
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return;
	}
	if ( !current_user_can('edit_post', $post_id) ) {
		return;
	}
	if ( !isset($_POST['sunset_contact_email_field']) ) {
		return;
	}
	$data = sanitize_text_field( $_POST['sunset_contact_email_field'] );
	update_post_meta( $post_id, 'contact_email', $data );
}






















