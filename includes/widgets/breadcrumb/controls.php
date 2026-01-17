<?php
namespace Mentorai\Widgets\Breadcrumb;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Controls {

	public static function register( $widget ): void {

		/* -----------------------
		 * Content
		 * ----------------------*/
		$widget->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'preset',
			[
				'label'   => __( 'Built-in Style', 'mentorai' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'minimal',
				'options' => [
          // Task UI presets (01–10)
          '01-chevron'      => __( '01 — Chevron', 'mentorai' ),
          '02-icons'        => __( '02 — Icon Trail', 'mentorai' ),
          '03-compact'      => __( '03 — Compact', 'mentorai' ),
          '04-slash'        => __( '04 — Slash', 'mentorai' ),
          '05-steps'        => __( '05 — Steps (Line)', 'mentorai' ),
          '06-steps-check'  => __( '06 — Steps (Check)', 'mentorai' ),
          '07-dots'         => __( '07 — Dots Progress', 'mentorai' ),
          '08-tabs'         => __( '08 — Tabs', 'mentorai' ),
          '09-tabs-active'  => __( '09 — Tabs (Active Pill)', 'mentorai' ),
          '10-pill-arrow'   => __( '10 — Pill Arrow', 'mentorai' ),

          // Classic presets (modern)
          'minimal'         => __( 'Classic — Minimal', 'mentorai' ),
          'pill'            => __( 'Classic — Pill', 'mentorai' ),
          'underline'       => __( 'Classic — Underline', 'mentorai' ),
          'dark'            => __( 'Classic — Dark', 'mentorai' ),
          'glass'           => __( 'Classic — Glass', 'mentorai' ),
        ],

			]
		);

		$widget->add_control(
			'show_home',
			[
				'label'        => __( 'Show Home', 'mentorai' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$widget->add_control(
			'home_label',
			[
				'label'     => __( 'Home Label', 'mentorai' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Home', 'mentorai' ),
				'condition' => [ 'show_home' => 'yes' ],
			]
		);

		$widget->add_control(
			'show_current',
			[
				'label'        => __( 'Show Current Item', 'mentorai' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$widget->add_control(
			'separator_type',
			[
				'label'   => __( 'Separator Type', 'mentorai' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon', // ✅ default icon
				'options' => [
					'icon' => __( 'Icon', 'mentorai' ),
					'text' => __( 'Text', 'mentorai' ),
				],
			]
		);

		$widget->add_control(
			'separator_text',
			[
				'label'     => __( 'Separator Text', 'mentorai' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '/',
				'condition' => [ 'separator_type' => 'text' ],
			]
		);

		$widget->add_control(
			'separator_icon',
			[
				'label'     => __( 'Separator Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'separator_type' => 'icon' ],
			]
		);

		$widget->end_controls_section();

		/* -----------------------
		 * Style: Layout
		 * ----------------------*/
		$widget->start_controls_section(
			'section_style_layout',
			[
				'label' => __( 'Layout', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'mentorai' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [ 'title' => __( 'Left', 'mentorai' ), 'icon' => 'eicon-text-align-left' ],
					'center'     => [ 'title' => __( 'Center', 'mentorai' ), 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => __( 'Right', 'mentorai' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .mentorai-bc__list' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$widget->add_responsive_control(
			'item_gap',
			[
				'label'      => __( 'Item Gap', 'mentorai' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 40 ],
					'em' => [ 'min' => 0, 'max' => 3 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .mentorai-bc__list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			'container_padding',
			[
				'label'      => __( 'Container Padding', 'mentorai' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mentorai-bc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_section();

		/* -----------------------
		 * Style: Separator
		 * ----------------------*/
		$widget->start_controls_section(
			'section_style_separator',
			[
				'label' => __( 'Separator', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// ✅ the reliable sizing method
		$widget->add_responsive_control(
			'separator_size',
			[
				'label'      => __( 'Icon Size', 'mentorai' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 8, 'max' => 120 ],
					'em' => [ 'min' => 0.5, 'max' => 6 ],
				],
				'default'    => [ 'size' => 14, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .mentorai-bc' => '--mentorai-sep-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_section();

		/* -----------------------
		 * Style: Typography
		 * ----------------------*/
		$widget->start_controls_section(
			'section_style_typography',
			[
				'label' => __( 'Typography', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .mentorai-bc',
			]
		);

		$widget->end_controls_section();

		/* -----------------------
		 * Style: Colors
		 * ----------------------*/
		$widget->start_controls_section(
			'section_style_colors',
			[
				'label' => __( 'Colors', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'link_color',
			[
				'label'     => __( 'Link Color', 'mentorai' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mentorai-bc__link' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'link_hover_color',
			[
				'label'     => __( 'Link Hover Color', 'mentorai' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mentorai-bc__link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'current_color',
			[
				'label'     => __( 'Current Color', 'mentorai' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mentorai-bc__current' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'separator_color',
      [
        'label'     => __( 'Separator Color', 'mentorai' ),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          // Applies to text separators + icon separators (via currentColor)
          '{{WRAPPER}} .mentorai-bc__sep' => 'color: {{VALUE}};',

          // Force SVG parts to inherit currentColor (more reliable than only svg fill)
          '{{WRAPPER}} .mentorai-bc__sep svg'    => 'fill: currentColor; stroke: currentColor;',
          '{{WRAPPER}} .mentorai-bc__sep svg *'  => 'fill: currentColor; stroke: currentColor;',

          // Font Awesome explicitly (safe)
          '{{WRAPPER}} .mentorai-bc__sep i' => 'color: {{VALUE}};',
        ],
      ]
		);

		$widget->end_controls_section();

		/* -----------------------
		 * Style: Box
		 * ----------------------*/
		$widget->start_controls_section(
			'section_style_box',
			[
				'label' => __( 'Box', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .mentorai-bc',
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .mentorai-bc',
			]
		);

		$widget->add_responsive_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'mentorai' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mentorai-bc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .mentorai-bc',
			]
		);

		$widget->end_controls_section();
	}
}
