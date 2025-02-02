<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [] );
	
	wp_enqueue_script( 'stein-custom', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), true );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 20 );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

add_filter('wpcf7_autop_or_not', '__return_false');


/**
 * Custom Short Codes
 */

require get_stylesheet_directory() . '/inc/shortcodes.php';

