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
     * Help function for get posts list.
     */
    protected function get_posts_list($settings = ['count' => -1, 'order' => ['date' => 'desc']])
    {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $settings['count'],
            'orderby' => $settings['order']
        );

        $posts = get_posts($args);

        $posts_list = [];

        foreach ($posts as $post) {
            $posts_list[$post->ID] = $post->post_title;
        }

        return $posts_list;
    }


    /**
     * Help function for get posts content.
     */
    protected function get_posts_contents($id)
    {
        $post_content = [
            'title' => get_the_title($id),
            'permalink' => get_the_permalink($id),
            'excerpt' => get_the_excerpt($id),
            'thumbnail' => get_the_post_thumbnail_url($id),
            'date' => get_the_date('', $id),
            'author' => get_the_author($id)
        ];

        return $post_content;
    }



    /**
     * Register posts list widget controls.
     */
    protected function register_controls()
    {

        /**
         * Section: Posts List Section
         */
        $this->start_controls_section(
            'posts_selection_section',
            [
                'label' => esc_html__('Posts Lists', 'elementor-posts-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        /**
         * Control: Posts show variables
         */
        $this->add_control(
            'posts_variables_control',
            [
                'label' => esc_html__('Choose the method', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'auto' => [
                        'title' => esc_html__('Auto', 'elementor-posts-list-widget'),
                        'icon' => 'eicon-preview-medium',
                    ],
                    'manually' => [
                        'title' => esc_html__('Manually', 'elementor-posts-list-widget'),
                        'icon' => 'eicon-edit',
                    ],
                ],
                'default' => 'auto',
                'toggle' => false,
            ]
        );

        /**
         * Control: Posts order
         */
        $this->add_control(
            'posts_order_control',
            [
                'label' => esc_html__('Order', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'date-desc' => esc_html__('Descending publication date', 'elementor-posts-list-widget'),
                    'date-asc' => esc_html__('Asc publication date', 'elementor-posts-list-widget'),
                    'views-desc'  => esc_html__('Descending number of views', 'elementor-posts-list-widget'),
                ],
                'default' => 'date-desc'
            ]
        );

        /**
         * If select show variable "Auto"
         * 
         * Control: Posts count
         */
        $this->add_control(
            'posts_count',
            [
                'label' => esc_html__('Count', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('5', 'elementor-posts-list-widget'),
                'condition' => [
                    'posts_variables_control' => 'auto',
                ],
            ]
        );


        /**
         * If select show variable "Manually"
         * 
         * Control: Posts list
         */

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'posts_list_control',
            array(
                'label' => __('Choose the post', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_posts_list(),
            )
        );

        $this->add_control(
            'posts_list',
            array(
                'label' => __('Posts List', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => array(),
                'condition' => [
                    'posts_variables_control' => 'manually',
                ],
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render posts list widget output on the frontend.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $postsVariable = $settings['posts_variables_control'];

        if ($postsVariable === 'auto') {

            $postCount = $settings['posts_count'];
            $postOrder = explode('-', $settings['posts_order_control']);

            $args = [
                'count' => $postCount,
                'order' => [
                    $postOrder[0] => $postOrder[1]
                ]
            ];

            echo '<pre>';
            var_dump($this->get_posts_list($args));
            echo '</pre>';
        }


        if ($postsVariable === 'manually') {

            foreach ($settings['posts_list'] as $post) {
                echo '<pre>';
                var_dump($this->get_posts_contents($post['posts_list_control']));
                echo '</pre>';
            }
        }
    }
}
