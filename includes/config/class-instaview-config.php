<?php
namespace InstaView\Config;

/**
 * Define the config const
 *
 * @since      1.0.0
 *
 * @package    InstaView
 * @subpackage InstaView\Helper
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class InstaView_Config {

	const PLUGIN_NAME = "InstaView";
	const PLUGIN_VERSION = "1.0";
	const WC_MIN_PLUGIN_VERSION = "1.0";
	const WC_TAB_NAME = "test";
}
