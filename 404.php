<?php
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main bg-surface text-text">
  <section class="relative flex min-h-[70vh] items-center justify-center overflow-hidden px-6 py-24">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/15 via-accent/10 to-secondary/15"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.35),_transparent_65%)]"></div>

    <div class="relative mx-auto flex max-w-3xl flex-col items-center gap-8 text-center">
      <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-primary/80">
        <?php esc_html_e('404', 'auriel-theme'); ?>
      </span>
      <h1 class="font-libre text-4xl font-semibold text-text md:text-5xl lg:text-6xl">
        <?php esc_html_e('Aradığınız Sayfayı Bulamadık.', 'auriel-theme'); ?>
      </h1>
      <p class="max-w-2xl text-base leading-relaxed text-text/70 md:text-lg">
        <?php esc_html_e('Var olmayan bir sayfaya ulaşmaya çalıştınız.', 'auriel-theme'); ?>
      </p>
      <div class="flex flex-wrap items-center justify-center gap-4">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="rounded-full bg-primary px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-primary/90">
          <?php esc_html_e('Anasayfaya git', 'auriel-theme'); ?>
        </a>
        <?php
        $blog_page_id = (int) get_option('page_for_posts');
        $blog_url = $blog_page_id > 0 ? get_permalink($blog_page_id) : get_post_type_archive_link('post');
        if ($blog_url):
          ?>
          <a href="<?php echo esc_url($blog_url); ?>" class="rounded-full border border-text/20 px-6 py-3 text-sm font-semibold uppercase tracking-[0.3em] text-text transition hover:border-primary/40 hover:text-primary">
            <?php esc_html_e('Blog sayfasına git', 'auriel-theme'); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
