<?php
/**
 * Plugin Name:     Roi Calculator
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     roi-calculator
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Roi_Calculator
 */

// Your code starts here.
namespace roi;
use roi\includes\Roi_Calculator;


include_once plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'class-wp-autoloader.php';


register_activation_hook(__FILE__,[Roi_Calculator::class, 'onPluginActivation']);

register_deactivation_hook(__FILE__, [Roi_Calculator::class, 'onPluginDeactivation']);

(new Roi_Calculator())->init();

//Unregister Autoloader
spl_autoload_unregister([WP_Autoloader::class, 'loadClass']);