<!-- Вывод даты на страницы постов -->
<?php the_date(); ?>
<?php the_time('j. F Y'); ?>


<!-- Подключаем Header и footer -->
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>


<!-- Вывод контента через цикл -->
<?php while ( have_posts() ) : the_post(); ?>	
  <article id="post-<?php the_ID(); ?>" <?php post_class('uk-article'); ?>>
    <?php the_content(); ?>	
  </article>
<?php endwhile;?>



<!-- Подключаем форматов страницы -->
<?php get_template_part( '/page/content/', get_post_format('name') ); ?>


<!-- Вывод заголовков -->
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
  <?php the_title(); ?>
</a>


<!-- Вывести дату как в Twitter -->
<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' назад'; ?>


<!-- Вывод отрывка поста -->
<?php do_excerpt(get_the_excerpt(), 20); ?>


<!-- Вывод количества комментариев -->
<a class="uk-link-reset" href="<?php the_permalink() ?>#comments">
  <span uk-icon="icon: commenting;  ratio:0.9;"></span> <?php comments_number('0', '1', '%'); ?>
</a>
