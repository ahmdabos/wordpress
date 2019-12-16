<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

// validate name
$value = stripslashes($post_data['form_name']);
if (empty($value)) {
    $error = true;
}
$form_data['form_name'] = $value;

// validate email
$value = $post_data['form_email'];
if (empty($value)) {
    $error = true;
}
$form_data['form_email'] = $value;

// validate subject
if ($subject_setting != "yes") {
    $value = stripslashes($post_data['form_subject']);
    if (empty($value)) {
        $error = true;
    }
    $form_data['form_subject'] = $value;
}

// validate captcha
$value = stripslashes($post_data['form_captcha']);
$hidden = stripslashes($post_data['form_captcha_hidden']);
if ($value != $hidden) {
    $error = true;
}
$form_data['form_captcha'] = $value;

// validate message
$value = stripslashes($post_data['form_message']);
if (empty($value)) {
    $error_class['form_captcha'] = true;
    $error = true;
}
$form_data['form_message'] = $value;

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

// validate privacy
if ($privacy_setting == "yes") {
    $value = $post_data['form_privacy'];
    if ($value != "yes") {
        $error = true;
    }
    $form_data['form_privacy'] = $value;
}


if (!$_FILES['attachment']['name']) {
    $error = true;
} else {
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    // Get image file extension
    $file_extension = strtolower(pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION));
    if ($_FILES['attachment']['size'] > 2097152) {
        $error = true;
    }
    if (!in_array($file_extension, $allowed_image_extension)) {
        $error = true;

    }
}
