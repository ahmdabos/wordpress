<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}
$email_form = '
<form 
id="form" 
method="post" 
enctype="multipart/form-data">
    <div>
        <label for="form_name">' . esc_attr($name_label) . ': 
        <input 
        type="text" 
        name="form_name" 
        id="form_name" 
        data-validation="required" 
        data-validation-error-msg-required="Name is requierd" 
        value="' . esc_attr($form_data['form_name']) . '" 
    />
    </div>
    <div>
        <label for="form_email">' . esc_attr($email_label) . ': </label>
        <input 
        type="email" 
        name="form_email" 
        id="form_email" 
        data-validation="required email"
        data-validation-error-msg-required="Email is required"
        data-validation-error-msg-email="Enter valid email" 
        value="' . esc_attr($form_data['form_email']) . '" 
        />
    </div>
    <div>
        <label for="form_attachment">' . esc_attr($attachment_label) . ': </label>
        <input 
        type="file"
        name="attachment"  
        id="attachment" 
        >
    </div>
    <div class="form-hide">
        <input 
        type="text" 
        name="form_firstname" 
        id="form_firstname" 
        class="form-control" 
        value="' . esc_attr($form_data['form_firstname']) . '" 
        />
    </div>
    <div class="form-hide">
        <input 
        type="text" 
        name="form_lastname" 
        id="form_lastname" 
        class="form-control" 
        value="' . esc_attr($form_data['form_lastname']) . '" 
        />
    </div>
    <div>' . $form_nonce_field . '</div>
    <div>
        <button 
        type="submit" 
        name="form_send" 
        id="form_send" 
        class="btn btn-primary">' . esc_attr($submit_label) . '
        </button>
    </div>
</form>';
