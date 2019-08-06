<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Simple_Owl_Carousel_Shortcode Class
 *
 * This file contains shortcode of 'soc_slider' post type. 
 * 
 * @link       http://presstigers.com
 * @since      1.0.0
 * 
 * @package    Simple_Owl_Carousel
 * @subpackage Simple_Owl_Carousel/includes                
 * @author     PressTigers <support@presstigers.com>
 */

class Simple_Owl_Carousel_Shortcode
{
    /**
     * Initialize the class and set it's properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        // Hook -> 'soc_slider_shortcode' Shortcode
        add_shortcode('soc_slider_shortcode', array($this, 'soc_slider'));

        // Hook -> 'edit_form_after_title' Shortcode
        add_action('edit_form_after_title', array($this, 'soc_slider_helper'));
        
        // Hook -> 'the_content' Shortcode
        add_filter( 'the_content', array($this, 'soc_slider_shortcode_empty_paragraph_fix'));
    }

    /**
     * Simple Owl Carousel Shortcode Implementation
     * 
     * @param array $atts
     * @param string $content
     * @return string
     */
    public function soc_slider($atts, $content)
    {
        // Shortcode Default Array
        $shortcode_args = array(
            'id' => '',
            'items' => 4,
            'navigation' => 'true',
            'single_item' => 'false',
            'slide_speed' => 300,
            'lazy_load'   => 'false',
            'auto_height' => 'true',
        );

        // Extract User Defined Shortcode Attributes
        $shortcode_args = shortcode_atts($shortcode_args, $atts);

        // Get Slider's Slides
        $image_files = get_post_meta( intval( $shortcode_args['id'] ), '_soc_slider', TRUE);
        $image_files = array_filter( explode(',', $image_files) );
        
        // SOC
        $image_html = '<div id="soc-carousel-'.intval( $shortcode_args['id'] ).'" class="owl-carousel">';
        foreach ($image_files as $file) {
            $alt = get_post_meta($file, '_wp_attachment_image_alt', true);
            $attachment_url = wp_get_attachment_url($file, 'thumbnail');
            $attachment_meta = get_post($file);
            
            $image_html .= '<div class="item">';
            if( "true" !== $shortcode_args['lazy_load'] ){
                $image_html .= '<img src="'. esc_url( $attachment_url ) .'" alt="'. esc_attr( $attachment_meta->post_title ) .'">';
            } else {
                $image_html .= '<img class="lazyOwl" data-src="'. esc_url( $attachment_url ) .'"  alt="'. esc_attr( $attachment_meta->post_title ) .'">';
            }
            if( !empty( $attachment_meta->post_excerpt ) ) {
                $image_html .= '<p class="text-center">'. wp_kses_data( $attachment_meta->post_excerpt ) .'</p>';
            }
            $image_html .= '</div>';
        }
        $image_html .= '</div>';
        wp_enqueue_script('simple-owl-carousel-owl-carousel');
        ob_start();
        ?>
        <!-- Script Adding Settings/Attributes of Shortcode -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>

        <script type="text/javascript">
            (function ($) {
                'use strict';
                $(document).ready(function ($) {
                    var owl = $("#soc-carousel-<?php echo intval( $shortcode_args['id'] );?>");
                    owl.owlCarousel({

                        // Most important owl features
                        items: <?php echo intval( $shortcode_args['items'] ); ?>,
                        singleItem: <?php echo esc_attr( $shortcode_args['single_item'] ); ?>,
                        itemsScaleUp: true,

                        // Basic Speeds
                        slideSpeed: <?php echo intval( $shortcode_args['slide_speed'] ); ?>,

                        // Navigation
                        navigation: <?php echo esc_attr( $shortcode_args['navigation'] ); ?>,

                        // Lazy load
                        lazyLoad :  <?php echo esc_attr( $shortcode_args['lazy_load'] ); ?>,

                        // Auto height
                        autoHeight: <?php echo esc_attr( $shortcode_args['auto_height'] ); ?>,
                    });
                });
            })(jQuery);
        </script>
        <?php
        $image_html = ob_get_clean() . $image_html;
        
        return $image_html;
    }

    /**
     * SOC Helper Function
     * 
     * @since   1.0.0
     * 
     * @global  object  $post   Post Object
     * @return  void
     */
    function soc_slider_helper()
    {
        global $post;
        if ($post->post_type != 'soc_slider')
            return;
        echo '<p>' . __('Paste this shortcode into a post or a page: ', 'simple-owl-carousel');
        echo '<strong>[soc_slider_shortcode id="'. intval( $post->ID ) .'"]</strong>';
        echo '</p>';
    }
    
    /**
     * Filters the content to remove any extra paragraph or break tags
     * caused by shortcodes.
     *
     * @since   1.0.0
     *
     * @param   string $content  String of HTML content.
     * @return  string $content Amended string of HTML content.
     */
    function soc_slider_shortcode_empty_paragraph_fix( $content )
    {
       $array = array(
           '<p>['    => '[',
           ']</p>'   => ']',
           ']<br />' => ']'
       );
       return strtr( $content, $array );
    }
}
new Simple_Owl_Carousel_Shortcode();