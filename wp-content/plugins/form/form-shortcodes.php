<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// shortcode for page
function form_shortcode($atts) {
	// attributes
	$atts = shortcode_atts(array(
		'class' => 'form-container',
		'email_to' => '',
		'from_header' => form_from_header(),
		'label_name' => '',
		'label_email' => '',
        'label_attachment' => '',
		'label_submit' => '',
		'message_success' => '',
		'message_error' => '',
		'auto_reply_message' => ''
	), $atts);

	// initialize variables
	$form_data = array(
		'form_name' => '',
		'form_email' => '',
        'form_attachment' => '',
		'form_firstname' => '',
		'form_lastname' => ''
	);
	$error = false;
	$sent = false;
	$fail = false;

	// include labels
	include 'form-labels.php';

	// set nonce field
	$form_nonce_field = wp_nonce_field( 'form_nonce_action', 'form_nonce', true, false );

	// processing form
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['form_send']) && isset( $_POST['form_nonce'] ) && wp_verify_nonce( $_POST['form_nonce'], 'form_nonce_action' ) ) {

		$post_data = array(
			'form_name' => sanitize_text_field($_POST['form_name']),
			'form_email' => sanitize_email($_POST['form_email']),
            'form_attachment' => sanitize_text_field($_POST['form_attachment']),
			'form_firstname' => sanitize_text_field($_POST['form_firstname']),
			'form_lastname' => sanitize_text_field($_POST['form_lastname'])
		);
		// include validation
		include 'form-validate.php';

		// include sending and saving form submission
		include 'form-submission.php';
	}

	// include form
	include 'form-html.php';

	// after form validation
	if ($sent == true) {
		return '<script type="text/javascript">window.location="'.form_redirect_success().'"</script>';
	} elseif ($fail == true) {
		return '<script type="text/javascript">window.location="'.form_redirect_error().'"</script>';
	}

	// display form or the result of submission
	if ( isset( $_GET['formsp'] ) ) {
		if ( $_GET['formsp'] == 'success' ) {
			return '<p class="form-info">'.esc_attr($thank_you_message).'</p>';
		} elseif ( $_GET['formsp'] == 'fail' ) {
			return '<p class="form-info">'.esc_attr($server_error_message).'</p>';
		}	
	} else {
        return $email_form;
	}	   		
} 
add_shortcode('form', 'form_shortcode');
add_shortcode('contact-widget', 'form_shortcode');
