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
    <nav class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-[10px_10px] border border-white/25 rounded-full bg-white/10 backdrop-blur-3xl
      [&>.menu]:
      [&>.menu>ul]:flex
      [&>.menu>ul]:gap-[10px]
      [&>.menu>ul]:p-[5px_0px]
      [&>.menu>ul>li>a]:p-[10px_15px]
      [&>.menu>ul>li>a]:border
      [&>.menu>ul>li>a]:rounded-full
      [&>.menu>ul>li>a]:border-white/25
      [&>.menu>ul>li>a]:text-white
      [&>.menu>ul>li>a]:font-semibold
      [&>.menu>ul>li>a]:tracking-widest
      [&>.menu>ul>li>a]:duration-500
      [&>.menu>ul>li>a:hover]:bg-primary/50
    ">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
        'container' => false,
        'fallback_cb' => false,
      ));
      ?>
    </nav>
  </header>