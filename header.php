<!-- Вывод главного меню -->
<?php
  $nav = wp_nav_menu(array(
    'theme_location'  => 'primary',
    'menu'            => '',
    'container'       => 'ul',
    'container_class' => '',
    'container_id'    => '',
    'menu_class'      => 'uk-navbar-nav uk-visible@m',
    'menu_id'         => '',
    'echo'            => false,
    'fallback_cb'     => false,
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'           => 2,
    'walker'          => new WalkerNavMenu('navbar'),
  ));
?>

<?= $nav ?>


<!-- Скрыть или показать определенный контент на страницах WP -->
<?php
  if ( is_page('about') )
    // где 'about' это название или ярлык страницы
    echo "Это страница 'about'";
  elseif ( is_page('12') )
    // где '12' это ID, название или ярлык страницы
    echo "Это страница '12'";
  else
  if (is_page()) echo "Это статическая страница";
?>

<?php if( is_page(array('12','contacts','Карта сайта','da-da')) )
  echo "Статическая страница с указанными данными";
else
  if( is_page() ) echo "Любая другая статическая страница";
?>

<?php if ( is_front_page() ) : ?>
    <!-- Контент для главной -->
<?php else : ?>
	 <!-- Контент для всехз остальных -->
<?php endif; ?>

<?php if( is_page('price') ): ?>
  <!-- Контент -->
<?php endif; ?>
