<?php

register_sidebar( array(
  'name' => 'left-sidebar',
  'id' => 'left-sidebar',
  'before_widget' => '<div id="%1$s" class="%2$s widget">',
  'after_widget' => '</div>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>'
));

register_sidebar( array(
  'name' => 'right-sidebar',
  'id' => 'right-sidebar',
  'before_widget' => '<div id="%1$s" class="%2$s widget">',
  'after_widget' => '</div>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>'
));
