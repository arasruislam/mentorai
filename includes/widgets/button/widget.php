<?php
namespace Mentorai\Widgets\Button;

use Mentorai\Widgets\Shared\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Widget extends Base_Widget {

	public function get_name(): string {
		return 'mentorai-button';
	}

	public function get_title(): string {
		return __( 'Button', 'mentorai' );
	}

	public function get_icon(): string {
		return 'eicon-button mentorai-panel-badge';
	}

	public function get_style_depends(): array {
		return [ 'mentorai-button' ];
	}

	protected function register_controls(): void {
		require_once __DIR__ . '/controls.php';
		Controls::register( $this );
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		require __DIR__ . '/view.php';
	}
}
