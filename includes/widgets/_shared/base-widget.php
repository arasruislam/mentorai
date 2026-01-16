<?php
namespace MentorAI\Widgets\Shared;

use Elementor\Widget_Base;
use MentorAI\Managers\Categories_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

abstract class Base_Widget extends Widget_Base {

	public function get_categories(): array {
		return [ Categories_Manager::CATEGORY_SLUG ];
	}

	// You can centralize common helpers here later:
	// - get_script_depends()
	// - get_style_depends()
	// - common sanitize/render helpers
}
