<?php
require(dirname(__FILE__) . '/../../../wp-load.php');
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

// validate name
$value = stripslashes($post_data['form_name']);
if (empty($value)) {
    $error_class['form_name'] = true;
    $error = true;
}
$form_data['form_name'] = $value;

// validate email
$value = $post_data['form_email'];
if (empty($value)) {
    $error_class['form_email'] = true;
    $error = true;
}
$form_data['form_email'] = $value;

// validate first honeypot field
$value = stripslashes($post_data['form_firstname']);
if (strlen($value) > 0) {
    $error = true;
}
$form_data['form_firstname'] = $value;

// validate second honeypot field
$value = stripslashes($post_data['form_lastname']);
if (strlen($value) > 0) {
    $error = true;
}
$form_data['form_lastname'] = $value;








