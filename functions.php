<?php

// Подключаем форматы записей
add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video' ) );


// Меняем WP вывод картинки на прямой адрес
function true_thumbnail_url_only( $html ){
  return preg_replace('#.*src="([^\"]+)".*#', '\1', $html );
}
add_filter('post_thumbnail_html', 'true_thumbnail_url_only', 10, 5);


// Добавляем возможность использования @2x
function onwp_fix_retina_filename($filename, $filename_raw) {
  $filename = str_replace('-2x.', '@2x.', $filename);
  return $filename;
}
add_filter('sanitize_file_name', 'onwp_fix_retina_filename', 100, 2);


// Убираем ссылку на ACF из админки
add_filter( 'acf/settings/show_admin', '__return_false' );
