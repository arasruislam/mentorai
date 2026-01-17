<?php
namespace Mentorai\Widgets\Breadcrumb;

use Mentorai\Widgets\Shared\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Widget extends Base_Widget {

	public function get_name(): string {
		return 'mentorai-breadcrumb';
	}

	public function get_title(): string {
		return __( 'Breadcrumb (Mentorai)', 'mentorai' );
	}

	public function get_icon(): string {
		return 'eicon-breadcrumbs';
	}

	/**
	 * Frontend preset CSS file handle (we will register/enqueue it via Assets Manager).
	 */
	public function get_style_depends(): array {
		return [ 'mentorai-widget-breadcrumb' ];
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
