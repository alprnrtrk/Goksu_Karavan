<?php
declare(strict_types=1);

auriel_define_partial_fields(
  'partials/hero.php',
  array(
    'templates' => auriel_theme_get_hero_templates(),
    'fields' => array(
      'hero_headline' => array(
        'type' => 'text',
        'label' => __('Hero headline', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Displayed as the main heading inside the hero section.', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_hero_default_headline',
      ),
      'hero_subheading' => array(
        'type' => 'textarea',
        'label' => __('Hero subheading', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Short description shown beneath the headline.', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 3,
        'default_callback' => 'auriel_hero_default_subheading',
      ),
      'hero_button_label' => array(
        'type' => 'text',
        'label' => __('Hero button label', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Optional call-to-action label.', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_hero_default_button_label',
      ),
      'hero_button_url' => array(
        'type' => 'url',
        'label' => __('Hero button URL', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Optional call-to-action link URL.', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_hero_default_button_url',
      ),
      'hero_slides' => array(
        'type' => 'repeater',
        'label' => __('Hero slides', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Configure the slides displayed in the hero carousel.', AURIEL_THEME_TEXT_DOMAIN),
        'button_label' => __('Add slide', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_hero_default_slides',
        'fields' => array(
          'title' => array(
            'type' => 'text',
            'label' => __('Slide title', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'subtitle' => array(
            'type' => 'textarea',
            'label' => __('Slide subtitle', AURIEL_THEME_TEXT_DOMAIN),
            'rows' => 2,
          ),
          'content' => array(
            'type' => 'textarea',
            'label' => __('Slide content', AURIEL_THEME_TEXT_DOMAIN),
            'rows' => 4,
          ),
          'button_label' => array(
            'type' => 'text',
            'label' => __('Button label', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'button_url' => array(
            'type' => 'url',
            'label' => __('Button URL', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'image_id' => array(
            'type' => 'image',
            'label' => __('Slide image', AURIEL_THEME_TEXT_DOMAIN),
            'placeholder' => __('No image selected', AURIEL_THEME_TEXT_DOMAIN),
          ),
        ),
      ),
    ),
  ),
  array(
    'title' => __('Page Hero', AURIEL_THEME_TEXT_DOMAIN),
  )
);

/**
 * Retrieve hero slide entries stored on the page.
 *
 * @param int $post_id Optional post ID.
 *
 * @return array<int, array<string, mixed>>
 */
function auriel_get_hero_slides(int $post_id = 0): array
{
  if (0 === $post_id) {
    $post_id = function_exists('get_the_ID') ? (int) get_the_ID() : 0;
  }

  if (0 === $post_id) {
    return auriel_hero_default_slides();
  }

  $slides = auriel_theme_get_field('hero_slides', null, $post_id);

  if (!is_array($slides) || empty($slides)) {
    $legacy = get_post_meta($post_id, '_auriel_hero_slides', true);
    if (is_array($legacy) && !empty($legacy)) {
      $slides = $legacy;
    }
  }

  if (!is_array($slides)) {
    $slides = array();
  }

  $prepared = array();

  foreach ($slides as $slide) {
    if (!is_array($slide)) {
      continue;
    }

    $image_id = 0;
    if (isset($slide['image_id'])) {
      $image_id = (int) $slide['image_id'];
    } elseif (isset($slide['image'])) {
      $image_id = (int) $slide['image'];
    }

    $prepared[] = array(
      'title' => isset($slide['title']) ? sanitize_text_field((string) $slide['title']) : '',
      'subtitle' => isset($slide['subtitle']) ? sanitize_text_field((string) $slide['subtitle']) : '',
      'content' => isset($slide['content']) ? wp_kses_post((string) $slide['content']) : '',
      'button_label' => isset($slide['button_label']) ? sanitize_text_field((string) $slide['button_label']) : '',
      'button_url' => isset($slide['button_url']) ? esc_url_raw((string) $slide['button_url']) : '',
      'image_id' => $image_id,
    );
  }

  if (empty($prepared)) {
    $prepared = auriel_hero_default_slides();
  }

  return $prepared;
}

function auriel_hero_default_headline(int $post_id = 0): string
{
  if (0 !== $post_id) {
    $title = get_the_title($post_id);
    if (!empty($title)) {
      return (string) $title;
    }
  }

  $title = function_exists('get_the_title') ? get_the_title() : '';
  if (!empty($title)) {
    return (string) $title;
  }

  return get_bloginfo('name');
}

function auriel_hero_default_subheading(): string
{
  return (string) get_bloginfo('description', 'display');
}

function auriel_hero_default_button_label(): string
{
  return __('Explore more', AURIEL_THEME_TEXT_DOMAIN);
}

function auriel_hero_default_button_url(): string
{
  return home_url();
}

function auriel_hero_default_slides(): array
{
  $tokens = auriel_theme_get_design_tokens();

  return array(
    array(
      'title' => __('Primary palette in action', AURIEL_THEME_TEXT_DOMAIN),
      'subtitle' => sprintf(
        __('Buttons and interactive accents inherit %s.', AURIEL_THEME_TEXT_DOMAIN),
        $tokens['primary_color'] ?? '#3b82f6'
      ),
      'content' => '',
      'button_label' => auriel_hero_default_button_label(),
      'button_url' => auriel_hero_default_button_url(),
      'image_id' => 0,
    ),
    array(
      'title' => __('Secondary highlights', AURIEL_THEME_TEXT_DOMAIN),
      'subtitle' => sprintf(
        __('Badges and highlights rely on %s.', AURIEL_THEME_TEXT_DOMAIN),
        $tokens['secondary_color'] ?? '#f59e0b'
      ),
      'content' => '',
      'button_label' => '',
      'button_url' => '',
      'image_id' => 0,
    ),
    array(
      'title' => __('Accent tone', AURIEL_THEME_TEXT_DOMAIN),
      'subtitle' => sprintf(
        __('CTA backgrounds use %s.', AURIEL_THEME_TEXT_DOMAIN),
        $tokens['accent_color'] ?? '#10b981'
      ),
      'content' => '',
      'button_label' => '',
      'button_url' => '',
      'image_id' => 0,
    ),
  );
}
