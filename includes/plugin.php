<?php
namespace Mentorai;

use Mentorai\Managers\Widgets_Manager;
use Mentorai\Managers\Categories_Manager;
use Mentorai\Managers\Assets_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Plugin {

	private static ?Plugin $instance = null;

	private Widgets_Manager $widgets;
	private Categories_Manager $categories;
	private Assets_Manager $assets;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	public function init(): void {
		$this->categories = new Categories_Manager();
		$this->assets     = new Assets_Manager();
		$this->widgets    = new Widgets_Manager();

		$this->categories->init();
		$this->assets->init();
		$this->widgets->init();
	}
}
