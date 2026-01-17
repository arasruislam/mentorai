<?php
namespace Mentorai\Managers;

use Elementor\Widgets_Manager as Elementor_Widgets_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Widgets_Manager {

	public function init(): void {

		// ✅ Register Mentorai category
		( new Categories_Manager() )->init();

		// ✅ Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function register_widgets( Elementor_Widgets_Manager $widgets_manager ): void {

		$all_widgets = Widgets_Registry::all();

		foreach ( $all_widgets as $slug => $meta ) {

			// ✅ Respect Settings toggle
			if ( ! Widgets_Settings::is_enabled( $slug ) ) {
				continue;
			}

			// Load required files
			if ( ! empty( $meta['file'] ) && file_exists( $meta['file'] ) ) {
				require_once $meta['file'];
			}

			if ( ! empty( $meta['controls'] ) && file_exists( $meta['controls'] ) ) {
				require_once $meta['controls'];
			}

			$class = $meta['class'] ?? '';
			if ( $class && class_exists( $class ) ) {
				$widgets_manager->register( new $class() );
			}
		}
	}
}
