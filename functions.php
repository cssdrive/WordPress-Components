<?php

// Подключаем форматы записей
add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video' ) );


// Подключаем удаленные файлы functions.php
require get_parent_theme_file_path( '/inc/name.php' );


// Меняем WP вывод картинки на прямой адрес
function true_thumbnail_url_only( $html ){
  return preg_replace('#.*src="([^\"]+)".*#', '\1', $html );
}
add_filter('post_thumbnail_html', 'true_thumbnail_url_only', 10, 5);


// Добавляем возможность использования @2x
function onwp_fix_retina_filename($filename, $filename_raw) {
  $filename = str_replace('-2x.', '@2x.', $filename);
  return $filename;
}
add_filter('sanitize_file_name', 'onwp_fix_retina_filename', 100, 2);


// Убираем ссылку на ACF из админки
add_filter( 'acf/settings/show_admin', '__return_false' );


// Удаляем название [Рубрика:] в категориях
function remove_cat_name( $title ){
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  }
  return $title;
}
add_filter( 'get_the_archive_title', 'remove_cat_name' );


/*------------------------------------------------------------------
  Подключаем настройки WP
-------------------------------------------------------------------*/

function wp_setup() {		
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');

	register_nav_menus( [
		'primary' => 'Primary Menu',
		'offcanvas' => 'Offcanvas Menu',
	] );

	//Добавляем собственные размеры для картинок
	add_image_size( 'post-thumbs', '460', '260', true);
	add_image_size( 'post-images', '960', '480', true); 
}
add_action( 'after_setup_theme', 'wp_setup' );


/*------------------------------------------------------------------
  Подключаем стили и скрипты
-------------------------------------------------------------------*/

function wp_scripts() {
  wp_enqueue_style( 'uikit', get_theme_file_uri() . '/assets/css/uikit.min.css', null, '' );
  wp_enqueue_style( 'theme', get_theme_file_uri() . '/assets/css/theme.css', null, '' );

  if( !is_admin()){ wp_deregister_script('jquery'); } // Отключаем стандартый WP JQuery

  wp_enqueue_script( 'jquery', get_theme_file_uri() . '/assets/js/jquery.js', array(), '', false );
  wp_enqueue_script( 'uikit', get_theme_file_uri() . '/assets/js/uikit.min.js', array(), '', false );
  wp_enqueue_script( 'uikit-icons', get_theme_file_uri() . '/assets/js/uikit-icons.min.js', array(), '', false );
}
add_action( 'wp_enqueue_scripts', 'wp_scripts' );


/*------------------------------------------------------------------
  Подключаем свои стили в админку
-------------------------------------------------------------------*/

function mystylesheet(){
	echo '<link href="'.get_bloginfo( 'stylesheet_directory' ).'/assets/css/admin.css" rel="stylesheet" type="text/css">';
}
add_action('admin_head', 'mystylesheet');


/*------------------------------------------------------------------
  Отключаем создание миниатюр файлов для указанных размеров
-------------------------------------------------------------------*/

function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, array(
		'thumbnail',
		'medium',
		'large',
		'full',
	) );
}
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );


/*------------------------------------------------------------------
  Подключаем виджеты
-------------------------------------------------------------------*/

function widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fubon' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'fubon' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'widgets_init' );


/*------------------------------------------------------------------
  Фильтр имя пользователя от непригодных для использования символов
-------------------------------------------------------------------*/

function wscu_sanitize_user ($username, $raw_username, $strict)
{
  //Strip HTML Tags
  $username = wp_strip_all_tags ($raw_username);
  //Remove Accents
  $username = remove_accents ($username);
  //Kill octets
  $username = preg_replace ('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
  //Kill entities
  $username = preg_replace ('/&.+?;/', '', $username);
  //If strict, reduce to ASCII, Cyrillic and Arabic characters for max portability.
  if ($strict)
  {
    //Read settings
    $settings = get_option ('wscu_settings');
    //Replace
    $username = preg_replace ('|[^a-z\p{Arabic}\p{Cyrillic}0-9 _.\-@]|iu', '', $username);
  }
  //Remove Whitespaces
  $username = trim ($username);
  // Consolidate contiguous Whitespaces
  $username = preg_replace ('|\s+|', ' ', $username);
  //Done
  return $username;
}
add_filter ('sanitize_user', 'wscu_sanitize_user', 10, 3);


// Добавление произвольного JQuery
if( !is_admin()){
  wp_deregister_script('jquery');
  wp_register_script('jquery', ("//code.jquery.com/jquery-3.1.1.min.js"), array(), true);
  wp_enqueue_script('jquery');
}


/*------------------------------------------------------------------
  Постраничная навигация
-------------------------------------------------------------------*/

function pagenavi( $before = '', $after = '', $echo = true, $args = array(), $wp_query = null ) {
	if( ! $wp_query )
		global $wp_query;

	// параметры по умолчанию
	$default_args = array(
		'text_num_page'   => '', // Текст перед пагинацией. {current} - текущая; {last} - последняя (пр. 'Страница {current} из {last}' получим: "Страница 4 из 60" )
		'num_pages'       => 6, // сколько ссылок показывать
		'step_link'       => 12, // ссылки с шагом (значение - число, размер шага (пр. 1,2,3...10,20,30). Ставим 0, если такие ссылки не нужны.
		'dotright_text'   => '…', // промежуточный текст "до".
		'dotright_text2'  => '…', // промежуточный текст "после".
		'back_text'       => '<span uk-pagination-previous></span>', // текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
		'next_text'       => '<span uk-pagination-next></span>', // текст "перейти на следующую страницу". Ставим 0, если эта ссылка не нужна.
		'first_page_text' => 'к началу', // текст "к первой странице". Ставим 0, если вместо текста нужно показать номер страницы.
		'last_page_text'  => 'в конец', // текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
	);

	$default_args = apply_filters('pagenavi_args', $default_args ); // чтобы можно было установить свои значения по умолчанию

	$args = array_merge( $default_args, $args );

	extract( $args );

	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
	$paged          = (int) $wp_query->query_vars['paged'];
	$max_page       = $wp_query->max_num_pages;

	//проверка на надобность в навигации
	if( $max_page <= 1 )
		return false;

	if( empty( $paged ) || $paged == 0 )
		$paged = 1;

	$pages_to_show = intval( $num_pages );
	$pages_to_show_minus_1 = $pages_to_show-1;

	$half_page_start = floor( $pages_to_show_minus_1/2 ); //сколько ссылок до текущей страницы
	$half_page_end = ceil( $pages_to_show_minus_1/2 ); //сколько ссылок после текущей страницы

	$start_page = $paged - $half_page_start; //первая страница
	$end_page = $paged + $half_page_end; //последняя страница (условно)

	if( $start_page <= 0 )
		$start_page = 1;
	if( ($end_page - $start_page) != $pages_to_show_minus_1 )
		$end_page = $start_page + $pages_to_show_minus_1;
	if( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = (int) $max_page;
	}

	if( $start_page <= 0 )
		$start_page = 1;

	//выводим навигацию
	$out = '';

	// создаем базу чтобы вызвать get_pagenum_link один раз
	$link_base = str_replace( 99999999, '___', get_pagenum_link( 99999999 ) );
	$first_url = get_pagenum_link( 1 );
	if( false === strpos( $first_url, '?') )
		$first_url = user_trailingslashit( $first_url );

	$out .= $before . "<section class='uk-section uk-section-xsmall uk-section-muted'><div class='uk-container uk-container-expand'><ul class='uk-pagination uk-flex-center' uk-margin>\n";

		if( $text_num_page ){
			$text_num_page = preg_replace( '!{current}|{last}!', '%s', $text_num_page );
			$out.= sprintf( "<li><span class='pages'>$text_num_page</span></li> ", $paged, $max_page );
		}
		// назад
		if ( $back_text && $paged != 1 )
			$out .= '<li><a href="'. ( ($paged-1)==1 ? $first_url : str_replace( '___', ($paged-1), $link_base ) ) .'">'. $back_text .'</a></li> ';
			
		// в начало
		if ( $start_page >= 2 && $pages_to_show < $max_page ) {
			$out.= '<li><a class="first" href="'. $first_url .'">'. ( $first_page_text ? $first_page_text : 1 ) .'</a></li> ';
			if( $dotright_text && $start_page != 2 ) $out .= '<li><span class="extend">'. $dotright_text .'</span><li> ';
		}
		// пагинация
		for( $i = $start_page; $i <= $end_page; $i++ ) {
			if( $i == $paged )
				$out .= '<li class="uk-active"><span>'.$i.'</span></li> ';
			elseif( $i == 1 )
				$out .= '<li><a href="'. $first_url .'">1</a></li> ';
			else
				$out .= '<li><a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a></li> ';
		}

		//ссылки с шагом
		$dd = 0;
		if ( $step_link && $end_page < $max_page ){
			for( $i = $end_page+1; $i<=$max_page; $i++ ) {
				if( $i % $step_link == 0 && $i !== $num_pages ) {
					if ( ++$dd == 1 )
						$out.= '<li><span class="extend">'. $dotright_text2 .'</span></li> ';
					$out.= '<li><a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a></li> ';
				}
			}
		}
		// в конец
		if ( $end_page < $max_page ) {
			if( $dotright_text && $end_page != ($max_page-1) )
				$out.= '<li><span class="extend">'. $dotright_text2 .'</span></li> ';
			$out.= '<li><a class="last" href="'. str_replace( '___', $max_page, $link_base ) .'">'. ( $last_page_text ? $last_page_text : $max_page ) .'</a></li> ';
		}
		// вперед
		if ( $next_text && $paged != $end_page )
			$out.= '<li><a class="next" href="'. str_replace( '___', ($paged+1), $link_base ) .'">'. $next_text .'</a></li> ';

	$out .= "</ul></div></section>". $after ."\n";

	$out = apply_filters('pagenavi', $out );

	if( $echo )
		return print $out;

	return $out;
}


/*------------------------------------------------------------------
  Инфо блоки в админке
-------------------------------------------------------------------*/

// Перед полем для ввода заголовка записи
add_action( 'edit_form_top', 'callback__edit_form_top' );
function callback__edit_form_top( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #673AB7;clear: both;">
		Здесь сработал хук <b>edit_form_top</b>.
	</div>
	<?php
}

// После поля для ввода заголовка записи, но перед ссылкой на запись
add_action( 'edit_form_before_permalink', 'callback__edit_form_before_permalink' );
function callback__edit_form_before_permalink( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #914029;clear: both;">
		Здесь сработал хук <b>edit_form_before_permalink</b>.
	</div>
	<?php
}

// После поля для ввода заголовка записи и постоянной ссылки для неё
add_action( 'edit_form_after_title', 'callback__edit_form_after_title' );
function callback__edit_form_after_title( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #9876aa;clear: both;">
		Здесь сработал хук <b>edit_form_after_title</b>.
	</div>
	<?php
}

// После визуального редактора
add_action( 'edit_form_after_editor', 'callback__edit_form_after_editor' );
function callback__edit_form_after_editor( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #ff2401;clear: both;">
		Здесь сработал хук <b>edit_form_after_editor</b>.
	</div>
	<?php
}

// Сайдбар - перед метабоксами - Страницы
add_action( 'submitpage_box', 'callback__submitpage_box' );
function callback__submitpage_box( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #8BC34A;clear: both;">
		Здесь сработал хук <b>submitpage_box</b>.
	</div>
	<?php
}

// Сайдбар - перед метабоксами - Все типы записей, кроме страниц
add_action( 'submitpost_box', 'callback__submitpost_box' );
function callback__submitpost_box( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #8BC34A;clear: both;">
		Здесь сработал хук <b>submitpost_box</b>.
	</div>
	<?php
}

// После всех метабоксов широкой колонки и только для страниц
add_action( 'edit_page_form', 'callback__edit_page_form' );
function callback__edit_page_form( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #0085ba;clear: both;">
		Здесь сработал хук <b>edit_page_form</b>.
	</div>
	<?php
}

// После всех метабоксов широкой колонки, для всех типов записей, кроме страниц
add_action( 'edit_form_advanced', 'callback__edit_form_advanced' );
function callback__edit_form_advanced( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #795548;clear: both;">
		Здесь сработал хук <b>edit_form_advanced</b>.
	</div>
	<?php
}

// После всех метабоксов широкой колонки и хуков. Это последний хук на странице.
add_action( 'dbx_post_sidebar', 'callback__dbx_post_sidebar' );
function callback__dbx_post_sidebar( $post ) {
	?>
	<div style="margin-top: 10px;padding: 15px;color: #fff;background: #ff9800;clear: both;">
		Здесь сработал хук <b>dbx_post_sidebar</b>.
	</div>
	<?php
}
