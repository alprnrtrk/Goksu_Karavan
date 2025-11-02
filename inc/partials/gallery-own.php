<?php
declare(strict_types=1);

auriel_partials_register(
  'gallery-own',
  [
    'title' => __('Galeri Alanı', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Galerinizi Özelleştirin', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'gallery_images' => [
        'type' => ''
      ]
    ],
  ]
);
