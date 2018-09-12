<?php

// если вы вставляете код не в новый файл, то <?php нужно удалить
function true_add_ajax_comment(){
	global $wpdb;
	$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

	$post = get_post($comment_post_ID);

	if ( empty($post->comment_status) ) {
		do_action('comment_id_not_found', $comment_post_ID);
		exit;
	}

	$status = get_post_status($post);

	$status_obj = get_post_status_object($status);

	/*
	 * различные проверки комментария
	 */
	if ( !comments_open($comment_post_ID) ) {
		do_action('comment_closed', $comment_post_ID);
		wp_die( esc_html__('Sorry, comments are closed for this item.', 'monopixel') );
	} elseif ( 'trash' == $status ) {
		do_action('comment_on_trash', $comment_post_ID);
		exit;
	} elseif ( !$status_obj->public && !$status_obj->private ) {
		do_action('comment_on_draft', $comment_post_ID);
		exit;
	} elseif ( post_password_required($comment_post_ID) ) {
		do_action('comment_on_password_protected', $comment_post_ID);
		exit;
	} else {
		do_action('pre_comment_on_post', $comment_post_ID);
	}

	$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
	$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
	$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
	$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;

	/*
	 * проверяем, залогинен ли пользователь
	 */
	$user = wp_get_current_user();
	if ( $user->exists() ) {
		if ( empty( $user->display_name ) )
			$user->display_name=$user->user_login;
		$comment_author       = $wpdb->escape($user->display_name);
		$comment_author_email = $wpdb->escape($user->user_email);
		$comment_author_url   = $wpdb->escape($user->user_url);
		$user_ID = get_current_user_id();
		if ( current_user_can('unfiltered_html') ) {
			if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
				kses_remove_filters(); // start with a clean slate
				kses_init_filters(); // set up the filters
			}
		}
	} else {
		if ( get_option('comment_registration') || 'private' == $status )
			wp_die(  esc_html__('You must be registered or logged in to post a comment.', 'monopixel') );
	}

	$comment_type = '';

	/*
	 * проверяем, заполнил ли пользователь все необходимые поля
 	 */
	if ( get_option('require_name_email') && !$user->exists() ) {
		if ( 6 > strlen($comment_author_email) || '' == $comment_author )
			wp_die( esc_html__( 'Error: fill in the required fields (Name, Email).', 'monopixel' ) );
		elseif ( !is_email($comment_author_email))
			wp_die( esc_html__( 'Error: the email you entered is incorrect.', 'monopixel' ) );
	}

	if ( '' == trim($comment_content) ||  '<p><br></p>' == $comment_content )
		wp_die( esc_html__( 'You forgot about the comment.', 'monopixel' ) );

	/*
	 * добавляем новый коммент и сразу же обращаемся к нему
	 */
	$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
	$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
	$comment_id = wp_new_comment( $commentdata );
	$comment = get_comment($comment_id);

	/*
	 * выставляем кукисы
	 */
	do_action('set_comment_cookies', $comment, $user);

	/*
	 * вложенность комментариев
	 */
	$comment_depth = 1;
	while($comment_parent){
		$comment_depth++;
		$parent_comment = get_comment($comment_parent);
		$comment_parent = $parent_comment->comment_parent;
	}

	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $comment_depth;
	/*
	 * ниже идет шаблон нового комментария, вы можете настроить его для себя,
	 * а можете воспользоваться функцией(которая скорее всего уже есть в теме) для его вывода
	 */
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 45 ); ?>
				<cite class="fn"><?php echo get_comment_author_link(); ?></cite>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Comment Submitted for Review', 'monopixel' ); ?></em>
				<br />
			<?php endif; ?>
			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php printf( esc_html__( '%1$s at %2$s', 'monopixel' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( 'Edit', 'monopixel' ), ' ' );	?>
			</div>
			<div class="comment-body"><?php comment_text(); ?></div>
		</div>
	</li>
	<?php
	die();
}

add_action('wp_ajax_ajaxcomments', 'true_add_ajax_comment'); // wp_ajax_{значение параметра action}
add_action('wp_ajax_nopriv_ajaxcomments', 'true_add_ajax_comment'); // wp_ajax_nopriv_{значение параметра action}
/*
 * Меняем местами input и textarea
 */
function wpb_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );
