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
    <nav class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-[10px_10px] border border-white/25 rounded-full bg-white/10
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
      <svg width="0" height="0" class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg">
        <filter id="glass-distort" x="0%" y="0%" width="100%" height="100%" filterUnits="objectBoundingBox">
          <!-- Step 1: Generate noise (monochrome preferred for subtle distortion) -->
          <feTurbulence type="turbulence" baseFrequency="0.01 0.02" numOctaves="3" seed="2" result="noise" />

          <!-- Step 2: Soften noise for a glassy ripple effect -->
          <feGaussianBlur in="noise" stdDeviation="8" result="softNoise" />

          <!-- Step 3: Displace underlying content using filtered noise -->
          <feDisplacementMap in="SourceGraphic" in2="softNoise" scale="40" xChannelSelector="R" yChannelSelector="G" result="distorted" />

          <!-- Step 4: Optional extra blur to improve glass feel -->
          <feGaussianBlur in="distorted" stdDeviation="3" result="final" />

          <!-- Export -->
          <feBlend in="final" in2="softNoise" mode="normal" />
        </filter>
      </svg>

      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
      ));
      ?>
    </nav>
  </header>