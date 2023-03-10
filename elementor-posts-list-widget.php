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
 * Register Posts List Styles.
 */
function register_posts_list_frontend_stylesheets()
{
	wp_register_style('elementor-posts-list-widget', plugins_url('assets/css/styles.css', __FILE__));
}
add_action('elementor/frontend/before_enqueue_styles', 'register_posts_list_frontend_stylesheets');



/**
 * When activating the plugin, 
 * for all existing posts that do not have post_views, 
 * set the default value to 0
 */
function set_empty_post_views()
{
	$posts = get_posts([
		'post_type' => 'post',
		'posts_per_page' => -1,
		'fields' => 'ids',
	]);

	foreach ($posts as $post_id) {
		$post_views = get_post_meta($post_id, 'post_views', true);

		if (empty($post_views)) {
			update_post_meta($post_id, 'post_views', 0);
		}
	}
}

register_activation_hook(__FILE__, 'set_empty_post_views');


/**
 * For posts that have been created or saved but without a post_views value, 
 * set the default value to 0
 */
function save_post_views($post_id)
{
	$post_views = get_post_meta($post_id, 'post_views', true);

	if ($post_views < 1) {
		$post_views = 0;
		update_post_meta($post_id, 'post_views', $post_views);
	}
}

add_action('save_post', 'save_post_views');


/**
 * For posts to which the user goes, 
 * the post_views counter is increased by 1
 */
function set_post_views()
{
	if (is_single()) {
		$post_id = get_queried_object_id();
		$post_views = get_post_meta($post_id, 'post_views', true);

		$post_views++;

		update_post_meta($post_id, 'post_views', $post_views);
	}
}

add_action('wp_head', 'set_post_views');
