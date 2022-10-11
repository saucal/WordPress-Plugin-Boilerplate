<?php
/**
 * Handle front hooks.
 *
 * @class       Front
 * @version     1.0.0
 * @package     Plugin_Name/Classes/
 */

namespace Plugin_Name\Front;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front main class
 */
final class Main {

	/**
	 * Initialize hooks
	 *
	 * @return void
	 */
	public static function hooks() {
		Assets::hooks();
	}
}
