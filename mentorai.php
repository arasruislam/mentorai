<?php
/**
 * Plugin Name: Mentorai
 * Description: Custom Elementor widget library.
 * Version: 0.1.0
 * Author: Mentorai
 * Text Domain: mentorai
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'MENTORAI_VERSION', '0.1.0' );
define( 'MENTORAI_FILE', __FILE__ );
define( 'MENTORAI_PATH', plugin_dir_path( __FILE__ ) );
define( 'MENTORAI_URL', plugin_dir_url( __FILE__ ) );

require_once MENTORAI_PATH . 'includes/bootstrap.php';

Mentorai\Bootstrap::init();
