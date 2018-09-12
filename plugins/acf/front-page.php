<!-- Вывод миниатюр -->
<?php if ( get_field( 'thumbnail') ) { ?>
  <img src="<?php the_field( 'thumbnail' ); ?>" class="attachment-post-thumbnail size-post-thumbnail">
<?php } ?>
