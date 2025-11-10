<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('hero-basic');
$title = $fields['hero_heading'];
$desc = $fields['hero_subHeading'];
$hero_media = $fields['hero_background'] ?? array();
?>

<section id="hero-basic" data-partial="hero-basic" class="relative w-screen h-screen md:h-[75vh] bg-red-500 text-white text-6xl flex items-center justify-center">
  <div class="absolute top-0 left-0 w-full h-full">
    <?php if ('video' === $hero_media['type']): ?>
      <video class="absolute top-0 left-0 w-full h-full object-cover object-center" autoplay muted playsinline loop src="<?php echo auriel_theme_resolve_video_attributes($hero_media['id'])['src'] ?>"></video>
    <?php endif; ?>
    <?php if ('image' === $hero_media['type']): ?>
      <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="<?php echo auriel_theme_resolve_image_attributes($hero_media['id'])['src'] ?>">
    <?php endif; ?>

    <span class="absolute z-[1] top-0 left-0 w-full h-full bg-gradient-to-tr md:bg-gradient-to-t from-black/75 from-35% to-transparent"></span>

    <div class="absolute z-[2] top-0 left-0 w-1/2 md:w-full h-full flex flex-col items-start md:items-center md:text-center justify-end p-[60px_150px] md:p-[30px]">
      <h1><?php echo $title ?></h1>
      <p>
        <?php echo $desc ?>
      </p>
      <a href="#about-us" class="relative flex text-lg p-[15px_30px] my-[50px] bg-white/10 rounded-full border border-white/25 overflow-hidden animate-bounce [animation-duration:5s]">
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
        Aşağı Kaydır
      </a>
    </div>
  </div>
</section>