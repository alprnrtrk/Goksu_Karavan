<?php
/**
 * Template Name: Home Page
 * Description: Landing layout with hero slider and palette preview.
 */
declare(strict_types=1);

get_header();
?>
<main id="main" class="site-main ">
  <?php get_template_part('partials/hero2'); ?>
  <?php get_template_part('partials/about-us2'); ?>
  <?php get_template_part('partials/gallery2'); ?>
  <?php get_template_part('partials/about-sliding2'); ?>
  <?php get_template_part('partials/user-comments'); ?>
</main>
<?php
get_footer();