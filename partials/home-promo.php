<?php
declare(strict_types=1);

$fields = auriel_theme_get_fields(
  array(
    'home_promo_eyebrow',
    'home_promo_heading',
    'home_promo_text',
    'home_promo_button_label',
    'home_promo_button_url',
    'home_promo_image_id',
  )
);

$eyebrow = (string) ($fields['home_promo_eyebrow'] ?? '');
$heading = (string) ($fields['home_promo_heading'] ?? '');
$text = (string) ($fields['home_promo_text'] ?? '');
$button_label = (string) ($fields['home_promo_button_label'] ?? '');
$button_url = (string) ($fields['home_promo_button_url'] ?? '');
$image_id = isset($fields['home_promo_image_id']) ? (int) $fields['home_promo_image_id'] : 0;
$image_html = $image_id ? wp_get_attachment_image($image_id, 'large', false, array('class' => 'h-full w-full rounded-2xl object-cover shadow-lg')) : '';
?>
<section class="mx-auto max-w-6xl overflow-hidden rounded-3xl border border-text/10 bg-gradient-to-r from-primary/10 via-white to-white px-6 py-12 shadow-xl md:px-12 md:py-16">
  <div class="grid gap-10 md:grid-cols-2 md:items-center">
    <div class="space-y-5">
      <?php if ('' !== $eyebrow): ?>
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-secondary">
          <?php echo esc_html($eyebrow); ?>
        </p>
      <?php endif; ?>
      <?php if ('' !== $heading): ?>
        <h2 class="text-3xl font-semibold text-primary md:text-4xl">
          <?php echo esc_html($heading); ?>
        </h2>
      <?php endif; ?>
      <?php if ('' !== $text): ?>
        <p class="max-w-xl text-base text-text/75 md:text-lg">
          <?php echo esc_html($text); ?>
        </p>
      <?php endif; ?>
      <?php if ('' !== $button_label && '' !== $button_url): ?>
        <a class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/60" href="<?php echo esc_url($button_url); ?>">
          <?php echo esc_html($button_label); ?>
        </a>
      <?php endif; ?>
    </div>
    <?php if ('' !== $image_html): ?>
      <div class="relative">
        <div class="absolute -inset-4 rounded-3xl bg-primary/10 blur-3xl"></div>
        <div class="relative overflow-hidden rounded-3xl">
          <?php echo wp_kses_post($image_html); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
