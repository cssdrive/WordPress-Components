<?php

/*
 * Основное меню
 */

// Изменяет основные параметры меню
add_filter( 'wp_nav_menu_args', 'filter_wp_menu_args_header' );
function filter_wp_menu_args_header( $args ) {
	if ( $args['theme_location'] === 'header' ) {
		$args['container']   = false;
		$args['items_wrap']  = '<ul class="%2$s">%3$s</ul>';
		$args['menu_class']  = 'uk-navbar-nav uk-navbar-parent-icon';
	}
	return $args;
}

// Изменяем атрибут id у тега li
add_filter( 'nav_menu_item_id', 'filter_menu_item_css_id_header', 10, 4 );
function filter_menu_item_css_id_header( $menu_id, $item, $args, $depth ) {
	return $args->theme_location === 'header' ? '' : $menu_id;
}

// Изменяем атрибут class у тега li
add_filter( 'nav_menu_css_class', 'filter_nav_menu_css_classes_header', 10, 4 );
function filter_nav_menu_css_classes_header( $classes, $item, $args, $depth ) {
	if ( $args->theme_location === 'header' ) {
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
add_filter( 'nav_menu_submenu_css_class', 'filter_nav_menu_submenu_css_class_header', 10, 3 );
function filter_nav_menu_submenu_css_class_header( $classes, $args, $depth ) {
	if ( $args->theme_location === 'header' ) {
		$classes = [
			'uk-nav uk-navbar-dropdown-nav',
		];
	}
	return $classes;
}

// ДОбавляем классы ссылкам
add_filter( 'nav_menu_link_attributes', 'filter_nav_menu_link_attributes_header', 10, 4 );
function filter_nav_menu_link_attributes_header( $atts, $item, $args, $depth ) {
	if ( $args->theme_location === 'header' ) {
		$atts['class'] = ' ';
		if ( $item->current ) {
			$atts['class'] .= ' uk-active';
		}
	}
	return $atts;
}

/*
 * Выпадающее меню
 */

class Kama_Walker_Nav_Menu extends Walker_Nav_Menu {
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
		$t = '';
		$n = '';
	} else {
		$t = "\t";
		$n = "\n";
	}
	$indent = str_repeat( $t, $depth );
	$classes = array( 'sub-menu' );
	$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
	$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	$output .= "{$n}{$indent}<div class='uk-navbar-dropdown' uk-drop='offset: -15; delay-show: 50; delay-hide: 30; duration: 50;'><ul$class_names>{$n}";
    }
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
	if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
		$t = '';
		$n = '';
	} else {
		$t = "\t";
		$n = "\n";
	}
	$indent = str_repeat( $t, $depth );
	$output .= "$indent</ul></div>{$n}";
  }
}
