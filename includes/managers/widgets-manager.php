<?php
namespace MentorAI\Managers;

use Elementor\Widgets_Manager as Elementor_Widgets_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Widgets_Manager {

	public function init(): void {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function register_widgets( Elementor_Widgets_Manager $widgets_manager ): void {
		// Load & register widgets here (one place only)
		$this->register_hello( $widgets_manager );
	}

	private function register_hello( Elementor_Widgets_Manager $widgets_manager ): void {
		require_once MENTORAI_PATH . 'includes/widgets/hello/widget.php';

		$widgets_manager->register( new \MentorAI\Widgets\Hello\Widget() );
	}
}
