<?php
declare(strict_types=1);

/**
 * Resolve core image attributes for a WordPress attachment in one go.
 *
 * @param int|string $attachment Attachment ID or falsy value.
 * @param string     $size       Image size to resolve.
 *
 * @return array<string,mixed>
 */
function auriel_theme_resolve_image_attributes( $attachment, string $size = 'full' ): array {
	$attachment_id = (int) $attachment;

	if ( $attachment_id <= 0 ) {
		return array(
			'id'     => 0,
			'src'    => '',
			'alt'    => '',
			'width'  => 0,
			'height' => 0,
			'srcset' => '',
			'sizes'  => '',
		);
	}

	$image = wp_get_attachment_image_src( $attachment_id, $size );

	if ( ! $image ) {
		return array(
			'id'     => $attachment_id,
			'src'    => '',
			'alt'    => '',
			'width'  => 0,
			'height' => 0,
			'srcset' => '',
			'sizes'  => '',
		);
	}

	$srcset = wp_get_attachment_image_srcset( $attachment_id, $size ) ?: '';
	$sizes  = wp_get_attachment_image_sizes( $attachment_id, $size ) ?: '';
	$alt    = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

	return array(
		'id'     => $attachment_id,
		'src'    => (string) $image[0],
		'width'  => (int) $image[1],
		'height' => (int) $image[2],
		'alt'    => is_string( $alt ) ? $alt : '',
		'srcset' => (string) $srcset,
		'sizes'  => (string) $sizes,
	);
}

/**
 * Build an <img> tag from resolved attributes.
 *
 * @param array<string,mixed> $attributes Attributes from auriel_theme_resolve_image_attributes().
 * @param array<string,string> $extra Additional attributes (class, loading, decoding...).
 *
 * @return string
 */
function auriel_theme_render_image_from_attributes( array $attributes, array $extra = array() ): string {
	if ( empty( $attributes['src'] ) ) {
		return '';
	}

	$defaults = array(
		'alt'     => (string) ( $attributes['alt'] ?? '' ),
		'width'   => $attributes['width'] ?? '',
		'height'  => $attributes['height'] ?? '',
		'srcset'  => $attributes['srcset'] ?? '',
		'sizes'   => $attributes['sizes'] ?? '',
		'loading' => 'lazy',
		'decoding'=> 'async',
	);

	$attrs = array_merge( $defaults, $extra );
	$attrs['src'] = (string) $attributes['src'];

	$markup = '<img';
	foreach ( $attrs as $name => $value ) {
		if ( '' === $value || null === $value ) {
			continue;
		}

		$markup .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( (string) $value ) );
	}
	$markup .= ' />';

	return $markup;
}
