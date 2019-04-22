<!--
  Страница
-->
<?php get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile;?>	
<?php get_footer(); ?>

<!--
  Удаленный вывод с комментариями
-->

<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'template-parts/content', 'page' ); ?>
	<?php if ( comments_open() || get_comments_number() ) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>
<?php endwhile;?>
