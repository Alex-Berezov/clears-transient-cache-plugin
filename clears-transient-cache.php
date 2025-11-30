<?php
/**
 * Plugin Name: Clears Transient Cache Plugin
 * Description: Clears transient cache via WP-CLI and logs the action to a custom table.
 * Version: 1.0.0
 * Author: Alex Berezov
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Transient_Cleaner_Plugin {

	const TABLE_NAME = 'transient_cleaner_logs';
	const DB_VERSION = '1.0.0';

	public function __construct() {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-transient-cleaner-command.php';
			WP_CLI::add_command( 'transient-cleaner', 'Transient_Cleaner_Command' );
		}
	}

	public static function activate() {
		global $wpdb;

		$table_name = $wpdb->prefix . self::TABLE_NAME;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			command varchar(50) NOT NULL,
			status varchar(20) NOT NULL,
			message text NOT NULL,
			created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'transient_cleaner_db_version', self::DB_VERSION );
	}
}

new Transient_Cleaner_Plugin();

register_activation_hook( __FILE__, array( 'Transient_Cleaner_Plugin', 'activate' ) );
