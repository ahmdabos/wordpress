



<?php
/*
 * Plugin Name: Form
 * Description: shortcode [form]
 * Version: 1.0.0
 * Author: fi
 * Text Domain: form
 * Domain Path: /translation
 */

// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

// load plugin text domain
function form_init()
{
    load_plugin_textdomain('form', false, dirname(plugin_basename(__FILE__)) . '/translation');
}

add_action('plugins_loaded', 'form_init');

// enqueue plugin scripts
function form_scripts()
{
    wp_enqueue_style('form_style', plugins_url('/css/form-style.min.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'form_scripts');

// the sidebar widget
function register_form_widget()
{
    register_widget('form_widget');
}

add_action('widgets_init', 'register_form_widget');

// form submissions
$list_submissions_setting = get_option('form-setting-2');
if ($list_submissions_setting == "yes") {
    // create submission post type
    function form_custom_postype()
    {
        $form_args = array(
            'labels' => array('name' => esc_attr__('Submissions', 'form')),
            'menu_icon' => 'dashicons-email',
            'public' => false,
            'can_export' => true,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_in_rest' => true,
            'capability_type' => 'post',
            'capabilities' => array('create_posts' => 'do_not_allow'),
            'map_meta_cap' => true,
            'supports' => array('title', 'editor')
        );
        register_post_type('submission', $form_args);
    }

    add_action('init', 'form_custom_postype');

    // dashboard submission columns
    function form_custom_columns($columns)
    {
        $columns['name_column'] = esc_attr__('Name', 'form');
        $columns['email_column'] = esc_attr__('Email', 'form');
        $columns['message_column'] = esc_attr__('Message', 'form');
        $custom_order = array('cb', 'title', 'name_column', 'email_column', 'message_column', 'date');
        foreach ($custom_order as $colname) {
            $new[$colname] = $columns[$colname];
        }
        return $new;
    }

    add_filter('manage_submission_posts_columns', 'form_custom_columns', 10);

    function form_custom_columns_content($column_name, $post_id)
    {
        if ('name_column' == $column_name) {
            $name = get_post_meta($post_id, 'name_sub', true);
            echo $name;
        }
        if ('email_column' == $column_name) {
            $email = get_post_meta($post_id, 'email_sub', true);
            echo $email;
        }
        if ('message_column' == $column_name) {
            $message = get_post_meta($post_id, 'message_sub', true);
            echo $message;
        }
    }

    add_action('manage_submission_posts_custom_column', 'form_custom_columns_content', 10, 2);

    // make name and email column sortable
    function form_column_register_sortable($columns)
    {
        $columns['name_column'] = 'name_sub';
        $columns['email_column'] = 'email_sub';
        return $columns;
    }

    add_filter('manage_edit-submission_sortable_columns', 'form_column_register_sortable');

    function form_name_column_orderby($vars)
    {
        if (is_admin()) {
            if (isset($vars['orderby']) && 'name_sub' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'name_sub',
                    'orderby' => 'meta_value'
                ));
            }
        }
        return $vars;
    }

    add_filter('request', 'form_name_column_orderby');

    function form_email_column_orderby($vars)
    {
        if (is_admin()) {
            if (isset($vars['orderby']) && 'email_sub' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'email_sub',
                    'orderby' => 'meta_value'
                ));
            }
        }
        return $vars;
    }

    add_filter('request', 'form_email_column_orderby');
}

// add settings link
function form_action_links($links)
{
    $settingslink = array('<a href="' . admin_url('options-general.php?page=form') . '">' . esc_attr__('Settings', 'form') . '</a>');
    return array_merge($links, $settingslink);
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'form_action_links');

// get ip of user
function form_get_the_ip()
{
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    } else {
        return $_SERVER["REMOTE_ADDR"];
    }
}

// create from email header
function form_from_header()
{
    if (!isset($from_email)) {
        $sitename = strtolower($_SERVER['SERVER_NAME']);
        if (substr($sitename, 0, 4) == 'www.') {
            $sitename = substr($sitename, 4);
        }
        return 'info@' . $sitename;
    }
}

// create random number for page captcha
function form_random_number()
{
    $page_number = mt_rand(100, 999);
    return $page_number;
}

// create random number for widget captcha
function form_widget_random_number()
{
    $widget_number = mt_rand(100, 999);
    return $widget_number;
}

// redirect if sending succeeded
function form_redirect_success()
{
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '?') == true) {
        $url_with_param = $current_url . "&formsp=success";
    } else {
        if (substr($current_url, -1) == '/') {
            $url_with_param = $current_url . "?formsp=success";
        } else {
            $url_with_param = $current_url . "/?formsp=success";
        }
    }
    return $url_with_param;
}

function form_widget_redirect_success()
{
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '?') == true) {
        $url_with_param = $current_url . "&formsw=success";
    } else {
        if (substr($current_url, -1) == '/') {
            $url_with_param = $current_url . "?formsw=success";
        } else {
            $url_with_param = $current_url . "/?formsw=success";
        }
    }
    return $url_with_param;
}

// redirect if sending failed
function form_redirect_error()
{
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '?') == true) {
        $url_with_param = $current_url . "&formsp=fail";
    } else {
        if (substr($current_url, -1) == '/') {
            $url_with_param = $current_url . "?formsp=fail";
        } else {
            $url_with_param = $current_url . "/?formsp=fail";
        }
    }
    return $url_with_param;
}

function form_widget_redirect_error()
{
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '?') == true) {
        $url_with_param = $current_url . "&formsw=fail";
    } else {
        if (substr($current_url, -1) == '/') {
            $url_with_param = $current_url . "?formsw=fail";
        } else {
            $url_with_param = $current_url . "/?formsw=fail";
        }
    }
    return $url_with_param;
}

// form anchor
function form_anchor_footer()
{
    $anchor_setting = get_option('form-setting-21');
    if ($anchor_setting == "yes") {
        echo '<script type="text/javascript">';
        echo 'if(document.getElementById("form-anchor")) { document.getElementById("form-anchor").scrollIntoView({behavior:"smooth", block:"center"}); }';
        echo '</script>';
    }
}

add_action('wp_footer', 'form_anchor_footer');

// include files
include 'form-shortcodes.php';
include 'form-widget.php';
include 'form-options.php';
