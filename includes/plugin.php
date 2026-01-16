<?php
namespace Mentorai;

use Mentorai\Managers\Widgets_Manager;
use Mentorai\Managers\Categories_Manager;
use Mentorai\Managers\Assets_Manager;
use Mentorai\Managers\CPT_Manager;
use Mentorai\Managers\Admin_Pages_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Plugin {

	private static ?Plugin $instance = null;

	private Widgets_Manager $widgets;
	private Categories_Manager $categories;
	private Assets_Manager $assets;
	private CPT_Manager $cpt;
	private Admin_Pages_Manager $admin_pages;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	public function init(): void {
		// $this->cpt        = new CPT_Manager();
    // $this->cpt->init();

		$this->admin_pages = new Admin_Pages_Manager();
    $this->admin_pages->init();

		$this->categories = new Categories_Manager();
    $this->categories->init();

		$this->assets     = new Assets_Manager();
    $this->assets->init();

		$this->widgets    = new Widgets_Manager();
    $this->widgets->init();

	}
}
