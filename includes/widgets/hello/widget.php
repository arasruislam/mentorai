<?php
namespace Mentorai\Widgets\Hello;

use Mentorai\Widgets\Shared\Base_Widget;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Widget extends Base_Widget {

	public function get_name(): string {
		return 'mentorai-hello';
	}

	public function get_title(): string {
		return __( 'Hello (MentorAI)', 'mentorai' );
	}

	public function get_icon(): string {
		return 'eicon-code';
	}

	protected function register_controls(): void {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'mentorai' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Hello from MentorAI', 'mentorai' ),
				'placeholder' => __( 'Enter title...', 'mentorai' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$title    = isset( $settings['title'] ) ? $settings['title'] : '';

		echo '<div class="mentorai-hello">';
		echo '<h3 class="mentorai-hello__title">' . esc_html( $title ) . '</h3>';
		echo '</div>';
	}
}
