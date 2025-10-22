<?php
declare(strict_types=1);

auriel_define_partial_fields(
	'partials/test-partial.php',
	array(
		'templates' => auriel_theme_discover_partial_templates( 'partials/test-partial.php' ),
		'fields'    => array(
			'dev_heading'       => auriel_partial_field_text(
				__( 'Guide heading', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'instructions' => __( 'Displayed as the hero heading for the developer playground.', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
			'dev_intro'         => auriel_partial_field_textarea(
				__( 'Intro summary', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'rows'         => 4,
					'instructions' => __( 'Explain what this partial teaches (textareas support multi-line copy).', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
			'dev_button_label'  => auriel_partial_field_text(
				__( 'CTA label', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'instructions' => __( 'Simple text field used for button copy.', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
			'dev_button_url'    => auriel_partial_field_url(
				__( 'CTA URL', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'instructions' => __( 'URL field for external/internal links.', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
			'dev_stat_number'   => auriel_partial_field_number(
				__( 'Number field', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'instructions' => __( 'Great for counters and stats; stored as text, so cast to (int) or (float) in templates.', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
			'dev_feature_image' => auriel_partial_field_image(
				__( 'Feature image', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'instructions' => __( 'Image picker integrated with the WordPress media library.', AURIEL_THEME_TEXT_DOMAIN ),
					'placeholder'  => __( 'No feature image selected', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
			'dev_video_url'     => auriel_partial_field_url(
				__( 'Video URL', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'instructions' => __( 'Paste a YouTube/Vimeo URL (wp_oembed_get() handles embeds in the template).', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
			'dev_cards'         => auriel_partial_field_repeater(
				__( 'Walkthrough cards', AURIEL_THEME_TEXT_DOMAIN ),
				array(
					'title'       => auriel_partial_field_text( __( 'Card title', AURIEL_THEME_TEXT_DOMAIN ) ),
					'description' => auriel_partial_field_textarea(
						__( 'Card description', AURIEL_THEME_TEXT_DOMAIN ),
						array( 'rows' => 3 )
					),
					'link_label'  => auriel_partial_field_text( __( 'Link label', AURIEL_THEME_TEXT_DOMAIN ) ),
					'link_url'    => auriel_partial_field_url( __( 'Link URL', AURIEL_THEME_TEXT_DOMAIN ) ),
					'media_id'    => auriel_partial_field_image(
						__( 'Supporting image', AURIEL_THEME_TEXT_DOMAIN ),
						array(
							'placeholder' => __( 'No image selected', AURIEL_THEME_TEXT_DOMAIN ),
						)
					),
				),
				array(
					'instructions' => __( 'Repeater fields let authors add repeatable groups (title, copy, link, image).', AURIEL_THEME_TEXT_DOMAIN ),
					'button_label' => __( 'Add walkthrough card', AURIEL_THEME_TEXT_DOMAIN ),
				)
			),
		),
	),
	array(
		'title'      => __( 'Developer Test Harness', AURIEL_THEME_TEXT_DOMAIN ),
		'post_types' => array( 'page' ),
	)
);

/**
 * Convenience wrapper to fetch all partial fields at once.
 *
 * @param int $post_id Optional post ID.
 *
 * @return array<string,mixed>
 */
function auriel_test_partial_get_fields( int $post_id = 0 ): array {
	$fields = auriel_theme_get_fields(
		array(
			'dev_heading',
			'dev_intro',
			'dev_button_label',
			'dev_button_url',
			'dev_stat_number',
			'dev_feature_image',
			'dev_video_url',
			'dev_cards',
		),
		$post_id
	);

	if ( ! isset( $fields['dev_cards'] ) || ! is_array( $fields['dev_cards'] ) ) {
		$fields['dev_cards'] = array();
	}

	return $fields;
}
