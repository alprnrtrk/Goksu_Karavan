<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('user-comments');

$heading = $fields['heading'];
$description = $fields['description'];
$comments = $fields['comments'];
$image = $fields['image'];

?>

<section data-partial="user-comments" class="relative w-screen h-auto bg-surface py-[100px] md:py-[50px]">
  <div data-gsap-parallax-image="wrapper" class="flex flex-col gap-[30px] items-center">
    <div class="min-md:max-w-[50%] flex flex-col items-center text-center gap-[20px] px-[30px]">
      <span class="relative w-max text-xl font-semibold before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[15px] before:-translate-x-full before:w-[50px] before:h-[2px] before:rounded-full before:bg-primary after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[15px] after:translate-x-full after:w-[50px] after:h-[2px] after:rounded-full after:bg-primary">Yorumlar</span>
      <h2 class="text-3xl"><?php echo $heading ?></h2>
      <p>
        <?php echo $description ?>
      </p>
    </div>
    <div class="relative w-full h-[70vh] md:h-[500px] overflow-hidden">
      <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".5" class="absolute scale-150 top-0 left-0 w-full h-full object-cover object-center" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($image)['src']) ?>" alt="">
      <div data-swiper="wrapper" class="swiper w-full h-full">
        <div class="absolute pointer-events-none z-[20] top-0 left-0 w-full h-full flex items-center justify-between px-[200px] md:px-[30px]">
          <span class="block absolute z-[-1] top-0 left-0 w-full h-full bg-gradient-to-r from-surface/80 via-transparent to-surface/80 md:hidden"></span>
          <span class="block absolute top-0 left-0 w-full h-[20px] md:h-[30px] rounded-b-[100%] bg-surface min-md:scale-y-[3] origin-top"></span>
          <span class="block absolute bottom-0 left-0 w-full h-[20px] md:h-[30px] rounded-t-[100%] bg-surface min-md:scale-y-[3] origin-bottom"></span>
        </div>
        <div class="swiper-wrapper min-md:!ease-linear will-change-transform">
          <?php foreach ($comments as $comment): ?>
            <div class="swiper-slide !flex !items-center will-change-transform group/slide">
              <div class="relative w-full h-[300px] md:h-[350px] border border-white/25 rounded-[20px] overflow-hidden">
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
                <div class="w-full h-full flex flex-col gap-[10px] p-[20px_30px] bg-black/40">
                  <div class="flex flex-col items-center gap-[10px]">
                    <img class="size-[70px] rounded-full" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($comment['user-image'])['src']) ?: 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png' ?>" alt="">
                    <h3 class="text-2xl"><?php echo $comment['user-name'] ?></h3>
                    <span data-star data-rating="<?php echo $comment['rate'] ?>" class="flex gap-[5px] p-[10px_15px] border-y border-primary text-white ">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                    </span>
                  </div>
                  <p class="text-center text-lg leading-[1.2rem]">
                    <?php echo $comment['comment'] ?>
                  </p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>