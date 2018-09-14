<!-------------------------------------------------------------------
  Вариант 1
-------------------------------------------------------------------->

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>
<ul class="uk-list">
	<li class="page_item">
		<form role="search" method="get" class="uk-search uk-search-default uk-width-1-1" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="uk-form-label" for="<?php echo $unique_id; ?>"><span class="screen-reader-text"><?php echo _x( 'Search for: %s', 'label', 'monopixel' ); ?></span></label>
		    <div class="uk-form-controls">
			    <span class="uk-search-icon-flip" uk-search-icon><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'monopixel' ); ?></span></span>
				<input id="<?php echo $unique_id; ?>" class="uk-search-input" type="search" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'monopixel' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
		    </div>
		</form>
	</li>
</ul>

<!-------------------------------------------------------------------
  Вариант 2
-------------------------------------------------------------------->

<form class="searchform uk-width-1-1" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<div class="uk-grid-small uk-flex-middle uk-flex-center" uk-grid>
		<div class="uk-width-expand@s">
			<input class="search-input uk-input uk-width-1-1" type="text" value="<?php echo get_search_query(); ?>" name="s"  autofocus>
		</div>
		<div class="uk-width-auto">
			<?php select_cats(); ?>
		</div>
		<div class="uk-width-auto">
			<input class="search-button uk-button" type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>">
			<input type="hidden" value="post" name="post_type" id="post_type" />
		</div>
	</div>
</form>

<?//php select_cats('include=21,23,24'); ?>