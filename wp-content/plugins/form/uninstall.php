<?php
// exit if uninstall is not called
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$keep = get_option( 'form-setting' );
if ( $keep != 'yes' ) {
	// delete options
	delete_option( 'widget_form-widget');
	delete_option( 'form-setting' );
	delete_option( 'form-setting-2' );
	delete_option( 'form-setting-3' );
	delete_option( 'form-setting-4' );
	delete_option( 'form-setting-5' );
	delete_option( 'form-setting-6' );
	delete_option( 'form-setting-7' );
	delete_option( 'form-setting-8' );
	delete_option( 'form-setting-9' );
	delete_option( 'form-setting-10' );
	delete_option( 'form-setting-15' );
	delete_option( 'form-setting-16' );
	delete_option( 'form-setting-17' );
	delete_option( 'form-setting-18' );
	delete_option( 'form-setting-19' );
	delete_option( 'form-setting-21' );
	delete_option( 'form-setting-22' );
	delete_option( 'form-setting-23' );

	// delete site options in multisite
	delete_site_option( 'widget_form-widget' );
	delete_site_option( 'form-setting' );
	delete_site_option( 'form-setting-2' );
	delete_site_option( 'form-setting-3' );
	delete_site_option( 'form-setting-4' );
	delete_site_option( 'form-setting-5' );
	delete_site_option( 'form-setting-6' );
	delete_site_option( 'form-setting-7' );
	delete_site_option( 'form-setting-8' );
	delete_site_option( 'form-setting-9' );
	delete_site_option( 'form-setting-10' );
	delete_site_option( 'form-setting-11' );
	delete_site_option( 'form-setting-error-required-message-label' );
	delete_site_option( 'form-setting-error-required-email-label' );
	delete_site_option( 'form-setting-error-required-captcha-label' );
	delete_site_option( 'form-setting-15' );
	delete_site_option( 'form-setting-16' );
	delete_site_option( 'form-setting-17' );
	delete_site_option( 'form-setting-18' );
	delete_site_option( 'form-setting-19' );
	delete_site_option( 'form-setting-error-required-subject-label' );
	delete_site_option( 'form-setting-21' );
	delete_site_option( 'form-setting-22' );
	delete_site_option( 'form-setting-23' );

	// set global
	global $wpdb;

	// delete submissions
	$wpdb->query( "DELETE FROM {$wpdb->posts} WHERE post_type = 'submission'" );
}
