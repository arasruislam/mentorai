<?php
namespace Mentorai\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Widgets_Settings {

	public const OPTION_KEY = 'mentorai_enabled_widgets';

	/**
	 * Default = all enabled (first install)
	 */
	public static function get_enabled(): array {

		$enabled = get_option( self::OPTION_KEY, null );

		// First run: enable all
		if ( ! is_array( $enabled ) ) {
			return array_keys( Widgets_Registry::all() );
		}

		$enabled = array_map( 'sanitize_key', $enabled );
		return array_values( array_unique( $enabled ) );
	}

	public static function is_enabled( string $slug ): bool {
		return in_array( $slug, self::get_enabled(), true );
	}

	public static function save_enabled( array $slugs ): void {

		$slugs = array_map( 'sanitize_key', $slugs );

		// Only allow known slugs
		$known = array_keys( Widgets_Registry::all() );
		$slugs = array_values( array_intersect( $slugs, $known ) );

		update_option( self::OPTION_KEY, $slugs, false );
	}
}
