<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article uk-margin-large-bottom'); ?>>
	
	<header class="entry-header uk-margin">
		
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta uk-article-meta">
			<?php monopixel_posted_on(); ?>
		</div>
		<?php endif; ?>
		
	</header>
	
	<?php monopixel_post_thumbnail(); ?>

	<?php monopixel_excerpt(); ?>

	<footer class="entry-footer">
		<?php monopixel_entry_footer(); ?>
	</footer>
</article>
