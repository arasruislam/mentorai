<?php
namespace Mentorai\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Assets_Manager {

	public function init(): void {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
	}

	public function enqueue_admin_assets( string $hook ): void {
		// Only load on Mentorai CPT and Mentorai pages
		$post_type = isset( $_GET['post_type'] ) ? (string) $_GET['post_type'] : ''; // phpcs:ignore
		$page      = isset( $_GET['page'] ) ? (string) $_GET['page'] : ''; // phpcs:ignore

		$is_mentorai_cpt  = ( $post_type === CPT_Manager::POST_TYPE );
		$is_mentorai_page = ( 0 === strpos( $page, 'mentorai-' ) );

		if ( ! $is_mentorai_cpt && ! $is_mentorai_page ) {
			return;
		}

		wp_enqueue_style(
			'mentorai-admin',
			MENTORAI_URL . 'assets/css/admin/admin.css',
			[],
			MENTORAI_VERSION
		);
	}

	public function enqueue_editor_styles(): void {
		wp_enqueue_style( 'mentorai-editor', MENTORAI_URL . 'assets/css/editor/editor.css', [], MENTORAI_VERSION );
	}

	public function enqueue_editor_scripts(): void {
		wp_enqueue_script( 'mentorai-editor', MENTORAI_URL . 'assets/js/editor/editor.js', [ 'jquery' ], MENTORAI_VERSION, true );
	}
}
