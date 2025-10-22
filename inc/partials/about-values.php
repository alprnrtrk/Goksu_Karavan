<?php
declare(strict_types=1);

auriel_define_partial_fields(
  'partials/about-values.php',
  array(
    'fields' => array(
      'about_values_heading' => array(
        'type' => 'text',
        'label' => __('Values heading', AURIEL_THEME_TEXT_DOMAIN),
        'default' => __('Our promise to every traveller', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'about_values_intro' => array(
        'type' => 'textarea',
        'label' => __('Values intro', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 3,
        'default_callback' => 'auriel_about_values_default_intro',
      ),
      'about_values_items' => array(
        'type' => 'repeater',
        'label' => __('Values list', AURIEL_THEME_TEXT_DOMAIN),
        'button_label' => __('Add value', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_about_values_default_items',
        'fields' => array(
          'title' => array(
            'type' => 'text',
            'label' => __('Title', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'description' => array(
            'type' => 'textarea',
            'label' => __('Description', AURIEL_THEME_TEXT_DOMAIN),
            'rows' => 3,
          ),
        ),
      ),
    ),
  ),
  array(
    'title' => __('About Values', AURIEL_THEME_TEXT_DOMAIN),
  )
);

function auriel_about_values_default_intro(): string
{
  return __(
    'We are more than rental keys and fuel stops. From the first inquiry to the moment you hand the keys back, we stay focused on comfort, safety, and delightful detail.',
    AURIEL_THEME_TEXT_DOMAIN
  );
}

function auriel_about_values_default_items(): array
{
  return array(
    array(
      'title' => __('Personal guidance', AURIEL_THEME_TEXT_DOMAIN),
      'description' => __('Dedicated trip planners tailor each itinerary around your pace, family, and style.', AURIEL_THEME_TEXT_DOMAIN),
    ),
    array(
      'title' => __('Transparent pricing', AURIEL_THEME_TEXT_DOMAIN),
      'description' => __('No surprise fees—just clear daily rates and fair add-ons you can opt into.', AURIEL_THEME_TEXT_DOMAIN),
    ),
    array(
      'title' => __('Local partnerships', AURIEL_THEME_TEXT_DOMAIN),
      'description' => __('We collaborate with regional guides, farms, and artisans to enrich every journey.', AURIEL_THEME_TEXT_DOMAIN),
    ),
  );
}
