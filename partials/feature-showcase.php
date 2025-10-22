<?php
declare(strict_types=1);

auriel_partials_enqueue_script('feature-showcase');

$fields = auriel_partials_get_fields('feature-showcase');

$heading = isset($fields['heading']) ? (string) $fields['heading'] : '';
$intro = isset($fields['intro']) ? (string) $fields['intro'] : '';
$body = isset($fields['body']) ? (string) $fields['body'] : '';
$button_label = isset($fields['button_label']) ? (string) $fields['button_label'] : '';
$button_url = isset($fields['button_url']) ? (string) $fields['button_url'] : '';
$image_id = isset($fields['image']) ? (int) $fields['image'] : 0;
$items = isset($fields['items']) && is_array($fields['items']) ? $fields['items'] : array();

$image_attributes = array();
if ($image_id > 0) {
  $image_attributes = auriel_theme_resolve_image_attributes($image_id, 'large');
}

$image_html = '';
if (!empty($image_attributes['src'])) {
  $image_html = auriel_theme_render_image_from_attributes(
    $image_attributes,
    array(
      'class' => 'feature-showcase__image',
      'loading' => 'lazy',
    )
  );
}
?>
<section class="feature-showcase" data-partial="feature-showcase">
  <div class="feature-showcase__container">
    <header class="feature-showcase__header">
      <?php if ('' !== $heading): ?>
        <h2 class="feature-showcase__heading">
          <?php echo esc_html($heading); ?>
        </h2>
      <?php endif; ?>

      <?php if ('' !== $intro): ?>
        <p class="feature-showcase__intro">
          <?php echo esc_html($intro); ?>
        </p>
      <?php endif; ?>

      <?php if ('' !== $body): ?>
        <div class="feature-showcase__body">
          <?php echo wp_kses_post(wpautop($body)); ?>
        </div>
      <?php endif; ?>

      <?php if ('' !== $button_label && '' !== $button_url): ?>
        <a class="feature-showcase__button" href="<?php echo esc_url($button_url); ?>">
          <?php echo esc_html($button_label); ?>
        </a>
      <?php endif; ?>
    </header>

    <?php if ('' !== $image_html): ?>
      <div class="feature-showcase__media">
        <?php echo wp_kses_post($image_html); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($items)): ?>
      <div class="feature-showcase__items">
        <?php foreach ($items as $index => $item): ?>
          <?php
          if (!is_array($item)) {
            continue;
          }

          $item_title = isset($item['title']) ? (string) $item['title'] : '';
          $item_description = isset($item['description']) ? (string) $item['description'] : '';
          $item_link_label = isset($item['link_label']) ? (string) $item['link_label'] : '';
          $item_link_url = isset($item['link_url']) ? (string) $item['link_url'] : '';
          $icon_id = isset($item['icon_image']) ? (int) $item['icon_image'] : 0;

          $icon_html = '';
          if ($icon_id > 0) {
            $icon_attr = auriel_theme_resolve_image_attributes($icon_id, 'thumbnail');
            if (!empty($icon_attr['src'])) {
              $icon_html = auriel_theme_render_image_from_attributes(
                $icon_attr,
                array(
                  'class' => 'feature-showcase__item-icon',
                  'loading' => 'lazy',
                )
              );
            }
          }

          if ('' === $item_title && '' === $item_description && '' === $item_link_label && '' === $item_link_url && '' === $icon_html) {
            continue;
          }
          ?>
          <article class="feature-showcase__item">
            <?php if ('' !== $icon_html): ?>
              <div class="feature-showcase__item-icon-wrap">
                <?php echo wp_kses_post($icon_html); ?>
              </div>
            <?php endif; ?>
            <?php if ('' !== $item_title): ?>
              <h3 class="feature-showcase__item-title">
                <?php echo esc_html($item_title); ?>
              </h3>
            <?php endif; ?>
            <?php if ('' !== $item_description): ?>
              <p class="feature-showcase__item-description">
                <?php echo esc_html($item_description); ?>
              </p>
            <?php endif; ?>
            <?php if ('' !== $item_link_label && '' !== $item_link_url): ?>
              <a class="feature-showcase__item-link" href="<?php echo esc_url($item_link_url); ?>">
                <?php echo esc_html($item_link_label); ?>
              </a>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
