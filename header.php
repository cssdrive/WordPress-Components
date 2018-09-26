<?php if ( is_user_logged_in() ) { ?>
  <!-- LOGIN ON -->
<?php $current_page = $_SERVER['REQUEST_URI']; ?>
  <a href="<?php echo wp_logout_url($current_page); ?>" uk-icon="icon: sign-out"></a>
<?php } else {   ?>
  <!-- LOGIN -OFF -->
  <a href="/wp-login.php" uk-icon="icon: sign-in"></a>
<?php } ?>

<!-------------------------------------------------------------------
  Настройки HEADER
-------------------------------------------------------------------->

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11"><!-- meta и rel для поисковиков (Не обязательный файл) -->
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-------------------------------------------------------------------
  Настройки Menu
-------------------------------------------------------------------->

<header class="header">
  <nav class="uk-navbar-container uk-navbar-transparent">
    <div class="uk-container uk-container-expand">
      <div class="uk-navbar boundary-align" uk-navbar>
        <div class="uk-navbar-left">
          <a class="uk-navbar-item uk-logo" href="<?php echo esc_url(home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo.png" alt="<?php bloginfo( 'name' ); ?>"></a>
        </div>
        <div class="uk-navbar-right">
          <?php wp_nav_menu( [ 'theme_location' => 'primary', 'walker' => new Kama_Walker_Nav_Menu(), ] ); ?>
        </div>
      </div>
    </div>
  </nav>	
</header>

<!-------------------------------------------------------------------
  Вывод плагина Breadcrumbs
-------------------------------------------------------------------->

<?php if ( is_front_page() ) : ?>
<?php else : ?>
<div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">
	<div class="uk-section uk-section-muted crumbs">
		<div class="uk-container uk-container-expand uk-link-text uk-text-small crumbs-list">
			<?php if(function_exists('bcn_display')) {bcn_display();} ?>
		</div>
	</div>
</div>
<?php endif; ?>

<!-------------------------------------------------------------------
  Вывод миниатюор постов в файле header.php
-------------------------------------------------------------------->

<?php if ( ( is_single() || ( is_page() ) ) && has_post_thumbnail( get_queried_object_id() ) ) : ?>
	<?php echo get_the_post_thumbnail( get_queried_object_id(), 'cssdrive-featured-image' ); ?>
<?php endif;?>
	
<!-------------------------------------------------------------------
  Назвние сайта и описание
-------------------------------------------------------------------->
	
<a class="uk-navbar-item uk-logo" href="<?php echo esc_url(home_url( '/' ) ); ?>">
  <?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?>
</a>

<!-------------------------------------------------------------------
  Вывод поиска
-------------------------------------------------------------------->

<?php get_search_form(); ?>

<!-------------------------------------------------------------------
  Вывод главного меню
-------------------------------------------------------------------->

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
    'walker'          => new Primary_Walker_Nav_Menu('navbar'),
  ));
?>

<?= $nav ?>

<!-------------------------------------------------------------------
  Вывод главного меню V2
-------------------------------------------------------------------->

<?php wp_nav_menu( array(
	'menu'            => 'primary',
	'theme_location'  => 'primary',
	'container'       => 'ul',
	'container_id'    => '',
	'container_class' => '',
	'menu_id'         => '',
	'menu_class'      => 'uk-navbar-nav uk-navbar-parent-icon',
	'before'          => '',
	'after'           => '',
	'link_before'     => '<span>',
	'link_after'      => '</span>',
	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'fallback_cb'     => 'Primary_Walker_Nav_Menu::fallback',
	'depth'           => 2,
	'walker'          => new Primary_Walker_Nav_Menu())
); ?>

<!-------------------------------------------------------------------
  Kama Walker Nav Menu (inc/walker-nav-menu/kama-walker-nav-menu.php)
-------------------------------------------------------------------->
	
<?php wp_nav_menu( [ 'theme_location' => 'header', 'walker' => new Kama_Walker_Nav_Menu(), ] ); ?>

<!-------------------------------------------------------------------
  Скрыть или показать определенный контент на страницах WP
-------------------------------------------------------------------->

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
