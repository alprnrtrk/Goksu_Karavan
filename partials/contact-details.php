<?php
declare(strict_types=1);

$fields = auriel_theme_get_fields(
  array(
    'contact_heading',
    'contact_intro',
    'contact_email',
    'contact_phone',
    'contact_address',
    'contact_hours',
    'contact_cta_label',
    'contact_cta_url',
  )
);

$accent = auriel_theme_get_design_token('accent_color', '#10b981');
$surface = auriel_theme_get_design_token('surface_color', '#ffffff');

$heading = (string) ($fields['contact_heading'] ?? '');
$intro = (string) ($fields['contact_intro'] ?? '');
$email = (string) ($fields['contact_email'] ?? '');
$phone = (string) ($fields['contact_phone'] ?? '');
$address = (string) ($fields['contact_address'] ?? '');
$hours = (string) ($fields['contact_hours'] ?? '');
$cta_label = (string) ($fields['contact_cta_label'] ?? '');
$cta_url = (string) ($fields['contact_cta_url'] ?? '');
?>
<section class="mx-auto flex max-w-5xl flex-col gap-10 px-6 text-left md:flex-row">
  <div class="flex-1 rounded-2xl border border-text/10 bg-white/90 p-8 shadow-sm" style="background: <?php echo esc_attr($surface); ?>;">
    <?php if ('' !== $heading): ?>
      <h2 class="text-2xl font-semibold text-primary">
        <?php echo esc_html($heading); ?>
      </h2>
    <?php endif; ?>
    <?php if ('' !== $intro): ?>
      <p class="mt-3 text-sm text-text/70">
        <?php echo esc_html($intro); ?>
      </p>
    <?php endif; ?>
    <article class="prose prose-slate mt-6 max-w-none">
      <?php the_content(); ?>
    </article>
  </div>
  <div class="flex w-full max-w-sm flex-col gap-4 rounded-2xl border border-transparent p-8 text-white shadow-lg" style="background: <?php echo esc_attr($accent); ?>;">
    <h3 class="text-xl font-semibold">
      <?php esc_html_e('Contact details', AURIEL_THEME_TEXT_DOMAIN); ?>
    </h3>
    <ul class="space-y-3 text-sm">
      <?php if ('' !== $email): ?>
        <li>
          <a class="underline decoration-white/60 decoration-2 underline-offset-4 hover:decoration-white" href="mailto:<?php echo esc_attr($email); ?>">
            <?php echo esc_html($email); ?>
          </a>
        </li>
      <?php endif; ?>
      <?php if ('' !== $phone): ?>
        <li>
          <a class="underline decoration-white/60 decoration-2 underline-offset-4 hover:decoration-white" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>">
            <?php echo esc_html($phone); ?>
          </a>
        </li>
      <?php endif; ?>
      <?php if ('' !== $address): ?>
        <li>
          <span class="opacity-90 block">
            <?php echo nl2br(esc_html($address)); ?>
          </span>
        </li>
      <?php endif; ?>
      <?php if ('' !== $hours): ?>
        <li>
          <span class="opacity-75 block">
            <?php echo nl2br(esc_html($hours)); ?>
          </span>
        </li>
      <?php endif; ?>
    </ul>
    <?php if ($cta_label && $cta_url): ?>
      <a class="mt-4 inline-flex items-center gap-2 rounded-full border border-white/40 bg-white/10 px-5 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white transition hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/70" href="<?php echo esc_url($cta_url); ?>">
        <?php echo esc_html($cta_label); ?>
      </a>
    <?php endif; ?>
  </div>
</section>
