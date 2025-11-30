# Clears Transient Cache Plugin

A reliable WordPress plugin that clears transient cache strictly via WP-CLI and logs the execution details into a custom database table.

## Features

- **Strict WP-CLI Execution**: The cleaning functionality is designed to be run via the command line for reliability and automation.
- **Comprehensive Cleaning**: Removes both standard transients (`_transient_`) and site transients (`_site_transient_`) directly from the database.
- **Object Cache Flushing**: Automatically flushes the object cache (`wp_cache_flush`) after clearing database entries to ensure memory freshness.
- **Audit Logging**: Records every execution in a custom database table (`wp_transient_cleaner_logs`), tracking the command status, message, and timestamp.

## Installation

1. Clone or download this repository into your `wp-content/plugins/` directory.
   ```bash
   cd wp-content/plugins/
   git clone https://github.com/Alex-Berezov/clears-transient-cache-plugin.git
   ```
2. Activate the plugin via the WordPress Dashboard or WP-CLI:
   ```bash
   wp plugin activate clears-transient-cache-plugin
   ```
   _Upon activation, the plugin will automatically create the necessary database table for logging._

## Usage

To clear the transient cache, run the following WP-CLI command:

```bash
wp transient-cleaner clear
```

### Output Example

```bash
$ wp transient-cleaner clear
Starting transient cache cleanup...
Success: Successfully cleared 42 transient entries.
```

## Database Logging

The plugin creates a table named `wp_transient_cleaner_logs` (prefix may vary). You can inspect the logs to verify when the cache was cleared and the result of the operation.

## Uninstallation

When you uninstall the plugin via the WordPress Admin dashboard, it will automatically:

- Drop the custom log table.
- Remove plugin-specific options.

## Requirements

- WordPress
- WP-CLI
