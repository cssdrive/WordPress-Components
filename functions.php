<?php

// Подключаем форматы записей
add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video' ) );


// Меняем WP вывод картинки на прямой адрес
function true_thumbnail_url_only( $html ){
  return preg_replace('#.*src="([^\"]+)".*#', '\1', $html );
}
add_filter('post_thumbnail_html', 'true_thumbnail_url_only', 10, 5);
