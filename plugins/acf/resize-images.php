<?php 

$image = get_sub_field('news-block-images');

if( !empty($image) ): 

	// vars
	$url = $image['url'];
	$title = $image['title'];
	$alt = $image['alt'];
	$caption = $image['caption'];

	// thumbnail
	$thumb = $image['sizes']['cover-small']; /* Размер 1 */
	$medium = $image['sizes']['cover-medium']; /* Размер 2 */
	$width = $image['sizes'][ $size . '-width' ];
	$height = $image['sizes'][ $size . '-height' ];

	if( $caption ): ?>

		<div class="wp-caption">

	<?php endif; ?>

	<a href="<?php echo $medium; ?>" title="<?php echo $title; ?>">

		<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />

	</a>

	<?php if( $caption ): ?>

			<p class="wp-caption-text"><?php echo $caption; ?></p>

		</div>

	<?php endif; ?>

<?php endif; ?>







<div class="uk-margin-medium" uk-lightbox>			
<?php $image = get_sub_field('news-block-images');

	if( !empty($image) ): 

	// vars
	$url = $image['url'];
	$title = $image['title'];
	$alt = $image['alt'];
	$caption = $image['caption'];
	$description = $image['description'];

	// thumbnail
	$thumb = $image['sizes']['cover-small'];
	$medium = $image['sizes']['cover-medium'];
?>

	<?php if ( get_sub_field( 'news-block-images-zoom' ) == 1 ) { ?>

		<a href="<?php echo $url ?>" title="<?php echo $title; ?>">

			<div class="uk-width-1-1 uk-inline-clip uk-transition-toggle" tabindex="0">

				<img width="960" height="540" src="<?php echo $medium; ?>" class="uk-width-1-1 uk-border-rounded" alt="" srcset="<?php echo $medium; ?> 960w, <?php echo $thumb; ?> 640w, <?php echo $thumb; ?> 768w" sizes="(max-width: 960px) 100vw, 960px" uk-img>

				<div class="uk-transition-fade uk-position-top-right uk-overlay">
					<span class="uk-icon-button" uk-icon="icon: expand;"></span>
				</div>
				<?php if( $caption ): ?>
					<div class="uk-position-bottom uk-overlay uk-overlay-secondary uk-light">
				<?php echo $caption; ?>
			    </div>
		    <?php endif; ?>
			</div>

		</a>

	<?php } else { ?>

		<?php if( $caption ): ?>
			<div class="uk-width-1-1 uk-inline-clip uk-transition-toggle" tabindex="0">
		<?php endif; ?>
		<img class="uk-width-1-1" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>">
		<?php if( $caption ): ?>
			<div class="uk-position-bottom uk-overlay uk-overlay-secondary uk-light">
			<?php echo $caption; ?>
		    </div>
			</div>
		<?php endif; ?>

	<?php } ?>

<?php endif; ?>
</div>
