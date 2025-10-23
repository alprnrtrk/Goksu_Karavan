<?php
declare(strict_types=1);

auriel_partials_register(
  'hero',
  [
    'title' => __('hero partial fields', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('some kind of description i dont know', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'hero_heading' => [
        'type' => 'text',
        'label' => __('Heading', AURIEL_THEME_TEXT_DOMAIN),
      ]
    ],
    [
      'hero_heading' => [
        'type' => 'text',
        'label' => __('Heading', AURIEL_THEME_TEXT_DOMAIN),
      ]
    ],
  ]
);
