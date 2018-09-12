<!-- Вывод списка будущих записей -->
<?php query_posts('showposts=10&post_status=future'); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!-- Контент -->
  <?php endwhile; else: ?>
    <!-- Нет будущих записей -->
<?php endif; ?>
