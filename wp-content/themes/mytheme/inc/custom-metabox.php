<?php

class Car_Info_Meta_Box
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
            'car_info',
            __('Car Info', 'text_domain'),
            array($this, 'render_metabox'),
            'car',
            'advanced',
            'default'
        );

    }

    public function render_metabox($post)
    {

        // Add nonce for security and authentication.
        wp_nonce_field('car_nonce_action', 'car_nonce');

        // Retrieve an existing value from the database.
        $car_year = get_post_meta($post->ID, 'car_year', true);
        $car_sunroof = get_post_meta($post->ID, 'car_sunroof', true);
        $car_price = get_post_meta($post->ID, 'car_price', true);
        $car_currency = get_post_meta($post->ID, 'car_currency', true);
        $car_intro = get_post_meta($post->ID, 'car_intro', true);
        // Set default values.
        if (empty($car_year)) $car_year = '';
        if (empty($car_sunroof)) $car_sunroof = '';
        if (empty($car_price)) $car_price = '';
        if (empty($car_currency)) $car_currency = '';
        if (empty($car_intro)) $car_intro = '';
        // Form fields.
        echo '<table class="form-table">';

        echo '	<tr>';
        echo '		<th><label for="car_year" class="car_year_label">' . __('Year', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '			<input type="text" id="car_year" name="car_year" class="car_year_field" placeholder="' . esc_attr__('', 'text_domain') . '" value="' . esc_attr__($car_year) . '">';
        echo '		</td>';
        echo '	</tr>';


        echo '	<tr>';
        echo '		<th><label for="car_sunroof" class="car_sunroof_label">' . __('Sunroof', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '			<input type="checkbox" id="car_sunroof" name="car_sunroof" class="car_sunroof_field" value="' . $car_sunroof . '" ' . checked($car_sunroof, 'checked', false) . '> ' . __('', 'text_domain');
        echo '			<span class="description">' . __('Car has sunroof.', 'text_domain') . '</span>';
        echo '		</td>';
        echo '	</tr>';

        echo '	<tr>';
        echo '		<th><label for="car_price" class="car_price_label">' . __('Price', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '			<input type="number" id="car_price" name="car_price" class="car_price_field" placeholder="' . esc_attr__('', 'text_domain') . '" value="' . esc_attr__($car_price) . '">';
        echo '			<p class="description">' . __('Price', 'text_domain') . '</p>';
        echo '		</td>';
        echo '	</tr>';

        echo '	<tr>';
        echo '		<th><label for="car_currency" class="car_currency_label">' . __('Currency', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '			<select id="car_currency" name="car_currency" class="car_currency_field">';
        echo '			<option value="car_USD" ' . selected($car_currency, 'car_USD', false) . '> ' . __('USD', 'text_domain');
        echo '			<option value="car_EUR" ' . selected($car_currency, 'car_EUR', false) . '> ' . __('Euro', 'text_domain');
        echo '			<option value="car_GBP" ' . selected($car_currency, 'car_GBP', false) . '> ' . __('GB Pound', 'text_domain');
        echo '			<option value="car_JPY" ' . selected($car_currency, 'car_JPY', false) . '> ' . __('Japanese Yen', 'text_domain');
        echo '			<option value="car_CNY" ' . selected($car_currency, 'car_CNY', false) . '> ' . __('Chinese Yuan', 'text_domain');
        echo '			</select>';
        echo '		</td>';
        echo '	</tr>';

        echo '	<tr>';
        echo '		<th><label for="car_intro" class="car_intro_label">' . __('Intro', 'text_domain') . '</label></th>';
        echo '		<td>';
        echo '			<textarea id="car_intro" name="car_intro" class="car_intro_field" >' . esc_attr__($car_intro) . '</textarea>';
        echo '			<p class="description">' . __('Intro', 'text_domain') . '</p>';
        echo '		</td>';
        echo '	</tr>';



        echo '</table>';


    }

    public function save_metabox($post_id, $post)
    {

        // Add nonce for security and authentication.
        $nonce_name = $_POST['car_nonce'];
        $nonce_action = 'car_nonce_action';

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
        $car_new_year = isset($_POST['car_year']) ? sanitize_text_field($_POST['car_year']) : '';
        $car_new_sunroof = isset($_POST['car_sunroof']) ? 'checked' : '';
        $car_new_price = isset($_POST['car_price']) ? sanitize_text_field($_POST['car_price']) : '';
        $car_new_currency = isset($_POST['car_currency']) ? $_POST['car_currency'] : '';
        $car_new_intro = isset($_POST['car_intro']) ? $_POST['car_intro'] : '';

        // Update the meta field in the database.
        update_post_meta($post_id, 'car_year', $car_new_year);
        update_post_meta($post_id, 'car_sunroof', $car_new_sunroof);
        update_post_meta($post_id, 'car_price', $car_new_price);
        update_post_meta($post_id, 'car_currency', $car_new_currency);
        update_post_meta($post_id, 'car_intro', $car_new_intro);
    }

}

new Car_Info_Meta_Box;


