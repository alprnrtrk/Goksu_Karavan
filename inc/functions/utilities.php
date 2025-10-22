<?php
declare(strict_types=1);

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
