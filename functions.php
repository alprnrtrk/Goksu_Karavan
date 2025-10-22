<?php
declare(strict_types=1);

if (!defined('AURIEL_THEME_TEXT_DOMAIN')) {
  define('AURIEL_THEME_TEXT_DOMAIN', 'auriel-theme');
}

if (!defined('AURIEL_THEME_SETTINGS_PAGE_SLUG')) {
  define('AURIEL_THEME_SETTINGS_PAGE_SLUG', 'auriel-theme-settings');
}

require_once get_template_directory() . '/inc/vite.php';
require_once get_template_directory() . '/inc/theme-options.php';
require_once get_template_directory() . '/inc/partial-fields.php';

function auriel_theme_setup(): void
{
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('menus');
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
      'navigation-widgets',
    )
  );

  add_theme_support(
    'custom-logo',
    array(
      'height' => 48,
      'width' => 48,
      'flex-height' => true,
      'flex-width' => true,
    )
  );

  register_nav_menus(
    array(
      'primary' => __('Primary Menu', AURIEL_THEME_TEXT_DOMAIN),
      'footer' => __('Footer Menu', AURIEL_THEME_TEXT_DOMAIN),
    )
  );
}
add_action('after_setup_theme', 'auriel_theme_setup');

/**
 * Render a navigation menu or a page list fallback.
 *
 * @param string $location Registered menu location slug.
 * @param array<string,mixed> $args Optional overrides for wp_nav_menu.
 */
function auriel_theme_render_menu(string $location, array $args = array()): void
{
  $defaults = array(
    'theme_location' => $location,
    'container' => '',
    'menu_id' => $location . '-menu',
    'menu_class' => 'menu',
    'depth' => 2,
    'fallback_cb' => false,
  );

  $args = wp_parse_args($args, $defaults);

  if (has_nav_menu($location)) {
    wp_nav_menu($args);
    return;
  }

  $pages = get_pages(
    array(
      'sort_column' => 'menu_order',
      'post_status' => 'publish',
    )
  );

  if (empty($pages)) {
    return;
  }

  $menu_class = isset($args['menu_class']) ? (string) $args['menu_class'] : 'flex gap-4';
  $menu_id = isset($args['menu_id']) ? (string) $args['menu_id'] : '';

  echo '<ul';
  if ('' !== $menu_id) {
    echo ' id="' . esc_attr($menu_id) . '"';
  }
  echo ' class="' . esc_attr($menu_class) . '">';

  foreach ($pages as $page) {
    echo '<li class="menu-item hover:text-primary transition"><a href="' . esc_url(get_permalink($page)) . '">' . esc_html(get_the_title($page)) . '</a></li>';
  }

  echo '</ul>';
}
