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
include 'functions.php';
// load plugin text domain
function form_init()
{
    load_plugin_textdomain('form', false, dirname(plugin_basename(__FILE__)) . '/translation');
}

add_action('plugins_loaded', 'form_init');

// enqueue plugin scripts
function form_scripts()
{
    wp_enqueue_style('form_style', plugins_url('/css/form-style.css', __FILE__));
    wp_enqueue_script('form_validator', plugins_url('/js/jquery.form-validator/jquery.form-validator.js', __FILE__), array('jquery'), time(), true);
    wp_enqueue_script('file_validator', plugins_url('/js/jquery.form-validator/file.js', __FILE__), array('form_validator'), time(), true);
    wp_enqueue_script('custom', plugins_url('/js/custom.js', __FILE__), array('jquery', 'form_validator'), time(), true);

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
    include 'submission-post-type.php';
}

// add settings link
function form_action_links($links)
{
    $settingslink = array('<a href="' . admin_url('options-general.php?page=form') . '">' . esc_attr__('Settings', 'form') . '</a>');
    return array_merge($links, $settingslink);
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'form_action_links');


// include files
include 'form-shortcodes.php';
include 'form-widget.php';
include 'form-options.php';
