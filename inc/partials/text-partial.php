<?php
declare(strict_types=1);

auriel_define_partial_fields(
	'partials/text-partial.php',
	array(
		'templates' => auriel_theme_discover_partial_templates( 'partials/text-partial.php' ),
		'fields'    => array(
			'text_partial_heading' => array(
				'type'              => 'text',
				'label'             => __( 'Heading', AURIEL_THEME_TEXT_DOMAIN ),
				'instructions'      => __( 'Primary heading displayed within the text testing block.', AURIEL_THEME_TEXT_DOMAIN ),
				'default_callback'  => 'auriel_text_partial_default_heading',
			),
			'text_partial_body' => array(
				'type'              => 'textarea',
				'label'             => __( 'Body copy', AURIEL_THEME_TEXT_DOMAIN ),
				'instructions'      => __( 'Supporting description text.', AURIEL_THEME_TEXT_DOMAIN ),
				'rows'              => 4,
				'default_callback'  => 'auriel_text_partial_default_body',
			),
			'text_partial_image' => array(
				'type'              => 'image',
				'label'             => __( 'Feature image', AURIEL_THEME_TEXT_DOMAIN ),
				'instructions'      => __( 'Optional image used for testing the resolver helper.', AURIEL_THEME_TEXT_DOMAIN ),
				'placeholder'       => __( 'No feature image selected', AURIEL_THEME_TEXT_DOMAIN ),
			),
		),
	),
	array(
		'title'      => __( 'Text Tester', AURIEL_THEME_TEXT_DOMAIN ),
		'post_types' => array( 'page' ),
	)
);

/**
 * Default heading fallback.
 */
function auriel_text_partial_default_heading(): string {
	$blogname = get_bloginfo( 'name' );

	return ! empty( $blogname ) ? (string) $blogname : __( 'Text tester heading', AURIEL_THEME_TEXT_DOMAIN );
}

/**
 * Default body fallback.
 */
function auriel_text_partial_default_body(): string {
	$description = get_bloginfo( 'description', 'display' );

	if ( ! empty( $description ) ) {
		return (string) $description;
	}

	return __( 'Use this partial to experiment with new helper utilities and theme option values.', AURIEL_THEME_TEXT_DOMAIN );
}

/**
 * Resolve testing partial fields as an array.
 *
 * @param int $post_id Optional post ID.
 *
 * @return array<string,mixed>
 */
function auriel_text_partial_get_fields( int $post_id = 0 ): array {
	return auriel_theme_get_fields(
		array(
			'text_partial_heading',
			'text_partial_body',
			'text_partial_image',
		),
		$post_id
	);
}
