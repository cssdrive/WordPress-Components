<h2 class="uk-margin-small-top"><span uk-icon="icon: album; ratio: 1.5;" style="position: relative; top: -3px;"></span> <?php printf( esc_html_e( 'Output of Scheduled Records', 'monopixel' ) ); ?></h2>

<?php query_posts('ignore_sticky_posts=1&post_status=future&order=DESC&posts_per_page=3'); //Значения (-9) отключают категорию (9) добавляют; C начала order=ASC; с конца order=DESC; ignore_sticky_posts=1 Отключает вывод рекомендуемых постов; ?>
	<?php if ( have_posts() ) : ?>
		<ul class="uk-grid-small uk-child-width-1-3@m" uk-grid>
			<?php while ( have_posts() ) : the_post(); ?>
				<li id="post-<?php the_ID(); ?>" <?php post_class(""); ?>>
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium uk-width-1-1'); } ?>
					<h3 class="uk-h4 uk-link-reset uk-margin-small"><?php the_title(); ?></h3>
					
					<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta uk-article-meta">
							<?php monopixel_posted_future(); ?>
						</div>
					<?php endif; ?>
	            </li>
			<?php endwhile; ?>
		</ul>
		<?php else : ?>
		<?php printf( esc_html_e( 'No Future Posts!', 'monopixel' ) ); ?>
	<?php endif; ?>
<?php wp_reset_query(); ?>
