<?php
/**
 * Utility methods.
 */

namespace Plugin_Name;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Utils class
 */
final class Utils {

	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	public static function is_request( $type ) {

		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return wp_doing_ajax();
			case 'cron':
				return wp_doing_cron();
			case 'frontend':
				return ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron();
			default:
				return false;
		}
	}


	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', PLUGIN_FILE ) );
	}


	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public static function plugin_path() {
		return untrailingslashit( plugin_dir_path( PLUGIN_FILE ) );
	}


	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public static function template_path() {
		// Allow 3rd party plugin filter template path from their plugin.
		return apply_filters( 'plugin_name_template_path', 'plugin-name/' );
	}


	/**
	 * Get Ajax URL.
	 *
	 * @return string
	 */
	public static function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}
}
