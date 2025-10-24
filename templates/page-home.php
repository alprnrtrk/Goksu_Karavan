<?php
/**
 * Template Name: Home Page
 * Description: Landing layout with hero slider and palette preview.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main ">
  <?php get_template_part('partials/hero'); ?>
  <?php get_template_part('partials/about-us'); ?>
  <?php get_template_part('partials/gallery'); ?>
  <?php get_template_part('partials/about-sliding'); ?>
</main>
<?php
get_footer();




