<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article'); ?>>
	<header class="entry-header uk-margin">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta uk-article-meta">
			<?php monopixel_posted_on(); ?>
		</div>
		<?php endif; ?>
	</header>
	
	<?php monopixel_post_thumbnail(); ?>
	
	<div class="uk-margin">
		<a class="uk-button uk-button-default" href="<?php the_permalink(); ?>" aria-hidden="true"><span class="uk-visible@s uk-margin-small-right"><?php esc_html_e( 'Learn More', 'monopixel' ); ?></span> <span style="top: -1px; position: relative;" uk-icon="icon: arrow-right; ratio: 1.2;"></span></a>
		<button class="ajax-post uk-button uk-button-default" data-id-post="<?php the_ID(); ?>" uk-toggle="#content-preview"><span class="uk-visible@s uk-margin-small-right"><?php esc_html_e( 'Previw', 'monopixel' ); ?></span> <span style="top: -2px; position: relative;" uk-icon="icon: move;"></span></button>
	</div>

	<?php monopixel_excerpt(); ?>

	<footer class="entry-footer">
		<?php monopixel_entry_footer(); ?>
	</footer>
</article>

<hr class="uk-hr">