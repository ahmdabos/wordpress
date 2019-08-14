<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://fi.com
 * @since      1.0.0
 * 
 * @package    Owl_Carousel_Slider
 * @subpackage Owl_Carousel_Slider/includes
 * @author     PressTigers <support@fi.com>
 */
class Owl_Carousel_Slider_i18n {

    /**
     * Load the plugin text domain for translation.
     *
     * @since   1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
                'owl-carousel-slider', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }

}