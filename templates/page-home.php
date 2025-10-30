<?php
/**
 * Template Name: Home Page
 * Description: Landing layout with hero slider and palette preview.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="min-h-[90vh]">
  <?php get_template_part('partials/hero'); ?>
  <?php get_template_part('partials/about-us'); ?>
  <?php get_template_part('partials/gallery'); ?>
  <?php get_template_part('partials/about-sliding'); ?>
  <?php get_template_part('partials/user-comments'); ?>
  <?php get_template_part('partials/caravan'); ?>
  <?php get_template_part('partials/contact-us'); ?>
</main>
<?php
get_footer();