<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('hero-basic');
$title = $fields['hero_heading'];
$desc = $fields['hero_subHeading'];
$hero_media = $fields['hero_background'] ?? array();
?>

<section id="hero-basic" data-partial="hero-basic" class="relative w-screen h-screen md:h-[85vh] bg-red-500 text-white text-6xl flex items-center justify-center">
  <div class="absolute top-0 left-0 w-full h-full">
    <?php if ('video' === $hero_media['type']): ?>
      <video class="absolute top-0 left-0 w-full h-full object-cover object-center" autoplay muted playsinline loop src="<?php echo auriel_theme_resolve_video_attributes($hero_media['id'])['src'] ?>"></video>
    <?php endif; ?>
    <?php if ('image' === $hero_media['type']): ?>
      <img class="absolute top-0 left-0 w-full h-full object-cover object-bottom" src="<?php echo auriel_theme_resolve_image_attributes($hero_media['id'])['src'] ?>">
    <?php endif; ?>

    <span class="absolute z-[1] top-0 left-0 w-full h-full bg-gradient-to-tr md:bg-gradient-to-t from-black/25 from-35% to-transparent"></span>

    <div class="absolute z-[2] top-0 left-0 w-1/2 md:w-full h-full flex flex-col items-start md:items-center md:text-center justify-end md:justify-center p-[60px_150px] md:p-[30px]">
      <h1 class="md:leading-none"><?php echo $title ?></h1>
      <p class="md:leading-none">
        <?php echo $desc ?>
      </p>


    </div>
  </div>
</section>