<?php

// Изменяет основные параметры меню
add_filter( 'wp_nav_menu_args', 'filter_wp_menu_args_offcanvas' );
function filter_wp_menu_args_offcanvas( $args ) {
	if ( $args['theme_location'] === 'offcanvas' ) {
		$args['container']   = false;
		$args['items_wrap']  = '<ul class="%2$s" uk-nav>%3$s</ul>';
		$args['menu_class']  = 'uk-nav-default uk-nav-parent-icon';
	}
	return $args;
}

// Изменяем атрибут id у тега li
add_filter( 'nav_menu_item_id', 'filter_menu_item_css_id_offcanvas', 10, 4 );
function filter_menu_item_css_id_offcanvas( $menu_id, $item, $args, $depth ) {
	return $args->theme_location === 'offcanvas' ? '' : $menu_id;
}

// Изменяем атрибут class у тега li
add_filter( 'nav_menu_css_class', 'filter_nav_menu_css_classes_offcanvas', 10, 4 );
function filter_nav_menu_css_classes_offcanvas( $classes, $item, $args, $depth ) {
	if ( $args->theme_location === 'offcanvas' ) {
		$classes = [
			'lvl-' . ( $depth + 1 )
		];
		if ( $item->current ) {
			$classes[] = 'uk-active';
		}
	}
	return $classes;
}

// Изменяет класс у вложенного ul
add_filter( 'nav_menu_submenu_css_class', 'filter_nav_menu_submenu_css_class_offcanvas', 10, 3 );
function filter_nav_menu_submenu_css_class_offcanvas( $classes, $args, $depth ) {
	if ( $args->theme_location === 'offcanvas' ) {
		$classes = [
			'uk-nav uk-navbar-dropdown-nav',
		];
	}
	return $classes;
}

// ДОбавляем классы ссылкам
add_filter( 'nav_menu_link_attributes', 'filter_nav_menu_link_attributes_offcanvas', 10, 4 );
function filter_nav_menu_link_attributes_offcanvas( $atts, $item, $args, $depth ) {
	if ( $args->theme_location === 'offcanvas' ) {
		$atts['class'] = ' ';
		if ( $item->current ) {
			$atts['class'] .= ' uk-active';
		}
	}
	return $atts;
}