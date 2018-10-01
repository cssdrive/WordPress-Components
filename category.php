<!-- Вывод заголовка и описания рубрики -->

<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>

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

<!-- Пекламные вставки между постами в ленте новостей -->

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

<!-- Вывод постов с конца -->

<?php query_posts( $query_string.'&cat=0&order=DESC&posts_per_page=3'); //Значения (-9) отключают категорию (9) добавляют; C начала order=ASC; с конца order=DESC ?>
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <img src="<?php if ( has_post_thumbnail() ) { the_post_thumbnail('large'); } ?>" uk-cover>
    <h1 class="uk-heading-primary" uk-slideshow-parallax="x: 200,-200"><?php the_title( '', '' ); ?></h1>
    <div class="uk-text-meta" uk-slideshow-parallax="x: 400,-400"><?php the_excerpt(); ?></div>
  <?php else : ?>
    Нет постовв
  <?php endif; ?>
<?php wp_reset_query(); ?>
