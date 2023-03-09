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

        /**
         * Section: Posts selection method
         */
        $this->start_controls_section(
            'posts_selection_section',
            [
                'label' => esc_html__('Posts Selection Method', 'elementor-posts-list-widget'),
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

        $this->end_controls_section();



        /**
         * Section: Posts order
         */
        $this->start_controls_section(
            'posts_order_section',
            [
                'label' => esc_html__('Posts Order', 'elementor-posts-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                    'desc-public-date' => esc_html__('Descending publication date', 'elementor-posts-list-widget'),
                    'desc-number-views'  => esc_html__('Descending number of views', 'elementor-posts-list-widget'),
                ],
                'default' => 'desc-public-date'
            ]
        );

        $this->end_controls_section();



        /**
         * If select show variable "Auto"
         * 
         * Section: Posts count
         */
        $this->start_controls_section(
            'posts_count_section',
            [
                'label' => esc_html__('Posts Count', 'elementor-posts-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'posts_variables_control' => 'auto',
                ],
            ]
        );

        /**
         * Control: Posts count
         */
        $this->add_control(
            'posts_count',
            [
                'label' => esc_html__('Count', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('5', 'elementor-posts-list-widget'),
            ]
        );

        $this->end_controls_section();



        /**
         * If select show variable "Manually"
         * 
         * Section: Posts list
         */
        $this->start_controls_section(
            'posts_list_section',
            [
                'label' => esc_html__('Posts List', 'elementor-posts-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'posts_variables_control' => 'manually',
                ],
            ]
        );

        /**
         * Control: Posts list
         */
        $this->add_control(
            'posts_list_control',
            [
                'label' => esc_html__('Repeater List', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'list_title',
                        'label' => esc_html__('Title', 'elementor-posts-list-widget'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__('List Title', 'elementor-posts-list-widget'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'list_content',
                        'label' => esc_html__('Content', 'elementor-posts-list-widget'),
                        'type' => \Elementor\Controls_Manager::WYSIWYG,
                        'default' => esc_html__('List Content', 'elementor-posts-list-widget'),
                        'show_label' => false,
                    ],
                    [
                        'name' => 'list_color',
                        'label' => esc_html__('Color', 'elementor-posts-list-widget'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                    ]
                ],
                'default' => [
                    [
                        'list_title' => esc_html__('Title #1', 'elementor-posts-list-widget'),
                        'list_content' => esc_html__('Item content. Click the edit button to change this text.', 'elementor-posts-list-widget'),
                    ],
                    [
                        'list_title' => esc_html__('Title #2', 'elementor-posts-list-widget'),
                        'list_content' => esc_html__('Item content. Click the edit button to change this text.', 'elementor-posts-list-widget'),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render posts list widget output on the frontend.
     */
    protected function render()
    {
    }
}
