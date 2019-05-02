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

/* Регистрация скрипта functions.js */

add_action( 'wp_enqueue_scripts', 'theme_register_scripts', 1 );

function theme_register_scripts() {
 
  /** Register JavaScript Functions File */
  wp_register_script( 'functions-js', esc_url( trailingslashit( get_template_directory_uri() ) . '/js/ajax-content.js' ), array( 'jquery' ), '1.0', true );
 
  /** Localize Scripts */
  $php_array = array( 'admin_ajax' => admin_url( 'admin-ajax.php' ) );
  wp_localize_script( 'functions-js', 'php_array', $php_array );
 
}
 
/** Enqueue Scripts. */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
function theme_enqueue_scripts() {
 
  /** Enqueue JavaScript Functions File */
  wp_enqueue_script( 'functions-js' );
 
}
