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

    wp_enqueue_script('mytheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('mytheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
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


// Shortcode: [filter_search]
function filter_search_shortcode()
{
    wp_enqueue_script('filter_search', get_stylesheet_directory_uri() . '/script.js', array(), '1.0', true);
    wp_localize_script('filter_search', 'ajax_url', admin_url('admin-ajax.php'));
    ob_start(); ?>
    <div id="filter-search">
        <form action="" method="get">
            <input type="text" name="search" id="search" value="" placeholder="Search Here..">
            <div class="column-wrap">
                <div class="column">
                    <label for="year">Year</label>
                    <select name="year" id="year">
                        <option value="">All</option>
                        <option value="2019">2019</option>
                        <option value="2018">2018</option>
                        <option value="2017">2017</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                    </select>
                </div>
                <div class="column">
                    <label for="month">month</label>
                    <select name="month" id="month">
                        <option value="">All</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>

                    </select>
                </div>
            </div>
            <input type="submit" id="submit" name="submit" value="Search">
        </form>
        <div id="fitler_search_results"></div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('filter_search', 'filter_search_shortcode');


// Ajax Callback
function filter_search_callback()
{
    header("Content-Type: application/json");
    $meta_query = array('relation' => 'AND');
    $date_query = array('relation' => 'AND');
    if (isset($_GET['year'])) {
        $year = sanitize_text_field($_GET['year']);
        $date_query[] = array(
            'year' => $year,
        );
    }
    if (isset($_GET['month'])) {
        $month = sanitize_text_field($_GET['month']);
        $date_query[] = array(
            'month' => $month,
        );
    }
    $tax_query = array();
    if (isset($_GET['genre'])) {
        $genre = sanitize_text_field($_GET['genre']);
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $genre
        );
    }
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_query' => $meta_query,
        'tax_query' => $tax_query,
        'date_query' => $date_query,
    );
    if (isset($_GET['search'])) {
        $search = sanitize_text_field($_GET['search']);
        $search_query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'meta_query' => $meta_query,
            'tax_query' => $tax_query,
            'date_query' => $date_query,
            's' => $search
        ));
    } else {
        $search_query = new WP_Query($args);
    }
    if ($search_query->have_posts()) {
        $result = array();
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $result[] = array(
                "id" => get_the_ID(),
                "title" => get_the_title(),
                "content" => get_the_content(),
                "permalink" => get_permalink(),
                "thumbnail" => get_the_post_thumbnail('blog-thumbnail'),
                "date" => get_the_date(),
                "author" => get_the_author(),
                "category" => strip_tags(get_the_category_list(", ")),
                "excerpt" => get_the_excerpt()
            );
        }
        wp_reset_query();

        echo json_encode($result);

    } else {
        // no posts found
    }
    wp_die();
}

add_action('wp_ajax_filter_search', 'filter_search_callback');
add_action('wp_ajax_nopriv_filter_search', 'filter_search_callback');