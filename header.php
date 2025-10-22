<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', AURIEL_THEME_TEXT_DOMAIN); ?></a>
  <header id="masthead" class="site-header bg-white/80 backdrop-blur border-b border-text/10">
    <div class="site-header__inner mx-auto flex max-w-6xl items-center justify-between gap-6 px-6 py-4">
      <div class="site-branding flex items-center gap-4">
        <?php
        if (function_exists('the_custom_logo') && has_custom_logo()) {
          the_custom_logo();
        } else {
          ?>
          <a class="site-title text-lg font-semibold text-primary hover:text-primary/80 transition" href="<?php echo esc_url(home_url('/')); ?>">
            <?php bloginfo('name'); ?>
          </a>
          <?php
          $description = get_bloginfo('description', 'display');
          if ($description) {
            echo '<p class="site-description text-sm text-text/70">' . esc_html($description) . '</p>';
          }
        }
        ?>
      </div>
      <nav class="primary-navigation hidden items-center gap-6 text-sm font-medium text-text md:flex" aria-label="<?php esc_attr_e('Primary menu', AURIEL_THEME_TEXT_DOMAIN); ?>">
        <?php
        auriel_theme_render_menu(
          'primary',
          array(
            'menu_class' => 'primary-menu flex items-center gap-6',
            'menu_id' => 'primary-menu',
            'depth' => 2,
          )
        );
        ?>
      </nav>
      <button class="menu-toggle inline-flex items-center gap-2 rounded md:hidden" type="button" data-menu-toggle>
        <span class="sr-only"><?php esc_html_e('Toggle navigation', AURIEL_THEME_TEXT_DOMAIN); ?></span>
        <span class="h-0.5 w-5 bg-text"></span>
        <span class="h-0.5 w-5 bg-text"></span>
        <span class="h-0.5 w-5 bg-text"></span>
      </button>
    </div>
  </header>