<?php
// Register Custom Post Type
function car_post_type()
{

    $labels = array(
        'name' => _x('Cars', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Car', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Car', 'text_domain'),
        'name_admin_bar' => __('Car', 'text_domain'),
        'parent_item_colon' => __('Parent Car:', 'text_domain'),
        'all_items' => __('All Cars', 'text_domain'),
        'add_new_item' => __('Add New Car', 'text_domain'),
        'add_new' => __('Add New', 'text_domain'),
        'new_item' => __('New Car', 'text_domain'),
        'edit_item' => __('Edit Car', 'text_domain'),
        'update_item' => __('Update Car', 'text_domain'),
        'view_item' => __('View Car', 'text_domain'),
        'search_items' => __('Search Car', 'text_domain'),
        'not_found' => __('Not found', 'text_domain'),
        'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
        'items_list' => __('Items list', 'text_domain'),
        'items_list_navigation' => __('Items list navigation', 'text_domain'),
        'filter_items_list' => __('Filter items list', 'text_domain'),
    );
    $args = array(
        'label' => __('Car', 'text_domain'),
        'description' => __('Car post type.', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail',),
        'taxonomies' => array('model', 'transmission', 'doors', 'color'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-dashboard',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'show_in_rest' => true,
    );
    register_post_type('car', $args);

}
add_action('init', 'car_post_type', 0);