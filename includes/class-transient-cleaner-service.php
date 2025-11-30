<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Transient_Cleaner_Service {

	/**
	 * Clears all transients from the database.
	 *
	 * @return int|false Number of rows affected or false on error.
	 */
	public function clean_transients() {
		global $wpdb;

		// Delete all transients and their timeouts from the options table.
		// Note: We use specific LIKE patterns to match both the transient data and the timeout.
		// '_transient_%' matches '_transient_foo' and '_transient_timeout_foo'.
		$sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '\_transient\_%' OR option_name LIKE '\_site\_transient\_%'";
		
		$result = $wpdb->query( $sql );

		// Clear object cache to ensure memory is fresh.
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}

		return $result;
	}

	/**
	 * Logs the execution of the command.
	 *
	 * @param string $command The command name.
	 * @param string $status  The status (success/error).
	 * @param string $message The message to log.
	 */
	public function log_action( $command, $status, $message ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'transient_cleaner_logs';

		$wpdb->insert(
			$table_name,
			array(
				'command'    => $command,
				'status'     => $status,
				'message'    => $message,
				'created_at' => current_time( 'mysql' ),
			),
			array(
				'%s',
				'%s',
				'%s',
				'%s',
			)
		);
	}
}
