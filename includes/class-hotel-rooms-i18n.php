<?php
/**
 * Description document
 *
 * @file
 * @package package
 */

/**
 * Class Hotel_Rooms_i18n
 */
class Hotel_Rooms_i18n {
	/**
	 * Description
	 *
	 * @param string $plugin_name description.
	 */
	public function load_plugin_textdomain( $plugin_name ) {

		load_plugin_textdomain(
			HR_PLUGIN_SLUG,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
