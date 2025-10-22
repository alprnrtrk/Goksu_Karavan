<?php
declare(strict_types=1);

auriel_define_partial_fields(
  'partials/home-promo.php',
  array(
    'fields' => array(
      'home_promo_eyebrow' => array(
        'type' => 'text',
        'label' => __('Intro label', AURIEL_THEME_TEXT_DOMAIN),
        'default' => __('Plan your escape', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'home_promo_heading' => array(
        'type' => 'text',
        'label' => __('Promo heading', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_home_promo_default_heading',
      ),
      'home_promo_text' => array(
        'type' => 'textarea',
        'label' => __('Promo text', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 4,
        'default_callback' => 'auriel_home_promo_default_text',
      ),
      'home_promo_button_label' => array(
        'type' => 'text',
        'label' => __('Button label', AURIEL_THEME_TEXT_DOMAIN),
        'default' => __('Browse vans', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'home_promo_button_url' => array(
        'type' => 'url',
        'label' => __('Button URL', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_home_promo_default_button_url',
      ),
      'home_promo_image_id' => array(
        'type' => 'image',
        'label' => __('Supporting image', AURIEL_THEME_TEXT_DOMAIN),
        'placeholder' => __('No image selected', AURIEL_THEME_TEXT_DOMAIN),
      ),
    ),
  ),
  array(
    'title' => __('Home Promo', AURIEL_THEME_TEXT_DOMAIN),
  )
);

function auriel_home_promo_default_heading(): string
{
  return __('Take the scenic route without the stress', AURIEL_THEME_TEXT_DOMAIN);
}

function auriel_home_promo_default_text(): string
{
  return __(
    'Curated caravans, thoughtful amenities, and on-call support mean you can focus on the journey. Choose a ready-made itinerary or customise every mile.',
    AURIEL_THEME_TEXT_DOMAIN
  );
}

function auriel_home_promo_default_button_url(): string
{
  return home_url('/fleet');
}
