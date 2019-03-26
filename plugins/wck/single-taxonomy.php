		<?php
			
			// необязательно, но в некоторых случаях без этого не обойтись
global $post;
 
// тут можно указать post_tag (подборка постов по схожим меткам) или даже массив array('category', 'post_tag') - подборка и по меткам и по категориям
$related_tax = 'console';
 
// получаем ID всех элементов (категорий, меток или таксономий), к которым принадлежит текущий пост
$cats_tags_or_taxes = wp_get_object_terms( $post->ID, $related_tax, array( 'fields' => 'ids' ) );
 
// массив параметров для WP_Query
$args = array(
	'posts_per_page' => 4, // сколько похожих постов нужно вывести,
	'tax_query' => array(
		array(
			'taxonomy' => $related_tax,
			'field' => 'id',
			'include_children' => false, // нужно ли включать посты дочерних рубрик
			'terms' => $cats_tags_or_taxes,
			'operator' => 'IN' // если пост принадлежит хотя бы одной рубрике текущего поста, он будет отображаться в похожих записях, укажите значение AND и тогда похожие посты будут только те, которые принадлежат каждой рубрике текущего поста
		)
	)
);
$misha_query = new WP_Query( $args );
 
// если посты, удовлетворяющие нашим условиям, найдены
if( $misha_query->have_posts() ) :
 
	// выводим заголовок блока похожих постов
	echo '<h3>Похожие посты</h3>';
 
	// запускаем цикл
	while( $misha_query->have_posts() ) : $misha_query->the_post();
		// в данном случае посты выводятся просто в виде ссылок
		echo '<a href="' . get_permalink( $misha_query->post->ID ) . '">' . $misha_query->post->post_title . '</a>';
	endwhile;
endif;
 
// не забудьте про эту функцию, её отсутствие может повлиять н
			
		?>
		
