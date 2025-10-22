<?php
declare(strict_types=1);

/**
 * Helper to define a text field configuration.
 *
 * @param string               $label Field label.
 * @param array<string,mixed>  $args  Additional configuration.
 *
 * @return array<string,mixed>
 */
function auriel_partial_field_text( string $label, array $args = array() ): array {
	return array_merge(
		array(
			'type'  => 'text',
			'label' => $label,
		),
		$args
	);
}

/**
 * Helper to define a textarea field configuration.
 *
 * @param string               $label Field label.
 * @param array<string,mixed>  $args  Additional configuration.
 *
 * @return array<string,mixed>
 */
function auriel_partial_field_textarea( string $label, array $args = array() ): array {
	return array_merge(
		array(
			'type'  => 'textarea',
			'label' => $label,
		),
		$args
	);
}

/**
 * Helper to define a URL field configuration.
 *
 * @param string               $label Field label.
 * @param array<string,mixed>  $args  Additional configuration.
 *
 * @return array<string,mixed>
 */
function auriel_partial_field_url( string $label, array $args = array() ): array {
	return array_merge(
		array(
			'type'  => 'url',
			'label' => $label,
		),
		$args
	);
}

/**
 * Helper to define a number field configuration.
 *
 * @param string               $label Field label.
 * @param array<string,mixed>  $args  Additional configuration.
 *
 * @return array<string,mixed>
 */
function auriel_partial_field_number( string $label, array $args = array() ): array {
	return array_merge(
		array(
			'type'  => 'number',
			'label' => $label,
		),
		$args
	);
}

/**
 * Helper to define an image field configuration.
 *
 * @param string               $label Field label.
 * @param array<string,mixed>  $args  Additional configuration.
 *
 * @return array<string,mixed>
 */
function auriel_partial_field_image( string $label, array $args = array() ): array {
	return array_merge(
		array(
			'type'  => 'image',
			'label' => $label,
		),
		$args
	);
}

/**
 * Helper to define a repeater field configuration.
 *
 * @param string                               $label  Field label.
 * @param array<string,array<string,mixed>>    $fields Sub-field definitions keyed by name.
 * @param array<string,mixed>                  $args   Additional configuration.
 *
 * @return array<string,mixed>
 */
function auriel_partial_field_repeater( string $label, array $fields, array $args = array() ): array {
	return array_merge(
		array(
			'type'   => 'repeater',
			'label'  => $label,
			'fields' => $fields,
		),
		$args
	);
}
