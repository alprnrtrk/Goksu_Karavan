<?php
declare(strict_types=1);

/**
 * Central store for registered field metadata.
 */
class Auriel_Partial_Field_Store
{
  /**
   * @var array<string, array<string, mixed>>
   */
  private static array $fields = array();

  public static function register(array $field): void
  {
    $name = $field['name'] ?? '';
    if ('' === $name) {
      return;
    }

    self::$fields[$name] = $field;
  }

  /**
   * @return array<string, mixed>
   */
  public static function get(string $name): array
  {
    return self::$fields[$name] ?? array();
  }

  /**
   * Resolve the default value for a field, invoking callbacks when provided.
   *
   * @param int $post_id Optional post ID.
   * @return mixed
   */
  public static function resolve_default(string $name, int $post_id = 0)
  {
    $field = self::get($name);

    if (isset($field['default_callback']) && is_callable($field['default_callback'])) {
      return call_user_func($field['default_callback'], $post_id);
    }

    if (!array_key_exists('default', $field)) {
      return '';
    }

    $default = $field['default'];
    if (is_callable($default)) {
      return call_user_func($default, $post_id);
    }

    return $default;
  }
}

/**
 * Simple metadata builder for registering partial-specific fields without ACF.
 */
class Auriel_Partial_Field_Group
{
  private string $partial;
  private string $meta_box_id;
  private string $title;
  /**
   * @var array<int, array<string, mixed>>
   */
  private array $fields = array();
  /**
   * @var array<int, string>
   */
  private array $templates = array();
  /**
   * @var array<int, string>
   */
  private array $post_types;
  private string $context;
  private string $priority;
  private string $form_key = 'auriel_fields';
  private string $nonce_key;
  private string $nonce_action;
  private bool $uses_repeater = false;

  public function __construct(string $partial, array $args = array())
  {
    $this->partial = auriel_theme_normalize_partial_reference($partial);

    $slug = str_replace(array('/', '-'), '_', preg_replace('/\.php$/', '', $this->partial));
    $slug = '' !== $slug ? $slug : 'partial';

    $this->meta_box_id = (string) ($args['id'] ?? 'auriel_partial_' . $slug);
    $this->title = (string) ($args['title'] ?? ucwords(str_replace('_', ' ', $slug)));
    $this->post_types = (array) ($args['post_types'] ?? array('page'));
    $this->context = (string) ($args['context'] ?? 'normal');
    $this->priority = (string) ($args['priority'] ?? 'default');
    $this->nonce_action = 'auriel_partial_fields_' . $this->meta_box_id;
    $this->nonce_key = $this->meta_box_id . '_nonce';
  }

  public function text(string $name, array $args = array()): self
  {
    return $this->add_field('text', $name, $args);
  }

  public function textarea(string $name, array $args = array()): self
  {
    return $this->add_field('textarea', $name, $args);
  }

  public function url(string $name, array $args = array()): self
  {
    return $this->add_field('url', $name, $args);
  }

  public function number(string $name, array $args = array()): self
  {
    return $this->add_field('number', $name, $args);
  }

  public function image(string $name, array $args = array()): self
  {
    return $this->add_field('image', $name, $args);
  }

  public function field(string $type, string $name, array $args = array()): self
  {
    return $this->add_field($type, $name, $args);
  }

  public function repeater(string $name, callable $definition, array $args = array()): self
  {
    $builder = new Auriel_Partial_Repeater_Builder($this, $name);
    $definition($builder);
    $sub_fields = $builder->export();

    if (empty($sub_fields)) {
      return $this;
    }

    $field = $this->normalize_field('repeater', $name, $args);
    $field['sub_fields'] = $sub_fields;

    if (!isset($field['button_label']) || '' === (string) $field['button_label']) {
      $field['button_label'] = __('Add item', AURIEL_THEME_TEXT_DOMAIN);
    }

    if (!isset($field['layout']) || '' === (string) $field['layout']) {
      $field['layout'] = 'block';
    }

    $this->uses_repeater = true;
    Auriel_Partial_Field_Store::register($field);
    $this->fields[] = $field;

    return $this;
  }

  /**
   * @param array<int, string> $templates
   */
  public function set_templates(array $templates): self
  {
    $this->templates = $this->sanitize_templates($templates);

    return $this;
  }

  /**
   * Finalise registration and hook into WordPress.
   */
  public function register(): void
  {
    add_action('add_meta_boxes', array($this, 'maybe_register_meta_box'), 10, 2);
    add_action('save_post', array($this, 'save_meta'), 10, 2);
  }

  public function maybe_register_meta_box(string $post_type, WP_Post $post): void
  {
    if (!in_array($post_type, $this->post_types, true)) {
      return;
    }

    if (!$this->should_display_meta_box($post)) {
      return;
    }

    add_meta_box(
      $this->meta_box_id,
      $this->title,
      array($this, 'render_meta_box'),
      $post_type,
      $this->context,
      $this->priority
    );
  }

  public function render_meta_box(WP_Post $post): void
  {
    wp_nonce_field($this->nonce_action, $this->nonce_key);

    if ($this->uses_repeater) {
      wp_enqueue_media();
      auriel_enqueue_repeater_assets();
    }

    $values = $this->get_values($post->ID);

    ?>
    <div class="auriel-partial-fields">
      <?php foreach ($this->fields as $field): ?>
        <?php $this->render_field($field, $values[$field['name']] ?? null); ?>
      <?php endforeach; ?>
    </div>
    <?php
  }

  public function save_meta(int $post_id, WP_Post $post): void
  {
    if (!in_array($post->post_type, $this->post_types, true)) {
      return;
    }

    if (!isset($_POST[$this->nonce_key]) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST[$this->nonce_key])), $this->nonce_action)) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    $input = $_POST[$this->form_key] ?? array();
    if (!is_array($input)) {
      $input = array();
    }

    $input = wp_unslash($input);

    foreach ($this->fields as $field) {
      $name = $field['name'];

      if ('repeater' === $field['type']) {
        $raw = $input[$name] ?? array();
        $sanitised = $this->sanitize_repeater($field, $raw);
        if (!empty($sanitised)) {
          update_post_meta($post_id, $name, $sanitised);
        } else {
          delete_post_meta($post_id, $name);
        }
        continue;
      }

      $raw_value = $input[$name] ?? null;
      $sanitised_value = $this->sanitize_field_value($field, $raw_value);

      if ('' === $sanitised_value || null === $sanitised_value) {
        delete_post_meta($post_id, $name);
      } else {
        update_post_meta($post_id, $name, $sanitised_value);
      }
    }
  }

  /**
   * @return array<string, mixed>
   */
  private function get_values(int $post_id): array
  {
    $values = array();

    foreach ($this->fields as $field) {
      $name = $field['name'];

      if ('repeater' === $field['type']) {
        $stored = get_post_meta($post_id, $name, true);
        if (!is_array($stored) || empty($stored)) {
          $stored = Auriel_Partial_Field_Store::resolve_default($name, $post_id);
        }
        $values[$name] = $this->prepare_repeater_entries($field, $stored);
        continue;
      }

      $stored = get_post_meta($post_id, $name, true);
      if (null === $stored || '' === $stored || (is_array($stored) && empty($stored))) {
        $stored = Auriel_Partial_Field_Store::resolve_default($name, $post_id);
      }
      $values[$name] = $stored;
    }

    return $values;
  }

  private function render_field(array $field, $value): void
  {
    $name = $field['name'];
    $label = $field['label'];
    $instructions = $field['instructions'] ?? '';
    $field_id = $this->meta_box_id . '_' . $name;
    $input_name = $this->form_key . '[' . $name . ']';

    switch ($field['type']) {
      case 'textarea':
        ?>
        <div class="auriel-partial-field">
          <label for="<?php echo esc_attr($field_id); ?>"><?php echo esc_html($label); ?></label>
          <textarea id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($input_name); ?>" class="widefat" rows="<?php echo (int) ($field['rows'] ?? 4); ?>"><?php echo esc_textarea((string) $value); ?></textarea>
          <?php if ($instructions): ?>
            <p class="description"><?php echo esc_html($instructions); ?></p>
          <?php endif; ?>
        </div>
        <?php
        break;

      case 'url':
        ?>
        <div class="auriel-partial-field">
          <label for="<?php echo esc_attr($field_id); ?>"><?php echo esc_html($label); ?></label>
          <input type="url" id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($input_name); ?>" class="widefat" value="<?php echo esc_attr((string) $value); ?>">
          <?php if ($instructions): ?>
            <p class="description"><?php echo esc_html($instructions); ?></p>
          <?php endif; ?>
        </div>
        <?php
        break;

      case 'number':
        ?>
        <div class="auriel-partial-field">
          <label for="<?php echo esc_attr($field_id); ?>"><?php echo esc_html($label); ?></label>
          <input type="number" id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($input_name); ?>" class="small-text" value="<?php echo esc_attr((string) $value); ?>">
          <?php if ($instructions): ?>
            <p class="description"><?php echo esc_html($instructions); ?></p>
          <?php endif; ?>
        </div>
        <?php
        break;

      case 'image':
        $this->render_media_field($field, $value, $field_id, $input_name);
        break;

      case 'repeater':
        $this->render_repeater_field($field, is_array($value) ? $value : array());
        break;

      case 'text':
      default:
        ?>
        <div class="auriel-partial-field">
          <label for="<?php echo esc_attr($field_id); ?>"><?php echo esc_html($label); ?></label>
          <input type="text" id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($input_name); ?>" class="widefat" value="<?php echo esc_attr((string) $value); ?>">
          <?php if ($instructions): ?>
            <p class="description"><?php echo esc_html($instructions); ?></p>
          <?php endif; ?>
        </div>
        <?php
        break;
    }
  }

  /**
   * @param array<int, array<string, mixed>> $entries
   */
  private function render_repeater_field(array $field, array $entries): void
  {
    $field_name = $field['name'];
    $field_prefix = $this->form_key . '[' . $field_name . ']';
    $template_id = $this->meta_box_id . '_' . $field_name . '_template';
    $button_label = $field['button_label'] ?? __('Add item', AURIEL_THEME_TEXT_DOMAIN);
    $instructions = $field['instructions'] ?? '';

    ?>
    <div class="auriel-partial-field">
      <label><?php echo esc_html($field['label']); ?></label>
      <?php if ($instructions): ?>
        <p class="description"><?php echo esc_html($instructions); ?></p>
      <?php endif; ?>
      <div class="auriel-repeater-meta" data-auriel-repeater data-repeater-template="<?php echo esc_attr($template_id); ?>" data-field-prefix="<?php echo esc_attr($field_prefix); ?>">
        <div class="auriel-repeater-meta__list" data-auriel-repeater-list>
          <?php
          if (!empty($entries)) {
            foreach ($entries as $index => $entry) {
              $this->render_repeater_card($field, (int) $index, $entry, $field_prefix);
            }
          }
          ?>
        </div>
        <button type="button" class="button button-secondary" data-auriel-repeater-add>
          <?php echo esc_html($button_label); ?>
        </button>
      </div>
      <template id="<?php echo esc_attr($template_id); ?>">
        <?php $this->render_repeater_card($field, '__index__', array(), $field_prefix); ?>
      </template>
    </div>
    <?php
  }

  /**
   * @param array<string, mixed> $entry
   * @param int|string $index
   */
  private function render_repeater_card(array $field, $index, array $entry, string $field_prefix): void
  {
    $sub_fields = $field['sub_fields'] ?? array();

    $card_index = (string) $index;
    $name_prefix = $field_prefix . '[' . $card_index . ']';
    ?>
    <div class="auriel-repeater-card" data-auriel-repeater-card data-index="<?php echo esc_attr($card_index); ?>">
      <div class="auriel-repeater-card__header">
        <span class="auriel-repeater-card__title"><?php echo esc_html($field['label']); ?></span>
        <div class="auriel-repeater-card__actions">
          <button type="button" class="button button-link" data-auriel-repeater-move-up>&uarr;</button>
          <button type="button" class="button button-link" data-auriel-repeater-move-down>&darr;</button>
          <button type="button" class="button button-link-delete" data-auriel-repeater-remove><?php esc_html_e('Remove', AURIEL_THEME_TEXT_DOMAIN); ?></button>
        </div>
      </div>
      <div class="auriel-repeater-card__body">
        <?php foreach ($sub_fields as $sub_field): ?>
          <?php
          $sub_name = $sub_field['name'];
          $sub_label = $sub_field['label'];
          $sub_value = $entry[$sub_name] ?? ($sub_field['default'] ?? '');
          $sub_id = $this->meta_box_id . '_' . $field['name'] . '_' . $sub_name . '_' . $card_index;
          $sub_input_name = $name_prefix . '[' . $sub_name . ']';
          ?>
          <div class="auriel-repeater-card__field">
            <label for="<?php echo esc_attr($sub_id); ?>"><?php echo esc_html($sub_label); ?></label>
            <?php
            switch ($sub_field['type']) {
              case 'textarea':
                ?>
                <textarea id="<?php echo esc_attr($sub_id); ?>" name="<?php echo esc_attr($sub_input_name); ?>" class="widefat" rows="<?php echo (int) ($sub_field['rows'] ?? 3); ?>"><?php echo esc_textarea((string) $sub_value); ?></textarea>
                <?php
                break;

              case 'url':
                ?>
                <input type="url" id="<?php echo esc_attr($sub_id); ?>" name="<?php echo esc_attr($sub_input_name); ?>" class="widefat" value="<?php echo esc_attr((string) $sub_value); ?>">
                <?php
                break;

              case 'image':
                $this->render_repeater_image_field($sub_field, $sub_value, $sub_id, $sub_input_name);
                break;

              case 'text':
              default:
                ?>
                <input type="text" id="<?php echo esc_attr($sub_id); ?>" name="<?php echo esc_attr($sub_input_name); ?>" class="widefat" value="<?php echo esc_attr((string) $sub_value); ?>">
                <?php
                break;
            }
            ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
  }

  private function render_media_field(array $field, $value, string $field_id, string $input_name): void
  {
    $button_text = $field['choose_button'] ?? __('Select image', AURIEL_THEME_TEXT_DOMAIN);
    $clear_text = $field['clear_button'] ?? __('Clear', AURIEL_THEME_TEXT_DOMAIN);
    $placeholder = $field['placeholder'] ?? __('No image selected', AURIEL_THEME_TEXT_DOMAIN);
    $preview = '';

    $value = (int) $value;
    if ($value > 0) {
      $preview = wp_get_attachment_image($value, 'medium', false, array('class' => 'auriel-media-preview'));
    }
    ?>
    <div class="auriel-partial-field auriel-partial-field--media">
      <label><?php echo esc_html($field['label']); ?></label>
      <div class="auriel-media-picker" data-auriel-media-picker>
        <div class="auriel-media-picker__preview">
          <?php
          if ($preview) {
            echo $preview; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
          } else {
            echo '<div class="auriel-media-picker__placeholder">' . esc_html($placeholder) . '</div>';
          }
          ?>
        </div>
        <input type="hidden" id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr((string) $value); ?>" data-auriel-media-input>
        <div class="auriel-media-picker__actions">
          <button type="button" class="button" data-auriel-media-select><?php echo esc_html($button_text); ?></button>
          <button type="button" class="button button-link-delete" data-auriel-media-clear><?php echo esc_html($clear_text); ?></button>
        </div>
      </div>
    </div>
    <?php
  }

  private function render_repeater_image_field(array $field, $value, string $field_id, string $input_name): void
  {
    $placeholder = $field['placeholder'] ?? __('No image selected', AURIEL_THEME_TEXT_DOMAIN);
    $value = (int) $value;
    $preview = '';

    if ($value > 0) {
      $preview = wp_get_attachment_image($value, 'medium', false, array('class' => 'auriel-repeater-card__image-preview'));
    }
    ?>
    <div class="auriel-repeater-card__media" data-auriel-repeater-media>
      <div class="auriel-repeater-card__image" data-auriel-repeater-image-preview data-placeholder-text="<?php echo esc_attr($placeholder); ?>">
        <?php
        if ($preview) {
          echo $preview; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
          echo '<div class="auriel-repeater-card__image-placeholder">' . esc_html($placeholder) . '</div>';
        }
        ?>
      </div>
      <input type="hidden" id="<?php echo esc_attr($field_id); ?>" name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr((string) $value); ?>" data-auriel-repeater-image-id>
      <div class="auriel-repeater-card__media-actions">
        <button type="button" class="button" data-auriel-repeater-select-image><?php esc_html_e('Select image', AURIEL_THEME_TEXT_DOMAIN); ?></button>
        <button type="button" class="button button-link-delete" data-auriel-repeater-clear-image><?php esc_html_e('Remove', AURIEL_THEME_TEXT_DOMAIN); ?></button>
      </div>
    </div>
    <?php
  }

  /**
   * @param string|int $index
   * @param array<string, mixed>|null $raw
   * @return array<string, mixed>
   */
  private function prepare_repeater_entry(array $field, $index, $raw): array
  {
    $entry = array();
    $sub_fields = $field['sub_fields'] ?? array();

    foreach ($sub_fields as $sub_field) {
      $name = $sub_field['name'];
      $entry[$name] = $raw[$name] ?? ($sub_field['default'] ?? '');
    }

    return $entry;
  }

  /**
   * @param mixed $stored
   * @return array<int, array<string, mixed>>
   */
  private function prepare_repeater_entries(array $field, $stored): array
  {
    if (!is_array($stored)) {
      return array();
    }

    $prepared = array();
    foreach ($stored as $index => $raw_entry) {
      if (!is_array($raw_entry)) {
        continue;
      }
      $prepared[] = $this->prepare_repeater_entry($field, $index, $raw_entry);
    }

    return $prepared;
  }

  /**
   * @param array<string, mixed>|null $raw
   * @return array<string, mixed>|null
   */
  private function sanitize_repeater_entry(array $field, $raw): ?array
  {
    if (!is_array($raw)) {
      return null;
    }

    $entry = array();
    $has_value = false;

    foreach ($field['sub_fields'] as $sub_field) {
      $name = $sub_field['name'];
      $value = $this->sanitize_field_value($sub_field, $raw[$name] ?? null);
      $entry[$name] = $value;

      if (is_string($value) && '' !== trim($value)) {
        $has_value = true;
      } elseif (is_int($value) && 0 !== $value) {
        $has_value = true;
      } elseif (is_array($value) && !empty($value)) {
        $has_value = true;
      }
    }

    return $has_value ? $entry : null;
  }

  /**
   * @param mixed $raw
   * @return array<int, array<string, mixed>>
   */
  private function sanitize_repeater(array $field, $raw): array
  {
    if (!is_array($raw)) {
      return array();
    }

    $prepared = array();
    foreach ($raw as $entry) {
      $sanitised = $this->sanitize_repeater_entry($field, $entry);
      if (null !== $sanitised) {
        $prepared[] = $sanitised;
      }
    }

    return $prepared;
  }

  private function sanitize_field_value(array $field, $value)
  {
    $type = $field['type'] ?? 'text';

    switch ($type) {
      case 'textarea':
        return wp_kses_post((string) $value);

      case 'url':
        return esc_url_raw((string) $value);

      case 'number':
        if ('' === $value || null === $value) {
          return '';
        }
        if (isset($field['step']) && (float) $field['step'] !== 1.0) {
          return (string) floatval($value);
        }

        return (string) intval($value);

      case 'image':
        return absint($value);

      case 'text':
      default:
        return sanitize_text_field((string) $value);
    }
  }

  private function add_field(string $type, string $name, array $args): self
  {
    $name = trim($name);
    if ('' === $name) {
      return $this;
    }

    $field = $this->normalize_field($type, $name, $args);
    Auriel_Partial_Field_Store::register($field);
    $this->fields[] = $field;

    return $this;
  }

  private function normalize_field(string $type, string $name, array $args): array
  {
    $field = $args;
    $field['name'] = $name;
    $field['type'] = $type;
    $field['label'] = isset($field['label']) ? (string) $field['label'] : ucwords(str_replace('_', ' ', $name));

    if (!isset($field['default'])) {
      $field['default'] = '';
    }

    return $field;
  }

  /**
   * @param array<int, string> $templates
   * @return array<int, string>
   */
  private function sanitize_templates(array $templates): array
  {
    $prepared = array();

    foreach ($templates as $template) {
      $template = (string) $template;
      if ('' === $template) {
        continue;
      }
      $prepared[] = $template;
    }

    return array_values(array_unique($prepared));
  }

  private function should_display_meta_box(WP_Post $post): bool
  {
    if (empty($this->fields)) {
      return false;
    }

    if (empty($this->templates)) {
      $this->templates = auriel_theme_discover_partial_templates($this->partial);
    }

    if (empty($this->templates)) {
      return true;
    }

    $template = get_page_template_slug($post->ID);
    if ('' === $template) {
      $template = 'default';
    }

    return in_array($template, $this->templates, true);
  }
}

class Auriel_Partial_Repeater_Builder
{
  private Auriel_Partial_Field_Group $group;
  private string $name;
  /**
   * @var array<int, array<string, mixed>>
   */
  private array $fields = array();

  public function __construct(Auriel_Partial_Field_Group $group, string $name)
  {
    $this->group = $group;
    $this->name = $name;
  }

  public function text(string $name, array $args = array()): self
  {
    return $this->add_field('text', $name, $args);
  }

  public function textarea(string $name, array $args = array()): self
  {
    return $this->add_field('textarea', $name, $args);
  }

  public function url(string $name, array $args = array()): self
  {
    return $this->add_field('url', $name, $args);
  }

  public function image(string $name, array $args = array()): self
  {
    return $this->add_field('image', $name, $args);
  }

  public function field(string $type, string $name, array $args = array()): self
  {
    return $this->add_field($type, $name, $args);
  }

  /**
   * @return array<int, array<string, mixed>>
   */
  public function export(): array
  {
    return $this->fields;
  }

  private function add_field(string $type, string $name, array $args): self
  {
    $name = trim($name);
    if ('' === $name) {
      return $this;
    }

    $field = array_merge(
      array(
        'name' => $name,
        'type' => $type,
        'label' => isset($args['label']) ? (string) $args['label'] : ucwords(str_replace('_', ' ', $name)),
        'default' => $args['default'] ?? '',
      ),
      $args
    );

    $this->fields[] = $field;

    return $this;
  }
}

class Auriel_Partial_Field_Definition_Parser
{
  public static function apply(Auriel_Partial_Field_Group $group, array $definition): void
  {
    if (isset($definition['templates'])) {
      $group->set_templates((array) $definition['templates']);
    }

    $fields = $definition['fields'] ?? $definition;

    foreach ($fields as $name => $config) {
      self::apply_field($group, (string) $name, $config);
    }
  }

  private static function apply_field(Auriel_Partial_Field_Group $group, string $name, $config): void
  {
    if (is_string($config)) {
      $config = array('type' => $config);
    } elseif (!is_array($config)) {
      $config = array();
    }

    $type = $config['type'] ?? 'text';
    $field_args = $config;
    unset($field_args['type'], $field_args['fields']);

    if ('repeater' === $type) {
      $sub_fields = $config['fields'] ?? array();

      $group->repeater(
        $name,
        static function (Auriel_Partial_Repeater_Builder $builder) use ($sub_fields): void {
          foreach ($sub_fields as $sub_name => $sub_config) {
            self::apply_sub_field($builder, (string) $sub_name, $sub_config);
          }
        },
        $field_args
      );

      return;
    }

    $group->field($type, $name, $field_args);
  }

  private static function apply_sub_field(Auriel_Partial_Repeater_Builder $builder, string $name, $config): void
  {
    if (is_string($config)) {
      $config = array('type' => $config);
    } elseif (!is_array($config)) {
      $config = array();
    }

    $type = $config['type'] ?? 'text';
    $field_args = $config;
    unset($field_args['type'], $field_args['fields']);

    $builder->field($type, $name, $field_args);
  }
}

class Auriel_Partial_Field_Registry
{
  /**
   * @var array<int, Auriel_Partial_Field_Group>
   */
  private static array $groups = array();
  private static bool $booted = false;

  public static function add(Auriel_Partial_Field_Group $group): void
  {
    self::$groups[] = $group;
  }

  public static function boot(): void
  {
    if (self::$booted) {
      return;
    }

    foreach (self::$groups as $group) {
      $group->register();
    }

    self::$booted = true;
  }
}

/**
 * Register a partial field group via a convenient definition callback.
 */
function auriel_define_partial_fields(string $partial, $definition, array $args = array()): Auriel_Partial_Field_Group
{
  $group = new Auriel_Partial_Field_Group($partial, $args);

  if (is_callable($definition)) {
    $definition($group);
  } elseif (is_array($definition)) {
    Auriel_Partial_Field_Definition_Parser::apply($group, $definition);
  }

  Auriel_Partial_Field_Registry::add($group);

  return $group;
}

add_action('init', array('Auriel_Partial_Field_Registry', 'boot'));

/**
 * Enqueue reusable assets for the repeater UI.
 */
function auriel_enqueue_repeater_assets(): void
{
  static $enqueued = false;

  if ($enqueued) {
    return;
  }

  $base = get_template_directory();
  $uri = get_template_directory_uri();

  $style_rel = 'assets/admin/hero-slides.css';
  $style_path = $base . '/' . $style_rel;
  if (file_exists($style_path)) {
    wp_enqueue_style(
      'auriel-repeater-meta',
      $uri . '/' . $style_rel,
      array(),
      (string) filemtime($style_path)
    );
  }

  $script_rel = 'assets/admin/hero-slides.js';
  $script_path = $base . '/' . $script_rel;
  if (file_exists($script_path)) {
    wp_enqueue_script(
      'auriel-repeater-meta',
      $uri . '/' . $script_rel,
      array(),
      (string) filemtime($script_path),
      true
    );
  }

  $enqueued = true;
}

/**
 * Normalise a partial reference so it can be located on disk.
 */
function auriel_theme_normalize_partial_reference(string $partial): string
{
  $partial = trim($partial);
  if ('' === $partial) {
    return '';
  }

  $partial = str_replace('\\', '/', $partial);

  if (substr($partial, -4) !== '.php') {
    $partial .= '.php';
  }

  return ltrim($partial, '/');
}

/**
 * Discover templates that include the given partial.
 *
 * @return array<int, string>
 */
function auriel_theme_discover_partial_templates(string $partial): array
{
  static $cache = array();

  $normalized_partial = auriel_theme_normalize_partial_reference($partial);
  if ('' === $normalized_partial) {
    return array();
  }

  if (isset($cache[$normalized_partial])) {
    return $cache[$normalized_partial];
  }

  $partial_slug = preg_replace('/\.php$/', '', $normalized_partial);
  $pattern = sprintf('/get_template_part\s*\(\s*[\'"]%s[\'"]\s*/i', preg_quote($partial_slug, '/'));

  $templates = array();

  foreach (auriel_theme_collect_template_candidates() as $candidate) {
    $contents = file_get_contents($candidate);
    if (false === $contents) {
      continue;
    }

    if (preg_match($pattern, $contents)) {
      $templates[] = auriel_theme_normalize_template_location($candidate);
    }
  }

  $cache[$normalized_partial] = array_values(array_unique(array_filter($templates)));

  return $cache[$normalized_partial];
}

/**
 * Collect potential page template files to scan.
 *
 * @return array<int, string>
 */
function auriel_theme_collect_template_candidates(): array
{
  $theme_dir = trailingslashit(get_template_directory());
  $candidates = array();

  $page_glob = glob($theme_dir . 'page*.php');
  if (is_array($page_glob)) {
    $candidates = array_merge($candidates, $page_glob);
  }

  $templates_dir = $theme_dir . 'templates/';
  if (is_dir($templates_dir)) {
    $template_glob = glob(trailingslashit($templates_dir) . '*.php');
    if (is_array($template_glob)) {
      $candidates = array_merge($candidates, $template_glob);
    }
  }

  return array_values(array_unique(array_filter($candidates, 'is_readable')));
}

/**
 * Convert an absolute template path into a location value.
 */
function auriel_theme_normalize_template_location(string $absolute_path): string
{
  $theme_root = wp_normalize_path(get_template_directory());
  $normalized = wp_normalize_path($absolute_path);
  $theme_root = trailingslashit($theme_root);

  if (0 === strpos($normalized, $theme_root)) {
    $relative = substr($normalized, strlen($theme_root));
  } else {
    $relative = $normalized;
  }

  if ('page.php' === $relative) {
    return 'default';
  }

  return $relative;
}

/**
 * Templates that render the hero partial.
 *
 * @return array<int, string>
 */
function auriel_theme_get_hero_templates(): array
{
  static $templates = null;

  if (null !== $templates) {
    return $templates;
  }

  $hero_partial = locate_template('partials/hero.php', false, false);
  if ('' === $hero_partial) {
    return array();
  }

  $templates = auriel_theme_discover_partial_templates('partials/hero.php');

  $templates = apply_filters('auriel_theme_hero_templates', $templates);

  return $templates;
}

/**
 * Wrapper around get_post_meta for templates.
 *
 * @param string     $field    Meta key.
 * @param mixed      $default  Default value.
 * @param int|string $post_id  Optional post ID.
 *
 * @return mixed
 */
function auriel_theme_get_field(string $field, $default = null, $post_id = 0)
{
  if (0 === $post_id) {
    $post_id = function_exists('get_the_ID') ? (int) get_the_ID() : 0;
  }

  $post_id = (int) $post_id;

  if (null === $default) {
    $default = Auriel_Partial_Field_Store::resolve_default($field, $post_id);
  } elseif (is_callable($default)) {
    $default = call_user_func($default, $post_id);
  }

  if (0 === $post_id) {
    return null === $default ? '' : $default;
  }

  $value = get_post_meta($post_id, $field, true);

  if (null === $value || '' === $value || (is_array($value) && empty($value))) {
    return null === $default ? '' : $default;
  }

  return $value;
}

/**
 * Fetch multiple meta fields at once.
 *
 * @param array<int|string, mixed> $fields Field names or field => default map.
 * @param int|string $post_id Optional post ID.
 *
 * @return array<string, mixed>
 */
function auriel_theme_get_fields(array $fields, $post_id = 0): array
{
  $resolved = array();

  foreach ($fields as $key => $definition) {
    if (is_int($key)) {
      $field_name = (string) $definition;
      $default = null;
    } else {
      $field_name = (string) $key;
      $default = $definition;
    }

    $resolved[$field_name] = auriel_theme_get_field($field_name, $default, $post_id);
  }

  return $resolved;
}

/**
 * Include partial field definition files.
 */
function auriel_include_partial_field_definitions(): void
{
  $base_dir = trailingslashit(get_template_directory()) . 'inc/partials';

  if (!is_dir($base_dir)) {
    return;
  }

  $files = glob(trailingslashit($base_dir) . '*.php');
  if (false === $files) {
    return;
  }

  foreach ($files as $file) {
    require_once $file;
  }
}

auriel_include_partial_field_definitions();
