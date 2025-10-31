<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('generic-hero');
$title = $fields['generic_hero_title'];
$description = $fields['generic_hero_description'];
$images = $fields['generic_hero_images'];
?>

<section id="generic-hero" data-partial="generic-hero" class="relative w-screen h-[75vh]">
  <div data-swiper="wrapper" class="absolute top-0 left-0 swiper w-full h-full">
    <div class="absolute z-[10] inset-0">
      <span class="absolute inset-0 w-full h-full bg-gradient-to-tr from-black to-transparent"></span>
      <div class="absolute inset-0 flex flex-col items-start justify-end w-full h-full p-[30px_150px] text-white">
        <h2 class="text-4xl border-b border-white/50 pb-[10px] mb-[10px]"><?php echo $title ?></h2>
        <p class="max-w-[600px] text-[1.25rem] leading-[1.25rem] text-white/90">
          <?php echo $description ?>
        </p>
      </div>
    </div>
    <div class="swiper-wrapper">
      <?php foreach ($images as $image): ?>
        <div class="swiper-slide relative text-white overflow-hidden">
          <img class="absolute inset-0 w-full h-full object-center object-cover" data-swiper-parallax="20%" data-swiper-parallax-scale="1.1" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($image['image'])['src']) ?>" alt="">
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>