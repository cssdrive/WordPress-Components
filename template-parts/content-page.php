<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article uk-margin-large-bottom'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title uk-article-title">', '</h1>' ); ?>
	</header>
	
	<?php monopixel_post_thumbnail(); ?>

	<div class="entry-content uk-margin-large-top">
		<?php the_content(); ?>

		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monopixel' ),
			'after'  => '</div>',
		) );?>
	</div>

	<footer class="entry-footer">
		<?php edit_post_link( sprintf( esc_html__( 'Edit %s', 'monopixel' ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ),
			'<span class="edit-link uk-display-block uk-margin-large-top"><span uk-icon="icon: pencil"></span> ', '</span>'
		); ?>
	</footer>
</article>
