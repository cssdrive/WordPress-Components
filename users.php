<?php
/*
Template Name: User Page
*/

get_header(); ?>

	<div class="uk-section uk-section-small uk-section-muted">
		<div id="content" class="uk-container uk-container-large" role="main">
			
		<h1 class="uk-heading">Наши авторы</h1>

		<?php		
			$number 	= 9; 
			$paged 		= (get_query_var('paged')) ? get_query_var('paged') : 1;
			$offset 	= ($paged - 1) * $number;
			$users 		= get_users();
			$query 		= get_users('&offset='.$offset.'&number='.$number);
			$total_users = count($users);
			$total_query = count($query);
			$total_pages = intval($total_users / $number) + 1;

			echo '<ul id="users" class="uk-child-width-1-2@m uk-grid-medium uk-grid-match" uk-grid>';
		?>
			
			<li>
				<div class="uk-card uk-card-primary uk-card-body">
				  <h3 class="uk-card-title">Вы тоже можете стать автором!</h3>
				  <p>Хотите писать для нас про мобильную аналитику? Заведите блог на «GetMobian». Лучшие тексты блогеров попадут в наши соцсети и на главную страницу.</p>
				  <div class="uk-margin-medium-top">
					  <a class="uk-button uk-button-primary uk-margin-small-bottom" href="#">Создать блог</a>
					  <a class="uk-button uk-button-default uk-margin-small-bottom" href="#">Добавить запись</a>
				  </div>
				</div>
			</li>
			
			<?php foreach($query as $q) { ?>
			
				<li>
					<div class="uk-card uk-card-default uk-grid-collapse uk-margin" uk-grid>
				    <div class="uk-flex-last@m uk-card-media-right uk-card-body  uk-width-auto@m">
			        <?php echo get_avatar( $q->ID, 80, '', '', array('class'=>'uk-border-circle', 'extra_attr'=>'') ); ?>	
				    </div>
				    <div class="uk-card-body uk-width-expand@m">
			        <div class="">
		            <h4 class="uk-card-title">
									<a class="uk-link-reset" href="<?php echo get_author_posts_url($q->ID);?>">
										<?php echo get_the_author_meta('display_name', $q->ID);?>
									</a>
								</h4>
	
								<?php if (get_the_author_meta('description', $q->ID) != '') : ?>
									<p><?php echo get_the_author_meta('description', $q->ID); ?></p>
								<?php endif; ?>
			        </div>
				    </div>
					</div>
				</li>
							
			<?php } 

			echo '</ul>';

			?>

			<?php
				if ($total_users > $total_query) {
					echo '<div id="pagination" class="uk-margin-large-top">';
					  $current_page = max(1, get_query_var('paged'));
					  echo paginate_links(array(
							'base' => get_pagenum_link(1) . '%_%',
							'format' => 'page/%#%/',
							'current' => $current_page,
							'total' => $total_pages,
							'prev_next'    => false,
							'type'         => 'list',
					    ));
					echo '</div>';
				}
			?>
		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>
