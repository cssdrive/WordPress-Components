<?php

function my_acf_flexible_content_layout_title( $title, $field, $layout, $i ) {
	
	// remove layout title from text
	$title = '';
	
	
	// load sub field image
	// note you may need to add extra CSS to the page t style these elements
	$title .= '<div class="thumbnail">';
	
	if( $image = get_sub_field('image') ) {
		
		$title .= '<img src="' . $image['sizes']['thumbnail'] . '" height="36px" />';
		
	}
	
	$title .= '</div>';
	
	
	// load text sub field
	if( $text = get_sub_field('text') ) {
		
		$title .= '<h4>' . $text . '</h4>';
		
	}
	
	
	// return
	return $title;
	
}

// name
add_filter('acf/fields/flexible_content/layout_title/name=my_flex_field', 'my_acf_flexible_content_layout_title', 10, 4);

?>
