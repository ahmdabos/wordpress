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
	delete_option( 'form-setting-5' );
	delete_option( 'form-setting-6' );
    delete_option( 'form-setting-7' );
	delete_option( 'form-setting-10' );
	delete_option( 'form-setting-15' );
	delete_option( 'form-setting-16' );
	delete_option( 'form-setting-17' );
	delete_option( 'form-setting-22' );

	// set global
	global $wpdb;

	// delete submissions
	$wpdb->query( "DELETE FROM {$wpdb->posts} WHERE post_type = 'submission'" );
}
