<!-- Вывод названия категории через кнопку -->

<?php $categories = get_the_category(); if($categories){ foreach($categories as $category) {
  $out .= '<a class="uk-button uk-button-default uk-border-rounded" href="'.get_category_link($category->term_id ).'">' . $category->name . '</a> ';
} echo trim($out, ', '); } ?>

<!-- Отображение похожих записей -->
<?php
  $tags = wp_get_post_tags($post->ID);
  if ($tags) {
    $tag_ids = array();
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
    $args=array(
    'tag__in' => $tag_ids,
    'post__not_in' => array($post->ID),
    'showposts'=>5, // Number of related posts that will be shown.
    'caller_get_posts'=>1
  );
  $my_query = new wp_query($args);
    if( $my_query->have_posts() ) {
      echo '<h3>Related Posts</h3><ul class="uk-list">';
      while ($my_query->have_posts()) { $my_query->the_post(); ?>
        <li>
          <!-- Сюда выводится контент цикла поста -->
        </li>
    <?php } echo '</ul>'; }
  }
?>

<!-- Вывод контента через цикл -->

<?php while ( have_posts() ) : the_post(); ?>	
  <article id="post-<?php the_ID(); ?>" <?php post_class('uk-article'); ?>>
    <?php the_content(); ?>	
  </article>
<?php endwhile;?>

<!-- Вывод заголовка -->

<?php if ( is_home() && ! is_front_page() ) : ?>
	<h1><?php single_post_title(); ?></h1>
<?php endif; ?>

<!-- Вывод информации о посте -->

<ul class="uk-article-meta uk-list uk-list-divider">
	<li>Дата создания: <?php the_date(); ?> в <?php the_time(); ?></li>
	<li>Последнее изменение: <?php the_modified_date(); ?> в <?php the_modified_time(); ?></li>
	<li>Категория: <?php printf(__('%s', 'thefubon'), get_the_category_list(', ')); ?></li>
	<li><?php the_tags(__('Метки: ', 'thefubon') . '', ', ', ''); ?></li>
	<li>Комментариев: <a href="<?php the_permalink() ?>#comments"> <?php comments_number('0', '1', '%'); ?></a></li>
	<li><?php edit_post_link('Измениь пост','',''); ?></li>
</ul>

<?php the_category(' > ', 'single'); ?>

<!-- Переход по страницас -->

<?php if ( get_the_post_navigation( 'post-navigation' ) ) : ?>
	<?php get_template_part( 'template-parts/content', 'navigation' ); ?>
<?php endif; ?>

<!-- Внутринности страницы /template-parts/content-navigation.php -->

<div class="navigation post-navigation uk-section uk-section-small uk-section-muted uk-margin uk-border-rounded"  role="navigation">
	<div class="uk-padding uk-padding-remove-vertical">
		<ul class="uk-child-width-expand uk-grid-divider" uk-grid>
			
			<?php $prev_post = get_previous_post(); if( ! empty($prev_post) ){ ?>
				<li class="nav-previous uk-text-center">
					<a class="uk-link-reset" href="<?php echo get_permalink( $prev_post->ID ); ?>" rel="prev">
						<div class="uk-inline-clip uk-transition-toggle uk-light">
		        	<?php echo get_the_post_thumbnail($prev_post->ID, array(100,100) ); ?>
		        	<div class="uk-position-center uk-transition-fade uk-overlay uk-overlay-primary">
	                <span class="uk-transition-fade uk-transition-slide-right-small" uk-icon="icon: arrow-left; ratio: 2"></span>
	            </div>
						</div>
			        </a>
			        <h2 class="uk-h4">
				        <a class="uk-link-reset" href="<?php echo get_permalink( $prev_post->ID ); ?>" rel="prev">
					        <?php echo $prev_post->post_title; ?>
				        </a>
				    </h2>
			    </li>
		    <?php } ?>
		    
		    <?php $next_post = get_next_post(); if( ! empty($next_post) ){ ?>
				<li class="nav-next uk-text-center">
					<a class="uk-link-reset" href="<?php echo get_permalink( $next_post->ID ); ?>" rel="next">
						<div class="uk-inline-clip uk-transition-toggle uk-light">
							<?php echo get_the_post_thumbnail($next_post->ID, array(100,100) ); ?>
		        	<div class="uk-position-center uk-transition-fade uk-overlay uk-overlay-primary">
	               <span class="uk-transition-fade uk-transition-slide-left-small" uk-icon="icon: arrow-right; ratio: 2"></span>
	            </div>
						</div>
					</a>
					<h2 class="uk-h4">
						<a class="uk-link-reset" href="<?php echo get_permalink( $next_post->ID ); ?>" rel="next">
							<?php echo $next_post->post_title; ?>
						</a>
					</h2>
				</li>
			<?php } ?>
			
		</ul>
	</div>
</div>

<!-- Комментарии -->

<?php if ( comments_open() || get_comments_number() ) : ?>
	<?php comments_template(); ?>
<?php endif; ?>
