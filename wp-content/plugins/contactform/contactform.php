<?php
/*
 * Plugin Name: Contact Form
 * Description:contact form. Add shortcode [contact] on a page or use the widget to display your form.
 * Version: 1.0.0
 * Author: Fi
 * Author URI: https://fi.ae
 * Text Domain: contact-form
 * Domain Path: /translation
 */

// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// load plugin text domain
function contactform_init() {
	load_plugin_textdomain( 'contact-form', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'contactform_init');

// enqueue plugin scripts
function contactform_scripts() {
	wp_enqueue_style('contactform_style', plugins_url('/css/contactform-style.min.css',__FILE__));
}
add_action('wp_enqueue_scripts', 'contactform_scripts');

// the sidebar widget
function register_contactform_widget() {
	register_widget( 'contactform_widget' );
}
add_action( 'widgets_init', 'register_contactform_widget' );

// form submissions
$list_submissions_setting = get_option('contactform-setting-2');
if ($list_submissions_setting == "yes") {
	// create submission post type
	function contactform_custom_postype() {
		$contactform_args = array(
			'labels' => array('name' => esc_attr__( 'Submissions', 'contact-form' )),
			'menu_icon' => 'dashicons-email',
			'public' => false,
			'can_export' => true,
			'show_in_nav_menus' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'capability_type' => 'post',
			'capabilities' => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap' => true,
 			'supports' => array( 'title', 'editor' )
		);
		register_post_type( 'submission', $contactform_args );
	}
	add_action( 'init', 'contactform_custom_postype' );

	// dashboard submission columns
	function contactform_custom_columns( $columns ) {
		$columns['name_column'] = esc_attr__( 'Name', 'contact-form' );
		$columns['email_column'] = esc_attr__( 'Email', 'contact-form' );
		$custom_order = array('cb', 'title', 'name_column', 'email_column', 'date');
		foreach ($custom_order as $colname) {
			$new[$colname] = $columns[$colname];
		}
		return $new;
	}
	add_filter( 'manage_submission_posts_columns', 'contactform_custom_columns', 10 );

	function contactform_custom_columns_content( $column_name, $post_id ) {
		if ( 'name_column' == $column_name ) {
			$name = get_post_meta( $post_id, 'name_sub', true );
			echo $name;
		}
		if ( 'email_column' == $column_name ) {
			$email = get_post_meta( $post_id, 'email_sub', true );
			echo $email;
		}
	}
	add_action( 'manage_submission_posts_custom_column', 'contactform_custom_columns_content', 10, 2 );

	// make name and email column sortable
	function contactform_column_register_sortable( $columns ) {
		$columns['name_column'] = 'name_sub';
		$columns['email_column'] = 'email_sub';
		return $columns;
	}
	add_filter( 'manage_edit-submission_sortable_columns', 'contactform_column_register_sortable' );

	function contactform_name_column_orderby( $vars ) {
		if(is_admin()) {
			if ( isset( $vars['orderby'] ) && 'name_sub' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'name_sub',
					'orderby' => 'meta_value'
				) );
			}
		}
		return $vars;
	}
	add_filter( 'request', 'contactform_name_column_orderby' );

	function contactform_email_column_orderby( $vars ) {
		if(is_admin()) {
			if ( isset( $vars['orderby'] ) && 'email_sub' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'email_sub',
					'orderby' => 'meta_value'
				) );
			}
		}
		return $vars;
	}
	add_filter( 'request', 'contactform_email_column_orderby' );
}

// add settings link
function contactform_action_links ( $links ) {
	$settingslink = array( '<a href="'. admin_url( 'options-general.php?page=contactform' ) .'">'. esc_attr__('Settings', 'contact-form') .'</a>' );
	return array_merge( $links, $settingslink );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'contactform_action_links' );

// get ip of user
function contactform_get_the_ip() {
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	} elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	} else {
		return $_SERVER["REMOTE_ADDR"];
	}
}

// create from email header
function contactform_from_header() {
	if ( !isset( $from_email ) ) {
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		return 'wordpress@' . $sitename;
	}
}

// create random number for page captcha
function contactform_random_number() {
	$page_number = mt_rand(100, 999);
	return $page_number;
}

// create random number for widget captcha
function contactform_widget_random_number() {
	$widget_number = mt_rand(100, 999);
	return $widget_number;
}

// redirect if sending succeeded
function contactform_redirect_success() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&contactformsp=success";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?contactformsp=success";
		} else {
			$url_with_param = $current_url."/?contactformsp=success";
		}
	}
	echo '<script type="text/javascript">';
	echo 'window.location="'.$url_with_param.'"';
	echo '</script>';
}

function contactform_widget_redirect_success() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&contactformsw=success";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?contactformsw=success";
		} else {
			$url_with_param = $current_url."/?contactformsw=success";
		}
	}
	echo '<script type="text/javascript">';
	echo 'window.location="'.$url_with_param.'"';
	echo '</script>';
}

// redirect if sending failed
function contactform_redirect_error() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&contactformsp=fail";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?contactformsp=fail";
		} else {
			$url_with_param = $current_url."/?contactformsp=fail";
		}
	}
	echo '<script type="text/javascript">';
	echo 'window.location="'.$url_with_param.'"';
	echo '</script>';
}

function contactform_widget_redirect_error() {
	$current_url = $_SERVER['REQUEST_URI'];
	if (strpos($current_url, '?') == true) {
		$url_with_param = $current_url."&contactformsw=fail";
	} else {
		if (substr($current_url, -1) == '/') {
			$url_with_param = $current_url."?contactformsw=fail";
		} else {
			$url_with_param = $current_url."/?contactformsw=fail";
		}
	}
	echo '<script type="text/javascript">';
	echo 'window.location="'.$url_with_param.'"';
	echo '</script>';
}

// form anchor
function contactform_anchor_footer() {
	$anchor_setting = get_option('contactform-setting-21');
	if ($anchor_setting == "yes") {
		echo '<script type="text/javascript">';
		echo 'if(document.getElementById("contactform-anchor")) {';
		echo 'document.getElementById("contactform-anchor").scrollIntoView({behavior:"smooth", block:"center"});';
		echo '}';
		echo '</script>';
	}
}
add_action('wp_footer', 'contactform_anchor_footer');

// include files
include 'contactform-page-shortcode.php';
include 'contactform-widget-shortcode.php';
include 'contactform-widget.php';
include 'contactform-options.php';
