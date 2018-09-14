<article id="post-<?php the_ID(); ?>" <?php post_class('mp-single uk-article'); ?>>
	
	<div class="mp-single-about uk-border-rounded uk-overflow-hidden">
		<div class="uk-inline uk-light">
			
			 <div class="uk-overlay-primary uk-position-cover uk-overlay-custom"></div>
		    
		    <?php if ( get_field( 'single_header_images' ) ) { ?>
		    	<img src="<?php the_field( 'single_header_images' ); ?>" alt=" <?php the_title(); ?>">
				<?php } else { ?>
				<img src="<?php echo get_template_directory_uri() ?>/assets/img/single-header-no-images.jpg" alt="">
		    <?php } ?>
		    
		    <div class="uk-position-medium uk-position-top-left sinle-tags">
			    <?php monopixel_entry_tags(); ?>
		    </div>
		    
		    <div class="uk-position-medium uk-position-bottom-left">
			    <?php the_title( '<h1 class="entry-title mp-single-title uk-article-title">', '</h1>' ); ?>
			    <div class="uk-margin-bottom"><?php monopixel_excerpt(); ?></div>
			    <ul class="uk-grid-small uk-text-bold uk-text-white uk-text-small" uk-grid>
			    	<li><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo get_template_directory_uri() ?>/assets/img/icon/visible.svg);"></span> <?php echo get_post_meta ($post->ID,'views',true); ?></li>
			    	<li><a class="uk-link-reset" href="<?php the_permalink() ?>#comments"><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo get_template_directory_uri() ?>/assets/img/icon/sms.svg);"></span> <?php comments_number('0', '1', '%'); ?></a></li>
		    	</ul>
		    </div>
		    
		</div>
	
		<section class="uk-section-default uk-padding">
			<ul class="" uk-grid>
				
				<li class="uk-width-expand@m">
					
					<!--
					<header class="entry-header uk-margin">
						<div class="entry-meta uk-article-meta"><?php monopixel_posted_on(); ?></div>
					</header>
					-->
				
					<h3><?php printf( esc_html__( 'Об игре:', 'monopixel' ) ); ?></h3>
					<?php the_content(); ?>
					
					<!-- Об игре -->
					
					<div class="uk-margin-medium">
						<ul class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-medium" uk-grid>
							<li>
								<h4>Дата выхода:</h4>
								<p>1990 г.</p>
							</li>
							<li>
								<h4>Платформа:</h4>
								<p>Nintendo Entertainment System</p>
							</li>
							<li>
								<h4>Жанр:</h4>
								<p>Платформер</p>
							</li>
							<li>
								<h4>Режимы:</h4>
								<p>Однопользовательская игра,<br>Кооперативная игра</p>
							</li>
							<li>
								<h4>Разработчики:</h4>
								<p>Capcom,<br>Rare</p>
							</li>
							<li>
								<h4>Издатель:</h4>
								<p>Capcom,<br>American Technos Inc.,<br>Sunsoft</p>
							</li>
							<li>
								<h4>Носитель:</h4>
								<p>Картридж</p>
							</li>
							<li>
								<h4>Музыка:</h4>
								<p>Харуми Фуджита</p>
							</li>
							<li>
								<h4>Художники:</h4>
								<p>Кейдзи Инафунэ</p>
							</li>
						</ul>
					</div>
					
					<!-- Скриншоты -->
					<div class="uk-margin">
						
						
					</div>
				</li>
				
				<li class="uk-width-1-5@m">
					<div class="uk-margin uk-widht-1-1 uk-text-center">
						<?php if ( has_post_thumbnail() ) { the_post_thumbnail('post-thumbnail', ['class' => 'uk-width-1-1 uk-border-rounded']); } ?>
					</div>
					<div class="uk-margin">
						<a class="download-button uk-button uk-button-large uk-button-primary uk-border-rounded uk-width-1-1" href="#" target="_blank">Скачать 1.75 MB</a>
					</div>
				</li>
			</ul>
		</section>
	</div><!-- .about -->

	<div class="entry-content">

		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'monopixel' ),
			'after'  => '</div>',
		) ); ?>
	</div>
</article>
