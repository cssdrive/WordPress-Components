<?php

// Собственные стили для форматов записей
function wck_editor_style() {
  global $current_screen;
  switch ($current_screen->post_type) {
      case 'post':
      add_editor_style('editor-style-post.css');
      break;
      case 'page':
      add_editor_style('editor-style-page.css');
      break;
      case 'portfolio':
      add_editor_style('editor-style-portfolio.css');
      break;
    }
}
add_action( 'admin_head', 'wck_editor_style' );
