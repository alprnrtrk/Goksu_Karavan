<?php
declare(strict_types=1);

if (!defined('AURIEL_VITE_DIST_DIR')) {
  define('AURIEL_VITE_DIST_DIR', 'assets/dist');
}

if (!defined('AURIEL_VITE_DIST_URI')) {
  define(
    'AURIEL_VITE_DIST_URI',
    trailingslashit(get_template_directory_uri()) . AURIEL_VITE_DIST_DIR
  );
}

if (!defined('AURIEL_VITE_DIST_PATH')) {
  define(
    'AURIEL_VITE_DIST_PATH',
    trailingslashit(get_template_directory()) . AURIEL_VITE_DIST_DIR
  );
}

if (!defined('AURIEL_VITE_SERVER')) {
  define('AURIEL_VITE_SERVER', 'http://localhost:5173');
}

if (!defined('AURIEL_VITE_SCRIPT_HANDLE')) {
  define('AURIEL_VITE_SCRIPT_HANDLE', 'auriel-main');
}

if (!defined('AURIEL_VITE_STYLE_HANDLE')) {
  define('AURIEL_VITE_STYLE_HANDLE', 'auriel-main-style');
}

/**
 * Determine the current Vite mode.
 */
function auriel_vite_get_mode(): string
{
  static $mode = null;

  if ($mode !== null) {
    return $mode;
  }

  // 1. Geliştirici tarafından manuel override
  if (defined('AURIEL_VITE_MODE')) {
    $candidate = strtolower((string) AURIEL_VITE_MODE);
    if (in_array($candidate, ['dev', 'build'], true)) {
      $mode = $candidate;
      return $mode;
    }
  }

  // 2. Otomatik fallback: manifest varsa build, yoksa dev
  $mode = file_exists(AURIEL_VITE_DIST_PATH . '/.vite/manifest.json') ? 'build' : 'dev';
  return $mode;
}


/**
 * Determine whether we should load built assets.
 */
function auriel_vite_is_build(): bool
{
  return 'build' === auriel_vite_get_mode();
}

/**
 * Load and cache the Vite manifest.
 *
 * @return array<string,array<string,mixed>>
 */
function auriel_vite_get_manifest(): array
{
  static $manifest = null;

  if (null !== $manifest) {
    return $manifest;
  }

  $manifest = array();

  $manifest_path = AURIEL_VITE_DIST_PATH . '/.vite/manifest.json';
  if (file_exists($manifest_path)) {
    $decoded = json_decode(file_get_contents($manifest_path), true);
    if (is_array($decoded)) {
      $manifest = $decoded;
    }
  }

  return $manifest;
}

/**
 * Locate an entry inside the Vite manifest regardless of its key format.
 *
 * @param string $source Original source path (e.g. assets/src/js/main.js).
 *
 * @return array<string,mixed>
 */
function auriel_vite_find_manifest_entry(string $source): array
{
  $manifest = auriel_vite_get_manifest();
  $normalized_source = ltrim($source, './');

  foreach ($manifest as $key => $entry) {
    $entry_src = isset($entry['src']) ? ltrim((string) $entry['src'], './') : '';

    if ($entry_src === $normalized_source) {
      return $entry;
    }

    if (ltrim((string) $key, './') === $normalized_source) {
      return $entry;
    }
  }

  return array();
}

/**
 * Resolve a built asset URI via the manifest.
 */
function auriel_vite_resolve_asset_uri(string $source): string
{
  $entry = auriel_vite_find_manifest_entry($source);

  if (!empty($entry['file'])) {
    return AURIEL_VITE_DIST_URI . '/' . ltrim((string) $entry['file'], '/');
  }

  return '';
}

/**
 * Resolve additional CSS files emitted by a manifest entry.
 *
 * @param string $source Original entry path.
 *
 * @return array<int,string> URIs to enqueue.
 */
function auriel_vite_resolve_css_dependencies(string $source): array
{
  $entry = auriel_vite_find_manifest_entry($source);

  if (empty($entry['css']) || !is_array($entry['css'])) {
    return array();
  }

  return array_map(
    static function ($css_file): string {
      return AURIEL_VITE_DIST_URI . '/' . ltrim((string) $css_file, '/');
    },
    $entry['css']
  );
}

/**
 * Register and enqueue the Vite-powered assets.
 */
/**
 * Enqueue Vite assets properly for both dev and build modes.
 */
function auriel_enqueue_vite_assets(): void
{
  $js_entry = 'assets/src/js/main.js';
  $css_entry = 'assets/src/scss/main.scss';

  // DEV modunda Vite server'dan load et
  if (!auriel_vite_is_build()) {
    // DEV mod: Vite client (HMR) + ana JS + SCSS direkt Vite üzerinden
    wp_enqueue_script(
      'vite-client',
      AURIEL_VITE_SERVER . '/@vite/client',
      [],
      null,
      true
    );

    wp_enqueue_script(
      AURIEL_VITE_SCRIPT_HANDLE,
      AURIEL_VITE_SERVER . '/assets/src/js/main.js',
      [],
      null,
      true
    );

    // ✅ İşte eksik olan kısım: CSS'i dev modda da yükle!
    wp_enqueue_style(
      AURIEL_VITE_STYLE_HANDLE,
      AURIEL_VITE_SERVER . '/assets/src/scss/main.scss',
      [],
      null
    );

    return;
  }


  // BUILD modunda manifestten çözelim
  $resolved_js = auriel_vite_resolve_asset_uri($js_entry);
  if ($resolved_js) {
    wp_enqueue_script(
      AURIEL_VITE_SCRIPT_HANDLE,
      $resolved_js,
      [],
      null,
      true
    );
  }

  // CSS varsa manifestte onu da çek
  $css_dependencies = auriel_vite_resolve_css_dependencies($js_entry);
  foreach ($css_dependencies as $index => $css_uri) {
    wp_enqueue_style(
      AURIEL_VITE_STYLE_HANDLE . '-' . $index,
      $css_uri,
      [],
      null
    );
  }

  // Ek olarak SCSS entry build halinde farklı bundle oluyor, onu da çekebiliriz
  $resolved_css = auriel_vite_resolve_asset_uri($css_entry);
  if ($resolved_css) {
    wp_enqueue_style(
      AURIEL_VITE_STYLE_HANDLE,
      $resolved_css,
      [],
      null
    );
  }
}
add_action('wp_enqueue_scripts', 'auriel_enqueue_vite_assets', 100);

/**
 * Inject the Vite client while running in development mode.
 */
function auriel_vite_client_script(): void
{
  if (auriel_vite_is_build()) {
    return;
  }

  printf(
    '<script type="module" crossorigin src="%s/@vite/client"></script>' . PHP_EOL,
    esc_url(AURIEL_VITE_SERVER)
  );
}
add_action('wp_head', 'auriel_vite_client_script');

/**
 * Ensure Vite scripts are treated as ES modules during development.
 */
function auriel_vite_module_tag(string $tag, string $handle, string $src): string
{
  if (AURIEL_VITE_SCRIPT_HANDLE !== $handle) {
    return $tag;
  }

  $attributes = array(
    'type="module"',
    sprintf('src="%s"', esc_url($src)),
  );

  if (!auriel_vite_is_build()) {
    $attributes[] = 'crossorigin="anonymous"';
  }

  return sprintf('<script %s></script>', implode(' ', $attributes));
}

add_filter('script_loader_tag', 'auriel_vite_module_tag', 10, 3);
