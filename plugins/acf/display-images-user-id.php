<?php get_header(); ?>
			
	<?php
		// Define user ID
		// Replace NULL with ID of user to be queried
		$user_id = NULL;
		
		// Example: Get ID of current user
		// $user_id = get_current_user_id();
		
		// Define prefixed user ID
		$user_acf_prefix = get_the_author_meta('ID');
		$user_id_prefixed = $user_acf_prefix . $user_id;
	?>

	<?php $author_header = get_field( 'author_header', $user_id_prefixed ); ?>
	<?php if ( $author_header ) { ?>
		<img class="uk-width-1-1" src="<?php echo $author_header['url']; ?>" alt="<?php echo $author_header['alt']; ?>" />
	<?php } ?>

	
<!--
  ACF
-->
<section class="uk-section uk-section-small">
	<div class="uk-container">
		<?php echo get_avatar($author->ID);?>
		<?php
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
		?>
		
		<dl>
			<dt><a href="<?php echo $curauth->user_url; ?>" target="_blank"><?php echo $curauth->user_url;?></a></dd>
			<dt><?php echo $curauth->user_description; ?></dd>
		</dl>
		
		
		<h1 class="uk-h4">Все посты автора: <?php echo $curauth->nickname; ?></h1>
		
		<ul class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-5@xl uk-grid-match" uk-grid>
		<?php
		    $args = array(
		        'post_type'      => array( 'analytics', 'news', 'cases', 'guides', 'reviews', 'interview', 'blokcheyn', 'company', 'companylist' ),
		        'posts_per_page' => '',
		        'author'         => $author,
		    );
			
			$author_posts = new WP_Query( $args );
		
		    if ( $author_posts->have_posts() ) : while ( $author_posts->have_posts() ) : $author_posts->the_post();
		?>
	        
		   <li>
					<div id="id-<?php the_ID(); ?>" class="uk-card uk-card-secondary uk-card-body uk-card-small">
						<?php $post_thumbs = get_field( 'post_thumbs' ); ?>
						<?php if ( $post_thumbs ) { ?>
							<a class="uk-link-text" href="<?php the_permalink(); ?>" rel="bookmark">
								<img class="uk-width-1-1 <?php if ( get_field( 'post_thumbs_border' ) == 1 ) { echo 'post-thumbs-border'; } else {  echo ''; } ?>" src="<?php echo $post_thumbs['sizes']['post-thumbs']; ?>" alt="<?php echo $post_thumbs['alt']; ?>">
							</a>
						<?php } ?>
						<h1 class="uk-h4 uk-margin-small-top"><a class="uk-link-text" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						<span uk-icon="icon: commenting"></span> <a class="uk-link-reset" href="<?php the_permalink(); ?>#comments" rel="bookmark"><?php comments_number('0', '1', '%'); ?></a>
						<span uk-icon="icon: user"></span> <?php kap_views() ?>
					</div>
				</li>	            
		<?php endwhile;  wp_reset_postdata(); endif; ?>
		</ul>
	
		<?php pagenavi(); ?>
		
		
	</div>
</section>

<?php get_footer(); ?>
