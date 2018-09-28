<?php
/**
 * Template Name: Create Post
 *
 * @author Mike Hemberger
 * @link http://thestizmedia.com/front-end-posting-with-acf-pro/
 * @uses Advanced Custom Fields Pro
 */
/**
 * Add required acf_form_head() function to head of page
 * @uses Advanced Custom Fields Pro
 */
add_action( 'get_header', 'tsm_do_acf_form_head', 1 );
function tsm_do_acf_form_head() {
	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}
	acf_form_head();
}
/**
 * Deregister the admin styles outputted when using acf_form
 */
add_action( 'wp_print_styles', 'tsm_deregister_admin_styles', 999 );
function tsm_deregister_admin_styles() {
	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}
	wp_deregister_style( 'wp-admin' );
}
/**
 * Add ACF form for front end posting
 * @uses Advanced Custom Fields Pro
 */
add_action( 'genesis_entry_content', 'tsm_do_create_post_form' );
function tsm_do_create_post_form() {
	// Bail if not logged in or able to post
	if ( ! ( is_user_logged_in()|| current_user_can('publish_posts') ) ) {
		echo '<p>You must be a registered author to post.</p>';
		return;
	}
	$new_post = array(
		'post_id'            => 'new_post', // Create a new post
		// PUT IN YOUR OWN FIELD GROUP ID(s)
		'field_groups'       => array(7,58), // Create post field group ID(s)
		'form'               => true,
		'return'             => '%post_url%', // Redirect to new post url
		'html_before_fields' => '',
		'html_after_fields'  => '',
		'submit_value'       => 'Submit Post',
		'updated_message'    => 'Saved!'
	);
	acf_form( $new_post );
}
/**
 * Back-end creation of new candidate post
 * @uses Advanced Custom Fields Pro
 */
add_filter('acf/pre_save_post' , 'tsm_do_pre_save_post' );
function tsm_do_pre_save_post( $post_id ) {
	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}
	// check if this is to be a new post
	if( $post_id != 'new_post' ) {
		return $post_id;
	}
	// Create a new post
	$post = array(
		'post_type'     => 'post', // Your post type ( post, page, custom post type )
		'post_status'   => 'publish', // (publish, draft, private, etc.)
		'post_title'    => wp_strip_all_tags($_POST['acf']['field_54dfc93e35ec4']), // Post Title ACF field key
		'post_content'  => $_POST['acf']['field_54dfc94e35ec5'], // Post Content ACF field key
	);
	// insert the post
	$post_id = wp_insert_post( $post );
	// Save the fields to the post
	do_action( 'acf/save_post' , $post_id );
	return $post_id;
}
/**
 * Save ACF image field to post Featured Image
 * @uses Advanced Custom Fields Pro
 */
add_action( 'acf/save_post', 'tsm_save_image_field_to_featured_image', 10 );
function tsm_save_image_field_to_featured_image( $post_id ) {
	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}
	// Bail early if no ACF data
	if( empty($_POST['acf']) ) {
		return;
	}
	// ACF image field key
	$image = $_POST['acf']['field_54dfcd4278d63'];
	// Bail if image field is empty
	if ( empty($image) ) {
		return;
	}
	// Add the value which is the image ID to the _thumbnail_id meta data for the current post
	add_post_meta( $post_id, '_thumbnail_id', $image );
}
// acf/update_value/name={$field_name} - filter for a specific field based on it's key
// Run the Genesis loop
genesis();
