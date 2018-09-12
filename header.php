<!-- WP Menu -->
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
