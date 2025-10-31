<?php
declare(strict_types=1);

auriel_partials_register(
  'generic-hero',
  [
    'title' => __('Sayfa Başlangıcı Alanı', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Sayfa başlangıç alanını özelleştirin.', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'generic_hero_title' => [
        'type' => 'text',
      ],
      'generic_hero_description' => [
        'type' => 'textarea',
      ],
      'generic_hero_images' => [
        'type' => 'repeater',
        'fields' => [
          'image' => [
            'type' => 'image'
          ]
        ]
      ],
    ],
  ]
);
