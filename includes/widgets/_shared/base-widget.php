<?php
namespace Mentorai\Widgets\Shared;

if ( ! defined( 'ABSPATH' ) ) { exit; }

// ✅ Safety: if Elementor is not loaded yet, do not fatal
if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
	return;
}

use Elementor\Widget_Base;
use Mentorai\Managers\Categories_Manager;

abstract class Base_Widget extends Widget_Base {

	public function get_categories(): array {
		return [ Categories_Manager::CATEGORY_SLUG ];
	}

	/**
	 * Optional default icon for widgets that don't override get_icon().
	 * NOTE: Elementor expects a single icon class here.
	 * Adding extra classes here is not reliable for "badge" in the panel.
	 */
	public function get_icon(): string {
		return 'eicon-star mentorai-panel-badge';
	}
}
