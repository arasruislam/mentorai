<?php
namespace Mentorai\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Widgets_Registry {

	/**
	 * Single source of truth for:
	 * - Dashboard widget list
	 * - Settings toggles
	 * - Actual registration
	 */
	public static function all(): array {

		return [
			'mentorai-breadcrumb' => [
				'title'       => __( 'Breadcrumb', 'mentorai' ),
				'description' => __( 'Dynamic breadcrumb widget.', 'mentorai' ),
				'file'        => MENTORAI_PATH . 'includes/widgets/breadcrumb/widget.php',
				'controls'    => MENTORAI_PATH . 'includes/widgets/breadcrumb/controls.php',
				'class'       => '\Mentorai\Widgets\Breadcrumb\Widget',
			],

			// Future widgets add here:
			// 'mentorai-xyz' => [
			//   'title' => 'XYZ',
			//   'description' => '...',
			//   'file' => MENTORAI_PATH . 'includes/widgets/xyz/widget.php',
			//   'controls' => MENTORAI_PATH . 'includes/widgets/xyz/controls.php',
			//   'class' => '\Mentorai\Widgets\Xyz\Widget',
			// ],
		];
	}
}
