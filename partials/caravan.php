<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('caravan');

$heading = $fields['heading'];
$description = $fields['description'];
$image = $fields['image'];
$left = $fields['left-area'];
$right = $fields['right-area'];

?>

<section data-partial="caravan" class="relative w-screen h-auto py-[100px] md:py-[50px]">
  <div class="flex flex-col items-center gap-[50px]">
    <div class="min-md:max-w-[50%] flex flex-col items-center text-center gap-[20px] px-[30px]">
      <span class="relative w-max text-xl font-semibold before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[15px] before:-translate-x-full before:w-[50px] before:h-[2px] before:rounded-full before:bg-primary after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[15px] after:translate-x-full after:w-[50px] after:h-[2px] after:rounded-full after:bg-primary">Karavan Detaylarımız</span>
      <h2 class="text-3xl"><?php echo $heading ?></h2>
      <p>
        <?php echo $description ?>
      </p>
    </div>
    <div class="w-full h-full flex md:flex-col items-center justify-center gap-[50px] md:gap-[10px] p-[30px]">
      <ul class="md:w-full relative flex flex-col list-disc list-inside p-[10px_15px] bg-secondary/25 border border-primary/25 rounded-[20px] before:absolute md:before:hidden before:right-0 before:translate-x-full before:top-1/2 before:-translate-y-1/2 before:w-full before:h-[2px] before:bg-primary/25">
        <?php foreach ($left as $each): ?>
          <li class="text-lg">
            <?php echo $each['type'] ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="relative z-[10] md:order-first">
        <img class="w-[500px] object-contain" src="https://www.titanvans.com/images/rb-camper-van-148-classic.png" alt="">
      </div>
      <ul class="md:w-full relative flex flex-col list-disc list-inside p-[10px_15px] bg-secondary/25 border border-primary/25 rounded-[20px] before:absolute md:before:hidden before:left-0 before:-translate-x-full before:top-1/2 before:-translate-y-1/2 before:w-full before:h-[2px] before:bg-primary/25">
        <?php foreach ($right as $each): ?>
          <li class="text-lg">
            <?php echo $each['type'] ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

</section>