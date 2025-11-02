<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('gallery-own');

?>

<section id="gallery-own" data-partial="gallery-own" class="mt-[150px] relative w-screen min-h-screen bg-red-500">
  <div class="flex flex-col gap-[30px] py-[60px] md:py-[30px] px-[150px] md:px-[30px]">
    <div class="flex flex-col items-center max-w-[50%] mx-auto text-center">
      <span class="relative w-max before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[15px] before:-translate-x-full before:w-[50px] before:h-[2px] before:rounded-full before:bg-primary after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[15px] after:translate-x-full after:w-[50px] after:h-[2px] after:rounded-full after:bg-primary">Galeri</span>
      <h2 class="text-3xl">Başlık örnek</h2>
      <p class="leading-[1.2rem]">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Architecto nam magni culpa explicabo, eligendi temporibus repudiandae eaque cum dolorum mollitia velit dolores magnam ullam minus maiores assumenda recusandae laborum ducimus, dicta voluptates! Harum eaque neque asperiores itaque, labore pariatur consectetur iusto, sequi repellat ratione alias illum voluptas ullam nulla iste.
      </p>
    </div>
    <div class="w-full grid grid-cols-3 md:grid-cols-2 gap-[30px]">
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".1" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/200/300" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".2" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/200/500" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".3" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/500/200" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".1" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/200/300" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".2" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/200/500" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".3" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/500/200" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".1" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/200/300" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".2" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/200/500" alt="">
      </div>
      <div data-gsap-toggle="active" data-device="desktop" data-delay=".3" data-start="top 70%" data-end="bottom 30%" data-mode="in" data-markers="true" class="relative w-full aspect-square h-auto rounded-[20px] overflow-hidden duration-500 || [&.active]:translate-y-0 [&.active]:opacity-100 translate-y-[10%] opacity-0 ">
        <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="https://picsum.photos/500/200" alt="">
      </div>
    </div>
  </div>
</section>