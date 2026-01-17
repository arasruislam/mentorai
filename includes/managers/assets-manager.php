<?php
namespace Mentorai\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Assets_Manager {

	public function init(): void {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'register_frontend_styles' ] );


	}

	public function enqueue_admin_assets( string $hook ): void {
		// Only load on Mentorai admin pages (add_menu_page / add_submenu_page)
		$page = isset( $_GET['page'] ) ? (string) $_GET['page'] : ''; // phpcs:ignore

		// Our pages: mentorai-dashboard, mentorai-*
		if ( 0 !== strpos( $page, 'mentorai-' ) ) {
			return;
		}

		wp_enqueue_style(
			'mentorai-admin',
			MENTORAI_URL . 'assets/css/admin/admin.css',
			[],
			MENTORAI_VERSION
		);

    wp_enqueue_style(
      'mentorai-editor',
      MENTORAI_URL . 'assets/css/editor/editor.css',
      [],
      MENTORAI_VERSION
    );

	}

	public function enqueue_editor_styles(): void {
		wp_enqueue_style(
			'mentorai-editor',
			MENTORAI_URL . 'assets/css/editor/editor.css',
			[],
			MENTORAI_VERSION
		);
	}

	public function enqueue_editor_scripts(): void {
		wp_enqueue_script(
			'mentorai-editor',
			MENTORAI_URL . 'assets/js/editor/editor.js',
			[ 'jquery' ],
			MENTORAI_VERSION,
			true
		);
	}

  // Breadcrumb
  public function register_frontend_styles(): void {
	wp_register_style(
		'mentorai-widget-breadcrumb',
		MENTORAI_URL . 'assets/css/frontend/widget-breadcrumb.css',
		[],
		MENTORAI_VERSION
	);
}
}
