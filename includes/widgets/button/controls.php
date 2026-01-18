<?php
namespace MentorAI\Widgets\Button;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class Controls {

    public static function register( $widget ) {

        /**
         * CONTENT: Button
         */
        $widget->start_controls_section(
            'section_content',
            [
                'label' => __( 'Button', 'mentorai' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'preset',
            [
                'label'   => __( 'Built-in Design', 'mentorai' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'p1',
                'options' => [
                    'p1' => __( 'P1 — Shadcn Solid', 'mentorai' ),
                    'p2' => __( 'P2 — Ant Ghost', 'mentorai' ),
                    'p3' => __( 'P3 — Material Gradient', 'mentorai' ),
                    'p4' => __( 'P4 — Neumorphism Soft', 'mentorai' ),
                    'p5' => __( 'P5 — Glass / Frosted', 'mentorai' ),
                ],
            ]
        );

        $widget->add_control(
            'text',
            [
                'label'       => __( 'Text', 'mentorai' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Click Me', 'mentorai' ),
                'placeholder' => __( 'Type your button text', 'mentorai' ),
                'label_block' => true,
            ]
        );

        $widget->add_control(
            'link',
            [
                'label'       => __( 'Link', 'mentorai' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'mentorai' ),
                'default'     => [ 'url' => '' ],
                'options'     => [ 'url', 'is_external', 'nofollow', 'custom_attributes' ],
            ]
        );

        $widget->add_control(
            'aria_label',
            [
                'label'       => __( 'ARIA Label (Accessibility)', 'mentorai' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'placeholder' => __( 'e.g. Open pricing page', 'mentorai' ),
                'description' => __( 'Recommended when button text is not descriptive.', 'mentorai' ),
                'label_block' => true,
            ]
        );

        $widget->add_control(
            'full_width',
            [
                'label'        => __( 'Full Width', 'mentorai' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $widget->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'mentorai' ),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'mentorai' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'mentorai' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'mentorai' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn-wrap' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'show_icon',
            [
                'label'        => __( 'Show Icon', 'mentorai' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $widget->add_control(
            'icon',
            [
                'label'     => __( 'Icon', 'mentorai' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'show_icon' => 'yes' ],
            ]
        );

        $widget->add_control(
            'icon_position',
            [
                'label'   => __( 'Icon Position', 'mentorai' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => __( 'Before Text', 'mentorai' ),
                    'after'  => __( 'After Text', 'mentorai' ),
                ],
                'condition' => [ 'show_icon' => 'yes' ],
            ]
        );

        $widget->add_control(
            'icon_gap',
            [
                'label' => __( 'Icon Gap', 'mentorai' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 40 ],
                ],
                'default' => [ 'size' => 10, 'unit' => 'px' ],
                'condition' => [ 'show_icon' => 'yes' ],
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn' => '--mab-icon-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();


        /**
         * STYLE: Button
         */
        $widget->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'mentorai' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .mentorai-btn',
            ]
        );

        $widget->add_responsive_control(
            'padding',
            [
                'label'      => __( 'Padding', 'mentorai' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'selectors'  => [
                    '{{WRAPPER}} .mentorai-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'radius',
            [
                'label'      => __( 'Border Radius', 'mentorai' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 80 ],
                    '%'  => [ 'min' => 0, 'max' => 100 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mentorai-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'border',
                'selector' => '{{WRAPPER}} .mentorai-btn',
            ]
        );

        $widget->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'shadow',
                'selector' => '{{WRAPPER}} .mentorai-btn',
            ]
        );

        $widget->add_control(
            'transition_ms',
            [
                'label' => __( 'Transition (ms)', 'mentorai' ),
                'type'  => Controls_Manager::NUMBER,
                'min'   => 0,
                'max'   => 2000,
                'step'  => 10,
                'default' => 220,
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn' => 'transition-duration: {{VALUE}}ms;',
                ],
            ]
        );

        $widget->add_control(
            'hover_lift',
            [
                'label' => __( 'Hover Lift (px)', 'mentorai' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 12 ],
                ],
                'default' => [ 'size' => 2, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn' => '--mab-hover-lift: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->start_controls_tabs( 'tabs_colors' );

        // Normal
        $widget->start_controls_tab(
            'tab_normal',
            [ 'label' => __( 'Normal', 'mentorai' ) ]
        );

        $widget->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'mentorai' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mentorai-btn svg' => 'fill: currentColor;',
                ],
            ]
        );

        $widget->add_control(
            'bg_color',
            [
                'label' => __( 'Background Color', 'mentorai' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'bg_gradient',
            [
                'label'       => __( 'Background Gradient (CSS)', 'mentorai' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'linear-gradient(135deg, #111 0%, #444 100%)',
                'description' => __( 'Optional. If set, it will override background-color.', 'mentorai' ),
                'selectors'   => [
                    '{{WRAPPER}} .mentorai-btn' => 'background-image: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        // Hover
        $widget->start_controls_tab(
            'tab_hover',
            [ 'label' => __( 'Hover', 'mentorai' ) ]
        );

        $widget->add_control(
            'hover_text_color',
            [
                'label' => __( 'Text Color (Hover)', 'mentorai' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'hover_bg_color',
            [
                'label' => __( 'Background Color (Hover)', 'mentorai' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'hover_bg_gradient',
            [
                'label'       => __( 'Background Gradient (Hover, CSS)', 'mentorai' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'linear-gradient(135deg, #000 0%, #333 100%)',
                'selectors'   => [
                    '{{WRAPPER}} .mentorai-btn:hover' => 'background-image: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();


        /**
         * Glass / Frosted controls (works best with P5 but user can use any preset)
         */
        $widget->add_control(
            'glass_heading',
            [
                'label'     => __( 'Glass / Frosted', 'mentorai' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'backdrop_blur',
            [
                'label' => __( 'Backdrop Blur (px)', 'mentorai' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default' => [ 'size' => 0, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn' => '--mab-blur: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'focus_ring_color',
            [
                'label' => __( 'Focus Ring Color', 'mentorai' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mentorai-btn' => '--mab-focus: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }
}
