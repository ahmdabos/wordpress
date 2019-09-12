<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	// get custom labels from settingspage
	$name_label = get_option('contactform-setting-5');
	$email_label = get_option('contactform-setting-6');
	$subject_label = get_option('contactform-setting-7');
	$captcha_label = get_option('contactform-setting-8');
	$message_label = get_option('contactform-setting-9');
	$privacy_label = get_option('contactform-setting-18');
	$submit_label = get_option('contactform-setting-10');
	$error_name_label = get_option('contactform-setting-11');
	$error_email_label = get_option('contactform-setting-13');
	$error_subject_label = get_option('contactform-setting-20');
	$error_captcha_label = get_option('contactform-setting-14');
	$error_message_label = get_option('contactform-setting-12');

	// get custom messages from settingspage
	$server_error_message = get_option('contactform-setting-15');
	$thank_you_message = get_option('contactform-setting-16');
	$auto_reply_message = get_option('contactform-setting-17');

	// name label
	$value = $name_label;
	if (empty($contactform_atts['label_name'])) {
		if (empty($value)) {
			$name_label = __( 'Name', 'contact-form' );
		} else {
			$name_label = $value;
		}
	} else {
		$name_label = $contactform_atts['label_name'];
	}

	// email label
	$value = $email_label;
	if (empty($contactform_atts['label_email'])) {
		if (empty($value)) {
			$email_label = __( 'Email', 'contact-form' );
		} else {
			$email_label = $value;
		}
	} else {
		$email_label = $contactform_atts['label_email'];
	}

	// subject label
	$value = $subject_label;
	if (empty($contactform_atts['label_subject'])) {
		if (empty($value)) {
			$subject_label = __( 'Subject', 'contact-form' );
		} else {
			$subject_label = $value;
		}
	} else {
		$subject_label = $contactform_atts['label_subject'];
	}

	// captcha label
	$value = $captcha_label;
	if (empty($contactform_atts['label_captcha'])) {
		if (empty($value)) {
			$captcha_label = __( 'Enter number %s', 'contact-form' );
		} else {
			$captcha_label = $value;
		}
	} else {
		$captcha_label = $contactform_atts['label_captcha'];
	}

	// message label
	$value = $message_label;
	if (empty($contactform_atts['label_message'])) {
		if (empty($value)) {
			$message_label = __( 'Message', 'contact-form' );
		} else {
			$message_label = $value;
		}
	} else {
		$message_label = $contactform_atts['label_message'];
	}

	// privacy label
	$value = $privacy_label;
	if (empty($contactform_atts['label_privacy'])) {
		if (empty($value)) {
			$privacy_label = __( 'I consent to having this website collect my personal data via this form.', 'contact-form' );
		} else {
			$privacy_label = $value;
		}
	} else {
		$privacy_label = $contactform_atts['label_privacy'];
	}

	// submit label
	$value = $submit_label;
	if (empty($contactform_atts['label_submit'])) {
		if (empty($value)) {
			$submit_label = __( 'Submit', 'contact-form' );
		} else {
			$submit_label = $value;
		}
	} else {
		$submit_label = $contactform_atts['label_submit'];
	}

	// error name label
	$value = $error_name_label;
	if (empty($contactform_atts['error_name'])) {
		if (empty($value)) {
			$error_name_label = __( 'Please enter at least 2 characters', 'contact-form' );
		} else {
			$error_name_label = $value;
		}
	} else {
		$error_name_label = $contactform_atts['error_name'];
	}

	// error email label
	$value = $error_email_label;
	if (empty($contactform_atts['error_email'])) {
		if (empty($value)) {
			$error_email_label = __( 'Please enter a valid email', 'contact-form' );
		} else {
			$error_email_label = $value;
		}
	} else {
		$error_email_label = $contactform_atts['error_email'];
	}

	// error subject label
	$value = $error_subject_label;
	if (empty($contactform_atts['error_subject'])) {
		if (empty($value)) {
			$error_subject_label = __( 'Please enter at least 2 characters', 'contact-form' );
		} else {
			$error_subject_label = $value;
		}
	} else {
		$error_subject_label = $contactform_atts['error_subject'];
	}

	// error captcha label
	$value = $error_captcha_label;
	if (empty($contactform_atts['error_captcha'])) {
		if (empty($value)) {
			$error_captcha_label = __( 'Please enter the correct number', 'contact-form' );
		} else {
			$error_captcha_label = $value;
		}
	} else {
		$error_captcha_label = $contactform_atts['error_captcha'];
	}

	// error message label
	$value = $error_message_label;
	if (empty($contactform_atts['error_message'])) {
		if (empty($value)) {
			$error_message_label = __( 'Please enter at least 10 characters', 'contact-form' );
		} else {
			$error_message_label = $value;
		}
	} else {
		$error_message_label = $contactform_atts['error_message'];
	}

	// server error message
	$value = $server_error_message;
	if (empty($contactform_atts['message_error'])) {
		if (empty($value)) {
			$server_error_message= __( 'Error! Could not send form. This might be a server issue.', 'contact-form' );
		} else {
			$server_error_message = $value;
		}
	} else {
		$server_error_message = $contactform_atts['message_error'];
	}

	// thank you message
	$value = $thank_you_message;
	if (empty($contactform_atts['message_success'])) {
		if (empty($value)) {
			$thank_you_message = __( 'Thank you! You will receive a response as soon as possible.', 'contact-form' );
		} else {
			$thank_you_message = $value;
		}
	} else {
		$thank_you_message = $contactform_atts['message_success'];
	}

	// auto reply message
	$value = $auto_reply_message;
	if (empty($contactform_atts['auto_reply_message'])) {
		if (empty($value)) {
			$auto_reply_message = __( 'Thank you! You will receive a response as soon as possible.', 'contact-form' );
		} else {
			$auto_reply_message = $value;
		}
	} else {
		$auto_reply_message = $contactform_atts['auto_reply_message'];
	}
