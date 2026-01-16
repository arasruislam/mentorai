<?php
namespace MentorAI;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Bootstrap {

	public static function init(): void {
		add_action( 'plugins_loaded', [ __CLASS__, 'on_plugins_loaded' ] );
	}

	public static function on_plugins_loaded(): void {
		// Load translations
		load_plugin_textdomain( 'mentorai', false, dirname( plugin_basename( MENTORAI_FILE ) ) . '/languages' );

		// Elementor check
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_elementor_missing' ] );
			return;
		}

		// Optional: Minimum Elementor version check (adjust if you want)
		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '<' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_elementor_version' ] );
			return;
		}

		// Manual "autoload" (simple + explicit, good for WP plugins)
		self::load_core_files();

		Plugin::instance()->init();
	}

	private static function load_core_files(): void {
		require_once MENTORAI_PATH . 'includes/plugin.php';
		require_once MENTORAI_PATH . 'includes/managers/widgets-manager.php';
		require_once MENTORAI_PATH . 'includes/managers/categories-manager.php';
		require_once MENTORAI_PATH . 'includes/managers/assets-manager.php';

		// Shared base widget
		require_once MENTORAI_PATH . 'includes/widgets/_shared/base-widget.php';
	}

	public static function notice_elementor_missing(): void {
		echo '<div class="notice notice-warning"><p>';
		echo esc_html__( 'MentorAI requires Elementor to be installed and activated.', 'mentorai' );
		echo '</p></div>';
	}

	public static function notice_elementor_version(): void {
		echo '<div class="notice notice-warning"><p>';
		echo esc_html__( 'MentorAI requires a newer version of Elementor.', 'mentorai' );
		echo '</p></div>';
	}
}
