<?php
declare(strict_types=1);

$fields = auriel_partials_get_fields('contact-us');

$heading = $fields['heading'];
$description = $fields['description'];
$phone = $fields['phone'];
$phone2 = $fields['phone2'];
$mail = $fields['mail'];
$adress = $fields['adress'];
$map = $fields['map'];

?>

<section id="contact-us" data-partial="contact-us" class="relative w-screen h-auto py-[100px] md:py-[50px]">
  <div class="flex flex-col gap-[30px] items-center">
    <div class="min-md:max-w-[50%] flex flex-col items-center text-center gap-[20px] px-[30px]">
      <span class="relative w-max text-xl font-semibold before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[15px] before:-translate-x-full before:w-[50px] before:h-[2px] before:rounded-full before:bg-primary after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[15px] after:translate-x-full after:w-[50px] after:h-[2px] after:rounded-full after:bg-primary">İletişime Geçin</span>
      <h2 class="text-3xl"><?php echo $heading ?></h2>
      <p>
        <?php echo $description ?>
      </p>
    </div>
    <div class="grid grid-cols-2 md:flex md:flex-col w-full gap-[50px] p-[50px_250px] md:p-[30px] bg-secondary/5 border border-primary/25">
      <div class="flex flex-col gap-[30px]">
        <div class="flex flex-col gap-[5px]">
          <h2 class="flex items-center gap-[15px] w-max pb-[5px] text-2xl md:text-xl border-b border-primary/50"><i class="fa-solid fa-phone text-lg text-primary"></i> Telefon</h2>
          <a class="text-3xl md:text-2xl text-text/50 hover:text-text hover:translate-x-[5px] duration-500" href="tel:<?php echo $phone ?>"><?php echo $phone ?></a>
        </div>
        <div class="flex flex-col gap-[5px]">
          <h2 class="flex items-center gap-[15px] w-max pb-[5px] text-2xl md:text-xl border-b border-primary/50"><i class="fa-solid fa-envelope text-lg text-primary"></i> Mail</h2>
          <a class="text-3xl md:text-2xl text-text/50 hover:text-text hover:translate-x-[5px] duration-500" href="mail:<?php echo $mail ?>"><?php echo $mail ?></a>
        </div>
        <div class="flex flex-col gap-[5px]">
          <h2 class="flex items-center gap-[15px] w-max pb-[5px] text-2xl md:text-xl border-b border-primary/50"><i class="fa-solid fa-map text-lg text-primary"></i> Adres</h2>
          <a class="text-3xl md:text-2xl text-text/50 hover:text-text hover:translate-x-[5px] duration-500" href="#"><?php echo $adress ?></a>
        </div>
      </div>
      <div class="relative w-full aspect-square">
        <iframe id="osm-map" class="w-full h-full [mask-image:radial-gradient(ellipse_closest-side,black_0%,transparent_100%)] saturate-0" width="600" height="450" frameborder="0" scrolling="no" src="">
        </iframe>
        <script>
          const src = '<?php echo $map ?>' ?? '';

          const getCoords = (url) => {
            const lng = url.match(/!2d([-0-9.]+)/)?.[1];
            const lat = url.match(/!3d([-0-9.]+)/)?.[1];
            return lng && lat ? { lat: +lat, lng: +lng } : null;
          };

          const coords = getCoords(src);

          if (coords) {
            const delta = 0.005;
            const bbox = [
              coords.lng - delta,
              coords.lat - delta,
              coords.lng + delta,
              coords.lat + delta
            ].join(',');

            const osmSrc = `https://www.openstreetmap.org/export/embed.html?bbox=${bbox}&marker=${coords.lat},${coords.lng}`;

            document.getElementById('osm-map').setAttribute('src', osmSrc);
          }
        </script>
      </div>
    </div>
  </div>
</section>