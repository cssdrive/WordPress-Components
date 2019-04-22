<?php

// Only works with ACF version 8.0 and higher!

/* ------------------------------------------------------------------------------------------------
  add in Block.php
------------------------------------------------------------------------------------------------ */
acf_register_block_type(array(
	//'enqueue_style'	=> get_template_directory_uri() . '/css/uikit.min.css',
	//'enqueue_script'	=> get_template_directory_uri() . '/js/uikit.min.js',	
));

/**
 * Register Style and Scripts
 */

function enqueue_assets(){
	wp_enqueue_style( 'uikit-style', get_theme_file_uri() . '/css/uikit.min.css', null, '3.0.3' );
	wp_enqueue_style( 'reset-style', get_theme_file_uri() . '/css/acf-uikit-gutenberg-block.css', null, time() );
	wp_enqueue_script( 'uikit-script', get_theme_file_uri() . '/js/uikit.min.js', array('jquery'), '3.0.3', false );
	wp_enqueue_script( 'uikit-icons-script', get_theme_file_uri() . '/js/uikit-icons.min.js', null, '3.0.3', false );
}
add_action( 'enqueue_block_editor_assets', 'enqueue_assets' );

/**
 * Register Template Block
 */
function my_acf_block_render_callback( $block ) {
	
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
	}
}

/**
 * Register Category in Gutenberg.
 */
if ( ! function_exists( 'fubon_block_category' ) ) {
	function fubon_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'fubon',
					'title' => __( 'Fubon Blocks', 'fubon' ),
				),
			)
		);
	}
	add_filter( 'block_categories', 'fubon_block_category', 10, 2 );
}

/**
 * Register Block in Gutenberg.
 */
function my_acf_init() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a Testimonial block
		acf_register_block(array(
			'name'				=> 'testimonial',
			'title'				=> __('Testimonial'),
			'description'		=> __('A custom testimonial block.'),
			'render_callback'	=> 'my_acf_block_render_callback',
			'category'			=> 'fubon',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'testimonial', 'quote' ),
			'mode'				=> 'auto', //preview,auto
		));
		
	}
}
add_action('acf/init', 'my_acf_init');



/* ------------------------------------------------------------------------------------------------
  CSS
------------------------------------------------------------------------------------------------ */

/*
	WP FIX
*/
.wp-person a:focus .gravatar, a:focus, a:focus .media-icon img {
    box-shadow: 0 0 0 0 #5b9dd9,0 0 2px 0px rgba(30,140,190,.0) !important;
    outline: none !important;
}

/*------------------------------------------------------------------
  Reset
-------------------------------------------------------------------*/

ul, li, ol {
	list-style: none !important;
}

/*------------------------------------------------------------------
  Accordion
-------------------------------------------------------------------*/

.uk-accordion > li {
	border: 1px solid #eeeeee;
	padding: 15px;
}
.uk-accordion > li.uk-open {
	border: 1px solid #1046e8;
}

/* Default */
.uk-accordion .uk-accordion-title {
	
}
.uk-accordion .uk-accordion-content {

}

/* Open */
.uk-accordion .uk-open .uk-accordion-title {
	color: #1046e8;
	border-bottom: 1px solid #1046e8;
	padding-bottom: 10px;
}
.uk-accordion .uk-open .uk-accordion-content {

}
