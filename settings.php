<!-- Путь до папки с картинками WP -->
<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images.png">


<!-- Отображение контента только для Админа -->
<?php if (current_user_can('level_10')) { ?>
  <!-- Сюда добавляется контент -->
<?php } ?>
