<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	$email_form = '<form id="contactform" class="'.$contactform_atts['class'].'" method="post">
		<div class="form-group contactform-name-group">
			<label for="contactform_name">'.esc_attr($name_label).': <span class="'.(isset($error_class['form_name']) ? "contactform-error" : "contactform-hide").'" >'.esc_attr($error_name_label).'</span></label>
			<input type="text" name="contactform_name" id="contactform_name" '.(isset($error_class['form_name']) ? ' class="form-control contactform-error"' : ' class="form-control"').' value="'.esc_attr($form_data['form_name']).'" />
		</div>
		<div class="form-group contactform-email-group">
			<label for="contactform_email">'.esc_attr($email_label).': <span class="'.(isset($error_class['form_email']) ? "contactform-error" : "contactform-hide").'" >'.esc_attr($error_email_label).'</span></label>
			<input type="email" name="contactform_email" id="contactform_email" '.(isset($error_class['form_email']) ? ' class="form-control contactform-error"' : ' class="form-control"').' value="'.esc_attr($form_data['form_email']).'" />
		</div>
		'. (($subject_setting != "yes") ? '
			<div class="form-group contactform-subject-group">
				<label for="contactform_subject">'.esc_attr($subject_label).': <span class="'.(isset($error_class['form_subject']) ? "contactform-error" : "contactform-hide").'" >'.esc_attr($error_subject_label).'</span></label>
				<input type="text" name="contactform_subject" id="contactform_subject" '. (isset($error_class['form_subject']) ? ' class="form-control contactform-error"' : ' class="form-control"').' value="'.esc_attr($form_data['form_subject']).'" />
			</div>
		' : '') .'
		<div class="form-group contactform-captcha-group">
			<label for="contactform_captcha">'.sprintf(esc_attr($captcha_label), $contactform_rand).': <span class="'.(isset($error_class['form_captcha']) ? "contactform-error" : "contactform-hide").'" >'.esc_attr($error_captcha_label).'</span></label>
			<input type="hidden" name="contactform_captcha_hidden" id="contactform_captcha_hidden" value="'.$contactform_rand.'" />
			<input type="text" name="contactform_captcha" id="contactform_captcha" '.(isset($error_class['form_captcha']) ? ' class="form-control contactform-error"' : ' class="form-control"').' value="'.esc_attr($form_data['form_captcha']).'" />
		</div>
		<div class="form-group contactform-hide">
			<input type="text" name="contactform_firstname" id="contactform_firstname" class="form-control" value="'.esc_attr($form_data['form_firstname']).'" />
		</div>
		<div class="form-group contactform-hide">
			<input type="text" name="contactform_lastname" id="contactform_lastname" class="form-control" value="'.esc_attr($form_data['form_lastname']).'" />
		</div>
		<div class="form-group contactform-message-group">
			<label for="contactform_message">'.esc_attr($message_label).': <span class="'.(isset($error_class['form_message']) ? "contactform-error" : "contactform-hide").'" >'.esc_attr($error_message_label).'</span></label>
			<textarea name="contactform_message" id="contactform_message" rows="10" '.(isset($error_class['form_message']) ? ' class="form-control contactform-error"' : ' class="form-control"').'>'.esc_textarea($form_data['form_message']).'</textarea>
		</div>
		'. (($privacy_setting == "yes") ? '
			<div class="form-group contactform-privacy-group">
				<input type="hidden" name="contactform_privacy" id="contactform_privacy_hidden" value="no">
				<label><input type="checkbox" name="contactform_privacy" id="contactform_privacy" class="custom-control-input" value="yes" '.checked( esc_attr($form_data['form_privacy']), "yes", false ).' /> <span class="'.(isset($error_class['form_privacy']) ? "contactform-error" : "").'" >'.esc_attr($privacy_label).'</span></label>
			</div>
		' : '') .'
		<div class="form-group contactform-hide">
			'.$contactform_nonce_field.'
		</div>
		<div class="form-group contactform-submit-group">
			<button type="submit" name="'.$submit_name_id.'" id="'.$submit_name_id.'" class="btn btn-primary">'.esc_attr($submit_label).'</button>
		</div>
	</form>';
