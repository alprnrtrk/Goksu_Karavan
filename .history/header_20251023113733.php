<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header class="relative z-[999] top-0 left-0 w-full h-[100px]">
    <a href=""></a>
    <nav class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
      ));
      ?>
    </nav>
  </header>