<?php
/**
 * @package wooRelProducts
 */
/*
Plugin Name: Related Products Woocommerce
Plugin URI: https://github.com/netzstrategen/test-wp-related-products-david
Description: Select products to show in a related products section wich can be set anywhere inside your website.
Version: 1.0.0
Author: David Galvez
Author URI: https://davidgalvez.github.io/
License: GPL3 or later
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: wooRelProducts
*/

defined('ABSPATH') or die("Not allowed access!!");

if(file_exists(dirname(__FILE__)."/vendor/autoload.php"))
{
  require_once(dirname(__FILE__)."/vendor/autoload.php");
}
require_once("wooRelProducts-config.php");

/**
 * This method excecutes the plugin activation hook
 */
function wooRelProduct_activate_plugin() {
	wooRelProducts\Base\Activate::activate();
}

/**
 * This method excecutes the plugin deactivation hook
 */
function wooRelProduct_deactivate_plugin() {
	wooRelProducts\Base\Deactivate::deactivate();
}

register_activation_hook( __FILE__, 'wooRelProduct_activate_plugin' );
register_deactivation_hook( __FILE__, 'wooRelProduct_deactivate_plugin' );

/**
 * Init the core services for the plugin
 */
if ( class_exists( 'wooRelProducts\\Init' ) ) {
	wooRelProducts\Init::register_services(WOORELPRODS_PLUGIN);
}