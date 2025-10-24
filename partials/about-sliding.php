<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('about-sliding');

$heading = $fields['about-sliding-heading'];
$description = $fields['about-sliding-description'];
$services = $fields['about-sliding-services'];
$images = $fields['about-sliding-cards'];
?>
<section data-partial="about-sliding" class="relative w-screen h-screen bg-black">
  <div class="absolute z-[99] top-1/2 -translate-y-1/2 left-0 w-full h-auto md:h-full flex justify-center p-[100px_30px] md:p-[30px]">
    <div class="relative w-1/2 md:w-full h-full flex flex-col gap-[20px] p-[40px_20px] md:p-[30px] bg-secondary/20 rounded-[30px] border border-white/25 overflow-hidden">
      <div class="absolute z-[-1] top-0 left-0 w-full h-full glass-bg-strong">
        <svg width="0" height="0" class="absolute z-[-1]">
          <filter id="realistic-glass-lens-strong" x="0%" y="0%" width="100%" height="100%">
            <feImage preserveAspectRatio="none" result="radialMap" href="data:image/svg+xml;utf8,
                  <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'>
                    <radialGradient id='g' cx='50%' cy='50%' r='50%'>
                      <stop offset='0%' stop-color='rgb(128,128,128)'/>  <!-- center neutral -->
                      <stop offset='50%' stop-color='rgb(135,135,135)'/> <!-- almost neutral -->
                      <stop offset='75%' stop-color='rgb(200,200,200)'/> <!-- some push -->
                      <stop offset='100%' stop-color='rgb(255,255,255)'/> <!-- strongest -->
                    </radialGradient>
                    <rect x='0' y='0' width='100' height='100' fill='url(%23g)'/>
                  </svg>" />
            <feDisplacementMap in="SourceGraphic" in2="radialMap" scale="50" xChannelSelector="R" yChannelSelector="G" result="distorted" />
            <feGaussianBlur in="distorted" stdDeviation="0.7" result="softened" />
          </filter>
        </svg>
      </div>
      <div class="flex flex-col gap-[10px]">
        <h2 class="font-bold text-4xl"><?php echo $heading ?></h2>
        <hr class="h-[2px] rounded-full opacity-50">
        <p class="text-lg leading-[1.2rem] text-white/90"><?php echo $description ?></p>
      </div>
      <ul class="grid grid-cols-2 md:flex md:flex-col gap-[10px]">
        <?php foreach ($services as $service): ?>
          <li class="flex items-center gap-[10px] p-[20px] md:p-[10px] bg-primary/10 rounded-[20px] border border-white/25 backdrop-blur-xl">
            <span class="size-[50px] md:!min-w-[40px] md:min-h-[40px] flex items-center justify-center rounded-full border border-primary bg-white text-primary text-xl">
              <i class="<?php echo $service['icon'] ?>"></i>
            </span>
            <div class="flex flex-col md:max-w-[70%]">
              <h3 class="text-2xl md:text-xl"><?php echo $service['name'] ?></h3>
              <p class="text-white/75 md:text-md leading-none"><?php echo $service['detail'] ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php
  if (!empty($images) && is_array($images)):
    foreach ($images as $item): ?>
      <div data-gsap-sticky-panel class="absolute inset-0 w-full h-screen bg-cover bg-center will-change-transform" style="background-image: url('<?php echo esc_url($img_url); ?>');">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($item['bacground-image'])['src']) ?>" alt="">
      </div>
    <?php endforeach;
  endif; ?>
</section>