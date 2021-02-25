<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://dotburo.org
 * @since             1.0.0
 * @package           Swi_Petition
 *
 * @wordpress-plugin
 * Plugin Name:       Petition!
 * Plugin URI:        https://github.com/dotburo/wp-plugin-petititon
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            dotburo
 * Author URI:        https://dotburo.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       swi-petition
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

use Dotburo\SwiHookLoader;
use Dotburo\SwiPetition;

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-swi-petition-activator.php
 */
function activate_swi_petition() {
	///require_once plugin_dir_path( __FILE__ ) . 'includes/class-swi-petition-activator.php';
	//Swi_Petition_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-swi-petition-deactivator.php
 */
function deactivate_swi_petition() {
	//require_once plugin_dir_path( __FILE__ ) . 'includes/class-swi-petition-deactivator.php';
	//Swi_Petition_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_swi_petition' );
register_deactivation_hook( __FILE__, 'deactivate_swi_petition' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_swi_petition() {

	$plugin = new SwiPetition(new SwiHookLoader());
	$plugin->run();

}
run_swi_petition();
