<?php
namespace MentorAI\Widgets\Shared;

use Elementor\Widget_Base;
use MentorAI\Managers\Categories_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

abstract class Base_Widget extends Widget_Base {

	public function get_categories(): array {
		return [ Categories_Manager::CATEGORY_SLUG ];
	}
}
