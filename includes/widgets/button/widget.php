<?php
namespace Mentorai\Widgets\Button;

if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once MENTORAI_PATH . 'includes/widgets/_shared/base-widget.php';

use Mentorai\Widgets\Shared\Base_Widget;

class Widget extends Base_Widget {

	public function get_name(): string {
		return 'mentorai-button';
	}

	public function get_title(): string {
		return __( 'MentorAI Button', 'mentorai' );
	}

	public function get_icon(): string {
		return 'eicon-button';
	}

	public function get_categories(): array {
		return parent::get_categories();
	}

	public function get_style_depends(): array {
		return [ 'mentorai-button' ];
	}

	protected function register_controls(): void {
		require __DIR__ . '/controls.php';
		Controls::register( $this );
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$widget   = $this;
		require __DIR__ . '/view.php';
	}
}
