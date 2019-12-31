<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

$name_label = get_option('form-setting-5');
$email_label = get_option('form-setting-6');
$attachment_label = get_option('form-setting-7');
$submit_label = get_option('form-setting-10');
$server_error_message = get_option('form-setting-15');
$thank_you_message = get_option('form-setting-16');
$auto_reply_message = get_option('form-setting-17');

// name label
$value = $name_label;
if (empty($atts['label_name'])) {
    if (empty($value)) {
        $name_label = __('Name', 'form');
    } else {
        $name_label = $value;
    }
} else {
    $name_label = $atts['label_name'];
}

// email label
$value = $email_label;
if (empty($atts['label_email'])) {
    if (empty($value)) {
        $email_label = __('Email', 'form');
    } else {
        $email_label = $value;
    }
} else {
    $email_label = $atts['label_email'];
}
// attachment label
$value = $attachment_label;
if (empty($atts['label_attachment'])) {
    if (empty($value)) {
        $attachment_label = __('Attachment', 'form');
    } else {
        $attachment_label = $value;
    }
} else {
    $attachment_label = $atts['label_attachment'];
}
// submit label
$value = $submit_label;
if (empty($atts['label_submit'])) {
    if (empty($value)) {
        $submit_label = __('Submit', 'form');
    } else {
        $submit_label = $value;
    }
} else {
    $submit_label = $atts['label_submit'];
}

// thank you message
$value = $thank_you_message;
if (empty($atts['message_success'])) {
    if (empty($value)) {
        $thank_you_message = __('Thank you! You will receive a response as soon as possible.', 'form');
    } else {
        $thank_you_message = $value;
    }
} else {
    $thank_you_message = $atts['message_success'];
}

// auto reply message
$value = $auto_reply_message;
if (empty($atts['auto_reply_message'])) {
    if (empty($value)) {
        $auto_reply_message = __('Thank you! You will receive a response as soon as possible.', 'form');
    } else {
        $auto_reply_message = $value;
    }
} else {
    $auto_reply_message = $atts['auto_reply_message'];
}
