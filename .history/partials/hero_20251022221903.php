<?php
declare(strict_types=1);
?>

<?php
$image_path = get_theme_file_path('/assets/src/image/parallax/Layer-0.png');
$image_url = get_theme_file_uri('/assets/src/image/parallax/Layer-0.png');
$show_image = file_exists($image_path);
?>

<section data-partial="hero" class="relative w-screen h-screen bg-blue-500">
  <?php if ($show_image): ?>
    <img class="absolute top-0 left-0 w-full h-full object-cover object-center" src="<?php echo esc_url($image_url); ?>" alt="">
  <?php endif; ?>
</section>