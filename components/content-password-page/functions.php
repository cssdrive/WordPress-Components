<?php
	
/*
 * По умолчанию введённый пользователем пароль запоминается на 10 дней, но вы можете изменить это значение при помощи фильтра post_password_expires:
 */ 
function true_change_pass_exp( $exp ){
	return time() + 5 * DAY_IN_SECONDS; // 5 дней к примеру
}
add_filter('post_password_expires', 'true_change_pass_exp', 10, 1);

/*
 * Изменить форму ввода пароля на страницах сайта
 */ 
function true_new_post_pass_form() {
	return '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
	  <input class="uk-input" name="post_password" type="password" placeholder="Пароль к записи" />
	  <input class="uk-button uk-button-default" type="submit" name="Submit" value="Разблокировать" />
	</form>';
}
add_filter( 'the_password_form', 'true_new_post_pass_form' ); // вешаем функцию на фильтр the_password_form

/*
 * Изменить стандартное сообщение для цитат
 */ 
function true_protected_excerpt_text( $excerpt ) {
	if ( post_password_required() )
		$excerpt = '<em>[Запись заблокирована. Для получения пароля обратитесь к администратору.]</em>';
	return $excerpt; // если запись не защищена, будет выводиться стандартная цитата
}
add_filter( 'the_excerpt', 'true_protected_excerpt_text' );

 /*
 * Полностью скрыть с сайта все записи, защищенные паролем
 */
function true_exclude_pass_posts($where) {
	global $wpdb;
	return $where .= " AND {$wpdb->posts}.post_password = '' "; 
}
function true_where_to_exclude($query) {
	if( is_front_page() ) { // например на главной странице
		add_filter( 'posts_where', 'true_exclude_pass_posts' );
	}
}
add_action('pre_get_posts', 'true_where_to_exclude');

/*
 * Изменить цитату на пароль
 */ 
function my_excerpt_password_form( $excerpt ) {
    if ( post_password_required() )
        $excerpt = get_the_password_form();
    return $excerpt;
}
add_filter( 'the_excerpt', 'my_excerpt_password_form' );
