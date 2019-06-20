<?php

/*
  Plugin Name: fi slider
  Plugin URI: http://fi.ae
  Description: image slider for wp
  Version: 1.0
  Author: FI
  Author URI: http://fi.ae
  License: GPLv2 or later
 */

function fi_slider_activation() {

}

register_activation_hook(__FILE__, 'fi_slider_activation');

function fi_slider_deactivation() {

}

register_deactivation_hook(__FILE__, 'fi_slider_deactivation');


add_action('wp_enqueue_scripts', 'fi_scripts');

function fi_scripts() {
    global $post;

    wp_enqueue_script('jquery');

    wp_register_script('slidesjs_core', plugins_url('js/jquery.slides.min.js', __FILE__), array("jquery"));
    wp_enqueue_script('slidesjs_core');


    wp_register_script('slidesjs_init', plugins_url('js/slidesjs.initialize.js', __FILE__));
    wp_enqueue_script('slidesjs_init');

    $effect      = (get_option('fi_effect') == '') ? "slide" : get_option('fi_effect');
    $interval    = (get_option('fi_interval') == '') ? 2000 : get_option('fi_interval');
    $autoplay    = (get_option('fi_autoplay') == 'enabled') ? true : false;
    $playBtn    = (get_option('fi_playbtn') == 'enabled') ? true : false;
        $config_array = array(
            'effect' => $effect,
            'interval' => $interval,
            'autoplay' => $autoplay,
            'playBtn' => $playBtn
        );

    wp_localize_script('slidesjs_init', 'setting', $config_array);

}

add_action('wp_enqueue_scripts', 'fi_styles');

function fi_styles() {

    wp_register_style('slidesjs_example', plugins_url('css/example.css', __FILE__));
    wp_enqueue_style('slidesjs_example');
    wp_register_style('slidesjs_fonts', plugins_url('css/font-awesome.min.css', __FILE__));
    wp_enqueue_style('slidesjs_fonts');
}

add_shortcode("fi_slider", "fi_display_slider");

function fi_display_slider($attr, $content) {

    extract(shortcode_atts(array(
                'id' => ''
                    ), $attr));

    $gallery_images = get_post_meta($id, "_fi_gallery_images", true);
    $gallery_images = ($gallery_images != '') ? json_decode($gallery_images) : array();



    $plugins_url = plugins_url();


    $html = '<div class="container">
    <div id="slides">';

    foreach ($gallery_images as $gal_img) {
        if ($gal_img != "") {
            $html .= "<img src='" . $gal_img . "' />";
        }
    }

    $html .= '<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
      <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
    </div>
  </div>';

    return $html;
}

add_action('init', 'fi_register_slider');

function fi_register_slider() {
    $labels = array(
        'menu_name' => _x('Sliders', 'slidesjs_slider'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Slideshows',
        'supports' => array('title', 'editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type('slidesjs_slider', $args);
}

/* Define shortcode column in Rhino Slider List View */
add_filter('manage_edit-slidesjs_slider_columns', 'fi_set_custom_edit_slidesjs_slider_columns');
add_action('manage_slidesjs_slider_posts_custom_column', 'fi_custom_slidesjs_slider_column', 10, 2);

function fi_set_custom_edit_slidesjs_slider_columns($columns) {
    return $columns
    + array('slider_shortcode' => __('Shortcode'));
}

function fi_custom_slidesjs_slider_column($column, $post_id) {

    $slider_meta = get_post_meta($post_id, "_fi_slider_meta", true);
    $slider_meta = ($slider_meta != '') ? json_decode($slider_meta) : array();

    switch ($column) {
        case 'slider_shortcode':
            echo "[fi_slider id='$post_id' /]";
            break;
    }
}

add_action('add_meta_boxes', 'fi_slider_meta_box');

function fi_slider_meta_box() {

    add_meta_box("fwds-slider-images", "Slider Images", 'fi_view_slider_images_box', "slidesjs_slider", "normal");
}

function fi_view_slider_images_box() {
    global $post;

    $gallery_images = get_post_meta($post->ID, "_fi_gallery_images", true);
    // print_r($gallery_images);exit;
    $gallery_images = ($gallery_images != '') ? json_decode($gallery_images) : array();

    // Use nonce for verification
    $html = '<input type="hidden" name="fi_slider_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

    $html .= '<table class="form-table">';

    $html .= "
          <tr>
            <th style=''><label for='Upload Images'>Image 1</label></th>
            <td><input name='gallery_img[]' id='fi_slider_upload' type='text' value='" . $gallery_images[0] . "'  /></td>
          </tr>
          <tr>
            <th style=''><label for='Upload Images'>Image 2</label></th>
            <td><input name='gallery_img[]' id='fi_slider_upload' type='text' value='" . $gallery_images[1] . "' /></td>
          </tr>
          <tr>
            <th style=''><label for='Upload Images'>Image 3</label></th>
            <td><input name='gallery_img[]' id='fi_slider_upload' type='text'  value='" . $gallery_images[2] . "' /></td>
          </tr>
          <tr>
            <th style=''><label for='Upload Images'>Image 4</label></th>
            <td><input name='gallery_img[]' id='fi_slider_upload' type='text' value='" . $gallery_images[3] . "' /></td>
          </tr>
          <tr>
            <th style=''><label for='Upload Images'>Image 5</label></th>
            <td><input name='gallery_img[]' id='fi_slider_upload' type='text' value='" . $gallery_images[4] . "' /></td>
          </tr>          

        </table>";

    echo $html;
}

/* Save Slider Options to database */
add_action('save_post', 'fi_save_slider_info');

function fi_save_slider_info($post_id) {


    // verify nonce
    if (!wp_verify_nonce($_POST['fi_slider_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('slidesjs_slider' == $_POST['post_type'] && current_user_can('edit_post', $post_id)) {

        /* Save Slider Images */
        //echo "<pre>";print_r($_POST['gallery_img']);exit;
        $gallery_images = (isset($_POST['gallery_img']) ? $_POST['gallery_img'] : '');
        $gallery_images = strip_tags(json_encode($gallery_images));
        update_post_meta($post_id, "_fi_gallery_images", $gallery_images);

    } else {
        return $post_id;
    }
}

add_action('admin_menu', 'fi_plugin_settings');

function fi_plugin_settings() {
    //creecho ate new top-level menu
    add_menu_page('1stWD Slider Settings', '1stWD Slider Settings', 'administrator', 'fi_settings', 'fi_display_settings');
}

function fi_display_settings() {

    $slide_effect = (get_option('fi_effect') == 'slide') ? 'selected' : '';
    $fade_effect = (get_option('fi_effect') == 'fade') ? 'selected' : '';
    $interval = (get_option('fi_interval') != '') ? get_option('fi_interval') : '2000';
    $autoplay  = (get_option('fi_autoplay') == 'enabled') ? 'checked' : '' ;
    $playBtn  = (get_option('fi_playBtn') == 'enabled') ? 'checked' : '' ;

    $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>Select Your Settings</h2>' . wp_nonce_field('update-options') . '
            <table width="100%" cellpadding="10" class="form-table">
                <tr>
                    <td align="left" scope="row">
                    <label>Slider Effect</label><select name="fi_effect" >
                      <option value="slide" ' . $slide_effect . '>Slide</option>
                      <option value="fade" '.$fade_effect.'>Fade</option>
                    </select>
             

                    </td> 
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Enable Auto Play</label><input type="checkbox" '.$autoplay.' name="fi_autoplay" 
                    value="enabled" />

                    </td> 
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Enable Play Button</label><input type="checkbox" '.$playBtn.' name="fi_playBtn" 
                    value="enabled" />

                    </td> 
                </tr>
                <tr>
                    <td align="left" scope="row">
                    <label>Transition Interval</label><input type="text" name="fi_interval" 
                    value="' . $interval . '" />

                    </td> 
                </tr>
            </table>
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="fi_autoplay,fi_effect,fi_interval,fi_playBtn" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';
    echo $html;
}
?>