<?php
declare(strict_types=1);

auriel_define_partial_fields(
  'partials/contact-details.php',
  array(
    'fields' => array(
      'contact_heading' => array(
        'type' => 'text',
        'label' => __('Contact heading', AURIEL_THEME_TEXT_DOMAIN),
        'default' => __('Let’s plan your next journey', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'contact_intro' => array(
        'type' => 'textarea',
        'label' => __('Contact intro', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 3,
        'default_callback' => 'auriel_contact_default_intro',
      ),
      'contact_email' => array(
        'type' => 'text',
        'label' => __('Email address', AURIEL_THEME_TEXT_DOMAIN),
        'default' => 'hello@goksukaravan.com',
      ),
      'contact_phone' => array(
        'type' => 'text',
        'label' => __('Phone number', AURIEL_THEME_TEXT_DOMAIN),
        'default' => '+90 312 123 45 67',
      ),
      'contact_address' => array(
        'type' => 'textarea',
        'label' => __('Address', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 2,
        'default' => __('Atat&uuml;rk Blv. No:101, Ankara, T&uuml;rkiye', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'contact_hours' => array(
        'type' => 'textarea',
        'label' => __('Office hours', AURIEL_THEME_TEXT_DOMAIN),
        'rows' => 2,
        'default' => __('Open daily 09:00 – 18:00 (GMT+3)', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'contact_cta_label' => array(
        'type' => 'text',
        'label' => __('Secondary CTA label', AURIEL_THEME_TEXT_DOMAIN),
        'default' => __('View availability', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'contact_cta_url' => array(
        'type' => 'url',
        'label' => __('Secondary CTA URL', AURIEL_THEME_TEXT_DOMAIN),
        'default_callback' => 'auriel_contact_default_cta_url',
      ),
    ),
  ),
  array(
    'title' => __('Contact Details', AURIEL_THEME_TEXT_DOMAIN),
  )
);

function auriel_contact_default_intro(): string
{
  return __(
    'Reach out for availability, route advice, or fleet questions. Our Ankara base is ready to kit your caravan and guide you before every departure.',
    AURIEL_THEME_TEXT_DOMAIN
  );
}

function auriel_contact_default_cta_url(): string
{
  return home_url('/availability');
}
