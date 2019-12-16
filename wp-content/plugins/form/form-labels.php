<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

// get custom labels from settingspage
$name_label = get_option('form-setting-5');
$email_label = get_option('form-setting-6');
$subject_label = get_option('form-setting-7');
$captcha_label = get_option('form-setting-8');
$message_label = get_option('form-setting-9');
$attachment_label = get_option('form-setting-99');
$privacy_label = get_option('form-setting-18');
$submit_label = get_option('form-setting-10');
// get custom messages from settingspage
$server_error_message = get_option('form-setting-15');
$thank_you_message = get_option('form-setting-16');
$auto_reply_message = get_option('form-setting-17');

// name label
$value = $name_label;
if (empty($form_atts['label_name'])) {
    if (empty($value)) {
        $name_label = __('Name', 'form');
    } else {
        $name_label = $value;
    }
} else {
    $name_label = $form_atts['label_name'];
}

// email label
$value = $email_label;
if (empty($form_atts['label_email'])) {
    if (empty($value)) {
        $email_label = __('Email', 'form');
    } else {
        $email_label = $value;
    }
} else {
    $email_label = $form_atts['label_email'];
}

// subject label
$value = $subject_label;
if (empty($form_atts['label_subject'])) {
    if (empty($value)) {
        $subject_label = __('Subject', 'form');
    } else {
        $subject_label = $value;
    }
} else {
    $subject_label = $form_atts['label_subject'];
}

// captcha label
$value = $captcha_label;
if (empty($form_atts['label_captcha'])) {
    if (empty($value)) {
        $captcha_label = __('Enter number %s', 'form');
    } else {
        $captcha_label = $value;
    }
} else {
    $captcha_label = $form_atts['label_captcha'];
}

// message label
$value = $message_label;
if (empty($form_atts['label_message'])) {
    if (empty($value)) {
        $message_label = __('Message', 'form');
    } else {
        $message_label = $value;
    }
} else {
    $message_label = $form_atts['label_message'];
}

// privacy label
$value = $privacy_label;
if (empty($form_atts['label_privacy'])) {
    if (empty($value)) {
        $privacy_label = __('I consent to having this website collect my personal data via this form.', 'form');
    } else {
        $privacy_label = $value;
    }
} else {
    $privacy_label = $form_atts['label_privacy'];
}

// submit label
$value = $submit_label;
if (empty($form_atts['label_submit'])) {
    if (empty($value)) {
        $submit_label = __('Submit', 'form');
    } else {
        $submit_label = $value;
    }
} else {
    $submit_label = $form_atts['label_submit'];
}

// thank you message
$value = $thank_you_message;
if (empty($form_atts['message_success'])) {
    if (empty($value)) {
        $thank_you_message = __('Thank you! You will receive a response as soon as possible.', 'form');
    } else {
        $thank_you_message = $value;
    }
} else {
    $thank_you_message = $form_atts['message_success'];
}

// auto reply message
$value = $auto_reply_message;
if (empty($form_atts['auto_reply_message'])) {
    if (empty($value)) {
        $auto_reply_message = __('Thank you! You will receive a response as soon as possible.', 'form');
    } else {
        $auto_reply_message = $value;
    }
} else {
    $auto_reply_message = $form_atts['auto_reply_message'];
}
