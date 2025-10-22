<?php
declare(strict_types=1);

$heading = (string) auriel_theme_get_field('about_values_heading', '');
$intro = (string) auriel_theme_get_field('about_values_intro', '');
$values = auriel_theme_get_field('about_values_items', array());

if (!is_array($values)) {
  $values = array();
}
?>
<section class="mx-auto max-w-5xl px-6">
  <div class="rounded-3xl border border-text/10 bg-white/80 p-8 shadow-xl">
    <?php if ('' !== $heading): ?>
      <h2 class="text-3xl font-semibold text-primary md:text-4xl">
        <?php echo esc_html($heading); ?>
      </h2>
    <?php endif; ?>
    <?php if ('' !== $intro): ?>
      <p class="mt-3 max-w-2xl text-base text-text/70">
        <?php echo esc_html($intro); ?>
      </p>
    <?php endif; ?>
    <?php if (!empty($values)): ?>
      <div class="mt-8 grid gap-6 md:grid-cols-3">
        <?php foreach ($values as $value): ?>
          <?php
          $title = isset($value['title']) ? (string) $value['title'] : '';
          $description = isset($value['description']) ? (string) $value['description'] : '';
          ?>
          <div class="flex flex-col gap-3 rounded-2xl border border-primary/10 bg-primary/5 p-5">
            <?php if ('' !== $title): ?>
              <h3 class="text-lg font-semibold text-primary">
                <?php echo esc_html($title); ?>
              </h3>
            <?php endif; ?>
            <?php if ('' !== $description): ?>
              <p class="text-sm text-text/70">
                <?php echo esc_html($description); ?>
              </p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
