<?php
/**
 * Load assets
 *
 * @author      Your Name or Your Company
 * @category    Admin
 * @package     PName/Admin
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once PNameSingleton()->plugin_path() . '/includes/class-pname-assets.php';

/**
 * PName_Admin_Assets Class.
 */
class PName_Admin_Assets extends PName_Assets {

	/**
	 * Hook in methods.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'admin_print_scripts', array( $this, 'localize_printed_scripts' ), 5 );
		add_action( 'admin_print_footer_scripts', array( $this, 'localize_printed_scripts' ), 5 );
	}

	/**
	 * Get styles for the frontend.
	 * @access private
	 * @return array
	 */
	public function get_styles() {
		return apply_filters(
			'plugin_name_enqueue_admin_styles',
			array(
				'plugin-name-admin' => array(
					'src' => $this->localize_asset( 'css/admin/plugin-name-admin.css' ),
				),
			)
		);
	}

	/**
	 * Get styles for the frontend.
	 * @access private
	 * @return array
	 */
	public function get_scripts() {
		return apply_filters(
			'plugin_name_enqueue_admin_scripts',
			array(
				'plugin-name-admin' => array(
					'src'  => $this->localize_asset( 'js/admin/plugin-name-admin.js' ),
					'data' => array(
						'ajax_url' => PNameSingleton()->ajax_url(),
					),
				),
			)
		);
	}

}

return new PName_Admin_Assets();
