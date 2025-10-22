<?php
declare(strict_types=1);

if ( ! defined( 'AURIEL_VITE_DIST_DIR' ) ) {
	define( 'AURIEL_VITE_DIST_DIR', 'assets/dist' );
}

if ( ! defined( 'AURIEL_VITE_DIST_URI' ) ) {
	define(
		'AURIEL_VITE_DIST_URI',
		trailingslashit( get_template_directory_uri() ) . AURIEL_VITE_DIST_DIR
	);
}

if ( ! defined( 'AURIEL_VITE_DIST_PATH' ) ) {
	define(
		'AURIEL_VITE_DIST_PATH',
		trailingslashit( get_template_directory() ) . AURIEL_VITE_DIST_DIR
	);
}

if ( ! defined( 'AURIEL_VITE_SERVER' ) ) {
	define( 'AURIEL_VITE_SERVER', 'http://localhost:5173' );
}

if ( ! defined( 'AURIEL_VITE_SCRIPT_HANDLE' ) ) {
	define( 'AURIEL_VITE_SCRIPT_HANDLE', 'auriel-main' );
}

if ( ! defined( 'AURIEL_VITE_STYLE_HANDLE' ) ) {
	define( 'AURIEL_VITE_STYLE_HANDLE', 'auriel-main-style' );
}

/**
 * Determine the current Vite mode.
 */
function auriel_vite_get_mode(): string {
	static $mode = null;

	if ( null !== $mode ) {
		return $mode;
	}

	// Respect explicit constant overrides first.
	if ( defined( 'AURIEL_VITE_MODE' ) ) {
		$candidate = strtolower( (string) AURIEL_VITE_MODE );
		if ( in_array( $candidate, array( 'dev', 'build' ), true ) ) {
			$mode = $candidate;

			return $mode;
		}
	}

	// Allow env.php configuration (theme root).
	$env_path = trailingslashit( get_template_directory() ) . 'env.php';
	if ( file_exists( $env_path ) ) {
		$env = include $env_path;
		if ( is_array( $env ) && isset( $env['vite_mode'] ) ) {
			$candidate = strtolower( (string) $env['vite_mode'] );
			if ( in_array( $candidate, array( 'dev', 'build' ), true ) ) {
				$mode = $candidate;

				return $mode;
			}
		}
	}

	// Fallback to manifest detection.
	$mode = file_exists( AURIEL_VITE_DIST_PATH . '/.vite/manifest.json' ) ? 'build' : 'dev';

	return $mode;
}

/**
 * Determine whether we should load built assets.
 */
function auriel_vite_is_build(): bool {
	return 'build' === auriel_vite_get_mode();
}

/**
 * Load and cache the Vite manifest.
 *
 * @return array<string,array<string,mixed>>
 */
function auriel_vite_get_manifest(): array {
	static $manifest = null;

	if ( null !== $manifest ) {
		return $manifest;
	}

	$manifest = array();

	$manifest_path = AURIEL_VITE_DIST_PATH . '/.vite/manifest.json';
	if ( file_exists( $manifest_path ) ) {
		$decoded = json_decode( file_get_contents( $manifest_path ), true );
		if ( is_array( $decoded ) ) {
			$manifest = $decoded;
		}
	}

	return $manifest;
}

/**
 * Locate an entry inside the Vite manifest regardless of its key format.
 *
 * @param string $source Original source path (e.g. assets/src/js/main.js).
 *
 * @return array<string,mixed>
 */
function auriel_vite_find_manifest_entry( string $source ): array {
	$manifest          = auriel_vite_get_manifest();
	$normalized_source = ltrim( $source, './' );

	foreach ( $manifest as $key => $entry ) {
		$entry_src = isset( $entry['src'] ) ? ltrim( (string) $entry['src'], './' ) : '';

		if ( $entry_src === $normalized_source ) {
			return $entry;
		}

		if ( ltrim( (string) $key, './' ) === $normalized_source ) {
			return $entry;
		}
	}

	return array();
}

/**
 * Resolve a built asset URI via the manifest.
 */
function auriel_vite_resolve_asset_uri( string $source ): string {
	$entry = auriel_vite_find_manifest_entry( $source );

	if ( ! empty( $entry['file'] ) ) {
		return AURIEL_VITE_DIST_URI . '/' . ltrim( (string) $entry['file'], '/' );
	}

	return '';
}

/**
 * Resolve additional CSS files emitted by a manifest entry.
 *
 * @param string $source Original entry path.
 *
 * @return array<int,string> URIs to enqueue.
 */
function auriel_vite_resolve_css_dependencies( string $source ): array {
	$entry = auriel_vite_find_manifest_entry( $source );

	if ( empty( $entry['css'] ) || ! is_array( $entry['css'] ) ) {
		return array();
	}

	return array_map(
		static function ( $css_file ): string {
			return AURIEL_VITE_DIST_URI . '/' . ltrim( (string) $css_file, '/' );
		},
		$entry['css']
	);
}

/**
 * Register and enqueue the Vite-powered assets.
 */
function auriel_enqueue_vite_assets(): void {
	$js_entries    = array(
		AURIEL_VITE_SCRIPT_HANDLE => 'assets/src/js/main.js',
	);
	$style_entries = array(
		AURIEL_VITE_STYLE_HANDLE => 'assets/src/scss/main.scss',
	);

	foreach ( $js_entries as $handle => $source ) {
		$dev_uri = sprintf( '%s/%s', AURIEL_VITE_SERVER, $source );
		$uri     = $dev_uri;
		$deps    = array();

		if ( auriel_vite_is_build() ) {
			$resolved = auriel_vite_resolve_asset_uri( $source );
			if ( '' !== $resolved ) {
				$uri = $resolved;
			}

			$css_dependencies = auriel_vite_resolve_css_dependencies( $source );
			if ( ! empty( $css_dependencies ) ) {
				foreach ( $css_dependencies as $index => $css_uri ) {
					$css_handle = sprintf( '%s-chunk-%d', $handle, (int) $index );
					wp_enqueue_style(
						$css_handle,
						$css_uri,
						array(),
						null
					);
					$deps[] = $css_handle;
				}
			}
		}

		wp_enqueue_script( $handle, $uri, $deps, null, true );
	}

	foreach ( $style_entries as $handle => $source ) {
		$dev_uri = sprintf( '%s/%s', AURIEL_VITE_SERVER, $source );
		$uri     = $dev_uri;

		if ( auriel_vite_is_build() ) {
			$resolved = auriel_vite_resolve_asset_uri( $source );
			if ( '' !== $resolved ) {
				$uri = $resolved;
			}
		}

		wp_enqueue_style( $handle, $uri, array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'auriel_enqueue_vite_assets', 100 );

/**
 * Inject the Vite client while running in development mode.
 */
function auriel_vite_client_script(): void {
	if ( auriel_vite_is_build() ) {
		return;
	}

	printf(
		'<script type="module" crossorigin src="%s/@vite/client"></script>' . PHP_EOL,
		esc_url( AURIEL_VITE_SERVER )
	);
}
add_action( 'wp_head', 'auriel_vite_client_script' );

/**
 * Ensure Vite scripts are treated as ES modules during development.
 */
function auriel_vite_module_tag( string $tag, string $handle, string $src ): string {
	if ( AURIEL_VITE_SCRIPT_HANDLE !== $handle ) {
		return $tag;
	}

	$attributes = array(
		'type="module"',
		sprintf( 'src="%s"', esc_url( $src ) ),
	);

	if ( ! auriel_vite_is_build() ) {
		$attributes[] = 'crossorigin="anonymous"';
	}

	return sprintf( '<script %s></script>', implode( ' ', $attributes ) );
}

add_filter( 'script_loader_tag', 'auriel_vite_module_tag', 10, 3 );
