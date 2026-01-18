<?php
/**
 * @var array $settings
 */

use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

$preset              = isset( $settings['preset'] ) ? (string) $settings['preset'] : 'minimal';
$show_home            = ( isset( $settings['show_home'] ) && 'yes' === $settings['show_home'] );
$home_label           = isset( $settings['home_label'] ) ? (string) $settings['home_label'] : __( 'Home', 'mentorai' );
$show_current         = ( isset( $settings['show_current'] ) && 'yes' === $settings['show_current'] );

$separator_type       = isset( $settings['separator_type'] ) ? (string) $settings['separator_type'] : 'icon';
$separator_text       = isset( $settings['separator_text'] ) ? (string) $settings['separator_text'] : '/';
$separator_icon       = isset( $settings['separator_icon'] ) ? $settings['separator_icon'] : [ 'value' => 'fas fa-angle-right', 'library' => 'fa-solid' ];

$enable_item_icons    = ( isset( $settings['enable_item_icons'] ) && 'yes' === $settings['enable_item_icons'] );
$item_icon_position   = isset( $settings['item_icon_position'] ) ? (string) $settings['item_icon_position'] : 'before';
$item_icon_source     = isset( $settings['item_icon_source'] ) ? (string) $settings['item_icon_source'] : 'auto';

$items = [];

/**
 * Item structure:
 * [
 *   'label' => string,
 *   'url'   => string,
 *   'type'  => string,  // home|archive|term|page|post|search|404|author|date|current
 * ]
 */

if ( is_front_page() ) {
	if ( $show_home ) {
		$items[] = [ 'label' => $home_label, 'url' => '', 'type' => 'home' ];
	}
} else {
	if ( $show_home ) {
		$items[] = [ 'label' => $home_label, 'url' => home_url( '/' ), 'type' => 'home' ];
	}

	if ( is_home() ) {
		$title = get_the_title( (int) get_option( 'page_for_posts' ) );
		$items[] = [ 'label' => $title ? $title : __( 'Blog', 'mentorai' ), 'url' => '', 'type' => 'archive' ];

	} elseif ( is_search() ) {
		$items[] = [ 'label' => sprintf( __( 'Search: %s', 'mentorai' ), get_search_query() ), 'url' => '', 'type' => 'search' ];

	} elseif ( is_404() ) {
		$items[] = [ 'label' => __( '404 Not Found', 'mentorai' ), 'url' => '', 'type' => '404' ];

	} elseif ( is_author() ) {
		$items[] = [ 'label' => get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) ), 'url' => '', 'type' => 'author' ];

	} elseif ( is_date() ) {
		$label = is_year() ? get_the_date( 'Y' ) : ( is_month() ? get_the_date( 'F Y' ) : get_the_date() );
		$items[] = [ 'label' => $label, 'url' => '', 'type' => 'date' ];

	} elseif ( is_category() || is_tag() || is_tax() ) {

		$term = get_queried_object();
		if ( $term && ! is_wp_error( $term ) ) {

			// Parent terms chain
			if ( isset( $term->taxonomy ) && is_taxonomy_hierarchical( $term->taxonomy ) && ! empty( $term->parent ) ) {
				$parents = array_reverse( get_ancestors( (int) $term->term_id, $term->taxonomy ) );
				foreach ( $parents as $pid ) {
					$pterm = get_term( (int) $pid, $term->taxonomy );
					if ( $pterm && ! is_wp_error( $pterm ) ) {
						$items[] = [ 'label' => $pterm->name, 'url' => get_term_link( $pterm ), 'type' => 'term' ];
					}
				}
			}

			$items[] = [ 'label' => $term->name, 'url' => '', 'type' => 'term' ];
		}

	} elseif ( is_singular() ) {

		global $post;
		if ( $post ) {
			$post_type = get_post_type( $post );

			// Post type archive
			$pt_obj = $post_type ? get_post_type_object( $post_type ) : null;
			if ( $pt_obj && ! empty( $pt_obj->has_archive ) ) {
				$archive = get_post_type_archive_link( $post_type );
				if ( $archive ) {
					$items[] = [ 'label' => $pt_obj->labels->name, 'url' => $archive, 'type' => 'archive' ];
				}
			}

			// Posts: category chain (first category)
			if ( 'post' === $post_type ) {
				$cats = get_the_category( (int) $post->ID );
				if ( ! empty( $cats ) ) {
					$cat = $cats[0];

					if ( ! empty( $cat->parent ) ) {
						$parents = array_reverse( get_ancestors( (int) $cat->term_id, 'category' ) );
						foreach ( $parents as $pid ) {
							$pterm = get_term( (int) $pid, 'category' );
							if ( $pterm && ! is_wp_error( $pterm ) ) {
								$items[] = [ 'label' => $pterm->name, 'url' => get_term_link( $pterm ), 'type' => 'term' ];
							}
						}
					}

					$items[] = [ 'label' => $cat->name, 'url' => get_term_link( $cat ), 'type' => 'term' ];
				}
			}

			// Pages: parent chain
			if ( is_page() && ! empty( $post->post_parent ) ) {
				$parents = [];
				$pid     = (int) $post->post_parent;

				while ( $pid ) {
					$p = get_post( $pid );
					if ( ! $p ) { break; }

					$parents[] = [ 'label' => get_the_title( $p ), 'url' => get_permalink( $p ), 'type' => 'page' ];
					$pid = (int) $p->post_parent;
				}

				foreach ( array_reverse( $parents ) as $pitem ) {
					$items[] = $pitem;
				}
			}

			// Current item
			if ( $show_current ) {
				$type = is_page() ? 'page' : ( ( 'post' === $post_type ) ? 'post' : 'current' );
				$items[] = [ 'label' => get_the_title( $post ), 'url' => '', 'type' => $type ];
			}
		}

	} else {
		if ( $show_current ) {
			$items[] = [ 'label' => wp_get_document_title(), 'url' => '', 'type' => 'current' ];
		}
	}
}

if ( empty( $items ) ) {
	return;
}

/**
 * Auto icon mapping (smart defaults)
 * NOTE: Uses Elementor Icons format. These are safe defaults; user can override via Custom.
 */
$auto_icons = [
	'home'    => [ 'value' => 'fas fa-house', 'library' => 'fa-solid' ],
	'archive' => [ 'value' => 'fas fa-box-archive', 'library' => 'fa-solid' ],
	'term'    => [ 'value' => 'fas fa-tags', 'library' => 'fa-solid' ],
	'page'    => [ 'value' => 'fas fa-file-lines', 'library' => 'fa-solid' ],
	'post'    => [ 'value' => 'fas fa-newspaper', 'library' => 'fa-solid' ],
	'search'  => [ 'value' => 'fas fa-magnifying-glass', 'library' => 'fa-solid' ],
	'404'     => [ 'value' => 'fas fa-triangle-exclamation', 'library' => 'fa-solid' ],
	'author'  => [ 'value' => 'fas fa-user', 'library' => 'fa-solid' ],
	'date'    => [ 'value' => 'fas fa-calendar-days', 'library' => 'fa-solid' ],
	'current' => [ 'value' => 'fas fa-circle-dot', 'library' => 'fa-regular' ],
];

/**
 * Custom overrides from settings
 */
$custom_icons = [
	'home'    => $settings['icon_home'] ?? [],
	'archive' => $settings['icon_archive'] ?? [],
	'term'    => $settings['icon_term'] ?? [],
	'page'    => $settings['icon_page'] ?? [],
	'post'    => $settings['icon_post'] ?? [],
	'search'  => $settings['icon_search'] ?? [],
	'404'     => $settings['icon_404'] ?? [],
	'author'  => $settings['icon_author'] ?? [],
	'date'    => $settings['icon_date'] ?? [],
];

/**
 * Helper: decide which icon to render for item
 */
$get_item_icon = static function( string $type ) use ( $item_icon_source, $auto_icons, $custom_icons ): array {

	$type = $type ?: 'current';

	if ( 'custom' === $item_icon_source ) {
		$icon = $custom_icons[ $type ] ?? [];
		if ( is_array( $icon ) && isset( $icon['value'] ) && ( is_string( $icon['value'] ) ? trim( $icon['value'] ) !== '' : true ) ) {
			return $icon;
		}
		// fallback to auto if custom empty
	}

	return $auto_icons[ $type ] ?? ( $auto_icons['current'] ?? [] );
};

$wrapper_class = 'mentorai-bc mentorai-bc--preset-' . sanitize_key( $preset );
if ( empty( $settings['preset_surface'] ) || 'yes' !== $settings['preset_surface'] ) {
	$wrapper_class .= ' mentorai-bc--no-preset-surface';
}
// $wrapper_class = apply_filters( 'mentorai/breadcrumb/wrapper_class', $wrapper_class );
$wrapper_class .= $enable_item_icons ? ' mentorai-bc--has-item-icons' : '';
$wrapper_class .= ( 'after' === $item_icon_position ) ? ' mentorai-bc--icon-after' : ' mentorai-bc--icon-before';

echo '<nav class="' . esc_attr( $wrapper_class ) . '" aria-label="' . esc_attr__( 'Breadcrumb', 'mentorai' ) . '">';
echo '<ol class="mentorai-bc__list">';

$last_index = count( $items ) - 1;

foreach ( $items as $i => $item ) {

	$is_last = ( $i === $last_index );
	$label   = isset( $item['label'] ) ? (string) $item['label'] : '';
	$url     = isset( $item['url'] ) ? (string) $item['url'] : '';
	$type    = isset( $item['type'] ) ? (string) $item['type'] : 'current';

	// current item type normalization (last item)
	if ( $is_last ) {
		$type = 'current';
	}

	echo '<li class="mentorai-bc__item">';

	$icon_data = ( $enable_item_icons ) ? $get_item_icon( $type ) : [];

	$icon_html = '';
	if ( $enable_item_icons && is_array( $icon_data ) && isset( $icon_data['value'] ) ) {
		ob_start();
		echo '<span class="mentorai-bc__item-icon" aria-hidden="true">';
		Icons_Manager::render_icon(
			$icon_data,
			[
				'aria-hidden' => 'true',
			]
		);
		echo '</span>';
		$icon_html = (string) ob_get_clean();
	}

	$label_html = '<span class="mentorai-bc__label">' .
		( ( 'before' === $item_icon_position ) ? $icon_html : '' ) .
		'<span class="mentorai-bc__text">' . esc_html( $label ) . '</span>' .
		( ( 'after' === $item_icon_position ) ? $icon_html : '' ) .
	'</span>';

	if ( $url && ! $is_last ) {
		echo '<a class="mentorai-bc__link" href="' . esc_url( $url ) . '">' . $label_html . '</a>';
	} else {
		$cls = $is_last ? 'mentorai-bc__current' : 'mentorai-bc__nolink';
		echo '<span class="' . esc_attr( $cls ) . '">' . $label_html . '</span>';
	}

	echo '</li>';

	// Separator (only between items)
	if ( ! $is_last ) {

		echo '<li class="mentorai-bc__sep" aria-hidden="true">';

		$has_sep_icon = false;

		if ( 'icon' === $separator_type && is_array( $separator_icon ) && isset( $separator_icon['value'] ) ) {
			if ( ( is_string( $separator_icon['value'] ) && '' !== trim( $separator_icon['value'] ) ) || is_array( $separator_icon['value'] ) ) {
				$has_sep_icon = true;
			}
		}

		if ( 'icon' === $separator_type && $has_sep_icon ) {
			Icons_Manager::render_icon(
				$separator_icon,
				[
					'aria-hidden' => 'true',
					'class'       => 'mentorai-bc__sep-icon',
				]
			);
		} else {
			echo esc_html( $separator_text );
		}

		echo '</li>';
	}
}

echo '</ol>';
echo '</nav>';
