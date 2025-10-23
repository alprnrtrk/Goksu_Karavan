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
    <a href="<?php echo esc_url(home_url('/')); ?>">
      <?php ?>
    </a>
    <nav class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-[10px_10px] border border-white/25 rounded-full bg-white/10 overflow-hidden
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
      [&>.menu>ul>li>a]:backdrop-blur-xl
      [&>.menu>ul>li>a]:duration-500
      [&>.menu>ul>li>a:hover]:bg-primary/50
    ">

      <div class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg">
        <svg width="0" height="0" class="absolute z-[-1]">
          <filter id="realistic-glass-lens" x="0%" y="0%" width="100%" height="100%">

            <!-- Step 1: Radial Map with strong edge intensity -->
            <feImage preserveAspectRatio="none" result="radialMap" href="data:image/svg+xml;utf8,
          <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
            <radialGradient id='g' cx='50%' cy='50%' r='50%'>
              <stop offset='0%' stop-color='rgb(128,128,128)'/>  <!-- center neutral -->
              <stop offset='50%' stop-color='rgb(135,135,135)'/> <!-- almost neutral -->
              <stop offset='85%' stop-color='rgb(200,200,200)'/> <!-- some push -->
              <stop offset='100%' stop-color='rgb(255,255,255)'/> <!-- strongest -->
            </radialGradient>
            <rect x='0' y='0' width='100' height='100' fill='url(%23g)'/>
          </svg>" />

            <!-- Step 2: Edge-focused displacement -->
            <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="60" xChannelSelector="R" yChannelSelector="G" result="distorted" />

            <!-- Step 3: Slight blur to soften the warped zone -->
            <feGaussianBlur in="distorted" stdDeviation="1" result="softened" />

            <!-- Final blend -->
            <feBlend in="softened" in2="SourceGraphic" mode="lighter" />
          </filter>
        </svg>
      </div>


      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
      ));
      ?>
    </nav>
  </header>