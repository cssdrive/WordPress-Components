<?php

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title' 	=> 'Theme General Settings',
    'menu_title'	=> 'Конструктор',
    'menu_slug' 	=> 'theme-general-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> true
  ));

  acf_add_options_sub_page(array(
    'page_title' 	=> 'Header Slider',
    'menu_title'	=> 'Header Slider',
    'parent_slug'	=> 'theme-general-settings',
  ));
}
