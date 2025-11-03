<?php
declare(strict_types=1);

auriel_partials_register(
  'gallery-own',
  [
    'title' => __('Gallery Section', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Manage the gallery grid content for dedicated gallery pages.', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'heading' => [
        'type' => 'text',
        'label' => __('Heading', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Displayed above the gallery grid.', AURIEL_THEME_TEXT_DOMAIN),
      ],
      'summary' => [
        'type' => 'textarea',
        'label' => __('Summary', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Optional supporting copy shown under the heading.', AURIEL_THEME_TEXT_DOMAIN),
      ],
      'gallery_images' => [
        'type' => 'gallery',
        'label' => __('Images', AURIEL_THEME_TEXT_DOMAIN),
        'instructions' => __('Select one or more images from the media library to populate the gallery.', AURIEL_THEME_TEXT_DOMAIN),
      ],
    ],
  ]
);
