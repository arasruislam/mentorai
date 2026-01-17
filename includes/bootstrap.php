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

		// ✅ Load core classes/files (order matters)
		self::load_core_files();

		// ✅ Admin should always work (Dashboard/Settings/Licences + admin assets)
		Plugin::instance()->init_admin_only();

		// Elementor installed/activated?
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_elementor_missing' ] );
			return; // stop Elementor widgets boot, admin still works
		}

		// Elementor version ok?
		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, self::MIN_ELEMENTOR_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ __CLASS__, 'notice_elementor_version' ] );
			return;
		}

		// ✅ Boot Elementor-dependent features after Elementor init
		add_action( 'elementor/init', [ __CLASS__, 'boot_after_elementor' ] );
	}

	public static function boot_after_elementor(): void {
    // ✅ load Elementor-dependent base class AFTER Elementor is ready
	  require_once MENTORAI_PATH . 'includes/widgets/_shared/base-widget.php';

		// Widgets + Elementor category registration
		Plugin::instance()->init_elementor();
	}

	/**
	 * Load files that are required for:
	 * - Admin UI (always)
	 * - Widget registry/settings
	 * - Elementor widgets (when Elementor is ready)
	 */
	private static function load_core_files(): void {

		// Main plugin singleton
		require_once MENTORAI_PATH . 'includes/plugin.php';

		// Managers (order matters)
		require_once MENTORAI_PATH . 'includes/managers/widgets-registry.php';
		require_once MENTORAI_PATH . 'includes/managers/widgets-settings.php';

		require_once MENTORAI_PATH . 'includes/managers/admin-pages-manager.php';
		require_once MENTORAI_PATH . 'includes/managers/assets-manager.php';

		// Elementor-related managers (safe to load, but init happens later)
		require_once MENTORAI_PATH . 'includes/managers/categories-manager.php';
		require_once MENTORAI_PATH . 'includes/managers/widgets-manager.php';

		// Optional CPT (only if you plan to use it later)
		// require_once MENTORAI_PATH . 'includes/managers/cpt-manager.php';
	}

	public static function notice_elementor_missing(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }

		printf(
			'<div class="%1$s"><p><strong>%2$s</strong></p></div>',
			esc_attr( 'notice notice-warning is-dismissible' ),
			esc_html__( 'Mentorai requires Elementor to be installed and activated for widgets. Admin panel is available.', 'mentorai' )
		);
	}

	public static function notice_elementor_version(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }

		$msg = sprintf(
			/* translators: 1: required Elementor version, 2: current Elementor version */
			__( 'Mentorai requires Elementor %1$s or higher. Current version: %2$s.', 'mentorai' ),
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
