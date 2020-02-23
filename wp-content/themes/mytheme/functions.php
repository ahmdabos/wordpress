<?php
if (!function_exists('mytheme_setup')) :
    function mytheme_setup()
    {
        load_theme_textdomain('mytheme', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'mytheme'),
        ));
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
    }
endif;
add_action('after_setup_theme', 'mytheme_setup');
function mytheme_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar 1', 'mytheme'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'mytheme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

}

add_action('widgets_init', 'mytheme_widgets_init');

function mytheme_scripts()
{
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
    wp_enqueue_style('owl-carousel-css', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), time(), 'all');
    wp_enqueue_script('mytheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), time(), true);
    wp_enqueue_script('mytheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), time(), true);
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    wp_enqueue_script("jquery");
    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-2.2.4.min.js', array(''), time(), true);
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.js', array('jquery'), time(), true);
    wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), time(), true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), time(), true);

}


add_action('wp_enqueue_scripts', 'mytheme_scripts');


add_image_size('blog-thumbnail', 400, 300, false);

function custom_excerpt_more()
{
    return sprintf(' <a href="%1$s" class="read-more" >%2$s</a>', get_permalink(get_the_ID()), __('...Continue', 'textdomain'));
}

add_filter('excerpt_more', 'custom_excerpt_more');

function custom_excerpt_lengh()
{
    return 50;
}

add_filter('excerpt_length', 'custom_excerpt_lengh');


add_filter('use_block_editor_for_post', '__return_false', 10);

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/custom-post-type.php';
require get_template_directory() . '/inc/custom-taxonomy.php';
require get_template_directory() . '/inc/custom-metabox.php';

