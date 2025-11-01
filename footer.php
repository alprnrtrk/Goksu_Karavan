<?php
$footerDescription = auriel_theme_get_design_token('footer_description');
$footerPhone = auriel_theme_get_design_token('footer_phone');
$footerMail = auriel_theme_get_design_token('footer_mail');
$footerAdres = auriel_theme_get_design_token('footer_adress');
?>

<footer class="relative flex flex-col gap-[15px] w-full px-[150px] md:px-[30px] py-[50px]">
  <div class="flex md:flex-col justify-between md:items-center gap-[10px] p-[30px] min-md:pr-[100px] rounded-[20px] border border-text/25">
    <div class="flex items-start gap-[15px]">
      <div class="flex flex-col gap-[15px]">
        <h2 class="text-2xl text-primary font-semibold border-b border-black/25 pb-[5px]">Göksu Karavan</h2>
        <p class="max-w-[400px] my-auto text-lg leading-[1.2rem]">
          <?php echo $footerDescription ?>
        </p>
      </div>
    </div>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="md:order-first w-[200px] overflow-hidden duration-500">
      <img class="w-full h-full object-contain object-center brightness-0" src="<?php echo esc_url(auriel_theme_resolve_image_attributes(auriel_theme_get_design_token('brand_logo'))['src']) ?>" alt="<?php echo esc_url(auriel_theme_resolve_image_attributes(auriel_theme_get_design_token('brand_logo'))['alt']) ?>">
    </a>
    <div class="flex flex-col min-md:items-end min-md:text-right gap-[15px]">
      <h2 class="text-2xl text-primary font-semibold border-b border-black/25 pb-[5px]">İletişime Geç</h2>
      <ul class="max-w-[300px] flex flex-col min-md:items-end gap-[5px]">
        <?php if (isset($footerPhone)): ?>
          <li class="relative flex items-start gap-[10px] text-xl">
            <a class="hover:-translate-x-[5px] hover:text-primary duration-500" href="tel:<?php echo $footerPhone ?>">
              <?php echo $footerPhone ?>
            </a>
            <i class="md:order-first mt-[5px] text-[1rem] text-primary fa-solid fa-phone"></i>
          </li>
        <?php endif; ?>
        <?php if (isset($footerMail)): ?>
          <li class="relative flex items-start gap-[10px] text-xl">
            <a class="hover:-translate-x-[5px] hover:text-primary duration-500" href="mail:<?php echo $footerMail ?>">
              <?php echo $footerMail ?>
            </a>
            <i class="md:order-first mt-[5px] text-[1rem] text-primary fa-solid fa-envelope"></i>
          </li>
        <?php endif; ?>
        <?php if (isset($footerAdres)): ?>
          <li class="relative flex items-start gap-[10px] text-xl">
            <span href="tel:<?php echo $footerAdres ?>">
              <?php echo $footerAdres ?>
            </span>
            <i class="md:order-first mt-[5px] text-[1rem] text-primary fa-solid fa-map"></i>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="w-full h-[50px] md:h-auto md:text-center flex md:flex-col items-center justify-between px-[30px] md:p-[15px] border border-text/25 rounded-full">
    <span>
      &copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>.
    </span>
    <span class="leading-[1rem]">
      Hayalinizde ki karavan için doğru adrestesiniz.
    </span>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>