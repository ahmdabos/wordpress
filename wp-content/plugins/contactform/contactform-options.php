<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// add admin options page
function contactform_menu_page() {
    add_options_page( esc_attr__( 'CONTACTFORM', 'contact-form' ), esc_attr__( 'CONTACTFORM', 'contact-form' ), 'manage_options', 'contactform', 'contactform_options_page' );
}
add_action( 'admin_menu', 'contactform_menu_page' );

// add admin settings and such
function contactform_admin_init() {
	add_settings_section( 'contactform-general-section', esc_attr__( 'General', 'contact-form' ), '', 'contactform-general' );

	add_settings_field( 'contactform-field-22', esc_attr__( 'Email', 'contact-form' ), 'contactform_field_callback_22', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting-22', array('sanitize_callback' => 'sanitize_email') );

	add_settings_field( 'contactform-field-1', esc_attr__( 'Uninstall', 'contact-form' ), 'contactform_field_callback_1', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting', array('sanitize_callback' => 'sanitize_key') );

	add_settings_field( 'contactform-field-2', esc_attr__( 'Submissions', 'contact-form' ), 'contactform_field_callback_2', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting-2', array('sanitize_callback' => 'sanitize_key') );
	
	add_settings_field( 'contactform-field-23', esc_attr__( 'Subject', 'contact-form' ), 'contactform_field_callback_23', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting-23', array('sanitize_callback' => 'sanitize_key') );

	add_settings_field( 'contactform-field-3', esc_attr__( 'Reply', 'contact-form' ), 'contactform_field_callback_3', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting-3', array('sanitize_callback' => 'sanitize_key') );

	add_settings_field( 'contactform-field-4', esc_attr__( 'Privacy', 'contact-form' ), 'contactform_field_callback_4', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting-4', array('sanitize_callback' => 'sanitize_key') );

	add_settings_field( 'contactform-field-19', esc_attr__( 'Privacy', 'contact-form' ), 'contactform_field_callback_19', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting-19', array('sanitize_callback' => 'sanitize_key') );

	add_settings_field( 'contactform-field-21', esc_attr__( 'Anchor', 'contact-form' ), 'contactform_field_callback_21', 'contactform-general', 'contactform-general-section' );
	register_setting( 'contactform-general-options', 'contactform-setting-21', array('sanitize_callback' => 'sanitize_key') );

	add_settings_section( 'contactform-label-section', esc_attr__( 'Labels', 'contact-form' ), '', 'contactform-label' );

	add_settings_field( 'contactform-field-5', esc_attr__( 'Name', 'contact-form' ), 'contactform_field_callback_5', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-5', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-6', esc_attr__( 'Email', 'contact-form' ), 'contactform_field_callback_6', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-6', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-7', esc_attr__( 'Subject', 'contact-form' ), 'contactform_field_callback_7', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-7', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-8', esc_attr__( 'Captcha', 'contact-form' ), 'contactform_field_callback_8', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-8', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-9', esc_attr__( 'Message', 'contact-form' ), 'contactform_field_callback_9', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-9', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-18', esc_attr__( 'Privacy', 'contact-form' ), 'contactform_field_callback_18', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-18', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-10', esc_attr__( 'Submit', 'contact-form' ), 'contactform_field_callback_10', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-10', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-11', esc_attr__( 'Name error', 'contact-form' ), 'contactform_field_callback_11', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-11', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-13', esc_attr__( 'Email error', 'contact-form' ), 'contactform_field_callback_13', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-13', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-20', esc_attr__( 'Subject error', 'contact-form' ), 'contactform_field_callback_20', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-20', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-14', esc_attr__( 'Captcha error', 'contact-form' ), 'contactform_field_callback_14', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-14', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-12', esc_attr__( 'Message error', 'contact-form' ), 'contactform_field_callback_12', 'contactform-label', 'contactform-label-section' );
	register_setting( 'contactform-label-options', 'contactform-setting-12', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_section( 'contactform-message-section', esc_attr__( 'Messages', 'contact-form' ), '', 'contactform-message' );

	add_settings_field( 'contactform-field-15', esc_attr__( 'Server error message', 'contact-form' ), 'contactform_field_callback_15', 'contactform-message', 'contactform-message-section' );
	register_setting( 'contactform-message-options', 'contactform-setting-15', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-16', esc_attr__( 'Thank you message', 'contact-form' ), 'contactform_field_callback_16', 'contactform-message', 'contactform-message-section' );
	register_setting( 'contactform-message-options', 'contactform-setting-16', array('sanitize_callback' => 'sanitize_text_field') );

	add_settings_field( 'contactform-field-17', esc_attr__( 'Reply message', 'contact-form' ), 'contactform_field_callback_17', 'contactform-message', 'contactform-message-section' );
	register_setting( 'contactform-message-options', 'contactform-setting-17', array('sanitize_callback' => 'sanitize_text_field') );
}
add_action( 'admin_init', 'contactform_admin_init' );

function contactform_field_callback_22() {
	$placeholder = esc_attr( get_option( 'admin_email' ) );
	$value = esc_attr( get_option( 'contactform-setting-22' ) );
	echo "<input type='text' size='40' name='contactform-setting-22' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_1() {
	$value = esc_attr( get_option( 'contactform-setting' ) );
	?>
	<input type='hidden' name='contactform-setting' value='no'>
	<label><input type='checkbox' name='contactform-setting' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Do not delete form submissions and settings.', 'contact-form' ); ?></label>
	<?php
}

function contactform_field_callback_2() {
	$value = esc_attr( get_option( 'contactform-setting-2' ) );
	?>
	<input type='hidden' name='contactform-setting-2' value='no'>
	<label><input type='checkbox' name='contactform-setting-2' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'List form submissions in dashboard.', 'contact-form' ); ?></label>
	<?php
}

function contactform_field_callback_23() {
	$value = esc_attr( get_option( 'contactform-setting-23' ) );
	?>
	<input type='hidden' name='contactform-setting-23' value='no'>
	<label><input type='checkbox' name='contactform-setting-23' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Disable subject field.', 'contact-form' ); ?></label>
	<?php
}

function contactform_field_callback_3() {
	$value = esc_attr( get_option( 'contactform-setting-3' ) );
	?>
	<input type='hidden' name='contactform-setting-3' value='no'>
	<label><input type='checkbox' name='contactform-setting-3' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Activate confirmation email to sender.', 'contact-form' ); ?></label>
	<?php
}

function contactform_field_callback_4() {
	$value = esc_attr( get_option( 'contactform-setting-4' ) );
	?>
	<input type='hidden' name='contactform-setting-4' value='no'>
	<label><input type='checkbox' name='contactform-setting-4' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Activate privacy consent checkbox on form.', 'contact-form' ); ?></label>
	<?php
}

function contactform_field_callback_19() {
	$value = esc_attr( get_option( 'contactform-setting-19' ) );
	?>
	<input type='hidden' name='contactform-setting-19' value='no'>
	<label><input type='checkbox' name='contactform-setting-19' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Disable collection of IP address.', 'contact-form' ); ?></label>
	<?php
}

function contactform_field_callback_21() {
	$value = esc_attr( get_option( 'contactform-setting-21' ) );
	?>
	<input type='hidden' name='contactform-setting-21' value='no'>
	<label><input type='checkbox' name='contactform-setting-21' <?php checked( $value, 'yes' ); ?> value='yes'> <?php esc_attr_e( 'Scroll back to form position after submit.', 'contact-form' ); ?></label>
	<?php
}

function contactform_field_callback_5() {
	$placeholder = esc_attr__( 'Name', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-5' ) );
	echo "<input type='text' size='40' name='contactform-setting-5' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_6() {
	$placeholder = esc_attr__( 'Email', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-6' ) );
	echo "<input type='text' size='40' name='contactform-setting-6' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_7() {
	$placeholder = esc_attr__( 'Subject', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-7' ) );
	echo "<input type='text' size='40' name='contactform-setting-7' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_8() {
	$placeholder = esc_attr__( 'Enter number %s', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-8' ) );
	echo "<input type='text' size='40' name='contactform-setting-8' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_9() {
	$placeholder = esc_attr__( 'Message', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-9' ) );
	echo "<input type='text' size='40' name='contactform-setting-9' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_18() {
	$placeholder = esc_attr__( 'I consent to having this website collect my personal data via this form.', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-18' ) );
	echo "<input type='text' size='40' name='contactform-setting-18' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_10() {
	$placeholder = esc_attr__( 'Submit', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-10' ) );
	echo "<input type='text' size='40' name='contactform-setting-10' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_11() {
	$placeholder = esc_attr__( 'Please enter at least 2 characters', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-11' ) );
	echo "<input type='text' size='40' name='contactform-setting-11' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_13() {
	$placeholder = esc_attr__( 'Please enter a valid email', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-13' ) );
	echo "<input type='text' size='40' name='contactform-setting-13' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_20() {
	$placeholder = esc_attr__( 'Please enter at least 2 characters', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-20' ) );
	echo "<input type='text' size='40' name='contactform-setting-20' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_14() {
	$placeholder = esc_attr__( 'Please enter the correct number', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-14' ) );
	echo "<input type='text' size='40' name='contactform-setting-14' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_12() {
	$placeholder = esc_attr__( 'Please enter at least 10 characters', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-12' ) );
	echo "<input type='text' size='40' name='contactform-setting-12' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_15() {
	$placeholder = esc_attr__( 'Error! Could not send form. This might be a server issue.', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-15' ) );
	echo "<input type='text' size='40' name='contactform-setting-15' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_16() {
	$placeholder = esc_attr__( 'Thank you! You will receive a response as soon as possible.', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-16' ) );
	echo "<input type='text' size='40' name='contactform-setting-16' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_17() {
	$placeholder = esc_attr__( 'Thank you! You will receive a response as soon as possible.', 'contact-form' );
	$value = esc_attr( get_option( 'contactform-setting-17' ) );
	echo "<input type='text' size='40' name='contactform-setting-17' placeholder='$placeholder' value='$value' />";
	?>
	<p><i><?php esc_attr_e( 'Displayed in the confirmation email to sender.', 'contact-form' ); ?></i></p>
	<?php
}

// display admin options page
function contactform_options_page() {
?>
<div class="wrap">
	<h1><?php esc_attr_e( 'Contact Form', 'contact-form' ); ?></h1>
	<?php
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general_options';
	?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=contactform&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'General', 'contact-form' ); ?></a>
		<a href="?page=contactform&tab=label_options" class="nav-tab <?php echo $active_tab == 'label_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Labels', 'contact-form' ); ?></a>
		<a href="?page=contactform&tab=message_options" class="nav-tab <?php echo $active_tab == 'message_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e( 'Messages', 'contact-form' ); ?></a>
	</h2>
	<form action="options.php" method="POST">
		<?php if( $active_tab == 'general_options' ) { ?>
			<?php settings_fields( 'contactform-general-options' ); ?>
			<?php do_settings_sections( 'contactform-general' ); ?>
		<?php } elseif( $active_tab == 'label_options' ) { ?>
			<?php settings_fields( 'contactform-label-options' ); ?>
			<?php do_settings_sections( 'contactform-label' ); ?>
		<?php } else { ?>
			<?php settings_fields( 'contactform-message-options' ); ?>
			<?php do_settings_sections( 'contactform-message' ); ?>
		<?php } ?>
		<?php submit_button(); ?>
	</form>
	<div>
        <p>Add shortcode [contact] on a page or use the widget to display your form.<br />Form has fields for Name, Email, Subject and Message. It also has a privacy consent checkbox and a simple numeric captcha.<br />You can personalize your form via the settingspage or by adding attributes to the shortcode or the widget.<br />It&rsquo;s also possible to list form submissions in your dashboard.<br />How to use<br />After installation add shortcode [contact] on a page or use the widget to display your form.<br />Settingspage<br />Via Settings:</p>
        <p>You can add attributes to the shortcode mentioned above.</p>
        <p>Misc:</p>
        <p>Change admin email address: email_to="your-email-here"<br /> Send to multiple email addresses: email_to="first-email-here, second-email-here"<br /> Change &ldquo;From&rdquo; email header: from_header="your-email-here"<br /> Change email subject: subject="your subject here"<br /> Change CSS class of form: class="your-class-here"</p>
        <p>Field labels:</p>
        <p>Change name label: label_name="your label here"<br /> Change email label: label_email="your label here"<br /> Change subject label: label_subject="your label here"<br /> Change captcha label: label_captcha="your label here"<br /> Change message label: label_message="your label here"<br /> Change privacy consent label: label_privacy="your label here"<br /> Change submit label: label_submit="your label here"</p>
        <p>Field error labels:</p>
        <p>Change name error label: error_name="your label here"<br /> Change email error label: error_email="your label here"<br /> Change subject error label: error_subject="your label here"<br /> Change captcha error label: error_captcha="your label here"<br /> Change message error label: error_message="your label here"</p>
        <p>Form messages:</p>
        <p>Change message when sending fails: message_error="your message here"<br /> Change message when sending succeeds: message_success="your message here"<br /> Change message in confirmation email when sending succeeds: auto_reply_message="your message here"</p>
        <p>Examples:</p>
        <p>One attribute: [contact email_to="your-email-here"]<br /> Multiple attributes: [contact email_to="your-email-here" subject="your subject here" auto_reply="true"]</p>
        <p>Widget attributes</p>
        <p>The widget supports the same attributes. You don&rsquo;t have to add the main shortcode tag or the brackets.</p>
        <p>Examples:</p>
        <p>One attribute: email_to="your-email-here"<br /> Multiple attributes: email_to="your-email-here" subject="your subject here" auto_reply="true"</p>
        <p>List form submissions in dashboard</p>
        <p>you can activate the listing of form submissions in your dashboard.</p>
        <p>After activation you will notice a new menu item called &ldquo;Submissions&rdquo;.<br />SMTP</p>
        <p>SMTP (Simple Mail Transfer Protocol) is an internet standard for sending emails.</p>
        <p>WordPress supports the PHP mail() function by default, but when using SMTP there&rsquo;s less chance your form submissions are being marked as spam.</p>
        <p>You should install an additional plugin for this. You could install for example:</p>
        <p>Post SMTP<br /> WP mail SMTP<br /> Easy WP SMTP<br /> Gmail SMTP</p>
        <p>If you uninstall plugin via dashboard all form submissions and settings will be removed from database.</p>
        <p>All posts of the (custom) post type &ldquo;submission&rdquo; will be removed.</p>
    </div>
</div>
<?php
}
