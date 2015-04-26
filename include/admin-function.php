<?php 

	// Add Image Size
	add_image_size( 'thumbnail_80*80',80 ,80 , true );
	add_image_size( 'thumbnail_50*50',50 ,50 , true );

function super_advanced_posts_scripts() {
	
	$mycss_file = plugins_url( 'css/super-advanced-posts.css',dirname(__FILE__) );
	 wp_register_style( 'super-advanced-posts', $mycss_file );
	        wp_enqueue_style( 'super-advanced-posts' );
}

add_action( 'wp_enqueue_scripts', 'super_advanced_posts_scripts' );