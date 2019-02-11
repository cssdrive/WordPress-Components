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
