<?php

function ajax_content() {
  /* Made Query */
  $args = array( 'p' => $_POST['id'] );
  $theme_post_query = new WP_Query( $args );
    while( $theme_post_query->have_posts() ) : $theme_post_query->the_post();
      //Сюда добавляем контент цикла поста
    endwhile;
  exit;
}
add_action( 'wp_ajax_theme_post_example', 'ajax_content' );
add_action( 'wp_ajax_nopriv_theme_post_example', 'ajax_content' );
