<?php
declare(strict_types=1);

$hero_fields = auriel_theme_get_fields(
  array(
    'hero_headline',
    'hero_subheading',
    'hero_button_label',
    'hero_button_url',
  )
);

$hero_headline = (string) ($hero_fields['hero_headline'] ?? '');
$hero_subheading = (string) ($hero_fields['hero_subheading'] ?? '');
$hero_button_label = (string) ($hero_fields['hero_button_label'] ?? '');
$hero_button_url = (string) ($hero_fields['hero_button_url'] ?? '');

$prepared_slides = array();

foreach (auriel_get_hero_slides() as $raw_slide) {
  $title = isset($raw_slide['title']) ? trim((string) $raw_slide['title']) : '';
  $subtitle = isset($raw_slide['subtitle']) ? (string) $raw_slide['subtitle'] : '';
  $content = isset($raw_slide['content']) ? (string) $raw_slide['content'] : '';
  $button_label = isset($raw_slide['button_label']) ? (string) $raw_slide['button_label'] : '';
  $button_url = isset($raw_slide['button_url']) ? (string) $raw_slide['button_url'] : '';
  $image_id = isset($raw_slide['image_id']) ? (int) $raw_slide['image_id'] : 0;
  $image_html = $image_id ? wp_get_attachment_image($image_id, 'large', false, array('class' => 'h-full w-full object-cover', 'loading' => 'lazy')) : '';

  $prepared_slides[] = array(
    'title' => '' !== $title ? $title : __('Untitled slide', AURIEL_THEME_TEXT_DOMAIN),
    'subtitle' => $subtitle,
    'button' => array(
      'label' => $button_label,
      'url' => $button_url,
    ),
    'image_html' => $image_html,
    'content' => $content,
  );
}
?>
<section class="relative isolate overflow-hidden bg-surface text-text" data-hero-partial>
  <div class="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-16 text-center">
    <div class="space-y-4" data-hero-animate>
      <p class="text-sm font-semibold uppercase tracking-[0.3em] text-secondary">
        <?php esc_html_e('Featured', AURIEL_THEME_TEXT_DOMAIN); ?>
      </p>
      <h1 class="text-4xl font-semibold text-primary md:text-5xl">
        <?php echo esc_html($hero_headline); ?>
      </h1>
      <?php if (!empty($hero_subheading)): ?>
        <p class="mx-auto max-w-2xl text-base text-text/80 md:text-lg">
          <?php echo esc_html($hero_subheading); ?>
        </p>
      <?php endif; ?>

      <?php if (!empty($hero_button_label) && !empty($hero_button_url)): ?>
        <div class="flex justify-center">
          <a class="inline-flex items-center gap-2 rounded-full border border-primary bg-primary px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60" href="<?php echo esc_url($hero_button_url); ?>">
            <?php echo esc_html($hero_button_label); ?>
          </a>
        </div>
      <?php endif; ?>
    </div>

    <div class="relative">
      <div class="swiper rounded-2xl border border-text/10 bg-white/70 p-6 shadow-xl backdrop-blur" data-hero-slider>
        <div class="swiper-wrapper">
          <?php foreach ($prepared_slides as $index => $slide): ?>
            <div class="swiper-slide">
              <div class="grid gap-6 md:grid-cols-2 md:items-center">
                <?php if (!empty($slide['image_html'])): ?>
                  <div class="overflow-hidden rounded-2xl bg-surface shadow-inner">
                    <?php echo wp_kses_post($slide['image_html']); ?>
                  </div>
                <?php endif; ?>
                <div class="text-left space-y-4">
                  <p class="text-xs font-medium uppercase tracking-widest text-secondary">
                    <?php
                    printf(
                      /* translators: %d is the slide index. */
                      esc_html__('Slide %d', AURIEL_THEME_TEXT_DOMAIN),
                      (int) $index + 1
                    );
                    ?>
                  </p>
                  <h2 class="text-2xl font-semibold text-primary">
                    <?php echo esc_html($slide['title']); ?>
                  </h2>
                  <?php if (!empty($slide['subtitle'])): ?>
                    <p class="text-sm text-text/70">
                      <?php echo esc_html($slide['subtitle']); ?>
                    </p>
                  <?php endif; ?>
                  <?php if (!empty($slide['content'])): ?>
                    <div class="prose prose-sm prose-slate max-w-none">
                      <?php echo wp_kses_post(wpautop($slide['content'])); ?>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($slide['button']['label']) && !empty($slide['button']['url'])): ?>
                    <div>
                      <a class="inline-flex items-center gap-2 rounded-full border border-accent bg-accent px-5 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white transition hover:bg-accent/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/60" href="<?php echo esc_url($slide['button']['url']); ?>">
                        <?php echo esc_html($slide['button']['label']); ?>
                      </a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div class="flex items-center gap-2">
            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-primary/40 text-primary transition hover:bg-primary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60" data-hero-prev>
              <span class="sr-only"><?php esc_html_e('Previous slide', AURIEL_THEME_TEXT_DOMAIN); ?></span>
              &larr;
            </button>
            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-primary/40 text-primary transition hover:bg-primary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60" data-hero-next>
              <span class="sr-only"><?php esc_html_e('Next slide', AURIEL_THEME_TEXT_DOMAIN); ?></span>
              &rarr;
            </button>
          </div>
          <div class="flex items-center justify-center gap-2" data-hero-pagination></div>
        </div>
      </div>
    </div>
  </div>
</section>