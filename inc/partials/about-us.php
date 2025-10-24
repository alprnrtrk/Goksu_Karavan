<?php
declare(strict_types=1);

auriel_partials_register(
  'about-us',
  [
    'title' => __('Hakkımızda Alanı', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Kutulu Hakkımızda Alanını Özelleştirin.', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'about-us-heading' => [
        'label' => 'Başlık',
        'type' => 'text',
      ],
      'about-us-description' => [
        'label' => 'Açıklama',
        'type' => 'textarea',
      ],
      'about-us-box-heading' => [
        'label' => 'Kutu Başlık',
        'type' => 'text',
      ],
      'about-us-box-description' => [
        'label' => 'Kutu Açıklama',
        'type' => 'textarea',
      ],
      'about-us-stats' => [
        'label' => 'İstatislikleriniz (3 Adet)',
        'type' => 'repeater',
        'fields' => [
          'icon' => [
            'label' => 'İkon (fonawesome ikonları örn:"fa-brands fa-facebook")',
            'type' => 'text',
          ],
          'amount' => [
            'label' => 'Değer (150, 1000, 5)',
            'type' => 'text'
          ],
          'prefix' => [
            'label' => 'Değer Sonu (%, yıl, bin)',
            'type' => 'text'
          ],
          'label' => [
            'label' => 'Değer Adı',
            'type' => 'text'
          ]
        ]
      ],
      'about-us-mission' => [
        'label' => 'Misyon Açıklaması',
        'type' => 'textarea',
      ],
      'about-us-vision' => [
        'label' => 'Vizyon Açıklaması',
        'type' => 'textarea',
      ],
      'about-us-image-one' => [
        'label' => 'Görsel 1',
        'type' => 'image',
      ],
      'about-us-image-two' => [
        'label' => 'Görsel 2',
        'type' => 'image',
      ]
    ],
  ]
);
