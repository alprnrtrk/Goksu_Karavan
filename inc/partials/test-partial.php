<?php
declare(strict_types=1);

auriel_define_partial_fields(
  'partials/test-partial.php',
  array(
    'templates' => auriel_theme_discover_partial_templates('partials/test-partial.php'),
    'fields' => array(
      'test_partial_title' => array(
        'type' => 'text',
        'label' => __('Test Partial Title', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('The title displayed in the test partial section.', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_test_partial_default_title',
      ),
      'test_partial_subtitle' => array(
        'type' => 'textarea',
        'label' => __('Test Partial Subtitle', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('The subtitle displayed in the test partial section.', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 3,
        'default_callback' => 'auriel_test_partial_default_subtitle',
      )
    )
  )
)

  ?>