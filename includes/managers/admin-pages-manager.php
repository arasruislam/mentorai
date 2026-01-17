<?php
namespace Mentorai\Managers;

if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Admin_Pages_Manager {

	private const PAGE_SLUG = 'mentorai-dashboard';

	public function init(): void {
		add_action( 'admin_menu', [ $this, 'register_pages' ] );
	}

	public function register_pages(): void {
		$cap = 'manage_options';

		// Top-level menu
		add_menu_page(
			__( 'Mentorai', 'mentorai' ),
			__( 'Mentorai', 'mentorai' ),
			$cap,
			self::PAGE_SLUG,
			[ $this, 'render_router' ],
			'dashicons-lightbulb',
			58
		);

		// Submenus (optional but requested)
		add_submenu_page(
			self::PAGE_SLUG,
			__( 'Dashboard', 'mentorai' ),
			__( 'Dashboard', 'mentorai' ),
			$cap,
			self::PAGE_SLUG,
			[ $this, 'render_router' ]
		);

		add_submenu_page(
			self::PAGE_SLUG,
			__( 'Settings', 'mentorai' ),
			__( 'Settings', 'mentorai' ),
			$cap,
			self::PAGE_SLUG . '&tab=settings',
			[ $this, 'render_router' ]
		);

		add_submenu_page(
			self::PAGE_SLUG,
			__( 'Licences', 'mentorai' ),
			__( 'Licences', 'mentorai' ),
			$cap,
			self::PAGE_SLUG . '&tab=licences',
			[ $this, 'render_router' ]
		);
	}

	public function render_router(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'mentorai' ) );
		}

		$tab = isset( $_GET['tab'] ) ? sanitize_key( (string) $_GET['tab'] ) : 'dashboard'; // phpcs:ignore

		$tabs = [
			'dashboard' => __( 'Dashboard', 'mentorai' ),
			'settings'  => __( 'Settings', 'mentorai' ),
			'licences'  => __( 'Licences', 'mentorai' ),
		];

		if ( ! isset( $tabs[ $tab ] ) ) {
			$tab = 'dashboard';
		}

		echo '<div class="wrap mentorai-admin">';

		// Hero
		echo '<div class="mentorai-hero">';
		echo '<div class="mentorai-hero__left">';
		echo '<h1>' . esc_html__( 'Mentorai', 'mentorai' ) . '</h1>';
		echo '<p class="mentorai-hero__sub">' . esc_html__( 'Admin panel for widgets, settings and licences (demo UI).', 'mentorai' ) . '</p>';
		echo '</div>';

		$status_badge = ( did_action( 'elementor/loaded' ) ) ? __( 'Status: Active', 'mentorai' ) : __( 'Status: Elementor Missing', 'mentorai' );
		echo '<div class="mentorai-hero__right">';
		echo '<span class="mentorai-badge">' . esc_html( $status_badge ) . '</span>';
		echo '</div>';
		echo '</div>';

		// Tabs
		echo '<h2 class="nav-tab-wrapper mentorai-tabs">';
		foreach ( $tabs as $key => $label ) {
			$url   = $this->tab_url( $key );
			$class = ( $key === $tab ) ? 'nav-tab nav-tab-active' : 'nav-tab';
			echo '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
		}
		echo '</h2>';

		// Content
		if ( 'settings' === $tab ) {
			$this->render_settings();
		} elseif ( 'licences' === $tab ) {
			$this->render_licences();
		} else {
			$this->render_dashboard();
		}

		echo '</div>';
	}

	private function render_dashboard(): void {
		$widgets_count = $this->get_mentorai_widgets_count();
		$version       = defined( 'MENTORAI_VERSION' ) ? MENTORAI_VERSION : '—';
		$status        = ( did_action( 'elementor/loaded' ) ) ? __( 'Elementor Connected', 'mentorai' ) : __( 'Elementor Missing', 'mentorai' );

		echo '<div class="mentorai-grid">';
		echo $this->card( __( 'Widgets Count', 'mentorai' ), (string) $widgets_count );
		echo $this->card( __( 'Mentorai Version', 'mentorai' ), (string) $version );
		echo $this->card( __( 'System Status', 'mentorai' ), (string) $status );
		echo '</div>';

		echo '<div class="mentorai-section">';
		echo '<h2 class="mentorai-h2">' . esc_html__( 'Quick Actions', 'mentorai' ) . '</h2>';
		echo '<div class="mentorai-actions">';
		echo '<a class="mentorai-btn" href="' . esc_url( $this->action_url( 'scaffold' ) ) . '">' . esc_html__( 'Create Widget Scaffold (Demo)', 'mentorai' ) . '</a>';
		echo '<a class="mentorai-btn mentorai-btn--ghost" target="_blank" rel="noopener" href="' . esc_url( $this->docs_url() ) . '">' . esc_html__( 'Docs', 'mentorai' ) . '</a>';
		echo '<a class="mentorai-btn mentorai-btn--ghost" target="_blank" rel="noopener" href="' . esc_url( $this->support_url() ) . '">' . esc_html__( 'Support', 'mentorai' ) . '</a>';
		echo '</div>';
		echo '<p class="mentorai-note">' . esc_html__( 'Next: implement real scaffold generation using WP_Filesystem.', 'mentorai' ) . '</p>';
		echo '</div>';

		$this->handle_actions();
	}

	private function render_settings(): void {
		echo '<div class="mentorai-section">';
		echo '<h2 class="mentorai-h2">' . esc_html__( 'Settings', 'mentorai' ) . '</h2>';
		echo '<div class="mentorai-panel">';
		echo '<p class="mentorai-muted">' . esc_html__( 'Settings UI placeholder. Next: Settings API fields (toggles, defaults).', 'mentorai' ) . '</p>';
		echo '</div>';
		echo '</div>';
	}

	private function render_licences(): void {
		echo '<div class="mentorai-section">';
		echo '<h2 class="mentorai-h2">' . esc_html__( 'Licences', 'mentorai' ) . '</h2>';
		echo '<div class="mentorai-panel">';
		echo '<p class="mentorai-muted">' . esc_html__( 'Licences UI placeholder. Next: key input + activation status.', 'mentorai' ) . '</p>';
		echo '</div>';
		echo '</div>';
	}

	private function get_mentorai_widgets_count(): int {
		if ( ! did_action( 'elementor/loaded' ) || ! class_exists( '\\Elementor\\Plugin' ) ) {
			return 0;
		}

		try {
			$manager = \Elementor\Plugin::instance()->widgets_manager;

			if ( method_exists( $manager, 'get_widget_types' ) ) {
				$all   = $manager->get_widget_types();
				$count = 0;

				foreach ( $all as $w ) {
					if ( method_exists( $w, 'get_name' ) ) {
						$name = (string) $w->get_name();
						if ( 0 === strpos( $name, 'mentorai-' ) ) {
							$count++;
						}
					}
				}

				return $count;
			}
		} catch ( \Throwable $e ) {
			return 0;
		}

		return 0;
	}

	private function card( string $label, string $value ): string {
		return
			'<div class="mentorai-card">' .
				'<div class="mentorai-card__label">' . esc_html( $label ) . '</div>' .
				'<div class="mentorai-card__value">' . esc_html( $value ) . '</div>' .
			'</div>';
	}

	private function tab_url( string $tab ): string {
		return add_query_arg(
			[
				'page' => self::PAGE_SLUG,
				'tab'  => $tab,
			],
			admin_url( 'admin.php' )
		);
	}

	private function action_url( string $action ): string {
		$base = $this->tab_url( 'dashboard' );

		return wp_nonce_url(
			add_query_arg( [ 'mentorai_action' => $action ], $base ),
			'mentorai_action_' . $action
		);
	}

	private function handle_actions(): void {
		if ( ! isset( $_GET['mentorai_action'] ) ) { // phpcs:ignore
			return;
		}

		$action = sanitize_key( (string) $_GET['mentorai_action'] ); // phpcs:ignore
		check_admin_referer( 'mentorai_action_' . $action );

		if ( 'scaffold' === $action ) {
			echo '<div class="notice notice-success is-dismissible"><p><strong>' .
				esc_html__( 'Demo: Widget scaffold action triggered.', 'mentorai' ) .
			'</strong></p></div>';
		}
	}

	private function docs_url(): string {
		return 'https://example.com/mentorai-docs';
	}

	private function support_url(): string {
		return 'https://example.com/mentorai-support';
	}
}
