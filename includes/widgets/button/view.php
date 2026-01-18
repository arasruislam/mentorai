<?php
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

$preset     = ! empty( $settings['preset'] ) ? $settings['preset'] : 'p1';
$text       = isset( $settings['text'] ) ? $settings['text'] : '';
$full_width = ( isset( $settings['full_width'] ) && $settings['full_width'] === 'yes' );

$link = isset( $settings['link'] ) ? $settings['link'] : [];
$url  = ! empty( $link['url'] ) ? $link['url'] : '';

$btn_tag = $url ? 'a' : 'button';

$widget->add_render_attribute( 'wrap', 'class', 'mentorai-btn-wrap' );

$classes = [ 'mentorai-btn', 'mentorai-btn--' . esc_attr( $preset ) ];
if ( $full_width ) $classes[] = 'is-full';

$widget->add_render_attribute( 'btn', 'class', $classes );

// Link attributes
if ( $url ) {
    $widget->add_render_attribute( 'btn', 'href', esc_url( $url ) );

    if ( ! empty( $link['is_external'] ) ) {
        $widget->add_render_attribute( 'btn', 'target', '_blank' );
    }
    if ( ! empty( $link['nofollow'] ) ) {
        $widget->add_render_attribute( 'btn', 'rel', 'nofollow' );
    }
    if ( ! empty( $link['custom_attributes'] ) ) {
        // Elementor will pass raw custom attributes; keep as-is
        $widget->add_render_attribute( 'btn', 'data-custom', $link['custom_attributes'] );
    }
}

// Accessibility
$aria_label = ! empty( $settings['aria_label'] ) ? $settings['aria_label'] : '';
if ( $aria_label ) {
    $widget->add_render_attribute( 'btn', 'aria-label', esc_attr( $aria_label ) );
}

$show_icon     = ( isset( $settings['show_icon'] ) && $settings['show_icon'] === 'yes' );
$icon_position = ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'after';
$icon          = ! empty( $settings['icon'] ) ? $settings['icon'] : [];

?>
<div <?php echo $widget->get_render_attribute_string( 'wrap' ); ?>>
    <<?php echo esc_html( $btn_tag ); ?> <?php echo $widget->get_render_attribute_string( 'btn' ); ?>>
        <span class="mentorai-btn__inner">
            <?php if ( $show_icon && $icon_position === 'before' && ! empty( $icon['value'] ) ) : ?>
                <span class="mentorai-btn__icon is-before" aria-hidden="true">
                    <?php Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            <?php endif; ?>

            <?php if ( $text !== '' ) : ?>
                <span class="mentorai-btn__text"><?php echo esc_html( $text ); ?></span>
            <?php endif; ?>

            <?php if ( $show_icon && $icon_position === 'after' && ! empty( $icon['value'] ) ) : ?>
                <span class="mentorai-btn__icon is-after" aria-hidden="true">
                    <?php Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            <?php endif; ?>
        </span>
    </<?php echo esc_html( $btn_tag ); ?>>
</div>
