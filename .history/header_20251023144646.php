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
    <a href="<?php echo esc_url(home_url('/')); ?>" class="fixed z-[88] top-0 left-[30px] md:left-[20px] w-[100px] md:scale-[.8] md:origin-top-left p-[15px] pb-[30px] border border-white/25 rounded-b-full overflow-hidden">
      <div class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg">
        <svg width="0" height="0" class="absolute z-[-1]">
          <filter id="realistic-glass-lens" x="0%" y="0%" width="100%" height="100%">
            <feImage preserveAspectRatio="none" result="radialMap" href="data:image/svg+xml;utf8,
                  <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
                    <radialGradient id='g' cx='50%' cy='50%' r='50%'>
                      <stop offset='0%' stop-color='rgb(128,128,128)'/>  <!-- center neutral -->
                      <stop offset='70%' stop-color='rgb(135,135,135)'/> <!-- almost neutral -->
                      <stop offset='80%' stop-color='rgb(200,200,200)'/> <!-- some push -->
                      <stop offset='100%' stop-color='rgb(255,255,255)'/> <!-- strongest -->
                    </radialGradient>
                    <rect x='0' y='0' width='100' height='100' fill='url(%23g)'/>
                  </svg>" />
            <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="30" xChannelSelector="R" yChannelSelector="G" result="distorted" />
            <feGaussianBlur in="distorted" stdDeviation="0.7" result="softened" />
          </filter>
        </svg>
      </div>
      <img class="w-full h-full object-contain object-center invert" src="<?php echo esc_url(auriel_theme_resolve_image_attributes(auriel_theme_get_design_token('brand_logo'))['src']) ?>" alt="<?php echo esc_url(auriel_theme_resolve_image_attributes(auriel_theme_get_design_token('brand_logo'))['alt']) ?>">
    </a>
    <button data-mobile-toggler class="group/toggle min-md:hidden fixed z-[88] top-[20px] right-[20px] size-[60px] rounded-full border border-white/25 overflow-hidden">
      <div class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg">
        <svg width="0" height="0" class="absolute z-[-1]">
          <filter id="realistic-glass-lens" x="0%" y="0%" width="100%" height="100%">
            <feImage preserveAspectRatio="none" result="radialMap" href="data:image/svg+xml;utf8,
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
                      <radialGradient id='g' cx='50%' cy='50%' r='50%'>
                        <stop offset='0%' stop-color='rgb(128,128,128)'/>  <!-- center neutral -->
                        <stop offset='70%' stop-color='rgb(135,135,135)'/> <!-- almost neutral -->
                        <stop offset='80%' stop-color='rgb(200,200,200)'/> <!-- some push -->
                        <stop offset='100%' stop-color='rgb(255,255,255)'/> <!-- strongest -->
                      </radialGradient>
                      <rect x='0' y='0' width='100' height='100' fill='url(%23g)'/>
                    </svg>" />
            <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="30" xChannelSelector="R" yChannelSelector="G" result="distorted" />
            <feGaussianBlur in="distorted" stdDeviation="0.7" result="softened" />
          </filter>
        </svg>
      </div>
      <div class="flex flex-col gap-[5px] items-center justify-center group-[&.active]/toggle:translate-y-[-3px]">
        <span class="-group-[&.active]/toggle:translate-y-[7px] group-[&.active]/toggle:translate-x-[4px] group-[&.active]/toggle:rotate-45 origin-left block w-[30px] h-[2px] bg-white duration-500"></span>
        <span class="group-[&.active]/toggle:opacity-0 block w-[30px] h-[2px] bg-white duration-500"></span>
        <span class="group-[&.active]/toggle:translate-y-[7px] group-[&.active]/toggle:translate-x-[4px] group-[&.active]/toggle:-rotate-45 origin-left block w-[30px] h-[2px] bg-white duration-500"></span>
      </div>
    </button>
    <div data-mobile-menu class="md:[&.active]:translate-x-0 md:translate-x-full md:absolute md:top-0 md:right-0 md:w-full md:h-screen md:flex md:flex-col md:p-[15px] md:bg-primary/25 md:backdrop-blur-2xl duration-500 ease-smooth">
      <nav class="min-md:absolute top-1/2 left-1/2 min-md:-translate-x-1/2 min-md:-translate-y-1/2 p-[15px_10px] md:pt-[120px] min-md:border border-white/25 min-md:rounded-full overflow-hidden [&>.menu]: [&>.menu>ul]:flex md:[&>.menu>ul]:flex-col [&>.menu>ul]:gap-[10px] [&>.menu>ul]:p-[5px_0px] [&>.menu>ul>li>a]:p-[10px_15px] md:[&>.menu>ul>li>a]:p-[10px_0px] min-md:[&>.menu>ul>li>a]:border min-md:[&>.menu>ul>li>a]:rounded-full [&>.menu>ul>li>a]:border-white/25 [&>.menu>ul>li>a]:text-white md:[&>.menu>ul>li>a]:text-3xl [&>.menu>ul>li>a]:font-semibold [&>.menu>ul>li>a]:tracking-widest min-md:[&>.menu>ul>li>a]:backdrop-blur-3xl min-md:[&>.menu>ul>li>a]:backdrop-brightness-[.99] [&>.menu>ul>li>a]:duration-500 [&>.menu>ul>li>a:hover]:bg-primary/50">
        <div class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg">
          <svg width="0" height="0" class="absolute z-[-1]">
            <filter id="realistic-glass-lens" x="0%" y="0%" width="100%" height="100%">
              <feImage preserveAspectRatio="none" result="radialMap" href="data:image/svg+xml;utf8,
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
                      <radialGradient id='g' cx='50%' cy='50%' r='50%'>
                        <stop offset='0%' stop-color='rgb(128,128,128)'/>  <!-- center neutral -->
                        <stop offset='70%' stop-color='rgb(135,135,135)'/> <!-- almost neutral -->
                        <stop offset='80%' stop-color='rgb(200,200,200)'/> <!-- some push -->
                        <stop offset='100%' stop-color='rgb(255,255,255)'/> <!-- strongest -->
                      </radialGradient>
                      <rect x='0' y='0' width='100' height='100' fill='url(%23g)'/>
                    </svg>" />
              <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="30" xChannelSelector="R" yChannelSelector="G" result="distorted" />
              <feGaussianBlur in="distorted" stdDeviation="0.7" result="softened" />
            </filter>
          </svg>
        </div>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'primary-menu',
        ));
        ?>
      </nav>
      <ul class="min-md:fixed top-1/2 min-md:-translate-y-1/2 right-[30px] flex min-md:flex-col items-center justify-center md:justify-start gap-[10px] p-[10px] md:mt-auto min-md:border border-white/25 rounded-full overflow-hidden">
        <div class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg">
          <svg width="0" height="0" class="absolute z-[-1]">
            <filter id="realistic-glass-lens" x="0%" y="0%" width="100%" height="100%">
              <feImage preserveAspectRatio="none" result="radialMap" href="data:image/svg+xml;utf8,
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
                      <radialGradient id='g' cx='50%' cy='50%' r='50%'>
                        <stop offset='0%' stop-color='rgb(128,128,128)'/>  <!-- center neutral -->
                        <stop offset='70%' stop-color='rgb(135,135,135)'/> <!-- almost neutral -->
                        <stop offset='80%' stop-color='rgb(200,200,200)'/> <!-- some push -->
                        <stop offset='100%' stop-color='rgb(255,255,255)'/> <!-- strongest -->
                      </radialGradient>
                      <rect x='0' y='0' width='100' height='100' fill='url(%23g)'/>
                    </svg>" />
              <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="30" xChannelSelector="R" yChannelSelector="G" result="distorted" />
              <feGaussianBlur in="distorted" stdDeviation="0.7" result="softened" />
            </filter>
          </svg>
        </div>
        <li>
          <a href="#" class="flex items-center justify-center size-[40px] md:size-[60px] rounded-full border border-white/25 hover:bg-primary/50 text-white/75 hover:text-white backdrop-blur-3xl backdrop-brightness-[.99] duration-500">
            <i class="fa-brands fa-twitter"></i>
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center justify-center size-[40px] md:size-[60px] rounded-full border border-white/25 hover:bg-primary/50 text-white/75 hover:text-white backdrop-blur-3xl backdrop-brightness-[.99] duration-500">
            <i class="fa-brands fa-twitter"></i>
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center justify-center size-[40px] md:size-[60px] rounded-full border border-white/25 hover:bg-primary/50 text-white/75 hover:text-white backdrop-blur-3xl backdrop-brightness-[.99] duration-500">
            <i class="fa-brands fa-twitter"></i>
          </a>
        </li>
      </ul>
    </div>
  </header>