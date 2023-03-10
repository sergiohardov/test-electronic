<?php

/**
 * Plugin Name: Elementor Posts List Widget
 * Description: Output to the page of a list of posts sorted by a given criterion.
 * Version:     1.0.0
 * Author:      Pivovar Serhii
 * Author URI:  https://developers.elementor.com/
 * Text Domain: elementor-posts-list-widget
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Register Posts List Widget.
 */
function register_posts_list_widget($widgets_manager)
{
	require_once(__DIR__ . '/widgets/posts-list-widget.php');

	$widgets_manager->register(new \Elementor_Posts_List_Widget());
}
add_action('elementor/widgets/register', 'register_posts_list_widget');


/**
 * Register styles.
 */
function register_posts_list_frontend_stylesheets()
{
	wp_register_style('elementor-posts-list-widget', plugins_url('assets/css/styles.css', __FILE__));
}
add_action('elementor/frontend/before_enqueue_styles', 'register_posts_list_frontend_stylesheets');



/**
 * Draft Function set post views
 */
function set_post_views()
{
	if (is_single()) {
		$post_id = get_queried_object_id();
		$post_views = get_post_meta($post_id, 'post_views', true);

		if ($post_views == '') {
			$post_views = 0;
		}

		$post_views++;

		update_post_meta($post_id, 'post_views', $post_views);
	}
}

add_action('wp_head', 'set_post_views');
