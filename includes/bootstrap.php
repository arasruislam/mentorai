<?php
namespace Mentorai;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Bootstrap {

	private const MIN_ELEMENTOR_VERSION = '3.0.0';

	public static function init(): void {
		add_action( 'plugins_loaded', [ __CLASS__, 'on_plugins_loaded' ] );
	}

	public static function on_plugins_loaded(): void {

		load_plugin_textdomain(
			'mentorai',
			false,
			dirname( plugin_basename( MENTORAI_FILE ) ) . '/languages'
		);

		// Elementor installed/activated?
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_elementor_missing' ] );
			return;
		}

		// Elementor version ok?
		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, self::MIN_ELEMENTOR_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_elementor_version' ] );
			return;
		}

		// IMPORTANT: Elementor classes guaranteed after elementor/init
		add_action( 'elementor/init', [ __CLASS__, 'boot_after_elementor' ] );
	}

	public static function boot_after_elementor(): void {
		self::load_core_files();
		Plugin::instance()->init();
	}

	private static function load_core_files(): void {
		require_once MENTORAI_PATH . 'includes/plugin.php';

		require_once MENTORAI_PATH . 'includes/managers/categories-manager.php';
		require_once MENTORAI_PATH . 'includes/managers/assets-manager.php';
		require_once MENTORAI_PATH . 'includes/managers/widgets-manager.php';
    // Post Type
    require_once MENTORAI_PATH . 'includes/managers/cpt-manager.php';
    require_once MENTORAI_PATH . 'includes/managers/admin-pages-manager.php';


		// Shared base widget (Elementor classes should exist now)
		require_once MENTORAI_PATH . 'includes/widgets/_shared/base-widget.php';
	}

	public static function notice_elementor_missing(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }

		printf(
			'<div class="%1$s"><p><strong>%2$s</strong></p></div>',
			esc_attr( 'notice notice-warning is-dismissible' ),
			esc_html__( 'MentorAI requires Elementor to be installed and activated.', 'mentorai' )
		);
	}

	public static function notice_elementor_version(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }

		$msg = sprintf(
			/* translators: 1: required Elementor version, 2: current Elementor version */
			__( 'MentorAI requires Elementor %1$s or higher. Current version: %2$s.', 'mentorai' ),
			self::MIN_ELEMENTOR_VERSION,
			defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '—'
		);

		printf(
			'<div class="%1$s"><p><strong>%2$s</strong></p></div>',
			esc_attr( 'notice notice-warning is-dismissible' ),
			esc_html( $msg )
		);
	}
}
