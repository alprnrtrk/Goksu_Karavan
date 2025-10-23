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
      <svg class="w-full h-full pointer-events-none absolute inset-0 -z-10" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <filter id="glass-filter--r3-" color-interpolation-filters="sRGB" x="0%" y="0%" width="100%" height="100%">
            <feImage x="0" y="0" width="100%" height="100%" preserveAspectRatio="none" result="map" href="data:image/svg+xml,%0A%20%20%20%20%20%20%3Csvg%20viewBox%3D%220%200%20382%2064%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%0A%20%20%20%20%20%20%20%20%3Cdefs%3E%0A%20%20%20%20%20%20%20%20%20%20%3ClinearGradient%20id%3D%22red-grad--r3-%22%20x1%3D%22100%25%22%20y1%3D%220%25%22%20x2%3D%220%25%22%20y2%3D%220%25%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cstop%20offset%3D%220%25%22%20stop-color%3D%22%230000%22%2F%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cstop%20offset%3D%22100%25%22%20stop-color%3D%22red%22%2F%3E%0A%20%20%20%20%20%20%20%20%20%20%3C%2FlinearGradient%3E%0A%20%20%20%20%20%20%20%20%20%20%3ClinearGradient%20id%3D%22blue-grad--r3-%22%20x1%3D%220%25%22%20y1%3D%220%25%22%20x2%3D%220%25%22%20y2%3D%22100%25%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cstop%20offset%3D%220%25%22%20stop-color%3D%22%230000%22%2F%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Cstop%20offset%3D%22100%25%22%20stop-color%3D%22blue%22%2F%3E%0A%20%20%20%20%20%20%20%20%20%20%3C%2FlinearGradient%3E%0A%20%20%20%20%20%20%20%20%3C%2Fdefs%3E%0A%20%20%20%20%20%20%20%20%3Crect%20x%3D%220%22%20y%3D%220%22%20width%3D%22382%22%20height%3D%2264%22%20fill%3D%22black%22%3E%3C%2Frect%3E%0A%20%20%20%20%20%20%20%20%3Crect%20x%3D%220%22%20y%3D%220%22%20width%3D%22382%22%20height%3D%2264%22%20rx%3D%2250%22%20fill%3D%22url(%23red-grad--r3-)%22%20%2F%3E%0A%20%20%20%20%20%20%20%20%3Crect%20x%3D%220%22%20y%3D%220%22%20width%3D%22382%22%20height%3D%2264%22%20rx%3D%2250%22%20fill%3D%22url(%23blue-grad--r3-)%22%20style%3D%22mix-blend-mode%3A%20difference%22%20%2F%3E%0A%20%20%20%20%20%20%20%20%3Crect%20x%3D%222.24%22%20y%3D%222.24%22%20width%3D%22377.52%22%20height%3D%2259.519999999999996%22%20rx%3D%2250%22%20fill%3D%22hsl(0%200%25%200.1%25%20%2F%200.7)%22%20style%3D%22filter%3Ablur(4px)%22%20%2F%3E%0A%20%20%20%20%20%20%3C%2Fsvg%3E%0A%20%20%20%20"></feImage>
            <feDisplacementMap in="SourceGraphic" in2="map" id="redchannel" result="dispRed" scale="-60" xChannelSelector="R" yChannelSelector="G"></feDisplacementMap>
            <feColorMatrix in="dispRed" type="matrix" values="1 0 0 0 0
                      0 0 0 0 0
                      0 0 0 0 0
                      0 0 0 1 0" result="red"></feColorMatrix>
            <feDisplacementMap in="SourceGraphic" in2="map" id="greenchannel" result="dispGreen" scale="-50" xChannelSelector="R" yChannelSelector="G"></feDisplacementMap>
            <feColorMatrix in="dispGreen" type="matrix" values="0 0 0 0 0
                      0 1 0 0 0
                      0 0 0 0 0
                      0 0 0 1 0" result="green"></feColorMatrix>
            <feDisplacementMap in="SourceGraphic" in2="map" id="bluechannel" result="dispBlue" scale="-40" xChannelSelector="R" yChannelSelector="G"></feDisplacementMap>
            <feColorMatrix in="dispBlue" type="matrix" values="0 0 0 0 0
                      0 0 0 0 0
                      0 0 1 0 0
                      0 0 0 1 0" result="blue"></feColorMatrix>
            <feBlend in="red" in2="green" mode="screen" result="rg"></feBlend>
            <feBlend in="rg" in2="blue" mode="screen" result="output"></feBlend>
            <feGaussianBlur in="output" stdDeviation="0"></feGaussianBlur>
          </filter>
        </defs>
      </svg>
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary-menu',
      ));
      ?>
    </nav>
  </header>