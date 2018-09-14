<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article thumbs-games'); ?>>	
<div class="thumb-item uk-border-rounded uk-overflow-hidden uk-card-hover">
			    
    <div class="uk-position-relative uk-transition-toggle">
    
    	<div class="uk-card uk-card-default">
	    	
	    	<div class="uk-card-header uk-text-center">
		    	Nintendo (nes) 
	    	</div>
	    	
	    	<div class="uk-card-media uk-text-center">
		    	<div class="uk-padding uk-padding-remove-vertical">
		    		<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail', ['class' => 'uk-border-circle']); } ?>
		    	</div>
	    	</div>
	    	
	    	<div class="uk-card-body">
	    		<?php the_title( '<h2 class="uk-card-title uk-text-center"><a class="uk-link-reset" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	    	</div>
	   
    	</div>
    	
    	<div class="uk-card-footer uk-tile uk-tile-default">
	    	<ul class="uk-grid-small uk-flex uk-flex-center" uk-grid>
		    	<li><span class="uk-icon uk-icon-image" style="background-image: url(http://dev.monopixel.ru/assets/icon/eye_black.svg);"></span> <?php echo get_post_meta ($post->ID,'views',true); ?></li>
		    	<li><?php// monopixel_comments(); ?><span class="uk-icon uk-icon-image" style="background-image: url(http://dev.monopixel.ru/assets/icon/comments_black.svg);"></span> <?php comments_number('0', '1', '%'); ?></li>
	    	</ul>
    	</div>
	
		<div class="uk-transition-fade uk-hidden uk-position-cover uk-overlay uk-overlay-primary uk-text-center">
			<div class="uk-position-center">
				<h1 class="uk-card-title uk-text-center">Chip&nbsp;'n&nbsp;Dale<br>Rescue Rangers</h1>
				<p class="uk-text-small text-white">Компьютерная игра 1993 года, основанная на одноимённом мультипликационном фильме</p>
				<div class="uk-margin">
					<a class="uk-button uk-button-default uk-border-rounded" href="#">Подробнее</a>
				</div>
			</div>
		</div> 
	 
	</div><!-- .uk-position-relative -->
	
</div><!-- .uk-border-rounded -->
</article>






<article id="post-<?php the_ID(); ?>" <?php post_class('uk-article uk-hidden'); ?>>	
	<header class="entry-header uk-margin">
		<?php the_title( '<h2 class="entry-title"><a class="uk-link-reset" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta uk-article-meta">
				<?php monopixel_posted_on(); ?>
			</div>
		<?php endif; ?>
	</header>
	
	<div class="uk-card">
		<?php if ( is_sticky() && is_home() ) : ?>
			<span class="sticky-post uk-card-badge uk-label"><?php esc_html_e( 'Featured' , 'monopixel'); ?></span>
		<?php endif; ?>
	    <div class="uk-card-media-top"><?php monopixel_post_thumbnail(); ?></div>
	</div>
	
	<div class="uk-margin">
		<a class="uk-button uk-button-default" href="<?php the_permalink(); ?>" aria-hidden="true"><span class="uk-visible@s uk-margin-small-right"><?php esc_html_e( 'Learn More', 'monopixel' ); ?></span> <span style="top: -1px; position: relative;" uk-icon="icon: arrow-right; ratio: 1.2;"></span></a>
		
		<button class="ajax-post uk-button uk-button-default" data-id-post="<?php the_ID(); ?>" uk-toggle="#content-preview"><span class="uk-visible@s uk-margin-small-right"><?php esc_html_e( 'Previw', 'monopixel' ); ?></span> <span style="top: -2px; position: relative;" uk-icon="icon: move;"></span></button>
	</div>
	
	<?php monopixel_excerpt(); ?>

	<div class="entry-content uk-margin">
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monopixel' ),
			'after'  => '</div>',
		) ); ?>
	</div>

	<footer class="entry-footer">
		<?php monopixel_entry_footer(); ?>
	</footer>
</article>