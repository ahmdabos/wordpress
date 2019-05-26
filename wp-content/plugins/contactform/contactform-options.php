<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}

// add admin options page
function contactform_menu_page()
{
    add_menu_page(
        esc_attr__('contactform', 'contactform'),
        esc_attr__('contactform', 'contactform'),
        'manage_options',
        'contactform',
        'contactform_options_page'
    );
}

add_action('admin_menu', 'contactform_menu_page');

// add admin settings and such
function contactform_admin_init()
{
    add_settings_section(
        'contactform-general-section',
        esc_attr__('General', 'contactform'),
        '',
        'contactform-general'
    );

    add_settings_field(
        'contactform-field-22',
        esc_attr__('Email', 'contactform'),
        'contactform_field_callback_22',
        'contactform-general',
        'contactform-general-section'
    );

    register_setting(
        'contactform-general-options',
        'contactform-setting-22',
        array('sanitize_callback' => 'sanitize_email')
    );


    add_settings_field('contactform-field-1',
        esc_attr__('Uninstall', 'contactform'),
        'contactform_field_callback_1',
        'contactform-general',
        'contactform-general-section');

    register_setting(
        'contactform-general-options',
        'contactform-setting',
        array('sanitize_callback' => 'sanitize_key')
    );


    add_settings_field('contactform-field-2', esc_attr__('Submissions', 'contactform'), 'contactform_field_callback_2', 'contactform-general', 'contactform-general-section');
    register_setting('contactform-general-options', 'contactform-setting-2', array('sanitize_callback' => 'sanitize_key'));

    add_settings_field('contactform-field-23', esc_attr__('Subject', 'contactform'), 'contactform_field_callback_23', 'contactform-general', 'contactform-general-section');
    register_setting('contactform-general-options', 'contactform-setting-23', array('sanitize_callback' => 'sanitize_key'));

    add_settings_field('contactform-field-3', esc_attr__('Reply', 'contactform'), 'contactform_field_callback_3', 'contactform-general', 'contactform-general-section');
    register_setting('contactform-general-options', 'contactform-setting-3', array('sanitize_callback' => 'sanitize_key'));

    add_settings_field('contactform-field-4', esc_attr__('Privacy', 'contactform'), 'contactform_field_callback_4', 'contactform-general', 'contactform-general-section');
    register_setting('contactform-general-options', 'contactform-setting-4', array('sanitize_callback' => 'sanitize_key'));

    add_settings_field('contactform-field-19', esc_attr__('Privacy', 'contactform'), 'contactform_field_callback_19', 'contactform-general', 'contactform-general-section');
    register_setting('contactform-general-options', 'contactform-setting-19', array('sanitize_callback' => 'sanitize_key'));

    add_settings_field('contactform-field-21', esc_attr__('Anchor', 'contactform'), 'contactform_field_callback_21', 'contactform-general', 'contactform-general-section');
    register_setting('contactform-general-options', 'contactform-setting-21', array('sanitize_callback' => 'sanitize_key'));

    add_settings_section('contactform-label-section', esc_attr__('Labels', 'contactform'), '', 'contactform-label');

    add_settings_field('contactform-field-5', esc_attr__('Name', 'contactform'), 'contactform_field_callback_5', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-5', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-6', esc_attr__('Email', 'contactform'), 'contactform_field_callback_6', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-6', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-7', esc_attr__('Subject', 'contactform'), 'contactform_field_callback_7', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-7', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-8', esc_attr__('Captcha', 'contactform'), 'contactform_field_callback_8', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-8', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-9', esc_attr__('Message', 'contactform'), 'contactform_field_callback_9', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-9', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-18', esc_attr__('Privacy', 'contactform'), 'contactform_field_callback_18', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-18', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-10', esc_attr__('Submit', 'contactform'), 'contactform_field_callback_10', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-10', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-11', esc_attr__('Name error', 'contactform'), 'contactform_field_callback_11', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-11', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-13', esc_attr__('Email error', 'contactform'), 'contactform_field_callback_13', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-13', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-20', esc_attr__('Subject error', 'contactform'), 'contactform_field_callback_20', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-20', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-14', esc_attr__('Captcha error', 'contactform'), 'contactform_field_callback_14', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-14', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-12', esc_attr__('Message error', 'contactform'), 'contactform_field_callback_12', 'contactform-label', 'contactform-label-section');
    register_setting('contactform-label-options', 'contactform-setting-12', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_section('contactform-message-section', esc_attr__('Messages', 'contactform'), '', 'contactform-message');

    add_settings_field('contactform-field-15',
        esc_attr__('Server error message', 'contactform'),
        'contactform_field_callback_15',
        'contactform-message',
        'contactform-message-section'
    );

    register_setting('contactform-message-options', 'contactform-setting-15', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-16', esc_attr__('Thank you message', 'contactform'), 'contactform_field_callback_16', 'contactform-message', 'contactform-message-section');
    register_setting('contactform-message-options', 'contactform-setting-16', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('contactform-field-17', esc_attr__('Reply message', 'contactform'), 'contactform_field_callback_17', 'contactform-message', 'contactform-message-section');
    register_setting('contactform-message-options', 'contactform-setting-17', array('sanitize_callback' => 'sanitize_text_field'));
}

add_action('admin_init', 'contactform_admin_init');

function contactform_field_callback_22()
{
    $placeholder = esc_attr(get_option('admin_email'));
    $value = esc_attr(get_option('contactform-setting-22'));
    echo "<input type='text' size='40' name='contactform-setting-22' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_1()
{
    $value = esc_attr(get_option('contactform-setting'));
    ?>
    <input type='hidden' name='contactform-setting' value='no'>
    <label><input type='checkbox' name='contactform-setting' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('Do not delete form submissions and settings.', 'contactform'); ?></label>
    <?php
}

function contactform_field_callback_2()
{
    $value = esc_attr(get_option('contactform-setting-2'));
    ?>
    <input type='hidden' name='contactform-setting-2' value='no'>
    <label><input type='checkbox' name='contactform-setting-2' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('List form submissions in dashboard.', 'contactform'); ?></label>
    <?php
}

function contactform_field_callback_23()
{
    $value = esc_attr(get_option('contactform-setting-23'));
    ?>
    <input type='hidden' name='contactform-setting-23' value='no'>
    <label><input type='checkbox' name='contactform-setting-23' <?php checked($value, 'yes'); ?> value='yes'> <?php esc_attr_e('Hide subject field.', 'contactform'); ?>
    </label>
    <?php
}

function contactform_field_callback_3()
{
    $value = esc_attr(get_option('contactform-setting-3'));
    ?>
    <input type='hidden' name='contactform-setting-3' value='no'>
    <label><input type='checkbox' name='contactform-setting-3' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('Activate confirmation email to sender.', 'contactform'); ?></label>
    <?php
}

function contactform_field_callback_4()
{
    $value = esc_attr(get_option('contactform-setting-4'));
    ?>
    <input type='hidden' name='contactform-setting-4' value='no'>
    <label><input type='checkbox' name='contactform-setting-4' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('Activate privacy consent checkbox on form.', 'contactform'); ?></label>
    <?php
}

function contactform_field_callback_19()
{
    $value = esc_attr(get_option('contactform-setting-19'));
    ?>
    <input type='hidden' name='contactform-setting-19' value='no'>
    <label><input type='checkbox' name='contactform-setting-19' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('Disable collection of IP address.', 'contactform'); ?></label>
    <?php
}

function contactform_field_callback_21()
{
    $value = esc_attr(get_option('contactform-setting-21'));
    ?>
    <input type='hidden' name='contactform-setting-21' value='no'>
    <label><input type='checkbox' name='contactform-setting-21' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('Scroll back to form position after submit.', 'contactform'); ?></label>
    <?php
}

function contactform_field_callback_5()
{
    $placeholder = esc_attr__('Name', 'contactform');
    $value = esc_attr(get_option('contactform-setting-5'));
    echo "<input type='text' size='40' name='contactform-setting-5' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_6()
{
    $placeholder = esc_attr__('Email', 'contactform');
    $value = esc_attr(get_option('contactform-setting-6'));
    echo "<input type='text' size='40' name='contactform-setting-6' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_7()
{
    $placeholder = esc_attr__('Subject', 'contactform');
    $value = esc_attr(get_option('contactform-setting-7'));
    echo "<input type='text' size='40' name='contactform-setting-7' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_8()
{
    $placeholder = esc_attr__('Enter number %s', 'contactform');
    $value = esc_attr(get_option('contactform-setting-8'));
    echo "<input type='text' size='40' name='contactform-setting-8' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_9()
{
    $placeholder = esc_attr__('Message', 'contactform');
    $value = esc_attr(get_option('contactform-setting-9'));
    echo "<input type='text' size='40' name='contactform-setting-9' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_18()
{
    $placeholder = esc_attr__('I consent to having this website collect my personal data via this form.', 'contactform');
    $value = esc_attr(get_option('contactform-setting-18'));
    echo "<input type='text' size='40' name='contactform-setting-18' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_10()
{
    $placeholder = esc_attr__('Submit', 'contactform');
    $value = esc_attr(get_option('contactform-setting-10'));
    echo "<input type='text' size='40' name='contactform-setting-10' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_11()
{
    $placeholder = esc_attr__('Please enter at least 2 characters', 'contactform');
    $value = esc_attr(get_option('contactform-setting-11'));
    echo "<input type='text' size='40' name='contactform-setting-11' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_13()
{
    $placeholder = esc_attr__('Please enter a valid email', 'contactform');
    $value = esc_attr(get_option('contactform-setting-13'));
    echo "<input type='text' size='40' name='contactform-setting-13' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_20()
{
    $placeholder = esc_attr__('Please enter at least 2 characters', 'contactform');
    $value = esc_attr(get_option('contactform-setting-20'));
    echo "<input type='text' size='40' name='contactform-setting-20' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_14()
{
    $placeholder = esc_attr__('Please enter the correct number', 'contactform');
    $value = esc_attr(get_option('contactform-setting-14'));
    echo "<input type='text' size='40' name='contactform-setting-14' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_12()
{
    $placeholder = esc_attr__('Please enter at least 10 characters', 'contactform');
    $value = esc_attr(get_option('contactform-setting-12'));
    echo "<input type='text' size='40' name='contactform-setting-12' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_15()
{
    $placeholder = esc_attr__('Error! Could not send form. This might be a server issue.', 'contactform');
    $value = esc_attr(get_option('contactform-setting-15'));
    echo "<input type='text' size='40' name='contactform-setting-15' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_16()
{
    $placeholder = esc_attr__('Thank you! You will receive a response as soon as possible.', 'contactform');
    $value = esc_attr(get_option('contactform-setting-16'));
    echo "<input type='text' size='40' name='contactform-setting-16' placeholder='$placeholder' value='$value' />";
}

function contactform_field_callback_17()
{
    $placeholder = esc_attr__('Thank you! You will receive a response as soon as possible.', 'contactform');
    $value = esc_attr(get_option('contactform-setting-17'));
    echo "<input type='text' size='40' name='contactform-setting-17' placeholder='$placeholder' value='$value' />";
    ?>
    <p><i><?php esc_attr_e('Displayed in the confirmation email to sender.', 'contactform'); ?></i></p>
    <?php
}

// display admin options page
function contactform_options_page()
{
    ?>
    <div class="wrap">
        <h1><?php esc_attr_e('Contact Form', 'contactform'); ?></h1>
        <?php
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general_options';
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=contactform&tab=general_options"
               class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('General', 'contactform'); ?></a>
            <a href="?page=contactform&tab=label_options"
               class="nav-tab <?php echo $active_tab == 'label_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Labels', 'contactform'); ?></a>
            <a href="?page=contactform&tab=message_options"
               class="nav-tab <?php echo $active_tab == 'message_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Messages', 'contactform'); ?></a>
        </h2>
        <form action="options.php" method="POST">
            <?php if ($active_tab == 'general_options') { ?>
                <?php settings_fields('contactform-general-options'); ?>
                <?php do_settings_sections('contactform-general'); ?>
            <?php } elseif ($active_tab == 'label_options') { ?>
                <?php settings_fields('contactform-label-options'); ?>
                <?php do_settings_sections('contactform-label'); ?>
            <?php } else { ?>
                <?php settings_fields('contactform-message-options'); ?>
                <?php do_settings_sections('contactform-message'); ?>
            <?php } ?>
            <?php submit_button(); ?>
        </form>
        <p><?php esc_attr_e('More customizations can be made by using (shortcode) attributes.', 'contactform'); ?></p>

        <h4>usage:</h4>
        <p>Misc:</p>
        <ul>
            <li>Change admin email address: <code>email_to="your-email-here"</code></li>
            <li>Send to multiple email addresses: <code>email_to="first-email-here, second-email-here"</code></li>
            <li>Change &ldquo;From&rdquo; email header: <code>from_header="your-email-here"</code></li>
            <li>Change email subject: <code>subject="your subject here"</code></li>
            <li>Change CSS class of form: <code>class="your-class-here"</code></li>
        </ul>
        <p>Field labels:</p>
        <ul>
            <li>Change name label: <code>label_name="your label here"</code></li>
            <li>Change email label: <code>label_email="your label here"</code></li>
            <li>Change subject label: <code>label_subject="your label here"</code></li>
            <li>Change captcha label: <code>label_captcha="your label here"</code></li>
            <li>Change message label: <code>label_message="your label here"</code></li>
            <li>Change privacy consent label: <code>label_privacy="your label here"</code></li>
            <li>Change submit label: <code>label_submit="your label here"</code></li>
        </ul>
        <p>Field error labels:</p>
        <ul>
            <li>Change name error label: <code>error_name="your label here"</code></li>
            <li>Change email error label: <code>error_email="your label here"</code></li>
            <li>Change subject error label: <code>error_subject="your label here"</code></li>
            <li>Change captcha error label: <code>error_captcha="your label here"</code></li>
            <li>Change message error label: <code>error_message="your label here"</code></li>
        </ul>
        <p>Form messages:</p>
        <ul>
            <li>Change sending failed message: <code>message_error="your message here"</code></li>
            <li>Change sending succeeded (&ldquo;thank you&rdquo;) message: <code>message_success="your message here"</code></li>
            <li>Change &ldquo;thank you&rdquo; message in confirmation email: <code>auto_reply_message="your message here"</code></li>
        </ul>
        <p>Examples:</p>
        <ul>
            <li>One attribute: <code>[contact email_to="your-email-here"]</code></li>
            <li>Multiple attributes: <code>[contact email_to="your-email-here" subject="your subject here" auto_reply="true"]</code></li>
        </ul>
        <h4>Widget attributes</h4>
        <p>The widget supports the same attributes. You don&rsquo;t have to add the main shortcode tag or the brackets.</p>
        <p>Examples:</p>
        <ul>
            <li>One attribute: <code>email_to="your-email-here"</code></li>
            <li>Multiple attributes: <code>email_to="your-email-here" subject="your subject here" auto_reply="true"</code></li>
        </ul>
        <h4>List form submissions in dashboard</h4>
        <p>Via Settings &gt; VSCF you can activate the listing of form submissions in your dashboard.</p>
        <p>After activation you will notice a new menu item called &ldquo;Submissions&rdquo;.</p>
        <h4>SMTP</h4>
        <p>SMTP (Simple Mail Transfer Protocol) is an internet standard for sending emails.</p>
        <p>WordPress supports the PHP <code>mail()</code> function by default, but when using SMTP there&rsquo;s less chance your form submissions are being marked as
            spam.</p>
        <p>You should install an additional plugin for this. You could install for example:</p>
        <ul>
            <li><a href="https://wordpress.org/plugins/gmail-smtp/">Gmail SMTP</a></li>
            <li><a href="https://wordpress.org/plugins/easy-wp-smtp/">Easy WP SMTP</a></li>
            <li><a href="https://wordpress.org/plugins/wp-mail-smtp/">WP mail SMTP</a></li>
            <li><a href="https://wordpress.org/plugins/post-smtp/">Post SMTP</a></li>
        </ul>


    </div>
    <?php
}
