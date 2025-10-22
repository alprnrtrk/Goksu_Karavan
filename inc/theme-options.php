<?php
declare(strict_types=1);

const AURIEL_THEME_OPTION_KEY = 'auriel_theme_design_tokens';

/**
 * Default design token values.
 *
 * @return array<string,string>
 */
function auriel_theme_design_token_defaults(): array {
	return array(
		'primary_color'   => '#3b82f6',
		'secondary_color' => '#f59e0b',
		'accent_color'    => '#10b981',
		'surface_color'   => '#ffffff',
		'text_color'      => '#0f172a',
	);
}

/**
 * Retrieve the theme design tokens with defaults applied.
 *
 * @return array<string,string>
 */
function auriel_theme_get_design_tokens(): array {
	$tokens = get_option( AURIEL_THEME_OPTION_KEY, array() );

	if ( ! is_array( $tokens ) ) {
		$tokens = array();
	}

	return wp_parse_args( $tokens, auriel_theme_design_token_defaults() );
}

/**
 * Fetch a single token value.
 *
 * @param string $key Token key.
 * @param string $default Default value.
 *
 * @return string
 */
function auriel_theme_get_design_token( string $key, string $default = '' ): string {
	$tokens = auriel_theme_get_design_tokens();

	return $tokens[ $key ] ?? $default;
}

/**
 * Convert a hex colour string into an RGB string with space separation (for tailwind alpha support).
 *
 * @param string $hex Hex colour value.
 *
 * @return string
 */
function auriel_theme_hex_to_rgb( string $hex ): string {
	$hex      = ltrim( $hex, '#' );
	$hex_len  = strlen( $hex );
	$segments = array();

	if ( 3 === $hex_len ) {
		$segments = array_map(
			static fn( string $char ): int => hexdec( str_repeat( $char, 2 ) ),
			str_split( $hex )
		);
	} elseif ( 6 === $hex_len ) {
		$segments = array_map(
			static fn( string $pair ): int => hexdec( $pair ),
			str_split( $hex, 2 )
		);
	} else {
		return '0 0 0';
	}

	return implode( ' ', $segments );
}

/**
 * Sanitize saved token values.
 *
 * @param mixed $input Raw option input.
 *
 * @return array<string,string>
 */
function auriel_theme_sanitize_design_tokens( $input ): array {
	$defaults = auriel_theme_design_token_defaults();
	$tokens   = array();

	if ( ! is_array( $input ) ) {
		$input = array();
	}

	foreach ( $defaults as $key => $default ) {
		$value = $input[ $key ] ?? $default;
		$value = sanitize_text_field( (string) $value );

		if ( ! preg_match( '/^#([0-9a-fA-F]{3}){1,2}$/', $value ) ) {
			$value = $default;
		}

		$tokens[ $key ] = $value;
	}

	return $tokens;
}

/**
 * Register theme settings page and fields.
 */
function auriel_theme_register_settings(): void {
	register_setting(
		'auriel_theme_settings',
		AURIEL_THEME_OPTION_KEY,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'auriel_theme_sanitize_design_tokens',
			'default'           => auriel_theme_design_token_defaults(),
		)
	);

	add_settings_section(
		'auriel_theme_design_tokens_section',
		__( 'Design Tokens', AURIEL_THEME_TEXT_DOMAIN ),
		static function (): void {
			echo '<p>' . esc_html__( 'Adjust the global colour palette used across the theme. Values are exposed to Tailwind via CSS variables.', AURIEL_THEME_TEXT_DOMAIN ) . '</p>';
		},
		AURIEL_THEME_SETTINGS_PAGE_SLUG
	);

	$fields = array(
		'primary_color'   => __( 'Primary colour', AURIEL_THEME_TEXT_DOMAIN ),
		'secondary_color' => __( 'Secondary colour', AURIEL_THEME_TEXT_DOMAIN ),
		'accent_color'    => __( 'Accent colour', AURIEL_THEME_TEXT_DOMAIN ),
		'surface_color'   => __( 'Surface colour', AURIEL_THEME_TEXT_DOMAIN ),
		'text_color'      => __( 'Text colour', AURIEL_THEME_TEXT_DOMAIN ),
	);

	foreach ( $fields as $key => $label ) {
		add_settings_field(
			$key,
			$label,
			'auriel_theme_render_colour_field',
			AURIEL_THEME_SETTINGS_PAGE_SLUG,
			'auriel_theme_design_tokens_section',
			array( 'key' => $key )
		);
	}
}
add_action( 'admin_init', 'auriel_theme_register_settings' );

/**
 * Render a colour field for the settings page.
 *
 * @param array<string,string> $args Field arguments.
 */
function auriel_theme_render_colour_field( array $args ): void {
	$key   = $args['key'] ?? '';
	$value = auriel_theme_get_design_token( $key, auriel_theme_design_token_defaults()[ $key ] ?? '' );

	printf(
		'<input type="color" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="auriel-color-field" />',
		esc_attr( $key ),
		esc_attr( AURIEL_THEME_OPTION_KEY ),
		esc_attr( $value )
	);
}

/**
 * Register the settings page in the admin menu.
 */
function auriel_theme_register_settings_page(): void {
	add_theme_page(
		__( 'Auriel Theme Settings', AURIEL_THEME_TEXT_DOMAIN ),
		__( 'Auriel Theme', AURIEL_THEME_TEXT_DOMAIN ),
		'manage_options',
		AURIEL_THEME_SETTINGS_PAGE_SLUG,
		'auriel_theme_render_settings_page'
	);
}
add_action( 'admin_menu', 'auriel_theme_register_settings_page' );

/**
 * Render the theme settings page.
 */
function auriel_theme_render_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Auriel Theme Settings', AURIEL_THEME_TEXT_DOMAIN ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'auriel_theme_settings' );
			do_settings_sections( AURIEL_THEME_SETTINGS_PAGE_SLUG );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Output CSS custom properties linking the saved colours to Tailwind.
 */
function auriel_theme_output_design_tokens(): void {
	$tokens = auriel_theme_get_design_tokens();

	$css_fragments = array();

	foreach ( $tokens as $key => $value ) {
		$slug = str_replace( '_color', '', $key );
		$css_fragments[] = sprintf( '--auriel-color-%1$s: %2$s;', esc_attr( $slug ), esc_attr( $value ) );
		$css_fragments[] = sprintf( '--auriel-color-%1$s-rgb: %2$s;', esc_attr( $slug ), esc_attr( auriel_theme_hex_to_rgb( $value ) ) );
	}

	if ( empty( $css_fragments ) ) {
		return;
	}

	$css = ':root{' . implode( '', $css_fragments ) . '}';

	wp_add_inline_style( AURIEL_VITE_STYLE_HANDLE, $css );
}
add_action( 'wp_enqueue_scripts', 'auriel_theme_output_design_tokens', 110 );
