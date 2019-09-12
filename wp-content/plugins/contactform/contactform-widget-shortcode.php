<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// the shortcode
function contactform_widget_shortcode($contactform_atts) {
	// attributes
	$contactform_atts = shortcode_atts(array(
		'class' => 'contactform-container',
		'email_to' => '',
		'from_header' => contactform_from_header(),
		'subject' => '',
		'label_name' => '',
		'label_email' => '',
		'label_subject' => '',
		'label_captcha' => '',
		'label_message' => '',
		'label_privacy' => '',
		'label_submit' => '',
		'error_name' => '',
		'error_email' => '',
		'error_subject' => '',
		'error_captcha' => '',
		'error_message' => '',
		'message_success' => '',
		'message_error' => '',
		'auto_reply_message' => ''
	), $contactform_atts);

	// initialize variables
	$form_data = array(
		'form_name' => '',
		'form_email' => '',
		'form_subject' => '',
		'form_captcha' => '',
		'form_message' => '',
		'form_privacy' => '',
		'form_firstname' => '',
		'form_lastname' => ''
	);
	$error = false;
	$sent = false;
	$fail = false;

	// get custom settings from settingspage
	$list_submissions_setting = get_option('contactform-setting-2');
	$subject_setting = get_option('contactform-setting-23');
	$auto_reply_setting = get_option('contactform-setting-3');
	$privacy_setting = get_option('contactform-setting-4');
	$ip_address_setting = get_option('contactform-setting-19');
	$anchor_setting = get_option('contactform-setting-21');

	// include labels
	include 'contactform-labels.php';

	// captcha
	$contactform_rand = contactform_widget_random_number();

	// set nonce field
	$contactform_nonce_field = wp_nonce_field( 'contactform_widget_nonce_action', 'contactform_widget_nonce', true, false );

	// name and id of submit button
	$submit_name_id = 'contactform_widget_send';

	// form anchor
	if ($anchor_setting == "yes") {
		$anchor_begin = '<div id="contactform-anchor">';
		$anchor_end = '</div>';
	} else {
		$anchor_begin = '';
		$anchor_end = '';
	}

	// processing form
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['contactform_widget_send']) && isset( $_POST['contactform_widget_nonce'] ) && wp_verify_nonce( $_POST['contactform_widget_nonce'], 'contactform_widget_nonce_action' ) ) {
		// sanitize content
		$post_data = array(
			'form_name' => sanitize_text_field($_POST['contactform_name']),
			'form_email' => sanitize_email($_POST['contactform_email']),
			'form_subject' => sanitize_text_field($_POST['contactform_subject']),
			'form_captcha' => sanitize_text_field($_POST['contactform_captcha']),
			'form_captcha_hidden' => sanitize_text_field($_POST['contactform_captcha_hidden']),
			'form_message' => sanitize_textarea_field($_POST['contactform_message']),
			'form_privacy' => sanitize_key($_POST['contactform_privacy']),
			'form_firstname' => sanitize_text_field($_POST['contactform_firstname']),
			'form_lastname' => sanitize_text_field($_POST['contactform_lastname'])
		);

		// include validation
		include 'contactform-validate.php';

		// include sending and saving form submission
		include 'contactform-submission.php';
	}

	// include form
	include 'contactform-form.php';
	
	// after form validation
	if ($sent == true) {
		contactform_widget_redirect_success();
	} elseif ($fail == true) {
		contactform_widget_redirect_error();
	}

	// display form or the result of submission
	if ( isset( $_GET['contactformsw'] ) ) {
		if ( $_GET['contactformsw'] == 'success' ) {
			return $anchor_begin . '<p class="contactform-info">'.esc_attr($thank_you_message).'</p>' . $anchor_end;
		} elseif ( $_GET['contactformsw'] == 'fail' ) {
			return $anchor_begin . '<p class="contactform-info">'.esc_attr($server_error_message).'</p>' . $anchor_end;
		}	
	} else {
		if ($error == true) {
			return $anchor_begin .$email_form. $anchor_end;
		} else {
			return $email_form;
		}
	}	   		
}
add_shortcode('contact-widget', 'contactform_widget_shortcode');
