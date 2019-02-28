<?php

// Работает только с версией ACF 8.0 и выше!

/* ------------------------------------------------------------------------------------------------
  Добавляем в Functions.php
------------------------------------------------------------------------------------------------ */

/**
 * Стили и скрипты для Gutenberg Editor.
 */
function my_block_cgb_editor_assets() {
	wp_enqueue_style( 'uikit-style', get_theme_file_uri() . '/assets/uikit/css/uikit.min.css', null, '3.0.3' );
  wp_enqueue_script( 'uikit-script', get_theme_file_uri() . '/assets/uikit/js/uikit.min.js', array('jquery'), '3.0.3', false );
  wp_enqueue_script( 'uikit-icons-script', get_theme_file_uri() . '/assets/uikit/js/uikit-icons.min.js', null, '3.0.3', false );
}
add_action( 'enqueue_block_editor_assets', 'my_block_cgb_editor_assets' );


/**
 * Подключаем добавление шаблонов.
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
 * Создаем произволную Категорию в Gutenberg.
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
 * Создаем произвольные блоки в Gutenberg.
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
		));
		
		// register a Youtube block
		acf_register_block(array(
			'name'				=> 'youtube',
			'title'				=> __('YouTube'),
			'description'		=> __('A custom YouTube block.'),
			'render_callback'	=> 'my_acf_block_render_callback',
			'category'			=> 'formatting',
			'icon'				=> 'video-alt3',
			'keywords'			=> array( 'youtube', 'video' ),
		));
		
	}
}
add_action('acf/init', 'my_acf_init');



/* ------------------------------------------------------------------------------------------------
  Зозадем папку /template-parts/block/content-{Название вашего блока}.php
------------------------------------------------------------------------------------------------ */

<?php
/**
 * Block Name: Testimonial
 *
 * This is the template that displays the testimonial block.
 */

// get image field (array)
$avatar = get_field('avatar');

// create id attribute for specific styling
$id = 'testimonial-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<div id="<?php echo $id; ?>" class="testimonial <?php echo $align_class; ?>">
    <p><?php the_field('testimonial'); ?></p>
    <cite>
    	<img src="<?php echo $avatar['url']; ?>" alt="<?php echo $avatar['alt']; ?>" />
    	<span><?php the_field('author'); ?></span>
    </cite>
</div>

<style type="text/css">
	#<?php echo $id; ?> {
		background: <?php the_field('background_color'); ?>;
		color: <?php the_field('text_color'); ?>;
	}
</style>



/* ------------------------------------------------------------------------------------------------
  В ACF добавляем новый блок и указываем его принадлежность | Блок -> Ваш Gutenberg Блок
------------------------------------------------------------------------------------------------ */
