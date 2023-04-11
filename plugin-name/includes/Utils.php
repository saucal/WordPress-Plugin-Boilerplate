<?php
/**
 * Utility methods
 *
 * @class       Utils
 * @version     1.0.0
 * @package     Plugin_Name/Classes/
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
	 * @return bool
	 */
	public static function is_request( $type ) {

		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' ) && DOING_AJAX;
			case 'cron':
				return defined( 'DOING_CRON' ) && DOING_CRON;
			case 'frontend':
				return ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) && ( ! defined( 'DOING_CRON' ) || ! DOING_CRON ) && ! self::is_rest_api_request();
				return ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) && ( ! defined( 'DOING_CRON' ) || ! DOING_CRON );
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
		/**
		 * Allow 3rd party plugin filter template path from their plugin.
		 *
		 * @since 1.0.0
		 */
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

	/**
	 * Determines if incoming request is towards the REST API.
	 *
	 * @return boolean
	 */
	protected static function is_rest_api_request() {
		if ( function_exists( 'WC' ) && method_exists( WC(), 'is_rest_api_request' ) ) {
			return WC()->is_rest_api_request();
		}

		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return false;
		}

		$rest_prefix         = trailingslashit( rest_get_url_prefix() );
		$is_rest_api_request = ( false !== strpos( $_SERVER['REQUEST_URI'], $rest_prefix ) ); // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		/**
		 * Whether this is a REST API request.
		 *
		 * @since 3.6.0
		 */
		return apply_filters( 'woocommerce_is_rest_api_request', $is_rest_api_request );
	}
}
