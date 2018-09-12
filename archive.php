<!-- Вывод даты на страницы постов -->
<?php the_date(); ?>
<?php the_time('j. F Y'); ?>


<!-- Вывод заголовков -->
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
  <?php the_title(); ?>
</a>


<!-- Вывести дату как в Twitter -->
<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' назад'; ?>


<!-- Вывод отрывка поста -->
<?php do_excerpt(get_the_excerpt(), 20); ?>


<!-- Путь до папки с картинками WP -->
<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images.png">
