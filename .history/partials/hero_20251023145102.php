<?php
declare(strict_types=1);
?>

<section data-gsap-parallax-image data-partial="hero" class="relative w-screen h-screen md:h-[75vh] bg-blue-500">
  <div data-gsap-parallax-image="wrapper" class="relative w-full h-full overflow-hidden">
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".8" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-0.jpg" alt="parallax effect clouds" class="absolute z-[0] top-0 left-0 w-full h-full object-cover object-bottom">
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".6" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-1.png" alt="parallax effect mountian far" class="absolute z-[1] top-0 left-0 w-full h-full object-cover object-bottom">
    <div data-gsap-parallax-image="image" data-gsap-parallax-image-power="1.2" class="absolute z-[2] top-0 left-0 text-7xl md:text-3xl font-bold w-full h-[50vh] min-md:pt-[50px] md:pb-[50px] flex justify-center md:items-end text-center text-white">
      <h2>Test Yazi 1</h2>
    </div>
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".4" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-2-hd.png" alt="parallax effect mountian middle" class="absolute z-[3] top-0 left-0 w-full h-full object-cover object-bottom">
    <div data-gsap-parallax-image="image" data-gsap-parallax-image-power=".6" class="absolute z-[4] bottom-0 left-0 text-7xl md:text-3xl font-bold w-full h-[50vh] min-md:pb-[50px] md:pt-[50px] flex justify-center text-center text-white">
      <h2>Test Yazi 1</h2>
    </div>
    <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".2" src="<?php echo get_template_directory_uri(); ?>/assets/src/image/parallax/Layer-3-hd.png" alt="parallax effect mountian front" class="absolute z-[5] top-0 left-0 w-full h-full object-cover object-bottom">
  </div>
</section>