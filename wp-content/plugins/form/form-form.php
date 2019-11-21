<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

// contact form
$email_form = '<form id="form" class="' . $form_atts['class'] . '" method="post" enctype="multipart/form-data">
		<div class="form-group form-name-group">
			<label for="form_name">' . esc_attr($name_label) . ': <span class="' . (isset($error_class['form_name']) ? "form-error" : "form-hide") . '" >' . esc_attr($error_name_label) . '</span></label>
			<input type="text" name="form_name" id="form_name" ' . (isset($error_class['form_name']) ? ' class="form-control form-error"' : ' class="form-control"') . ' value="' . esc_attr($form_data['form_name']) . '" />
		</div>
		<div class="form-group form-email-group">
			<label for="form_email">' . esc_attr($email_label) . ': <span class="' . (isset($error_class['form_email']) ? "form-error" : "form-hide") . '" >' . esc_attr($error_email_label) . '</span></label>
			<input type="email" name="form_email" id="form_email" ' . (isset($error_class['form_email']) ? ' class="form-control form-error"' : ' class="form-control"') . ' value="' . esc_attr($form_data['form_email']) . '" />
		</div>
		' . (($subject_setting != "yes") ? '
			<div class="form-group form-subject-group">
				<label for="form_subject">' . esc_attr($subject_label) . ': <span class="' . (isset($error_class['form_subject']) ? "form-error" : "form-hide") . '" >' . esc_attr($error_subject_label) . '</span></label>
				<input type="text" name="form_subject" id="form_subject" ' . (isset($error_class['form_subject']) ? ' class="form-control form-error"' : ' class="form-control"') . ' value="' . esc_attr($form_data['form_subject']) . '" />
			</div>
		' : '') . '
		<div class="form-group form-captcha-group">
			<label for="form_captcha">' . sprintf(esc_attr($captcha_label), $form_rand) . ': <span class="' . (isset($error_class['form_captcha']) ? "form-error" : "form-hide") . '" >' . esc_attr($error_captcha_label) . '</span></label>
			<input type="hidden" name="form_captcha_hidden" id="form_captcha_hidden" value="' . $form_rand . '" />
			<input type="text" name="form_captcha" id="form_captcha" ' . (isset($error_class['form_captcha']) ? ' class="form-control form-error"' : ' class="form-control"') . ' value="' . esc_attr($form_data['form_captcha']) . '" />
		</div>
		<div class="form-group form-hide">
			<input type="text" name="form_firstname" id="form_firstname" class="form-control" value="' . esc_attr($form_data['form_firstname']) . '" />
		</div>
		<div class="form-group form-hide">
			<input type="text" name="form_lastname" id="form_lastname" class="form-control" value="' . esc_attr($form_data['form_lastname']) . '" />
		</div>
		<div class="form-group form-message-group">
			<label for="form_message">' . esc_attr($message_label) . ': <span class="' . (isset($error_class['form_message']) ? "form-error" : "form-hide") . '" >' . esc_attr($error_message_label) . '</span></label>
			<textarea name="form_message" id="form_message" rows="10" ' . (isset($error_class['form_message']) ? ' class="form-control form-error"' : ' class="form-control"') . '>' . esc_textarea($form_data['form_message']) . '</textarea>
		</div>
		<div class="form-group form-message-group">
		 <input id="attachment" accept=".doc,.docx,.pdf" name="attachment" type="file">
		 </div>
		' . (($privacy_setting == "yes") ? '
			<div class="form-group form-privacy-group">
				<input type="hidden" name="form_privacy" id="form_privacy_hidden" value="no" />
				<label><input type="checkbox" name="form_privacy" id="form_privacy" class="custom-control-input" value="yes" ' . checked(esc_attr($form_data['form_privacy']), "yes", false) . ' /> <span class="' . (isset($error_class['form_privacy']) ? "form-error" : "") . '" >' . esc_attr($privacy_label) . '</span></label>
			</div>
		' : '') . '
		<div class="form-group form-hide">
			' . $form_nonce_field . '
		</div>
		<div class="form-group form-submit-group">
			<button type="submit" name="' . $submit_name_id . '" id="' . $submit_name_id . '" class="btn btn-primary">' . esc_attr($submit_label) . '</button>
		</div>
	</form>';
