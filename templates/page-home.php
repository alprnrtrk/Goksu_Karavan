<?php
/**
 * Template Name: Home Page
 * Description: Landing layout with hero slider and palette preview.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main space-y-16 bg-surface py-12">
  <?php if (have_posts()): ?>
    <?php while (have_posts()):
      the_post(); ?>
      <?php get_template_part('partials/hero'); ?>
      <?php get_template_part('partials/test-partial'); ?>
      <?php get_template_part('partials/home-promo'); ?>
      <?php get_template_part('partials/home-feature-grid'); ?>

      <section class="mx-auto max-w-5xl px-6 text-left">
        <article class="prose prose-slate max-w-none">
          <?php the_content(); ?>
        </article>
      </section>

      <?php
      $tokens = auriel_theme_get_design_tokens();
      if (!empty($tokens)):
        ?>
        <section class="mx-auto max-w-5xl px-6">
          <h2 class="text-2xl font-semibold text-primary">
            <?php esc_html_e('Theme palette', AURIEL_THEME_TEXT_DOMAIN); ?>
          </h2>
          <p class="mt-2 text-sm text-text/70">
            <?php esc_html_e('These values map to Tailwind utility classes via CSS variables.', AURIEL_THEME_TEXT_DOMAIN); ?>
          </p>
          <div class="mt-6 grid gap-4 md:grid-cols-2">
            <?php foreach ($tokens as $key => $value): ?>
              <?php
              $label = ucwords(str_replace('_', ' ', $key));
              ?>
              <div class="flex items-center justify-between rounded-lg border border-text/10 bg-white/60 p-4 shadow-sm">
                <div>
                  <p class="text-sm font-medium text-text/80">
                    <?php echo esc_html($label); ?>
                  </p>
                  <p class="text-base font-semibold text-text">
                    <?php echo esc_html($value); ?>
                  </p>
                </div>
                <span class="h-10 w-10 rounded-full border border-text/10 shadow-inner" style="background: <?php echo esc_attr($value); ?>;" aria-hidden="true"></span>
              </div>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endif; ?>
    <?php endwhile; ?>
  <?php endif; ?>
</main>
<?php
get_footer();
