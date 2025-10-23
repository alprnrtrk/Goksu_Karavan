<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('hero');
$heading = $fields['hero_heading'];
$subHeading = $fields['hero_subHeading'];
?>

<section data-gsap-parallax-image data-partial="hero" class="relative w-screen h-screen md:h-[75vh] bg-blue-500">
  <div data-gsap-parallax-image="wrapper" class="relative w-full h-full overflow-hidden">
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".8" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-0.jpg" alt="parallax effect clouds" class="absolute z-[0] top-0 left-0 w-full h-full object-cover object-bottom">
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".6" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-1.png" alt="parallax effect mountian far" class="absolute z-[1] top-0 left-0 w-full h-full object-cover object-bottom">
    <div data-gsap-parallax-image="image" data-gsap-parallax-image-power="1.2" class="absolute z-[2] top-0 left-0 text-7xl md:text-3xl font-bold w-full h-[50%] pt-[120px] md:pt-[150px] flex justify-center text-center text-white">
      <h2><?php echo $heading ?></h2>
    </div>
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".4" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-2-hd.png" alt="parallax effect mountian middle" class="absolute z-[3] top-0 left-0 w-full h-full object-cover object-bottom">
    <div data-gsap-parallax-image="image" data-gsap-parallax-image-power=".6" class="absolute z-[4] bottom-0 left-0 text-7xl md:text-3xl font-bold w-full h-[50%] min-md:pb-[100px] flex justify-center text-center text-white">
      <h2 class="relative h-max p-[10px_25px] border border-white/25 rounded-full overflow-hidden">
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
              <feGaussianBlur in="distorted" stdDeviation="0.2" result="softened" />
            </filter>
          </svg>
        </div>
        <span class="font-libre"><?php echo $subHeading ?></span>
      </h2>
    </div>
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".2" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-3-hd.png" alt="parallax effect mountian front" class="absolute z-[5] top-0 left-0 w-full h-full object-cover object-bottom">
  </div>
</section>