<?php
/**
 * Template Name: Partial Showcase Guide
 * Description: Demonstrates how to work with theme partials and fields.
 */
declare(strict_types=1);

get_header();
?>
<main class="auriel-guide-body bg-surface py-16">
  <style>
    .auriel-guide {
      color: #0f172a;
      background: linear-gradient(180deg, rgba(241,245,249,0.6), rgba(226,232,240,0.4));
      border-radius: 18px;
      box-shadow: 0 24px 60px -30px rgba(15, 23, 42, 0.45);
      margin: 0 auto;
      max-width: 1040px;
      padding: 48px 56px;
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .auriel-guide h1,
    .auriel-guide h2,
    .auriel-guide h3 {
      font-weight: 700;
      color: #0b1120;
      margin-bottom: 16px;
    }
    .auriel-guide h1 {
      font-size: 42px;
      margin-bottom: 24px;
    }
    .auriel-guide h2 {
      font-size: 28px;
      margin-top: 48px;
    }
    .auriel-guide h3 {
      font-size: 20px;
      margin-top: 32px;
    }
    .auriel-guide p {
      line-height: 1.7;
      margin-bottom: 16px;
    }
    .auriel-guide__list {
      padding-left: 22px;
      margin-bottom: 16px;
      color: #1e293b;
    }
    .auriel-guide__card {
      border: 1px solid rgba(15, 23, 42, 0.08);
      border-radius: 14px;
      padding: 20px 24px;
      background: rgba(255, 255, 255, 0.92);
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
      margin-bottom: 24px;
    }
    .auriel-guide__code {
      position: relative;
      background: #0d1117;
      border-radius: 12px;
      border: 1px solid #1e293b;
      padding: 22px;
      margin: 24px 0;
      overflow-x: auto;
      box-shadow: inset 0 0 32px rgba(15, 23, 42, 0.45);
    }
    .auriel-guide__code code {
      color: #e9edf5;
      font-family: 'Fira Code', 'JetBrains Mono', Consolas, 'Courier New', monospace;
      font-size: 15px;
      line-height: 1.6;
      display: block;
      white-space: pre;
    }
    .auriel-guide__badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      border-radius: 999px;
      background: rgba(37, 99, 235, 0.12);
      color: #1d4ed8;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      margin-bottom: 18px;
    }
    .auriel-guide__grid {
      display: grid;
      gap: 20px;
    }
    @media (min-width: 880px) {
      .auriel-guide__grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }
    }
    .auriel-guide__grid-card {
      background: rgba(248, 250, 252, 0.96);
      border-radius: 12px;
      border: 1px solid rgba(15,23,42,0.08);
      padding: 20px 22px;
    }
    .auriel-guide__grid-card h4 {
      margin: 0 0 12px;
      font-weight: 600;
      color: #0f172a;
      font-size: 18px;
    }
    .auriel-guide__grid-card p {
      margin: 0;
      font-size: 14px;
      color: #334155;
    }
  </style>

  <article class="auriel-guide">
    <div class="auriel-guide__badge">WordPress partial toolkit</div>
    <h1>Build custom sections with the Auriel partial system</h1>
    <p>
      This theme ships with a compact registry that lets you create bespoke page sections (partials) without reaching
      for large field frameworks. Everything is plain PHP and native WordPress APIs, so you stay in control while your
      content editors work with an intuitive UI.
    </p>

    <section>
      <h2>1. Register fields with <code>auriel_partials_register()</code></h2>
      <p>
        Drop a definition file inside <code>inc/partials/&lt;slug&gt;.php</code>. The registry handles meta boxes,
        sanitisation, and saving; you just describe the fields you need.
      </p>
      <div class="auriel-guide__code">
        <code class="language-php"><?php echo esc_html(
"<?php
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
          'title' => array( 'type' => 'text', 'label' => __('Card title', AURIEL_THEME_TEXT_DOMAIN) ),
          'description' => array( 'type' => 'textarea', 'label' => __('Card body', AURIEL_THEME_TEXT_DOMAIN) ),
          'icon_image' => array( 'type' => 'image', 'label' => __('Icon image', AURIEL_THEME_TEXT_DOMAIN) ),
        ),
      ),
    ),
  )
);" ); ?></code>
      </div>
      <p>
        Available field types: <strong>text</strong>, <strong>textarea</strong>, <strong>editor</strong>,
        <strong>url</strong>, <strong>image</strong>, and <strong>repeater</strong> (repeaters accept any of the other
        types as sub-fields).
      </p>
    </section>

    <section>
      <h2>2. Render the partial in your template</h2>
      <div class="auriel-guide__code">
        <code class="language-php"><?php echo esc_html(
"<?php
auriel_partials_enqueue_script('feature-showcase');

$fields = auriel_partials_get_fields('feature-showcase');
$heading = (string) ($fields['heading'] ?? '');
$items = isset($fields['items']) && is_array($fields['items']) ? $fields['items'] : array();
?>" ); ?></code>
      </div>

      <p>
        Fetch fields with <code>auriel_partials_get_fields()</code> to receive an associative array keyed by your field
        names. Access individual values with <code>auriel_partials_get_field($slug, $field)</code> if you prefer to pull
        them one at a time.
      </p>

      <div class="auriel-guide__code">
        <code class="language-php"><?php echo esc_html(
"<?php if (!empty($items)) : ?>
  <div class=\"feature-grid\">
    <?php foreach ($items as $item) : ?>
      <?php
      $title = (string) ($item['title'] ?? '');
      $description = (string) ($item['description'] ?? '');
      $icon_id = (int) ($item['icon_image'] ?? 0);
      $icon = $icon_id ? auriel_theme_resolve_image_attributes($icon_id, 'thumbnail') : array();
      ?>
      <article class=\"feature-grid__card\">
        <?php if (!empty($icon['src'])) : ?>
          <?php echo auriel_theme_render_image_from_attributes($icon, array('class' => 'feature-grid__icon')); ?>
        <?php endif; ?>
        <h3><?php echo esc_html($title); ?></h3>
        <p><?php echo esc_html($description); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>" ); ?></code>
      </div>
    </section>

    <section>
      <h2>3. Looping repeaters</h2>
      <p>
        Repeater fields return a plain array. No special helpers are required—iterate it with <code>foreach</code>, and
        cast values to strings or integers before printing.
      </p>
      <div class="auriel-guide__grid">
        <div class="auriel-guide__grid-card">
          <h4>Check structure</h4>
          <p>
            Always ensure the repeater result is an array:
            <code>$items = is_array($fields['items'] ?? null) ? $fields['items'] : array();</code>
          </p>
        </div>
        <div class="auriel-guide__grid-card">
          <h4>Sanitise output</h4>
          <p>
            Use <code>esc_html()</code> for plain text, <code>esc_url()</code> for links, and
            <code>auriel_theme_render_image_from_attributes()</code> for WordPress media attachments.
          </p>
        </div>
      </div>
    </section>

    <section>
      <h2>4. Available helper functions</h2>
      <div class="auriel-guide__card">
        <h3><code>auriel_partials_register( $slug, $config )</code></h3>
        <p>
          Registers the partial, defines its field schema, and wires the admin meta box. Call this once per partial from
          <code>inc/partials/&lt;slug&gt;.php</code>.
        </p>
      </div>

      <div class="auriel-guide__card">
        <h3><code>auriel_partials_get_fields( $slug, $post_id = 0 )</code></h3>
        <p>
          Returns an associative array of stored values. When <code>$post_id</code> is omitted, the helper uses the
          current loop's post ID.
        </p>
      </div>

      <div class="auriel-guide__card">
        <h3><code>auriel_partials_get_field( $slug, $field, $default = '' )</code></h3>
        <p>
          Convenience wrapper to pull a single field. Handy when you only need one value—for example, a button label or
          URL.
        </p>
      </div>

      <div class="auriel-guide__card">
        <h3><code>auriel_partials_enqueue_script( $slug )</code></h3>
        <p>
          Loads <code>js/partials/&lt;slug&gt;.js</code> on the front end. Admin behaviour (media picker, repeater UI)
          is handled automatically via <code>assets/admin/partial-manager.js</code>.
        </p>
      </div>
    </section>

    <section>
      <h2>5. Putting it all together</h2>
      <p>
        Include your partial from any template or block of PHP with <code>get_template_part('partials/&lt;slug&gt;')</code>.
        The registry detects usage automatically and only shows the related field group to editors when the template
        loads that partial.
      </p>
      <div class="auriel-guide__code">
        <code class="language-php"><?php echo esc_html(
"<?php
/* Template snippet */
get_template_part('partials/feature-showcase');
" ); ?></code>
      </div>
    </section>

    <section>
      <h2>Bonus: Media helpers</h2>
      <p>
        Fetch image attributes in one go with <code>auriel_theme_resolve_image_attributes()</code>, then render the tag
        with <code>auriel_theme_render_image_from_attributes()</code>. Both live in
        <code>inc/functions/media.php</code>.
      </p>
      <div class="auriel-guide__code">
        <code class="language-php"><?php echo esc_html(
"$image = auriel_theme_resolve_image_attributes($attachment_id, 'large');
echo auriel_theme_render_image_from_attributes(
  $image,
  array(
    'class' => 'my-partial__hero',
    'loading' => 'lazy',
  )
);" ); ?></code>
      </div>
    </section>
  </article>
</main>
<?php
get_footer();
