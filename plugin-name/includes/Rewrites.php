<?php
/**
 * Handle rewrite rules flushing.
 */

namespace Plugin_Name;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rewrites class
 */
final class Rewrites {

	/**
	 * Hook into install/uninstall actions to flag a flush.
	 *
	 * @return void
	 */
	public static function bootstrap_hooks() {
		add_action( 'plugin_name_installed', array( self::class, 'flush_rewrites' ) );
		add_action( 'plugin_name_uninstalled', array( self::class, 'do_flush_rewrites' ) );
	}


	/**
	 * Hook into init to maybe flush rewrites.
	 *
	 * @return void
	 */
	public static function hooks() {
		add_action( 'init', array( self::class, 'maybe_flush_rewrites' ), \PHP_INT_MAX );
	}


	/**
	 * Flag that rewrites need to be flushed on next init.
	 *
	 * @return void
	 */
	public static function flush_rewrites() {
		\update_option( 'pname_flush_rewrites', 1, true );
	}


	/**
	 * Flush rewrites if flagged, skip if option doesn't exist yet.
	 *
	 * @return void
	 */
	public static function maybe_flush_rewrites() {
		if ( 2 === \get_option( 'pname_flush_rewrites', 2 ) ) {
			\update_option( 'pname_flush_rewrites', 0, true ); // set this, so that it's autoloaded next time
			return;
		}

		if ( ! (int) \get_option( 'pname_flush_rewrites', 0 ) ) {
			return;
		}

		self::do_flush_rewrites();
	}


	/**
	 * Perform the actual rewrite flush.
	 *
	 * @return void
	 */
	public static function do_flush_rewrites() {
		\update_option( 'pname_flush_rewrites', 0, true );
		\flush_rewrite_rules();
	}
}
