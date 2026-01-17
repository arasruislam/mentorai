<?php
namespace Mentorai\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class CPT_Manager {

	public const POST_TYPE = 'mentorai';

	public function init(): void {
		add_action( 'init', [ $this, 'register_post_type' ] );
	}

	public function register_post_type(): void {

		$labels = [
			'name'          => __( 'Mentorai', 'mentorai' ),
			'singular_name' => __( 'Mentorai Item', 'mentorai' ),
			'menu_name'     => __( 'Mentorai', 'mentorai' ),
			'add_new_item'  => __( 'Add New Mentorai Item', 'mentorai' ),
			'edit_item'     => __( 'Edit Mentorai Item', 'mentorai' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => false,
			'show_ui'             => false,
			'show_in_menu'        => true,
			'menu_position'       => 58,
			'menu_icon'           => false,
			'supports'            => [ ],
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_in_rest'        => false,
		];

		register_post_type( self::POST_TYPE, $args );
	}
}
