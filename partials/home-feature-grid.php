<?php
declare(strict_types=1);

$heading = (string) auriel_theme_get_field('home_feature_heading', '');
$intro = (string) auriel_theme_get_field('home_feature_intro', '');
$features = auriel_theme_get_field('home_feature_items', array());

if (!is_array($features)) {
  $features = array();
}
?>
<section class="mx-auto max-w-6xl px-6">
  <div class="mx-auto max-w-2xl text-center">
    <?php if ('' !== $heading): ?>
      <h2 class="text-3xl font-semibold text-primary md:text-4xl">
        <?php echo esc_html($heading); ?>
      </h2>
    <?php endif; ?>
    <?php if ('' !== $intro): ?>
      <p class="mt-3 text-base text-text/70 md:text-lg">
        <?php echo esc_html($intro); ?>
      </p>
    <?php endif; ?>
  </div>
  <?php if (!empty($features)): ?>
    <div class="mt-10 grid gap-6 md:grid-cols-3">
      <?php foreach ($features as $feature): ?>
        <?php
        $title = isset($feature['title']) ? (string) $feature['title'] : '';
        $description = isset($feature['description']) ? (string) $feature['description'] : '';
        $icon = isset($feature['icon']) ? (string) $feature['icon'] : '';
        ?>
        <div class="rounded-2xl border border-text/10 bg-white/80 p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
          <?php if ('' !== $icon): ?>
            <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-xl">
              <?php echo esc_html($icon); ?>
            </div>
          <?php endif; ?>
          <?php if ('' !== $title): ?>
            <h3 class="text-lg font-semibold text-primary">
              <?php echo esc_html($title); ?>
            </h3>
          <?php endif; ?>
          <?php if ('' !== $description): ?>
            <p class="mt-2 text-sm text-text/70">
              <?php echo esc_html($description); ?>
            </p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
