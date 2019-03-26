<?php $params = array('posts_per_page' => 4, 'orderby' => 'rand', 'tax_query' => array(array( 'taxonomy' => 'console', 'field' => 'slug', 'terms' => array( 'nintendo-nes' ),),),); $query = new WP_Query( $params ); ?>
<?php if ( $query->have_posts() ) : ?>
    <ul class="uk-list">
	    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	    <?php endwhile; ?>
    </ul>
<?php endif; ?>
