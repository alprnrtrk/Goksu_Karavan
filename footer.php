<footer id="colophon" class="site-footer border-t border-text/10 bg-white/70 backdrop-blur">
  <div class="site-footer__inner mx-auto flex max-w-6xl flex-col items-center gap-4 px-6 py-6 text-sm text-text/70 md:flex-row md:justify-between">
    <nav class="footer-navigation" aria-label="<?php esc_attr_e('Footer menu', AURIEL_THEME_TEXT_DOMAIN); ?>">
      <?php
      auriel_theme_render_menu(
        'footer',
        array(
          'menu_class' => 'footer-menu flex flex-wrap items-center justify-center gap-4 md:justify-start',
          'menu_id' => 'footer-menu',
          'depth' => 1,
        )
      );
      ?>
    </nav>
    <div class="site-info text-center md:text-right">
      &copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>.
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
