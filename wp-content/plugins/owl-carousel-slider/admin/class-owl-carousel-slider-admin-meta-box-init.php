<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Owl_Carousel_Slider_Admin_Meta_Box_Init Class
 * 
 * @link       http://fi.com
 * @since       1.0.0
 *
 * @package     Owl_Carousel_Slider
 * @subpackage  Owl_Carousel_Slider/admin
 * @author      PressTigers <support@fi.com>
 */

class Owl_Carousel_Slider_Admin_Meta_Box_Init {

    /**
     * Initialize the class and set it's properties.
     *
     * @since   1.0.0
     */
    public function __construct() {

        //Including Meta Box of 'oc_slider' Custom Post Type
        require_once plugin_dir_path(__FILE__) . 'partials/meta-boxes/class-owl-carousel-slider-meta-box-slider.php';

        // Check If OC's Meta Box Class Exists
        if (class_exists('Owl_Carousel_Slider_Meta_Box_Slider')) {

            // Initialize OC's Meta Box Slider Class Object
            new Owl_Carousel_Slider_Meta_Box_Slider();
        }
    }

}

new Owl_Carousel_Slider_Admin_Meta_Box_Init();