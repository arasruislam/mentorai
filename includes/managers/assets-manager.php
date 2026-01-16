<?php
namespace MentorAI\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Assets_Manager {

	public function init(): void {
		// Global editor assets (optional)
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
	}

	public function enqueue_editor_styles(): void {
		$path = MENTORAI_URL . 'assets/css/editor/editor.css';
		wp_enqueue_style( 'mentorai-editor', $path, [], MENTORAI_VERSION );
	}

	public function enqueue_editor_scripts(): void {
		$path = MENTORAI_URL . 'assets/js/editor/editor.js';
		wp_enqueue_script( 'mentorai-editor', $path, [ 'jquery' ], MENTORAI_VERSION, true );
	}
}
