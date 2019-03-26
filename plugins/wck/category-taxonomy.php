<?php 
	 
	/*
	 * Получаем все Отзывы
	 * post_type - название нашего произвольного типа записей (идентификатор)
	 * posts_per_page - количество получаемых записей 
	 * (в нашем случае стоит -1, это значит, что нужно получить все посты)
	 */
	$params = array(
		'tax_query' => array( // про tax_query написано чуть выще
			array(
				'taxonomy' => 'console', // таксономия форматов
				'field'    => 'slug', // значение этого поля обязательно slug
				'terms'    => array( 'nintendo-nes' ), // название одного или нескольких форматов в виде массива
			),
		),
	);
	$query = new WP_Query( $params );
	?>
	 
	<div class="wrap">
 
    <!-- Не забудьте в цикл добавить полученный объект постов $reviews -->
    <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="review-excerpt"><?php the_excerpt(); ?></div>
 
    <?php endwhile; ?>
    <?php endif; ?>
 
</div>
