<?php
namespace MentorAI\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Categories_Manager {

	public const CATEGORY_SLUG = 'mentorai-widgets';

	public function init(): void {
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
	}

	public function register_category( $elements_manager ): void {
		$elements_manager->add_category(
			self::CATEGORY_SLUG,
			[
				'title' => __( 'Mentorai', 'mentorai' ),
				'icon'  => 'fa fa-plug',
			]
		);
	}
}
