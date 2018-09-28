<?php
/**
 * Check if user is logged in and is post author
 * Setup functions for front end post editing
 * @author Mike Hemberger
 * @link http://thestizmedia.com/front-end-post-editing-with-acf-pro/
 * @uses Advanced Custom Fields Pro
 * @uses Sidr
 */
add_action( 'get_header', 'tsm_do_logged_in_author_checks' );
function tsm_do_logged_in_author_checks() {
	// Get current user info
	global $post,$current_user;
	get_currentuserinfo();
	// Bail if user is not logged in and not post author
	if ( ! ( is_user_logged_in() && $current_user->ID == $post->post_author ) ) {
		return;
	}
	/**
	 * Enqueue Javascript files
	 * @uses Sidr
	 */
	add_action( 'wp_enqueue_scripts', 'tsm_acf_form_edit_post_enqueue_scripts' );
	/**
	 * Add required acf_form_head() function to head of page
	 * @uses Advanced Custom Fields Pro
	 */
	add_action( 'get_header', 'tsm_do_acf_form_head', 1 );
	/**
	 * Deregister the admin styles outputted when using acf_form
	 */
	add_action( 'wp_print_styles', 'tsm_deregister_admin_styles', 999 );
	/**
	 * Add edit post toggle button
	 */
	add_action( 'genesis_entry_header', 'tsm_do_acf_form_edit_toggle', 5 );
	/**
	 * Add the acf_form
	 * @uses Advanced Custom Fields Pro
	 */
	add_action( 'genesis_after', 'tsm_do_acf_form_content' );
	/**
	 * Load existing post title
	 * @uses Advanced Custom Fields Pro
	 */
	add_filter( 'acf/load_value/key=field_54dfc93e35ec4', 'tsm_load_post_title', 10, 3 );
	/**
	 * Load existing post content
	 * @uses Advanced Custom Fields Pro
	 */
	add_filter( 'acf/load_value/key=field_54dfc94e35ec5', 'tsm_load_post_content', 10, 3 );
	/**
	 * Load existing post thumbnail
	 * @uses Advanced Custom Fields Pro
	 */
	add_filter( 'acf/load_value/key=field_54dfcd4278d63', 'tsm_load_post_thumbnail', 10, 3 );
	/**
	 * Update existing post data
	 * @uses Advanced Custom Fields Pro
	 */
	add_action( 'acf/save_post', 'tsm_update_existing_post_data', 10 );
	// acf/update_value/name={$field_name} - filter for a specific field based on it's key
}
function tsm_acf_form_edit_post_enqueue_scripts() {
	wp_enqueue_script( 'sidr',  get_stylesheet_directory_uri() . '/assets/js/jquery.sidr.min.js', array( 'jquery' ), '1.2.1', true );
	wp_enqueue_script( 'edit-post', get_stylesheet_directory_uri() . '/assets/js/edit-post.js', array( 'sidr' ), '1.0.0', true );
}
function tsm_do_acf_form_head() {
	acf_form_head();
}
function tsm_deregister_admin_styles() {
	wp_deregister_style( 'wp-admin' );
}
function tsm_do_acf_form_edit_toggle() {
?>
	<button id="edit-toggle">Edit</button>
<?php
}
function tsm_do_acf_form_content() {
?>
	<div id="edit-post" style="display:none;">

    	<?php
		$edit_post = array(
			'post_id'            => get_the_ID(), // Get the post ID
			'field_groups'       => array(7,58), // Create post field group ID(s)
			'form'               => true,
			'return'             => '%post_url%',
			'html_before_fields' => '<div class="edit-close-wrap"><button class="edit-close" role="button" aria-pressed="false"><i class="fa fa-times"></i> Close</button></div>',
			'html_after_fields'  => '',
			'submit_value'       => 'Save Changes',
		);
		acf_form( $edit_post );
		?>

	</div>
<?php
}
function tsm_load_post_title( $value, $post_id, $field ) {
    $value = get_the_title($post_id);
    return $value;
}
function tsm_load_post_content( $value, $post_id, $field ) {
    $value = get_the_content($post_id);
    return $value;
}
function tsm_load_post_thumbnail( $value, $post_id, $field ) {
    $value = get_post_thumbnail_id($post_id);
    return $value;
}
function tsm_update_existing_post_data( $post_id ) {
	// Update existing post
	$post = array(
		'ID'           => $post_id,
		'post_status'  => 'publish',
		'post_title'   => wp_strip_all_tags($_POST['acf']['field_54dfc93e35ec4']), // Post Title ACF field key
		'post_content' => $_POST['acf']['field_54dfc94e35ec5'], // Post Content ACF field key
	);
	// Update the post
	$post_id = wp_insert_post( $post );
	// ACF image field key
	$image   = $_POST['acf']['field_54dfcd4278d63'];
	// Add the value which is the image ID to the _thumbnail_id meta data for the current post
	update_post_meta( $post_id, '_thumbnail_id', $image );
}
/**
 * OPTIONAL CODE - Display our repeater rows in the entry content
 */
add_action( 'genesis_entry_content', 'tsm_do_single_post_featured_image', 1 );
function tsm_do_single_post_featured_image() {
	$rows = get_field('tsm_repeater');
	if( $rows ) {
		echo '<h3>Repeater field values</h3>';
		echo '<ul>';
		foreach($rows as $row) {
			echo '<li>' . $row['tsm_repeater_field'] . '</li>';
		}
		echo '</ul>';
	}
}
//* Do the Genesis magic
genesis();
