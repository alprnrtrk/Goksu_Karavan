<?php
declare(strict_types=1);

auriel_partials_register(
  'gallery',
  [
    'title' => __('Galeri Alanı', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Açıklama alanını özelleştirin.', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'heading' => [
        'type' => 'text',
        'label' => 'Başlık'
      ],
      'description' => [
        'type' => 'textarea',
        'label' => 'Açıklama'
      ],
      'images' => [
        'label' => 'Galeri Resimeri',
        'type' => 'repeater',
        'fields' => [
          'images' => [
            'type' => 'image'
          ]
        ]
      ],
    ],
  ]
);
