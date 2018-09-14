<?php if ( is_front_page() ) : ?>
	<?php if ( have_rows( 'header-slider', 'option' ) ) : ?>
		<div class="header-slider uk-margin-medium-bottom" uk-slider="center: true; autoplay: true; pause-on-hover: true;">
			<div class="uk-position-relative">
				<div class="uk-slider-container uk-border-rounded">
					<ul class="uk-slider-items uk-child-width-1-1">
						<?php while ( have_rows( 'header-slider', 'option' ) ) : the_row(); ?>
							<li>
								<?php if ( get_sub_field( 'header-slider-images' ) ) { ?><img src="<?php the_sub_field( 'header-slider-images' ); ?>" /><?php } ?>
								<div class="uk-position-left uk-light uk-flex uk-flex-<?php the_sub_field( 'header-slider-position' ); ?> uk-flex-middle uk-panel uk-text-center uk-width-1-1">
									<div class="uk-width-1-2@m">
										<h1 class="uk-heading-primary" style="color: <?php the_sub_field( 'header-slider-title-color' ); ?>;" uk-slider-parallax="x: 100,-100"><?php the_sub_field( 'header-slider-title' ); ?></h1>
										<a class="uk-button uk-border-rounded" style="background: <?php the_sub_field( 'header-slider-button-color' ); ?>;" uk-slider-parallax="x: 200,-200" href="<?php the_sub_field( 'header-slider-button-link' ); ?>"><?php the_sub_field( 'header-slider-button' ); ?></a>
		                    		</div>
		                		</div>
							</li>
						<?php endwhile; ?>
					</ul>
	    		</div>
				<div class="uk-light">
					<a class="uk-position-center-left uk-position-small uk-overlay uk-overlay-primary uk-border-rounded" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
					<a class="uk-position-center-right uk-position-small uk-overlay uk-overlay-primary uk-border-rounded" href="#" uk-slidenav-next uk-slider-item="next"></a>
	    		</div>
			</div>
			<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin-top"></ul>	
		</div>
	<?php else : ?>
		<?php // no rows found ?>
	<?php endif; ?>
<?php endif; ?>