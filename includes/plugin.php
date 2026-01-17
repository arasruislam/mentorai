<?php
namespace Mentorai;

use Mentorai\Managers\Widgets_Manager;
use Mentorai\Managers\Assets_Manager;
use Mentorai\Managers\Admin_Pages_Manager;
use Mentorai\Managers\Categories_Manager;
use Mentorai\Managers\CPT_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Plugin {

	private static ?Plugin $instance = null;

	private ?Widgets_Manager $widgets = null;
	private ?Categories_Manager $categories = null;
	private ?Assets_Manager $assets = null;
	private ?CPT_Manager $cpt = null;
	private ?Admin_Pages_Manager $admin_pages = null;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	/**
	 * Backward compatible entry point (your old Bootstrap may call this).
	 * We keep this, but internally it becomes "safe init".
	 */
	public function init(): void {
		$this->init_admin_only();

		// Elementor widgets only if Elementor is loaded
		if ( did_action( 'elementor/loaded' ) ) {
			$this->init_elementor();
		}
	}

	/**
	 * Always-on: Admin pages + admin/editor assets
	 */
	public function init_admin_only(): void {

		// Admin pages (Dashboard/Settings/Licences) — always
		if ( null === $this->admin_pages ) {
			$this->admin_pages = new Admin_Pages_Manager();
			$this->admin_pages->init();
		}

		// Assets manager — always (admin css, editor css, etc.)
		if ( null === $this->assets ) {
			$this->assets = new Assets_Manager();
			$this->assets->init();
		}

		// CPT optional (you currently keep it hidden; keep disabled by default)
		// If you want it later, just uncomment.
		/*
		if ( null === $this->cpt ) {
			$this->cpt = new CPT_Manager();
			$this->cpt->init();
		}
		*/
	}

	/**
	 * Elementor-only init: categories + widget registration
	 */
	public function init_elementor(): void {

		// Category for Elementor panel
		if ( null === $this->categories ) {
			$this->categories = new Categories_Manager();
			$this->categories->init();
		}

		// Widgets register (will respect Widgets_Settings toggles)
		if ( null === $this->widgets ) {
			$this->widgets = new Widgets_Manager();
			$this->widgets->init();
		}
	}
}
