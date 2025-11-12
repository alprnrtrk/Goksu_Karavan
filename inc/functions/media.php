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

	$defaults         = array(
		'alt'     => (string) ( $attributes['alt'] ?? '' ),
		'width'   => $attributes['width'] ?? '',
		'height'  => $attributes['height'] ?? '',
		'srcset'  => $attributes['srcset'] ?? '',
		'sizes'   => $attributes['sizes'] ?? '',
		'loading' => 'lazy',
		'decoding' => 'async',
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

/**
 * Resolve core video attributes for a WordPress attachment.
 *
 * @param int|string $attachment Attachment ID or falsy value.
 *
 * @return array<string,mixed>
 */
function auriel_theme_resolve_video_attributes( $attachment ): array {
	$defaults = array(
		'id'               => 0,
		'src'              => '',
		'mime_type'        => '',
		'width'            => 0,
		'height'           => 0,
		'duration'         => 0,
		'duration_formatted' => '',
		'poster'           => '',
		'title'            => '',
		'caption'          => '',
		'description'      => '',
		'filesize'         => 0,
		'sources'          => array(),
	);

	$attachment_id = (int) $attachment;

	if ( $attachment_id <= 0 ) {
		return $defaults;
	}

	$post = get_post( $attachment_id );
	if ( ! $post instanceof WP_Post || 'attachment' !== $post->post_type ) {
		return $defaults;
	}

	$metadata = wp_get_attachment_metadata( $attachment_id );
	if ( ! is_array( $metadata ) ) {
		$metadata = array();
	}

	$url = wp_get_attachment_url( $attachment_id );
	$url = is_string( $url ) ? $url : '';

	$mime_type = get_post_mime_type( $attachment_id );
	$mime_type = is_string( $mime_type ) ? $mime_type : '';

	$width  = isset( $metadata['width'] ) ? (int) $metadata['width'] : 0;
	$height = isset( $metadata['height'] ) ? (int) $metadata['height'] : 0;

	$duration     = isset( $metadata['length'] ) ? (int) $metadata['length'] : 0;
	$duration_str = isset( $metadata['length_formatted'] ) ? (string) $metadata['length_formatted'] : '';

	$poster = get_the_post_thumbnail_url( $attachment_id, 'large' );
	if ( ! is_string( $poster ) ) {
		$poster = '';
	}
	if ( '' === $poster && isset( $metadata['image']['src'] ) && is_string( $metadata['image']['src'] ) ) {
		$poster = $metadata['image']['src'];
	}

	$caption     = wp_get_attachment_caption( $attachment_id ) ?: '';
	$description = is_string( $post->post_content ) ? trim( $post->post_content ) : '';

	$filesize = 0;
	if ( isset( $metadata['filesize'] ) ) {
		$filesize = (int) $metadata['filesize'];
	} else {
		$file = get_attached_file( $attachment_id );
		if ( $file && file_exists( $file ) ) {
			$filesize = filesize( $file );
		}
	}

	$sources = array();
	if ( '' !== $url ) {
		$sources[] = array(
			'src'       => $url,
			'mime_type' => $mime_type,
		);
	}

	return array(
		'id'                 => $attachment_id,
		'src'                => $url,
		'mime_type'          => $mime_type,
		'width'              => $width,
		'height'             => $height,
		'duration'           => $duration,
		'duration_formatted' => $duration_str,
		'poster'             => $poster,
		'title'              => get_the_title( $attachment_id ),
		'caption'            => is_string( $caption ) ? $caption : '',
		'description'        => $description,
		'filesize'           => $filesize,
		'sources'            => $sources,
	);
}

/**
 * Render a <video> tag from resolved video attributes.
 *
 * @param array<string,mixed> $attributes Attributes from auriel_theme_resolve_video_attributes().
 * @param array<string,mixed> $options    Optional overrides (controls, autoplay, loop, muted...).
 *
 * @return string
 */
function auriel_theme_render_video_from_attributes( array $attributes, array $options = array() ): string {
	if ( empty( $attributes['src'] ) ) {
		return '';
	}

	$defaults = array(
		'controls'   => true,
		'playsinline'=> true,
		'preload'    => 'metadata',
		'poster'     => $attributes['poster'] ?? '',
		'width'      => $attributes['width'] ?? '',
		'height'     => $attributes['height'] ?? '',
	);

	$attrs          = array_merge( $defaults, $options );
	$boolean_attrs  = array( 'controls', 'autoplay', 'loop', 'muted', 'playsinline' );
	$string_attrs   = array( 'preload', 'poster', 'width', 'height', 'crossorigin' );
	$numeric_attrs  = array( 'width', 'height' );
	$sources        = $attributes['sources'] ?? array();
	if ( empty( $sources ) ) {
		$sources = array(
			array(
				'src'       => $attributes['src'],
				'mime_type' => $attributes['mime_type'] ?? '',
			),
		);
	}

	$markup = '<video';
	foreach ( $boolean_attrs as $name ) {
		if ( ! empty( $attrs[ $name ] ) ) {
			$markup .= sprintf( ' %s', esc_attr( $name ) );
		}
	}

	foreach ( $string_attrs as $name ) {
		if ( ! isset( $attrs[ $name ] ) || '' === $attrs[ $name ] ) {
			continue;
		}

		$value = $attrs[ $name ];
		if ( in_array( $name, $numeric_attrs, true ) ) {
			$value = (int) $value;
			if ( $value <= 0 ) {
				continue;
			}
		}

		$markup .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( (string) $value ) );
	}

	$markup .= '>';

	foreach ( $sources as $source ) {
		if ( empty( $source['src'] ) ) {
			continue;
		}

		$type = isset( $source['mime_type'] ) ? (string) $source['mime_type'] : '';
		$markup .= '<source src="' . esc_url( (string) $source['src'] ) . '"';
		if ( '' !== $type ) {
			$markup .= ' type="' . esc_attr( $type ) . '"';
		}
		$markup .= ' />';
	}

	$markup .= esc_html__( 'Your browser does not support the video tag.', AURIEL_THEME_TEXT_DOMAIN );
	$markup .= '</video>';

	return $markup;
}
