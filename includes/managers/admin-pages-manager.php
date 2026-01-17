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
			// IMPORTANT: use a small menu icon (20/24px)
			MENTORAI_URL . 'assets/img/mentorai-logo.png',
			58
		);

		// Submenus
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

	/**
	 * DASHBOARD
	 * - Top stats cards
	 * - Quick actions
	 * - Widgets list (enabled/disabled)
	 */
	private function render_dashboard(): void {

		$all_widgets     = Widgets_Registry::all();
		$enabled_widgets = Widgets_Settings::get_enabled();

		$total_count   = count( $all_widgets );
		$enabled_count = 0;

		foreach ( array_keys( $all_widgets ) as $slug ) {
			if ( in_array( $slug, $enabled_widgets, true ) ) {
				$enabled_count++;
			}
		}

		$version = defined( 'MENTORAI_VERSION' ) ? MENTORAI_VERSION : '—';
		$status  = ( did_action( 'elementor/loaded' ) ) ? __( 'Elementor Connected', 'mentorai' ) : __( 'Elementor Missing', 'mentorai' );

		echo '<div class="mentorai-grid">';
		echo $this->card( __( 'Widgets Enabled', 'mentorai' ), (string) $enabled_count . ' / ' . (string) $total_count );
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

		// Widgets list panel
		echo '<div class="mentorai-section">';
		echo '<h2 class="mentorai-h2">' . esc_html__( 'Widgets', 'mentorai' ) . '</h2>';
		echo '<div class="mentorai-panel">';

		if ( empty( $all_widgets ) ) {
			echo '<p class="mentorai-muted">' . esc_html__( 'No widgets registered yet.', 'mentorai' ) . '</p>';
		} else {
			echo '<table class="widefat striped">';
			echo '<thead><tr>';
			echo '<th style="width:120px;">' . esc_html__( 'Status', 'mentorai' ) . '</th>';
			echo '<th>' . esc_html__( 'Widget', 'mentorai' ) . '</th>';
			echo '<th>' . esc_html__( 'Slug', 'mentorai' ) . '</th>';
			echo '</tr></thead><tbody>';

			foreach ( $all_widgets as $slug => $meta ) {
				$is_on = in_array( $slug, $enabled_widgets, true );

				echo '<tr>';
				echo '<td>' . ( $is_on
					? '<span class="mentorai-badge" style="background:#eaf7ef;color:#1d6f2b;border:1px solid #bfe7c9;">' . esc_html__( 'Enabled', 'mentorai' ) . '</span>'
					: '<span class="mentorai-badge" style="background:#fdecec;color:#9a1b1b;border:1px solid #f3b7b7;">' . esc_html__( 'Disabled', 'mentorai' ) . '</span>'
				) . '</td>';

				echo '<td><strong>' . esc_html( $meta['title'] ?? $slug ) . '</strong></td>';
				echo '<td><code>' . esc_html( $slug ) . '</code></td>';
				echo '</tr>';
			}

			echo '</tbody></table>';
			echo '<p class="mentorai-muted" style="margin-top:12px;">' .
				esc_html__( 'Enable/disable widgets from Settings → Widgets.', 'mentorai' ) .
			'</p>';
		}

		echo '</div>'; // panel
		echo '</div>'; // section

		$this->handle_actions();
	}

	/**
	 * SETTINGS
	 * - Widgets enable/disable toggles
	 */
	private function render_settings(): void {

		// Save
		if ( isset( $_POST['mentorai_save_widgets'] ) ) {
			check_admin_referer( 'mentorai_widgets_settings' );

			$enabled = isset( $_POST['mentorai_widgets_enabled'] ) && is_array( $_POST['mentorai_widgets_enabled'] )
				? (array) $_POST['mentorai_widgets_enabled']
				: [];

			Widgets_Settings::save_enabled( $enabled );

			echo '<div class="notice notice-success is-dismissible"><p>' .
				esc_html__( 'Settings saved.', 'mentorai' ) .
			'</p></div>';
		}

		$all_widgets     = Widgets_Registry::all();
		$enabled_widgets = Widgets_Settings::get_enabled();

		echo '<div class="mentorai-section">';
		echo '<h2 class="mentorai-h2">' . esc_html__( 'Settings', 'mentorai' ) . '</h2>';
		echo '<div class="mentorai-panel">';

		echo '<h3 style="margin-top:0;">' . esc_html__( 'Widgets', 'mentorai' ) . '</h3>';
		echo '<p class="mentorai-muted">' . esc_html__( 'Turn widgets on/off. Disabled widgets will not appear in Elementor.', 'mentorai' ) . '</p>';

		echo '<form method="post">';
		wp_nonce_field( 'mentorai_widgets_settings' );

		echo '<table class="widefat striped">';
		echo '<thead><tr>';
		echo '<th style="width:90px;">' . esc_html__( 'Enabled', 'mentorai' ) . '</th>';
		echo '<th>' . esc_html__( 'Widget', 'mentorai' ) . '</th>';
		echo '<th>' . esc_html__( 'Description', 'mentorai' ) . '</th>';
		echo '</tr></thead><tbody>';

		foreach ( $all_widgets as $slug => $meta ) {
			$is_on = in_array( $slug, $enabled_widgets, true );

			echo '<tr>';
			echo '<td>';
			printf(
				'<label style="display:inline-flex;align-items:center;gap:8px;">
					<input type="checkbox" name="mentorai_widgets_enabled[]" value="%s" %s />
					<span>%s</span>
				</label>',
				esc_attr( $slug ),
				checked( $is_on, true, false ),
				$is_on ? esc_html__( 'On', 'mentorai' ) : esc_html__( 'Off', 'mentorai' )
			);
			echo '</td>';

			echo '<td><strong>' . esc_html( $meta['title'] ?? $slug ) . '</strong><br/><code>' . esc_html( $slug ) . '</code></td>';
			echo '<td>' . esc_html( $meta['description'] ?? '' ) . '</td>';
			echo '</tr>';
		}

		echo '</tbody></table>';

		echo '<p style="margin-top:14px;">';
		echo '<button type="submit" name="mentorai_save_widgets" class="button button-primary">' .
			esc_html__( 'Save Changes', 'mentorai' ) .
		'</button>';
		echo '</p>';

		echo '</form>';

		echo '<p class="mentorai-note">' .
			esc_html__( 'After disabling a widget, reload Elementor editor to see changes.', 'mentorai' ) .
		'</p>';

		echo '</div>'; // panel
		echo '</div>'; // section
	}

	private function render_licences(): void {
		echo '<div class="mentorai-section">';
		echo '<h2 class="mentorai-h2">' . esc_html__( 'Licences', 'mentorai' ) . '</h2>';
		echo '<div class="mentorai-panel">';
		echo '<p class="mentorai-muted">' . esc_html__( 'Licences UI placeholder. Next: key input + activation status.', 'mentorai' ) . '</p>';
		echo '</div>';
		echo '</div>';
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
