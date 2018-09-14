<div id="post-<?php the_ID(); ?>">	
	<div class="uk-modal-header">
		<?php the_title( '<h2 class="uk-modal-title">', '</h2>' ); ?>
	</div>
	
	<div class="uk-modal-body">
		<?php the_post_thumbnail('post-thumbnail'); ?>
		<?php monopixel_excerpt(); ?>
		<?php the_content( sprintf( 
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'monopixel' ), array( 'span' => array( 'class' => array() ) ) ), the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) ); ?>
	</div>
	
	<div class="uk-modal-footer">
		<a class="uk-button uk-button-primary" href="<?php the_permalink(); ?>" aria-hidden="true"><?php esc_html_e( 'Learn More', 'monopixel' ); ?></a>
	</div>
</div>