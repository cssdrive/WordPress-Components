<?php if ( post_password_required() ) { return; } ?>

<div id="comments" class="comments-area uk-margin">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title uk-margin-large uk-text-center">
			<?php $comments_number = get_comments_number(); if ( '1' === $comments_number ) {
				printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'monopixel' ), get_the_title() );
			} else {
				printf(
					_nx(
						'%1$s Reply to &ldquo;%2$s&rdquo;',
						'%1$s Replies to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'monopixel'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
			?>
		</h2>

		<ul class="comment-list uk-comment-list">
			<?php wp_list_comments( array(
				'avatar_size' => 45,
				'style'       => 'ul',
				'short_ping'  => true,
				'reply_text'  => '<span uk-icon="icon: reply"></span> ' . esc_html__( 'Reply', 'monopixel' ),
			) ); ?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'monopixel' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'monopixel' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'monopixel' ) ); ?></div>

			</div>
		</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'monopixel' ); ?></p>
	<?php endif; ?>

	<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(
		    'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'monopixel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		        '<input class="uk-input" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		    'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'monopixel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		        '<input class="uk-input" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		    'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'monopixel' ) . '</label>' .
		        '<input class="uk-input" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
		);

		$comments_args = array(
		    'fields'       => $fields,
		    'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'monopixel' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) . '<textarea class="uk-textarea" id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p>',
		    'title_reply'  => esc_html__( 'Please give us your valuable comment', 'monopixel' ),
		    'label_submit' => esc_html__( 'Send My Comment', 'monopixel' ),
		);

		comment_form($comments_args);
	?>
</div>
