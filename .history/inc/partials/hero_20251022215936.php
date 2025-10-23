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
      'intro' => [
        'type' => 'textarea',
        'label' => __('Intro text', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 3,
      ],
      'body' => [
        'type' => 'editor',
        'label' => __('Body content', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 8,
      ],
      'button_label' => [
        'type' => 'text',
        'label' => __('Button label', AURIEL_THEME_TEXT_DOMAIN),
      ],
      'button_url' => [
        'type' => 'url',
        'label' => __('Button URL', AURIEL_THEME_TEXT_DOMAIN),
      ],
      'image' => [
        'type' => 'image',
        'label' => __('Supporting image', AURIEL_THEME_TEXT_DOMAIN),
      ],
      'items' => [
        'type' => 'repeater',
        'label' => __('Feature items', AURIEL_THEME_TEXT_DOMAIN),
        'add_button_label' => __('Add feature', AURIEL_THEME_TEXT_DOMAIN),
        'fields' => [
          'title' => [
            'type' => 'text',
            'label' => __('Item title', AURIEL_THEME_TEXT_DOMAIN),
          ],
          'description' => [
            'type' => 'textarea',
            'label' => __('Item description', AURIEL_THEME_TEXT_DOMAIN),
            'rows' => 3,
          ],
          'link_label' => [
            'type' => 'text',
            'label' => __('Link label', AURIEL_THEME_TEXT_DOMAIN),
          ],
          'link_url' => [
            'type' => 'url',
            'label' => __('Link URL', AURIEL_THEME_TEXT_DOMAIN),
          ],
          'icon_image' => [
            'type' => 'image',
            'label' => __('Optional icon image', AURIEL_THEME_TEXT_DOMAIN),
          ],
        ],
      ],
    ],
  ]
);
