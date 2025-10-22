<?php
declare(strict_types=1);

auriel_define_partial_fields(
  'partials/home-feature-grid.php',
  array(
    'fields' => array(
      'home_feature_heading' => array(
        'type' => 'text',
        'label' => __('Feature section heading', AURIEL_THEME_TEXT_DOMAIN),
        'default' => __('Why travellers choose G&ouml;ksu Karavan', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'home_feature_intro' => array(
        'type' => 'textarea',
        'label' => __('Feature section intro', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 3,
        'default_callback' => 'auriel_home_feature_default_intro',
      ),
      'home_feature_items' => array(
        'type' => 'repeater',
        'label' => __('Feature items', AURIEL_THEME_TEXT_DOMAIN),
        'button_label' => __('Add feature', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_home_feature_default_items',
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
          'icon' => array(
            'type' => 'text',
            'label' => __('Icon/emoji', AURIEL_THEME_TEXT_DOMAIN),
            'default' => '✨',
          ),
        ),
      ),
    ),
  ),
  array(
    'title' => __('Home Feature Grid', AURIEL_THEME_TEXT_DOMAIN),
  )
);

function auriel_home_feature_default_intro(): string
{
  return __(
    'Every caravan is serviced after each trip, stocked with local essentials, and supported by a 24/7 helpline so you can roam with confidence.',
    AURIEL_THEME_TEXT_DOMAIN
  );
}

function auriel_home_feature_default_items(): array
{
  return array(
    array(
      'title' => __('Flexible itineraries', AURIEL_THEME_TEXT_DOMAIN),
      'description' => __('Pick a curated route or build your own adventure with our trip planners.', AURIEL_THEME_TEXT_DOMAIN),
      'icon' => '🗺️',
    ),
    array(
      'title' => __('Fully equipped vans', AURIEL_THEME_TEXT_DOMAIN),
      'description' => __('Premium bedding, compact kitchens, and smart storage keep comfort effortless.', AURIEL_THEME_TEXT_DOMAIN),
      'icon' => '🚐',
    ),
    array(
      'title' => __('Local expertise', AURIEL_THEME_TEXT_DOMAIN),
      'description' => __('Insider tips on campsites, hidden beaches, and regional cuisine await every booking.', AURIEL_THEME_TEXT_DOMAIN),
      'icon' => '📍',
    ),
  );
}
