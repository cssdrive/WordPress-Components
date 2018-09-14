<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article uk-margin-large-bottom'); ?>>
	

	<header class="entry-header uk-margin">
		
		<h1 class="entry-title uk-article-title"><span class="uk-badge"><?php printf( esc_html_e( 'Aside', 'monopixel' ) ); ?></span> <?php the_title( sprintf( '<a class="uk-link-reset" href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?></h1>
		 
        <div class="entry-meta uk-article-meta">
			<?php monopixel_posted_on(); ?>
		</div>
		
    </header>
	
	<?php monopixel_post_thumbnail(); ?>
	
	<div class="uk-margin">
		<a class="uk-button uk-button-default" href="<?php the_permalink(); ?>" aria-hidden="true"><span class="uk-visible@s uk-margin-small-right"><?php esc_html_e( 'Learn More', 'monopixel' ); ?></span> <span style="top: -1px; position: relative;" uk-icon="icon: arrow-right; ratio: 1.2;"></span></a>
		<button class="ajax-post uk-button uk-button-default" data-id-post="<?php the_ID(); ?>" uk-toggle="#content-preview"><span class="uk-visible@s uk-margin-small-right"><?php esc_html_e( 'Previw', 'monopixel' ); ?></span> <span style="top: -2px; position: relative;" uk-icon="icon: move;"></span></button>
	</div>
	
	<?php monopixel_excerpt(); ?>

	<div class="entry-content uk-margin">
		<?php the_content(); ?>

		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monopixel' ),
			'after'  => '</div>',
		) ); ?>
	</div>

	<footer class="entry-footer">
		<?php monopixel_entry_footer(); ?>
	</footer>
</article>
