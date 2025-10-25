<?php
declare(strict_types=1);

auriel_partials_register(
  'caravan',
  [
    'title' => __('Karavan Detay', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Karavan Özelliklerini Güncelleyin & Ekleyin.', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'heading' => [
        'label' => 'Başlık',
        'type' => 'text'
      ],
      'description' => [
        'label' => 'Açıklama',
        'type' => 'textarea'
      ],
      'image' => [
        'label' => 'Karavan Görsel',
        'type' => 'image'
      ],
      'left-area' => [
        'label' => 'Sol Alan Özellikler',
        'type' => 'repeater',
        'fields' => [
          'type' => 'text'
        ]
      ],
      'right-area' => [
        'label' => 'Sağ Alan Özellikler',
        'type' => 'repeater',
        'fields' => [
          'type' => 'text'
        ]
      ],
    ],
  ]
);
