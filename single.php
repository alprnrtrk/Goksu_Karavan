<?php
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main bg-surface text-text">
  <?php if (have_posts()): ?>
    <?php while (have_posts()):
      the_post(); ?>
      <?php
      $has_thumbnail = has_post_thumbnail();
      $thumbnail_html = '';

      if ($has_thumbnail) {
        $thumbnail_html = get_the_post_thumbnail(
          null,
          'full',
          array(
            'class' => 'absolute inset-0 h-full w-full object-cover',
            'loading' => 'eager',
          )
        );
      }

      $categories = get_the_category();
      $tags = get_the_tags();
      ?>
      <article <?php post_class('relative flex flex-col'); ?>>
        <header class="relative isolate">
          <div class="relative flex items-center justify-center h-[60vh] min-h-[320px] w-full overflow-hidden">
            <?php if ('' !== $thumbnail_html): ?>
              <?php echo $thumbnail_html; ?>
              <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/70 to-transparent"></div>
            <?php else: ?>
              <div class="absolute inset-0 bg-gradient-to-br from-primary/15 via-accent/10 to-secondary/15"></div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.42),_transparent_55%)]"></div>
            <div class="mx-auto w-full max-w-4xl px-6">
              <div class="glass-bg-strong rounded-3xl border border-white/20 bg-surface/85 p-10 shadow-2xl backdrop-saturate-150">
                <?php if (!empty($categories)): ?>
                  <div class="flex flex-wrap gap-2">
                    <?php foreach ($categories as $category): ?>
                      <a class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-primary/80 transition hover:bg-primary/15 hover:text-primary" href="<?php echo esc_url(get_category_link($category)); ?>">
                        <?php echo esc_html($category->name); ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
                <h1 class="mt-6 font-libre text-4xl font-semibold text-text md:text-3xl">
                  <?php the_title(); ?>
                </h1>
                <div class="mt-6 flex flex-wrap items-center gap-5 text-sm text-text/70">
                  <div class="flex items-center gap-3">
                    <?php echo get_avatar(get_the_author_meta('ID'), 64, '', '', array('class' => 'h-12 w-12 rounded-full border border-white/60 shadow-lg')); ?>
                    <span class="font-medium text-text">
                      <?php echo esc_html(get_the_author_meta('display_name')); ?>
                    </span>
                  </div>
                  <span class="hidden h-1 w-1 rounded-full bg-text/40 md:inline-block" aria-hidden="true"></span>
                  <time class="text-text/60" datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>">
                    <?php echo esc_html(get_the_date('F j, Y')); ?>
                  </time>
                  <?php if (!empty($tags)): ?>
                    <span class="hidden h-1 w-1 rounded-full bg-text/40 md:inline-block" aria-hidden="true"></span>
                    <div class="flex flex-wrap gap-2">
                      <?php foreach ($tags as $tag): ?>
                        <span class="rounded-full bg-text/5 px-3 py-1 text-xs font-medium uppercase tracking-wide text-text/70">
                          <?php echo esc_html($tag->name); ?>
                        </span>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </header>

        <div class="pt-32">
          <div class="mx-auto w-full max-w-4xl px-6 pb-20">
            <div class="single-post-content space-y-8 text-lg leading-relaxed text-text/90">
              <?php the_content(); ?>
            </div>
            <?php
            wp_link_pages(
              array(
                'before' => '<nav class="mt-12 flex flex-wrap items-center gap-3 text-sm text-primary" aria-label="' . esc_attr__('Post pages', 'auriel-theme') . '">',
                'after' => '</nav>',
                'link_before' => '<span class="rounded-full border border-primary/40 px-4 py-2 transition hover:bg-primary/10">',
                'link_after' => '</span>',
              )
            );
            ?>
          </div>
        </div>
      </article>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="mx-auto max-w-3xl px-6 py-24 text-center text-lg text-text/80">
      <?php esc_html_e('The content you are looking for could not be found.', 'auriel-theme'); ?>
    </div>
  <?php endif; ?>
</main>
<?php
get_footer();
