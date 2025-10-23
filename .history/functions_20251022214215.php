<?php
declare(strict_types=1);

if (!defined('AURIEL_THEME_TEXT_DOMAIN')) {
  define('AURIEL_THEME_TEXT_DOMAIN', 'auriel-theme');
}

if (!defined('AURIEL_THEME_SETTINGS_PAGE_SLUG')) {
  define('AURIEL_THEME_SETTINGS_PAGE_SLUG', 'auriel-theme-settings');
}

$functions_dir = get_template_directory() . '/inc/functions';
if (is_dir($functions_dir)) {
  $function_files = glob(trailingslashit($functions_dir) . '*.php');
  if (false !== $function_files) {
    sort($function_files);
    foreach ($function_files as $function_file) {
      if (is_file($function_file)) {
        require_once $function_file;
      }
    }
  }
}

require_once get_template_directory() . '/inc/vite.php';
require_once get_template_directory() . '/inc/theme-options.php';
require_once get_template_directory() . '/inc/partials/core.php';
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

/**
 * Templates that should hide the default content editor.
 *
 * @return array<int, string>
 */
function auriel_theme_editorless_templates(): array
{
  return array(
    'templates/page-home.php',
    'templates/page-about.php',
    'templates/page-contact.php',
  );
}

/**
 * Determine whether the editor should be disabled for a given post.
 */
function auriel_theme_should_disable_editor(int $post_id): bool
{
  if ($post_id <= 0) {
    return false;
  }

  $template = get_page_template_slug($post_id);
  if ('' === $template) {
    $template = get_post_meta($post_id, '_wp_page_template', true);
  }

  return in_array($template, auriel_theme_editorless_templates(), true);
}

/**
 * Disable the block editor for selected templates.
 *
 * @param bool     $use_block_editor Whether Gutenberg should load.
 * @param WP_Post  $post             The post being edited.
 */
function auriel_theme_filter_block_editor($use_block_editor, $post)
{
  if ($post instanceof WP_Post && 'page' === $post->post_type && auriel_theme_should_disable_editor((int) $post->ID)) {
    return false;
  }

  return $use_block_editor;
}
add_filter('use_block_editor_for_post', 'auriel_theme_filter_block_editor', 10, 2);

/**
 * Remove the classic editor when a template does not use content.
 */
function auriel_theme_maybe_remove_classic_editor(): void
{
  $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
  if (0 === $post_id && isset($_POST['post_ID'])) {
    $post_id = (int) $_POST['post_ID'];
  }

  if ($post_id > 0 && auriel_theme_should_disable_editor($post_id)) {
    remove_post_type_support('page', 'editor');
  } else {
    add_post_type_support('page', 'editor');
  }
}
add_action('load-post.php', 'auriel_theme_maybe_remove_classic_editor');
add_action('load-post-new.php', 'auriel_theme_maybe_remove_classic_editor');
