<?php
/**
 * Handle plugin's install actions.
 *
 * @class       Install
 * @version     1.0.0
 * @package     Plugin_Name/Classes/
 */

namespace Plugin_Name;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install class
 */
final class Install {

	/**
	 * Install action.
	 */
	public static function install( $sitewide = false ) {

		// Perform install actions here.

		// Trigger action.
		do_action( 'plugin_name_installed', $sitewide );
	}
}
