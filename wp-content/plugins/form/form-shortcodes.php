<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// shortcode for page
function form_shortcode($form_atts) {
	// attributes
	$form_atts = shortcode_atts(array(
		'class' => 'form-container',
		'email_to' => '',
		'from_header' => form_from_header(),
		'prefix_subject' => '',
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
	), $form_atts);

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
	$list_submissions_setting = get_option('form-setting-2');
	$subject_setting = get_option('form-setting-23');
	$auto_reply_setting = get_option('form-setting-3');
	$privacy_setting = get_option('form-setting-4');
	$ip_address_setting = get_option('form-setting-19');
	$anchor_setting = get_option('form-setting-21');

	// include labels
	include 'form-labels.php';

	// captcha
	$form_rand = form_random_number();

	// set nonce field
	$form_nonce_field = wp_nonce_field( 'form_nonce_action', 'form_nonce', true, false );

	// name and id of submit button
	$submit_name_id = 'form_send';

	// form anchor
	if ($anchor_setting == "yes") {
		$anchor_begin = '<div id="form-anchor">';
		$anchor_end = '</div>';
	} else {
		$anchor_begin = '';
		$anchor_end = '';
	}

	// processing form
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['form_send']) && isset( $_POST['form_nonce'] ) && wp_verify_nonce( $_POST['form_nonce'], 'form_nonce_action' ) ) {
		// sanitize input
		if ($subject_setting != "yes") {
			$subject_value = sanitize_text_field($_POST['form_subject']);
		} else {
			$subject_value = '';
		}
		if($privacy_setting == "yes") {
			$privacy_value = sanitize_key($_POST['form_privacy']);
		} else {
			$privacy_value = '';
		}
		$post_data = array(
			'form_name' => sanitize_text_field($_POST['form_name']),
			'form_email' => sanitize_email($_POST['form_email']),
			'form_subject' => $subject_value,
			'form_captcha' => sanitize_text_field($_POST['form_captcha']),
			'form_captcha_hidden' => sanitize_text_field($_POST['form_captcha_hidden']),
			'form_message' => sanitize_textarea_field($_POST['form_message']),
			'form_privacy' => $privacy_value,
			'form_firstname' => sanitize_text_field($_POST['form_firstname']),
			'form_lastname' => sanitize_text_field($_POST['form_lastname'])
		);
		// include validation
		include 'form-validate.php';

		// include sending and saving form submission
		include 'form-submission.php';
	}

	// include form
	include 'form-form.php';

	// after form validation
	if ($sent == true) {
		return '<script type="text/javascript">window.location="'.form_redirect_success().'"</script>';
	} elseif ($fail == true) {
		return '<script type="text/javascript">window.location="'.form_redirect_error().'"</script>';
	}

	// display form or the result of submission
	if ( isset( $_GET['formsp'] ) ) {
		if ( $_GET['formsp'] == 'success' ) {
			return $anchor_begin . '<p class="form-info">'.esc_attr($thank_you_message).'</p>' . $anchor_end;
		} elseif ( $_GET['formsp'] == 'fail' ) {
			return $anchor_begin . '<p class="form-info">'.esc_attr($server_error_message).'</p>' . $anchor_end;
		}	
	} else {
		if ($error == true) {
			return $anchor_begin .$email_form. $anchor_end;
		} else {
			return $email_form;
		}
	}	   		
} 
add_shortcode('form', 'form_shortcode');

// shortcode for widget
function form_widget_shortcode($form_atts) {
	// attributes
	$form_atts = shortcode_atts(array(
		'class' => 'form-container',
		'email_to' => '',
		'from_header' => form_from_header(),
		'prefix_subject' => '',
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
	), $form_atts);

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
	$list_submissions_setting = get_option('form-setting-2');
	$subject_setting = get_option('form-setting-23');
	$auto_reply_setting = get_option('form-setting-3');
	$privacy_setting = get_option('form-setting-4');
	$ip_address_setting = get_option('form-setting-19');
	$anchor_setting = get_option('form-setting-21');

	// include labels
	include 'form-labels.php';

	// captcha
	$form_rand = form_widget_random_number();

	// set nonce field
	$form_nonce_field = wp_nonce_field( 'form_widget_nonce_action', 'form_widget_nonce', true, false );

	// name and id of submit button
	$submit_name_id = 'form_widget_send';

	// form anchor
	if ($anchor_setting == "yes") {
		$anchor_begin = '<div id="form-anchor">';
		$anchor_end = '</div>';
	} else {
		$anchor_begin = '';
		$anchor_end = '';
	}

	// processing form
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['form_widget_send']) && isset( $_POST['form_widget_nonce'] ) && wp_verify_nonce( $_POST['form_widget_nonce'], 'form_widget_nonce_action' ) ) {
		// sanitize input
		if ($subject_setting != "yes") {
			$subject_value = sanitize_text_field($_POST['form_subject']);
		} else {
			$subject_value = '';
		}
		if($privacy_setting == "yes") {
			$privacy_value = sanitize_key($_POST['form_privacy']);
		} else {
			$privacy_value = '';
		}
		$post_data = array(
			'form_name' => sanitize_text_field($_POST['form_name']),
			'form_email' => sanitize_email($_POST['form_email']),
			'form_subject' => $subject_value,
			'form_captcha' => sanitize_text_field($_POST['form_captcha']),
			'form_captcha_hidden' => sanitize_text_field($_POST['form_captcha_hidden']),
			'form_message' => sanitize_textarea_field($_POST['form_message']),
			'form_privacy' => $privacy_value,
			'form_firstname' => sanitize_text_field($_POST['form_firstname']),
			'form_lastname' => sanitize_text_field($_POST['form_lastname'])
		);

		// include validation
		include 'form-validate.php';

		// include sending and saving form submission
		include 'form-submission.php';
	}

	// include form
	include 'form-form.php';

	// after form validation
	if ($sent == true) {
		return '<script type="text/javascript">window.location="'.form_widget_redirect_success().'"</script>';
	} elseif ($fail == true) {
		return '<script type="text/javascript">window.location="'.form_widget_redirect_error().'"</script>';
	}

	// display form or the result of submission
	if ( isset( $_GET['formsw'] ) ) {
		if ( $_GET['formsw'] == 'success' ) {
			return $anchor_begin . '<p class="form-info">'.esc_attr($thank_you_message).'</p>' . $anchor_end;
		} elseif ( $_GET['formsw'] == 'fail' ) {
			return $anchor_begin . '<p class="form-info">'.esc_attr($server_error_message).'</p>' . $anchor_end;
		}	
	} else {
		if ($error == true) {
			return $anchor_begin .$email_form. $anchor_end;
		} else {
			return $email_form;
		}
	}	   		
}
add_shortcode('contact-widget', 'form_widget_shortcode');
