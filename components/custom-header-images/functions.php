<?php

function cssdrive_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri( '/assets/images/header.png' ),
		'width'              => 2000,
		'height'             => 1200,
		'flex-width'         => true,
		'flex-height'        => true,
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header.png',
			'thumbnail_url' => '%s/assets/images/header.png',
			'description'   => __( 'Default Header Image', 'cssdrive' ),
		),
	) );
}
add_action( 'after_setup_theme', 'custom_header_setup' );



function video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="screen-reader-text">' . __( 'Play background video', 'cssdrive' ) . '</span>' . '<span uk-icon="icon:  play"></span>';
	$settings['l10n']['pause'] = '<span class="screen-reader-text">' . __( 'Pause background video', 'cssdrive' ) . '</span>' . '<span uk-icon="icon:  close"></span>';
	return $settings;
}
add_filter( 'header_video_settings', 'video_controls' );