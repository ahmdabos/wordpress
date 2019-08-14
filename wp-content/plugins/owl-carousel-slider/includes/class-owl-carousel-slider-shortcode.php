<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Owl_Carousel_Slider_Shortcode Class
 *
 * This file contains shortcode of 'oc_slider' post type.
 *
 * @link       http://fi.com
 * @since      1.0.0
 *
 * @package    Owl_Carousel_Slider
 * @subpackage Owl_Carousel_Slider/includes
 * @author     PressTigers <support@fi.com>
 */
class Owl_Carousel_Slider_Shortcode
{
    /**
     * Initialize the class and set it's properties.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        // Hook -> 'oc_slider_shortcode' Shortcode
        add_shortcode('oc_slider_shortcode', array($this, 'oc_slider'));

        // Hook -> 'edit_form_after_title' Shortcode
        add_action('edit_form_after_title', array($this, 'oc_slider_helper'));

        // Hook -> 'the_content' Shortcode
        add_filter( 'the_content', array($this, 'oc_slider_shortcode_empty_paragraph_fix'));
    }

    /**
     * Owl Carousel Slider Shortcode Implementation
     *
     * @param array $atts
     * @param string $content
     * @return string
     */
    public function oc_slider($atts, $content)
    {
        // Shortcode Default Array
        $shortcode_args = array(
            'id' => '',
            'items' => '1',
            'margin' => 0,
            'nav' => 'true',
            'loob' => 'true',
            'center' => 'true',
            'slideTransition' => 'linear',
            'lazyLoad' => 'true',
            'autoplay' => 'true',
            'autoplayTimeout' => 5000,
            'video' => 'false',
            'videoHeight' => '',
            'videoWidth' => '',
            'animateOut' => '',
            'animateIn' => '',

        );

        // Extract User Defined Shortcode Attributes
        $shortcode_args = shortcode_atts($shortcode_args, $atts);

        // Get Slider's Slides
        $image_files = get_post_meta( intval( $shortcode_args['id'] ), '_oc_slider', TRUE);
        $image_files = array_filter( explode(',', $image_files) );

        // OC
        $image_html = '<div id="oc-carousel-'.intval( $shortcode_args['id'] ).'" class="owl-carousel">';
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
        wp_enqueue_script('owl-carousel-slider-owl-carousel');
        ob_start();
        ?>
        <!-- Script Adding Settings/Attributes of Shortcode -->


        <script type="text/javascript">
            (function ($) {
                'use strict';
                $(document).ready(function ($) {
                    var owl = $("#oc-carousel-<?php echo intval( $shortcode_args['id'] );?>");
                    owl.owlCarousel({
                        items: <?php echo intval( $shortcode_args['items'] ); ?>,
                        margin: <?php echo intval( $shortcode_args['margin'] ); ?>,
                        nav: <?php echo intval( $shortcode_args['nav'] ); ?>,
                        loob: <?php echo intval( $shortcode_args['loob'] ); ?>,
                        center: <?php echo intval( $shortcode_args['center'] ); ?>,
                        slideTransition: <?php echo intval( $shortcode_args['slideTransition'] ); ?>,
                        lazyLoad: <?php echo intval( $shortcode_args['lazyLoad'] ); ?>,
                        autoplay: <?php echo intval( $shortcode_args['autoplay'] ); ?>,
                        autoplayTimeout: <?php echo intval( $shortcode_args['autoplayTimeout'] ); ?>,
                        video: <?php echo intval( $shortcode_args['video'] ); ?>,
                        videoHeight: <?php echo intval( $shortcode_args['videoHeight'] ); ?>,
                        videoWidth: <?php echo intval( $shortcode_args['videoWidth'] ); ?>,
                        animateOut: <?php echo intval( $shortcode_args['animateOut'] ); ?>,
                        animateIn: <?php echo intval( $shortcode_args['animateIn'] ); ?>,
                        responsive: {

                        }
                    });
                });
            })(jQuery);
        </script>
        <?php
        $image_html = ob_get_clean() . $image_html;

        return $image_html;
    }

    /**
     * OC Helper Function
     *
     * @since   1.0.0
     *
     * @global  object  $post   Post Object
     * @return  void
     */
    function oc_slider_helper()
    {
        global $post;
        if ($post->post_type != 'oc_slider')
            return;
        echo '<p>' . __('Paste this shortcode into a post or a page: ', 'owl-carousel-slider');
        echo '<strong>[oc_slider_shortcode id="'. intval( $post->ID ) .'"]</strong>';
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
    function oc_slider_shortcode_empty_paragraph_fix( $content )
    {
       $array = array(
           '<p>['    => '[',
           ']</p>'   => ']',
           ']<br />' => ']'
       );
       return strtr( $content, $array );
    }
}
new Owl_Carousel_Slider_Shortcode();