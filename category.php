<!-- Выводим количество всех записей на странице категории -->
<?php echo count(query_posts('cat=1,3,4,7'));?>


<!-- Вывод списка будущих записей -->
<?php query_posts('showposts=10&post_status=future'); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!-- Контент -->
  <?php endwhile; else: ?>
    <!-- Нет будущих записей -->
<?php endif; ?>


<!-- Выводим последних постов -->
<?php query_posts($query_string.'&cat=0&showposts=8'); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <!-- Контент цикла -->
<?php  endwhile; ?>
<?php wp_reset_query();?>


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

<!-------------------------------------------------------------------
  Пекламные вставки между постами в ленте новостей
-------------------------------------------------------------------->

<?php $counter = 0; ?>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php $counter = $counter + 1;?>
		
		<?php if(1 == $counter) : { ?>
			<li><?php get_template_part( 'content', 'large' ); ?></li>
		<?php } else : { ?>
			<li><?php get_template_part( 'content' ); ?></li>
		<?php } endif; ?>
	
		<?php if(2 == $counter) : { ?>
			<li>Реклама 1</li>
		<?php } endif; ?>
		
		<?php if(4 == $counter) : { ?>
			<li>Реклама 3</li>
		<?php } endif; ?>

		<?php endwhile; ?>
<?php else : ?>
	Постов нет!
<?php endif; ?>
