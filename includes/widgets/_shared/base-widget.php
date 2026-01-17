<?php
namespace Mentorai\Widgets\Shared;

use Elementor\Widget_Base;
use Mentorai\Managers\Categories_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

abstract class Base_Widget extends Widget_Base {

	public function get_categories(): array {
		return [ Categories_Manager::CATEGORY_SLUG ];
	}

	/**
	 * ✅ Add a unique icon marker class for Mentorai widgets
	 * So we can target widget tiles in Elementor panel using CSS.
	 */
	public function get_icon(): string {
		// Your child widgets can still override, but if they don't, this applies.
		return 'eicon-star mentorai-panel-badge';
	}
}
