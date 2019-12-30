<?php
if (!defined('ABSPATH')) {
    exit;
}
// create submission post type
function submissions_postype()
{
    $form_args = array(
        'labels' => array('name' => esc_attr__('Submissions', 'form')),
        'menu_icon' => 'dashicons-email',
        'public' => false,
        'can_export' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_in_rest' => false,
        'capability_type' => 'post',
        'capabilities' => array('create_posts' => 'do_not_allow'),
        'map_meta_cap' => true,
        'supports' => array('title', 'editor')
    );
    register_post_type('submission', $form_args);
}

add_action('init', 'submissions_postype');

class Submission_Info_Meta_Box
{
    public function __construct()
    {
        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }
    }

    public function init_metabox()
    {
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);

    }

    public function add_metabox()
    {

        add_meta_box(
            'submission_info',
            __('Submission Info', 'text_domain'),
            array($this, 'render_metabox'),
            'submission',
            'advanced',
            'default'
        );

    }

    public function render_metabox($post)
    {

        // Add nonce for security and authentication.
        wp_nonce_field('submission_nonce_action', 'submission_nonce');

        // Retrieve an existing value from the database.
        $submission_name = get_post_meta($post->ID, 'submission_name', true);
        $submission_email = get_post_meta($post->ID, 'submission_email', true);
        $submission_attachment = get_post_meta($post->ID, 'submission_attachment', true);


        // Set default values.
        if (empty($submission_name)) $submission_name = '';
        if (empty($submission_email)) $submission_email = '';
        if (empty($submission_attachment)) $submission_attachment = '';


        // Form fields.
        echo '<table class="form-table">';

        echo '	<tr>';
        echo '		<th><label for="submission_name" class="submission_name_label">' . __('Name', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '			<input type="text" id="submission_name" name="submission_name" class="submission_name_field" placeholder="' . esc_attr__('', 'text_domain') . '" value="' . esc_attr__($submission_name) . '">';
        echo '		</td>';
        echo '	</tr>';


        echo '	<tr>';
        echo '		<th><label for="submission_email" class="submission_email_label">' . __('Email', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '			<input type="text" id="submission_email" name="submission_email" class="submission_email_field" placeholder="' . esc_attr__('', 'text_domain') . '" value="' . esc_attr__($submission_email) . '">';
        echo '		</td>';
        echo '	</tr>';

        $upload_dir = wp_upload_dir();
        echo '	<tr>';
        echo '		<th><label for="submission_attachment" class="submission_attachment_label">' . __('Attachment', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '          <img src="' . $upload_dir['baseurl'] . '/files/' . esc_attr__($submission_attachment) . '"/>';
        echo '		</td>';

        echo '	</tr>';
        echo '</table>';


    }

    public function save_metabox($post_id, $post)
    {

        // Add nonce for security and authentication.
        $nonce_name = $_POST['submission_nonce'];
        $nonce_action = 'submission_nonce_action';

        // Check if a nonce is set.
        if (!isset($nonce_name))
            return;

        // Check if a nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action))
            return;

        // Check if the user has permissions to save data.
        if (!current_user_can('edit_post', $post_id))
            return;

        // Check if it's not an autosave.
        if (wp_is_post_autosave($post_id))
            return;

        // Check if it's not a revision.
        if (wp_is_post_revision($post_id))
            return;

        // Sanitize user input.
        $submission_new_name = isset($_POST['submission_name']) ? sanitize_text_field($_POST['submission_name']) : '';
        $submission_new_email = isset($_POST['submission_email']) ? sanitize_text_field($_POST['submission_email']) : '';
        $submission_new_attachment = isset($_POST['submission_attachment']) ? $_POST['submission_attachment'] : '';


        // Update the meta field in the database.
        update_post_meta($post_id, 'submission_name', $submission_new_name);
        update_post_meta($post_id, 'submission_email', $submission_new_email);
        update_post_meta($post_id, 'submission_attachment', $submission_new_attachment);


    }
}

new Submission_Info_Meta_Box;

// dashboard submission columns
function form_custom_columns($columns)
{
    $columns['name_column'] = esc_attr__('Name', 'form');
    $columns['email_column'] = esc_attr__('Email', 'form');
    $columns['attachment_column'] = esc_attr__('Attachment', 'form');
    $custom_order = array('cb', 'title', 'name_column', 'email_column', 'attachment_column', 'date');
    foreach ($custom_order as $colname) {
        $new[$colname] = $columns[$colname];
    }
    return $new;
}

add_filter('manage_submission_posts_columns', 'form_custom_columns', 10);

function form_custom_columns_content($column_name, $post_id)
{

    if ('name_column' == $column_name) {
        $name = get_post_meta($post_id, 'submission_name', true);
        echo $name;
    }
    if ('email_column' == $column_name) {
        $email = get_post_meta($post_id, 'submission_email', true);
        echo $email;
    }


    if ('attachment_column' == $column_name) {
        $upload_dir = wp_upload_dir();
        $attachment = get_post_meta($post_id, 'submission_attachment', true);
        echo '<img style="width:60px;" src="' . $upload_dir['baseurl'] . '/files/' . esc_attr__($attachment) . '"/>';
    }
}

add_action('manage_submission_posts_custom_column', 'form_custom_columns_content', 10, 2);

// make name and email column sortable
function form_column_register_sortable($columns)
{
    $columns['name_column'] = 'name_sub';
    $columns['email_column'] = 'email_sub';
    return $columns;
}

add_filter('manage_edit-submission_sortable_columns', 'form_column_register_sortable');

function form_name_column_orderby($vars)
{
    if (is_admin()) {
        if (isset($vars['orderby']) && 'name_sub' == $vars['orderby']) {
            $vars = array_merge($vars, array(
                'meta_key' => 'name_sub',
                'orderby' => 'meta_value'
            ));
        }
    }
    return $vars;
}

add_filter('request', 'form_name_column_orderby');

function form_email_column_orderby($vars)
{
    if (is_admin()) {
        if (isset($vars['orderby']) && 'email_sub' == $vars['orderby']) {
            $vars = array_merge($vars, array(
                'meta_key' => 'email_sub',
                'orderby' => 'meta_value'
            ));
        }
    }
    return $vars;
}

add_filter('request', 'form_email_column_orderby');