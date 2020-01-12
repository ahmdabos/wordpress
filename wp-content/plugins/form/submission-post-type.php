<?php

namespace PostType;
class Submission
{
    private $type = 'submission';
    private $slug = 'submissions';
    private $name = 'Submissions';
    private $singular_name = 'Submission';

    public function __construct()
    {
        // Register the post type
        add_action('init', array($this, 'register'));
        // Admin set post columns
        add_filter('manage_edit-' . $this->type . '_columns', array($this, 'set_columns'), 10, 1);
        // Admin edit post columns
        add_action('manage_' . $this->type . '_posts_custom_column', array($this, 'edit_columns'), 10, 2);
        // Admin sortable post columns
        add_filter('manage_edit-' . $this->type . '_sortable_columns', array($this, 'sortable_columns'), 10, 2);
        // Admin orderby post columns
        add_filter('request', array($this, 'orderby_columns'), 10, 2);

    }

    /**
     * Register post type
     */

    public function register()
    {
        $labels = array(
            'name' => $this->name,
            'singular_name' => $this->singular_name,
            'add_new' => 'Add New',
            'add_new_item' => 'Add New ' . $this->singular_name,
            'edit_item' => 'Edit ' . $this->singular_name,
            'new_item' => 'New ' . $this->singular_name,
            'all_items' => 'All ' . $this->name,
            'view_item' => 'View ' . $this->name,
            'search_items' => 'Search ' . $this->name,
            'not_found' => 'No ' . strtolower($this->name) . ' found',
            'not_found_in_trash' => 'No ' . strtolower($this->name) . ' found in Trash',
            'parent_item_colon' => '',
            'menu_name' => $this->name
        );

        $args = array(
            'labels' => $labels,
            'supports' => array('title', 'editor'),
            'taxonomies' => array(''),
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-dashboard',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability_type' => 'post',
            'show_in_rest' => false,
        );

        register_post_type($this->type, $args);
    }

    /**
     * @param $columns
     * @return mixed
     *
     * Choose the columns you want in
     * the admin table for this post
     */
    public function set_columns($columns)
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

    /**
     * @param $column
     * @param $post_id
     *
     * Edit the contents of each column in
     * the admin table for this post
     */
    public function edit_columns($column, $post_id)
    {
        if ('name_column' == $column) {
            $name = get_post_meta($post_id, 'submission_name', true);
            echo $name;
        }
        if ('email_column' == $column) {
            $email = get_post_meta($post_id, 'submission_email', true);
            echo $email;
        }


        if ('attachment_column' == $column) {
            $attachment = get_post_meta($post_id, 'submission_attachment', true);
            echo '<img style="width:60px;" src="' . esc_attr__($attachment) . '"/>';
        }
    }

    /**
     * @param $columns
     * @return mixed
     * make column sortable
     */
    public function sortable_columns($columns)
    {
        $columns['name_column'] = 'name_sub';
        $columns['email_column'] = 'email_sub';
        return $columns;
    }

    /**
     * @param $vars
     * @return mixed
     * orderby columns
     */
    public function orderby_columns($vars)
    {
        if (is_admin()) {
            if (isset($vars['orderby']) && 'name_sub' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'name_sub',
                    'orderby' => 'meta_value'
                ));
            }
            if (isset($vars['orderby']) && 'email_sub' == $vars['orderby']) {
                $vars = array_merge($vars, array(
                    'meta_key' => 'email_sub',
                    'orderby' => 'meta_value'
                ));
            }
        }
        return $vars;
    }
}

new Submission();


