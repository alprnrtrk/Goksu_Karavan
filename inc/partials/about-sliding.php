<?php
declare(strict_types=1);

auriel_partials_register(
  'about-sliding',
  [
    'title' => __('Servisler Alanı', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Kayan yapıyı özelleştirin.', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'about-sliding-heading' => [
        'label' => 'Başlık',
        'type' => 'text',
      ],
      'about-sliding-description' => [
        'label' => 'Açıklama',
        'type' => 'textarea',
      ],
      'about-sliding-services' => [
        'label' => 'Hizmetleriniz',
        'type' => 'repeater',
        'fields' => [
          'icon' => [
            'label' => 'Hizmet İkonunuz (font awesome ikon class adı "fa-brand fa-twitter")',
            'type' => 'text',
          ],
          'name' => [
            'label' => 'Hizmet Başlığınız',
            'type' => 'text',
          ],
          'detail' => [
            'label' => 'Hizmet Detayınız',
            'type' => 'text',
          ],
        ]
      ],
      'about-sliding-cards' => [
        'label' => 'Kayan Görseller',
        'type' => 'repeater',
        'fields' => [
          'bacground-image' => [
            'label' => 'Arka Plan Resmi',
            'type' => 'image',
          ]
        ]
      ],
    ],
  ]
);
