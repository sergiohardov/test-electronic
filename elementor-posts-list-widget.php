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
