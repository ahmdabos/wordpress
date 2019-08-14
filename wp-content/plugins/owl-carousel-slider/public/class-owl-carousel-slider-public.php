<?php
/**
 * The public-facing functionality of the plugin.
 * 
 * @link       http://fi.com
 * @since      1.0.0
 *
 * @package    Owl_Carousel_Slider
 * @subpackage Owl_Carousel_Slider/public
 * @author     PressTigers <support@fi.com>
 */
class Owl_Carousel_Slider_Public
{
    /**
     * The ID of this plugin.
     *
     * @since   1.0.0
     * @access  private
     * @var     string     $plugin_name    The ID of this plugin.
     */
    private $owl_carousel_slider;

    /**
     * The version of this plugin.
     *
     * @since   1.0.0
     * @access  private
     * @var     string      $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set it's properties.
     *
     * @since   1.0.0
     * @param   string  $plugin_name    The name of the plugin.
     * @param   string  $version        The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->owl_carousel_slider = $plugin_name;
        $this->version = $version;

        /**
         * The class is responsible for defining the post type 'oc_slider'.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-owl-carousel-slider-post-type.php';

        /**
         * The class is responsible for defining all shortcode of the OC slider
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-owl-carousel-slider-shortcode.php';
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since   1.0.0
     */




    public function enqueue_styles()
    {
        wp_enqueue_style($this->owl_carousel_slider, plugin_dir_url(__FILE__) . 'css/owl-carousel-slider-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script('jquery', plugin_dir_url(__FILE__) . 'js/jquery-2.2.4.min.js', array(''), '2.2.4', TRUE);
        wp_enqueue_script('owl-carousel', plugin_dir_url(__FILE__) . 'js/owl.carousel.min.js', array('jquery'), '2.3.4', TRUE);
    }









}