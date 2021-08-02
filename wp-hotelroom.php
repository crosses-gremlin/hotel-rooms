<?php
/**
 * Hotel room
 *
 * Plugin Name: Hotel rooms
 * Plugin URI:
 * Description: Show blocks with hotel rooms information
 * Version:     1.0.0
 * Author:      Evgen
 * Author URI:
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: hotel-rooms
 * Domain Path: /languages
 * Requires at least: 5.5
 * Requires PHP: 7.0
 *
 * @package package
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HR_NAME', 'Hotel rooms' );
define( 'HR_PATH', plugin_dir_path( __FILE__ ) );
define( 'HR_URL', plugin_dir_url( __FILE__ ) );
define( 'HR_PLUGIN_SLUG', 'hotel-rooms' );
define( 'HR_VERSION', '1.0.0' );

/**
 * Description
 */
function activate_hotel_rooms() {
	require_once HR_PATH . 'includes/class-hotel-rooms-activator.php';
	Hotel_Rooms_Activator::activate();
}

/**
 * Description
 */
function deactivate_hotel_rooms() {
	require_once HR_PATH . 'includes/class-hotel-rooms-deactivator.php';
	Hotel_Rooms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hotel_rooms' );
register_deactivation_hook( __FILE__, 'deactivate_hotel_rooms' );

require HR_PATH . 'includes/class-hotel-rooms.php';

/**
 * Description
 */
function execute_hr_plugin() {

	$plugin = new Hotel_Rooms();
	$plugin->run();

}

execute_hr_plugin();
