<?php
$contact = auriel_theme_get_design_token('footer_phone')
  ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header class="group/header fixed z-[999] top-0 left-0 w-full h-[100px]">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="min-md:group-[&.scrolled-down]/header:-translate-y-[150px] fixed z-[88] top-0 left-[30px] md:left-[20px] w-[100px] md:scale-[.8] md:origin-top-left min-md:hover:pt-[30px] border border-t-0 border-white/25 bg-primary/15 rounded-b-full overflow-hidden duration-500">
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
      <img class="w-full h-full object-contain object-center brightness-0 invert" src="<?php echo esc_url(auriel_theme_resolve_image_attributes(auriel_theme_get_design_token('brand_logo'))['src']) ?>" alt="<?php echo esc_url(auriel_theme_resolve_image_attributes(auriel_theme_get_design_token('brand_logo'))['alt']) ?>">
    </a>
    <button data-mobile-toggler class="group/toggle min-md:hidden fixed z-[88] top-[20px] right-[20px] size-[60px] rounded-full border border-white/25 bg-primary/15 overflow-hidden">
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
    <div data-mobile-menu class="md:[&.active]:translate-x-0 md:translate-x-full md:absolute md:top-0 md:right-0 md:w-full md:h-screen md:flex md:flex-col md:p-[15px] md:bg-primary/15 md:backdrop-blur-3xl duration-500 ease-smooth">
      <nav class="min-md:group-[&.scrolled-down]/header:-translate-y-[150px] min-md:absolute top-1/2 left-1/2 min-md:-translate-x-1/2 min-md:-translate-y-1/2 p-[15px_10px] md:pt-[120px] min-md:border border-white/25 min-md:bg-primary/15 min-md:rounded-full [&>ul]:flex md:[&>ul]:flex-col [&>ul]:gap-[10px] [&>ul]:p-[5px_0px] [&>ul>li>a]:p-[10px_15px] md:[&>ul>li>a]:p-[10px_0px] min-md:[&>ul>li>a]:border min-md:[&>ul>li>a]:rounded-full [&>ul>li>a]:border-white/25 [&>ul>li>a]:text-white md:[&>ul>li>a]:text-3xl [&>ul>li>a]:font-semibold [&>ul>li>a]:tracking-widest min-md:[&>ul>li>a]:backdrop-blur-3xl min-md:[&>ul>li>a]:backdrop-brightness-[.99] [&>ul>li>a]:duration-500 [&>ul>li>a:hover]:bg-primary/50 duration-500 [&_li]:relative [&_li:hover>.sub-menu]:opacity-100 [&_li:hover>.sub-menu]:translate-y-0 min-md:[&_.sub-menu]:-translate-y-full min-md:[&_.sub-menu]:opacity-0 min-md:[&_.sub-menu]:absolute md:[&_.sub-menu]:before:hidden [&_.sub-menu]:before:absolute [&_.sub-menu]:before:top-0 [&_.sub-menu]:before:left-0 [&_.sub-menu]:before:-translate-y-full [&_.sub-menu]:before:w-full [&_.sub-menu]:before:h-[30px] [&_.sub-menu]:top-[calc(100%+30px)] [&_.sub-menu]:left-0 [&_.sub-menu]:min-w-full [&_.sub-menu]:w-max [&_.sub-menu]:h-max md:[&_.sub-menu]:py-[5px] md:[&_.sub-menu]:pl-[15px] md:[&_.sub-menu]:border-l md:[&_.sub-menu]:text-2xl min-md:[&_.sub-menu]:p-[10px] min-md:[&_.sub-menu]:bg-white/10 min-md:[&_.sub-menu]:backdrop-blur-xl min-md:[&_.sub-menu]:backdrop-brightness-[.8] min-md:[&_.sub-menu]:border min-md:[&_.sub-menu]:border-white/25 min-md:[&_.sub-menu]:rounded-[10px] [&_.sub-menu]:text-white [&_.sub-menu]:font-semibold [&_.sub-menu]:tracking-wider [&_.sub-menu]:duration-500">
        <div class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg min-md:rounded-full overflow-hidden">
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
          'container' => false,
          'menu_class' => '',
          'menu_id' => '',
          'fallback_cb' => false,
        ));
        ?>
      </nav>
      <ul class="min-md:fixed top-1/2 min-md:-translate-y-1/2 right-[30px] flex min-md:flex-col items-center justify-center md:justify-start gap-[10px] p-[7px_5px] md:mt-auto min-md:border border-white/25 bg-primary/15 rounded-full overflow-hidden">
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
        $social_twitter = auriel_theme_get_design_token('social_twitter');
        $social_twitter = is_string($social_twitter) ? trim($social_twitter) : '';
        $social_facebook = auriel_theme_get_design_token('social_facebook');
        $social_facebook = is_string($social_facebook) ? trim($social_facebook) : '';
        $social_instagram = auriel_theme_get_design_token('social_instagram');
        $social_instagram = is_string($social_instagram) ? trim($social_instagram) : '';
        $social_youtube = auriel_theme_get_design_token('social_youtube');
        $social_youtube = is_string($social_youtube) ? trim($social_youtube) : '';
        ?>
        <?php if ($social_twitter !== '' && filter_var($social_twitter, FILTER_VALIDATE_URL)): ?>
          <li>
            <a href="<?php echo esc_url($social_twitter); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center size-[40px] md:size-[60px] rounded-full border border-white/25 hover:bg-primary/50 text-white/75 hover:text-white backdrop-blur-3xl backdrop-brightness-[.99] duration-500">
              <i class="fa-brands fa-twitter"></i>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($social_facebook !== '' && filter_var($social_facebook, FILTER_VALIDATE_URL)): ?>
          <li>
            <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center size-[40px] md:size-[60px] rounded-full border border-white/25 hover:bg-primary/50 text-white/75 hover:text-white backdrop-blur-3xl backdrop-brightness-[.99] duration-500">
              <i class="fa-brands fa-facebook"></i>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($social_instagram !== '' && filter_var($social_instagram, FILTER_VALIDATE_URL)): ?>
          <li>
            <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center size-[40px] md:size-[60px] rounded-full border border-white/25 hover:bg-primary/50 text-white/75 hover:text-white backdrop-blur-3xl backdrop-brightness-[.99] duration-500">
              <i class="fa-brands fa-instagram"></i>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($social_youtube !== '' && filter_var($social_youtube, FILTER_VALIDATE_URL)): ?>
          <li>
            <a href="<?php echo esc_url($social_youtube); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center size-[40px] md:size-[60px] rounded-full border border-white/25 hover:bg-primary/50 text-white/75 hover:text-white backdrop-blur-3xl backdrop-brightness-[.99] duration-500">
              <i class="fa-brands fa-youtube"></i>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo str_replace('+', '', str_replace(' ', '', $contact)) ?>" class="group/contact fixed z-[9] min-md:top-[20px] md:bottom-[20px] right-[30px] flex items-center gap-[15px] min-md:p-[10px_20px] min-md:pr-[10px] md:p-[10px] rounded-full overflow-hidden bg-primary/30 border border-white/25 text-white text-xl duration-500 hover:translate-y-[5px] before:absolute before:top-1/2 before:-translate-y-1/2 before:right-[15px] before:rounded-full before:bg-white before:w-[10px] hover:before:right-0 hover:before:w-full before:aspect-square hover:before:h-auto before:duration-200">
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
      <span class="md:hidden group-hover/contact:text-primary relative z-[1] duration-200 delay-200">Bize Ulaşın</span>
      <i class="relative z-[1] size-[30px] flex items-center justify-center bg-white rounded-full text-lg text-primary fa-solid fa-phone"></i>
    </a>
  </header>