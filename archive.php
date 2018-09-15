<!-- Вывод даты на страницы постов -->
<?php the_date(); ?>
<?php the_time('j. F Y'); ?>


<!-- Подключаем Header и footer -->
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

<!-------------------------------------------------------------------
  Вывод контента с заголовокм и постраничноц навигацией
-------------------------------------------------------------------->

<?php if ( have_posts() ) : ?>	
	<?php if ( is_home() && ! is_front_page() ) : ?>
		<h1><?php single_post_title(); ?></h1>
	<?php endif; ?>
		<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
		<?php endwhile; ?>
	<?php pagenavi(); ?>
<?php else : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>

<!-------------------------------------------------------------------
  Вывод заголовока и описания
-------------------------------------------------------------------->

<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
  <?php the_title(); ?>
</a>

<?php
  if ( is_single() ) {
    the_title( '<h1 class="uk-article-title">', '</h1>' );
  } else {
    the_title( '<h2 class="uk-article-title"><a class="uk-link-reset" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
  }
?>

<!-------------------------------------------------------------------
  Вывод Аватарки
-------------------------------------------------------------------->

<a class="uk-link-reset uk-margin-small-right" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>">
	<?php echo get_avatar( get_the_author_meta('user_email'), 24, '', '', array('class'=>'uk-border-rounded', 'extra_attr'=>'style="margin-top: -4px;"')); ?>
	<?php the_author(); ?>
</a>

<!-------------------------------------------------------------------
  Кнопка редактирования страницы
-------------------------------------------------------------------->

<?php edit_post_link('<span uk-icon="icon: cog"></span>','<div class="uk-card-badge uk-link-reset">','</div>'); ?>

<!-------------------------------------------------------------------
  Подключаем форматов страницы
-------------------------------------------------------------------->

<?php get_template_part( '/page/content/', get_post_format() ); ?>

<!-------------------------------------------------------------------
  Подключение произвольных страниц template-parts/content-future.php
-------------------------------------------------------------------->

<?php get_template_part( 'template-parts/content', 'future' ); ?>

<!-------------------------------------------------------------------
  Вывод категории
-------------------------------------------------------------------->

<?php printf(__('<strong class="uk-link-muted">%s</strong>', 'cssdrive'), get_the_category_list(', ')); ?>

<?php printf(__('%s'), get_the_category_list(' ')); ?>


<!-------------------------------------------------------------------
   Вывести дату как в Twitter
-------------------------------------------------------------------->

<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' назад'; ?>


<!-- Вывод отрывка поста -->
<?php the_excerpt(); ?>

<?php do_excerpt(get_the_excerpt(), 20); ?>

<?php if ( is_category() ) { the_excerpt(); } else { the_content(); } ?>

<?php the_content(); ?>

<!-- Вывод количества комментариев -->
<a class="uk-link-reset" href="<?php the_permalink() ?>#comments">
  <span uk-icon="icon: commenting;  ratio:0.9;"></span> <?php comments_number('0', '1', '%'); ?>
</a>

<!-------------------------------------------------------------------
  Вывод миниатюр
-------------------------------------------------------------------->

<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail', ['class' => 'attachment-post-thumbnail size-post-thumbnail']); } ?>

<?php if ( has_post_thumbnail() ) : ?>
  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	  <?php the_post_thumbnail('thumbnail'); ?>
	</a>
<?php endif; ?>

<!-------------------------------------------------------------------
  Вывод миниатюр V2
-------------------------------------------------------------------->

<?php  if ( is_single() ) { ?>	
		<?php if ( has_post_thumbnail() ) : ?>
	  	<?php the_post_thumbnail('thumbnail-post', ['class' => 'attachment-post-thumbnail size-post-thumbnail']); ?>
		<?php endif; ?>
	<?php } else { ?>
	  <?php if ( has_post_thumbnail() ) : ?>
		  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			  <?php the_post_thumbnail('thumbnail-post', ['class' => 'attachment-post-thumbnail size-post-thumbnail']); ?>
			</a>
		<?php endif; ?>
	<? }	?>
