<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;
$table_name = $wpdb->prefix . 'transient_cleaner_logs';
$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
delete_option( 'transient_cleaner_db_version' );
