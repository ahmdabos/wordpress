<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

// sending and saving form submission
if ($error == false) {
    // hook to support plugin Contact Form DB
    do_action('form_before_send_mail', $form_data);
    // site name
    $blog_name = htmlspecialchars_decode(get_bloginfo('name'), ENT_QUOTES);
    // email address admin
    $email_admin = get_option('admin_email');
    $email_settings = get_option('form-setting-22');
    if (!empty($form_atts['email_to'])) {
        $to = $form_atts['email_to'];
    } else {
        if (!empty($email_settings)) {
            $to = $email_settings;
        } else {
            $to = $email_admin;
        }
    }
    // from email header
    $from = $form_atts['from_header'];
    // subject
    if (!empty($form_atts['prefix_subject'])) {
        $prefix = $form_atts['prefix_subject'];
    } else {
        $prefix = $blog_name;
    }
    if (!empty($form_atts['subject'])) {
        $subject = $form_atts['subject'];
    } elseif ($subject_setting != "yes") {
        $subject = "(" . $prefix . ") " . $form_data['form_subject'];
    } else {
        $subject = $prefix;
    }
    // auto reply message
    $reply_message = htmlspecialchars_decode($auto_reply_message, ENT_QUOTES);
    // set privacy consent
    $value = $form_data['form_privacy'];
    if ($value == "yes") {
        $consent = __('Yes', 'form');
    } else {
        $consent = __('No', 'form');
    }
    // show or hide ip address
    if ($ip_address_setting == "yes") {
        $ip_address = '';
    } else {
        $ip_address = sprintf(esc_attr__('IP: %s', 'form'), form_get_the_ip());
    }

    //upload file
    require_once('inc/upload.php');

    // save form submission in database
    if ($list_submissions_setting == "yes") {
        $form_post_information = array(
            'post_title' => wp_strip_all_tags($subject),

            'post_content' => $form_data['form_name'] . "\r\n\r\n" . $form_data['form_email'] . "\r\n\r\n" . $form_data['form_message'] . "\r\n\r\n" . sprintf(esc_attr__('Privacy consent: %s', 'form'), $consent) . "\r\n\r\n" . $ip_address . "\r\n\r\n" . $attachment,
            'post_type' => 'submission',
            'post_status' => 'pending',
            'meta_input' => array("name_sub" => $form_data['form_name'], "email_sub" => $form_data['form_email'], "message_sub" => $form_data['form_message'], "attachment_sub" => $attachment)
        );
        $post_id = wp_insert_post($form_post_information);
        update_post_meta( $post_id, 'submission_name', $form_data['form_name'] );
        update_post_meta( $post_id, 'submission_email', $form_data['form_email'] );
        update_post_meta( $post_id, 'submission_message', $form_data['form_message'] );
        update_post_meta( $post_id, 'submission_attachment', $attachment );

    }
    // mail
    $content = $form_data['form_name'] . "\r\n\r\n" . $form_data['form_email'] . "\r\n\r\n" . $form_data['form_message'] . "\r\n\r\n" . sprintf(esc_attr__('Privacy consent: %s', 'form'), $consent) . "\r\n\r\n" . $ip_address . "\r\n\r\n" . $attachment;
    $headers = "Content-Type: text/plain; charset=UTF-8" . "\r\n";
    $headers .= "From: " . $form_data['form_name'] . " <" . $from . ">" . "\r\n";
    $headers .= "Reply-To: <" . $form_data['form_email'] . ">" . "\r\n";
    $auto_reply_content = $reply_message . "\r\n\r\n" . $form_data['form_name'] . "\r\n\r\n" . $form_data['form_email'] . "\r\n\r\n" . $form_data['form_message'] . "\r\n\r\n" . $ip_address;
    $auto_reply_headers = "Content-Type: text/plain; charset=UTF-8" . "\r\n";
    $auto_reply_headers .= "From: " . $blog_name . " <" . $from . ">" . "\r\n";
    $auto_reply_headers .= "Reply-To: <" . $form_atts['email_to'] . ">" . "\r\n";

    if (wp_mail(esc_attr($to), wp_strip_all_tags($subject), $content, $headers)) {
        if ($auto_reply_setting == "yes") {
            wp_mail($form_data['form_email'], wp_strip_all_tags($subject), $auto_reply_content, $auto_reply_headers);
        }
        $sent = true;
    } else {
        $fail = true;
    }
}
