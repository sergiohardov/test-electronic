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
     * Depends style widget.
     */
    public function get_style_depends()
    {
        return array('elementor-posts-list-widget');
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
        return ['posts', 'post', 'list', 'blog'];
    }


    /**
     * Helpers: Function for get posts list.
     */
    protected function get_posts_list($settings = ['count' => -1, 'order' => 'date-desc'])
    {

        $order = explode('-', $settings['order']);

        if ($order[0] === 'post_views') {
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $settings['count'],
                'meta_key' => $order[0],
                'orderby' => 'meta_value_num',
                'order' => $order[1],
            );
        } else {
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $settings['count'],
                'orderby' => [
                    $order[0] => $order[1]
                ]
            );
        }


        $posts = get_posts($args);

        $posts_list = [];

        foreach ($posts as $post) {
            $posts_list[$post->ID] = $post->post_title;
        }

        return $posts_list;
    }

    /**
     * Helpers: Function for get posts content.
     */
    protected function get_posts_contents($id)
    {
        $posts_content = [
            'title' => get_the_title($id),
            'permalink' => get_the_permalink($id),
            'excerpt' => get_the_excerpt($id),
            'thumbnail' => get_the_post_thumbnail_url($id),
            'date' => get_the_date('', $id),
            'author' => get_the_author($id),

            'views' => get_post_meta($id, 'post_views', true)
        ];

        return $posts_content;
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
            'posts_list_section',
            [
                'label' => __('Posts Lists', 'elementor-posts-list-widget'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        /**
         * Control: Posts select show method
         */
        $this->add_control(
            'posts_show_method',
            [
                'label' => __('Choose the method', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'auto' => [
                        'title' => __('Auto', 'elementor-posts-list-widget'),
                        'icon' => 'eicon-preview-medium',
                    ],
                    'manually' => [
                        'title' => __('Manually', 'elementor-posts-list-widget'),
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
            'posts_order',
            [
                'label' => __('Order', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'date-desc' => __('Descending publication date', 'elementor-posts-list-widget'),
                    'post_views-desc'  => __('Descending number of views', 'elementor-posts-list-widget'),
                ],
                'label_block' => true,
                'default' => 'date-desc'
            ]
        );

        /**
         * If select show method "Auto"
         * 
         * Control: Posts count
         */
        $this->add_control(
            'posts_count',
            [
                'label' => __('Count', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('5', 'elementor-posts-list-widget'),
                'condition' => [
                    'posts_show_method' => 'auto',
                ],
            ]
        );


        /**
         * If select show method "Manually"
         * 
         * Control: Posts list
         */

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'posts_select_control',
            array(
                'label' => __('Choose the post', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_posts_list(),
                'label_block' => true,
            )
        );

        $this->add_control(
            'posts_list',
            array(
                'label' => __('List', 'elementor-posts-list-widget'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => 'Post ID# {{{ posts_select_control }}}',
                'default' => [],
                'condition' => [
                    'posts_show_method' => 'manually',
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

        $postsShowMethod = $settings['posts_show_method'];
        $postsId = [];

        switch ($postsShowMethod) {
            case 'auto':
                $postsId = [];

                $posts = $this->get_posts_list([
                    'count' => $settings['posts_count'],
                    'order' => $settings['posts_order']
                ]);

                $postsId = array_keys($posts);
                break;

            case 'manually':
                $postsId = [];

                foreach ($settings['posts_list'] as $item) {
                    $postsId[] = $item['posts_select_control'];
                }
                break;

            default:
                echo "Something wrong...";
                break;
        } ?>

        <div class="elementor-posts-list-widget">

            <?php foreach ($postsId as $id) { ?>

                <?php $post = $this->get_posts_contents($id); ?>

                <div class="elementor-posts-list-item">
                    <span class="elementor-posts-list-author"><?php echo $post['author']; ?></span>
                    <img class="elementor-posts-list-image" src="<?php echo $post['thumbnail']; ?>" alt="">
                    <div class="elementor-posts-list-content">
                        <a href="<?php echo $post['permalink']; ?>">
                            <h2 class="elementor-posts-list-title"><?php echo $post['title']; ?></h2>
                        </a>
                        <p class="elementor-posts-list-excerpt"><?php echo $post['excerpt']; ?></p>

                        <div class="elementor-posts-list-footer">

                            <div class="elementor-posts-list-views">
                                <img src="<?php echo plugin_dir_url(__DIR__) . 'assets/img/eye.svg'; ?>" alt="Eye icon">
                                <span><?php echo $post['views'] ?></span>
                            </div>

                            <span class="elementor-posts-list-date"><?php echo $post['date']; ?></span>

                            <a class="elementor-posts-list-more" href="<?php echo $post['permalink']; ?>">Read More...</a>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
<?php }
}
