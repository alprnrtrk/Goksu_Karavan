<?php
declare(strict_types=1);

auriel_partials_register(
  'hero',
  [
    'title' => __('hero partial fields', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('some kind of description i dont know', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'heading' => [
        'type' => 'text',
        'label' => __('Heading', AURIEL_THEME_TEXT_DOMAIN),
      ],
      'image' => [
        'type' => 'image',
        'label' => __('Supporting image', AURIEL_THEME_TEXT_DOMAIN),
      ],
    ],
  ]
);
