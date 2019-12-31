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

/*if (!$_FILES['attachment']['name']) {
    $error = true;
    $error_class['form_attachment_required'] = true;
} else {
    $allowed_image_extension = array(
'image/png'
'text/plain'
'image/gif'
'text/plain'
'application/vnd.ms-powerpoint'
'application/pdf'
    );
    // Get image file extension
    $file_extension = strtolower(pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION));
    if ($_FILES['attachment']['size'] > 2097152) {
        $error = true;
        $error_class['form_attachment_size'] = true;
    }
    if (!in_array($file_extension, $allowed_image_extension)) {
        $error = true;
        $error_class['form_attachment_type'] = true;
    }
}
*/












