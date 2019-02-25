/* ----------------------------------------
  FUNCTION.PHP
---------------------------------------- */

// Функция для изменения части WHERE запроса SQL (WP_Query)
function os_restrict_by_first_letter( $where ) {

	// Условие проверяет наличие GET запроса с параметром 'az'
	if ( isset( $_GET['az'] ) ) {

		// Глобализация переменной $wpdb
		global $wpdb;

		// Изменения касаются только страниц архива
		if ( ! is_tag() && ! is_date() && is_archive() && is_main_query() ) {

			// Устанавливается значение из параметра 'az'
			$where .= $wpdb->prepare( " AND SUBSTRING( {$wpdb->posts}.post_title, 1, 1 ) = %s ", $_GET['az'] );
		}
	}

	// Возвращаются изменённые данные
	return $where;
}

// Установка фильтра для хука 'posts_where'
add_filter( 'posts_where', 'os_restrict_by_first_letter' );


/* ----------------------------------------
  INDEX.PHP
---------------------------------------- */

<?php get_header(); ?>

<?php
if ( ! is_tag() && ! is_date() ) : ?>
	<nav aria-label="a-z" class="mb-4">
		<ul class="pagination pagination-sm flex-wrap justify-content-center">
			<?php

			// Определяем текущую категорию.
			$cat_ID = get_queried_object_id();

			// Формируем массив из списка букв от 'a' до 'z'.
			$az_range_arr = [];

			// Диапазон символов 'а' до 'я' в ASCII Win-1251.
			$az_letters_arr = range( chr( 0xE0 ), chr( 0xFF ) );
			foreach ( $az_letters_arr as $az_letters ) {

				// Формируем массив из списка букв с преобразованием в UTF-8.
				$az_range_arr[ $az_letters ] = iconv( 'CP1251', 'UTF-8', $az_letters );
			}
			foreach ( $az_range_arr as $letter ) : ?>
				<li class="page-item"><a class="page-link text-uppercase" href="<?php echo esc_url( add_query_arg( 'az', $letter, get_category_link( $cat_ID ) ) ); ?>"><?php echo $letter; ?></a></li>
			<?php
			endforeach; ?>

			<li class="page-item"><a class="page-link text-uppercase" href="<?php echo get_category_link( $cat_ID ); ?>">Все</a></li>
		</ul>
	</nav>
<?php
endif; ?>

<?php
if ( ! is_tag() && ! is_date() ) : ?>
	<nav aria-label="a-z" class="mb-4">
		<ul class="pagination pagination-sm flex-wrap justify-content-center">
			<?php

			// Определяем текущую категорию.
			$cat_ID = get_queried_object_id();

			// Задаём массив параметров для пользовательского запроса WP_Query.
			$args_az = array(
				'post_type'   => 'post',
				'post_status' => 'publish',
				'category'    => $cat_ID,
				'numberposts' => -1
			);

			// Запрос WP_Query функцией get_posts().
			$query_az = get_posts( $args_az );

			// Перебираем каждый заголовок записи, отобрав первую букву в массив '$all_titles_arr'.
			$all_titles_arr = [];
			foreach ( $query_az as $post_az ) :
				setup_postdata( $post_az );
				$title            = get_the_title( $post_az->ID );
				$all_titles_arr[] = mb_strtolower( mb_substr( $title, 0, 1, 'UTF-8' ) );
			endforeach;
			wp_reset_postdata();

			// Формируем массив из списка букв от 'a' до 'z'.
			$az_range_arr = [];

			// Диапазон символов 'а' до 'я' в ASCII Win-1251.
			// Формируем массив из списка букв от 'a' до 'z'.
			$az_range_arr = range( 'a', 'z' );

			// Подготовка различных классов для подсветки кнопок навигации.
			foreach ( $az_range_arr as $letter ) :
				$disabled = '';
				$active   = '';

				// Существует ли данная буква в массиве 'all_titles_arr'.
				if ( ! in_array( $letter, $all_titles_arr ) ) :
					$disabled = ' disabled';

				// Совпадает ли буква с текущим параметром GET массива.
				elseif ( isset( $_GET['az'] ) && $_GET['az'] == $letter ) :
					$active = ' active';
				endif; ?>

				<li class="page-item<?php echo $disabled . $active; ?>"><a class="page-link text-uppercase" href="<?php echo esc_url( add_query_arg( 'az', $letter, get_category_link( $cat_ID ) ) ); ?>"><?php echo $letter; ?></a></li>
			<?php
			endforeach;

			$all = '';

			// Если отсутствует параметр $_GET['az'], деактивировать кнопку "Все".
			if ( ! isset( $_GET['az'] ) ) :
				$all = ' disabled';
			endif; ?>

			<li class="page-item<?php echo $all; ?>"><a class="page-link text-uppercase" href="<?php echo get_category_link( $cat_ID ); ?>">Все</a></li>
		</ul>
	</nav>
<?php
endif; ?>

	<?php if ( have_posts() ) : ?>
		
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
		<?php endwhile; ?>
		
		
		<?php global $wp_query; if (  $wp_query->max_num_pages > 1 ) echo '<div id="loadmore_button" class="uk-section uk-text-center"><button class="uk-button uk-button-muted uk-button-large uk-width-medium">Загрузить еще</button>
		</div>'; ?>
		
		<div class="uk-hidden">
			<?php pagination(); ?>
		</div>

	<?php else : ?>
	
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
		
	<?php endif; ?>

<?php get_footer(); ?>
