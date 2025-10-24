<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('about-us');

$heading = $fields['about-us-heading'];
$description = $fields['about-us-description'];
$boxHeading = $fields['about-us-box-heading'];
$boxDescription = $fields['about-us-box-description'];
$stats = $fields['about-us-stats'];
$mission = $fields['about-us-mission'];
$vision = $fields['about-us-vision'];
$imageOne = $fields['about-us-image-one'];
$imageTwo = $fields['about-us-image-two'];

?>

<section data-partial="about-us" class="relative w-screen h-auto md:h-auto bg-surface py-[100px] md:py-[50px]">
  <div data-gsap-parallax-image="wrapper" class="flex flex-col gap-[100px] md:gap-[30px] px-[150px] md:px-[15px]">
    <div class="flex flex-col gap-[30px] items-center">
      <div class="min-md:max-w-[50%] flex flex-col items-center text-center gap-[20px] min-md:px-[30px]">
        <span class="relative w-max text-xl text-white/75 font-semibold before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[15px] before:-translate-x-full before:w-[50px] before:h-[2px] before:rounded-full before:bg-primary after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[15px] after:translate-x-full after:w-[50px] after:h-[2px] after:rounded-full after:bg-primary">Hakkımızda</span>
        <h2 class="text-3xl"><?php echo $heading ?></h2>
        <p>
          <?php echo $description ?>
        </p>
      </div>
    </div>
    <div class="grid grid-cols-5 md:flex md:flex-col gap-[30px]">
      <div class="w-full min-h-[400px] md:min-h-[200px] border border-white/25 rounded-[20px] overflow-hidden">
        <img data-gsap-parallax-image="image" data-gsap-parallax-image-power=".1" class="w-full h-full object-cover scale-[1.5] object-center" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($imageOne)['src']) ?>" alt="<?php echo esc_url(auriel_theme_resolve_image_attributes($imageOne)['alt']) ?>">
      </div>
      <div class="col-span-4 w-full h-full flex flex-col justify-between gap-[25px] p-[30px] rounded-[20px] bg-white/10 border border-white/25">
        <div class="flex flex-col gap-[15px]">
          <h2 class="text-4xl md:text-3xl"><?php echo $boxHeading ?></h2>
          <hr class="min-md:w-[150px] border-primary">
          <p class="text-xl text-white/75">
            <?php echo $boxDescription ?>
          </p>
        </div>
        <ul class="grid grid-cols-3 md:flex md:flex-col gap-[25px]">
          <?php foreach ($stats as $stat): ?>
            <li class="flex flex-col items-center h-max gap-[10px] p-[10px_20px] rounded-[20px] bg-white/10 border border-white/25">
              <span class="size-[60px] flex items-center justify-center border border-white/25 rounded-full bg-white/10 text-white text-xl text-white/75">
                <i class="<?php echo $stat['icon'] ?>"></i>
              </span>
              <span class="text-3xl text-primary" data-gsap-counter data-target="<?php echo $stat['amount'] ?>" data-duration="2" data-suffix="<?php echo $stat['prefix'] ?>"></span>
              <span class="text-2xl text-white/75">
                <?php echo $stat['label'] ?>
              </span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-span-2 w-full h-full flex flex-col items-center justify-center gap-[15px] p-[50px_20px] md:p-[20px] rounded-[20px] bg-white/10 border border-white/25">
        <h2 class="text-center text-4xl">Misyonumuz</h2>
        <hr class="w-[150px] border-primary">
        <p class="min-md:max-w-[70%] text-xl text-white/75 text-center">
          <?php echo $mission ?>
        </p>
      </div>
      <div class="col-span-2 w-full h-full flex flex-col items-center justify-center gap-[15px] p-[50px_20px] md:p-[20px] rounded-[20px] bg-white/10 border border-white/25">
        <h2 class="text-center text-4xl">Vizyonumuz</h2>
        <hr class="w-[150px] border-primary">
        <p class="min-md:max-w-[70%] text-xl text-white/75 text-center">
          <?php echo $vision ?>
        </p>
      </div>
      <div class="md:hidden w-full min-h-[400px] md:min-h-[200px] border border-white/25 rounded-[20px] overflow-hidden">
        <img data-gsap-parallax-image="image" data-gsap-parallax-image-power="-.1" class="w-full h-full object-cover scale-[1.5] object-center" src="<?php echo esc_url(auriel_theme_resolve_image_attributes($imageOne)['src']) ?>" alt="<?php echo esc_url(auriel_theme_resolve_image_attributes($imageOne)['alt']) ?>">
      </div>
    </div>
  </div>
</section>