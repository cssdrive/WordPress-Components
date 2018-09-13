<?php

// Закрыть прямой доступ к файлу Wp, отобразится пустой лист при просмотре кода.

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

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
  Колонка миниатюры в списке записей админки
-------------------------------------------------------------------*/

add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Миниатюра');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
	if($column_name === 'riv_post_thumbs'){ ?>
    <img src="<?php the_post_thumbnail('thumbnail', array(50,50)); ?>">  
<?php }} ?>

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

/*------------------------------------------------------------------ 
  Удаляем в строке браузера, срочку category
-------------------------------------------------------------------*/

add_filter('category_link', create_function('$a', 'return str_replace("category/", "", $a);'), 9999);
		
/*------------------------------------------------------------------ 
    Удаляем Emoji
-------------------------------------------------------------------*/

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2.2.1/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	return $urls;
}
		
/*------------------------------------------------------------------
  Удаляем ссылку на WordPress (s.w.org)
-------------------------------------------------------------------*/

function remove_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
		
/*------------------------------------------------------------------
  Удаляем остальные ненужные meta из head
-------------------------------------------------------------------*/

function wp_version_js_css($src) {
    if (strpos($src, 'ver=' . get_bloginfo('version')))
        $src = remove_query_arg('ver', $src);
    return $src;
}
add_filter('style_loader_src', 'wp_version_js_css', 9999);
add_filter('script_loader_src', 'wp_version_js_css', 9999);

// Удаляем код meta name="generator"
remove_action( 'wp_head', 'wp_generator' );
 
// Удаляем link rel="canonical" // Этот тег лучше выводить с помощью плагина Yoast SEO или All In One SEO Pack
remove_action( 'wp_head', 'rel_canonical' );
 
// Удаляем link rel="shortlink" - короткую ссылку на текущую страницу
remove_action( 'wp_head', 'wp_shortlink_wp_head' ); 
 
// Удаляем link rel="EditURI" type="application/rsd+xml" title="RSD"
// Используется для сервиса Really Simple Discovery 
remove_action( 'wp_head', 'rsd_link' ); 
 
// Удаляем link rel="wlwmanifest" type="application/wlwmanifest+xml"
// Используется Windows Live Writer
remove_action( 'wp_head', 'wlwmanifest_link' );
 
// Удаляем различные ссылки link rel
// на главную страницу
remove_action( 'wp_head', 'index_rel_link' ); 
// на первую запись
remove_action( 'wp_head', 'start_post_rel_link', 10 );  
// на предыдущую запись
remove_action( 'wp_head', 'parent_post_rel_link', 10 ); 
// на следующую запись
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );
 
// Удаляем связь с родительской записью
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); 
 
// Удаляем вывод /feed/
remove_action( 'wp_head', 'feed_links', 2 );

// Удаляем вывод /feed/ для записей, категорий, тегов и подобного
remove_action( 'wp_head', 'feed_links_extra', 3 );
 
// Удаляем ненужный css плагина WP-PageNavi
remove_action( 'wp_head', 'pagenavi_css' );

/*------------------------------------------------------------------ 
    Настраиваем редирект со страницы rss /feed/ на главную
-------------------------------------------------------------------*/

add_action( 'do_feed', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rdf', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rss', 'sheensay_redirect_feed', 1 );
add_action( 'do_feed_rss2', 'sheensay_redirect_feed', 1 );
 
function sheensay_redirect_feed() {
  wp_redirect( site_url('/') );
  exit;
}

/*------------------------------------------------------------------ 
  Удаляем стили css-класса .recentcomments
-------------------------------------------------------------------*/

function sheensay_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory -> widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'sheensay_remove_recent_comments_style' );

/*------------------------------------------------------------------
  Отключаем и удаляем wp-json и oembed
-------------------------------------------------------------------*/

// Отключаем WP-API версий 1.x
add_filter( 'json_enabled', '__return_false' );
add_filter( 'json_jsonp_enabled', '__return_false' );
 
// Отключаем WP-API версий 2.x
add_filter( 'rest_enabled', '__return_false' );
add_filter( 'rest_jsonp_enabled', '__return_false' );
 
// Удаляем информацию о REST API из заголовков HTTP и секции head
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
 
// Отключаем фильтры REST API
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
 
// Отключаем события REST API
remove_action( 'init', 'rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
remove_action( 'parse_request', 'rest_api_loaded' );
 
// Отключаем Embeds связанные с REST API
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );
 
// Убираем oembed ссылки в секции head
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
 
// Если собираетесь выводить oembed из других сайтов на своём, то закомментируйте следующую строку
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

/*------------------------------------------------------------------
  Код для отключения и удаления XML-RPC
-------------------------------------------------------------------*/

add_filter( 'xmlrpc_methods', 'sheensay_block_xmlrpc_attacks' );
 
function sheensay_block_xmlrpc_attacks( $methods ) {
   unset( $methods['pingback.ping'] );
   unset( $methods['pingback.extensions.getPingbacks'] );
   return $methods;
}
 
add_filter( 'wp_headers', 'sheensay_remove_x_pingback_header' );
 
function sheensay_remove_x_pingback_header( $headers ) {
   unset( $headers['X-Pingback'] );
   return $headers;
}

// Не рекомендую использовать, т.к. несовместимо с плагином JetPack и подобными
add_filter('xmlrpc_enabled', '__return_false');
