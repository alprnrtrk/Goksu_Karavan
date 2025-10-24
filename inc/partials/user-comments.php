<?php
declare(strict_types=1);

auriel_partials_register(
  'user-comments',
  [
    'title' => __('Kullanıcı Yorunları', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Yeni Yorum Ekleyin & Varolan Yorumları Düzenleyin', AURIEL_THEME_TEXT_DOMAIN),
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
      'comments' => [
        'type' => 'repeater',
        'label' => 'Yorumlar',
        'fields' => [
          'user-image' => [
            'label' => 'Kullanıcı Resmi',
            'type' => 'image',
          ],
          'user-name' => [
            'label' => 'Kullanıcı Adı',
            'type' => 'text',
          ],
          'rate' => [
            'label' => 'Yıldız',
            'type' => 'number'
          ],
          'comment' => [
            'label' => 'Yorum',
            'type' => 'textarea'
          ]
        ]
      ],
      'image' => [
        'label' => 'Arkaplan Görseli',
        'type' => 'image'
      ]
    ],
  ]
);
