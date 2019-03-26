<?php global $post;
		 
		// тут можно указать post_tag (подборка постов по схожим меткам) или даже массив array('category', 'post_tag') - подборка и по меткам и по категориям
		$related_tax = 'console';
		 
		// получаем ID всех элементов (категорий, меток или таксономий), к которым принадлежит текущий пост
		$cats_tags_or_taxes = wp_get_object_terms( $post->ID, $related_tax, array( 'fields' => 'ids' ) );
		 
		// массив параметров для WP_Query
		$args = array(
			'posts_per_page' => 5, // сколько похожих постов нужно вывести,
			'orderby' => 'rand', // Выводить в случайном порядке
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
		$wp_query = new WP_Query( $args );
		 
		// если посты, удовлетворяющие нашим условиям, найдены
		if( $wp_query->have_posts() ) : ?>
		 
		<h3>Похожие посты</h3>
		 
		<?php while( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			
			<?php echo '<a href="' . get_permalink( $wp_query->post->ID ) . '">' . $wp_query->post->post_title . '</a>';?>
			
		<? endwhile; endif; ?>
