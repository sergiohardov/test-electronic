<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Posts List Widget.
 */
class Elementor_Posts_List_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     */
    public function get_name()
    {
        return 'posts-list';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return esc_html__('Posts List', 'elementor-posts-list-widget');
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'eicon-post-list';
    }

    /**
     * Get custom help URL.
     */
    public function get_custom_help_url()
    {
        return 'https://developers.elementor.com/docs/widgets/';
    }

    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['general'];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords()
    {
        return ['posts', 'post', 'list'];
    }

    /**
     * Register posts list widget controls.
     */
    protected function register_controls()
    {
    }

    /**
     * Render posts list widget output on the frontend.
     */
    protected function render()
    {
    }
}
