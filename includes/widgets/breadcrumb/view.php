<?php
/**
 * @var array $settings
 */
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) { exit; }

$preset         = isset( $settings['preset'] ) ? (string) $settings['preset'] : 'minimal';
$show_home       = ( isset( $settings['show_home'] ) && 'yes' === $settings['show_home'] );
$home_label      = isset( $settings['home_label'] ) ? (string) $settings['home_label'] : __( 'Home', 'mentorai' );
$show_current    = ( isset( $settings['show_current'] ) && 'yes' === $settings['show_current'] );
$separator_type  = isset( $settings['separator_type'] ) ? (string) $settings['separator_type'] : 'icon';
$separator_text  = isset( $settings['separator_text'] ) ? (string) $settings['separator_text'] : '/';
$separator_icon  = isset( $settings['separator_icon'] ) ? $settings['separator_icon'] : [];

$items = [];

if ( is_front_page() ) {
	if ( $show_home ) {
		$items[] = [ 'label' => $home_label, 'url' => '' ];
	}
} else {

	if ( $show_home ) {
		$items[] = [ 'label' => $home_label, 'url' => home_url( '/' ) ];
	}

	if ( is_home() ) {
		$title = get_the_title( (int) get_option( 'page_for_posts' ) );
		$items[] = [ 'label' => $title ? $title : __( 'Blog', 'mentorai' ), 'url' => '' ];

	} elseif ( is_search() ) {
		$items[] = [ 'label' => sprintf( __( 'Search: %s', 'mentorai' ), get_search_query() ), 'url' => '' ];

	} elseif ( is_404() ) {
		$items[] = [ 'label' => __( '404 Not Found', 'mentorai' ), 'url' => '' ];

	} elseif ( is_author() ) {
		$items[] = [ 'label' => get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) ), 'url' => '' ];

	} elseif ( is_date() ) {
		if ( is_year() ) {
			$items[] = [ 'label' => get_the_date( 'Y' ), 'url' => '' ];
		} elseif ( is_month() ) {
			$items[] = [ 'label' => get_the_date( 'F Y' ), 'url' => '' ];
		} else {
			$items[] = [ 'label' => get_the_date(), 'url' => '' ];
		}

	} elseif ( is_category() || is_tag() || is_tax() ) {

		$term = get_queried_object();
		if ( $term && ! is_wp_error( $term ) ) {

			if ( isset( $term->taxonomy ) && is_taxonomy_hierarchical( $term->taxonomy ) && ! empty( $term->parent ) ) {
				$parents = array_reverse( get_ancestors( (int) $term->term_id, $term->taxonomy ) );
				foreach ( $parents as $pid ) {
					$pterm = get_term( (int) $pid, $term->taxonomy );
					if ( $pterm && ! is_wp_error( $pterm ) ) {
						$items[] = [ 'label' => $pterm->name, 'url' => get_term_link( $pterm ) ];
					}
				}
			}

			$items[] = [ 'label' => $term->name, 'url' => '' ];
		}

	} elseif ( is_singular() ) {

		global $post;
		if ( $post ) {

			$post_type = get_post_type( $post );
			$pt_obj    = $post_type ? get_post_type_object( $post_type ) : null;

			if ( $pt_obj && ! empty( $pt_obj->has_archive ) ) {
				$archive = get_post_type_archive_link( $post_type );
				if ( $archive ) {
					$items[] = [ 'label' => $pt_obj->labels->name, 'url' => $archive ];
				}
			}

			if ( 'post' === $post_type ) {
				$cats = get_the_category( (int) $post->ID );
				if ( ! empty( $cats ) ) {
					$cat = $cats[0];

					if ( ! empty( $cat->parent ) ) {
						$parents = array_reverse( get_ancestors( (int) $cat->term_id, 'category' ) );
						foreach ( $parents as $pid ) {
							$pterm = get_term( (int) $pid, 'category' );
							if ( $pterm && ! is_wp_error( $pterm ) ) {
								$items[] = [ 'label' => $pterm->name, 'url' => get_term_link( $pterm ) ];
							}
						}
					}

					$items[] = [ 'label' => $cat->name, 'url' => get_term_link( $cat ) ];
				}
			}

			if ( is_page() && ! empty( $post->post_parent ) ) {
				$parents = [];
				$pid = (int) $post->post_parent;

				while ( $pid ) {
					$p = get_post( $pid );
					if ( ! $p ) { break; }
					$parents[] = [ 'label' => get_the_title( $p ), 'url' => get_permalink( $p ) ];
					$pid = (int) $p->post_parent;
				}

				$parents = array_reverse( $parents );
				foreach ( $parents as $pitem ) {
					$items[] = $pitem;
				}
			}

			if ( $show_current ) {
				$items[] = [ 'label' => get_the_title( $post ), 'url' => '' ];
			}
		}

	} else {
		if ( $show_current ) {
			$items[] = [ 'label' => wp_get_document_title(), 'url' => '' ];
		}
	}
}

if ( empty( $items ) ) {
	return;
}

$wrapper_class = 'mentorai-bc mentorai-bc--preset-' . preg_replace( '/[^a-z0-9\-]/', '', strtolower( $preset ) );

echo '<nav class="' . esc_attr( $wrapper_class ) . '" aria-label="' . esc_attr__( 'Breadcrumb', 'mentorai' ) . '">';
echo '<ol class="mentorai-bc__list">';

$last_index = count( $items ) - 1;

foreach ( $items as $i => $item ) {

	$is_last = ( $i === $last_index );
	$label   = isset( $item['label'] ) ? (string) $item['label'] : '';
	$url     = isset( $item['url'] ) ? (string) $item['url'] : '';

	echo '<li class="mentorai-bc__item">';

	if ( $url && ! $is_last ) {
		echo '<a class="mentorai-bc__link" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
	} else {
		$cls = $is_last ? 'mentorai-bc__current' : 'mentorai-bc__nolink';
		echo '<span class="' . esc_attr( $cls ) . '">' . esc_html( $label ) . '</span>';
	}

	echo '</li>';

	// Separator ONLY between items
	if ( ! $is_last ) {

		echo '<li class="mentorai-bc__sep" aria-hidden="true">';

		if ( 'icon' === $separator_type ) {

			$icon = ( is_array( $separator_icon ) ) ? $separator_icon : [];

			// default fallback icon
			if ( ! isset( $icon['value'] ) || ( is_string( $icon['value'] ) && '' === trim( $icon['value'] ) ) ) {
				$icon = [
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				];
			}

			// ✅ our own wrapper ensures sizing works
			echo '<span class="mentorai-bc__sep-icon" aria-hidden="true">';
			Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
			echo '</span>';

		} else {
			$sep = ( '' !== trim( $separator_text ) ) ? $separator_text : '/';
			echo '<span class="mentorai-bc__sep-text">' . esc_html( $sep ) . '</span>';
		}

		echo '</li>';
	}
}

echo '</ol>';
echo '</nav>';
