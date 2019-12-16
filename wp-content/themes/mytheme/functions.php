<?php

if (!function_exists('mytheme_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function mytheme_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on mytheme, use a find and replace
         * to change 'mytheme' to the name of your theme in all the template files.
         */
        load_theme_textdomain('mytheme', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'mytheme'),
        ));
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('mytheme_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }
endif;
add_action('after_setup_theme', 'mytheme_setup');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
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


/**
 * Enqueue scripts and styles.
 */
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


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * add image size
 */
add_image_size('blog-thumbnail', 400, 300, false);


/**
 * Custom excerpt link
 */
function custom_excerpt_more()
{
    return sprintf(' <a href="%1$s" class="read-more" >%2$s</a>', get_permalink(get_the_ID()), __('...Continue', 'textdomain'));
}

add_filter('excerpt_more', 'custom_excerpt_more');


/**
 * Custom excerpt length
 */
function custom_excerpt_lengh()
{
    return 50;
}

add_filter('excerpt_length', 'custom_excerpt_lengh');


/**
 * Custom post type
 */
require get_template_directory() . '/inc/custom-post-type.php';


/**
 * Custom Taxonomy
 */
require get_template_directory() . '/inc/custom-taxonomy.php';


/**
 * Custom Metabox
 */
require get_template_directory() . '/inc/custom-metabox.php';
