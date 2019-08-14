<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Owl_Carousel_Slider_Post_Type Class
 * 
 * This class is used to create custom post type for oc slider.
 *
 * @link        http://fi.com
 * @since       1.0.0
 *
 * @package     Owl_Carousel_Slider
 * @subpackage  Owl_Carousel_Slider/includes
 * @author      PressTigers <support@fi.com>
 */
class Owl_Carousel_Slider_Post_Type
{
    /**
     * Initialize the class and set it's properties.
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        // Add Hook into the 'init()' Action
        add_action('init', array($this, 'owl_carousel_slider_init'));

        // Add Hook into the 'init()' action
        add_action('admin_init', array($this, 'owl_carousel_slider_admin_init'));
    }

    /**
     * WordPress core launches at 'init' points
     *          
     * @since   1.0.0
     */
    public function owl_carousel_slider_init()
    {
        $this->create_post_type();

        // Flush Rewrite Rules 
        flush_rewrite_rules();
    }

    /**
     * Create_post_type function.
     *
     * @since   1.0.0
     */
    public function create_post_type()
    {
        if (post_type_exists("oc_slider"))
            return;

        /**
         * Post Type -> oc_slider
         */
        $singular = __('Slider', 'owl-carousel-slider');
        $plural = __('Sliders', 'owl-carousel-slider');

        $rewrite = array(
            'slug' => _x('oc', 'OC permalink - resave permalinks after changing this', 'owl-carousel-slider'),
            'with_front' => FALSE,
            'feeds' => FALSE,
            'pages' => FALSE,
            'hierarchical' => FALSE,
        );

        // Post Type -> OC Slider -> Labels
        $slider_labels = array(
            'name' => $plural,
            'singular_name' => $singular,
            'menu_name' => __('Owl Carousel Slider', 'owl-carousel-slider'),
            'all_items' => sprintf(__('All %s', 'owl-carousel-slider'), $plural),
            'add_new' => __('Add New', 'owl-carousel-slider'),
            'add_new_item' => sprintf(__('Add %s', 'owl-carousel-slider'), $singular),
            'edit' => __('Edit', 'owl-carousel-slider'),
            'edit_item' => sprintf(__('Edit %s', 'owl-carousel-slider'), $singular),
            'new_item' => sprintf(__('New %s', 'owl-carousel-slider'), $singular),
            'view' => sprintf(__('View %s', 'owl-carousel-slider'), $singular),
            'view_item' => sprintf(__('View %s', 'owl-carousel-slider'), $singular),
            'search_items' => sprintf(__('Search %s', 'owl-carousel-slider'), $plural),
            'not_found' => sprintf(__('No %s found', 'owl-carousel-slider'), $plural),
            'not_found_in_trash' => sprintf(__('No %s found in trash', 'owl-carousel-slider'), $plural),
            'parent' => sprintf(__('Parent %s', 'owl-carousel-slider'), $singular)
        );

        // Post Type -> OC Slider -> Arguments
        $slider_args = array(
            'labels' => $slider_labels,
            'description' => sprintf(__('This is where you can create and manage %s.', 'owl-carousel-slider'), $plural),
            'public' => TRUE,
            'show_ui' => TRUE,
            'capability_type' => 'post',
            'map_meta_cap' => TRUE,
            'publicly_queryable' => TRUE,
            'exclude_from_search' => TRUE,
            'hierarchical' => FALSE,
            'rewrite' => array(
                'slug' => _x('oc', 'OC permalink - resave permalinks after changing this', 'owl-carousel-slider'),
                'hierarchical' => TRUE,
                'with_front' => FALSE
            ),
            'query_var' => TRUE,
            'can_export' => TRUE,
            'supports' => array('title'),
            'has_archive' => TRUE,
            'show_in_nav_menus' => TRUE,
        );

        // Register OC Slider Post Type
        register_post_type("oc_slider", apply_filters("register_post_type_oc_slider", $slider_args));
    }

    /**
     * A function hook that the WP core launches at 'admin_init' points
     * 
     * @since   1.0.0
     */
    public function owl_carousel_slider_admin_init()
    {
        // Hook - Shortcode -> Add New Column
        add_filter('manage_oc_slider_posts_columns', array($this, 'oc_slider_columns'));

        // Hook - Shortcode -> Add Value to New Column
        add_action('manage_oc_slider_posts_custom_column', array($this, 'oc_slider_columns_value'));
    }

    /**
     * Add custom column for 'OC' shortcode
     *
     * @since   1.0.0
     * @param   $columns   Custom Column 
     *  
     * @return  $columns   Custom Column
     */
    public function oc_slider_columns($columns)
    {
        $columns['shortcode'] = __('Shortcode', 'owl-carousel-slider');
        return $columns;
    }

    /**
     * Add custom column's value
     *
     * @since   1.0.0
     * @param   $name   custom column's name
     *  
     * @return  void
     */
    public function oc_slider_columns_value($name)
    {
        global $post;
        switch ($name) {
            case 'shortcode':
                echo ' <b> [oc_slider_shortcode id="' . intval( $post->ID ) . '"] </b>';
                break;
        }
    }
}
new Owl_Carousel_Slider_Post_Type();