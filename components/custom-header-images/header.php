<!-------------------------------------------------------------------
  Custom Header Images
-------------------------------------------------------------------->

<?php if ( has_header_image( 'custom-header' ) ) : ?>
	<div class="custom-header">
		<div class="custom-header-media">
			<div class="embed-container"><?php the_custom_header_markup(); ?></div>
		</div>
	</div>

	<?php if ( is_front_page() ) : ?>
		<?php $header_image = get_header_image();  if ( ! empty( $header_image ) ) { ?>
			<div class="custom-header">
				<div class="custom-header-media uk-inline"> 
					<div id="wp-custom-header" class="uk-cover-container uk-height-large">
						<canvas width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>"></canvas>
		
						<?php if( has_header_video() && is_header_video_active() ){ ?>
							<div class="embed-container">
								<video autoplay loop muted playsinline uk-video="automute: true; autoplay: true;" uk-cover>
						        	<source src="<?php the_header_video_url() ?>" type="video/mp4">
						    	</video>
							</div>
					    <?php } else { ?>	
							<img src="<?php header_image(); ?>" alt="" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" uk-cover>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	
	<?php else : ?>
		
		<?php $header_image = get_header_image();  if ( ! empty( $header_image ) ) { ?>
			<div class="custom-header">	
				<div class="custom-header-media uk-cover-container uk-height-small">
			    	<div id="wp-custom-header" class="wp-custom-header">
			            <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" uk-cover>
			        </div>
					
					<div class="uk-overlay-primary uk-position-cover"></div>
				</div>
			</div>
		<?php } ?>
	<?php endif; ?>
<?php endif; ?>