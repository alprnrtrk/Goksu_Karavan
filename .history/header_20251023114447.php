<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header class="fixed z-[999] top-0 left-0 w-full h-[100px]">
    <a href=""></a>
    <nav class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-[10px_20px] border border-white/25 rounded-full bg-primary/50 backdrop-blur-xl
      [&>.menu]:
      [&>.menu>ul]:flex
      [&>.menu>ul]:gap-[15px]
      [&>.menu>ul>li]:
      [&>.menu>ul>li>a]:text-white
      [&>.menu>ul>li>a]:p-[10px_5px]
      [&>.menu>ul>li>a]:bg-primary/60
      [&>.menu>ul>li>a]:
      [&>.menu>ul>li>a]:
      [&>.menu>ul>li>a]:font-semibold
      [&>.menu>ul>li>a]:tracking-widest
    ">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
      ));
      ?>
    </nav>
  </header>