<?php
// disable direct access
if (!defined('ABSPATH')) {
    exit;
}
// add admin options page
function form_menu_page()
{
    add_options_page(esc_attr__('FORM', 'form'), esc_attr__('form', 'form'), 'manage_options', 'form', 'form_options_page');
}

add_action('admin_menu', 'form_menu_page');
// add admin settings and such
function form_admin_init()
{
    add_settings_section('form-general-section', esc_attr__('General', 'form'), '', 'form-general');

    add_settings_field('form-field-22', esc_attr__('Email', 'form'), 'form_field_callback_22', 'form-general', 'form-general-section');
    register_setting('form-general-options', 'form-setting-22', array('sanitize_callback' => 'sanitize_email'));

    add_settings_field('form-field-1', esc_attr__('Uninstall', 'form'), 'form_field_callback_1', 'form-general', 'form-general-section');
    register_setting('form-general-options', 'form-setting', array('sanitize_callback' => 'sanitize_key'));

    add_settings_field('form-field-2', esc_attr__('Submissions', 'form'), 'form_field_callback_2', 'form-general', 'form-general-section');
    register_setting('form-general-options', 'form-setting-2', array('sanitize_callback' => 'sanitize_key'));


    add_settings_field('form-field-3', esc_attr__('Reply', 'form'), 'form_field_callback_3', 'form-general', 'form-general-section');
    register_setting('form-general-options', 'form-setting-3', array('sanitize_callback' => 'sanitize_key'));

    add_settings_section('form-label-section', esc_attr__('Labels', 'form'), '', 'form-label');

    add_settings_field('form-field-5', esc_attr__('Name', 'form'), 'form_field_callback_5', 'form-label', 'form-label-section');
    register_setting('form-label-options', 'form-setting-5', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('form-field-6', esc_attr__('Email', 'form'), 'form_field_callback_6', 'form-label', 'form-label-section');
    register_setting('form-label-options', 'form-setting-6', array('sanitize_callback' => 'sanitize_text_field'));
    add_settings_field('form-field-7', esc_attr__('Attachment', 'form'), 'form_field_callback_7', 'form-label', 'form-label-section');
    register_setting('form-label-options', 'form-setting-7', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('form-field-10', esc_attr__('Submit', 'form'), 'form_field_callback_10', 'form-label', 'form-label-section');
    register_setting('form-label-options', 'form-setting-10', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_section('form-message-section', esc_attr__('Messages', 'form'), '', 'form-message');

    add_settings_field('form-field-15', esc_attr__('Server error message', 'form'), 'form_field_callback_15', 'form-message', 'form-message-section');
    register_setting('form-message-options', 'form-setting-15', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('form-field-16', esc_attr__('Thank you message', 'form'), 'form_field_callback_16', 'form-message', 'form-message-section');
    register_setting('form-message-options', 'form-setting-16', array('sanitize_callback' => 'sanitize_text_field'));

    add_settings_field('form-field-17', esc_attr__('Reply message', 'form'), 'form_field_callback_17', 'form-message', 'form-message-section');
    register_setting('form-message-options', 'form-setting-17', array('sanitize_callback' => 'sanitize_text_field'));

}

add_action('admin_init', 'form_admin_init');
function form_field_callback_1()
{
    $value = esc_attr(get_option('form-setting'));
    ?>
    <input type='hidden' name='form-setting' value='no'>
    <label><input type='checkbox' name='form-setting' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('Do not delete form submissions and settings.', 'form'); ?></label>
    <?php
}

function form_field_callback_2()
{
    $value = esc_attr(get_option('form-setting-2'));
    ?>
    <input type='hidden' name='form-setting-2' value='no'>
    <label><input type='checkbox' name='form-setting-2' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('List form submissions in dashboard.', 'form'); ?></label>
    <?php
}

function form_field_callback_3()
{
    $value = esc_attr(get_option('form-setting-3'));
    ?>
    <input type='hidden' name='form-setting-3' value='no'>
    <label><input type='checkbox' name='form-setting-3' <?php checked($value, 'yes'); ?>
                  value='yes'> <?php esc_attr_e('Activate confirmation email to sender.', 'form'); ?></label>
    <?php
}

function form_field_callback_5()
{
    $placeholder = esc_attr__('Name', 'form');
    $value = esc_attr(get_option('form-setting-5'));
    echo "<input type='text' size='40' name='form-setting-5' placeholder='$placeholder' value='$value' />";
}

function form_field_callback_6()
{
    $placeholder = esc_attr__('Email', 'form');
    $value = esc_attr(get_option('form-setting-6'));
    echo "<input type='text' size='40' name='form-setting-6' placeholder='$placeholder' value='$value' />";
}

function form_field_callback_7()
{
    $placeholder = esc_attr__('Attachment', 'form');
    $value = esc_attr(get_option('form-setting-7'));
    echo "<input type='text' size='40' name='form-setting-7' placeholder='$placeholder' value='$value' />";
}

function form_field_callback_10()
{
    $placeholder = esc_attr__('Submit', 'form');
    $value = esc_attr(get_option('form-setting-10'));
    echo "<input type='text' size='40' name='form-setting-10' placeholder='$placeholder' value='$value' />";
}

function form_field_callback_15()
{
    $placeholder = esc_attr__('Error! Could not send form. This might be a server issue.', 'form');
    $value = esc_attr(get_option('form-setting-15'));
    echo "<input type='text' size='40' name='form-setting-15' placeholder='$placeholder' value='$value' />";
}

function form_field_callback_16()
{
    $placeholder = esc_attr__('Thank you! You will receive a response as soon as possible.', 'form');
    $value = esc_attr(get_option('form-setting-16'));
    echo "<input type='text' size='40' name='form-setting-16' placeholder='$placeholder' value='$value' />";
}

function form_field_callback_17()
{
    $placeholder = esc_attr__('Thank you! You will receive a response as soon as possible.', 'form');
    $value = esc_attr(get_option('form-setting-17'));
    echo "<input type='text' size='40' name='form-setting-17' placeholder='$placeholder' value='$value' />";
    ?>
    <p><i><?php esc_attr_e('Displayed in the confirmation email to sender.', 'form'); ?></i></p>
    <?php
}

function form_field_callback_22()
{
    $placeholder = esc_attr(get_option('admin_email'));
    $value = esc_attr(get_option('form-setting-22'));
    echo "<input type='text' size='40' name='form-setting-22' placeholder='$placeholder' value='$value' />";
}

// display admin options page
function form_options_page()
{
    ?>
    <div class="wrap">
        <h1><?php esc_attr_e('Form', 'form'); ?></h1>
        <?php
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general_options';
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=form&tab=general_options"
               class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('General', 'form'); ?></a>
            <a href="?page=form&tab=label_options"
               class="nav-tab <?php echo $active_tab == 'label_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Labels', 'form'); ?></a>
            <a href="?page=form&tab=message_options"
               class="nav-tab <?php echo $active_tab == 'message_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Messages', 'form'); ?></a>


        </h2>
        <form action="options.php" method="POST">
            <?php if ($active_tab == 'general_options') { ?>
                <?php settings_fields('form-general-options'); ?>
                <?php do_settings_sections('form-general'); ?>
            <?php } elseif ($active_tab == 'label_options') { ?>
                <?php settings_fields('form-label-options'); ?>
                <?php do_settings_sections('form-label'); ?>
            <?php } else { ?>
                <?php settings_fields('form-message-options'); ?>
                <?php do_settings_sections('form-message'); ?>
            <?php } ?>
            <?php submit_button(); ?>
        </form>

    </div>
    <?php
}
