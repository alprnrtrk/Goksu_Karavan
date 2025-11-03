<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('gallery-own');

$heading = isset($fields['heading']) ? (string) $fields['heading'] : '';
$summary = isset($fields['summary']) ? (string) $fields['summary'] : '';
$image_ids = isset($fields['gallery_images']) && is_array($fields['gallery_images'])
  ? array_map('intval', $fields['gallery_images'])
  : array();

if ('' === $heading) {
  $heading = get_the_title() ?: __('Gallery', AURIEL_THEME_TEXT_DOMAIN);
}

$images = array();
foreach ($image_ids as $image_id) {
  $attributes = auriel_theme_resolve_image_attributes($image_id, 'large');
  if ('' === $attributes['src']) {
    continue;
  }

  $images[] = $attributes;
}

$has_images = !empty($images);
$summary_text = trim($summary);
$items_per_batch = 9;

?>

<section id="gallery-own" data-partial="gallery-own" class="relative w-full bg-surface py-[120px] md:py-[80px]">
  <div class="px-[150px] md:px-[20px] space-y-[60px]">
    <?php if ($heading || $summary_text): ?>
      <div class="flex flex-col items-center text-center gap-[20px] mx-auto">
        <span class="relative w-max text-xl font-semibold before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[15px] before:-translate-x-full before:w-[50px] before:h-[2px] before:rounded-full before:bg-primary after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[15px] after:translate-x-full after:w-[50px] after:h-[2px] after:rounded-full after:bg-primary">Galeri</span>
        <?php if ($heading): ?>
          <h2 class="text-3xl md:text-2xl font-semibold ">
            <?php echo esc_html($heading); ?>
          </h2>
        <?php endif; ?>
        <?php if ($summary_text): ?>
          <p class="text-base leading-relaxed">
            <?php echo esc_html($summary_text); ?>
          </p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($has_images): ?>
      <div data-gallery-own-grid data-gallery-batch="<?php echo esc_attr((string) $items_per_batch); ?>" class="grid grid-cols-3 md:grid-cols-2 gap-[30px] md:gap-[10px]">
        <?php foreach ($images as $index => $image): ?>
          <?php
          $delay = number_format(0.1 * (($index % 3) + 1), 1, '.', '');
          $image_classes = 'absolute inset-0 w-full h-full object-cover object-center';
          $is_initial_batch = $index < $items_per_batch;
          ?>
          <div data-gsap-toggle="active" data-device="desktop" data-delay="<?php echo esc_attr($delay); ?>" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="false" data-gallery-own-item="<?php echo esc_attr((string) $index); ?>" <?php if (!$is_initial_batch): ?>data-gallery-hidden="true" style="display: none;" <?php endif; ?> class="relative w-full aspect-square overflow-hidden rounded-[20px] bg-black/30 duration-500 min-md:translate-y-[10%] min-md:opacity-0 [&.active]:translate-y-0 [&.active]:opacity-100">
            <a href="<?php echo esc_url($image['src']); ?>" data-fancybox="gallery-own" class="group relative block h-full w-full" aria-label="<?php echo esc_attr(__('View image in lightbox', AURIEL_THEME_TEXT_DOMAIN)); ?>">
              <?php
              echo auriel_theme_render_image_from_attributes(
                $image,
                array(
                  'class' => $image_classes,
                )
              );
              ?>
              <span class="absolute inset-0 flex items-center justify-center bg-black/0 text-white text-4xl opacity-0 duration-500 group-hover:bg-black/50 group-hover:opacity-100">
                <i class="fa-solid fa-magnifying-glass-plus" aria-hidden="true"></i>
              </span>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if (count($images) > $items_per_batch): ?>
        <div class="flex justify-center">
          <button type="button" data-gallery-own-load-more data-gallery-total="<?php echo esc_attr((string) count($images)); ?>" class="px-8 py-3 rounded-full border border-white/30 text-white/80 uppercase tracking-[0.2em] text-sm hover:bg-white/10 duration-300">
            <?php esc_html_e('Load more', AURIEL_THEME_TEXT_DOMAIN); ?>
          </button>
        </div>
      <?php endif; ?>
    <?php else: ?>
      <div class="rounded-[20px] border border-dashed border-white/20 bg-white/5 p-[40px] text-center text-white/70">
        <?php esc_html_e('No gallery images have been selected yet. Use the Gallery Section box in the editor to add images.', AURIEL_THEME_TEXT_DOMAIN); ?>
      </div>
    <?php endif; ?>
  </div>
</section>