<?php
declare(strict_types=1);

get_header();
?>
<?php
$posts_page_id = (int) get_option('page_for_posts');
$hero_has_thumbnail = $posts_page_id > 0 && has_post_thumbnail($posts_page_id);
$hero_image_url = '';

if ($hero_has_thumbnail) {
  $hero_image_url = wp_get_attachment_image_url(get_post_thumbnail_id($posts_page_id), 'full');
}
?>
<main id="main" class="site-main bg-surface text-text">
  <section class="relative isolate overflow-hidden">
    <?php if ($hero_has_thumbnail && '' !== $hero_image_url): ?>
      <div class="absolute inset-0">
        <img src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo esc_attr(get_the_title($posts_page_id)); ?>" class="h-full w-full object-cover" loading="lazy" />
      </div>
      <div class="absolute inset-0 bg-gradient-to-b from-surface/10 via-surface/70 to-surface"></div>
    <?php else: ?>
      <div class="absolute inset-0 bg-gradient-to-br from-primary/15 via-accent/10 to-secondary/15"></div>
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.35),_transparent_60%)]"></div>
    <?php endif; ?>
    <div class="relative mx-auto w-full max-w-5xl px-6 pb-24 pt-40 text-center">
      <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-primary/80">
        <?php esc_html_e('Haber Bültenimiz', 'auriel-theme'); ?>
      </span>
      <h1 class="mt-6 font-libre text-4xl font-semibold text-text md:text-3xl">
        <?php esc_html_e("Göksu Karavan'dan en güncel sektör gelişmelerini ve haberlerini dinleyin", 'auriel-theme'); ?>
      </h1>
      <p class="mx-auto mt-6 max-w-3xl text-base text-text/70 md:text-lg">
        <?php esc_html_e('Sizlerde sektör hakkında daha fazla bilgi almak ve Göksu Karavan çalışmaları hakkında detayları okumak için blog larımızı okuyun.', 'auriel-theme'); ?>
      </p>
    </div>
  </section>

  <section class="relative z-10 -mt-16 pb-20">
    <div class="mx-auto w-full max-w-6xl py-[40px] px-[150px] md:p-[15px]">
      <?php if (have_posts()): ?>
        <div class="grid gap-[30px] grid-cols-2 md:flex md:flex-col">
          <?php while (have_posts()):
            the_post(); ?>
            <?php
            $categories = get_the_category();
            $primary_category = $categories[0] ?? null;
            $thumbnail_html = '';

            if (has_post_thumbnail()) {
              $thumbnail_html = get_the_post_thumbnail(
                null,
                'large',
                array(
                  'class' => 'absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105',
                  'loading' => 'lazy',
                )
              );
            }

            $excerpt = wp_trim_words(get_the_excerpt(), 24, '&hellip;');
            ?>
            <article <?php post_class('group relative flex h-full flex-col p-[20px] overflow-hidden rounded-3xl border border-white/20 bg-surface/90 shadow-2xl backdrop-blur-xl'); ?>>
              <div class="relative overflow-hidden">
                <?php if ('' !== $thumbnail_html): ?>
                  <?php echo $thumbnail_html; ?>
                  <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/40 to-transparent transition duration-500 group-hover:from-surface/80"></div>
                <?php else: ?>
                  <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-accent/15 to-secondary/20"></div>
                  <div class="absolute inset-0 flex items-center justify-center text-5xl text-white/60">
                    <i class="fa-regular fa-image"></i>
                  </div>
                <?php endif; ?>
                <?php if ($primary_category instanceof WP_Term): ?>
                  <a class="absolute left-5 top-5 rounded-full bg-surface/85 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-primary transition hover:bg-surface" href="<?php echo esc_url(get_category_link($primary_category)); ?>">
                    <?php echo esc_html($primary_category->name); ?>
                  </a>
                <?php endif; ?>
              </div>

              <div class="flex flex-col gap-6 !p-[15px]">
                <div class="flex flex-col gap-[10px]">
                  <h2 class="text-2xl font-semibold text-text transition duration-300 group-hover:text-primary">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_title(); ?>
                    </a>
                  </h2>
                  <?php if (!empty($excerpt)): ?>
                    <p class="text-base leading-relaxed text-text/70">
                      <?php echo esc_html($excerpt); ?>
                    </p>
                  <?php endif; ?>
                </div>
                <div class="mt-auto flex items-center justify-between text-xs uppercase tracking-[0.3em] text-text/60">
                  <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>">
                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                  </time>
                  <a class="flex items-center gap-2 text-primary transition hover:text-primary/80" href="<?php the_permalink(); ?>">
                    <?php esc_html_e('Read More', 'auriel-theme'); ?>
                    <svg class="size-4 transition duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M5 12h14"></path>
                      <path d="m13 5 7 7-7 7"></path>
                    </svg>
                  </a>
                </div>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

        <div class="mt-16 flex justify-center">
          <?php
          the_posts_pagination(
            array(
              'mid_size' => 1,
              'prev_text' => '<span class="px-4 py-2">' . esc_html__('Previous', 'auriel-theme') . '</span>',
              'next_text' => '<span class="px-4 py-2">' . esc_html__('Next', 'auriel-theme') . '</span>',
              'before_page_number' => '<span class="px-4 py-2">',
              'after_page_number' => '</span>',
              'screen_reader_text' => esc_html__('Posts navigation', 'auriel-theme'),
            )
          );
          ?>
        </div>
      <?php else: ?>
        <div class="rounded-3xl border border-white/20 bg-surface/80 px-8 py-16 text-center shadow-2xl backdrop-blur-xl">
          <h2 class="text-2xl font-semibold text-text">
            <?php esc_html_e('No posts yet', 'auriel-theme'); ?>
          </h2>
          <p class="mt-4 text-text/70">
            <?php esc_html_e('Once you publish your first story it will appear here.', 'auriel-theme'); ?>
          </p>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php
get_footer();
