<?php
declare(strict_types=1);

auriel_partials_register(
  'feature-showcase',
  array(
    'title' => __('Feature Showcase Partial', AURIEL_THEME_TEXT_DOMAIN),
    'description' => __('Example partial demonstrating text, textarea, editor, link, image, and repeater fields.', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => array('page'),
    'fields' => array(
      'heading' => array(
        'type' => 'text',
        'label' => __('Heading', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'intro' => array(
        'type' => 'textarea',
        'label' => __('Intro text', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 3,
      ),
      'body' => array(
        'type' => 'editor',
        'label' => __('Body content', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 8,
      ),
      'button_label' => array(
        'type' => 'text',
        'label' => __('Button label', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'button_url' => array(
        'type' => 'url',
        'label' => __('Button URL', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'image' => array(
        'type' => 'image',
        'label' => __('Supporting image', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'items' => array(
        'type' => 'repeater',
        'label' => __('Feature items', AURIEL_THEME_TEXT_DOMAIN),
        'add_button_label' => __('Add feature', AURIEL_THEME_TEXT_DOMAIN),
        'fields' => array(
          'title' => array(
            'type' => 'text',
            'label' => __('Item title', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'description' => array(
            'type' => 'textarea',
            'label' => __('Item description', AURIEL_THEME_TEXT_DOMAIN),
            'rows' => 3,
          ),
          'link_label' => array(
            'type' => 'text',
            'label' => __('Link label', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'link_url' => array(
            'type' => 'url',
            'label' => __('Link URL', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'icon_image' => array(
            'type' => 'image',
            'label' => __('Optional icon image', AURIEL_THEME_TEXT_DOMAIN),
          ),
        ),
      ),
    ),
  )
);
