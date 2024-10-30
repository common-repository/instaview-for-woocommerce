<?php
namespace InstaView\Core;

/**
 * Text domain for translation.
 *
 * @since      1.0.0
 *
 * @package    InstaView
 * @subpackage InstaView\Core
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class InstaView_i18n {


	/**
	 * Text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function instaview_load_plugin_textdomain() {

		instaview_load_plugin_textdomain(
			'instaview', false, INSTAVIEW_PLUGIN_DIR . '/languages/'
		);

	}

}
