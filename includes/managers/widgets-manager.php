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
		$this->register_breadcrumb( $widgets_manager );
	}

	private function register_breadcrumb( Elementor_Widgets_Manager $widgets_manager ): void {
		require_once MENTORAI_PATH . 'includes/widgets/breadcrumb/widget.php';
		require_once MENTORAI_PATH . 'includes/widgets/breadcrumb/controls.php';

		$widgets_manager->register( new \Mentorai\Widgets\Breadcrumb\Widget() );
	}
}
