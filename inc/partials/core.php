<?php
declare(strict_types=1);

final class Auriel_Partial_Registry
{
  /**
   * @var array<string, array<string, mixed>>
   */
  private static array $partials = array();

  public static function register(string $slug, array $config): void
  {
    $slug = sanitize_key($slug);
    if ('' === $slug) {
      return;
    }

    $defaults = array(
      'slug' => $slug,
      'title' => ucwords(str_replace('-', ' ', $slug)),
      'description' => '',
      'post_types' => array('page'),
      'fields' => array(),
      'templates' => array(),
    );

    $config = wp_parse_args($config, $defaults);
    $config['slug'] = $slug;
    $config['post_types'] = array_values(array_filter(array_unique(array_map('sanitize_key', (array) $config['post_types']))));
    $config['fields'] = is_array($config['fields']) ? $config['fields'] : array();
    $config['templates'] = array_values(array_filter(array_map('sanitize_text_field', (array) $config['templates'])));

    self::$partials[$slug] = $config;
  }

  /**
   * @return array<string, array<string, mixed>>
   */
  public static function all(): array
  {
    return self::$partials;
  }

  /**
   * @return array<string, mixed>
   */
  public static function get(string $slug): array
  {
    return self::$partials[$slug] ?? array();
  }
}

function auriel_partials_register(string $slug, array $config): void
{
  Auriel_Partial_Registry::register($slug, $config);
}

function auriel_partials_meta_key(string $slug, string $field_key): string
{
  return 'auriel_partial_' . sanitize_key($slug) . '_' . sanitize_key($field_key);
}

function auriel_partials_nonce_name(string $slug): string
{
  return 'auriel_partials_nonce_' . sanitize_key($slug);
}

function auriel_partials_nonce_action(string $slug): string
{
  return 'auriel_partials_save_' . sanitize_key($slug);
}

add_action('add_meta_boxes', 'auriel_partials_register_meta_boxes', 10, 2);
function auriel_partials_register_meta_boxes(string $post_type, $post): void
{
  $post_id = $post instanceof WP_Post ? (int) $post->ID : 0;

  foreach (Auriel_Partial_Registry::all() as $slug => $partial) {
    $post_types = !empty($partial['post_types']) ? $partial['post_types'] : array('page');

    if (!in_array($post_type, $post_types, true)) {
      continue;
    }

    if (!auriel_partials_should_display_meta_box_for_post($slug, $partial, $post_id)) {
      continue;
    }

    add_meta_box(
      'auriel-partial-' . $slug,
      (string) ($partial['title'] ?? ucwords(str_replace('-', ' ', $slug))),
      'auriel_partials_render_meta_box',
      $post_type,
      'normal',
      'default',
      array(
        'slug' => $slug,
      )
    );
  }
}

/**
 * @param array<string, mixed> $box
 */
function auriel_partials_render_meta_box(WP_Post $post, array $box): void
{
  $slug = isset($box['args']['slug']) ? (string) $box['args']['slug'] : '';
  $partial = Auriel_Partial_Registry::get($slug);

  if ('' === $slug || empty($partial)) {
    return;
  }

  if (!auriel_partials_should_display_meta_box_for_post($slug, $partial, (int) $post->ID)) {
    return;
  }

  wp_nonce_field(auriel_partials_nonce_action($slug), auriel_partials_nonce_name($slug));

  $fields = is_array($partial['fields']) ? $partial['fields'] : array();
  $values = auriel_partials_get_fields($slug, (int) $post->ID);

  echo '<div class="auriel-partials-meta" data-partial-meta data-partial="' . esc_attr($slug) . '">';

  if (!empty($partial['description'])) {
    echo '<p class="description">' . esc_html((string) $partial['description']) . '</p>';
  }

  foreach ($fields as $field_key => $field_config) {
    $value = $values[$field_key] ?? null;
    auriel_partials_render_field($slug, (string) $field_key, (array) $field_config, $value);
  }

  echo '</div>';

  wp_enqueue_media();
  auriel_partials_enqueue_admin_assets();
}

/**
 * @param array<string, mixed> $field
 * @param mixed                $value
 */
function auriel_partials_render_field(string $slug, string $field_key, array $field, $value): void
{
  $type = isset($field['type']) ? (string) $field['type'] : 'text';
  $label = isset($field['label']) ? (string) $field['label'] : ucwords(str_replace('_', ' ', $field_key));
  $instructions = isset($field['instructions']) ? (string) $field['instructions'] : '';
  $name = 'auriel_partials[' . esc_attr($slug) . '][' . esc_attr($field_key) . ']';
  $id = 'auriel-partials-' . sanitize_key($slug) . '-' . sanitize_key($field_key);

  echo '<div class="auriel-partials-field auriel-partials-field--' . esc_attr($type) . '" data-field-type="' . esc_attr($type) . '">';
  echo '<label class="auriel-partials-label" for="' . esc_attr($id) . '">' . esc_html($label) . '</label>';

  switch ($type) {
    case 'textarea':
      $rows = isset($field['rows']) ? (int) $field['rows'] : 4;
      echo '<textarea class="widefat auriel-partials-input" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" rows="' . max(2, $rows) . '">' . esc_textarea(is_string($value) ? $value : '') . '</textarea>';
      break;

    case 'url':
      echo '<input type="url" class="widefat auriel-partials-input" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr(is_string($value) ? $value : '') . '" />';
      break;

    case 'media':
      $media_value = auriel_partials_normalize_media_value($value);
      $encoded_value = auriel_partials_encode_media_value($media_value);
      $media_placeholder_text = __('No media selected', AURIEL_THEME_TEXT_DOMAIN);
      $media_image_label_text = __('Image', AURIEL_THEME_TEXT_DOMAIN);
      $media_video_label_text = __('Video', AURIEL_THEME_TEXT_DOMAIN);
      $media_video_fallback_text = __('Video selected', AURIEL_THEME_TEXT_DOMAIN);
      $meta_label = '';
      if (!empty($media_value)) {
        $label_prefix = 'image' === ($media_value['type'] ?? '')
          ? $media_image_label_text
          : $media_video_label_text;
        $title = isset($media_value['title']) ? (string) $media_value['title'] : '';
        $meta_label = '' !== $title ? $label_prefix . ': ' . $title : $label_prefix;
      }
      echo '<div class="auriel-partials-media" data-partial-media data-media-placeholder="' . esc_attr($media_placeholder_text) . '" data-media-image-label="' . esc_attr($media_image_label_text) . '" data-media-video-label="' . esc_attr($media_video_label_text) . '" data-media-video-fallback="' . esc_attr($media_video_fallback_text) . '">';
      echo '<input type="hidden" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr($encoded_value) . '" data-media-input />';
      echo '<div class="auriel-partials-media-preview" data-media-preview>' . wp_kses_post(auriel_partials_media_preview_markup($media_value)) . '</div>';
      echo '<div class="auriel-partials-media-actions">';
      echo '<button type="button" class="button" data-media-select>' . esc_html__('Select media', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '<button type="button" class="button button-link-delete" data-media-remove>' . esc_html__('Remove media', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '</div>';
      echo '<p class="description auriel-partials-media-meta" data-media-meta>' . esc_html($meta_label) . '</p>';
      echo '</div>';
      break;

    case 'image':
      $image_id = (int) $value;
      $preview = '';
      if ($image_id > 0) {
        $preview = wp_get_attachment_image($image_id, 'thumbnail', false, array('class' => 'auriel-partials-image-preview'));
      }
      echo '<div class="auriel-partials-image" data-partial-image>';
      echo '<input type="hidden" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr((string) $image_id) . '" data-image-input />';
      echo '<div class="auriel-partials-image-preview" data-image-preview>' . wp_kses_post($preview) . '</div>';
      echo '<div class="auriel-partials-image-actions">';
      echo '<button type="button" class="button" data-image-select>' . esc_html__('Select image', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '<button type="button" class="button button-link-delete" data-image-remove>' . esc_html__('Remove image', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '</div>';
      echo '</div>';
      break;

    case 'gallery':
      $image_ids = auriel_partials_normalize_gallery_value($value);
      auriel_partials_render_gallery_control($name, $id, $image_ids);
      break;

    case 'editor':
      $content = is_string($value) ? $value : '';
      wp_editor(
        $content,
        $id,
        array(
          'textarea_name' => $name,
          'textarea_rows' => isset($field['rows']) ? (int) $field['rows'] : 8,
        )
      );
      break;

    case 'repeater':
      $items = array();
      if (is_array($value)) {
        $items = $value;
      }

      if (empty($items)) {
        $items[] = array();
      }

      $sub_fields = isset($field['fields']) && is_array($field['fields']) ? $field['fields'] : array();
      $button_label = isset($field['add_button_label']) ? (string) $field['add_button_label'] : __('Add item', AURIEL_THEME_TEXT_DOMAIN);

      echo '<div class="auriel-partials-repeater" data-partial-repeater data-field="' . esc_attr($field_key) . '">';
      echo '<div class="auriel-partials-repeater-items" data-repeater-items>';

      foreach ($items as $index => $item) {
        auriel_partials_render_repeater_item($slug, $field_key, (int) $index, $sub_fields, is_array($item) ? $item : array());
      }

      echo '</div>';
      echo '<button type="button" class="button" data-repeater-add>' . esc_html($button_label) . '</button>';

      $template_html = auriel_partials_capture_repeater_item($slug, $field_key, '__INDEX__', $sub_fields);
      echo '<script type="text/template" data-repeater-template>' . $template_html . '</script>';
      echo '</div>';
      break;

    default: // text
      echo '<input type="text" class="widefat auriel-partials-input" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr(is_string($value) ? $value : '') . '" />';
      break;
  }

  if ('' !== $instructions) {
    echo '<p class="description">' . esc_html($instructions) . '</p>';
  }

  echo '</div>';
}

/**
 * @param mixed $value
 * @return array<int>
 */
function auriel_partials_normalize_gallery_value($value): array
{
  if (is_array($value)) {
    $source = $value;
  } elseif (is_string($value)) {
    $source = array_filter(array_map('trim', explode(',', $value)));
  } else {
    $source = array();
  }

  $ids = array();

  foreach ($source as $maybe_id) {
    $id = (int) $maybe_id;
    if ($id <= 0) {
      continue;
    }
    if (in_array($id, $ids, true)) {
      continue;
    }
    $ids[] = $id;
  }

  return $ids;
}

/**
 * @param array<int> $image_ids
 */
function auriel_partials_render_gallery_control(string $input_name, string $input_id, array $image_ids): void
{
  $image_ids = array_values(array_filter(array_map('intval', $image_ids)));

  echo '<div class="auriel-partials-gallery" data-partial-gallery>';

  $attributes = '';
  if ('' !== $input_id) {
    $attributes = ' id="' . esc_attr($input_id) . '"';
  }

  echo '<input type="hidden"' . $attributes . ' name="' . esc_attr($input_name) . '" value="' . esc_attr(implode(',', $image_ids)) . '" data-gallery-input />';
  echo '<div class="auriel-partials-gallery-list" data-gallery-list>';

  foreach ($image_ids as $image_id) {
    $thumb_src = wp_get_attachment_image_url($image_id, 'thumbnail');
    $thumb_src = is_string($thumb_src) ? $thumb_src : '';

    $alt_text = trim((string) get_post_meta($image_id, '_wp_attachment_image_alt', true));
    if ('' === $alt_text) {
      $alt_text = get_the_title($image_id);
    }
    $alt_text = is_string($alt_text) ? $alt_text : '';

    echo '<div class="auriel-partials-gallery-item" data-gallery-item="1" data-image-id="' . esc_attr((string) $image_id) . '"';
    if ('' !== $thumb_src) {
      echo ' data-thumb-src="' . esc_url($thumb_src) . '"';
    }
    if ('' !== $alt_text) {
      echo ' data-thumb-alt="' . esc_attr($alt_text) . '"';
    }
    echo '>';
    echo '<div class="auriel-partials-gallery-thumb">';
    if ('' !== $thumb_src) {
      echo '<img src="' . esc_url($thumb_src) . '" alt="' . esc_attr($alt_text) . '" class="auriel-partials-gallery-thumb-img" />';
    }
    echo '</div>';
    echo '<div class="auriel-partials-gallery-item-actions">';
    echo '<button type="button" class="button button-small" data-gallery-move-up>' . esc_html__('Move up', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
    echo '<button type="button" class="button button-small" data-gallery-move-down>' . esc_html__('Move down', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
    echo '<button type="button" class="button button-link-delete" data-gallery-remove>' . esc_html__('Remove', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
    echo '</div>';
    echo '</div>';
  }

  echo '</div>';
  echo '<div class="auriel-partials-gallery-actions">';
  echo '<button type="button" class="button" data-gallery-select>' . esc_html__('Manage images', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
  echo '<button type="button" class="button" data-gallery-add>' . esc_html__('Add images', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
  echo '<button type="button" class="button button-link-delete" data-gallery-clear>' . esc_html__('Clear gallery', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
  echo '</div>';
  echo '</div>';
}

/**
 * Normalize the stored value for a media field to a rich associative array.
 *
 * @param mixed $value
 * @return array<string, mixed>
 */
function auriel_partials_normalize_media_value($value): array
{
  if (is_string($value)) {
    if (function_exists('wp_unslash')) {
      $value = wp_unslash($value);
    }
    $decoded = json_decode($value, true);
    if (is_array($decoded)) {
      $value = $decoded;
    } elseif ('' !== trim($value)) {
      $value = array('id' => (int) $value);
    }
  }

  if (!is_array($value)) {
    return array();
  }

  $attachment_id = isset($value['id']) ? (int) $value['id'] : 0;
  if ($attachment_id <= 0) {
    return array();
  }

  $attachment = get_post($attachment_id);
  if (!$attachment instanceof WP_Post || 'attachment' !== $attachment->post_type) {
    return array();
  }

  $mime_type = get_post_mime_type($attachment_id);
  $mime_type = is_string($mime_type) ? $mime_type : '';

  $type = isset($value['type']) ? (string) $value['type'] : '';
  if ('' === $type) {
    if (wp_attachment_is_image($attachment_id)) {
      $type = 'image';
    } elseif (0 === strpos($mime_type, 'video/')) {
      $type = 'video';
    }
  }

  if ('image' !== $type && 'video' !== $type) {
    return array();
  }

  $url = wp_get_attachment_url($attachment_id);
  $url = is_string($url) ? $url : '';

  $thumbnail = '';
  if ('image' === $type) {
    $thumbnail = wp_get_attachment_image_url($attachment_id, 'medium');
    if (!is_string($thumbnail) || '' === $thumbnail) {
      $thumbnail = wp_get_attachment_image_url($attachment_id, 'thumbnail');
    }
  } else {
    $thumbnail = get_the_post_thumbnail_url($attachment_id, 'medium');
    if (!is_string($thumbnail) || '' === $thumbnail) {
      $icon = wp_mime_type_icon($attachment_id);
      $thumbnail = is_string($icon) ? $icon : '';
    }
  }

  $title = get_the_title($attachment_id);
  $title = is_string($title) ? $title : '';

  return array(
    'id' => $attachment_id,
    'type' => $type,
    'mime_type' => $mime_type,
    'title' => $title,
    'url' => $url,
    'thumbnail_url' => is_string($thumbnail) ? $thumbnail : '',
  );
}

/**
 * Reduce a normalized media value to the subset of data we persist.
 *
 * @param array<string, mixed> $media
 * @return array<string, mixed>
 */
function auriel_partials_compact_media_value(array $media): array
{
  if (empty($media) || empty($media['id']) || empty($media['type'])) {
    return array();
  }

  return array(
    'id' => (int) $media['id'],
    'type' => (string) $media['type'],
  );
}

/**
 * @param array<string, mixed> $media
 */
function auriel_partials_media_preview_markup(array $media): string
{
  if (empty($media)) {
    return '<div class="auriel-partials-media-placeholder">' . esc_html__('No media selected', AURIEL_THEME_TEXT_DOMAIN) . '</div>';
  }

  if ('image' === ($media['type'] ?? '')) {
    $attachment_id = (int) ($media['id'] ?? 0);
    if ($attachment_id > 0) {
      $image = wp_get_attachment_image(
        $attachment_id,
        'medium',
        false,
        array('class' => 'auriel-partials-media-preview-image')
      );
      if (!empty($image)) {
        return $image;
      }
    }
  }

  if ('video' === ($media['type'] ?? '')) {
    $thumbnail = isset($media['thumbnail_url']) ? (string) $media['thumbnail_url'] : '';
    if ('' !== $thumbnail) {
      return '<img src="' . esc_url($thumbnail) . '" alt="" class="auriel-partials-media-preview-video-thumb" />';
    }

    $title = isset($media['title']) ? (string) $media['title'] : __('Selected video', AURIEL_THEME_TEXT_DOMAIN);
    return '<div class="auriel-partials-media-placeholder auriel-partials-media-placeholder--video">' . esc_html($title) . '</div>';
  }

  return '<div class="auriel-partials-media-placeholder">' . esc_html__('Unsupported media selection', AURIEL_THEME_TEXT_DOMAIN) . '</div>';
}

/**
 * @param array<string, mixed> $media
 */
function auriel_partials_encode_media_value(array $media): string
{
  $compact = auriel_partials_compact_media_value($media);
  if (empty($compact)) {
    return '';
  }

  return (string) wp_json_encode($compact);
}

/**
 * @param array<string, array<string, mixed>> $fields
 * @param array<string, mixed>                $values
 */
function auriel_partials_render_repeater_item(string $slug, string $field_key, int $index, array $fields, array $values): void
{
  $index_attr = (string) $index;
  echo '<div class="auriel-partials-repeater-item" data-repeater-item>';
  foreach ($fields as $sub_key => $sub_field) {
    $sub_value = $values[$sub_key] ?? '';
    auriel_partials_render_repeater_field($slug, $field_key, $index_attr, (string) $sub_key, (array) $sub_field, $sub_value);
  }
  echo '<div class="auriel-partials-repeater-item-actions">';
  echo '<button type="button" class="button button-link-delete" data-repeater-remove>' . esc_html__('Remove item', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
  echo '</div>';
  echo '<hr />';
  echo '</div>';
}

/**
 * @param array<string, array<string, mixed>> $fields
 */
function auriel_partials_capture_repeater_item(string $slug, string $field_key, string $index_placeholder, array $fields): string
{
  ob_start();
  auriel_partials_render_repeater_item($slug, $field_key, 0, $fields, array());
  $html = (string) ob_get_clean();

  return str_replace('[0]', '[' . $index_placeholder . ']', $html);
}

/**
 * @param array<string, mixed> $field
 * @param mixed                $value
 */
function auriel_partials_render_repeater_field(string $slug, string $field_key, string $index, string $sub_key, array $field, $value): void
{
  $type = isset($field['type']) ? (string) $field['type'] : 'text';
  $label = isset($field['label']) ? (string) $field['label'] : ucwords(str_replace('_', ' ', $sub_key));
  $name = 'auriel_partials[' . esc_attr($slug) . '][' . esc_attr($field_key) . '][' . esc_attr($index) . '][' . esc_attr($sub_key) . ']';

  echo '<div class="auriel-partials-field auriel-partials-field--' . esc_attr($type) . ' auriel-partials-field--sub" data-field-type="' . esc_attr($type) . '">';
  echo '<label class="auriel-partials-label">' . esc_html($label) . '</label>';

  switch ($type) {
    case 'textarea':
      $rows = isset($field['rows']) ? (int) $field['rows'] : 3;
      echo '<textarea class="widefat auriel-partials-input" name="' . esc_attr($name) . '" rows="' . max(2, $rows) . '">' . esc_textarea(is_string($value) ? $value : '') . '</textarea>';
      break;

    case 'url':
      echo '<input type="url" class="widefat auriel-partials-input" name="' . esc_attr($name) . '" value="' . esc_attr(is_string($value) ? $value : '') . '" />';
      break;

    case 'media':
      $media_value = auriel_partials_normalize_media_value($value);
      $encoded_value = auriel_partials_encode_media_value($media_value);
      $media_placeholder_text = __('No media selected', AURIEL_THEME_TEXT_DOMAIN);
      $media_image_label_text = __('Image', AURIEL_THEME_TEXT_DOMAIN);
      $media_video_label_text = __('Video', AURIEL_THEME_TEXT_DOMAIN);
      $media_video_fallback_text = __('Video selected', AURIEL_THEME_TEXT_DOMAIN);
      echo '<div class="auriel-partials-media" data-partial-media data-media-placeholder="' . esc_attr($media_placeholder_text) . '" data-media-image-label="' . esc_attr($media_image_label_text) . '" data-media-video-label="' . esc_attr($media_video_label_text) . '" data-media-video-fallback="' . esc_attr($media_video_fallback_text) . '">';
      echo '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($encoded_value) . '" data-media-input />';
      echo '<div class="auriel-partials-media-preview" data-media-preview>' . wp_kses_post(auriel_partials_media_preview_markup($media_value)) . '</div>';
      echo '<div class="auriel-partials-media-actions">';
      echo '<button type="button" class="button" data-media-select>' . esc_html__('Select media', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '<button type="button" class="button button-link-delete" data-media-remove>' . esc_html__('Remove media', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '</div>';
      echo '<p class="description auriel-partials-media-meta" data-media-meta>';
      if (!empty($media_value)) {
        $label_prefix = 'image' === ($media_value['type'] ?? '')
          ? $media_image_label_text
          : $media_video_label_text;
        $title = isset($media_value['title']) ? (string) $media_value['title'] : '';
        $meta_label = '' !== $title ? $label_prefix . ': ' . $title : $label_prefix;
        echo esc_html($meta_label);
      }
      echo '</p>';
      echo '</div>';
      break;

    case 'image':
      $image_id = (int) $value;
      $preview = '';
      if ($image_id > 0) {
        $preview = wp_get_attachment_image($image_id, 'thumbnail', false, array('class' => 'auriel-partials-image-preview'));
      }
      echo '<div class="auriel-partials-image" data-partial-image>';
      echo '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr((string) $image_id) . '" data-image-input />';
      echo '<div class="auriel-partials-image-preview" data-image-preview>' . wp_kses_post($preview) . '</div>';
      echo '<div class="auriel-partials-image-actions">';
      echo '<button type="button" class="button" data-image-select>' . esc_html__('Select image', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '<button type="button" class="button button-link-delete" data-image-remove>' . esc_html__('Remove image', AURIEL_THEME_TEXT_DOMAIN) . '</button>';
      echo '</div>';
      echo '</div>';
      break;

    case 'gallery':
      $gallery_ids = auriel_partials_normalize_gallery_value($value);
      auriel_partials_render_gallery_control($name, '', $gallery_ids);
      break;

    default:
      echo '<input type="text" class="widefat auriel-partials-input" name="' . esc_attr($name) . '" value="' . esc_attr(is_string($value) ? $value : '') . '" />';
      break;
  }

  if (!empty($field['instructions'])) {
    echo '<p class="description">' . esc_html((string) $field['instructions']) . '</p>';
  }

  echo '</div>';
}

/**
 * Resolve the template assigned to a post.
 */
function auriel_partials_get_post_template(int $post_id): string
{
  if ($post_id <= 0) {
    return '';
  }

  $template = get_page_template_slug($post_id);
  if (!is_string($template) || '' === $template || 'default' === $template) {
    $stored = get_post_meta($post_id, '_wp_page_template', true);
    $template = is_string($stored) ? $stored : '';
  }

  if (isset($_GET['page_template'])) {
    $requested = sanitize_text_field((string) $_GET['page_template']);
    if ('' !== $requested && 'default' !== $requested) {
      $template = $requested;
    }
  } elseif (isset($_POST['page_template'])) {
    $requested = sanitize_text_field((string) $_POST['page_template']);
    if ('' !== $requested && 'default' !== $requested) {
      $template = $requested;
    }
  }

  if ('default' === $template) {
    $template = '';
  }

  return $template;
}

/**
 * Check whether a partial should display for a specific post.
 *
 * @param array<string, mixed> $partial
 */
function auriel_partials_should_display_meta_box_for_post(string $slug, array $partial, int $post_id): bool
{
  $templates = isset($partial['templates']) && is_array($partial['templates']) ? array_filter($partial['templates']) : array();

  $template = auriel_partials_get_post_template($post_id);

  if (empty($templates)) {
    if ('' === $template) {
      return false;
    }

    $template_path = auriel_partials_locate_template_path($template);
    if ('' === $template_path) {
      return false;
    }

    return auriel_partials_template_includes_slug($template_path, $slug);
  }

  if ('' === $template) {
    return false;
  }

  return in_array($template, $templates, true);
}

function auriel_partials_locate_template_path(string $template): string
{
  if ('' === $template) {
    return '';
  }

  $located = locate_template(array($template), false, false);

  return is_string($located) ? $located : '';
}

function auriel_partials_template_includes_slug(string $template_path, string $slug): bool
{
  static $cache = array();

  $cache_key = $template_path . '::' . $slug;
  if (isset($cache[$cache_key])) {
    return $cache[$cache_key];
  }

  if (!is_readable($template_path)) {
    $cache[$cache_key] = false;
    return false;
  }

  $contents = file_get_contents($template_path);
  if (false === $contents) {
    $cache[$cache_key] = false;
    return false;
  }

  $partial_pattern = preg_quote('partials/' . $slug, '/');
  $slug_pattern = preg_quote($slug, '/');

  $patterns = array(
    sprintf('/get_template_part\s*\(\s*[\'"]%s[\'"]/', $partial_pattern),
    sprintf('/get_template_part\s*\(\s*[\'"]%s\.php[\'"]/', $partial_pattern),
    sprintf('/get_template_part\s*\(\s*[\'"]partials[\'"]\s*,\s*[\'"]%s[\'"]/', $slug_pattern),
    sprintf('/locate_template\s*\([^;]*%s\.php/', $partial_pattern),
    sprintf('/include\s+[^;]*[\'"]%s\.php[\'"]/', $partial_pattern),
    sprintf('/require\s+[^;]*[\'"]%s\.php[\'"]/', $partial_pattern),
  );

  $found = false;
  foreach ($patterns as $pattern) {
    if (preg_match($pattern, $contents)) {
      $found = true;
      break;
    }
  }

  $cache[$cache_key] = $found;
  return $found;
}

function auriel_partials_enqueue_admin_assets(): void
{
  static $enqueued = false;

  if ($enqueued) {
    return;
  }

  $script_path = get_template_directory() . '/assets/admin/partial-manager.js';
  if (file_exists($script_path)) {
    wp_enqueue_script(
      'auriel-partials-admin',
      get_template_directory_uri() . '/assets/admin/partial-manager.js',
      array(),
      (string) filemtime($script_path),
      true
    );
  }

  $style_path = get_template_directory() . '/assets/admin/partial-manager.css';
  if (file_exists($style_path)) {
    wp_enqueue_style(
      'auriel-partials-admin',
      get_template_directory_uri() . '/assets/admin/partial-manager.css',
      array(),
      (string) filemtime($style_path)
    );
  }

  $enqueued = true;
}

add_action('save_post', 'auriel_partials_handle_save');
function auriel_partials_handle_save(int $post_id): void
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
    return;
  }

  foreach (Auriel_Partial_Registry::all() as $slug => $partial) {
    $nonce_name = auriel_partials_nonce_name($slug);
    if (!isset($_POST[$nonce_name])) {
      continue;
    }

    if (!wp_verify_nonce((string) $_POST[$nonce_name], auriel_partials_nonce_action($slug))) {
      continue;
    }

    if (!current_user_can('edit_post', $post_id)) {
      continue;
    }

    $input = $_POST['auriel_partials'][$slug] ?? array();
    if (!is_array($input)) {
      $input = array();
    }

    $fields = isset($partial['fields']) && is_array($partial['fields']) ? $partial['fields'] : array();

    foreach ($fields as $field_key => $field) {
      $meta_key = auriel_partials_meta_key($slug, (string) $field_key);
      $type = isset($field['type']) ? (string) $field['type'] : 'text';
      $raw_value = $input[$field_key] ?? null;

      if ('repeater' === $type) {
        $sanitized_repeater = auriel_partials_sanitize_repeater($field, $raw_value);
        if (!empty($sanitized_repeater)) {
          update_post_meta($post_id, $meta_key, $sanitized_repeater);
        } else {
          delete_post_meta($post_id, $meta_key);
        }
        continue;
      }

      $sanitized = auriel_partials_sanitize_field_value($type, $raw_value);

      $should_delete = false;

      if (is_string($sanitized)) {
        $should_delete = '' === $sanitized;
      } elseif (is_numeric($sanitized)) {
        $should_delete = 0 === (int) $sanitized;
      } elseif (is_array($sanitized)) {
        $should_delete = empty($sanitized);
      }

      if ($should_delete) {
        delete_post_meta($post_id, $meta_key);
        continue;
      }

      update_post_meta($post_id, $meta_key, $sanitized);
    }
  }
}

/**
 * @param array<string, mixed> $field
 * @param mixed                $value
 * @return array<int, array<string, mixed>>
 */
function auriel_partials_sanitize_repeater(array $field, $value): array
{
  if (!is_array($value)) {
    return array();
  }

  $rows = array();
  $sub_fields = isset($field['fields']) && is_array($field['fields']) ? $field['fields'] : array();

  foreach ($value as $row) {
    if (!is_array($row)) {
      continue;
    }

    $sanitized_row = array();
    foreach ($sub_fields as $sub_key => $sub_field) {
      $sub_type = isset($sub_field['type']) ? (string) $sub_field['type'] : 'text';
      $sanitized_row[$sub_key] = auriel_partials_sanitize_field_value($sub_type, $row[$sub_key] ?? null);
    }

    $has_content = false;
    foreach ($sanitized_row as $value_part) {
      if (is_string($value_part) && '' !== $value_part) {
        $has_content = true;
        break;
      }

      if (is_numeric($value_part) && 0 !== (int) $value_part) {
        $has_content = true;
        break;
      }
    }

    if ($has_content) {
      $rows[] = $sanitized_row;
    }
  }

  return $rows;
}

/**
 * @param mixed $value
 * @return mixed
 */
function auriel_partials_sanitize_field_value(string $type, $value)
{
  switch ($type) {
    case 'textarea':
      return sanitize_textarea_field((string) ($value ?? ''));

    case 'url':
      return esc_url_raw((string) ($value ?? ''));

    case 'media':
      $media_value = auriel_partials_normalize_media_value($value);
      return auriel_partials_compact_media_value($media_value);

    case 'image':
      return max(0, (int) $value);

    case 'gallery':
      return auriel_partials_normalize_gallery_value($value);

    case 'editor':
      return wp_kses_post((string) ($value ?? ''));

    default:
      return sanitize_text_field((string) ($value ?? ''));
  }
}

/**
 * Retrieve all fields for a partial.
 *
 * @return array<string, mixed>
 */
function auriel_partials_get_fields(string $slug, int $post_id = 0): array
{
  $partial = Auriel_Partial_Registry::get($slug);
  if (empty($partial)) {
    return array();
  }

  if ($post_id <= 0) {
    $post_id = function_exists('get_the_ID') ? (int) get_the_ID() : 0;
  }

  if ($post_id <= 0) {
    return array();
  }

  $fields = isset($partial['fields']) && is_array($partial['fields']) ? $partial['fields'] : array();
  $values = array();

  foreach ($fields as $field_key => $field) {
    $type = isset($field['type']) ? (string) $field['type'] : 'text';
    $meta_key = auriel_partials_meta_key($slug, (string) $field_key);
    $stored = get_post_meta($post_id, $meta_key, true);

    if ('repeater' === $type) {
      $values[$field_key] = is_array($stored) ? $stored : array();
      continue;
    }

    if ('gallery' === $type) {
      $values[$field_key] = auriel_partials_normalize_gallery_value($stored);
      continue;
    }

    if ('media' === $type) {
      $values[$field_key] = auriel_partials_normalize_media_value($stored);
      continue;
    }

    if ('image' === $type) {
      $values[$field_key] = (int) $stored;
      continue;
    }

    $values[$field_key] = is_string($stored) ? $stored : '';
  }

  return $values;
}

/**
 * Retrieve a single field value for a partial.
 *
 * @param mixed $default
 * @return mixed
 */
function auriel_partials_get_field(string $slug, string $field, $default = '')
{
  $values = auriel_partials_get_fields($slug);
  if (!array_key_exists($field, $values)) {
    return $default;
  }

  $value = $values[$field];

  if ((is_string($value) && '' === $value) || (is_array($value) && empty($value))) {
    return $default;
  }

  if (is_int($default) && is_numeric($value)) {
    return (int) $value;
  }

  return $value;
}

add_action('init', 'auriel_partials_register_scripts');
function auriel_partials_register_scripts(): void
{
  foreach (Auriel_Partial_Registry::all() as $slug => $_partial) {
    $handle = auriel_partials_script_handle($slug);
    if ('' === $handle) {
      continue;
    }

    $path = get_template_directory() . '/js/partials/' . $slug . '.js';
    if (!file_exists($path)) {
      continue;
    }

    $uri = get_template_directory_uri() . '/js/partials/' . $slug . '.js';
    $version = (string) filemtime($path);

    wp_register_script(
      $handle,
      $uri,
      array(),
      $version,
      true
    );
  }
}

function auriel_partials_script_handle(string $slug): string
{
  $slug = sanitize_key($slug);
  if ('' === $slug) {
    return '';
  }

  return 'auriel-partial-' . $slug;
}

function auriel_partials_enqueue_script(string $slug): void
{
  $handle = auriel_partials_script_handle($slug);
  if ('' === $handle) {
    return;
  }

  if (wp_script_is($handle, 'registered')) {
    wp_enqueue_script($handle);
  }
}

function auriel_partials_load_definitions(): void
{
  $directory = __DIR__;
  foreach (glob($directory . '/*.php') as $file) {
    if (basename($file) === 'core.php') {
      continue;
    }
    require_once $file;
  }
}
auriel_partials_load_definitions();
