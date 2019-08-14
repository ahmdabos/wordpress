<?php if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Owl_Carousel_Slider_Meta_Box_Slider Class
 *
 * This file is used to define add or save meta box of oc_slider.
 *
 * @link       http://fi.com
 * @since      1.0.0
 *
 * @package    Owl_Carousel_Slider
 * @subpackage Owl_Carousel_Slider/admin/partials/meta-boxes
 * @author     PressTigers <support@fi.com>
 */
class Owl_Carousel_Slider_Meta_Box_Slider
{

    /**
     * The ID of this plugin.
     *
     * @since   1.0.0
     * @access  protected
     * @var     array $oc_slider_postmeta
     */
    protected $oc_slider_postmeta;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        global $post;

        // Creating Meta Box on Add New OC Slider Page
        $this->oc_slider_postmeta = array(
            'id' => 'simple_owl_metabox',
            'title' => __('Slides', 'owl-carousel-slider'),
            'context' => 'normal',
            'screen' => 'oc_slider',
            'priority' => 'high',
            'context' => 'normal',
            'callback' => 'oc_slider_output',
            'show_names' => TRUE,
            'closed' => FALSE,
        );

        // Add Hook into the 'admin_menu' Action
        add_action('add_meta_boxes', array($this, 'oc_create_meta_box'));

        // Add Hook into the 'save_post()' Action
        add_action('save_post_oc_slider', array($this, 'save_oc_slider'));
    }

    /**
     * Getter of oc_slider meta box.
     *
     * @since   1.0.0
     */
    public function get_oc_slider_postmeta()
    {
        return $this->oc_slider_postmeta;
    }

    /**
     * Create Meta Box
     *
     * @since   1.0.0
     */
    public function oc_create_meta_box()
    {
        $oc_post_meta = self::get_oc_slider_postmeta();
        add_meta_box(
            $oc_post_meta['id'],
            $oc_post_meta['title'],
            array($this, $oc_post_meta['callback']),
            $oc_post_meta['screen'],
            $oc_post_meta['context'],
            $oc_post_meta['priority']
        );
    }

    /**
     * Meta Box Output
     *
     * @param object $post Post Object
     * @since   1.0.0
     *
     */
    public static function oc_slider_output($post)
    {

        // Add a nonce field so we can check it for later.
        wp_nonce_field('oc_meta_box', 'oc_slider_meta_box_nonce');
        ?>

        <!-- Slider's slides -->
        <div id="oc-slider-slide-container">
            <ul class="oc-slides">
                <?php
                if (metadata_exists('post', $post->ID, '_oc_slider')) {
                    $oc_slider_slides = get_post_meta($post->ID, '_oc_slider', TRUE);
                } else {
                    $attachment_ids = get_posts(
                        'post_parent=' . $post->ID . '&'
                        . 'numberposts=-1&'
                        . 'post_type=attachment&'
                        . 'orderby=menu_order&'
                        . 'order=ASC&'
                        . 'post_mime_type=image&'
                        . 'fields=ids&'
                    );
                    $attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
                    $oc_slider_slides = implode(',', $attachment_ids);
                }

                $attachments = array_filter(explode(',', $oc_slider_slides));
                $update_meta = FALSE;
                $updated_gallery_ids = array();

                if (!empty($attachments)) {
                    foreach ($attachments as $attachment_id) {
                        $attachment = wp_get_attachment_image($attachment_id, 'thumbnail');
                        $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                        $attachment_meta = get_post($attachment_id);

                        // Skip Empty Attachment
                        if (empty($attachment)) {
                            $update_meta = TRUE;
                            continue;
                        }

                        echo '<li class="slide" data-attachment_id="' . esc_attr($attachment_id) . '">
                                ' . $attachment . '<br>
                                <input type="text" name="caption_' . $attachment_id . '"  value="' . $attachment_meta->post_excerpt . '"  placeholder="Caption"> 
                                <a href="#" class="delete tips" data-tip="' . esc_attr__('Delete Slide', 'owl-carousel-slider') . '"><i class="fa fa-times" aria-hidden="true"></i>
                              </a>
                        </li>';


                        // Rebuild IDs to be Saved
                        $updated_gallery_ids[] = $attachment_id;
                    }

                    // Update Soc Slider Meta to Set New Slide's IDs
                    if ($update_meta) {
                        update_post_meta($post->ID, '_oc_slider', implode(',', $updated_gallery_ids));
                    }
                }
                ?>
            </ul>
            <input type="hidden" id="oc_slider_slides" name="oc_slider_slides" value="<?php echo esc_attr($oc_slider_slides); ?>"/>
        </div>
        <p class="add_slide hide-if-no-js">
            <a href="#" data-choose="<?php esc_attr_e('Add Slide to Slider', 'owl-carousel-slider'); ?>"
               data-update="<?php esc_attr_e('Add to Slider', 'owl-carousel-slider'); ?>" data-delete="<?php esc_attr_e('Delete Slide', 'owl-carousel-slider'); ?>"
               data-text="<?php esc_attr_e('Delete', 'owl-carousel-slider'); ?>"><?php _e('Add Slide to Slider', 'owl-carousel-slider'); ?></a>
        </p>
        <?php
    }

    /**
     * Save Meta Box.
     *
     * @since   1.0.0
     */
    public static function save_oc_slider()
    {
        global $post;

        // Check Nonce Field
        if (!isset($_POST['oc_slider_meta_box_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['oc_slider_meta_box_nonce'], 'oc_meta_box')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post->ID)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post->ID)) {
                return;
            }
        }

        // Get Attachment's/Slide's IDs
        $attachment_ids = isset($_POST['oc_slider_slides']) ? array_filter(explode(',', $_POST['oc_slider_slides'])) : array();
        update_post_meta($post->ID, '_oc_slider', implode(',', $attachment_ids));

        foreach ($attachment_ids as $attachment_id) {

            $post_type_attachment_ = array(
                'ID' => $attachment_id,
                'post_excerpt' => $_POST['caption_' . $attachment_id],
            );

            // Update Excerpt of Post Type Attachment
            wp_update_post($post_type_attachment_);
        }

    }
}