<?php
/**
 * Register frontend assets.
 */

namespace Plugin_Name\Front;

use Plugin_Name\Assets as AssetsMain;
use Plugin_Name\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Frontend assets class
 */
final class Assets {

	/**
	 * Hook in methods.
	 */
	public static function hooks() {
		add_filter( 'plugin_name_enqueue_styles', array( self::class, 'add_styles' ), 9 );
		add_filter( 'plugin_name_enqueue_scripts', array( self::class, 'add_scripts' ), 9 );
		add_action( 'wp_enqueue_scripts', array( AssetsMain::class, 'load_scripts' ) );
		add_action( 'wp_print_scripts', array( AssetsMain::class, 'localize_printed_scripts' ), 5 );
		add_action( 'wp_print_footer_scripts', array( AssetsMain::class, 'localize_printed_scripts' ), 5 );
	}


	/**
	 * Add styles for the frontend.
	 *
	 * @param array $styles Frontend styles.
	 *
	 * @return array<string,array>
	 */
	public static function add_styles( $styles ) {

		$styles['plugin-name-general'] = array(
			'src' => AssetsMain::localize_asset( 'css/frontend/plugin-name.css' ),
		);

		return $styles;
	}


	/**
	 * Add scripts for the frontend.
	 *
	 * @param  array $scripts Frontend scripts.
	 *
	 * @return array<string,array>
	 */
	public static function add_scripts( $scripts ) {

		$scripts['plugin-name-general'] = array(
			'src'  => AssetsMain::localize_asset( 'js/frontend/plugin-name.js' ),
			'data' => array(
				'ajax_url' => Utils::ajax_url(),
			),
		);

		return $scripts;
	}
}
