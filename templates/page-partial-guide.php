<?php
/**
 * Template Name: Partial Showcase Guide
 * Description: Demonstrates how to define and render theme partials.
 */
declare(strict_types=1);

get_header();

$auriel_render_code = static function (string $code): string {
  return htmlspecialchars(str_replace(array("\r\n", "\r"), "\n", $code), ENT_NOQUOTES, 'UTF-8');
};
?>
<main class="auriel-guide-body bg-surface py-16">
  <style>
    .auriel-guide {
      margin: 0 auto;
      max-width: 1040px;
      padding: 48px clamp(24px, 6vw, 64px);
      border-radius: 20px;
      background: linear-gradient(180deg, rgba(248, 250, 252, 0.92) 0%, rgba(229, 231, 235, 0.72) 100%);
      box-shadow: 0 32px 80px -48px rgba(15, 23, 42, 0.55);
    }
    .auriel-guide h1,
    .auriel-guide h2,
    .auriel-guide h3 {
      margin-bottom: 18px;
      color: #0b1120;
    }
    .auriel-guide h1 {
      font-size: clamp(2.6rem, 4vw, 3.4rem);
      margin-bottom: 28px;
    }
    .auriel-guide h2 {
      font-size: clamp(2rem, 3.2vw, 2.5rem);
      margin-top: 52px;
    }
    .auriel-guide h3 {
      font-size: clamp(1.5rem, 2.6vw, 1.9rem);
      margin-top: 30px;
    }
    .auriel-guide p {
      color: #1f2937;
      margin-bottom: 16px;
    }
    .auriel-guide__badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 6px 12px;
      border-radius: 999px;
      background: rgba(37, 99, 235, 0.14);
      color: #1d4ed8;
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.14em;
      font-weight: 600;
      margin-bottom: 20px;
    }
    .auriel-guide__code {
      position: relative;
      background: #0d1117;
      border-radius: 12px;
      border: 1px solid #1e293b;
      padding: 22px;
      margin: 26px 0;
      overflow-x: auto;
      box-shadow: inset 0 0 32px rgba(15, 23, 42, 0.45);
    }
    .auriel-guide__code code {
      display: block;
      font-family: 'JetBrains Mono', 'Fira Code', ui-monospace, SFMono-Regular, Consolas, 'Liberation Mono', monospace;
      font-size: 0.95rem;
      line-height: 1.6;
      white-space: pre;
      color: #e9edf5;
    }
    .auriel-guide__grid {
      display: grid;
      gap: 20px;
      margin-top: 24px;
    }
    @media (min-width: 880px) {
      .auriel-guide__grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }
    .auriel-guide__grid-card {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 12px;
      border: 1px solid rgba(15, 23, 42, 0.08);
      padding: 20px 22px;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.45);
    }
    .auriel-guide__grid-card h4 {
      margin: 0 0 12px;
      font-size: 1.05rem;
      font-weight: 600;
      color: #0f172a;
    }
    .auriel-guide__grid-card p {
      margin: 0;
      font-size: 0.95rem;
      color: #334155;
    }
  </style>

  <article class="auriel-guide">
    <div class="auriel-guide__badge">WordPress partial toolkit</div>
    <h1>Build custom sections with the Auriel partial registry</h1>
    <p>
      The theme ships with a lightweight partial system. You define fields once, editors get a polished meta box, and
      templates stay clean with straightforward helper functions.
    </p>

    <section>
      <h2>1. Register the partial fields</h2>
      <p>Create <code>inc/partials/feature-showcase.php</code> and describe the fields you need.</p>
      <div class="auriel-guide__code"><code class="language-php"><?= $auriel_render_code(<<<'PHP'
<?php
auriel_partials_register(
  'feature-showcase',
  array(
    'title' => __('Feature Showcase Partial', AURIEL_THEME_TEXT_DOMAIN),
    'post_types' => array('page'),
    'fields' => array(
      'heading' => array(
        'type' => 'text',
        'label' => __('Heading', AURIEL_THEME_TEXT_DOMAIN),
      ),
      'items' => array(
        'type' => 'repeater',
        'label' => __('Feature cards', AURIEL_THEME_TEXT_DOMAIN),
        'fields' => array(
          'title' => array(
            'type' => 'text',
            'label' => __('Card title', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'description' => array(
            'type' => 'textarea',
            'label' => __('Card body', AURIEL_THEME_TEXT_DOMAIN),
          ),
          'icon_image' => array(
            'type' => 'image',
            'label' => __('Icon image', AURIEL_THEME_TEXT_DOMAIN),
          ),
        ),
      ),
    ),
  )
);
PHP
      ); ?></code></div>
    </section>

    <section>
      <h2>2. Fetch the data inside the template</h2>
      <p>
        Call <code>auriel_partials_get_fields()</code> to collect all values, or <code>auriel_partials_get_field()</code>
        for a single entry.
      </p>
      <div class="auriel-guide__code"><code class="language-php"><?= $auriel_render_code(<<<'PHP'
<?php
auriel_partials_enqueue_script('feature-showcase');

$fields  = auriel_partials_get_fields('feature-showcase');
$heading = (string) ($fields['heading'] ?? '');
$items   = isset($fields['items']) && is_array($fields['items']) ? $fields['items'] : array();
PHP
      ); ?></code></div>
    </section>

    <section>
      <h2>3. Loop repeaters and render media</h2>
      <p>
        Repeaters return a simple array. Use the media helpers to pull <code>src</code>, <code>srcset</code>, and
        <code>alt</code> in one shot.
      </p>
      <div class="auriel-guide__code"><code class="language-php"><?= $auriel_render_code(<<<'PHP'
<?php if (!empty($items)) : ?>
  <div class="feature-grid">
    <?php foreach ($items as $item) : ?>
      <?php
      $title       = (string) ($item['title'] ?? '');
      $description = (string) ($item['description'] ?? '');
      $icon_id     = (int) ($item['icon_image'] ?? 0);
      $icon        = $icon_id > 0 ? auriel_theme_resolve_image_attributes($icon_id, 'thumbnail') : array();
      ?>
      <article class="feature-grid__card">
        <?php if (!empty($icon['src'])) : ?>
          <?= auriel_theme_render_image_from_attributes($icon, array('class' => 'feature-grid__icon', 'loading' => 'lazy')); ?>
        <?php endif; ?>
        <?php if ('' !== $title) : ?>
          <h3><?= esc_html($title); ?></h3>
        <?php endif; ?>
        <?php if ('' !== $description) : ?>
          <p><?= esc_html($description); ?></p>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
PHP
      ); ?></code></div>

      <div class="auriel-guide__grid">
        <div class="auriel-guide__grid-card">
          <h4>Sanitise on output</h4>
          <p>Use <code>esc_html()</code> for text, <code>esc_url()</code> for links, and the media helpers for images.</p>
        </div>
        <div class="auriel-guide__grid-card">
          <h4>Keep arrays defensive</h4>
          <p>Always confirm repeater values with <code>is_array()</code> before looping.</p>
        </div>
      </div>
    </section>

    <section>
      <h2>4. Include the partial anywhere</h2>
      <p>
        The registry auto-detects usage. As soon as a template calls the partial, the corresponding field group appears
        for editors.
      </p>
      <div class="auriel-guide__code"><code class="language-php"><?= $auriel_render_code(<<<'PHP'
<?php
get_template_part('partials/feature-showcase');
PHP
      ); ?></code></div>
    </section>

    <section>
      <h2>5. Reference: helper functions</h2>
      <div class="auriel-guide__grid">
        <div class="auriel-guide__grid-card">
          <h4>auriel_partials_register()</h4>
          <p>Define the fields and meta box for a partial.</p>
        </div>
        <div class="auriel-guide__grid-card">
          <h4>auriel_partials_get_fields()</h4>
          <p>Retrieve every stored value as an associative array.</p>
        </div>
        <div class="auriel-guide__grid-card">
          <h4>auriel_partials_get_field()</h4>
          <p>Fetch a single field with an optional default.</p>
        </div>
        <div class="auriel-guide__grid-card">
          <h4>auriel_partials_enqueue_script()</h4>
          <p>Load the matching <code>js/partials/&lt;slug&gt;.js</code> on the front end.</p>
        </div>
      </div>
    </section>

    <section>
      <h2>Bonus: media helpers</h2>
      <p>Use the bundled utilities to render WordPress attachments without repeating boilerplate.</p>
      <div class="auriel-guide__code"><code class="language-php"><?= $auriel_render_code(<<<'PHP'
$image = auriel_theme_resolve_image_attributes($attachment_id, 'large');
echo auriel_theme_render_image_from_attributes(
  $image,
  array(
    'class' => 'my-partial__hero',
    'loading' => 'lazy',
  )
);
PHP
      ); ?></code></div>
    </section>
  </article>
</main>
<?php
get_footer();
