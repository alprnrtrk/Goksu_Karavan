<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('gallery');

$heading = $fields['heading'];
$description = $fields['description'];
$images = $fields['images'];

?>
<section data-partial="gallery" class="relative w-screen h-screen md:h-auto bg-surface py-[100px] md:py-[50px]">
  <div class="flex flex-col gap-[30px] items-center">
    <div class="min-md:max-w-[50%] flex flex-col items-center text-center gap-[20px] px-[30px]">
      <span class="relative w-max text-xl font-semibold before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[15px] before:-translate-x-full before:w-[50px] before:h-[2px] before:rounded-full before:bg-primary after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[15px] after:translate-x-full after:w-[50px] after:h-[2px] after:rounded-full after:bg-primary">Galeri</span>
      <h2 class="text-3xl"><?php echo $heading ?></h2>
      <p>
        <?php echo $description ?>
      </p>
    </div>
    <div data-swiper="wrapper" class="swiper w-full h-auto">
      <div class="absolute pointer-events-none z-[20] top-0 left-0 w-full h-full flex items-center justify-between px-[200px] md:px-[30px]">
        <span class="block absolute z-[-1] top-0 left-0 w-full h-full bg-gradient-to-r from-surface via-transparent to-surface md:hidden"></span>
        <span class="block absolute top-0 left-0 w-full h-[20px] md:h-[30px] rounded-b-[100%] bg-surface min-md:scale-y-[3] origin-top"></span>
        <span class="block absolute bottom-0 left-0 w-full h-[20px] md:h-[30px] rounded-t-[100%] bg-surface min-md:scale-y-[3] origin-bottom"></span>
        <button data-swiper="prev" class="relative pointer-events-auto z-[10] size-[100px] md:size-[70px] flex items-center justify-center text-white text-3xl md:text-xl bg-primary/5 border border-white/25 rounded-full overflow-hidden min-md:hover:-translate-x-[10px] duration-500">
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
                <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="10" xChannelSelector="R" yChannelSelector="G" result="distorted" />
                <feGaussianBlur in="distorted" stdDeviation="0.7" result="softened" />
              </filter>
            </svg>
          </div>
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button data-swiper="next" class="relative pointer-events-auto z-[10] size-[100px] md:size-[70px] flex items-center justify-center text-white text-3xl md:text-xl bg-primary/5 border border-white/25 rounded-full overflow-hidden min-md:hover:translate-x-[20px] duration-500">
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
                <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="10" xChannelSelector="R" yChannelSelector="G" result="distorted" />
                <feGaussianBlur in="distorted" stdDeviation="0.7" result="softened" />
              </filter>
            </svg>
          </div>
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
      <div class="swiper-wrapper">
        <?php foreach ($images as $image): ?>
          <div class="swiper-slide group/slide">
            <a href="<?php echo esc_url(auriel_theme_resolve_image_attributes($image['images'])['src']) ?>" data-fancybox="gallery" class="md:hidden opacity-0 pointer-events-none group-[&.swiper-slide-active:hover]/slide:pointer-events-auto group-[&.swiper-slide-active:hover]/slide:opacity-100 absolute top-0 left-0 w-full h-full flex items-center justify-center text-5xl text-white bg-black/25 backdrop-blur-sm duration-500">
              <i class="fa-solid fa-magnifying-glass-plus"></i>
            </a>
            <img class="w-full min-h-[500px] object-cover object-center" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($image['images'])['src']) ?>" alt="">
          </div>
        <?php endforeach; ?>
        <?php foreach ($images as $image): ?>
          <div class="swiper-slide group/slide">
            <a href="<?php echo esc_url(auriel_theme_resolve_image_attributes($image['images'])['src']) ?>" data-fancybox="gallery" class="md:hidden opacity-0 pointer-events-none group-[&.swiper-slide-active:hover]/slide:pointer-events-auto group-[&.swiper-slide-active:hover]/slide:opacity-100 absolute top-0 left-0 w-full h-full flex items-center justify-center text-5xl text-white bg-black/25 backdrop-blur-sm duration-500">
              <i class="fa-solid fa-magnifying-glass-plus"></i>
            </a>
            <img class="w-full min-h-[500px] object-cover object-center" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($image['images'])['src']) ?>" alt="">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>