<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_CLI_Command' ) ) {
	return;
}

/**
 * Commands to clear transient cache.
 */
class Transient_Cleaner_Command extends WP_CLI_Command {

	/**
	 * Clears all transient cache.
	 *
	 * ## EXAMPLES
	 *
	 *     wp transient-cleaner clear
	 *
	 * @when after_wp_load
	 */
	public function clear( $args, $assoc_args ) {
		WP_CLI::log( 'Starting transient cache cleanup...' );

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-transient-cleaner-service.php';
		$service = new Transient_Cleaner_Service();

		try {
			$count = $service->clean_transients();
			
			if ( false === $count ) {
				throw new Exception( 'Database error occurred while clearing transients.' );
			}

			$message = sprintf( 'Successfully cleared %d transient entries.', $count );
			$service->log_action( 'wp transient-cleaner clear', 'success', $message );
			WP_CLI::success( $message );

		} catch ( Exception $e ) {
			$error_message = $e->getMessage();
			$service->log_action( 'wp transient-cleaner clear', 'error', $error_message );
			WP_CLI::error( $error_message );
		}
	}
}
