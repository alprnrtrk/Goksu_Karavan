<?php
declare(strict_types=1);

/**
 * Declarative list of design token fields used on the settings screen.
 * Adjust values here without diving into the settings page internals.
 *
 * Supported field types: color, text, image.
 *
 * @return array<int, array<string, mixed>>
 */
function auriel_theme_get_design_token_fields(): array {
	$fields = array(
		array(
			'name'        => 'brand_logo',
			'label'       => __( 'Brand logo', AURIEL_THEME_TEXT_DOMAIN ),
			'type'        => 'image',
			'default'     => '',
			'instructions' => __( 'Optional fallback logo displayed when no site logo is set.', AURIEL_THEME_TEXT_DOMAIN ),
		),
		array(
			'name'        => 'primary_color',
			'label'       => __( 'Primary colour', AURIEL_THEME_TEXT_DOMAIN ),
			'type'        => 'color',
			'default'     => '#3b82f6',
			'instructions' => __( 'Primary accent colour applied to key interactions.', AURIEL_THEME_TEXT_DOMAIN ),
		),
		array(
			'name'        => 'secondary_color',
			'label'       => __( 'Secondary colour', AURIEL_THEME_TEXT_DOMAIN ),
			'type'        => 'color',
			'default'     => '#f59e0b',
			'instructions' => __( 'Secondary highlight colour for supporting elements.', AURIEL_THEME_TEXT_DOMAIN ),
		),
		array(
			'name'        => 'accent_color',
			'label'       => __( 'Accent colour', AURIEL_THEME_TEXT_DOMAIN ),
			'type'        => 'color',
			'default'     => '#10b981',
			'instructions' => __( 'Accent tone used to draw attention to featured blocks.', AURIEL_THEME_TEXT_DOMAIN ),
		),
		array(
			'name'        => 'surface_color',
			'label'       => __( 'Surface colour', AURIEL_THEME_TEXT_DOMAIN ),
			'type'        => 'color',
			'default'     => '#ffffff',
			'instructions' => __( 'Background colour for cards, panels, and neutral surfaces.', AURIEL_THEME_TEXT_DOMAIN ),
		),
		array(
			'name'        => 'text_color',
			'label'       => __( 'Text colour', AURIEL_THEME_TEXT_DOMAIN ),
			'type'        => 'color',
			'default'     => '#0f172a',
			'instructions' => __( 'Primary body text colour to maintain readability.', AURIEL_THEME_TEXT_DOMAIN ),
		),
	);

	return apply_filters( 'auriel_theme_design_token_fields', $fields );
}

/**
 * Shortcut to fetch the default value assigned to each token.
 *
 * @return array<string, string>
 */
function auriel_theme_design_token_defaults(): array {
	$defaults = array();

	foreach ( auriel_theme_get_design_token_fields() as $field ) {
		$name = $field['name'] ?? '';
		if ( '' === $name ) {
			continue;
		}

		$default = $field['default'] ?? '';
		$defaults[ $name ] = is_string( $default ) ? $default : (string) $default;
	}

	return $defaults;
}
