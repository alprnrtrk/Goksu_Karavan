<?php
declare(strict_types=1);

auriel_partials_register(
  'hero',
  [
    'title' => __('Giriş Alanı', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Sitenin Karşılama Alanını Özelleştirin', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => ['page'],
    'fields' => [
      'hero_heading' => [
        'type' => 'text',
        'label' => __('Giriş Başlık', AURIEL_THEME_TEXT_DOMAIN),
      ],
      'hero_subHeading' => [
        'type' => 'text',
        'label' => __('Giriş Alt Başlık', AURIEL_THEME_TEXT_DOMAIN),
      ]
    ],
    [

    ],
  ]
);
