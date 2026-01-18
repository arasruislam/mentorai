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
        'default' => 'current-pill',
        'options' => [
          'ant-breadcrumb'     => __( '01 — Ant Design Breadcrumb', 'mentorai' ),
          'shadcn-ghost'       => __( '02 — Shadcn Ghost', 'mentorai' ),
          'material-chips'     => __( '03 — Material Chips', 'mentorai' ),
          'shadcn-underline'   => __( '04 — Shadcn Underline', 'mentorai' ),
          'neumorph-soft'      => __( '05 — Neumorph Soft', 'mentorai' ),
          'glass-frost'        => __( '06 — Glass Frost', 'mentorai' ),
          'terminal-mono'      => __( '07 — Terminal / Mono', 'mentorai' ),
          'tag-trail'          => __( '08 — Tag Trail', 'mentorai' ),
          'timeline-steps'     => __( '09 — Timeline Steps', 'mentorai' ),
          'segmented'          => __( '10 — Segmented Control', 'mentorai' ),
          'current-pill'       => __( '11 — Ant Current Pill', 'mentorai' ),
          'gradient-active'    => __( '12 — Gradient Active', 'mentorai' ),
          'minimal-uppercase'  => __( '13 — Minimal Uppercase', 'mentorai' ),
          'breadcrumb-bar'     => __( '14 — Breadcrumb Bar', 'mentorai' ),
          'dark-neon'          => __( '15 — Dark Neon', 'mentorai' ),
        ],
      ]
    );

    $widget->add_control(
    'preset_surface',
    [
      'label'        => __( 'Use Preset Surface (BG / Border / Shadow)', 'mentorai' ),
      'type'         => Controls_Manager::SWITCHER,
      'return_value' => 'yes',
      'default'      => 'yes',
      'description'  => __( 'Turn off to fully control background, border and shadow from Style tab.', 'mentorai' ),
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

		$widget->end_controls_section();

		/* -----------------------
		 * Content: Separator
		 * ----------------------*/
		$widget->start_controls_section(
			'section_separator',
			[
				'label' => __( 'Separator', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'separator_type',
			[
				'label'   => __( 'Separator Type', 'mentorai' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'text' => __( 'Text', 'mentorai' ),
					'icon' => __( 'Icon', 'mentorai' ),
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

		// Default icon always exists; user can change it.
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
		 * Content: Item Icons
		 * ----------------------*/
		$widget->start_controls_section(
			'section_item_icons',
			[
				'label' => __( 'Item Icons', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'enable_item_icons',
			[
				'label'        => __( 'Enable Item Icons', 'mentorai' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$widget->add_control(
			'item_icon_position',
			[
				'label'     => __( 'Icon Position', 'mentorai' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'before',
				'options'   => [
					'before' => __( 'Before Label', 'mentorai' ),
					'after'  => __( 'After Label', 'mentorai' ),
				],
				'condition' => [ 'enable_item_icons' => 'yes' ],
			]
		);

		$widget->add_control(
			'item_icon_source',
			[
				'label'     => __( 'Icon Source', 'mentorai' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'auto',
				'options'   => [
					'auto'   => __( 'Auto (Smart Mapping)', 'mentorai' ),
					'custom' => __( 'Custom (Override)', 'mentorai' ),
				],
				'condition' => [ 'enable_item_icons' => 'yes' ],
			]
		);

		// Custom overrides (only shown if custom)
		$widget->add_control(
			'icon_home',
			[
				'label'     => __( 'Home Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-house', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_archive',
			[
				'label'     => __( 'Archive / Post Type Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-box-archive', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_term',
			[
				'label'     => __( 'Category / Tag / Term Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-tags', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_page',
			[
				'label'     => __( 'Page Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-file-lines', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_post',
			[
				'label'     => __( 'Post Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-newspaper', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_search',
			[
				'label'     => __( 'Search Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-magnifying-glass', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_404',
			[
				'label'     => __( '404 Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-triangle-exclamation', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_author',
			[
				'label'     => __( 'Author Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-user', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
			]
		);

		$widget->add_control(
			'icon_date',
			[
				'label'     => __( 'Date Icon', 'mentorai' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-calendar-days', 'library' => 'fa-solid' ],
				'condition' => [ 'enable_item_icons' => 'yes', 'item_icon_source' => 'custom' ],
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
					'px' => [ 'min' => 0, 'max' => 60 ],
					'em' => [ 'min' => 0, 'max' => 4 ],
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
		 * Style: Icons (Item + Separator)
		 * ----------------------*/
		$widget->start_controls_section(
			'section_style_icons',
			[
				'label' => __( 'Icons', 'mentorai' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_responsive_control(
			'item_icon_size',
			[
				'label'      => __( 'Item Icon Size', 'mentorai' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 8, 'max' => 64 ],
					'em' => [ 'min' => .5, 'max' => 4 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .mentorai-bc__item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mentorai-bc__item-icon svg' => 'width: 1em; height: 1em;',
				],
			]
		);

		$widget->add_responsive_control(
			'item_icon_gap',
			[
				'label'      => __( 'Item Icon Gap', 'mentorai' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 30 ],
					'em' => [ 'min' => 0, 'max' => 2 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .mentorai-bc__label' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			'separator_icon_size',
			[
				'label'      => __( 'Separator Size', 'mentorai' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 8, 'max' => 64 ],
					'em' => [ 'min' => .5, 'max' => 4 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .mentorai-bc__sep' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .mentorai-bc__sep' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mentorai-bc__sep svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'item_icon_color',
			[
				'label'     => __( 'Item Icon Color', 'mentorai' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mentorai-bc__item-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mentorai-bc__item-icon svg' => 'fill: currentColor; stroke: currentColor;',
				],
			]
		);

		$widget->add_control(
			'item_icon_hover_color',
			[
				'label'     => __( 'Item Icon Hover Color', 'mentorai' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mentorai-bc__link:hover .mentorai-bc__item-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'item_icon_current_color',
			[
				'label'     => __( 'Item Icon Current Color', 'mentorai' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mentorai-bc__current .mentorai-bc__item-icon' => 'color: {{VALUE}};',
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
