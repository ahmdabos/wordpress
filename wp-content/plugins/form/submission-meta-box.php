<?php

namespace metaBox;
class Submission
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

        echo '	<tr>';
        echo '		<th><label for="submission_attachment" class="submission_attachment_label">' . __('Attachment', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '          <input id="submission_attachment" name="submission_attachment" type="text" value="' . esc_attr__($submission_attachment) . '" style="width:400px;" />';
        echo '          <input id="submission_attachment_url" type="button" value="Upload" /><br>';
        echo '          <img id="submission_attachment_img" style="max-width:200px;" src="' . esc_attr__($submission_attachment) . '"/>';
        echo '          <script>
                            jQuery("#submission_attachment_url").click(function () {
                            var send_attachment_bkp = wp.media.editor.send.attachment;
                            wp.media.editor.send.attachment = function (props, attachment) {
                                console.log("attachment"+ JSON.stringify(attachment));
                                jQuery("#submission_attachment_img").attr("src", attachment.url);
                                jQuery("#submission_attachment").val(attachment.url);
                                wp.media.editor.send.attachment = send_attachment_bkp;
                            }
                            wp.media.editor.open();
                            return false;
                        });
                        </script>';
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
        $submission_new_attachment = isset($_POST['submission_attachment']) ? sanitize_text_field($_POST['submission_attachment']) : '';


        // Update the meta field in the database.
        update_post_meta($post_id, 'submission_name', $submission_new_name);
        update_post_meta($post_id, 'submission_email', $submission_new_email);
        update_post_meta($post_id, 'submission_attachment', $submission_new_attachment);

    }
}

new Submission;