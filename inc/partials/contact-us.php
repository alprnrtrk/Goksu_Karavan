<?php
declare(strict_types=1);

auriel_partials_register(
  'contact-us',
  [
    'title' => __('İletişime Geç', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('İletişim Alanını Özelleştirin.', AURIEL_THEME_TEXT_DOMAIN),
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
      'phone' => [
        'label' => 'Telefon 1',
        'type' => 'text',
      ],
      'phone2' => [
        'label' => 'Telefon 2',
        'type' => 'text',
      ],
      'mail' => [
        'label' => 'Mail',
        'type' => 'text',
      ],
      'adress' => [
        'label' => 'İşletme Adresiniz',
        'type' => 'text',
      ],
      'map' => [
        'label' => 'Adres (google map > paylaş > harita yerleştırme)',
        'type' => 'textarea',
      ],
    ],
  ]
);
