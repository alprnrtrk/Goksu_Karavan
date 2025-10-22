<?php
declare(strict_types=1);

require_once __DIR__ . '/theme-options-definitions.php';

const AURIEL_THEME_OPTION_KEY = 'auriel_theme_design_tokens';

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
 * Sanitize saved token values.
 *
 * @param mixed $input Raw option input.
 *
 * @return array<string,string>
 */
function auriel_theme_sanitize_design_tokens( $input ): array {
	if ( ! is_array( $input ) ) {
		$input = array();
	}

	$defaults = auriel_theme_design_token_defaults();
	$tokens   = array();

	foreach ( auriel_theme_get_design_token_fields() as $field ) {
		$key = $field['name'] ?? '';
		if ( '' === $key ) {
			continue;
		}

		$type    = $field['type'] ?? 'text';
		$default = $defaults[ $key ] ?? '';
		$value   = $input[ $key ] ?? $default;

		switch ( $type ) {
			case 'color':
				$value = sanitize_text_field( (string) $value );
				if ( ! preg_match( '/^#([0-9a-fA-F]{3}){1,2}$/', $value ) ) {
					$value = $default;
				}
				break;
			case 'image':
				$value = absint( $value );
				$value = $value > 0 ? (string) $value : '';
				break;
			default:
				$value = sanitize_text_field( (string) $value );
				break;
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

	foreach ( auriel_theme_get_design_token_fields() as $field ) {
		$key   = $field['name'] ?? '';
		$label = $field['label'] ?? ucwords( str_replace( '_', ' ', $key ) );

		if ( '' === $key ) {
			continue;
		}

		add_settings_field(
			$key,
			$label,
			'auriel_theme_render_settings_field',
			AURIEL_THEME_SETTINGS_PAGE_SLUG,
			'auriel_theme_design_tokens_section',
			array( 'field' => $field )
		);
	}
}
add_action( 'admin_init', 'auriel_theme_register_settings' );

/**
 * Render a settings field using the declarative configuration.
 *
 * @param array<string,mixed> $args Field arguments.
 */
function auriel_theme_render_settings_field( array $args ): void {
	$field = $args['field'] ?? array();
	$key   = $field['name'] ?? '';

	if ( '' === $key ) {
		return;
	}

	$type       = $field['type'] ?? 'text';
	$default    = auriel_theme_design_token_defaults()[ $key ] ?? '';
	$value      = auriel_theme_get_design_token( $key, $default );
	$field_id   = isset( $field['id'] ) ? (string) $field['id'] : $key;
	$name_attr  = sprintf( '%s[%s]', AURIEL_THEME_OPTION_KEY, $key );
	$class_attr = array_filter(
		array(
			'auriel-field',
			'auriel-field--' . sanitize_html_class( $type ),
			isset( $field['class'] ) ? (string) $field['class'] : '',
		)
	);
	$class_attr = implode( ' ', array_map( 'sanitize_html_class', $class_attr ) );

	switch ( $type ) {
		case 'color':
			printf(
				'<input type="color" id="%1$s" name="%2$s" value="%3$s"%4$s />',
				esc_attr( $field_id ),
				esc_attr( $name_attr ),
				esc_attr( (string) $value ),
				'' !== $class_attr ? ' class="' . esc_attr( $class_attr ) . '"' : ''
			);
			break;
		case 'image':
			$attachment_id   = absint( $value );
			$stored_value    = $attachment_id > 0 ? (string) $attachment_id : '';
			$placeholder     = isset( $field['placeholder'] ) ? (string) $field['placeholder'] : __( 'No image selected', AURIEL_THEME_TEXT_DOMAIN );
			$select_label    = isset( $field['select_button'] ) ? (string) $field['select_button'] : __( 'Select image', AURIEL_THEME_TEXT_DOMAIN );
			$clear_label     = isset( $field['clear_button'] ) ? (string) $field['clear_button'] : __( 'Remove image', AURIEL_THEME_TEXT_DOMAIN );
			$preview_markup  = '';

			if ( $attachment_id > 0 ) {
				$preview_markup = wp_get_attachment_image( $attachment_id, 'thumbnail', false );
			}

			if ( empty( $preview_markup ) ) {
				$preview_markup = '<span class="auriel-media-placeholder">' . esc_html( $placeholder ) . '</span>';
			}

			$wrapper_classes = 'auriel-media-field';
			if ( '' !== $class_attr ) {
				$wrapper_classes .= ' ' . $class_attr;
			}

			echo '<div class="' . esc_attr( $wrapper_classes ) . '" data-auriel-media-field>';
			printf(
				'<input type="hidden" id="%1$s" name="%2$s" value="%3$s" />',
				esc_attr( $field_id ),
				esc_attr( $name_attr ),
				esc_attr( $stored_value )
			);
			echo '<div class="auriel-media-preview" data-preview data-placeholder="' . esc_attr( $placeholder ) . '">';
			echo wp_kses_post( $preview_markup );
			echo '</div>';
			echo '<div class="auriel-media-actions">';
			printf(
				'<button type="button" class="button auriel-media-select" data-action="select" data-modal-title="%1$s" data-modal-button="%2$s">%3$s</button>',
				esc_attr( $select_label ),
				esc_attr( $select_label ),
				esc_html( $select_label )
			);
			printf(
				'<button type="button" class="button button-secondary auriel-media-clear" data-action="clear"%1$s>%2$s</button>',
				'' === $stored_value ? ' disabled' : '',
				esc_html( $clear_label )
			);
			echo '</div>';
			echo '</div>';
			break;
		default:
			printf(
				'<input type="text" id="%1$s" name="%2$s" value="%3$s"%4$s />',
				esc_attr( $field_id ),
				esc_attr( $name_attr ),
				esc_attr( (string) $value ),
				'' !== $class_attr ? ' class="' . esc_attr( $class_attr ) . '"' : ''
			);
			break;
	}

	if ( ! empty( $field['instructions'] ) ) {
		printf(
			'<p class="description">%s</p>',
			esc_html( (string) $field['instructions'] )
		);
	}
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
 * Enqueue assets required for enhanced settings fields.
 *
 * @param string $hook Current admin page hook.
 */
function auriel_theme_enqueue_settings_assets( string $hook ): void {
	if ( 'appearance_page_' . AURIEL_THEME_SETTINGS_PAGE_SLUG !== $hook ) {
		return;
	}

	wp_enqueue_media();

	$script_rel  = 'assets/admin/theme-options.js';
	$script_path = get_template_directory() . '/' . $script_rel;

	if ( file_exists( $script_path ) ) {
		wp_enqueue_script(
			'auriel-theme-options',
			get_template_directory_uri() . '/' . $script_rel,
			array(),
			(string) filemtime( $script_path ),
			true
		);
	}
}
add_action( 'admin_enqueue_scripts', 'auriel_theme_enqueue_settings_assets' );

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

	foreach ( auriel_theme_get_design_token_fields() as $field ) {
		if ( ( $field['type'] ?? '' ) !== 'color' ) {
			continue;
		}

		$key = $field['name'] ?? '';
		if ( '' === $key ) {
			continue;
		}

		$value = $tokens[ $key ] ?? '';
		if ( '' === $value ) {
			continue;
		}

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
