<!-- Вывод списка будущих записей -->
<?php query_posts('showposts=10&post_status=future'); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!-- Контент -->
  <?php endwhile; else: ?>
    <!-- Нет будущих записей -->
<?php endif; ?>


<!-- Меняем вид первого поста в выводе произвольных потов -->
<?php query_posts(array('orderby' => 'rand', 'cat' => '0,1,2,3', 'showposts' => 5)); ?>
<?php if (have_posts()) : ?>
<?php $count = 0; ?>
  <!-- Начало цикла -->
  <?php while (have_posts()) : the_post(); ?>
	<?php $count++; ?>
	<?php if ($count == 1) : ?>
    <!-- Первый пост -->
  <?php else : ?>
    <!-- Остальные посты -->
  <?php endif; ?>
	<?php endwhile; ?>
  <!-- Конец цикла -->
<?php endif; ?>
<?php wp_reset_query();?>
